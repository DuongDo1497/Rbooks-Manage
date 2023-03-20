@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css">
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection

@section('content')

@if(session()->has('success'))
@include('layouts.partials.messages.success')
@endif

<form role="form" method="post" action="{{ route('recruitments-store') }}?continue=true">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary info-product">
                <div class="box-header with-border">
                    <h3 class="box-title">Vị trí ứng tuyển công việc <small class="text-danger text"> (*): {{ trans('home.Bắt buộc điền thông tin') }}</small></h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label>Tên vị trí(ENG)<small class="text-danger text"> (*)</small></label>
                        <input type="text" class="form-control" placeholder="Tên vị trí tuyển dụng (tiếng anh)" name="vacancies" id="vacancies">
                        @if($errors->has('vacancies'))<div class="text-danger">{{ $errors->first('vacancies') }}</div>@endif
                    </div>
                    <div class="form-group">
                        <label>Tên vị trí(VN)<small class="text-danger text"> (*)</small></label>
                        <input type="text" class="form-control" placeholder="Tên vị trí tuyển dụng (tiếng việt)" name="title" id="title">
                        @if($errors->has('title'))<div class="text-danger">{{ $errors->first('title') }}</div>@endif
                    </div>
                    <div class="form-group">
                        <label>Mô tả công việc<small class="text-danger text"> (*) {{ trans('home.Nhập dưới 400 từ') }}</small></label>
                        <textarea id="introduction" name="introduction" rows="6" class="form-control"></textarea>
                        @if($errors->has('introduction'))<div class="text-danger">{{ $errors->first('introduction') }}</div>@endif
                    </div>
                    <div class="form-group">
                        <label>Quyền lợi<small class="text-danger text"> (*) {{ trans('home.Nhập dưới 400 từ') }}</small></label>
                        <textarea id="benefit" name="benefit" rows="6" class="form-control"></textarea>
                        @if($errors->has('benefit'))<div class="text-danger">{{ $errors->first('benefit') }}</div>@endif
                    </div>
                    <div class="form-group">
                        <label>Địa chỉ<small class="text-danger text"> (*)</small></label>
                        <input type="text" class="form-control" placeholder="Địa chỉ làm việc" name="address" id="address">
                        @if($errors->has('address'))<div class="text-danger">{{ $errors->first('address') }}</div>@endif
                    </div>
                    <div class="form-group">
                        <label>Mức lương công ty chi trả<small class="text-danger text"> (*)</small></label>
                        <input type="number" class="form-control" placeholder="Nhập số lương (VNĐ)" name="salary" id="salary">
                        @if($errors->has('salary'))<div class="text-danger">{{ $errors->first('salary') }}</div>@endif
                    </div>
                    <div class="form-group">
                        <label>Thời gian làm việc<small class="text-danger text"> (*)</small></label>
                        <input type="text" class="form-control" placeholder="Nhập thời gian làm việc" name=" work_time" id="work_time">
                        @if($errors->has('work_time'))<div class="text-danger">{{ $errors->first('work_time') }}</div>@endif
                    </div>
                    <div class="form-group">
                        <label>Kinh nghiệm<small class="text-danger text"> (*)</small></label>
                        <input type="text" class="form-control" placeholder="Kinh nghiệm yêu cầu" name="experience" id="experience">
                        @if($errors->has('experience'))<div class="text-danger">{{ $errors->first('experience') }}</div>@endif
                    </div>
                    <div class="form-group">
                        <label>Yêu cầu chính<small class="text-danger text"> (*)</small></label>
                        <textarea id="requirements" name="requirements" rows="6" class="form-control"></textarea>
                        @if($errors->has('requirements'))<div class="text-danger">{{ $errors->first('requirements') }}</div>@endif
                    </div>
                    <div class="form-group">
                        <label>Yêu cầu thêm<small class="text-danger text"> (*)</small></label>
                        <textarea id="orther_requirements" name="orther_requirements" rows="6" class="form-control"></textarea>
                        @if($errors->has('orther_requirements'))<div class="text-danger">{{ $errors->first('orther_requirements') }}</div>@endif
                    </div>
                    <div class="form-group">
                        <label>Số lượng ứng tuyển<small class="text-danger text"> (*)</small></label>
                        <input type="number" class="form-control" placeholder="Số lượng cần tuyển" name="quantity" id="quantity">
                        @if($errors->has('quantity'))<div class="text-danger">{{ $errors->first('quantity') }}</div>@endif
                    </div>
                    <div class="form-group">
                        <label>Ngày hết hạn tuyển dụng<small class="text-danger text"> (*)</small></label>
                        <input type="date" class="form-control" placeholder="Ngày hết hạng tuyển dụng" name="application_deadline" id="application_deadline">
                        @if($errors->has('application_deadline'))<div class="text-danger">{{ $errors->first('application_deadline') }}</div>@endif
                    </div>

                </div>
            </div>

        </div>
        <div class="col-md-4">
            <div class="box box-primary box-control">

                <div class="box-body">

                    <div class="form-group">
                        <label>Trạng thái bài tuyển dụng</label>
                        <select class="form-control select2" name="status">
                            <option value="0">Hết hạn</option>
                            <option value="1">Còn thời gian</option>
                            <option value="2">Sắp hết thời hạn</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Chức năng</h3>
                </div>
                <div class="box-body">
                    <button type="submit" class="btn btn-primary btn-save" tabindex="9">Lưu</button>
                    <a href="http://127.0.0.1:8000/recruitments" class="btn btn-default btn-cancel" tabindex="10">Trở về</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')

@endsection