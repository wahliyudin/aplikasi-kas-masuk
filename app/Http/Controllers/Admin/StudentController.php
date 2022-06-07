<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        return view('admin.student.index', [
            'breadcrumbs' => [
                'title' => 'Data Siswa',
                'path' => [
                    'Master Data' => route('admin.students.index'),
                    'Data Siswa' => 0
                ]
            ]
        ]);
    }
}
