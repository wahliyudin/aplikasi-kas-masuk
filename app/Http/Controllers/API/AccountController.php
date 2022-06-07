<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Account::with('accountType')->oldest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm"
        data-id="' . Crypt::encrypt($row->id) . '">Ubah</a> <a href="javascript:void(0)"
        class="delete btn btn-danger btn-sm" id="' . Crypt::encrypt($row->id) . '">Hapus</a>';
                    return $actionBtn;
                })
                ->addColumn('saldo_awal', function($row){
                    return numberFormat($row->saldo_awal, 'Rp.');
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function updateOrCreate(Request $request)
    {
        try {
            if (isset($request->saldo_awal)) {
                $request->merge(['saldo_awal' => replaceRupiah($request->saldo_awal)]);
            }
            Account::updateOrCreate(
                [
                    'id' => $request->id
                ],
                [
                    'nama' => $request->nama,
                    'kode' => $request->kode,
                    'saldo_awal' => $request->saldo_awal,
                    'account_type_id' => $request->account_type_id
                ]
            );
            return response()->json([
                'status' => 'success',
                'message' => isset($request->id) ? 'Ubah Data akun' : 'Menambahkan data akun',
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
            $account = Account::find($id);
            if (!$account) {
                throw new Exception('Data akun tidak ditemukan!', 400);
            }
            $data = [
                'id' => $account->id,
                'nama' => $account->nama,
                'kode' => $account->kode,
                'saldo_awal' => $account->saldo_awal,
                'account_type_id' => $account->account_type_id
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
            $account = Account::find($id);

            if (!$account) {
                throw new Exception('Data Akun tidak ditemukan!', 400);
            }

            $account->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Menghapus data Akun',
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
