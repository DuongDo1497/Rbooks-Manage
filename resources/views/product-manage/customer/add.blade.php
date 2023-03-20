@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection
@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif
<div class="row">
    <form role="form" action="{{ route('customers-store') }}?continue=true" method="post" id="customer-form">
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('home.Tạo mới khách hàng') }}</h3>
                </div>
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group{{ ($errors->has('fullname')) ? ' has-error' : '' }}">
                        <label>{{ trans('home.Tên khách hàng') }}</label>
                        <input type="text" class="form-control" placeholder="{{ trans('home.Tên khách hàng') }}" name="fullname">
                        @if($errors->has('fullname'))<span class="help-block">{{ $errors->first('fullname') }}</span>@endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Giới tính') }}</label>
                        <select class="form-control select2" name="gender">
                            <option>{{ trans('home.Chọn') }}</option>
                            <option value="1">{{ trans('home.Nam') }}</option>
                            <option value="0">{{ trans('home.Nữ') }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <label>{{ trans('home.Ngày sinh') }}:</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <select class="form-control select2" name="birthday_day">
                                        <option value="">{{ trans('home.Ngày') }}</option>
                                        @for($i=1; $i <= 31; $i++)
                                            <option>{{ $i }}</option>
                                        @endfor
                                    </select>
                                    @if($errors->has('birthday_day'))<span class="text-danger">{{ $errors->first('birthday_day') }}</span>@endif
                                </div>
                                <div class="col-md-4">
                                    <select class="form-control select2" name="birthday_month">
                                        <option value="">{{ trans('home.Tháng') }}</option>
                                        @for($i=1; $i <= 12; $i++)
                                            <option>{{ $i }}</option>
                                        @endfor
                                    </select>
                                    @if($errors->has('birthday_month'))<span class="text-danger">{{ $errors->first('birthday_month') }}</span>@endif
                                </div>
                                <div class="col-md-4">
                                    <select class="form-control select2" name="birthday_year">
                                        <option value="">{{ trans('home.Năm') }}</option>
                                        @for($i=date('Y'); $i >= 1900; $i--)
                                            <option>{{ $i }}</option>
                                        @endfor
                                    </select>
                                    @if($errors->has('birthday_year'))<span class="text-danger">{{ $errors->first('birthday_year') }}</span>@endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Email') }}</label>
                                <input type="text" class="form-control" placeholder="Email" name="email">
                                @if($errors->has('email'))<span class="text-danger">{{ $errors->first('email') }}</span>@endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('home.Số điện thoại') }}:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">(+84)</div>
                                    <input type="text" class="form-control" tabindex="5" name="phone"> 
                                </div>
                                @if($errors->has('phone'))<span class="text-danger">{{ $errors->first('phone') }}</span>@endif
                            </div>
                        </div>
                    </div>
                </div>
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
                        <a href="{{ route('customers-index') }}" class="btn btn-default btn-cancel" tabindex="8">
                            <img src="{{ asset('img/icon-cancel.png') }}" alt="">
                            <span><b>Thoát</b></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('home.Nhóm khách hàng') }}</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <div class="select-container">
                            @foreach($customergroups as $customergroup)
                            <div class="select-row">
                                <label class="cur-pointer">
                                    <input type="checkbox" class="flat-red" name="customergroup_{{ $customergroup->id }}" value="{{ $customergroup->id }}"> {{ $customergroup->name }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
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
            $('#customer-form').submit();
        });

        $('#birthday').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' });

        $('#chk-continue').on('ifChecked', function() {
            $('#customer-form').attr('action', '{{ route('customers-store') }}?continue=true');
        });

        $('#chk-continue').on('ifUnchecked', function() {
            $('#customer-form').attr('action', '{{ route('customers-store') }}');
        });
    });
</script>
@endsection
