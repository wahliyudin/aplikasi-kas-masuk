<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CashIn;
use App\Models\CashInDetail;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class CashInController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = CashIn::with('account', 'user')->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="d-flex align-item-center"> <a href="javascript:void(0)"
                            class="edit btn btn-success btn-sm mr-2"
        data-id="' . Crypt::encrypt($row->id) . '">Ubah</a> <a href="javascript:void(0)"
        class="delete btn btn-danger btn-sm mr-2" id="' . Crypt::encrypt($row->id) . '">Hapus</a> <a
            href="'.route('admin.cash-ins.show', Crypt::encrypt($row->id)).'" class="btn btn-secondary btn-sm">Detail</a></div>';
                    return $actionBtn;
                })
                ->addColumn('sebesar', function ($row) {
                    return numberFormat($row->sebesar, 'Rp.');
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        try {
            $cashin = CashIn::create([
                'account_id' => $request->account_id,
                'user_id' => $request->user_id,
                'no_cek' => $request->no_cek,
                'tanggal' => Carbon::make($request->tanggal)->format('Y-m-d'),
                'sebesar' => replaceRupiah($request->sebesar),
                'memo' => $request->memo
            ]);
            for ($i=0; $i < count($request->nominals); $i++) {
                $account_id = Crypt::decrypt($request->account_ids[$i]);
                CashInDetail::create([
                    'cash_in_id' => $cashin->id,
                    'account_id' => $account_id,
                    'nominal' => replaceRupiah($request->nominals[$i])
                ]);
            }
            return response()->json([
                'status' => 'success',
                'message' => isset($request->id) ? 'Ubah Data Kas Masuk' : 'Menambahkan data Kas Masuk',
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
            $cash_in = CashIn::find($id);
            if (!$cash_in) {
                throw new Exception('Data Kas Masuk tidak ditemukan!', 400);
            }
            $data = [
                'id' => $cash_in->id,
                'account_id' => $cash_in->account_id,
                'user_id' => $cash_in->user_id,
                'no_cek' => $cash_in->no_cek,
                'tanggal' => $cash_in->tanggal,
                'sebesar' => $cash_in->sebesar,
                'memo' => $cash_in->memo
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
            $cash_in = CashIn::find($id);

            if (!$cash_in) {
                throw new Exception('Data Kas Masuk tidak ditemukan!', 400);
            }

            $cash_in->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Menghapus data Kas Masuk',
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
