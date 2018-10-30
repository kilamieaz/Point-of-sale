@extends('layouts.master')
@section('title')
Daftar Supplier
@endsection

@section('breadcrumb')
@parent
<li>Supplier</li>
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
    <table class="table table-striped">
      <thead>
        <tr>
            <th width="30">No</th>
            <th>Nama Supplier</th>
            <th>Alamat</th>
            <th>Telpon</th>
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
@include('supplier.form')
@endsection

@section('script')
<script type="text/javascript">
var table, save_method;
$(function(){
   table = $('.table').DataTable({
     "processing" : true,
     "ajax" : {
       "url" : "{{ route('supplier.data') }}",
       "type" : "GET"
     }
   }); 
   
   $('#modal-form form').validator().on('submit', function(e){
      if(!e.isDefaultPrevented()){
         var id = $('#id_supplier').val();
         if(save_method == "add") url = "{{ route('supplier.store') }}";
         else url = "supplier/"+id;
         
         $.ajax({
           url : url,
           type : "POST",
           data : $('#modal-form form').serialize(),
           success : function(data){
             $('#modal-form').modal('hide');
             table.ajax.reload();
           },
           error : function(){
             alert("Tidak dapat menyimpan data!");
           }   
         });
         return false;
     }
   });
});

function addForm(){
   save_method = "add";
   $('input[name=_method]').val('POST');
   $('#modal-form').modal('show');
   $('#modal-form form')[0].reset();            
   $('.modal-title').text('Tambah Supplier');
}

function editForm(id){
   save_method = "edit";
   $('input[name=_method]').val('PATCH');
   $('#modal-form form')[0].reset();
   $.ajax({
     url : "supplier/"+id+"/edit",
     type : "GET",
     dataType : "JSON",
     success : function(data){
       $('#modal-form').modal('show');
       $('.modal-title').text('Edit Supplier');
       
       $('#id_supplier').val(data.id_supplier);
       $('#name_supplier').val(data.name_supplier);
       $('#address').val(data.address);
       $('#telephone').val(data.telephone);
       
     },
     error : function(){
       alert("Tidak dapat menampilkan data!");
     }
   });
}

function deleteData(id){
   if(confirm("Apakah yakin data akan dihapus?")){
     $.ajax({
       url : "supplier/"+id,
       type : "POST",
       data : {'_method' : 'DELETE', '_token' : $('meta[name=csrf-token]').attr('content')},
       success : function(data){
         table.ajax.reload();
       },
       error : function(){
         alert("Tidak dapat menghapus data!");
       }
     });
   }
}
</script>
@endsection