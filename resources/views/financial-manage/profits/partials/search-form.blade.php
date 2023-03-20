<style type="text/css">
    .box-group .box{
        width: 100%;
        float: none;
    }
</style>

<div class="box-group clearfix">   

    <div class="row">
        <div class="col-md-6">
            <div class="box box-default">
                <form action="{{ route('profit-index') }}">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ trans('home.Xem theo') }}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ trans('home.Năm') }}</label>
                                    <select id="year" class="form-control select2" name="">
                                        <option value="">2019</option>
                                        <option value="">2018</option>
                                        <option value="">2017</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ trans('home.Tháng') }}</label>
                                    <select id="month" class="form-control select2" name="">
                                        <option value="">2019</option>
                                        <option value="">2018</option>
                                        <option value="">2017</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer text-right">
                        <button class="btn btn-primary btn-search">{{ trans('home.Tìm kiếm') }}</button>
                        <a href="{{ route('profit-index') }}" class="btn btn-default">{{ trans('home.Xóa form') }}</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-default">
                <form action="{{ route('profit-index') }}">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ trans('home.Tùy chọn') }}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{ trans('home.Tùy chọn') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" name="datetime" class="form-control pull-right" id="reservation">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer text-right">
                        <button class="btn btn-primary btn-search">{{ trans('home.Xem') }}</button>
                        <button class="btn btn-default">{{ trans('home.Xuất excel') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</div>   