<div class="modal fade" id="getFormAdd" role="dialog">
    <form action="{{ route('create-receipt', ['id' => $detail->id]) }}" enctype="multipart/form-data" method="POST">
        {{ csrf_field() }}
        {{ method_field('put') }}
        <div class="modal-dialog modal-xs">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{ trans('home.Tạo mới phiếu thu') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ trans('home.Ngày thu') }}</label>
                        <input type="date" class="form-control" placeholder="{{ trans('home.Nhập ngày thu') }}" name="date_revenue">
                    </div>

                    <div class="form-group">
                        <label>Số lượng</label>
                        <input type="text" class="form-control" placeholder="Số lượng" name="quantity">
                    </div>

                    <div class="row">
                    	<div class="col-md-6">
                    		<div class="form-group">
		                        <label>{{ trans('home.Tổng tiền đã thu (không VAT)') }}</label>
		                        <input type="text" class="form-control total-vat" placeholder="{{ trans('home.Nhập tổng tiền đã trả (không VAT)') }}" name="dathu_notvat">
		                    </div>
                    	</div>
                    	<div class="col-md-6">
                    		<div class="form-group">
		                        <label>{{ trans('home.Tổng tiền đã thu (có VAT)') }}</label>
		                        <input type="text" class="form-control total-vat" placeholder="{{ trans('home.Nhập tổng tiền đã trả (có VAT)') }}" name="dathu_vat">
		                    </div>
                    	</div>
                    </div>

                    <div class="row">
                    	<div class="col-md-6">
                    		<div class="form-group">
		                        <label>{{ trans('home.Nội dung thu') }}</label>
		                        <textarea class="form-control" placeholder="{{ trans('home.Nhập nội dung thu') }}" rows="4" name="content"></textarea>
		                    </div>
                    	</div>
                    	<div class="col-md-6">
                    		<div class="form-group">
		                        <label>{{ trans('home.Ghi chú') }}</label>
		                        <textarea class="form-control" placeholder="{{ trans('home.Nhập ghi chú') }}" rows="4" name="note"></textarea>
		                    </div>
                    	</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-create">{{ trans('home.Tạo mới') }}</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('home.Đóng') }}</button>
                </div>
            </div>
        </div>
    </form>
</div>
