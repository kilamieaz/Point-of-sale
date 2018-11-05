@extends('layouts.master')
@section('title')
Transaksi Pembelian
@endsection

@section('breadcrumb')
@parent
<li>Pembelian</li>
<li>Tambah</li>
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
        <table>
            <tr>
                <td width="150">Supplier</td>
                <td><b>{{ $supplier->name_supplier }}</b></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td><b>{{ $supplier->address }}</b></td>
            </tr>
            <tr>
                <td>Telpon</td>
                <td><b>{{ $supplier->telephone }}</b></td>
            </tr>
        </table>
        <hr>

        <form class="form form-horizontal form-product" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="id_purchase" value="{{ $idPurchase }}">
            <div class="form-group">
                <label for="code_product" class="col-md-2 control-label">Kode Produk</label>
                <div class="col-md-5">
                    <div class="input-group">
                        <input id="code_product" type="text" class="form-control" name="code_product" autofocus required>
                        <span class="input-group-btn">
                            <button onclick="showProduct()" type="button" class="btn btn-info">...</button>
                        </span>
                    </div>
                </div>
            </div>
        </form>

        <form class="form-cart">
            {{ csrf_field() }} {{ method_field('PATCH') }}
            <table class="table table-striped table-purchase">
                <thead>
                    <tr>
                        <th width="30">No</th>
                        <th>Kode Produk</th>
                        <th>Nama Produk</th>
                        <th align="right">Harga</th>
                        <th>Jumlah</th>
                        <th align="right">Sub Total</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </form>

        <div class="col-md-8">
            <div id="show-pay" style="background: #dd4b39; color: #fff; font-size: 80px; text-align: center; height: 100px"></div>
            <div id="paySpelled" style="background: #3c8dbc; color: #fff; font-weight: bold; padding: 10px"></div>
        </div>
        <div class="col-md-4">
            <form class="form form-horizontal form-purchase" method="post" action="{{  route('purchase.store') }} ">
                {{ csrf_field() }}
                <input type="hidden" name="id_purchase" value="{{ $idPurchase }}">
                <input type="hidden" name="total" id="total">
                <input type="hidden" name="totalItem" id="totalItem">
                <input type="hidden" name="pay" id="pay">

                <div class="form-group">
                    <label for="totalRp" class="col-md-4 control-label">Total</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="totalRp" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label for="discount" class="col-md-4 control-label">diskon</label>
                    <div class="col-md-8">
                        <input type="number" class="form-control" id="discount" name="discount" value="0">
                    </div>
                </div>

                <div class="form-group">
                    <label for="payRp" class="col-md-4 control-label">pay</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="payRp" readonly>
                    </div>
                </div>

            </form>
        </div>

    </div>
    <!-- /.box-body -->
    <div class="box-footer">
    </div>
    <!-- /.box-footer-->
</div>
<!-- /.box -->
@include('purchase_detail.product')
@endsection

@section('script')
<script type="text/javascript">
var table;
$(function(){
  $('.table-product').DataTable();

  table = $('.table-purchase').DataTable({
     "dom" : 'Brt',
     "bSort" : false,
     "processing" : true,
     "ajax" : {
       "url" : "{{ route('purchase_detail.data', $idPurchase) }}",
       "type" : "GET"
     }
  }).on('draw.dt', function(){
    loadForm($('#discount').val());
  });


  $('.form-product').on('submit', function(e){
      return false;
   });

   $('#code_product').change(function(){
      addItem();
   });

   $('.form-cart').submit(function(){
     return false;
   });

   $('#discount').change(function(){
      if($(this).val() == "") $(this).val(0).select();
      loadForm($(this).val());
   });

   $('.simpan').click(function(){
      $('.form-purchase').submit();
   });

});

function addItem(){
  $.ajax({
    url : "{{ route('purchase_detail.store') }}",
    type : "POST",
    data : $('.form-product').serialize(),
    success : function(data){
      $('#code_product').val('').focus();
      table.ajax.reload(function(){
        loadForm($('#discount').val());
      });             
    },
    error : function(){
       alert("Tidak dapat menyimpan data!");
    }   
  });
}

function selectItem(code_product){
  $('#code_product').val(code_product);
  $('#modal-product').modal('hide');
  addItem();
}

function changeCount(id){
     $.ajax({
        url : "purchase_detail/"+id,
        type : "POST",
        data : $('.form-cart').serialize(),
        success : function(data){
          $('#code_product').focus();
          table.ajax.reload(function(){
            loadForm($('#discount').val());
          });             
        },
        error : function(){
          alert("Tidak dapat menyimpan data!");
        }   
     });
}

function showProduct(){
  $('#modal-product').modal('show');
}

function deleteItem(id){
   if(confirm("Apakah yakin data akan dihapus?")){
     $.ajax({
       url : "purchase_detail/"+id,
       type : "POST",
       data : {'_method' : 'DELETE', '_token' : $('meta[name=csrf-token]').attr('content')},
       success : function(data){
         table.ajax.reload(function(){
            loadForm($('#discount').val());
          }); 
       },
       error : function(){
         alert("Tidak dapat menghapus data!");
       }
     });
   }
}

function loadForm(discount=0){
  $('#total').val($('.total').text());
  $('#totalItem').val($('.totalItem').text());

  $.ajax({
       url : "purchase_detail/loadform/"+discount+"/"+$('.total').text(),
       type : "GET",
       dataType : 'JSON',
       success : function(data){
         $('#totalRp').val("Rp. "+data.totalRp);
         $('#payRp').val("Rp. "+data.payRp);
         $('#pay').val(data.pay);
         $('#show-pay').text("Rp. "+data.payRp);
         $('#paySpelled').text(data.paySpelled);
       },
       error : function(){
         alert("Tidak dapat menampilkan data!");
       }
  });
}

</script>

@endsection