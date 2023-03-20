<h1>DANH SÁCH SẢN PHẨM</h1>
<table>
	<tbody>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td colspan="12" style="background-color: #01DF74;">Số lượng</td>
		</tr>
		<tr>
			<th style="background-color: #01DF74;">STT</th>
			<th style="background-color: #01DF74;">Mã sách</th>
			<th style="background-color: #01DF74;">Tên sách</th>
			<th style="background-color: #01DF74;">Giá bán</th>
			<th style="background-color: #01DF74;">Giá KM</th>

			<th style="background-color: #01DF74;">Tổng</th>

			<th style="background-color: #01DF74;">Sắp PH</th>
			<th style="background-color: #01DF74;">RB-VH</th>
			<th style="background-color: #01DF74;">RB-TĐ</th>
			<th style="background-color: #01DF74;">TikiShop</th>
			<th style="background-color: #01DF74;">Hàng Lỗi</th>
			<th style="background-color: #01DF74;">FAHASA</th>
			<th style="background-color: #01DF74;">TikiTD</th>
			<th style="background-color: #01DF74;">Shopee</th>
			<th style="background-color: #01DF74;">Phương Nam</th>
			<th style="background-color: #01DF74;">Vinabook</th>
			<th style="background-color: #01DF74;">Song Phát</th>
			<th style="background-color: #01DF74;">Tổng giá bán</th>
			<th style="background-color: #01DF74;">Tổng giá KM</th>
		</tr>
		@php
		$i = 1
		@endphp
		@foreach($products as $product)
		@php
			$sum = $product['quantityRBVH'] + $product['quantityRBTD'] + $product['quantityTikiShop'] + $product['quantityHL'] + $product['quantityFHS'] + $product['quantityTikiTD'] + $product['quantityShopee'] + $product['quantityPN'] + $product['quantityVNB'] + $product['quantitySP']
		@endphp
		<tr>
			<td>{{ $i }}</td>
			<td>{{ $product['id'] }}</td>
			<td>{{ $product['name'] }}</td>
			<td>{{ $product['cover_price'] }}</td>
			<td>{{ $product['sale_price'] }}</td>

			<td>{{ $sum }}</td>

			<td>{{ $product['quantitySPH'] }}</td>
			<td>{{ $product['quantityRBVH'] }}</td>
			<td>{{ $product['quantityRBTD'] }}</td>
			<td>{{ $product['quantityTikiShop'] }}</td>
			<td>{{ $product['quantityHL'] }}</td>
			<td>{{ $product['quantityFHS'] }}</td>
			<td>{{ $product['quantityTikiTD'] }}</td>
			<td>{{ $product['quantityShopee'] }}</td>
			<td>{{ $product['quantityPN'] }}</td>
			<td>{{ $product['quantityVNB'] }}</td>
			<td>{{ $product['quantitySP'] }}</td>
			<td>{{ $sum * $product['cover_price'] }}</td>
			<td>{{ $sum * $product['sale_price'] }}</td>
		</tr>
		@php
		$i++
		@endphp
		@endforeach
	</tbody>
</table>