<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountType;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        return view('admin.account.index', [
            'breadcrumbs' => [
                'title' => 'Data Akun',
                'path' => [
                    'Master Data' => route('admin.accounts.index'),
                    'Data Akun' => 0
                ]
            ],
            'account_types' => AccountType::latest()->get()
        ]);
    }
}
