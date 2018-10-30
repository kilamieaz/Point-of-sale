<div class="modal" id="modal-form" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <form class="form-horizontal" data-toggle="validator" method="post">
                {{ csrf_field() }} {{ method_field('POST') }}

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">
                            &times; </span> </button>
                    <h3 class="modal-title"></h3>
                </div>

                <div class="modal-body">

                    <input type="hidden" id="id_product" name="id_product">
                    <div class="form-group">
                        <label for="code_product" class="col-md-3 control-label">Kode Produk</label>
                        <div class="col-md-6">
                            <input id="code_product" type="number" class="form-control" name="code_product" autofocus required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name_product" class="col-md-3 control-label">Nama Produk</label>
                        <div class="col-md-6">
                            <input id="name_product" type="text" class="form-control" name="name_product" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="id_category" class="col-md-3 control-label">Kategori</label>
                        <div class="col-md-6">
                            <select id="id_category" type="text" class="form-control" name="id_category" required>
                                <option value=""> -- Pilih Kategori-- </option>
                                @foreach($categories as $list)
                                <option value="{{ $list->id_category }}">{{ $list->name_category }}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="brand" class="col-md-3 control-label">Merk</label>
                        <div class="col-md-6">
                            <input id="brand" type="text" class="form-control" name="brand" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="purchase_price" class="col-md-3 control-label">Harga Beli</label>
                        <div class="col-md-3">
                            <input id="purchase_price" type="text" class="form-control" name="purchase_price" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="discount" class="col-md-3 control-label">Diskon</label>
                        <div class="col-md-2">
                            <input id="discount" type="text" class="form-control" name="discount" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="selling_price" class="col-md-3 control-label">Harga Jual</label>
                        <div class="col-md-3">
                            <input id="selling_price" type="text" class="form-control" name="selling_price" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="stock" class="col-md-3 control-label">Stok</label>
                        <div class="col-md-2">
                            <input id="stock" type="text" class="form-control" name="stock" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-save"><i class="fa fa-floppy-o"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i>
                        Batal</button>
                </div>

            </form>

        </div>
    </div>
</div>