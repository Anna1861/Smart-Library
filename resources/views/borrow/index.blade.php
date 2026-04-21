@extends('welcome')

@section('content')

<style>
.book-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 20px;
}

.book-card {
    background: rgba(19,21,28,0.7);
    backdrop-filter: blur(6px);
    border-radius: 14px;
    overflow: hidden;
    cursor: pointer;
    transition: 0.3s;
    border: 1px solid rgba(255,255,255,0.06);
    opacity: 0;
    transform: translateY(20px);
    animation: fadeUp 0.6s ease forwards;
}

.book-card:hover {
    transform: scale(1.05) rotate(-1deg);
    box-shadow: 0 20px 60px rgba(212,146,58,0.25);
}

@keyframes fadeUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.book-cover {
    height: 240px;
    position: relative;
    overflow: hidden;
}

/* картинка */
.book-cover img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* fallback */
.no-image {
    width: 100%;
    height: 100%;
    background: #1c1f2a;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #aaa;
    font-size: 14px;
    font-family: monospace;
}

/* overlay */
.book-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.6);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: 0.3s;
    color: white;
    font-weight: 600;
}

.book-card:hover .book-overlay {
    opacity: 1;
}

.book-info {
    padding: 12px;
}

.book-title {
    font-size: 14px;
    font-weight: 600;
    color: white;
    transition: 0.2s;
}

.book-card:hover .book-title {
    color: #d4923a;
}

.book-author {
    font-size: 12px;
    color: #888;
}

.book-status {
    margin-top: 8px;
    font-size: 11px;
    padding: 3px 8px;
    border-radius: 100px;
    display: inline-block;
}

.available { background: #1f3d2b; color: #3dcfb0; }
.borrowed  { background: #3d1f1f; color: #e0605a; }

/* поиск */
.search {
    margin-bottom: 20px;
}

/* MODAL */
.modal-bg {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.7);
    display: none;
    align-items: center;
    justify-content: center;
}

.modal-box {
    background: #111318;
    padding: 30px;
    border-radius: 16px;
    text-align: center;
    width: 300px;
}

.modal-box h3 {
    color: white;
    margin-bottom: 10px;
}

.modal-box p {
    color: #aaa;
    font-size: 14px;
}

.modal-actions {
    margin-top: 20px;
    display: flex;
    gap: 10px;
}

.genre-filter button {
    border-radius: 20px;
    font-size: 12px;
}


/* SEARCH UI */
.search-wrapper {
    margin-bottom: 25px;
}

.search-box {
    position: relative;
    margin-bottom: 15px;
}

.search-box input {
    width: 100%;
    padding: 12px 16px 12px 40px;
    border-radius: 12px;
    border: 1px solid rgba(255,255,255,0.08);
    background: rgba(19,21,28,0.7);
    color: white;
    outline: none;
    transition: 0.3s;
}

.search-box input:focus {
    border-color: #d4923a;
    box-shadow: 0 0 20px rgba(212,146,58,0.2);
}

.search-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    opacity: 0.6;
}

