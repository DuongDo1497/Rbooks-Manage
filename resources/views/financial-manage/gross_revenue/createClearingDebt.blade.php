<div class="modal fade" id="getClearingDebt" role="dialog">
    <form action="{{ route('clearing_debt-store', request()->id) }}" enctype="multipart/form-data" method="POST">
        @csrf
        <div class="modal-dialog modal-xs" id="information">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Tạo mới phiếu cấn trừ công nợ</h4>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label>Số lượng hàng trả lại <small class="text-danger">(nếu có)</small></label>
                        <input type="text" class="form-control" placeholder="Số lượng hàng trả lại" name="sl_tralai">
                    </div>

                    <div class="row">
                    	<div class="col-md-6">
                    		<div class="form-group">
		                        <label>Tổng tiền cấn trừ (không VAT)</label>
		                        <input type="text" class="form-control total-vat" placeholder="Nhập tổng tiền cấn trừ (không VAT)" name="clearing_novat">
		                    </div>
                    	</div>
                    	<div class="col-md-6">
                    		<div class="form-group">
		                        <label>Tổng tiền cấn trừ (có VAT)</label>
		                        <input type="text" class="form-control total-vat" placeholder="Nhập tổng tiền cấn trừ (có VAT)" name="clearing_vat">
		                    </div>
                    	</div>
                    </div>

                    <div class="row">
                    	<div class="col-md-6">
                    		<div class="form-group">
		                        <label>Lý do</label>
		                        <textarea class="form-control" placeholder="Nhập lý do cấn trừ" rows="4" name="reason"></textarea>
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
