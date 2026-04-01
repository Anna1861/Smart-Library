@extends('welcome')

@section('content')

<div class="container py-4">

    <h2 class="mb-4 text-white">Dashboard</h2>

<div class="card bg-dark text-white shadow mb-4">
    <div class="card-body">
        <div class="row text-center">

            <div class="col">
                <div class="text-white-50 small">Gesamtanzahl Bücher</div>
                <div class="fs-3 fw-bold">{{ $totalBooks }}</div>
            </div>

            <div class="col border-start border-secondary">
                <div class="text-success small">Verfügbar</div>
                <div class="fs-3 fw-bold text-success">{{ $availableBooks }}</div>
            </div>

            <div class="col border-start border-secondary">
                <div class="text-danger small">Ausgeliehen</div>
                <div class="fs-3 fw-bold text-danger">{{ $borrowedBooks }}</div>
            </div>

        </div>
    </div>
</div>

    <div class="row g-4">

        <div class="col-lg-7">
            <div class="card bg-dark text-white shadow h-100">
                <div class="card-body">
                    <h5 class="card-title mb-3">Ausgeliehene Bücher nach Genre</h5>

                    <div style="height: 300px;">
                        <canvas id="genreChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card bg-dark text-white shadow h-100">
                <div class="card-body">
                    <h5 class="card-title mb-3">Zuletzt ausgeliehene Bücher</h5>

                    <ul class="list-group list-group-flush">
                        @foreach($lastBorrowed as $borrow)
                            <li class="list-group-item bg-dark text-white border-secondary">
                                <div class="fw-semibold">{{ $borrow->book->title }}</div>
                                <div class="text-white-50 small">
                                    {{ $borrow->book->author }}<br>
                                    Ausgeliehen am: {{ $borrow->borrowed_at }}
                                </div>
                            </li>
                        @endforeach
                    </ul>

                </div>
            </div>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('genreChart');

    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($genreStats->pluck('name')->toArray()) !!},
            datasets: [{
                data: {!! json_encode($genreStats->pluck('borrowed_count')->toArray()) !!},
                backgroundColor: [
                    '#F87171',
                    '#60A5FA',
                    '#FBBF24',
                    '#34D399',
                    '#A78BFA'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        color: 'white'
                    }
                }
            }
        }
    });
});
</script>

@endsection