/* GENRE BUTTONS */
.genre-filter {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.genre-btn {
    padding: 6px 14px;
    border-radius: 20px;
    background: transparent;
    border: 1px solid rgba(255,255,255,0.1);
    color: #aaa;
    font-size: 12px;
    cursor: pointer;
    transition: 0.25s;
}

.genre-btn:hover {
    color: white;
    border-color: #d4923a;
}

.genre-btn.active {
    background: #d4923a;
    color: black;
    border-color: #d4923a;
}

/* CARD UPGRADE */
.book-card {
    position: relative;
}

.book-card::after {
    content: "";
    position: absolute;
    inset: 0;
    border-radius: 14px;
    opacity: 0;
    transition: 0.3s;
    box-shadow: inset 0 0 40px rgba(212,146,58,0.15);
}

.book-card:hover::after {
    opacity: 1;
}

/* subtle zoom image */
.book-cover img {
    transition: 0.4s;
}

.book-card:hover .book-cover img {
    transform: scale(1.08);
}

/* layout */
.search-row {
    display: flex;
    gap: 12px;
    margin-bottom: 25px;
}

/* поиск */
.search-box {
    flex: 1;
    position: relative;
}

.search-box input {
    width: 100%;
    padding: 12px 16px 12px 40px;
    border-radius: 12px;
    border: 1px solid rgba(255,255,255,0.08);
    background: rgba(19,21,28,0.7);
    color: white;
}

/* dropdown */
.genre-dropdown select {
    padding: 12px 14px;
    border-radius: 12px;
    border: 1px solid rgba(255,255,255,0.08);
    background: rgba(19,21,28,0.7);
    color: white;
    min-width: 160px;
    cursor: pointer;
}

/* hover */
.genre-dropdown select:hover {
    border-color: #d4923a;
}
</style>

<div class="container py-4">

    <h1 class="text-white mb-4"> Buch auswählen</h1>

<div class="search-row">

    <div class="search-box">
        <span class="search-icon">🔍</span>
        <input type="text" id="search" placeholder="Suche Buch...">
    </div>

    <div class="genre-dropdown">
        <select id="genreSelect">
            <option value="all">Alle Genres</option>

            @foreach($genres as $genre)
                <option value="{{ $genre->id }}">
                    {{ $genre->name }}
                </option>
            @endforeach
        </select>
    </div>

</div>


    <div class="book-grid">

        @foreach($books as $book)
            <div class="book-card"
                data-genre="{{ $book->genre_id }}"
                onclick="openModal({{ $book->id }}, '{{ $book->title }}')">

                <div class="book-cover">

                    @if($book->image)
<img src="{{ $book->image }}">
                    @else
                        <div class="no-image">Kein Bild</div>
                    @endif

                    <div class="book-overlay">
                        Ausleihen
                    </div>

                </div>

                <div class="book-info">

    <div class="book-genre">
        {{ $book->genre->name }}
    </div>

    <div class="book-title">{{ $book->title }}</div>
    <div class="book-author">{{ $book->author }}</div>
    <div class="book-status {{ $book->is_available ? 'available' : 'borrowed' }}">
        {{ $book->is_available ? 'Verfügbar' : 'Ausgeliehen' }}
    </div>

</div>

            </div>
        @endforeach

    </div>
<div class="container py-4">

    <h2 class="text-white mt-4 mb-3" style="opacity:0.8;">
        Ausgeliehene Bücher
    </h2>

    <div class="book-grid" style="opacity:0.5;">

        @foreach($borrowedBooks as $book)
            <div class="book-card" style="cursor: not-allowed;">

                <div class="book-cover">

                    @if($book->image)
                    <img src="{{ $book->image }}">
                    @else
                        <div class="no-image">Kein Bild</div>
                    @endif

                </div>

                <div class="book-info">
                    <div class="book-title">{{ $book->title }}</div>
                    <div class="book-author">{{ $book->author }}</div>

                    <div class="book-status borrowed">
                        Ausgeliehen
                    </div>
                </div>

            </div>
        @endforeach

    </div>

</div>
</div>

<div class="modal-bg" id="modal">
    <div class="modal-box">
        <h3 id="modalTitle">Buch ausleihen?</h3>
        <p>Möchtest du dieses Buch wirklich ausleihen?</p>

        <form method="POST" action="{{ route('borrow.book') }}">
            @csrf
            <input type="hidden" name="book_id" id="modalBookId">

            <div class="modal-actions">
                <button type="submit" class="btn btn-success w-100">
                    Ja
                </button>

                <button type="button" class="btn btn-secondary w-100"
                        onclick="closeModal()">
                    Abbrechen
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal(id, title) {
    document.getElementById('modal').style.display = 'flex';
    document.getElementById('modalBookId').value = id;
    document.getElementById('modalTitle').innerText = '„' + title + '“ ausleihen?';
}

function closeModal() {
    document.getElementById('modal').style.display = 'none';
}

document.getElementById('search').addEventListener('input', function() {
    let value = this.value.toLowerCase();
    document.querySelectorAll('.book-card').forEach(card => {
        card.style.display = card.innerText.toLowerCase().includes(value) ? 'block' : 'none';
    });
});

document.getElementById('genreSelect').addEventListener('change', function () {
    let genreId = this.value;

    document.querySelectorAll('.book-card').forEach(card => {
        if (genreId === 'all') {
            card.style.display = 'block';
        } else {
            card.style.display = card.dataset.genre == genreId ? 'block' : 'none';
        }
    });
});
</script>

@endsection
