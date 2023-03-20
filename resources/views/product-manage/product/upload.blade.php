@extends('layouts.master')

@section('head')
<meta name="_token" content="{{csrf_token()}}" />
<link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css">
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection

@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif
<div class="row">
    <div class="col-xs-9">
        <div class="box box-table">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('home.Danh sách hình ảnh') }}</h3>
                <!-- <img width="200px" src="{{ asset(empty($product->images->first()) ? RBOOKS_NO_IMAGE_URL : $product->images->last()->path) }}" alt=""> -->
            </div>
            <div class="box-body">
                <!-- <form method="post" action="{{ route('product-upload') }}" enctype="multipart/form-data" class="dropzone" id="dropzone">
                    @csrf
                    <input type="text" name="id" hidden="true" value="{{ $product->id }}">
                </form> -->
                <div class="box-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th width="30%" class="text-left">{{ trans('home.Tên hình ảnh') }}</th>
                                <th width="50%">{{ trans('home.Hình ảnh') }}</th>
                                <th width="20%">{{ trans('home.Chức năng') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($product->images as $image)
                            <tr>
                                <td>{{ $image->name }}</td>
                                <td class="text-center"><img src="{{ asset($image->path) }}" alt="" width="100px"></td>
                                <td class="text-center">
                                    <button type="button" class="btn-delete" onclick="window.location.href='{{ route('del-img',['id' => $image->id]) }}'"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-3">
        <div class="box box-primary box-control">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('home.Chức năng') }}</h3>
            </div>
            <div class="box-body">
                <div class="btn-group">
                    <a type="submit" href="{{ route('products-index') }}" class="btn btn-primary btn-save">
                        <img src="{{ asset('img/icon-save.png') }}" alt="">
                        <span><b>{{ trans('home.Lưu') }}</b></span>
                    </a>
                    <a href="{{ route('products-index') }}" class="btn btn-default btn-cancel" tabindex="8">
                        <img src="{{ asset('img/icon-cancel.png') }}" alt="">
                        <span><b>Thoát</b></span>
                    </a>
                </div>
            </div>
        </div>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('home.Hình ảnh') }}</h3>
            </div>
            <div class="box-body">
                <img class="img-responsive" style="width: 40%; margin: 20px auto;" src="{{ asset(empty($product->images->first()) ? RBOOKS_NO_IMAGE_URL : $product->images->last()->path) }}" alt="">
                <form method="post" action="{{ route('product-upload') }}" enctype="multipart/form-data" class="dropzone" id="dropzone">
                    @csrf
                    <input type="text" name="id" hidden="true" value="{{ $product->id }}">
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript" src="https://rawgit.com/enyo/dropzone/master/dist/dropzone.js"></script>
<script>
Dropzone.options.dropzone =
{
    maxFilesize: 5,
    renameFile: function(file) {
        var dt = new Date();
        var time = dt.getTime();
        return time+file.name;
    },
    acceptedFiles: ".jpeg,.jpg,.png,.gif",
    addRemoveLinks: true,
    timeout: 50000,
    removedfile: function(file)
    {
        var name = file.upload.filename;
        console.log(name);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            type: 'POST',
            url: '{{ route('delete-image') }}',
            data: { filename: name, id: {{ $product->id }} },
            success: function (data){
                alert("Hình ảnh đã xóa thành công");
            },
            error: function(e) {
                console.log(e);
            }});
            var fileRef;
            return (fileRef = file.previewElement) != null ?
            fileRef.parentNode.removeChild(file.previewElement) : void 0;
    },
    success: function(file, response)
    {
        console.log('thành công');
    },
    error: function(file, response)
    {
        alert('Xuất hiện lỗi!!!');
        return false;
    }
};
</script>
@endsection