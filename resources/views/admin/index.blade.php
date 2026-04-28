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
        color: white;
    }

    .btn-modern:hover {
        transform: scale(1.04);
        box-shadow: 0 8px 20px rgba(249,115,22,0.4);
        color: white;
    }

    /* TABS */
    .nav-tabs {
        border-bottom: 1px solid rgba(255,255,255,0.08);
        margin-bottom: 1.5rem;
    }

    .nav-tabs .nav-link {
        background: transparent;
        border: none;
        color: rgba(255,255,255,0.5);
        padding: 10px 20px;
        border-radius: 10px 10px 0 0;
        transition: 0.3s;
        font-weight: 500;
    }

    .nav-tabs .nav-link:hover {
        color: rgba(255,255,255,0.9);
        background: rgba(255,255,255,0.04);
    }

    .nav-tabs .nav-link.active {
        background: rgba(249,115,22,0.1);
        color: #f97316;
        border-bottom: 2px solid #f97316;
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
        margin: 0;
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

    .badge-shelf {
        background: rgba(99,102,241,0.15);
        color: #818cf8;
        border-radius: 8px;
        padding: 5px 10px;
        font-size: 12px;
    }

    h1, h2 {
        font-weight: 600;
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

    .empty-state {
        color: rgba(255,255,255,0.5);
        text-align: center;
        padding: 30px 20px;
        background: rgba(255,255,255,0.02);
        border-radius: 10px;
        border: 1px dashed rgba(255,255,255,0.1);
    }
</style>

<div class="container py-5">

    <h1 class="text-white mb-5">Verwaltung</h1>

    @if(session('success'))
        <div class="alert alert-success shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @php $unassignedBooks = $books->whereNull('section_number'); @endphp

    <!-- TABS WITH FORMS -->
    <div class="card card-modern p-4 text-white mb-5">

        <ul class="nav nav-tabs" id="adminTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="book-tab" data-bs-toggle="tab"
                        data-bs-target="#book-pane" type="button" role="tab">
                    Neues Buch
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="genre-tab" data-bs-toggle="tab"
                        data-bs-target="#genre-pane" type="button" role="tab">
                    Neues Genre
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="assign-tab" data-bs-toggle="tab"
                        data-bs-target="#assign-pane" type="button" role="tab">
                    Regal zuweisen
                </button>
            </li>
        </ul>

        <div class="tab-content" id="adminTabsContent">

            <!-- NEW BOOK -->
            <div class="tab-pane fade show active" id="book-pane" role="tabpanel">
                <form action="{{ route('admin.book.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-2 mb-2">
                        <div class="col-md-6">
                            <input type="text" name="title" class="form-control" placeholder="Titel" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="author" class="form-control" placeholder="Autor" required>
                        </div>
                    </div>

                    <textarea name="desc" class="form-control mb-2" placeholder="Description" rows="2"></textarea>

                    <div class="row g-2 mb-2">
                        <div class="col-md-6">
                            <select name="genre_id" class="form-select" required>
                                <option value="">Genre wählen</option>
                                @foreach($genres as $genre)
                                    <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select name="section_number" class="form-select">
                                <option value="">Regal wählen (optional)</option>
                                @foreach($locations as $location)
                                    <option value="{{ $location->section_number }}">
                                        {{ $location->section_number }} — {{ $location->desc }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <input type="file" name="image" class="form-control mb-3">

                    <button class="btn btn-modern w-100">Buch erstellen</button>
                </form>
            </div>

            <!-- NEW GENRE -->
            <div class="tab-pane fade" id="genre-pane" role="tabpanel">
                <form action="{{ route('admin.genre.store') }}" method="POST">
                    @csrf
                    <input type="text" name="name" class="form-control mb-3" placeholder="Genre Name" required>
                    <button class="btn btn-modern w-100">Erstellen</button>
                </form>
            </div>

            <!-- ASSIGN BOOK TO LOCATION -->
            <div class="tab-pane fade" id="assign-pane" role="tabpanel">
                @if($unassignedBooks->count() > 0)
                    <form action="{{ route('admin.book.assignLocation') }}" method="POST">
                        @csrf

                        <div class="row g-2 mb-3">
                            <div class="col-md-6">
                                <select name="book_id" class="form-select" required>
                                    <option value="">— Buch wählen —</option>
                                    @foreach($unassignedBooks as $book)
                                        <option value="{{ $book->id }}">
                                            {{ $book->title }} — {{ $book->author }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <select name="section_number" class="form-select" required>
                                    <option value="">— Regal wählen —</option>
                                    @foreach($locations as $location)
                                        <option value="{{ $location->section_number }}">
                                            {{ $location->section_number }} — {{ $location->desc }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <button class="btn btn-modern w-100">Zuweisen</button>
                    </form>
                @else
                    <div class="empty-state">
                        ✓ Alle Bücher sind bereits einem Regal zugewiesen.
                    </div>
                @endif
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
                    <th>Regal</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @foreach($books as $book)
                    <tr>
                        <td>
                            @if($book->image)
                                <img src="{{ $book->image }}" style="width:50px;border-radius:6px;">
                            @endif
                        </td>

                        <td class="fw-semibold">{{ $book->title }}</td>
                        <td>{{ $book->author }}</td>
                        <td>{{ $book->desc }}</td>
                        <td>{{ $book->genre->name ?? '—' }}</td>

                        <td>
                            @if($book->location)
                                <span class="badge-shelf">
                                    {{ $book->location->section_number }} — {{ $book->location->desc }}
                                </span>
                            @else
                                <span style="color: rgba(255,255,255,0.4)">—</span>
                            @endif
                        </td>

                        <td>
                            @if($book->is_available)
                                <span class="badge-available">Verfügbar</span>
                            @else
                                <span class="badge-borrowed">Ausgeliehen</span>
                            @endif
                        </td>

                        <td>
                            @if($book->is_available)
                                <form action="{{ route('books.borrow', $book) }}" method="POST">
                                    @csrf
                                    <button class="btn-action borrow">Borrow</button>
                                </form>
                            @else
                                <form action="{{ route('books.return', $book) }}" method="POST">
                                    @csrf
                                    <button class="btn-action return">Return</button>
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
