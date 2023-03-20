<table>
    <tr>
        <td>#</td>
        <td>Code</td>
        <td>Name</td>
        <td>Address</td>
        <td>Phone</td>
        <td>Email</td>
        <td>Discount</td>
    </tr>
    @foreach($suppliers as $supplier)
    <tr>
        <td>{{ $supplier->id }}</td>
        <td>{{ $supplier->code }}</td>
        <td>{{ $supplier->name }}</td>
        <td>{{ $supplier->address }}</td>
        <td>{{ $supplier->phone }}</td>
        <td>{{ $supplier->email }}</td>
        <td>{{ $supplier->discount }}</td>
    </tr>
    @endforeach
</table>