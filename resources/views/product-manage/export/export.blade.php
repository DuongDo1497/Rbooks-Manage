
<table>
	<thead>
		<tr>
			<td colspan="8">XRB - {{ $exports['order_id'] }}</td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td><b>Công ty TNHH R Books</b></td>
		</tr>
		<tr>
			<td colspan="8">Địa chỉ: L4-42.OT05 (Officetel) , Landmark 4 Vinhomes Central Park, 720A Điện Biên Phủ, P. 22, Q. Bình Thạnh, Tp HCM</td>
		</tr>
		<tr>
			<td><b>Phone: </b>028 3636 4405 / 08 4966 4005</td>
		</tr>
		<tr>
			<td colspan="7">PHIẾU XUẤT KHO</td>
		</tr>
		<tr>
			<td colspan="7">NGÀY {{$exports['day_order']}} THÁNG {{$exports['month_order']}} NĂM {{$exports['year_order']}}</td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td>Đơn vị mua hàng: {{$exports['donvi']}}</td>
		</tr>
		<tr>
			<td colspan="7">Địa chỉ: {{$exports['diachi']}}</td>
		</tr>
		<tr>
			<td colspan="2">Mã số thuế: </td>
			<td>Số điện thoại: {{$exports['phone']}}</td>
		</tr>
		<tr>
			<td>Email: {{$exports['email']}}</td>
		</tr>
		<tr>
			<td colspan="2">Hình thức thanh toán: TM/ CK</td>
			<td colspan="3">Đã thanh toán: 0 đồng</td>
			<td>Còn lại: {{ number_format($exports['total_all']) }} đồng</td>
		</tr>
		<tr>
			<td colspan="2">Mã xuất kho: {{ $exports['warehouse_export_code'] }}</td>
			<td colspan="2">Mã đơn hàng: {{ $exports['order_id'] }}</td>
		</tr>
		<tr>
			<td colspan="2">Chứng từ: Phiếu xuất kho</td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td colspan="2">Nhân viên: {{ $exports['saler'] }}</td>
		</tr>
		<tr>
			<td ></td>
		</tr>
	</thead>

	<tbody>
		<tr>
			<th style="background-color: #E0F2F7;">STT</th>
			<th style="background-color: #E0F2F7;">TÊN HÀNG HÓA</th>
			<th style="background-color: #E0F2F7;">ĐVT</th>
			<th style="background-color: #E0F2F7;">Số lượng</th>
			<th style="background-color: #E0F2F7;">Giá bìa</th>
			<th style="background-color: #E0F2F7;">CK(%)</th>
			<th style="background-color: #E0F2F7;">Giá Đã CK chưa VAT</th>
			<th style="background-color: #E0F2F7;">THÀNH TIỀN</th>
		</tr>
		@php
		$i = 1
		@endphp
		@foreach($exports['products'] as $value)
		<tr>
			<td>{{ $i }}</td>
			<td >{{ $value['name'] }}</td>
			<td>Cuốn</td>
			<td>{{ $value['quantity'] }}</td>
			<td>{{ number_format($value['price']) }}</td>
			<td>{{ number_format($value['discount']) }} %</td>
			<td>{{ number_format($value['truocthueproduct']) }}</td>
			<td>{{ number_format($value['total_product']) }}</td>
		</tr>
		@php
		$i++
		@endphp
		@endforeach
		<tr>
			<td colspan="3"></td>
			<td>{{ $exports['quantity'] }}</td>
		</tr>
		<tr>
			<td colspan="2">Cộng tiền hàng trước thuế</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td>{{ number_format($exports['truocthue']) }}</td>
		</tr>
		<tr>
			<td colspan="2">Thuế suất 5%</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td>{{ number_format($exports['tax'])}}</td>
		</tr>
		<tr>
			<td colspan="2">Tổng cộng thanh toán đã bao gồm VAT</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td>{{ number_format($exports['sub_total'] - $exports['discount']) }}</td>
		</tr>
		<tr>
			<td colspan="2">Phí giao nhận hàng</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td>{{ number_format($exports['ship']) }}</td>
		</tr>
		@if($exports['gift_fee'] == 20000)
		<tr>
			<td colspan="2">Phí gói quà</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td>{{ number_format($exports['gift_fee']) }}</td>
		</tr>
		@endif
		<tr>
			<td colspan="2">Tổng tiền thanh toán</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td>{{ number_format($exports['total']) }}
			</td>
		</tr>
		<tr>
			<td colspan="8">Số tiền (viết bằng chữ):</td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td>Người đề nghị Người lập</td>
			<td colspan="2">Người duyệt</td>
			<td colspan="2">Kế toán</td>
			<td colspan="2">Người nhận hàng</td>
		</tr>
		<tr>
			<td></td>
			<td>(Ký, họ tên) (Ký, họ tên)</td>
			<td colspan="2">(Ký, họ tên)</td>
			<td colspan="2">(Ký, họ tên)</td>
			<td colspan="2">(Ký, họ tên)</td>
		</tr>
	</tfoot>
</table>