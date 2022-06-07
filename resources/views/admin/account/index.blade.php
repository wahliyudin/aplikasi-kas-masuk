@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Akun</h3>
                        <button class="btn btn-sm btn-primary float-right" id="addNewAccount"><i class="fas fa-plus mr-2"></i>
                            Tambah
                            Data</button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="account" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Kode</th>
                                    <th>Jenis Akun</th>
                                    <th>Saldo Awal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
    @include('admin.account.modal')
@endsection
@include('layouts.inc.datatables')
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
@endpush
@push('script')
    <!-- bs-custom-file-input -->
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script type="text/javascript">
        var table;
        setTimeout(function() {
            tableaccount();
        }, 500);
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

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // function to retrieve DataTable server side
        function tableaccount() {
            $('#account').dataTable().fnDestroy();
            table = $('#account').DataTable({
                responsive: true,
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('api.accounts.index') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}"
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'kode',
                        name: 'kode'
                    },
                    {
                        data: 'account_type.nama',
                        name: 'account_type.nama'
                    },
                    {
                        data: 'saldo_awal',
                        name: 'saldo_awal'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    },
                ],
                pageLength: 10,
                lengthMenu: [
                    [10, 20, 50, -1],
                    [10, 20, 50, 'All']
                ]
            });
        }

        $('#addNewAccount').click(function() {
            $('#addEditAccountForm').trigger("reset");
            $("#id").val('');
            $('.modal-title').html("Tambah Akun");
            $('#Account-modal').modal('show');
        });

        $('body').on('click', '.edit', function() {
            var id = $(this).data('id');

            // ajax
            $.ajax({
                type: "GET",
                url: "{{ url('/') }}/api/accounts/" + id + "/edit",
                dataType: 'json',
                success: function(res) {
                    $('.modal-title').html("Edit Akun");
                    $('#Account-modal').modal('show');
                    $('#id').val(res.data.id);
                    $('#nama').val(res.data.nama);
                    $('#kode').val(res.data.kode);
                    $('#saldo_awal').val(formatRupiah(String(res.data.saldo_awal), 'Rp.'));
                    $('#account_type_id').val(res.data.account_type_id).trigger('change');
                },
                error: ajaxError,
            });
        });

        $('body').on('click', '#btn-save', function(event) {
            var id = $("#id").val();
            var nama = $("#nama").val();
            var kode = $("#kode").val();
            var saldo_awal = $("#saldo_awal").val();
            var account_type_id = $("#account_type_id").val();
            $("#btn-save").html('Please Wait...');
            $("#btn-save").attr("disabled", true);

            // ajax
            $.ajax({
                type: "POST",
                url: "{{ route('api.accounts.update-or-create') }}",
                data: {
                    id: id,
                    nama: nama,
                    kode: kode,
                    saldo_awal: saldo_awal,
                    account_type_id: account_type_id
                },
                dataType: 'json',
                success: function(res) {
                    table.ajax.reload();
                    $("#btn-save").html('Submit');
                    $("#btn-save").attr("disabled", false);
                    toastr.success(res.message, 'Berhasil!');
                    $('#Account-modal').modal('hide');
                },
                error: ajaxError,
            });
        });

        // // delete
        $('body').on('click', '.delete', function(e) {
            e.preventDefault();
            deleteaccount($(this).attr('id'))
        });

        function deleteaccount(id) {
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Akun akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus Sekarang!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{ url('/') }}/api/accounts/" + id + "/destroy",
                        type: 'DELETE',
                        success: function(resp) {
                            toastr.success(resp.message, 'Berhasil!');
                            table.ajax.reload();
                        },
                        error: ajaxError,
                    });
                }
            })
        }

        $(function() {
            bsCustomFileInput.init();
            //Initialize Select2 Elements
            $('.select2').select2()
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

        $('#saldo_awal').keyup(function(e) {
            $(this).val(formatRupiah(e.target.value, 'Rp.'));
        });
    </script>
@endpush
