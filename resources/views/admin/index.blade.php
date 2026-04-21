@extends('welcome')

@section('content')

<style>
    body {
        font-family: 'Inter', sans-serif;
    }

    .card-modern {
        background: rgba(255, 255, 255, 0.04);
        border-radius: 18px;
        border: 1px solid rgba(255,255,255,0.08);
        backdrop-filter: blur(12px);
        transition: 0.3s;
    }

    .card-modern:hover {
        transform: translateY(-4px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.5);
    }

    .form-control, .form-select {
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.08);
        color: white;
        border-radius: 10px;
        padding: 10px;
    }

    .form-control::placeholder {
        color: rgba(255,255,255,0.5);
    }

    .form-control:focus, .form-select:focus {
        border-color: #f97316;
        box-shadow: 0 0 0 2px rgba(249,115,22,0.3);
        background: rgba(255,255,255,0.08);
        color: white;
    }

    .btn-modern {
        background: linear-gradient(135deg, #f97316, #ea580c);
        border: none;
        border-radius: 10px;
        padding: 10px;
        font-weight: 500;
        transition: 0.3s;
    }

    .btn-modern:hover {
        transform: scale(1.04);
        box-shadow: 0 8px 20px rgba(249,115,22,0.4);
    }

    .table-modern {
        background: rgba(255,255,255,0.04);
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid rgba(255,255,255,0.08);
    }

    .table-modern table {
        margin: 0;
    }

    .table-modern th {
        background: rgba(255,255,255,0.06);
        font-weight: 500;
        color: rgba(255,255,255,0.7);
        border-bottom: 1px solid rgba(255,255,255,0.08);
    }

    .table-modern tr {
        transition: 0.2s;
    }

    .table-modern tr:hover {
        background: rgba(249,115,22,0.08);
    }

    .badge-available {
        background: rgba(34,197,94,0.15);
        color: #22c55e;
        border-radius: 8px;
        padding: 5px 10px;
    }

    .badge-borrowed {
        background: rgba(239,68,68,0.15);
        color: #ef4444;
        border-radius: 8px;
        padding: 5px 10px;
    }

    h1, h2 {
        font-weight: 600;
    }

    .table-modern {
    background: rgba(255,255,255,0.04);
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid rgba(255,255,255,0.08);
}

.table-modern table {
    width: 100%;
    border-collapse: collapse;
    background: transparent !important;
}

.table-modern thead {
    background: rgba(255,255,255,0.05);
}

.table-modern th {
    color: rgba(255,255,255,0.6);
    font-weight: 500;
    border-bottom: 1px solid rgba(255,255,255,0.08);
}

.table-modern td,
.table-modern th {
    padding: 14px 16px;
}

.table-modern tr:hover {
    background: rgba(249,115,22,0.08);
}

.btn-action {
    border: none;
    padding: 8px 14px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 500;
    transition: 0.3s;
    width: 100px;
}

.btn-action.borrow {
    background: rgba(249,115,22,0.15);
    color: #f97316;
}

.btn-action.borrow:hover {
    background: #f97316;
    color: white;
}

.btn-action.return {
    background: rgba(239,68,68,0.15);
    color: #ef4444;
}

.btn-action.return:hover {
    background: #ef4444;
    color: white;
}
</style>

<div class="container py-5">

    <h1 class="text-white mb-5">Verwaltung</h1>

    @if(session('success'))
        <div class="alert alert-success shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="row g-4">

        <!-- GENRE -->
        <div class="col-md-6">
            <div class="card card-modern p-4 text-white">
                <h5 class="mb-3">Neues Genre</h5>

                <form action="{{ route('admin.genre.store') }}" method="POST">
                    @csrf

                    <input type="text"
                           name="name"
                           class="form-control mb-3"
                           placeholder="Genre Name">

                    <button class="btn btn-modern w-100">
                        Erstellen
                    </button>
                </form>
            </div>
        </div>

        <!-- BOOK -->
        <div class="col-md-6">
            <div class="card card-modern p-4 text-white">
                <h5 class="mb-3">Neues Buch</h5>

                <form action="{{ route('admin.book.store') }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf

                    <input type="text" name="title"
                           class="form-control mb-2"
                           placeholder="Titel">

                    <input type="text" name="author"
                           class="form-control mb-2"
                           placeholder="Autor">

                           <textarea type="text" name="desc" class="form-control mb-2"
                           placeholder="Description"></textarea>
                    <select name="genre_id"
                            class="form-select mb-2">
                        <option>Genre wählen</option>
                        @foreach($genres as $genre)
                            <option value="{{ $genre->id }}">
                                {{ $genre->name }}
                            </option>
                        @endforeach
                    </select>

                    <input type="file"
                           name="image"
                           class="form-control mb-3">

                    <button class="btn btn-modern w-100">
                        Buch erstellen
                    </button>

                </form>
            </div>
        </div>

    </div>

    <!-- TABLE -->
    <h2 class="mt-5 mb-3 text-white">Alle Bücher</h2>

    <div class="table-modern">

        <table class="text-white align-middle">

            <thead>
                <tr>
                    <th></th>
                    <th>Titel</th>
                    <th>Autor</th>
                    <th>Description</th>
                    <th>Genre</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @foreach($books as $book)
                    <tr>

                        <td>
                            <img
                                src="{{ $book->image ? asset('storage/'.$book->image) : 'https://via.placeholder.com/50x70' }}"
                                width="50"
                                style="border-radius: 6px; object-fit: cover;"
                            >
                        </td>

                        <td class="fw-semibold">{{ $book->title }}</td>
                        <td>{{ $book->author }}</td>
                        <td>{{ $book->desc }}</td>
                        <td>{{ $book->genre->name }}</td>

                        <td>
                            @if($book->is_available)
                                <span class="badge-available">
                                    Verfügbar
                                </span>
                            @else
                                <span class="badge-borrowed">
                                    Ausgeliehen
                                </span>
                            @endif
                        </td>
<td>

    @if($book->is_available)
        <form action="{{ route('books.borrow', $book) }}" method="POST">
            @csrf
            <button class="btn-action borrow">
                Borrow
            </button>
        </form>
    @else
        <form action="{{ route('books.return', $book) }}" method="POST">
            @csrf
            <button class="btn-action return">
                Return
            </button>
        </form>
    @endif

</td>
                    </tr>
                @endforeach
            </tbody>

        </table>

    </div>

</div>

@endsection
