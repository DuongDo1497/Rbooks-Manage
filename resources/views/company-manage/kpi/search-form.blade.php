<div class="box box-primary">
    <form action="{{ route('kpis-index') }}">
        <div class="box-header with-border">
            <h3 class="box-title">QUẢN LÝ KPI</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Nhân viên:</label> 
                                <select class="form-control select2" name="searchField" id="searchFields" data-minimum-results-for-search="Infinity">
                                    @if(isset($employee))
                                        <option value="{{ $employee->id }}">{{ $employee->fullname }}</option>
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->fullname }}</option>
                                        @endforeach
                                    @else
                                        <option value="">Chọn</option>
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->fullname }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Bắt đầu:</label>
                                        <input type="date" class="form-control" name="fromdate" value="{{ $fromdate }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Kết thúc:</label>
                                        <input type="date" class="form-control" name="todate" value="{{ $todate }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label>&nbsp;</label><br>
                                <button class="btn btn-primary btn-search" style="width: 45%;">Lọc task việc</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>