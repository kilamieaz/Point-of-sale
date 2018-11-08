@extends('layouts.master')
@section('title')
Transaksi Penjualan
@endsection

@section('breadcrumb')
@parent
<li>penjualan</li>
<li>tambah</li>
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
        <form class="form form-horizontal form-product" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="idSales" value="{{ $idSales }}">
            <div class="form-group">
                <label for="code_product" class="col-md-2 control-label">Kode Produk</label>
                <div class="col-md-5">
                    <div class="input-group">
                        <input id="code_product" type="text" class="form-control" name="code_product" autofocus
                            required>
                        <span class="input-group-btn">
                            <button onclick="showProduct()" type="button" class="btn btn-info">...</button>
                        </span>
                    </div>
                </div>
            </div>
        </form>

        <form class="form-cart">
            {{ csrf_field() }} {{ method_field('PATCH') }}
            <table class="table table-striped table-sales">
                <thead>
                    <tr>
                        <th width="30">No</th>
                        <th>Kode produk</th>
                        <th>Nama produk</th>
                        <th align="right">Harga</th>
                        <th>Jumlah</th>
                        <th>diskon</th>
                        <th align="right">Sub Total</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </form>
        <br>

        <div class="col-md-8">
            <div id="show-pay" style="background: #dd4b39; color: #fff; font-size: 80px; text-align: center; height: 120px"></div>
            <div id="paySpelled" style="background: #3c8dbc; color: #fff; font-size: 25px; padding: 10px"></div>
        </div>
        <div class="col-md-4">
            <form class="form form-horizontal form-sales" method="get" action="{{route('transaction.print')}}">
                {{ csrf_field() }}
                <input type="hidden" name="idSales" value="{{ $idSales }}">
                <input type="hidden" name="total_price" id="total_price">
                <input type="hidden" name="total_item" id="total_item">
                <input type="hidden" name="pay" id="pay">

                <div class="form-group">
                    <label for="totalRp" class="col-md-4 control-label">Total</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="totalRp" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label for="code_member" class="col-md-4 control-label">Kode Member</label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <input id="code_member" type="text" class="form-control" name="code_member" value="0">
                            <span class="input-group-btn">
                                <button onclick="showMember()" type="button" class="btn btn-info">...</button>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="discount" class="col-md-4 control-label">diskon</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="discount" id="discount" value="0" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label for="payRp" class="col-md-4 control-label">Bayar</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="payRp" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label for="accepted" class="col-md-4 control-label">diterima</label>
                    <div class="col-md-8">
                        <input type="number" class="form-control" value="0" name="accepted" id="accepted">
                    </div>
                </div>

                <div class="form-group">
                    <label for="back" class="col-md-4 control-label">kembali</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="back" value="0" readonly>
                    </div>
                </div>

            </form>
        </div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        <button type="submit" class="btn btn-primary pull-right save"><i class="fa fa-floppy-o"></i> Simpan Transaksi</button>
    </div>
    <!-- /.box-footer-->
</div>
<!-- /.box -->
@include('sales_detail.product')
@include('sales_detail.member')
@endsection


@section('script')
<script type="text/javascript">
    var table;
    $(function () {
        $('.table-product').DataTable();

        table = $('.table-sales').DataTable({
            "dom": 'Brt',
            "bSort": false,
            "processing": true,
            "ajax": {
                "url": "{{ route('transaction.data', $idSales) }}",
                "type": "GET"
            }
        }).on('draw.dt', function () {
            loadForm($('#discount').val());
        });

        $('.form-product').on('submit', function () {
            return false;
        });

        $('body').addClass('sidebar-collapse');

        $('#code_product').change(function () {
            addItem();
        });

        $('.form-cart').submit(function () {
            return false;
        });

        $('#code_member').change(function () {
            selectMember($(this).val());
        });

        $('#accepted').change(function () {
            if ($(this).val() == "") $(this).val(0).select();
            loadForm($('#discount').val(), $(this).val());
        }).focus(function () {
            $(this).select();
        });

        $('.save').click(function () {
            $('.form-cart').submit();
            $('.form-sales').submit();
        });

    });

    function addItem() {
        $.ajax({
            url: "{{ route('transaction.store') }}",
            type: "POST",
            data: $('.form-product').serialize(),
            success: function (data) {
                $('#code_product').val('').focus();
                table.ajax.reload(function () {
                    loadForm($('#discount').val());
                });
            },
            error: function () {
                alert("Tidak dapat menyimpan data!");
            }
        });
    }

    function showProduct() {
        $('#modal-product').modal('show');
    }

    function showMember() {
        $('#modal-member').modal('show');
    }

    function selectItem(code_product) {
        $('#code_product').val(code_product);
        $('#modal-product').modal('hide');
        addItem();
    }

    function changeCount(id) {
        $.ajax({
            url: "transaction/" + id,
            type: "POST",
            data: $('.form-cart').serialize(),
            success: function (data) {
                $('#code_product').focus();
                table.ajax.reload(function () {
                    loadForm($('#discount').val());
                });
            },
            error: function () {
                alert("Tidak dapat menyimpan data!");
            }
        });
    }
    //
    function selectMember(code_member) {
        $('#modal-member').modal('hide');
        // $('#discount').val('{{ $setting->discount_member }}');
        $('#code_member').val(code_member);
        loadForm($('#discount').val());
        $('#accepted').val(0).focus().select();
    }

    function deleteItem(id) {
        if (confirm("Apakah yakin data akan dihapus?")) {
            $.ajax({
                url: "transaction/" + id,
                type: "POST",
                data: {
                    '_method': 'DELETE',
                    '_token': $('meta[name=csrf-token]').attr('content')
                },
                success: function (data) {
                    table.ajax.reload(function () {
                        loadForm($('#discount').val());
                    });
                },
                error: function () {
                    alert("Tidak dapat menghapus data!");
                }
            });
        }
    }

    function loadForm(discount = 0, accepted = 0) {
        $('#total_price').val($('.total_price').text());
        $('#total_item').val($('.total_item').text());

        $.ajax({
            url: "transaction/loadform/" + discount + "/" + $('#total_price').val() + "/" + accepted,
            type: "GET",
            dataType: 'JSON',
            success: function (data) {
                $('#totalRp').val("Rp. " + data.totalRp);
                $('#payRp').val("Rp. " + data.payRp);
                $('#pay').val(data.pay);
                $('#show-pay').html("<small>Bayar:</small> Rp. " + data.payRp);
                $('#paySpelled').text(data.paySpelled);

                $('#back').val("Rp. " + data.backRp);
                if ($('#accepted').val() != 0) {
                    $('#show-pay').html("<small>Kembali:</small> Rp. " + data.backRp);
                    $('#paySpelled').text(data.backSpelled);
                }
            },
            error: function () {
                alert("Tidak dapat menampilkan data!");
            }
        });
    }
</script>

@endsection