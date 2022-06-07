<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashInDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'cash_in_id',
        'account_id',
        'nominal'
    ];

    public function cashIn()
    {
        return $this->belongsTo(CashIn::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
