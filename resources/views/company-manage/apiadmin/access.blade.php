@extends('layouts.master')

@section('content')

@if(isset($infor))
<p align='left'>
<font size=6 color='#ff0000'>
<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
</font>
<font size=4 color='#000'><b>{{ $infor }}</b></font>
</p>
<p align='left' style="margin-left:45px;font-size:11pt;">
<font size=3 color='#000'>Để sử dụng chức năng này, vui lòng liên hệ <b>Bộ phận Quản trị hệ thống Công ty</b> để được xử lý.</font>
</p>
<p align='left' style="margin-left:42px;margin-top:50px;">
<a href="{{ route('dashboard') }}" style="width: 20%;color: #fff" class="btn btn-default btn-success">Quay lại trang chủ</a>
</p>
@endif


@endsection

