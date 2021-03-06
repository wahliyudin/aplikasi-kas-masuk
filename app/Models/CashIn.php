<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashIn extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'student_id',
        'no_cek',
        'tanggal',
        'sebesar',
        'memo'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function cashInDetails()
    {
        return $this->hasMany(CashInDetail::class);
    }
}
