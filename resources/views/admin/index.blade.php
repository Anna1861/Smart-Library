@extends('welcome')

@section('content')

<div class="container py-4">

    <h1 class="mb-4 text-white">Verwaltung</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card bg-dark text-white shadow">
                <div class="card-body">
                    <h5 class="card-title">Neues Genre erstellen</h5>
                    <form action="{{ route('admin.genre.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="genreName" class="form-label">Genre-Name</label>
                            <input type="text" name="name" id="genreName" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success">Genre erstellen</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card bg-dark text-white shadow">
                <div class="card-body">
                    <h5 class="card-title">Neues Buch erstellen</h5>
                    <form action="{{ route('admin.book.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="bookTitle" class="form-label">Buchtitel</label>
                            <input type="text" name="title" id="bookTitle" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="bookAuthor" class="form-label">Autor</label>
                            <input type="text" name="author" id="bookAuthor" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="bookGenre" class="form-label">Genre</label>
                            <select name="genre_id" id="bookGenre" class="form-select" required>
                                <option value="">Genre auswählen</option>
                                @foreach($genres as $genre)
                                    <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">Buch erstellen</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <h2 class="mt-4 mb-3 text-white">Alle Bücher</h2>
    <div class="table-responsive">
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>Titel</th>
                    <th>Autor</th>
                    <th>Genre</th>
                    <th>Status</th>
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
                                <span class="badge bg-success">Verfügbar</span>
                            @else
                                <span class="badge bg-danger">Ausgeliehen</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
