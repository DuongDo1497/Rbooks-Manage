<div class="modal fade report_rate_of_progress" id="getReportLicense" role="dialog">
    <form action="#" method="POST" id="frm">
        {{ csrf_field() }}
        <input type="hidden" name="typereport" value="">
        <div class="modal-dialog modal-xs">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    @if(Auth::user()->roles()->first()->name == 'owner')
                        <h4 class="modal-title">Tiến độ thực hiện <small>(%)</small></h4>
                    @else
                        <h4 class="modal-title">Báo cáo tiến độ <small>(%)</small></h4>
                    @endif
                </div>
                <div class="modal-body">
                    <div class="form-group report_rate">
                        <label>Nhập tiến độ công việc:</label>
                        <input type="text" class="form-control" placeholder="Nhập tiến độ công việc (VD: 10)" name="report">
                    </div>
                    <div class="form-group">
                        <label>Ghi chú:</label>
                        <input type="text" class="form-control" placeholder="Nhập ghi chú (VD: Hoàn thành một phần Task)" name="note">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-create">Báo cáo</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </form>
</div>
