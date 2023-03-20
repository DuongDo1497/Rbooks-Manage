@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection
@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif
<div class="row">
    <form role="form" action="{{ route('careers-store') }}?continue=true" method="post" id="careers-form" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('home.Tạo mới ứng viên') }}</h3>
                </div>
                <div class="box-body">

                    <div class="form-group{{ ($errors->has('fullname')) ? ' has-error' : '' }}">
                        <label>{{ trans('home.Tên ứng viên') }}</label>
                        <input type="text" class="form-control" placeholder="{{ trans('home.Tên ứng viên') }}" name="fullname">
                        @if($errors->has('fullname'))<span class="help-block">{{ $errors->first('fullname') }}</span>@endif
                    </div>

                    <div class="form-group{{ ($errors->has('phone')) ? ' has-error' : '' }}">
                        <label>{{ trans('home.Số điện thoại') }}</label>
                        <input type="number" class="form-control" placeholder="{{ trans('home.Số điện thoại') }}" name="phone">
                        @if($errors->has('phone'))<span class="help-block">{{ $errors->first('phone') }}</span>@endif
                    </div>

                    <div class="form-group{{ ($errors->has('email')) ? ' has-error' : '' }}">
                        <label>{{ trans('home.Email') }}</label>
                        <input type="text" class="form-control" placeholder="{{ trans('home.Email') }}" name="email">
                        @if($errors->has('email'))<span class="help-block">{{ $errors->first('email') }}</span>@endif
                    </div>

                    <div class="form-group">
                        <label>{{ trans('home.Giới tính') }}</label>
                        <select class="form-control select2" name="gender">
                            <option>{{ trans('home.Chọn') }}</option>
                            <option value="0">{{ trans('home.Nữ') }}</option>
                            <option value="1">{{ trans('home.Nam') }}</option>
                            <option value="2">{{ trans('home.Khác') }}</option>
                        </select>
                    </div>

                    <div class="form-group{{ ($errors->has('apply_position')) ? ' has-error' : '' }}">
                        <label>{{ trans('home.Vị trí ứng tuyển') }}</label>
                        <input type="text" class="form-control" placeholder="{{ trans('home.Vị trí ứng tuyển') }}" name="apply_position">
                        @if($errors->has('apply_position'))<span class="help-block">{{ $errors->first('apply_position') }}</span>@endif
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('home.Chức năng') }}</h3>
                </div>
                <div class="box-body">
                    <button type="submit" class="btn btn-primary btn-save" tabindex="9">{{ trans('home.Lưu') }}</button>
                    <a href="{{ route('careers-index') }}" class="btn btn-default btn-cancel" tabindex="10">{{ trans('home.Trở về') }}</a>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Upload CV</h3>
                </div>
                <div class="box-body">
                    <input class="file_cv_add" type="file" name="file_cv" id="file_cv" data-file_types="pdf">
                    <label for="file_cv" class="clearfix fileName">
                        <span></span>
                        <strong><i class="fa fa-upload"></i> Choose a file&hellip;</strong>
                    </label>
                    <p class="text-danger" style="margin-top: 10px;">{{ trans('home.Lưu ý: Tải file .pdf và dung lượng file dưới 1 MB') }}</p>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@section('scripts')
<script src="{{ asset('plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
<script>
    $(function() {
        $('.btn-save').click(function() {
            $('#careers-form').submit();
        });

        // $('#birthday').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' });

        $('#chk-continue').on('ifChecked', function() {
            $('#careers-form').attr('action', '{{ route('careers-store') }}?continue=true');
        });

        $('#chk-continue').on('ifUnchecked', function() {
            $('#careers-form').attr('action', '{{ route('careers-store') }}');
        });

        $('.file_cv_add').change(function() {
            var numb = $(this)[0].files[0].size/1024/1024;
            var resultid = $(this).val().split(".");
            var gettypeup  = resultid [resultid.length-1];
            var filetype = $(this).attr('data-file_types');
            var allowedfiles = filetype.replace(/\|/g,', ');
            var filesize = 1;
            var onlist = $(this).attr('data-file_types').indexOf(gettypeup) > -1;
            var checkinputfile = $(this).attr('type');
            var numb_fix = numb.toFixed(2);
            var fileName = $(this).val().split( "\\" ).pop();

            

            if(onlist && numb_fix <= filesize){
                $('.fileName span').text(fileName);
                confirm('Upload file successful');
            } else {
                if(numb_fix >= filesize && onlist){
                    $(this).val('');
                    confirm('Added file is too big \(' + numb_fix + ' MB\) - max file size '+ filesize +' MB');
                } else if(numb_fix < filesize && !onlist || !onlist) {
                    $(this).val('');
                    confirm('An not allowed file format has been added \('+ gettypeup +') - allowed formats: ' + allowedfiles);
                }
            }
        });

    });
</script>
@endsection
