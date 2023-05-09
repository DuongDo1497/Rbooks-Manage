<div class="box box-primary">
    <div class="nav-tabs-custom" id="product-info-container">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('home.Thông tin sản phẩm') }}</h3>
        </div>
    
        <div class="box-body">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#product-general" data-toggle="tab">{{ trans('home.Thông tin chung') }}</a></li>
                <li><a href="#product-inventory" data-toggle="tab">{{ trans('home.Kho hàng') }}</a></li>
                <li><a href="#product-attribute" data-toggle="tab">{{ trans('home.Thuộc tính') }}</a></li>
            </ul>
    
            <div class="tab-content">
                <div class="tab-pane active" id="product-general">
                    <div class="form-group">
                        <label>{{ trans('home.Giá sản phẩm') }}</label>
                        <div class="input-group addon-right">
                            <input type="text" class="form-control" name="cover_price" value="{{ $model->cover_price }}">
                            <span class="input-group-addon">{{ trans('home.đồng') }}</span>
                        </div>
                        @if($errors->has('cover_price'))<span class="text-danger">{{ $errors->first('cover_price') }}</span>@endif
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Giá khuyến mãi') }}</label>
                        <div class="input-group addon-right">
                            <input type="text" class="form-control" name="sale_price" value="{{ $model->sale_price }}">
                            <span class="input-group-addon">{{ trans('home.đồng') }}</span>
                        </div>
                    </div>
                </div>
    
                <div class="tab-pane" id="product-attribute">
                    <div class="form-group">
                        <label>{{ trans('home.SKU sản phẩm') }}</label>
                        <input type="text" class="form-control" name="input_sku" value="{{ $model->sku }}">
                    </div>
                    <div class="form-group">
                        <label>ISBN</label>
                        <input type="number" class="form-control" name="isbn" value="{{ $model->isbn }}">
                    </div>
                    <div class="form-group">
                        <label>Barcode</label>
                        <input type="number" class="form-control" name="barcode" value="{{ $model->barcode }}">
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Tác giả') }}</label>
                        <input type="text" class="form-control" name="input_author" value="{{ $model->author }}">
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Số trang') }}</label>
                        <div class="input-group addon-right">
                            <input type="text" class="form-control" name="input_paper" value="{{ $model->paper }}">
                            <span class="input-group-addon">{{ trans('home.Trang') }}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Kích thước (Dài x Rộng)') }}</label>
                        <div class="input-group addon-right">
                            <input type="text" class="form-control" name="input_size" value="{{ $model->size }}">
                            <span class="input-group-addon">cm</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Năm xuất bản') }}</label>
                        <input type="text" class="form-control" name="input_year" value="{{ $model->publishing_year }}">
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Nhà xuất bản') }}</label>
                        <input type="text" class="form-control" name="input_pub_company" value="{{ $model->pub_company }}">
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Nhà phát hành') }}</label>
                        <input type="text" class="form-control" name="input_publisher" value="{{ $model->publisher }}">
                    </div>
                    <div class="form-group">
                        <label>{{ trans('home.Nhà phát hành không dấu') }}</label>
                        <input type="text" class="form-control" name="input_publisherEnglish" value="{{ $model->publisherEnglish }}">
                    </div>
                    <div class="form-group">
                        <label>Định lượng</label>
                        <input type="text" class="form-control" name="quantitative" id="quantitative" value="{{ $model->quantitative }}">
                    </div>
                    <div class="form-group">
                        <label>Quy cách đóng gói</label>
                        <input type="text" class="form-control" name="packing" id="packing" value="{{ $model->packing }}">
                    </div>
                </div>
    
                <div class="tab-pane" id="product-inventory">
                    @foreach($warehouses as $warehouse)
                    <h4>{{ $warehouse->name }}</h4>
                    <div class="form-group row">
                        @if(empty($model->productwarehouses->where('product_id', $model->id)->where('warehouse_id', $warehouse->id)->first()))
                            <div class="col-md-6">
                            <label>SKU</label>
                            <input type="text" name="{{ $warehouse->name }}" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>{{ trans('home.Số lượng') }}</label>
                                <input type="text" name="quantity_{{ $warehouse->id }}" class="form-control" value="0">
                            </div>
                        @else
                        <div class="col-md-6">
                            <label>SKU</label>
                            <input type="text" name="{{ $warehouse->name }}" class="form-control" value="{{ $model->productwarehouses->where('product_id', $model->id)->where('warehouse_id', $warehouse->id)->first()->sku }}">
                        </div>
                        <div class="col-md-6">
                            <label>{{ trans('home.Số lượng') }}</label>
                            <input type="text" name="quantity_{{ $warehouse->id }}" class="form-control" value="{{ $model->productwarehouses->where('product_id', $model->id)->where('warehouse_id', $warehouse->id)->first()->quantity }}">
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>