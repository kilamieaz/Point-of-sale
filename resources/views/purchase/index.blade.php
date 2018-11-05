@extends('layouts.master')
@section('title')
Daftar Pembelian
@endsection

@section('breadcrumb')
@parent
<li>Pembelian</li>
@endsection
@section('content')
<!-- Default box -->
<div class="box">
  <div class="box-header with-border">
    <a onclick="addForm()" class="btn btn-success"><i class="fa fa-plus-circle"></i> Tambah</a>

    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
        <i class="fa fa-minus"></i></button>
      <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
        <i class="fa fa-times"></i></button>
    </div>
  </div>

  <div class="box-body">
    <table class="table table-striped table-purchase">
      <thead>
        <tr>
          <th width="30">No</th>
          <th>Tanggal</th>
          <th>Supplier</th>
          <th>Total Item</th>
          <th>Total Harga</th>
          <th>Diskon</th>
          <th>Total Bayar</th>
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
@include('purchase.detail')
@include('purchase.supplier')
@endsection

@section('script')
<script type="text/javascript">
  var table, save_method, table1;
  $(function () {
    table = $('.table-purchase').DataTable({
      "processing": true,
      "serverside": true,
      "ajax": {
        "url": "{{ route('purchase.data') }}",
        "type": "GET"
      }
    });

    table1 = $('.table-detail').DataTable({
      "dom": 'Brt',
      "bSort": false,
      "processing": true
    });

    $('.table-supplier').DataTable();
  });

  function addForm() {
    $('#modal-supplier').modal('show');
  }

  function showDetail(id) {
    $('#modal-detail').modal('show');

    table1.ajax.url("purchase/" + id + "/show");
    table1.ajax.reload();
  }

  function deleteData(id) {
    if (confirm("Apakah yakin data akan dihapus?")) {
      $.ajax({
        url: "purchase/" + id,
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