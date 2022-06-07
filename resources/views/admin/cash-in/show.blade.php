@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('admin.cash-ins.exports.bukti-kas-masuk', Crypt::encrypt($cash_in->id)) }}"
                            target="_blank" class="btn btn-primary float-right"><i class="fas fa-print mr-2"></i> Cetak</a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-6">
                                <label>Akun Kas</label>
                                <input type="text" class="form-control" value="{{ $cash_in->account->nama }}" readonly>
                            </div>
                            <div class="form-group col-6">
                                <label>No Cek</label>
                                <input type="text" class="form-control" value="{{ $cash_in->no_cek }}" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label>Dari</label>
                                <input type="text" class="form-control" value="{{ $cash_in->user->name }}" readonly>
                            </div>

                            <div class="form-group col-6">
                                <label>Tanggal</label>
                                <input type="text" class="form-control" value="{{ $cash_in->tanggal }}" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="sebesar">Sebesar</label>
                                <input type="text" class="form-control"
                                    value="{{ numberFormat($cash_in->sebesar, 'Rp.') }}" readonly>
                            </div>
                            <div class="form-group col-6">
                                <label for="memo">Memo</label>
                                <input type="text" class="form-control" value="{{ $cash_in->memo }}" readonly>
                            </div>
                        </div>

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama Akun</th>
                                    <th>Nominal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cash_in->cashInDetails as $cash_in_detail)
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control"
                                                    value="{{ $cash_in_detail->account->kode }}" readonly>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control"
                                                    value="{{ $cash_in_detail->account->nama }}" readonly>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control"
                                                    value="{{ numberFormat($cash_in_detail->nominal, 'Rp.') }}" readonly>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
