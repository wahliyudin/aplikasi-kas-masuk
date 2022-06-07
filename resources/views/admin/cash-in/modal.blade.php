<div class="modal fade" id="CashIn-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addEditCashInForm" action="javascript:void(0)" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="row">
                        <div class="form-group col-6">
                            <label>Akun Kas</label>
                            <select name="account_id" id="account_id" class="form-control select2" style="width: 100%;">
                                <option selected="selected" disabled>-- pilih --</option>
                                @foreach ($accounts as $account)
                                    <option value="{{ $account->id }}">{{ $account->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-6">
                            <label for="no_cek">No Cek</label>
                            <input type="text" class="form-control" name="no_cek" id="no_cek" placeholder="No Cek">
                            <span class="text-danger" id="no_cekError"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label>Dari</label>
                            <select name="user_id" id="user_id" class="form-control select2" style="width: 100%;">
                                <option selected="selected" disabled>-- pilih --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-6">
                            <label>Tanggal</label>
                            <div class="input-group date" id="tanggal" data-target-input="nearest">
                                <input type="text" required name="tanggal" class="form-control datetimepicker-input"
                                    data-target="#tanggal" value="">
                                <div class="input-group-append" data-target="#tanggal" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="sebesar">Sebesar</label>
                            <input type="text" class="form-control" name="sebesar" id="sebesar" placeholder="sebesar">
                            <span class="text-danger" id="sebesarError"></span>
                        </div>
                        <div class="form-group col-6">
                            <label for="memo">Memo</label>
                            <input type="text" class="form-control" name="memo" id="memo" placeholder="memo">
                            <span class="text-danger" id="memoError"></span>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary" id="btn-save">Simpan</button>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
