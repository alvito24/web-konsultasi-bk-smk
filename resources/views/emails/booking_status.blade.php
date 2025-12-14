<!DOCTYPE html>
<html>
<body>
    <h2>Halo, {{ $session->student->name }} 👋</h2>
    <p>Status permintaan konseling kamu telah diperbarui.</p>

    <p><strong>Status Saat Ini:</strong>
        <span style="font-weight:bold; font-size:14px; color: {{ $session->status == 'approved' ? 'green' : 'red' }}">
            {{ strtoupper($session->status) }}
        </span>
    </p>

    <ul>
        <li><strong>Tanggal:</strong> {{ $session->scheduled_at->format('d F Y, H:i') }}</li>
        <li><strong>Guru BK:</strong> {{ $session->counselor->name ?? 'Tim BK' }}</li>
    </ul>

    @if($session->counselor_notes)
        <p><strong>Catatan Guru:</strong><br> {{ $session->counselor_notes }}</p>
    @endif

    <p>Jangan lupa cek dashboard kamu secara berkala.</p>
    <p>Terima kasih,<br>Sistem Konseling Sekolah</p>
</body>
</html>
