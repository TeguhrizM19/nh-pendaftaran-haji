<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulir Pendaftaran Haji</title>
  <style>
    body { font-family: 'Times New Roman', Times, serif; font-size: 17px; }
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

    <table class="table-format" style="margin-top: 20px">
      <tr>
        <td class="label">Telah terima dari</td>
        <td class="separator">:</td>
        <td>{{ $gabungHaji->customer->nama }}</td>
      </tr>
    </table>
  </div>
</body>
</html>