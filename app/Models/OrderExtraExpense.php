<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderExtraExpense extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(expenseCategories::class, 'expense_category_id');
    }
}
