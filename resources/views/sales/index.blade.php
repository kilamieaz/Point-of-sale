@extends('layouts.master')
@section('title')
Daftar Sales
@endsection

@section('breadcrumb')
@parent
<li>Sales</li>
@endsection
@section('content')
<!-- Default box -->
<div class="box">
    <div class="box-header with-border">

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                <i class="fa fa-times"></i></button>
        </div>
    </div>

    <div class="box-body">
        <table class="table table-striped table-sales">
            <thead>
                <tr>
                    <th width="30">No</th>
                    <th>Tanggal</th>
                    <th>Kode Member</th>
                    <th>Total Item</th>
                    <th>Total Harga</th>
                    <th>Diskon</th>
                    <th>Total Bayar</th>
                    <th>Kasir</th>
                    <th width="100">Aksi</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
    </div>
    <!-- /.box-footer-->
</div>
<!-- /.box -->
@include('sales.detail')
@endsection

@section('script')
<script type="text/javascript">
    var table, save_method, table1;
    $(function () {
        table = $('.table-sales').DataTable({
            "processing": true,
            "serverside": true,
            "ajax": {
                "url": "{{ route('sales.data') }}",
                "type": "GET"
            }
        });

        table1 = $('.table-detail').DataTable({
            "dom": 'Brt',
            "bSort": false,
            "processing": true
        });

        $('.tabel-supplier').DataTable();
    });

    function addForm() {
        $('#modal-supplier').modal('show');
    }

    function showDetail(id) {
        $('#modal-detail').modal('show');

        table1.ajax.url("sales/" + id + "/show");
        table1.ajax.reload();
    }

    function deleteData(id) {
        if (confirm("Apakah yakin data akan dihapus?")) {
            $.ajax({
                url: "sales/" + id,
                type: "POST",
                data: {
                    '_method': 'DELETE',
                    '_token': $('meta[name=csrf-token]').attr('content')
                },
                success: function (data) {
                    table.ajax.reload();
                },
                error: function () {
                    alert("Tidak dapat menghapus data!");
                }
            });
        }
    }
</script>
@endsection