@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-6">
                                <label>Akun Kas</label>
                                <select name="account_id_single" id="account_id_single" class="form-control select2"
                                    style="width: 100%;">
                                    <option selected="selected" disabled>-- pilih --</option>
                                    @foreach ($accounts as $account)
                                        <option value="{{ $account->id }}">{{ $account->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-6">
                                <label for="no_cek">No Cek</label>
                                <input type="text" class="form-control" readonly value="{{ $no_cek }}" name="no_cek" id="no_cek"
                                    placeholder="No Cek">
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
                                <input type="text" class="form-control" readonly name="sebesar" id="sebesar"
                                    placeholder="sebesar">
                                <span class="text-danger" id="sebesarError"></span>
                            </div>
                            <div class="form-group col-6">
                                <label for="memo">Memo</label>
                                <input type="text" class="form-control" name="memo" id="memo" placeholder="memo">
                                <span class="text-danger" id="memoError"></span>
                            </div>
                        </div>

                        <button class="btn btn-secondary add-input float-right mb-2">tambah</button>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama Akun</th>
                                    <th>Nominal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="list">

                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button class="btn btn-primary btn-save float-right">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('layouts.inc.toastr')
@push('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <style>
        .select2-container .select2-selection--single {
            height: 38px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 100% !important;
        }
    </style>
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@endpush
@push('script')
<!-- bs-custom-file-input -->
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script>
        $('.add-input').click(function(e) {
            e.preventDefault();
            $('#list').append(`<tr id="${$('#list').children().length}">
                                    <td>
                                        <div class="form-group">
                                            <input type="text" readonly class="form-control" id="kode" placeholder="kode">
                                            <span class="text-danger" id="kodeError"></span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <select name="account_id[]" id="account_id" class="form-control select2"
                                                style="width: 100%;">
                                                <option selected="selected" disabled>-- pilih --</option>
                                                @foreach ($accounts as $account)
                                                    <option value="{{ Crypt::encrypt($account->id) }}">{{ $account->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="nominal[]" id="nominal"
                                                placeholder="nominal">
                                            <span class="text-danger" id="nominalError"></span>
                                        </div>
                                    </td>
                                    <td>
                                        <button class="btn btn-danger remove">hapus</button>
                                    </td>
                                </tr>`);
        });

        var ajaxError = function(jqXHR, xhr, textStatus, errorThrow, exception) {
            if (jqXHR.status === 0) {
                toastr.error('Not connect.\n Verify Network.', 'Error!');
            } else if (jqXHR.status == 400) {
                toastr.warning(jqXHR['responseJSON'].message, 'Peringatan!');
            } else if (jqXHR.status == 404) {
                toastr.error('Requested page not found. [404]', 'Error!');
            } else if (jqXHR.status == 500) {
                toastr.error('Internal Server Error [500].' + jqXHR['responseJSON'].message, 'Error!');
            } else if (exception === 'parsererror') {
                toastr.error('Requested JSON parse failed.', 'Error!');
            } else if (exception === 'timeout') {
                toastr.error('Time out error.', 'Error!');
            } else if (exception === 'abort') {
                toastr.error('Ajax request aborted.', 'Error!');
            } else {
                toastr.error('Uncaught Error.\n' + jqXHR.responseText, 'Error!');
            }
        };

        $('body').on('change', '#account_id', function(event) {
            var id = $(event.target).parent().parent().parent().attr('id');
            var kode = $(event.target).parent().parent().parent().find('#kode');
                // ajax
            $.ajax({
                type: "GET",
                url: "{{ url('/') }}/api/accounts/" + event.target.value + "/by-id",
                dataType: 'json',
                success: function(res) {
                    kode.val(res.data.kode);
                },
                error: ajaxError,
            });
            console.log($(event.target).parent().parent().parent().attr('id'));
        });
        $('body').on('click', '.remove', function(event) {
            $('#sebesar').val(formatRupiah(String(replaceFormatRupiah($('#sebesar').val()) - parseInt(replaceFormatRupiah($($(event.target).parent().parent().find('#nominal')).val()))), 'Rp.'));
            $(event.target).parent().parent().remove();
        });

        $('body').on('keyup', '#nominal', function(event) {
            $(this).val(formatRupiah(String(event.target.value), 'Rp.'));

            var sum = 0;
            $.each($('#nominal*'), function (indexInArray, valueOfElement) {
                sum += parseInt(replaceFormatRupiah(String(valueOfElement.value)))
            });
            $('#sebesar').val(formatRupiah(String(sum), 'Rp.'));
        });

        $('#sebesar').change(function (e) {
            e.preventDefault();
            formatRupiah();
        });

        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka satuan ribuan
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }
        function escapeRegExp(string) {
            return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'); // $& means the whole matched string
        }

        function replaceFormatRupiah(str) {
            return str.replace(new RegExp(escapeRegExp('.'), 'g'), '').replace('Rp ', '');
        }

        $(function() {
            bsCustomFileInput.init();
            //Initialize Select2 Elements
            $('.select2').select2()
        });

        $('#tanggal').datetimepicker({
            format: 'L'
        });
        $('[data-mask]').inputmask()


        $('body').on('click', '.btn-save', function(event) {
            var account_id_single = $("#account_id_single").val();
            var no_cek = $("#no_cek").val();
            var user_id = $("#user_id").val();
            var tanggal = $('input[name="tanggal"]').val();
            var sebesar = $("#sebesar").val();
            var memo = $("#memo").val();
            var nominals = $("input[name='nominal[]']").map(function(){
                return $(this).val();
            }).get();
            var account_ids = $("select[name='account_id[]']").map(function(){
                return $(this).val();
            }).get();
            console.log(account_ids);
            $("#btn-save").html('Please Wait...');
            $("#btn-save").attr("disabled", true);

            // ajax
            $.ajax({
                type: "POST",
                url: "{{ route('api.cash-ins.store') }}",
                data: {
                    account_id: account_id_single,
                    user_id: user_id,
                    no_cek: no_cek,
                    tanggal: tanggal,
                    sebesar: sebesar,
                    memo: memo,
                    nominals: nominals,
                    account_ids: account_ids
                },
                dataType: 'json',
                success: function(res) {
                    $("#btn-save").html('Submit');
                    $("#btn-save").attr("disabled", false);
                    toastr.success(res.message, 'Berhasil!');
                    window.location.reload()
                },
                error: ajaxError,
            });
        });
    </script>
@endpush
