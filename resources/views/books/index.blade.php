@extends('welcome')

@section('content')
<h2 class="mb-4">Books</h2>

<table class="table table-hover table-striped">
    <thead class="table-dark">
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Genre</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($books as $book)
        <tr>
            <td>{{ $book->title }}</td>
            <td>{{ $book->author }}</td>
            <td>{{ $book->genre->name }}</td>
            <td>
                @if($book->is_available)
                    <span class="badge bg-success">Available</span>
                @else
                    <span class="badge bg-danger">Taken</span>
                @endif
            </td>
            <td>
                @if($book->is_available)
                    <form method="POST" action="/books/{{ $book->id }}/borrow">
                        @csrf
                        <button class="btn btn-primary btn-sm">Borrow</button>
                    </form>
                @else
                    <form method="POST" action="/books/{{ $book->id }}/return">
                        @csrf
                        <button class="btn btn-warning btn-sm">Return</button>
                    </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection

