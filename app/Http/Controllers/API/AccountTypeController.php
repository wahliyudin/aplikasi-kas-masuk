<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AccountType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class AccountTypeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = AccountType::oldest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm"
        data-id="' . Crypt::encrypt($row->id) . '">Ubah</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm"
        id="' . Crypt::encrypt($row->id) . '">Hapus</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function updateOrCreate(Request $request)
    {
        try {
            AccountType::updateOrCreate(
                [
                    'id' => $request->id
                ],
                [
                    'nama' => $request->nama
                ]
            );
            return response()->json([
                'status' => 'success',
                'message' => isset($request->id) ? 'Ubah Data jenis akun' : 'Menambahkan data jenis akun',
            ]);
        } catch (\Exception $th) {
            $th->getCode() == 400 ? $code = 400 : $code = 500;
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], $code);
        }
    }

    public function edit($id)
    {
        try {
            $id = Crypt::decrypt($id);
            $account_type = AccountType::find($id);
            if (!$account_type) {
                throw new Exception('Data jenis akun tidak ditemukan!', 400);
            }
            $data = [
                'id' => $account_type->id,
                'nama' => $account_type->nama
            ];
            return response()->json([
                'status' => 'success',
                'data' => $data,
            ]);
        } catch (\Exception $th) {
            $th->getCode() == 400 ? $code = 400 : $code = 500;
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], $code);
        }
    }

    public function destroy($id)
    {
        try {
            $id = Crypt::decrypt($id);
            $account_type = AccountType::find($id);

            if (!$account_type) {
                throw new Exception('Data Jenis Akun tidak ditemukan!', 400);
            }

            $account_type->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Menghapus data Jenis Akun',
            ]);
        } catch (\Exception $th) {
            $th->getCode() == 400 ? $code = 400 : $code = 500;
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], $code);
        }
    }
}
