<h1>Danh sách phiếu xuất kho</h1>
<br>
<table>
	<tbody>
		<tr>
			<th>Mã xuất kho</th>
			<th>Mã phiếu xuất</th>
			<th>Kho xuất</th>
			<th>Ngày đặt</th>
			<th>Ngày xuất kho</th>
			<th>Ngày hoàn thành</th>
			<th>Ngày hủy</th>
			<th>Xuất VAT</th>
			<th>SKU</th>
			<th>Tên sản phẩm</th>
			<th>SL bán</th>
			<th>Đơn giá</th>
			<th>Giá đã CK chưa VAT</th>
			<th>Thuế xuất 5%</th>
			<th>Tổng cộng thanh toán bao gồm VAT</th>
			<!-- <th>Phí vận chuyển</th>
			<th>Phí gói quà</th>
			<th>Thành tiền</th>
			<th>Tổng tiền thanh toán</th> -->
		</tr>
		@foreach($exports_all as $exports)
			@foreach($exports['products'] as $product)
			<tr>
				<td>{{ isset($exports['export_code']) ? $exports['export_code'] : "" }}</td>
				<td>{{ isset($exports['warehouse_export_code']) ? $exports['warehouse_export_code'] : "" }}</td>
				<td>{{ isset($exports['warehouses']['name']) ? $exports['warehouses']['name'] : "" }}</td>
				<td>{{ isset($exports['created_at']) ? date("d-m-Y", strtotime($exports['created_at'])) : "" }}</td>
				<td>{{ isset($exports['created_at']) ? date("d-m-Y", strtotime($exports['created_at'])) : "" }}</td>
				<td>{{ isset($exports['updated_at']) ? date("d-m-Y", strtotime($exports['updated_at'])) : "" }}</td>
				<td>{{ isset($exports['deleted_at']) ? date("d-m-Y", strtotime($exports['deleted_at'])) : "" }}</td>
				<td></td>
				<td>{{ $product['sku'] }}</td>
				<td>{{ $product['name'] }}</td>
				<td>{{ $product['pivot']['quantity'] }}</td>
				<td>{{ $product['pivot']['price'] }}</td>
				<td>{{ $product['pivot']['total'] / 1.05 }}</td>
				<td>{{$product['pivot']['total'] / 1.05 * 0.05 }}</td>
				<td>{{ ($product['pivot']['total'] / 1.05) + (($product['pivot']['total'] / 1.05) * 0.05) }}</td>
				<!-- <td>{{ number_format($exports->ship_total) }}</td>
				<td>{{ number_format($exports->gift_fee) }}</td>
				<td>{{ number_format($exports->total_all) }}</td> --> 
			</tr>
			@endforeach
		@endforeach
	</tbody>
</table>