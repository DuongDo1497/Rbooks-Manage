<h1>THÔNG TIN KHÁCH HÀNG</h1>
<br>
<table>
	<tbody>
		<tr>
			<th>Mã khách hàng</th>
			<th>Tên Khách hàng</th>
			<th>Ngày sinh</th>
			<th>Số điện thoại</th>
			<th>Email</th>
			<th>Địa chỉ</th>
		</tr>
		@foreach($customers as $customer)
		<tr>
			<td>{{ $customer['id'] }}</td>
			<td>{{ $customer['fullname'] }}</td>
			<td>{{ $customer['birthday'] }}</td>
			<td>{{ $customer['phone'] }}</td>
			<td>{{ $customer['email'] }}</td>
			<td>{{ $customer['address'] }}</td>
		</tr>
		@endforeach
	</tbody>
</table>