<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\CashIn;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class CashInController extends Controller
{
    public function index()
    {
        return view('admin.cash-in.index', [
            'breadcrumbs' => [
                'title' => 'Kas Masuk',
                'path' => [
                    'Master Data' => route('admin.cash-ins.index'),
                    'Kas Masuk' => 0
                ]
            ],
            'accounts' => Account::latest()->get(),
            'users' => User::latest()->get()
        ]);
    }

    public function create()
    {
        return view('admin.cash-in.create', [
            'breadcrumbs' => [
                'title' => 'Tambah Kas Masuk',
                'path' => [
                    'Kas Masuk' => route('admin.cash-ins.index'),
                    'Tambah Kas Masuk' => 0
                ]
            ],
            'accounts' => Account::latest()->get(),
            'users' => User::latest()->get(),
            'no_cek' => generateNoCek()
        ]);
    }

    public function show($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
        }

        return view('admin.cash-in.show', [
            'breadcrumbs' => [
                'title' => 'Detail Kas Masuk',
                'path' => [
                    'Kas Masuk' => route('admin.cash-ins.index'),
                    'Detail Kas Masuk' => 0
                ]
            ],
            'cash_in' => CashIn::with('account', 'user', 'cashInDetails', 'cashInDetails.account')->find($id)
        ]);
    }

    public function buktiKasMasuk($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
        }
        $cash_in = CashIn::with('account', 'user', 'cashInDetails', 'cashInDetails.account')->find($id);

        $pdf = Pdf::loadView('admin.exports.bukti-kas-masuk', compact('cash_in'));
        return $pdf->setPaper('A4')->stream();
    }
}
