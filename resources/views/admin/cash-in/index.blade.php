@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Kas Masuk</h3>
                        {{-- <button class="btn btn-sm btn-primary float-right" id="addNewCashIn"><i class="fas fa-plus mr-2"></i>
                            Tambah
                            Data</button> --}}
                        <a href="{{ route('admin.cash-ins.create') }}" class="btn btn-sm btn-primary float-right"><i
                                class="fas fa-plus mr-2"></i>
                            Tambah
                            Data</a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="cash_in" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Cek</th>
                                    <th>Nama User</th>
                                    <th>Tanggal</th>
                                    <th>Keterangan</th>
                                    <th>Sebesar</th>
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
    @include('admin.cash-in.modal')
@endsection
@include('layouts.inc.datatables')
@include('layouts.inc.toastr')

@push('script')
    <script type="text/javascript">
        var table;
        setTimeout(function() {
            tablecashin();
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

        function tablecashin() {
            $('#cash_in').dataTable().fnDestroy();
            table = $('#cash_in').DataTable({
                responsive: true,
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('api.cash-ins.index') }}",
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
                        data: 'no_cek',
                        name: 'no_cek'
                    },
                    {
                        data: 'user.name',
                        name: 'user.name'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'memo',
                        name: 'memo'
                    },
                    {
                        data: 'sebesar',
                        name: 'sebesar'
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

        $('#addNewCashIn').click(function() {
            $('#addEditCashInForm').trigger("reset");
            $("#id").val('');
            $('.modal-title').html("Tambah Kas Masuk");
            $('#CashIn-modal').modal('show');
        });

        $('body').on('click', '.edit', function() {
            var id = $(this).data('id');

            // ajax
            $.ajax({
                type: "GET",
                url: "{{ url('/') }}/api/cash-ins/" + id + "/edit",
                dataType: 'json',
                success: function(res) {
                    $('.modal-title').html("Edit Kas Masuk");
                    $('#CashIn-modal').modal('show');
                    $('#id').val(res.data.id);
                    $("#account_id").val(res.data.account_id).trigger('change');;
                    $("#user_id").val(res.data.user_id).trigger('change');;
                    $("#no_cek").val(res.data.no_cek);
                    $("#tanggal").val(res.data.tanggal).trigger('change.datetimepicker');
                    $("#sebesar").val(formatRupiah(String(res.data.sebesar), 'Rp.'));
                },
                error: ajaxError,
            });
        });



        // // delete
        $('body').on('click', '.delete', function(e) {
            e.preventDefault();
            deletecash_in($(this).attr('id'))
        });

        function deletecash_in(id) {
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Kas Masuk akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus Sekarang!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{ url('/') }}/api/cash-ins/" + id + "/destroy",
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
    </script>
@endpush
