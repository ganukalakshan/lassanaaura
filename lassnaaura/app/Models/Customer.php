<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_code',
        'name',
        'company_name',
        'email',
        'phone',
        'mobile',
        'tax_id',
        'credit_limit',
        'outstanding_balance',
        'payment_terms_days',
        'assigned_user_id',
        'lead_source',
        'tags',
        'notes',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'credit_limit' => 'decimal:2',
        'outstanding_balance' => 'decimal:2',
        'tags' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get the invoices for the customer.
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Get the sales orders for the customer.
     */
    public function salesOrders()
    {
        return $this->hasMany(SalesOrder::class);
    }

    /**
     * Get the contacts for the customer.
     */
    public function customerContacts()
    {
        return $this->hasMany(CustomerContact::class);
    }

    /**
     * Get the loyalty points for the customer.
     */
    public function loyaltyPoints()
    {
        return $this->hasMany(LoyaltyPoint::class);
    }
}
