@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/iCheck/all.css') }}">
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection
@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif
<div class="row">
    <form action="{{ route('taskchild-post-file', ['id' => $taskchild->id]) }}" method="POST" id="typefile" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="modal-dialog modal-xs">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="color: red">Upload file sau khi hoàn thành 100% công việc <small></small></h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <input type="hidden" name="division_id" value="{{$iddivision}}">
                        <input class="file_cv_add" type="file" name="file_name" id="file_name" data-file_types="pdf|xlsx|docx|jpg|jpeg|png|zip|rar">
                        <label for="file_name" class="clearfix fileName">
                            <span style="font-size: 14px; padding: 13px 9px;"></span>
                            <strong><i class="fa fa-upload"></i> Choose a file&hellip;</strong>
                        </label>
                        <p class="text-danger" style="margin-top: 10px;">Lưu ý: kiểm tra kỹ file trước khi lưu</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-save">Lưu</button>
                    <button onclick="window.history.back();" type="button" class="btn btn-primary btn-save">Trở về</button>
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

        $('.file_cv_add').change(function() {
            var numb = $(this)[0].files[0].size/1024/1024;
            var resultid = $(this).val().split(".");
            var gettypeup  = resultid [resultid.length-1];
            var filetype = $(this).attr('data-file_types');
            var allowedfiles = filetype.replace(/\|/g,', ');
            var filesize = 10;
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