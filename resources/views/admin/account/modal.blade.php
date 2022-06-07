<div class="modal fade" id="Account-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addEditAccountForm" action="javascript:void(0)" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama">
                            <span class="text-danger" id="namaError"></span>
                        </div>
                        <div class="form-group col-6">
                            <label for="kode">Kode</label>
                            <input type="text" class="form-control" name="kode" id="kode" placeholder="kode">
                            <span class="text-danger" id="kodeError"></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-6">
                            <label for="saldo_awal">Saldo Awal</label>
                            <input type="text" class="form-control" name="saldo_awal" id="saldo_awal"
                                placeholder="saldo_awal">
                            <span class="text-danger" id="saldo_awalError"></span>
                        </div>
                        <div class="form-group col-6">
                            <label>Jenis Akun</label>
                            <select name="account_type_id" id="account_type_id" class="form-control select2"
                                style="width: 100%;">
                                <option selected="selected" disabled>-- pilih --</option>
                                @foreach ($account_types as $account_type)
                                    <option value="{{ $account_type->id }}">{{ $account_type->nama }}</option>
                                @endforeach
                            </select>
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
