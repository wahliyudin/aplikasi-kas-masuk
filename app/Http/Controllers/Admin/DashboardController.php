<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CashIn;
use App\Models\Student;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'breadcrumbs' => [
                'title' => 'Dashboard',
                'path' => [
                    'Dashboard' => 0
                ]
            ],
            'total_kas_masuk' => CashIn::sum('sebesar'),
            'total_siswa' => Student::count()
        ]);
    }
}
