@extends('layouts.master')

@section('head')
<link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">
@endsection
@section('content')

@if(session()->has('success'))
    @include('layouts.partials.messages.success')
@endif

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body no-padding">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="1%">
                                <label>
                                    <input type="checkbox" class="minimal checkbox-all">
                                </label>
                            </th>
                            <th class="text-nowrap" width="5%">#</th>
                            <th class="text-nowrap">Tên danh mục</th>
                            <th class="text-nowrap">URL</th>
                            <th class="text-nowrap" width="5%">Danh mục cha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($collections as $assets)
                            <tr>
                                <td>
                                    <input type="checkbox" class="minimal checkbox-item">
                                </td>
                                <td>
                                    {{ $assets['id'] }}
                                </td>
                                <td>
                                    {{ $assets['name'] }}
                                </td>
                                <td>
                                    {{ $assets['slug'] }}
                                </td>
                                <td>
                                    {{ $assets['parent_id'] }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th width="1%">
                                <label>
                                    <input type="checkbox" class="minimal checkbox-all">
                                </label>
                            </th>
                            <th class="text-nowrap" width="5%">#</th>
                            <th class="text-nowrap">Tên danh mục</th>
                            <th class="text-nowrap">URL</th>
                            <th class="text-nowrap" width="5%">Danh mục cha</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer text-right">
                <form action="{{ route('categories-imports') }}" method="post">
                    {{ csrf_field() }}
                    <input type="text" name="filename" class="hidden" value="{{ $filename }}">
                    <button type="submit" class="btn btn-primary">Import</button>
                    <button class="btn btn-default">Đóng</button>
                </form>
            </div>
        </div>
        <!-- /.box -->
    </div>
</div>
@endsection
