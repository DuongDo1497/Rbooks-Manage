
<h1>THÔNG TIN HÓA ĐƠN</h1>
<br>
<table>
    <tbody>
        <tr>
            <th colspan="2">Mã đơn hàng</th>
            <th colspan="2">Tên khách hàng</th>
            <th colspan="5">Địa chỉ thanh toán</th>
            <th colspan="5">Địa chỉ nhận hàng</th>
            <th colspan="2">Ngày đặt hàng</th>
            <th colspan="3">Phương thức thanh toán</th>
        </tr>
        <tr>
            <td colspan="2">{{ $orders['id'] }}</td>
            <td colspan="2">{{ $orders['fullname'] }}</td>
            <td colspan="5">{{ $orders['address_payment'] }} - {{$orders['district_payment']}} - {{$orders['city_payment']}}</td>
            <td colspan="5">{{ $orders['address_ship'] }} - {{$orders['district_ship']}} - {{$orders['city_ship']}}</td>
            <td colspan="2">{{ $orders['created_at'] }}</td>
            <td colspan="3">{{ $orders['payment_method'] }}</td>
        </tr>
    </tbody>
</table>
<table>
    <tbody>
        <tr>
            <th colspan="4">Tên sản phẩm</th>
            <th>Giá bán</th>
            <th>Giá KM</th>
            <th>Số lượng</th>
            <th>Tạm tính</th>
        </tr>
        @foreach($orders['products'] as $value)
            <tr>
                <td colspan="4">{{ $value['name'] }}</td>
                <td>{{ $value['cover_price'] }}</td>
                <td>{{ $value['price'] }}</td>
                <td>{{ $value['quantity'] }}</td>
                <td>{{ $value['total'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<table>
    <tbody>
        <tr>
            <td colspan="7">Tổng tiền:</td>
            <td>{{ number_format($orders['sub_cover_price']) }}</td>
        </tr>
        <tr>
            <td colspan="7">Chiết khấu/Tiết kiệm:</td>
            <td>({{$orders['sub_cover_price'] == null ? 0 : round((1-($orders['sub_total'] / $orders['sub_cover_price'])) * 100, 0)}}%)/{{ $orders['sub_cover_price'] - $orders['sub_total'] }}</td>
        </tr>
        <tr>
            <td colspan="7">Thành tiền:</td>
            <td>{{ number_format($orders['sub_total']) }}</td>
        </tr>
        <tr>
            <td colspan="7">Phí giao hàng:</td>
            <td>{{ number_format($orders['ship']) }}</td>
        </tr>
        <tr>
            <td colspan="7">Tổng thanh toán:</td>
            <td>{{ number_format($orders['total']) }}</td>
        </tr>
    </tbody>
</table>

