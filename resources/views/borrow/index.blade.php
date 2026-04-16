@extends('welcome')

@section('content')

<div class="container py-4">

    <h1 class="mb-4 text-white">Buch ausleihen</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card bg-dark text-white p-4 shadow mb-4">
        <form action="{{ route('borrow.book') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="bookSelect" class="form-label">Buch auswählen</label>
                <select name="book_id" id="bookSelect" class="form-select" required>
                    <option value="">Bitte ein Buch auswählen</option>
                    @foreach($books as $book)
                        <option value="{{ $book->id }}">{{ $book->title }} ({{ $book->author }})</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-success">Buch ausleihen</button>
        </form>
    </div>
</div>

@endsection
