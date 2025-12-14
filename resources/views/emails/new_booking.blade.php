<!DOCTYPE html>
<html>
<body>
    <h2>Halo, Guru BK 👋</h2>
    <p>Ada permintaan konseling baru dari siswa.</p>

    <ul>
        <li><strong>Nama Siswa:</strong> {{ $session->student->name }}</li>
        <li><strong>Kelas:</strong> {{ $session->student->class_name }}</li>
        <li><strong>Tanggal:</strong> {{ $session->scheduled_at->format('d F Y, H:i') }}</li>
        <li><strong>Topik:</strong> {{ $session->category }}</li>
    </ul>

    <p>Silakan login ke dashboard untuk menerima atau menolak permintaan ini.</p>
    <p>Terima kasih,<br>Sistem Konseling Sekolah</p>
</body>
</html>
