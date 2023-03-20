@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection

@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

<form role="form" method="post" action="{{ route('products-update',['id' => $model->id]) }}">
    {{ csrf_field() }}
    {{ method_field('put') }}
    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('home.Thông tin sản phẩm') }}</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label>{{ trans('home.Tên sản phẩm') }}</label>
                        <input type="text" class="form-control" placeholder="Tên sản phẩm" name="name" value="{{ $model->name }}">
                         @if($errors->has('name'))<span class="text-danger">{{ $errors->first('name') }}</span>@endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Hiện') }}/{{ trans('home.Ẩn') }} sản phẩm</label>
                        <div class="radio-item">
                            <input name="status" value="1" 
                            @if($model->status == 1)
                            {{"checked"}}
                            @endif
                            type="radio">
                            <span>{{ trans('home.Hiện') }}</span>
                        </div>
                        <div class="radio-item">
                            <input name="status" value="0" 
                            @if($model->status == 0)
                            {{"checked"}}
                            @endif 
                            type="radio">
                            <span>{{ trans('home.Ẩn') }}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="slug">URL</label>
                        <div class="input-group">
                            <span class="input-group-addon">https://rbooks.vn/resources/views/pages/shopping/</span>
                            <input type="text" class="form-control" placeholder="Url" name="slug" tabindex="2" value="{{ $model->slug }}">
                        </div>
                         @if($errors->has('slug'))<span class="text-danger">{{ $errors->first('slug') }}</span>@endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Mô tả') }}<small class="text-danger text"> (*) {{ trans('home.Nhập dưới 400 từ') }}</small></label>
                        <textarea id="excerpt" name="excerpt" rows="6" class="form-control">{{ $model->excerpt }}</textarea>
                         @if($errors->has('excerpt'))<span class="text-danger">{{ $errors->first('excerpt') }}</span>@endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Nội dung giới thiệu') }}</label>
                        <textarea id="description" name="description" rows="10">{{ $model->description }}</textarea>
                    </div>
                </div>
            </div>
            <!-- <div class="form-group">
                <label>Ẩn hiện</label>
                <select class="form-control select2" name="status" data-minimum-results-for-search="Infinity">
                    <option value="1">Hiện</option>
                    <option value="0">Ẩn</option>
                </select>
            </div> -->
            @include('product-manage.product.settingEdit')
        </div>
        <div class="col-md-4">
            <div class="box box-primary box-control">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('home.Chức năng') }}</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label class="cur-pointer">
                            <input type="checkbox" class="flat-red" tabindex="4"
                                    name="continue" value="1" checked="checked" id="chk-continue"
                                    {{ old( 'continue')===1 ? 'checked="checked"' : '' }}> {{ trans('home.Lưu và thêm mới') }}
                        </label>
                    </div>
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary btn-save" tabindex="7">
                            <img src="{{ asset('img/icon-save.png') }}" alt="">
                            <span><b>{{ trans('home.Lưu') }}</b></span>
                        </button>
                        <a href="{{ route('products-index') }}" class="btn btn-default btn-cancel" tabindex="8">
                            <img src="{{ asset('img/icon-cancel.png') }}" alt="">
                            <span><b>Thoát</b></span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('home.Danh mục/Thể loại') }}</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <div class="select-container">
                            @foreach($categories as $category)
                            <div class="select-row">
                                <label class="cur-pointer">
                                    <input type="checkbox" class="flat-red" name="category_{{ $category->id }}" value="{{ sub_category_depth_tab($category->depth) . $category->id }}" {{ $category->key == '1' ? 'checked="checked"' : '' }}> {{ sub_category_depth_tab($category->depth) . $category->name }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('home.Upload File Đọc thử') }}</h3>
                </div>
                <div class="box-body">
                    <input class="look_inside" type="file" name="file_look_inside" data-file_types="pdf">
                    <p class="text-danger" style="margin-top: 10px;">{{ trans('home.Lưu ý: Tải file .pdf và dung lượng file dưới 1 MB') }}</p>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
@include('product-manage.product.partials.script')
@endsection