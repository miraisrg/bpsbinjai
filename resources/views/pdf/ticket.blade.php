<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Tiket Antrian {{ $antrian->no_antrian }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; }
        .container { width: 320px; margin: 0 auto; border: 1px solid #ccc; padding: 20px; text-align: center; }
        .logo { height: 50px; margin-bottom: 10px; }
        hr { border: 0; border-top: 1px solid #ccc; margin: 15px 0; }
        .queue-number { font-size: 48px; font-weight: bold; margin: 10px 0; }
        .details { font-size: 14px; color: #666; }
        .service-type { display: inline-block; background-color: #eee; font-size: 12px; padding: 5px 10px; border-radius: 15px; margin-top: 10px; }
        .qr-code { padding: 15px 0; }
        .footer-text { font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        {{-- dom-pdf memerlukan path absolut ke file gambar. Pastikan logo Anda ada di public/images/ --}}
        <img src="{{ public_path('images/logo_bps.png') }}" alt="Logo BPS" class="logo">
        <p style="font-weight: bold;">BPS Kota Binjai</p>

        <hr>

        <p class="details">Nomor Antrian Anda:</p>
        <p class="queue-number">{{ $antrian->no_antrian }}</p>
        <p class="details">
            {{ $antrian->created_at->isoFormat('DD MMMM YYYY') }} &nbsp;&bull;&nbsp; {{ $antrian->created_at->format('H:i') }}
        </p>
        <div>
            <span class="service-type">
                Jenis Pelayanan: {{ $antrian->tamu->jenis_pelayanan }}
            </span>
        </div>

        <hr>

        <div class="footer-text">
            <p>Silahkan menunggu panggilan petugas</p>
            <p>Terima kasih atas kunjungan Anda</p>
        </div>
    </div>
</body>
</html>