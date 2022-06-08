<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CashIn;
use App\Models\CashInDetail;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class CashInController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = CashIn::with('account', 'student')->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="d-flex align-item-center"> <a
                            href="' . route('admin.cash-ins.edit', Crypt::encrypt($row->id)) . '"
                            class="btn btn-success btn-sm mr-2">Ubah</a> <a href="javascript:void(0)"
        class="delete btn btn-danger btn-sm mr-2" id="' . Crypt::encrypt($row->id) . '">Hapus</a> <a
            href="' . route('admin.cash-ins.show', Crypt::encrypt($row->id)) . '" class="btn btn-secondary btn-sm">Detail</a></div>';
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
                'student_id' => $request->student_id,
                'no_cek' => $request->no_cek,
                'tanggal' => Carbon::make($request->tanggal)->format('Y-m-d'),
                'sebesar' => replaceRupiah($request->sebesar),
                'memo' => $request->memo
            ]);
            for ($i = 0; $i < count($request->nominals); $i++) {
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

    public function update(Request $request, $id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {

        }
        try {
            CashIn::find($id)->update([
                'account_id' => $request->account_id,
                'student_id' => $request->student_id,
                'no_cek' => $request->no_cek,
                'tanggal' => Carbon::make($request->tanggal)->format('Y-m-d'),
                'sebesar' => replaceRupiah($request->sebesar),
                'memo' => $request->memo
            ]);
            for ($i = 0; $i < count($request->nominals); $i++) {
                $account_id = Crypt::decrypt($request->account_ids[$i]);
                if (isset($request->cash_in_detail_ids[$i])) {
                    try {
                        $detail_id = Crypt::decrypt($request->cash_in_detail_ids[$i]);
                    } catch (DecryptException $e) {

                    }
                    CashInDetail::find($detail_id)->update([
                        'cash_in_id' => $id,
                        'account_id' => $account_id,
                        'nominal' => replaceRupiah($request->nominals[$i])
                    ]);
                } else {
                    CashInDetail::create([
                        'cash_in_id' => $id,
                        'account_id' => $account_id,
                        'nominal' => replaceRupiah($request->nominals[$i])
                    ]);
                }
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
                'student_id' => $cash_in->student_id,
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

    public function destroyDetail($id)
    {
        try {
            $id = Crypt::decrypt($id);
            $cash_in_detail = CashInDetail::find($id);

            if (!$cash_in_detail) {
                throw new Exception('Data detail Kas Masuk tidak ditemukan!', 400);
            }
            $sebesar = $cash_in_detail->cashIn->sebesar;
            $cash_in_detail->cashIn->update(['sebesar' => $sebesar - $cash_in_detail->nominal]);
            $cash_in_detail->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Menghapus data detail Kas Masuk',
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
