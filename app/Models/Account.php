<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'kode',
        'saldo_awal',
        'account_type_id'
    ];

    public function accountType()
    {
        return $this->belongsTo(AccountType::class);
    }
}
