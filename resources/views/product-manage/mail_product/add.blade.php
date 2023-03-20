<div class="modal fade" id="getFormAdd" role="dialog">
    <form action="{{ route('mail_products-store') }}?index=true" enctype="multipart/form-data" method="POST">
        {{ csrf_field() }}
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Tạo mới qui trình gửi mail</h4>
                </div>
                <div class="modal-body box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tiêu đề giới thiệu</label>
                                <input type="text" class="form-control" placeholder="Nhập tiêu đề giới thiệu" name="name">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Sách hiện tại</label>
                                <select class="form-control select2" name="product_id">
                                    <option>Chọn</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Nội dung giới thiệu</label>
                        <textarea id="description" name="content" rows="10"></textarea>
                        @if($errors->has('content'))<span class="text-danger">{{ $errors->first('content') }}</span>@endif
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Sách kế tiếp gửi mail</label>
                                <select class="form-control select2" name="next_product_id">
                                    <option>{{ trans('home.Chọn') }}</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Số ngày gửi tiếp theo</label>
                                <input type="text" class="form-control" placeholder="Nhập số ngày gửi" name="aftersendday">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Thứ tự gửi mail</label>
                                <input type="text" class="form-control" placeholder="Nhập thứ tự" name="ordernum">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-create">Tạo mới</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </form>
</div>