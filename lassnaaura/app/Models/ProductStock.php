<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    protected $table = 'product_stock';

    protected $fillable = [
        'product_id',
        'warehouse_id',
        'quantity_on_hand',
        'reserved_quantity',
        'batch_number',
        'expiry_date',
    ];

    protected $casts = [
        'quantity_on_hand' => 'integer',
        'reserved_quantity' => 'integer',
        'expiry_date' => 'date',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
