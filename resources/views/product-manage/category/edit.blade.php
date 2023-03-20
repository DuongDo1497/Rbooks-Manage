@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection
@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif
<div class="row">
    <div class="col-md-8">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('home.Chỉnh sửa danh mục') }}</h3>
            </div>
            <form role="form" action="{{ route('categories-update', ['id' => $model->id]) }}?continue=true" method="post" id="category-form">
                {{ csrf_field() }}
                {{ method_field('put') }}
                <div class="box-body">
                    <div class="form-group">
                        <label>{{ trans('home.Tên danh mục') }}</label>
                        <input type="text" class="form-control" placeholder="{{ trans('home.Tên danh mục') }}" name="name" value="{{ $model->name }}">
                        @if($errors->has('name'))<span class="help-block">{{ $errors->first('name') }}</span>@endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Tên danh mục tiếng anh') }}</label>
                        <input type="text" class="form-control" placeholder="{{ trans('home.Tên danh mục tiếng anh') }}" name="nameEnglish" value="{{ $model->nameEnglish }}">
                        @if($errors->has('nameEnglish'))<span class="help-block">{{ $errors->first('nameEnglish') }}</span>@endif
                    </div>
                    <div class="form-group">
                        <label>Slug</label>
                        <div class="input-group">
                            <span class="input-group-addon">https://rbooks.vn/resources/views/pages/shopping/</span>
                            <input type="text" class="form-control" placeholder="Url" name="slug" tabindex="2" value="{{ $model->slug }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Danh mục cha') }}</label>
                        <select class="form-control select2" name="parent_id">
                            <option value="">{{ trans('home.Danh mục cha') }}</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ sub_category_depth_tab($category->depth) . $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Trạng thái') }}</label>
                        <select class="form-control select2" name="status" data-minimum-results-for-search="Infinity">
                            <option value="1">{{ trans('home.Kích hoạt') }}</option>
                            <option value="0">{{ trans('home.Không kích hoạt') }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Mô tả') }}</label>
                        <textarea id="description" name="description" rows="10" cols="80">{{ $model->description }}</textarea>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-4">
        <div class="box box-primary box-control">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('home.Chức năng') }}</h3>
            </div>
            <div class="box-body">
                <div class="btn-group">
                    <button type="submit" class="btn btn-primary btn-save" tabindex="7">
                        <img src="{{ asset('img/icon-save.png') }}" alt="">
                        <span><b>{{ trans('home.Lưu') }}</b></span>
                    </button>
                    <a href="{{ route('categories-index') }}" class="btn btn-default btn-cancel" tabindex="8">
                        <img src="{{ asset('img/icon-cancel.png') }}" alt="">
                        <span><b>Thoát</b></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@include('product-manage.category.partials.script')
<script>
    $(function() {
        $('#chk-continue').on('ifChecked', function() {
            $('#category-form').attr('action', '{{ route('categories-edit', ['id' => $model->id]) }}?continue=true');
        });

        $('#chk-continue').on('ifUnchecked', function() {
            $('#category-form').attr('action', '{{ route('categories-edit', ['id' => $model->id]) }}');
        });

        $("select[name=status]").val('{{ $model->status }}').trigger('change');

        @if($model->parent_id)
            $("select[name=parent_id]").val('{{ $model->parent_id }}').trigger('change');
        @endif
    });
</script>
@endsection
