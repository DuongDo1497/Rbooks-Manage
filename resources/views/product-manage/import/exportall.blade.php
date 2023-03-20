<h1>Danh sách phiếu xuất kho</h1>
<br>
<table>
	<tbody>
		<tr>
			<th>Mã nhập kho</th>
			<th>Mã phiếu nhập</th>
			<th>Kho nhập</th>
			<th>Ngày đặt</th>
			<th>Ngày nhập</th>
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
		@foreach($imports_all as $imports)
			@foreach($imports['products'] as $product)
			<tr>
				<td>{{ isset($imports['import_code']) ? $imports['import_code'] : "" }}</td>
				<td>{{ isset($imports['warehouse_import_code']) ? $imports['warehouse_import_code'] : "" }}</td>
				<td>{{ isset($imports['warehouses']['name']) ? $imports['warehouses']['name'] : "" }}</td>
				<td>{{ isset($imports['created_at']) ? date("d-m-Y", strtotime($imports['created_at'])) : "" }}</td>
				<td>{{ isset($imports['created_at']) ? date("d-m-Y", strtotime($imports['created_at'])) : "" }}</td>
				<td>{{ isset($imports['updated_at']) ? date("d-m-Y", strtotime($imports['updated_at'])) : "" }}</td>
				<td>{{ isset($imports['deleted_at']) ? date("d-m-Y", strtotime($imports['deleted_at'])) : "" }}</td>
				<td></td>
				<td>{{ $product['sku'] }}</td>
				<td>{{ $product['name'] }}</td>
				<td>{{ $product['pivot']['quantity'] }}</td>
				<td>{{ $product['pivot']['price'] }}</td>
				<td>{{ $product['pivot']['total'] / 1.05 }}</td>
				<td>{{$product['pivot']['total'] / 1.05 * 0.05 }}</td>
				<td>{{ ($product['pivot']['total'] / 1.05) + (($product['pivot']['total'] / 1.05) * 0.05) }}</td>
				<!-- <td>{{ number_format($imports->ship_total) }}</td>
				<td>{{ number_format($imports->gift_fee) }}</td>
				<td>{{ number_format($imports->total_all) }}</td> --> 
			</tr>
			@endforeach
		@endforeach
	</tbody>
</table>