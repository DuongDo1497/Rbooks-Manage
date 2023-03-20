<div class="modal fade" id="getEdit" role="dialog">
    <form action="" id="getFormEdit" enctype="multipart/form-data" method="POST">
        {{ csrf_field() }}
        {{ method_field('put') }}
        <div class="modal-dialog modal-xs">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Chỉnh sửa phiếu chi</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ trans('home.Ngày chi') }}</label>
                        <input type="date" class="form-control date_cost" name="date_cost" value="">
                    </div>

                    <div class="row">
                    	<div class="col-md-6">
                    		<div class="form-group">
		                        <label>{{ trans('home.Tổng tiền đã trả (không VAT)') }}</label>
		                        <input type="text" class="form-control paided_cost_novat" name="paided_cost_novat" value="">
		                    </div>
                    	</div>
                    	<div class="col-md-6">
                    		<div class="form-group">
		                        <label>{{ trans('home.Tổng tiền đã trả (có VAT)') }}</label>
		                        <input type="text" class="form-control paided_cost_vat" name="paided_cost_vat" value="">
		                    </div>
                    	</div>
                    </div>

                    <div class="row">
                    	<div class="col-md-6">
                    		<div class="form-group">
		                        <label>{{ trans('home.Nội dung chi') }}</label>
		                        <textarea class="form-control content" rows="4" name="content"></textarea>
		                    </div>
                    	</div>
                    	<div class="col-md-6">
                    		<div class="form-group">
		                        <label>{{ trans('home.Ghi chú') }}</label>
		                        <textarea class="form-control note" rows="4" name="note"></textarea>
		                    </div>
                    	</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-create">{{ trans('home.Lưu') }}</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('home.Đóng') }}</button>
                </div>
            </div>
        </div>
    </form>
</div>