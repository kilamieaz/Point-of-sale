@extends('layouts.master')
@section('title')
Edit Profile
@endsection

@section('breadcrumb')
@parent
<li>User</li>
<li>Edit Profile</li>
@endsection
@section('content')
<!-- Default box -->
<div class="box">
    <div class="box-header with-border">
    </div>

    <form class="form form-horizontal" data-toggle="validator" method="post" enctype="multipart/form-data">
        {{ csrf_field() }} {{ method_field('PATCH') }}
        <div class="box-body">

            <div class="alert alert-info alert-dismissible" style="display:none">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <i class="icon fa fa-check"></i>
                Perubahan berhasil disimpan.
            </div>

            <div class="form-group">
                <label for="photo" class="col-md-2 control-label">Foto Profil</label>
                <div class="col-md-4">
                    <input id="photo" type="file" class="form-control" name="photo">
                    <br>
                    <div class="show-photo"> <img src="{{ Storage::url($user->photo()) }}" width="200"></div>
                </div>
            </div>

            <div class="form-group">
                <label for="oldPassword" class="col-md-2 control-label">Password Lama</label>
                <div class="col-md-6">
                    <input id="oldPassword" type="password" class="form-control" name="oldPassword">
                    <span class="help-block with-errors"></span>
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="col-md-2 control-label">Password</label>
                <div class="col-md-6">
                    <input id="password" type="password" class="form-control" name="password">
                    <span class="help-block with-errors"></span>
                </div>
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="col-md-2 control-label">Ulang Password</label>
                <div class="col-md-6">
                    <input id="password_confirmation" type="password" class="form-control" data-match="#password" name="password_confirmation">
                    <span class="help-block with-errors"></span>
                </div>
            </div>

        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Simpan Perubahan</button>
        </div>
    </form>
    <!-- /.box-body -->
    <div class="box-footer">
    </div>
    <!-- /.box-footer-->
</div>
<!-- /.box -->
@include('category.form')
@endsection

@section('script')
<script type="text/javascript">
    $(function () {
        $('#oldPassword').keyup(function () {
            if ($(this).val() != "") $('#password, #password_confirmation').attr('required', true);
            else $('#password, #password_confirmation').attr('required', false);
        });

        $('.form').validator().on('submit', function (e) {
            if (!e.isDefaultPrevented()) {

                $.ajax({
                    url: "{{ Auth::user()->id }}/change",
                    type: "POST",
                    data: new FormData($(".form")[0]),
                    dataType: 'JSON',
                    async: false,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        if (data.msg == "error") {
                            alert('Password lama salah!');
                            $('#oldPassword').focus().select();
                        } else {
                            d = new Date();
                            $('.alert').css('display', 'block').delay(2000).fadeOut();
                            $('.show-photo img, .user-image, .img-circle').attr('src',
                                data.url + '?' + d.getTime());
                            $('#photo').val('');
                            $('#password').val('');
                            $('#password_confirmation').val('');
                            $('#oldPassword').val('');
                        }
                    },
                    error: function () {
                        alert("Tidak dapat menyimpan data!");
                    }
                });
                return false;
            }
        });

    });
</script>
@endsection