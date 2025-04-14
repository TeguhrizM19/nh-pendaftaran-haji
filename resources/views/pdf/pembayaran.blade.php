<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kwitansi Pembayaran</title>
  <style>
    body { font-family: 'Times New Roman', Times, serif; font-size: 16px; }
    .header-table {
      width: 100%;
      border-collapse: collapse;
      border: 2px solid black;
    }
    .header-table td {
      border: 1px solid black;
      padding: 8px;
      text-align: center;
    }
    .header-logo {
      width: 200px;
      text-align: center;
      font-size: 14px;
      font-weight: normal;
    }
    .header-title {
      font-size: 20px;
      text-transform: uppercase;
    }
    .sub-header td {
      font-size: 16px;
    }
    .info-table {
      width: 100%;
      border-collapse: collapse;
    }
    .info-table td {
      border: 1px solid black;
      padding: 5px;
      text-align: center;
      font-size: 14px;
    }
    .bold {
      font-weight: bold;
    }
    .top-section td {
      vertical-align: middle;
    }
    .right-section {
      text-align: left;
      font-weight: normal;
    }
    .right-section td {
      padding: 5px 10px;
    }

    .table-format {
      width: 100%;
      border-collapse: collapse;
    }

    .table-format td {
      padding: 5px;
    }

    .table-format .label {
      width: 30%;
    }

    .table-format .separator {
      width: 2%;
    }

    h4 {
      margin-bottom: 2px;
      padding-bottom: 2px;
    }

    /* Gaya untuk tabel baru */
    .table-header {
      width: 100%;
      border-collapse: collapse;
      border: 2px solid black;
      margin-bottom: 20px;
    }

    .table-header .logo {
      width: 15%;
    }

    .table-header .logo img {
      max-width: 100%;
      height: auto;
    }

    .table-header .header {
      font-size: 1.5em;
      font-weight: bold;
    }

    .table-header .form-title {
      font-size: 1.2em;
      font-weight: bold;
    }

    .table-header .footer {
      font-size: 0.8em;
    }
  </style>
