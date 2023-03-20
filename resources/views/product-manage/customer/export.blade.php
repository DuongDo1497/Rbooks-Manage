<h1>THÔNG TIN KHÁCH HÀNG</h1>
<br>
<table>
	<tbody>
		<tr>
			<th>Mã KH</th>
			<th>Tên KH</th>
			<th>Ngày sinh</th>
			<th>Số điện thoại</th>
			<th>Email</th>
			<th>Địa chỉ</th>
			<th>Nhóm KH</th>
		</tr>
		@foreach($customers as $customer)
		<tr>
			<td>{{ $customer['id'] }}</td>
			<td>{{ $customer['fullname'] }}</td>
			<td>{{ date("d/m/Y", strtotime($customer['birthday'])) }}</td>
			<td>{{ $customer['phone'] }}</td>
			<td>{{ $customer['email'] }}</td>
			<td>
				Địa chỉ: {{ $customer['addresses']->last() == null ? "" : $customer['addresses']->last()->address }}
			</td>
			<td>
				@foreach($customer['groups'] as $group)
					{{ $group->name }}
				@endforeach
			</td>
		</tr>
		@endforeach
	</tbody>
</table>