<div class="modal fade" id="getFormAdd" role="dialog">
    <form action="{{ route('debts-store') }}" enctype="multipart/form-data" method="POST">
        {{ csrf_field() }}
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Tạo mới phiếu chuyển kho</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Nhà cung cấp</label>
                            <select class="form-control" name="supplier_id">
                                <option>Chọn nhà cung cấp</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Phiếu nhập hàng</label>
                            <select class="form-control select2" name="import_id">
                                <option>Chọn phiếu nhập hàng</option>
                                @foreach($imports as $import)
                                    <option value="{{ $import->id }}">{{ $import->import_code }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Thời gian công nợ</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" name="datetime" class="form-control pull-right" id="reservation">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Ghi chú</label>
                            <textarea class="form-control" name="note" rows="5"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Tạo mới</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </form>
</div>