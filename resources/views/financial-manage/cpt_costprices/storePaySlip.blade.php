<div class="modal fade" id="getFormAdd" role="dialog">
    <form action="{{ route('cpt_gvt_payslip-store', ['id' => $detail->id]) }}?index=true" enctype="multipart/form-data" method="POST">
        @csrf
        <div class="modal-dialog modal-xs">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{ trans('home.Tạo mới phiếu chi') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ trans('home.Ngày chi') }}</label>
                        <input type="date" class="form-control" placeholder="{{ trans('home.Nhập ngày chi') }}" name="date_cost">
                    </div>

                    <div class="row">
                    	<div class="col-md-6">
                    		<div class="form-group">
		                        <label>{{ trans('home.Tổng tiền đã trả (không VAT)') }}</label>
		                        <input type="text" class="form-control total-vat" placeholder="{{ trans('home.Nhập số tiền') }}" name="paided_cost_novat">
		                    </div>
                    	</div>
                    	<div class="col-md-6">
                    		<div class="form-group">
		                        <label>{{ trans('home.Tổng tiền đã trả (có VAT)') }}</label>
		                        <input type="text" class="form-control total-vat" placeholder="{{ trans('home.Nhập số tiền') }}" name="paided_cost_vat">
		                    </div>
                    	</div>
                    </div>

                    <div class="row">
                    	<div class="col-md-6">
                    		<div class="form-group">
		                        <label>{{ trans('home.Nội dung chi') }}</label>
		                        <textarea class="form-control" placeholder="{{ trans('home.Nhập nội dung chi') }}" rows="4" name="content"></textarea>
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