<h1>THÔNG TIN CHUYỂN KHO</h1>
<br>
<table>
	<tbody>
		<tr>
			<th>Mã chuyển kho</th>
			<th>Kho xuất ra</th>
			<th>Kho nhập vào</th>
			<th>Tổng số lượng</th>
			<th>Đơn giá</th>
			<th>Thành tiền</th>
			<th>Tổng thành tiền</th>
			<th>Ghi chú</th>
			<th>Tình trạng</th>
			<th>Ngày lập</th>
			<th>Tình trạng</th>
		</tr>
		@foreach($transfers as $transfer)
		@php
		dd($transfer)
		@endphp
		<tr>
			<td>{{ $transfer['id'] }}</td>
			<td>{{ $transfer['fullname'] }}</td>
			<td>{{ $transfer['birthday'] }}</td>
			<td>{{ $transfer['phone'] }}</td>
			<td>{{ $transfer['email'] }}</td>
			<td>{{ $transfer['address'] }}</td>
		</tr>
		@endforeach
	</tbody>
</table>