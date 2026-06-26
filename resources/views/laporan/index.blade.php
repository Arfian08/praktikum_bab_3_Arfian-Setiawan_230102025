<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: sans-serif; padding: 20px; background: #f5f5f5; }
        h1   { color: #333; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px; }
        .card { background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .stat-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-top: 20px; }
        .stat { background: white; border-radius: 10px; padding: 20px; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .stat h2 { font-size: 2rem; margin: 0; }
        .stat p  { color: #666; margin: 5px 0 0; }
        .aktif    { border-top: 4px solid #22c55e; }
        .expired  { border-top: 4px solid #ef4444; }
        .total    { border-top: 4px solid #3b82f6; }
    </style>
</head>
<body>

<h1>📊 Dashboard Laporan</h1>

{{-- STAT KUPON --}}
<div class="stat-grid">
    <div class="stat aktif">
        <h2>{{ $kuponAktif }}</h2>
        <p>Kupon Aktif</p>
    </div>
    <div class="stat expired">
        <h2>{{ $kuponKadaluarsa }}</h2>
        <p>Kupon Kadaluarsa</p>
    </div>
    <div class="stat total">
        <h2>{{ $totalPenggunaan }}</h2>
        <p>Total Penggunaan Kupon</p>
    </div>
</div>

{{-- GRAFIK --}}
<div class="grid">

    {{-- Donut: Sentimen --}}
    <div class="card">
        <h3>🎯 Analisis Sentimen Rating</h3>
        <canvas id="sentimenChart"></canvas>
    </div>

    {{-- Bar: Rating per Bintang --}}
    <div class="card">
        <h3>⭐ Distribusi Rating</h3>
        <canvas id="ratingChart"></canvas>
    </div>

</div>

<script>
    // Donut Sentimen
    new Chart(document.getElementById('sentimenChart'), {
        type: 'doughnut',
        data: {
            labels: ['Positif (4-5)', 'Netral (3)', 'Negatif (1-2)'],
            datasets: [{
                data: [{{ $sentimen->positif }}, {{ $sentimen->netral }}, {{ $sentimen->negatif }}],
                backgroundColor: ['#22c55e', '#f59e0b', '#ef4444'],
            }]
        }
    });

    // Bar Rating
    new Chart(document.getElementById('ratingChart'), {
        type: 'bar',
        data: {
            labels: {!! $ratingPerBintang->pluck('rating')->map(fn($r) => '"⭐ '.$r.'"')->implode(',') !!},
            datasets: [{
                label: 'Jumlah Review',
                data: [{{ $ratingPerBintang->pluck('total')->implode(',') }}],
                backgroundColor: ['#ef4444','#f97316','#f59e0b','#84cc16','#22c55e'],
            }]
        },
        options: { plugins: { legend: { display: false } } }
    });
</script>

</body>
</html>