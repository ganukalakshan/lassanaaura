<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Invoice;
use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['invoice.customer', 'bank']);
        
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }
        
        if ($request->filled('date_from')) {
            $query->where('payment_date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->where('payment_date', '<=', $request->date_to);
        }
        
        $payments = $query->orderBy('payment_date', 'desc')->paginate(20);
        
        return view('payments.index', compact('payments'));
    }

    public function create(Request $request)
    {
        $invoice = null;
        if ($request->filled('invoice_id')) {
            $invoice = Invoice::with('customer')->findOrFail($request->invoice_id);
        }
        
        $invoices = Invoice::whereIn('status', ['sent', 'partially_paid'])
            ->with('customer')
            ->get();
        $banks = Bank::where('is_active', true)->get();
        
        return view('payments.create', compact('invoice', 'invoices', 'banks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:cash,bank_transfer,check,credit_card,debit_card,online',
            'bank_id' => 'required_if:payment_method,bank_transfer,check|nullable|exists:banks,id',
            'reference_number' => 'nullable|string|max:64',
            'notes' => 'nullable|string',
        ]);
        
        DB::transaction(function() use ($validated) {
            $invoice = Invoice::findOrFail($validated['invoice_id']);
            
            // Check if payment exceeds remaining balance
            $remainingBalance = $invoice->total - $invoice->paid_amount;
            if ($validated['amount'] > $remainingBalance) {
                throw new \Exception('Payment amount exceeds remaining balance.');
            }
            
            $payment = Payment::create([
                'invoice_id' => $validated['invoice_id'],
                'payment_date' => $validated['payment_date'],
                'amount' => $validated['amount'],
                'payment_method' => $validated['payment_method'],
                'bank_id' => $validated['bank_id'] ?? null,
                'reference_number' => $validated['reference_number'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'created_by' => auth()->id(),
            ]);
            
            // Update invoice paid amount and status
            $invoice->paid_amount += $validated['amount'];
            
            if ($invoice->paid_amount >= $invoice->total) {
                $invoice->status = 'paid';
            } else {
                $invoice->status = 'partially_paid';
            }
            
            $invoice->save();
            
            return $payment;
        });
        
        return redirect()->route('payments.index')
            ->with('success', 'Payment recorded successfully!');
    }

    public function show(Payment $payment)
    {
        $payment->load(['invoice.customer', 'bank', 'creator']);
        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $invoices = Invoice::whereIn('status', ['sent', 'partially_paid', 'paid'])
            ->with('customer')
            ->get();
        $banks = Bank::where('is_active', true)->get();
        
        return view('payments.edit', compact('payment', 'invoices', 'banks'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:cash,bank_transfer,check,credit_card,debit_card,online',
            'bank_id' => 'required_if:payment_method,bank_transfer,check|nullable|exists:banks,id',
            'reference_number' => 'nullable|string|max:64',
            'notes' => 'nullable|string',
        ]);
        
        $payment->update($validated);
        
        return redirect()->route('payments.show', $payment)
            ->with('success', 'Payment updated successfully!');
    }

    public function destroy(Payment $payment)
    {
        DB::transaction(function() use ($payment) {
            $invoice = $payment->invoice;
            
            // Reverse payment from invoice
            $invoice->paid_amount -= $payment->amount;
            
            if ($invoice->paid_amount <= 0) {
                $invoice->status = 'sent';
            } else if ($invoice->paid_amount < $invoice->total) {
                $invoice->status = 'partially_paid';
            }
            
            $invoice->save();
            $payment->delete();
        });
        
        return redirect()->route('payments.index')
            ->with('success', 'Payment deleted successfully!');
    }
}
