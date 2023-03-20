<div class="col-md-8">
	<div class="box box-primary">
        <div class="box-header with-border">
            <h2 class="box-title">{{ trans('home.Chi tiết dự án') }}</h2>
        </div>
        <div class="box-body">
        	<div class="row">
        		<div class="col-md-4 clearfix">
        			<div class="detail-title"><b>{{ trans('home.Tên dự án') }}:</b></div>
        			<div class="detail-content">{{ $detailTask->taskname }}</div>
        		</div>
        		<div class="col-md-4 clearfix">
        			<div class="detail-title"><b>{{ trans('home.Loại dự án') }}:</b></div>
        			<div class="detail-content">{{ $detailTask->tasktype }}</div>
        		</div>
        		<div class="col-md-4 clearfix">
        			<div class="detail-title"><b>{{ trans('home.Dự án') }}:</b></div>
        			<div class="detail-content">{{ $detailTask->project }}</div>
        		</div>
        	</div>

        	<div class="row">
        		<div class="col-md-4 clearfix">
        			<div class="detail-title"><b>{{ trans('home.Ngày bắt đầu') }}:</b></div>
        			<div class="detail-content">{{ date("d/m/Y", strtotime($detailTask->fromdate)) }}</div>
        		</div>
        		<div class="col-md-4 clearfix">
        			<div class="detail-title"><b>{{ trans('home.Ngày kết thúc') }}:</b></div>
        			<div class="detail-content">{{ date("d/m/Y", strtotime($detailTask->todate)) }}</div>
        		</div>
        		<div class="col-md-4 clearfix">
        			<div class="detail-title"><b>{{ trans('home.Tổng ngày') }}:</b></div>
        			<div class="detail-content">{{ $detailTask->numday }}</div>
        		</div>
        	</div>

        	<div class="row">
        		<div class="col-md-4 clearfix">
        			<div class="detail-title" style="width: 20%;"><b>{{ trans('home.Ghi chú') }}:</b></div>
        			<div class="detail-content" style="width: 80%;">{{ $detailTask->description }}</div>
        		</div>
        		<div class="col-md-4 clearfix">
        			<div class="detail-title" style="width: 20%;"><b>{{ trans('home.Tiến độ') }}:</b></div>
        			<div class="detail-content" style="width: 80%;">
        				<div class="progress" style="border-radius: 15px; height: 12px; margin: 4px 0;">
							<div class="progress-bar" role="progressbar" aria-valuenow="70"
							aria-valuemin="0" aria-valuemax="100" style="width:{{ $detailTask->progress }}%; line-height: 12px; background-color: #3d5c5c;">
							{{ round($detailTask->progress) }}%
							</div>
						</div>
        			</div>
        		</div>
        		<div class="col-md-4 clearfix">
        			<div class="detail-title"><b>{{ trans('home.Trạng thái') }}:</b></div>
        			<div class="detail-content">
        				@if($detailTask->status == 1)
        				<b>User khởi tạo</b>
        				@elseif($detailTask->status == 2)
        				<b>Leader duyệt</b>
        				@elseif($detailTask->status == 3)
        				<b>CEO duyệt</b>
        				@elseif($detailTask->status == 4)
        				<b>CEO phân công</b>
        				@elseif($detailTask->status == 5)
        				<b>Leader nhận</b>
        				@elseif($detailTask->status == 6)
        				<b>Leader phân công</b>
        				@elseif($detailTask->status == 7)
        				<b>User nhận</b>
        				@elseif($detailTask->status == 8)
        				<b>User báo cáo</b>
        				@elseif($detailTask->status == 9)
        				<b>Leader duyệt báo cáo</b>
        				@elseif($detailTask->status == 10)
        				<b>Leader báo cáo</b>
        				@elseif($detailTask->status == 11)
        				<b>CEO duyệt báo cáo</b>
        				@else
        				<b>CEO phân công BP khác</b>
        				@endif
        			</div>
        		</div>
        	</div>
        </div>
	</div>
</div>