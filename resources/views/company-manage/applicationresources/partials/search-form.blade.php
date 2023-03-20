<div class="box box-search">
    <form action="{{ route('applicationresources-index') }}">
        <div class="box-header with-border">
            <h3 class="box-title">QUẢN LÝ TRANG TRUY CẬP</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-xs-4">
                    <label>Route Prefix :</label>
                    <select id="searchprefix" class="form-control" name="searchprefix">
                        <option value=""></option>
                        @foreach($listprefix as $key=>$value)
                            @if( $value->prefix == $searchprefix )
                                <option value="{{ $value->prefix }}" selected>{{ $value->prefix }}</option>
                            @else
                                <option value="{{ $value->prefix }}">{{ $value->prefix }}</option>
                            @endif
                        @endforeach                      
                    </select>
                </div>
                <div class="col-xs-3">
                    <label>File name :</label>
                    <input type="text" class="form-control" name="searchfilename" value="{{ $searchfilename }}">
                </div>
                <div class="col-xs-3">
                    <label>&nbsp;</label><br>
                    <button class="btn btn-primary btn-search" style="width: 45%;">Tìm kiếm</button>
                </div>                
            </div>
            <!-- /.row -->
        </div>

    </form>
</div>