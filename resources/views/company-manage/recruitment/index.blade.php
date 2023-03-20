@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection
@section('content')

@if(session()->has('success'))
@include('layouts.partials.messages.success')
@endif
@include('company-manage.recruitment.partials.search-form')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">
                    Danh sách tin tuyển dụng
                    <small>({{ trans('home.Hiển thị') }} {{ $filter['limit'] }} {{ trans('home.dòng / trang') }}) </small>
                </h3>
                <div class="box-tools">
                    <div class="btn-group btn-group-sm">
                        <a href="{{ route('recruitments-add') }}" class="btn btn-default"><i class="fa fa-plus" aria-hidden="true"></i> {{ trans('home.Tạo mới') }}</a>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-download" aria-hidden="true"></i> {{ trans('home.Xuất danh sách') }}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="#"><i class="fa fa-file-text-o" aria-hidden="true"></i> {{ trans('home.Xuất tất cả') }}</a></li>
                                <li><a href="#"><i class="fa fa-file-text" aria-hidden="true"></i> {{ trans('home.Xuất tùy chọn') }}</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="btn-group btn-group-sm">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-window-maximize" aria-hidden="true"></i> {{ trans('home.Hiển thị') }}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="{{ route('recruitments-index', filter_data($filter, 'limit', 10)) }}">10 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('recruitments-index', filter_data($filter, 'limit', 25)) }}">25 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('recruitments-index', filter_data($filter, 'limit', 50)) }}">50 {{ trans('home.dòng / trang') }}</a></li>
                                <li><a href="{{ route('recruitments-index', filter_data($filter, 'limit', 100)) }}">100 {{ trans('home.dòng / trang') }}</a></li>
                            </ul>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-sort" aria-hidden="true"></i> {{ trans('home.Sắp xếp') }}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="{{ route('recruitments-index', filter_data($filter, 'orderBy', 'id')) }}">{{ trans('home.ID') }}</a></li>
                                <li><a href="{{ route('recruitments-index', filter_data($filter, 'orderBy', 'code_divisions')) }}">{{ trans('home.Mã bộ phận') }}</a></li>
                                <li><a href="{{ route('recruitments-index', filter_data($filter, 'orderBy', 'name')) }}">{{ trans('home.Tên bộ phận') }}</a></li>
                                <li><a href="{{ route('recruitments-index', filter_data($filter, 'orderBy', 'created_at')) }}">{{ trans('home.Ngày tạo') }}</a></li>
                                <li><a href="{{ route('recruitments-index', filter_data($filter, 'orderBy', 'updated_at')) }}">{{ trans('home.Ngày chỉnh sửa') }}</a></li>
                            </ul>
                        </div>

                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @if($filter['sortedBy'] == 'asc' || empty($filter['sortedBy']))
                                <i class="fa fa-sort-amount-asc" aria-hidden="true"></i> {{ trans('home.Tăng dần') }}
                                @else
                                <i class="fa fa-sort-amount-desc" aria-hidden="true"></i> {{ trans('home.Giảm dần') }}
                                @endif
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="{{ route('recruitments-index', filter_data($filter, 'sortedBy', 'asc')) }}"><i class="fa fa-sort-amount-asc" aria-hidden="true"></i> {{ trans('home.Tăng dần') }}</a></li>
                                <li><a href="{{ route('recruitments-index', filter_data($filter, 'sortedBy', 'desc')) }}"><i class="fa fa-sort-amount-desc" aria-hidden="true"></i> {{ trans('home.Giảm dần') }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="1%">
                                <label>
                                    <input type="checkbox" class="minimal checkbox-all">
                                </label>
                            </th>
                            <th width="5%">{{ trans('home.STT') }}</th>
                            <th class="text-nowrap" width="15%">Vị trí công việc</th>
                            <th class="text-nowrap">Mô tả công việc</th>
                            <th class="text-nowrap">Quyền lợi</th>
                            <th class="text-nowrap">Yêu cầu</th>
                            <th class="text-nowrap">Kinh nghiệm</th>
                            <th class="text-nowrap">Số lượng</th>
                            <th class="text-nowrap">Trạng thái</th>
                            <th class="text-nowrap">Ngày hết hạn</th>
                            <th class="text-nowrap">{{ trans('home.Ngày khởi tạo') }}</th>
                            <th class="text-nowrap">{{ trans('home.Ngày chỉnh sửa') }}</th>
                            <th class="text-nowrap">
                                <span class="lbl-action">{{ trans('home.Chức năng') }}</span>
                                <button class="btn btn-danger btn-xs btn-block hide btn-delete-selected">{{ trans('home.Xóa') }} <span class="lbl-selected-rows-count">0</span> {{ trans('home.đã chọn') }}</button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($collections->count() === 0)
                        <tr>
                            <td colspan="8"><b>{{ trans('home.Không có dữ liệu') }}!!!</b></td>
                        </tr>
                        @endif
                        @php
                        $i = 1
                        @endphp
                        @foreach ($collections as $recruitment)
                        <tr>
                            <td>
                                <label>
                                    <input type="checkbox" class="minimal checkbox-item" data-id="">
                                </label>
                            </td>
                            <td>{{ $i }}</td>
                            <td>{{ $recruitment->title }} ( {{$recruitment->vacancies}} )</td>
                            <td>{{ $recruitment->job_description->introduction ?? 'Mô tả công việc'}}</td>
                            <td>{{ $recruitment->job_description->benefit ?? 'Quyền lợi'}}</td>
                            <td>{{ $recruitment->job_description->requirements ?? 'Yêu cầu'}}</td>
                            <td>{{ $recruitment->job_description->experience ?? 'kinh nghiệm' }}</td>
                            <td>{{ $recruitment->quantity }} </td>

                            <td><span class=" @if($recruitment->status == 0)
                    bg-danger
                   @elseif($recruitment->status == 1)bg-success
                   @elseif($recruitment->status == 2) bg-warning
                   
                   @endif">{{ $recruitment->status_text ?? 'nội dung trống'}}</span></td>
                            <td>{{ $recruitment->application_deadline }} </td>
                            <td>{{ $recruitment->created_at }}</td>
                            <td>{{ $recruitment->updated_at }}</td>
                            <td>
                                <div class=" btn-group">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ trans('home.Thao tác') }} <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li>
                                            <form method="POST" action="{{route('recruitments-UpLoadStatus', [ 'id' => $recruitment->id ])}}">
                                                @csrf
                                                @method('PUT')
                                                @if($recruitment->status == 0)
                                                <button class="dropdown-item btn-sm ">
                                                    <i class="fas fa-pencil-alt" style="margin-right: 10px;"></i> Còn thời gian
                                                </button>
                                                @elseif($recruitment->status == 1)
                                                <button class="dropdown-item btn-sm ">
                                                    <i class="fas fa-pencil-alt" style="margin-right: 10px;"></i> Sắp hết thời gian
                                                </button>
                                                @elseif($recruitment->status == 2)
                                                <button class="dropdown-item btn-sm ">
                                                    <i class="fas fa-pencil-alt" style="margin-right: 10px;"></i> Hết hạn
                                                </button>
                                                @endif
                                            </form>
                                        </li>
                                        <li><a href="{{ route('recruitments-edit', ['id' => $recruitment->id ]) }}"><i class="fas fa-pencil-alt" style="margin-right: 10px;"></i> {{ trans('home.Chỉnh sửa') }}</a></li>
                                        <li><a href="javascript:void(0)" data-id="{{ $recruitment->id }}" class="btn-delete"><i class="fa fa-trash" aria-hidden="true"></i> {{ trans('home.Xóa') }}</a>
                                            <form name="form-delete-{{ $recruitment->id }}" method="post" action="{{ route('recruitments-delete', ['id' => $recruitment->id ]) }}">
                                                {{ csrf_field() }}
                                                {{ method_field('delete') }}
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @php
                        $i++
                        @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix text-right">
                {{ $collections->links() }}
            </div>
        </div>
        <!-- /.box -->
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(function() {
        $('.btn-delete').click(function() {
            var id = $(this).data('id');
            swal({
                    title: "{{ trans('home.Bạn có chắc không?') }}",
                    text: "{{ trans('home.Nội dung xóa sẽ được đưa vào thùng rác') }}",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((value) => {
                    console.log(value);
                    if (value) {
                        document.forms['form-delete-' + id].submit();
                    }
                });
        });

        @if(!empty($filter['searchFields']))
        $('#searchFields').val('{{ $filter['
            searchFields '] }}').trigger('change');
        @endif
    });
</script>
@endsection