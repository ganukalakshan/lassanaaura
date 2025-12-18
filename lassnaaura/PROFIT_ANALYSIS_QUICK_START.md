# Quick Start Guide - Profit & Loss Analysis

## 🎯 What's New?

### New Database Columns:
- `sales_order_items.cost_price` - Tracks product cost at time of sale
- `sales_order_items.subtotal` - Line item total
- `sales_orders.payment_method` - Cash or Bank Transfer

### New Page: Profit & Loss Analysis
**URL:** `/aura/profit-analysis`
**Sidebar Menu:** "Profit & Loss" (with chart icon 📊)

---

## 📊 Features at a Glance

### Summary Dashboard (4 Cards):
```
┌─────────────────────────────────────────────────────────────┐
│  💰 Total Profit   │  💵 Total Revenue  │  🏷️ Total Cost   │
│   Rs XX,XXX.XX    │   Rs XX,XXX.XX    │  Rs XX,XXX.XX   │
│                   │                   │                 │
│  📈 Profit Margin %                                        │
│     XX.X%                                                  │
└─────────────────────────────────────────────────────────────┘
```

### Transaction Details Table:
```
Order      | Customer        | Product      | Cost vs Selling      | Profit/Loss   | Margin | Date
-----------|----------------|--------------|---------------------|---------------|--------|----------
ORD-XXX    | John Doe       | Product A    | Cost: Rs 100.00     | ↑ Rs 50.00    | 50%    | 19 Dec 25
           | john@email.com |              | Selling: Rs 150.00  | (Profit)      |        |
```

---

## 🔍 How Profit is Calculated

### For Each Transaction:
```
Profit = Selling Price - Cost Price
Margin % = (Profit / Cost Price) × 100
```

### Example:
- **Product Cost:** Rs 1,000
- **Selling Price (to customer):** Rs 1,500
- **Profit:** Rs 500
- **Margin:** 50%

---

## 🎨 Color Coding

### Profit Indicators:
- 🟢 **Green Badge with ↑**: Profitable transaction
- 🔴 **Red Badge with ↓**: Loss-making transaction

### Margin Performance:
- 🟢 **≥30%**: Excellent margin
- 🟠 **10-29%**: Fair margin  
- 🔴 **<10%**: Poor margin

---

## 🔧 How to Use

### 1. Create Orders with Custom Pricing:
   1. Go to "Create Order" page
   2. Select customer
   3. Add products
   4. **Adjust selling price** in the modal
   5. System automatically tracks cost price
   6. Complete order

### 2. View Profit Analysis:
   1. Click "Profit & Loss" in sidebar
   2. See summary cards at top
   3. View detailed transactions below
   4. Use filter buttons:
      - **All**: View all transactions
      - **Profitable**: Only profitable items
      - **Loss**: Only loss-making items

---

## 📈 Business Insights

### What You Can Learn:
- **Which products are most profitable?**
- **Which customers get the best deals?**
- **What's your average profit margin?**
- **Are you losing money on any products?**
- **What's your total profit for the period?**

### Decision Making:
- ✅ **High margin products**: Promote more
- ⚠️ **Low margin products**: Review pricing
- ❌ **Loss-making items**: Investigate why
- 💡 **Pricing strategy**: Optimize based on data

---

## 🗂️ Data Source

### Only Confirmed Orders:
- ✅ Confirmed/Complete orders = Included
- ❌ Pending orders = Excluded
- ❌ Cancelled orders = Excluded

### Historical Accuracy:
- Cost price **captured at time of order**
- Even if product cost changes later, profit remains accurate
- No retroactive recalculations

---

## 🎯 Key Metrics Explained

### Total Profit:
Sum of all (Selling Price - Cost Price) from confirmed orders

### Total Revenue:
Sum of all selling prices (what customers paid)

### Total Cost:
Sum of all cost prices (what products cost you)

### Profit Margin %:
(Total Profit ÷ Total Revenue) × 100
Shows overall efficiency of pricing

---

## 💡 Pro Tips

1. **Monitor Daily**: Check profit trends regularly
2. **Filter Strategically**: Use filters to spot issues
3. **Review Loss Items**: Immediately investigate red items
4. **Maintain Good Margins**: Aim for 20%+ margin
5. **Track by Customer**: See which customers are profitable
6. **Compare Products**: Identify your best sellers

---

## ✅ System Requirements Met

- ✅ Database stores cost price for each transaction
- ✅ Profit calculated: Selling - Cost
- ✅ Clear, detailed transaction view
- ✅ Summary statistics at top
- ✅ Beautiful, professional design
- ✅ Easy filtering and analysis
- ✅ Integrated in sidebar navigation
- ✅ Rs currency throughout

---

## 🚀 Ready to Use!

Your Aura ERP system now has complete profit tracking. Every order you create will be analyzed, and you can see exactly how profitable your business is!

**Start using it now:**
1. Create some orders with products
2. Click "Profit & Loss" in sidebar
3. Analyze your profitability!

---

## 📞 Need Help?

The system is fully automatic. Once orders are created with products:
- Cost prices are captured automatically
- Profits are calculated automatically
- Reports update in real-time
- No manual data entry needed!

Enjoy your new profit analysis tool! 🎉
