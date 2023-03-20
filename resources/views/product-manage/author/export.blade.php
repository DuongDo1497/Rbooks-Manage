<table>
    <tr>
        <td>#</td>
        <td>Name</td>
        <td>Description</td>
    </tr>
    @foreach($authors as $author)
    <tr>
        <td>{{ $author->id }}</td>
        <td>{{ $author->name }}</td>
        <td>{{ $author->description }}</td>
    </tr>
    @endforeach
</table>