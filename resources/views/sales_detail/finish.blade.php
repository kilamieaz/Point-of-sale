@extends('layouts.master')
@section('title')
Selesai Transaksi
@endsection

@section('breadcrumb')
@parent
<li>Transaksi</li>
<li>Selesai</li>
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
        <div class="alert alert-success alert-dismissible">
            <i class="icon fa fa-check"></i>
            Data Transaksi telah disimpan.
        </div>

        <br><br>
        @if($setting->note_type==0)
        <a class="btn btn-warning btn-lg" href="{{ route('transaction.print') }}">Cetak Ulang Nota</a>
        @else
        <a class="btn btn-warning btn-lg" onclick="showNota()">Cetak Ulang Nota</a>
        <script type="text/javascript">
            showNota();

            function showNota() {
                window.open("{{ route('transaction.pdf') }}", "Nota PDF", "height=650,width=1024,left=150,scrollbars=yes");
            }
        </script>
        @endif
        <a class="btn btn-primary btn-lg" href="{{ route('transaction.new') }}">Transaksi Baru</a>
        <br><br><br><br>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
    </div>
    <!-- /.box-footer-->
</div>
<!-- /.box -->
@endsection