</head>
<body>
  <div class="container">
    <table class="header-table">
      <tr class="top-section">
        <td rowspan="2" class="header-logo">
          <img src="{{ public_path('images/logo_haji_umroh.jpg') }}" style="width: 160px;" alt="logo">
        </td>
        <td style="font-weight: bold" class="header-title">KBIH NURUL HAYAT</td>
      </tr>
      <tr>
        <td>Telp. 031 8783344, Hotline 0812 3382 7372</td>
      </tr>
    </table>

    <h4 style="text-align: center;">KWITANSI PEMBAYARAN</h4>
    <p>Kwitansi No : {{ $cabang->kode_cab }}{{ $pembayaran->kwitansi }}</p>

    <table class="table-format">
      <tr>
        <td class="label">Telah terima dari</td>
        <td class="separator">:</td>
        <td>{{ $gabungHaji->customer->nama }}</td>
      </tr>
      
      @foreach ($pembayaranList as $data)
        <tr>
          <td class="label" style="vertical-align: top;">Untuk Pembayaran</td>
          <td class="separator" style="vertical-align: top;">:</td>
          <td>
            DP Haji {{ $gabungHaji->keberangkatan->keberangkatan ?? '-' }}
            @if ($data->operasional)
              Operasional: Rp. {{ number_format($data->operasional, 0, ',', '.') }}
            @endif
            @if ($data->manasik)
              Manasik: Rp. {{ number_format($data->manasik, 0, ',', '.') }},
            @endif
            @if ($data->dam)
              Dam: Rp. {{ number_format($data->dam, 0, ',', '.') }}
            @endif
          </td> 
        </tr>

        <tr>
          <td class="label font-bold">Total Pembayaran</td>
          <td class="separator font-bold">:</td>
          <td class="font-bold text-black">
            {{ $totalKeseluruhan ? 'Rp. ' . number_format($totalKeseluruhan, 0, ',', '.') : '-' }}
          </td>
        </tr>
        <tr>
          <td class="label font-bold">Terbilang</td>
          <td class="separator font-bold">:</td>
          <td class="font-bold text-black">
            {{ $totalKeseluruhan ? '# ' . strtoupper($terbilangTotal) . ' RUPIAH #' : '-' }}
          </td>
        </tr>
        @endforeach

        <tr>
          <td class="label">Metode Bayar</td>
          <td class="separator">:</td>
          <td>{{ $metodeList[$data->metode_bayar] ?? $data->metode_bayar }}</td>
        </tr>

        <tr> 
          <td class="label font-bold">Total Biaya</td>
          <td class="separator font-bold">:</td>
          <td class="font-bold text-black">
            {{ isset($totalBiayaResmi) && $totalBiayaResmi > 0 
              ? 'Rp ' . number_format($totalBiayaResmi, 0, ',', '.') 
              : '-' }}
          </td>
        </tr>

        <tr>
          <td class="label">Admin Input</td>
          <td class="separator">:</td>
          <td>{{ $data->create_user }}</td>
        </tr>
    </table>

    <table style="width: 100%; text-align: center; border-collapse: collapse;">
      <tr>
        <td style="height: 10px;"></td>
      </tr>
      <tr>
        <td style="width: 40%;"></td> <!-- Spasi di tengah -->
        <td style="width: 40%;"></td> <!-- Spasi di tengah -->
        <td style="width: 50%; text-align: center;">
          Surabaya, {{ \Carbon\Carbon::parse($data->created_at)->translatedFormat('d F Y') }}
        </td>
      </tr>
      <tr>
        <td style="height: 60px;"></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td style="text-align: center;">
          {{ $data->create_user ?? 'Admin' }}
        </td>
      </tr>
    </table>
    <div style="border-top: 2px dotted #000; margin: 10px 0;"></div>
    <p>Info Rincian Pembayaran : </p>
    <table class="header-table">
      <tr class="top-section">
        <td style="font-weight: bold">Tanggal</td>
        <td style="font-weight: bold">No Kwitansi</td>
        <td style="font-weight: bold">Keterangan</td>
        <td style="font-weight: bold">Nominal</td>
        <td style="font-weight: bold">Admin</td>
      </tr>
      @forelse($semuaPembayaran as $pembayaran)
        <tr>
          <td>
            {{ \Carbon\Carbon::parse($pembayaran->tgl_bayar)->translatedFormat('d-F-Y') }}
          </td>
          <td>
            {{ $pembayaran->cabang->kode_cab ?? 100 }}{{ $pembayaran->kwitansi ?? '-' }}
          </td>
          <td style="text-align: left;">
            {{ $pembayaran->keterangan ?? '-' }}
            <ul style="list-style-type: none; padding: 0; margin: 0;">
              @if ($pembayaran->operasional)
                <li>Operasional : Rp. {{ number_format($pembayaran->operasional, 0, ',', '.') }}</li>
              @endif
            
              @if ($pembayaran->manasik)
                <li>Manasik : Rp. {{ number_format($pembayaran->manasik, 0, ',', '.') }}</li>
              @endif
            
              @if ($pembayaran->dam)
                <li>Dam : Rp. {{ number_format($pembayaran->dam, 0, ',', '.') }}</li>
              @endif
            </ul> 
            {{ $metodeList[$pembayaran->metode_bayar] ?? $pembayaran->metode_bayar }}
          </td>
          <td> 
            {{ $pembayaran->nominal ? 'Rp. ' . number_format($pembayaran->nominal, 0, ',', '.') : '-' }}
          </td>
          <td>{{ $pembayaran->create_user }}</td>
        </tr>
      @empty
        <tr>
          <td colspan="6" style="color: red">Data Masih Kosong</td>
        </tr>
      @endforelse
    </table>

    <p class="label font-bold">Status : 
      @if($totalKekurangan > 0)
        <span>Kurang Rp {{ number_format($totalKekurangan, 0, ',', '.') }}</span>
      @elseif($totalLebih > 0)
        <span>Kelebihan Rp {{ number_format($totalLebih, 0, ',', '.') }}</span>
      @else
        <span>LUNAS</span>
      @endif
    </p>
  </div>
</body>
</html>