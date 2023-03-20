<h1>DANH SÁCH ĐƠN HÀNG</h1>
<br>
<table>
    <tbody>
        <tr>
            <th>Mã đơn hàng</th>
            <th>Tên KH</th>
            <th>Kho xuất</th>
            <th>Ngày đặt</th>
            <th>SKU</th>
            <th>Tên sản phẩm</th>
            <th>SL bán</th>
            <th>Đơn giá</th>
            <th>Tổng cộng thanh toán bao gồm VAT</th>
        </tr>
        @foreach($orders_all as $orders)
            @foreach($orders['products'] as $product)
            <tr>
                <td>{{ isset($orders['id']) ? $orders['id'] : "" }}</td>
                <td>{{ isset($orders['deliveryaddress']) ? $orders['deliveryaddress']['fullname'] : "" }}</td>
                <td>{{ isset($orders['warehouses']['name']) ? $orders['warehouses']['name'] : "" }}</td>
                <td>{{ isset($orders['created_at']) ? date("d-m-Y", strtotime($orders['created_at'])) : "" }}</td>
                <td>{{ $product['sku'] }}</td>
                <td>{{ $product['name'] }}</td>
                <td>{{ $product['pivot']['quantity'] }}</td>
                <td>{{ $product['pivot']['price'] }}</td>
                <td>{{ ($product['pivot']['total'] / 1.05) + (($product['pivot']['total'] / 1.05) * 0.05) }}</td>
            </tr>
            @endforeach
        @endforeach
    </tbody>
</table>