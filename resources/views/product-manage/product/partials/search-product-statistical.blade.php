<div class="box box-search">
    <form action="">
        <input id="product_statistical_search" name="search" type="hidden"/>
        <div class="box-header">
            <h1>
                {{ trans($title->heading) }}
                <span>RBooks Corp</span>
            </h1>
        </div>
        
        <div class="box-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label><b>Tìm kiếm</b></label>
                        <select hidden="true" class="search-code select2 form-control" id="input-search-product">
                            @if(isset($product))
                                <option value="{{$product->id}}" selected="selected">{{$product->name}}</option>
                            @endif
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Lọc theo thời gian <small class="text-danger">(chọn mốc thời gian)</small></label>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        From
                                    </div>
                                    <input type="date" name="from_date" class="form-control" value="{{request()->from_date}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        To
                                    </div>
                                    <input type="date" name="to_date" class="form-control" value="{{request()->to_date}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Số lần Nhập/Xuất</label>
                            <div class="requests" style="display: flex">
                                <input type="text" class="form-control" name="number" value="{{ isset($product) ? $product->imports->count() : 0 }}" disabled="">
                                <input type="text" class="form-control" name="number" value="{{ isset($product) ? $product->exports->count() : 0 }}" disabled="">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <label>Số lượng Nhập/Xuất</label>
                            <div class="quantity" style="display: flex">
                                <input type="text" class="form-control" name="number" value="{{ isset($product) ? $product->imports->sum('quantity') : 0 }}" disabled="">
                                <input type="text" class="form-control" name="number" value="{{ isset($product) ? $product->exports->sum('quantity') : 0 }}" disabled="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="box-footer text-right">
            <button class="btn btn-primary btn-search">{{ trans('home.Tìm kiếm') }}</button>
            <a href="#" class="btn btn-primary btn-delete">{{ trans('home.Xóa') }} form</a>
        </div>
    </form>
</div>
