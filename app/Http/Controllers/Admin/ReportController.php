<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CashIn;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.laporan.index', [
            'breadcrumbs' => [
                'title' => 'Laporan',
                'path' => [
                    'Laporan' => 0
                ]
            ]
        ]);
    }

    public function kasMasukExport(Request $request)
    {
        $first_date = Carbon::make($request->first_date)->format('Y-m-d');
        $last_date = Carbon::make($request->last_date)->format('Y-m-d');
        $cash_ins = CashIn::with('account', 'cashInDetails', 'cashInDetails.account')->whereBetween('tanggal',
        [$first_date, $last_date])->get();
        $pdf = Pdf::loadView('admin.exports.laporan-kas-masuk', compact('cash_ins', 'first_date', 'last_date'));
        return $pdf->setPaper('A4')->stream();
    }
}
