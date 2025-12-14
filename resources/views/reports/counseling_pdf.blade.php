<!DOCTYPE html>
<html>
<head>
    <title>Laporan Konseling</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 8px; text-align: left; font-size: 12px; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; }
        .meta { text-align: center; font-size: 12px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <h2>Laporan Rekapitulasi Konseling Sekolah</h2>
    <div class="meta">
        Dicetak pada: {{ date('d F Y, H:i') }} <br>
        Oleh: {{ Auth::user()->name }}
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Kategori Masalah</th>
                <th>Guru BK</th>
                <th>Catatan / Solusi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sessions as $index => $s)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $s->scheduled_at->format('d/m/Y') }}</td>
                <td>{{ $s->student->name }}</td>
                <td>{{ $s->student->class_name }}</td>
                <td>{{ $s->category }}</td>
                <td>{{ $s->counselor->name ?? '-' }}</td>
                <td>{{ $s->solution ?? $s->counselor_notes ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
