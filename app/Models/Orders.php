<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $guarded = [];

    public function getInvAttribute()
    {
        return $this->id;
    }

    public function expenses()
    {
        return $this->hasMany(OrderExpenses::class, 'order_id', 'id');
    }

    public function extraExpenses()
    {
        return $this->hasMany(OrderExtraExpense::class, 'order_id', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo(accounts::class, 'supplier_id');
    }

    public function customer()
    {
        return $this->belongsTo(accounts::class, 'customer_id');
    }

    public function product()
    {
        return $this->belongsTo(products::class, 'product_id');
    }

    public function driver()
    {
        return $this->belongsTo(drivers::class, 'driver_id');
    }

    public function purchaseAccount()
    {
        return $this->belongsTo(accounts::class, 'purchase_account_id');
    }

    public function saleAccount()
    {
        return $this->belongsTo(accounts::class, 'sale_account_id');
    }
}

class OrderExpenses extends Model
{
    protected $guarded = [];

    public function post()
    {
        return $this->belongsTo(accounts::class, 'post_id');
    }
}
