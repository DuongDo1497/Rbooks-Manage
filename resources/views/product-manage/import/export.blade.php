<table>
	<thead>
		<tr>
			<td colspan="7">NRB - {{$imports['import_code']}}</td>
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
			<td colspan="6">PHIẾU NHẬP KHO</td>
		</tr>
		<tr>
			<td colspan="6"></td>
		</tr>
		<tr>
			<td colspan="6">I. Ngày nhập kho: {{ date("d/m/Y", strtotime($imports['import_date'])) }}</td>
		</tr>
		<tr>
			<td colspan="2">Nhà cung cấp: {{$imports['supplier']}}</td>
		</tr>
		<tr>
			<td colspan="2">Nhập kho: {{$imports['warehousename']}}</td>
		</tr>
		<tr>
			<td colspan="3">II. Mã nhập kho: {{$imports['warehouse_import_code']}}</td>
		</tr>
		<tr>
			<td colspan="3">Chứng từ: {{$imports['note']}}</td>
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
			<th>CK(%)</th>
			<th>Đơn giá</th>
			<th>THÀNH TIỀN</th>
		</tr>
		@php
		$i = 1
		@endphp
		@foreach($imports['products'] as $value)
		<tr>
			<td>{{$i}}</td>
			<td>{{ $value['name'] }}</td>
			<td>{{$imports['unit']}}</td>
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
			<td>{{ $imports['quantity'] }}</td>
		</tr>
		<tr>
			<td colspan="2">Tổng tiền chiết khấu:</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td>{{ number_format($sum_total) }}</td>
		</tr>
		<tr>
			<td colspan="2">Tổng tiền:</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td>{{ number_format($sub_total) }}</td>
		</tr>
		<tr>
			<td colspan="2">Tổng thành tiền:</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td>{{ number_format($imports['total']) }}</td>
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