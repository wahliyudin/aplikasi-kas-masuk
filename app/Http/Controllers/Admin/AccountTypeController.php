<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountTypeController extends Controller
{
    public function index()
    {
        return view('admin.account-type.index', [
            'breadcrumbs' => [
                'title' => 'Jenis Akun',
                'path' => [
                    'Master Data' => route('admin.account-types.index'),
                    'Jenis Akun' => 0
                ]
            ]
        ]);
    }
}
