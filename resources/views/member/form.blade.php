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

                    <input type="hidden" id="id_member" name="id_member">
                    <div class="form-group">
                        <label for="code_member" class="col-md-3 control-label">Kode Member</label>
                        <div class="col-md-6">
                            <input id="code_member" type="number" class="form-control" name="code_member" autofocus required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name_member" class="col-md-3 control-label">Nama Member</label>
                        <div class="col-md-6">
                            <input id="name_member" type="text" class="form-control" name="name_member" autofocus required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address" class="col-md-3 control-label">Alamat</label>
                        <div class="col-md-8">
                            <input id="address" type="text" class="form-control" name="address" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="telephone" class="col-md-3 control-label">Telpon</label>
                        <div class="col-md-6">
                            <input id="telephone" type="text" class="form-control" name="telephone" autofocus required>
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