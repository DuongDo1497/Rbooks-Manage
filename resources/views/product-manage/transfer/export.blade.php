<table>
	<thead>
		<tr>
			<td colspan="7">CKRB - {{ $transfer['id'] }}</td>
		</tr>
		<tr>
			<td colspan="2">Công ty TNHH R Books</td>
		</tr>
		<tr>
			<td colspan="7">Địa chỉ: L4-42.OT05 (Officetel) , Landmark 4 Vinhomes Central Park, 720A Điện Biên Phủ, P. 22, Q. Bình Thạnh, Tp HCM</td>
		</tr>
		<tr>
			<td colspan="2">Phone: 028 3636 4405 / 08 4966 4005</td>
		</tr>
		<tr>
			<td colspan="7">PHIẾU CHUYỂN KHO</td>
		</tr>
		<tr>
			<td colspan="7"></td>
		</tr>
		<tr>
			<td colspan="7">I. Ngày chuyển kho: {{ date("d-m-Y", strtotime($transfers['date_transfer'])) }}</td>
		</tr>
		<tr>
			<td colspan="2">Kho xuất ra: {{ $transfers['warehousefrom'] }}</td>
		</tr>
		<tr>
			<td colspan="2">Kho nhập vào: {{ $transfers['warehouseto'] }}</td>
		</tr>
		<tr>
			<td colspan="3">II. Mã chuyển kho: {{ $transfers['code_transfer'] }} </td>
		</tr>
		<tr>
			<td colspan="3">Chứng từ: {{ $transfers['note'] }}</td>
		</tr>
		<tr>
			<td></td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<th>STT</th>
			<th>TÊN HÀNG HÓA</th>
			<th>ĐVT</th>
			<th>Số lượng</th>
			<th>Chiết khấu</th>
			<th>Đơn giá</th>
			<th>THÀNH TIỀN</th>
		</tr>
		@php
		$i = 1
		@endphp
		@foreach($transfers['products'] as $value)
		<tr>
			<td>{{$i}}</td>
			<td>{{ $value['name'] }}</td>
			<td>{{ $transfers['unit'] }}</td>
			<td>{{ $value['quantity'] }}</td>
			<td>{{ $value['discount'] }}</td>
			<td>{{ number_format($value['price']) }}</td>
			<td>{{ number_format($value['total']) }}</td>
		</tr>
		@php
		$i++
		@endphp
		@endforeach
		<tr>
			<td colspan="3"></td>
			<td>{{ $transfer['quantity'] }}</td>
		</tr>
		<tr>
			<td colspan="2">Tổng thành tiền:</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td>{{ number_format($transfers['total']) }}</td>
		</tr>
		<tr>
			<td colspan="7">Số tiền (viết bằng chữ):</td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<th></th>
			<th>Người đề nghị Người lập</th>
			<th>Người duyệt</th>
			<th></th>
			<th>Người nhận hàng</th>
		</tr>
		<tr>
			<td></td>
			<td>(Ký, họ tên) (Ký, họ tên)</td>
			<td>(Ký, họ tên)</td>
			<td></td>
			<td>(Ký, họ tên)</td>
		</tr>
	</tbody>
</table>