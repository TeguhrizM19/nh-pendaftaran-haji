<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulir Pendaftaran Haji</title>
  <style>
    body { font-family: 'Times New Roman', Times, serif; font-size: 16px; }
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

    .table-header td {
      border: 1px solid black;
      padding: 10px;
      text-align: center;
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
    <table class="table-header">
      <tr>
        <td rowspan="4" class="logo"><img src="logo.png" alt="Logo Nurul Hayat"></td>
        <td colspan="2" class="header">YAYASAN NURUL HAYAT<br>SURABAYA</td>
      </tr>
      <tr>
        <td rowspan="3" class="form-title">FORM<br>KBIH-01</td>
        <td rowspan="3" class="form-title">PENDAFTARAN<br>HAJI</td>
      </tr>
      <tr></tr>
      <tr></tr>
      <tr>
        <td colspan="2" class="footer">Diterbitkan 01-04-2018</td>
        <td class="footer">Revisi 00</td>
        <td class="footer">Halaman 1 dari 1</td>
      </tr>
    </table>

    <h2 align="center">Formulir Pendaftaran Haji</h2>

    <table class="table-format">
      <tr>
        <td class="label">Nomor Porsi Haji</td>
        <td class="separator">:</td>
        <td>{{ $daftar->no_porsi_haji }}</td>
      </tr>
      <tr>
        <td class="label">Paket Pendaftaran</td>
        <td class="separator">:</td>
        <td>{{ $daftar->paket_haji }}</td>
      </tr>
      <tr>
        <td class="label">Bank / Jumlah Setoran</td>
        <td class="separator">:</td>
        <td>{{ $daftar->bank }}</td>
      </tr>
      <tr>
        <td class="label">Wilayah Daftar</td>
        <td class="separator">:</td>
        <td>{{ $daftar->wilayahKota->kota }}</td>
      </tr>
      <tr>
        <td class="label">Sumber Informasi</td>
        <td class="separator">:</td>
        <td>{{ $daftar->sumberInfo->info }}</td>
      </tr>
    </table>

    <h4>DATA PRIBADI :</h4> 
    <table class="table-format">
      <tr>
        <td class="label">Nama Lengkap</td>
        <td class="separator">:</td>
        <td>{{ $daftar->customer->nama }}</td>
      </tr>
      <tr>
        <td class="label">Jenis Kelamin</td>
        <td class="separator">:</td>
        <td>{{ $daftar->customer->jenis_kelamin }}</td>
      </tr>
      <tr> 
        <td class="label">Tempat & Tanggal Lahir</td>
        <td class="separator">:</td>
        <td>
          {{ $daftar->customer->kotaLahir->kota ?? '-' }} / 
          {{ \Carbon\Carbon::parse($daftar->customer->tgl_lahir)->translatedFormat('d-F-Y') }}
        </td>
      </tr>   
      <tr>   
        <td class="label" style="vertical-align: top;">Alamat KTP</td>
        <td class="separator" style="vertical-align: top;">:</td>
        <td>
          {{ $alamat_ktp['alamat'] ?? '-' }} <br>
          <span style="display: block; margin-top: 4px;">
            {{ $provinsi }}, {{ $kota }}, {{ $kecamatan }}, {{ $kelurahan }}
          </span>
        </td>
      </tr>
      <tr>
        <td class="label" style="vertical-align: top;">Alamat Domisili</td>
        <td class="separator" style="vertical-align: top;">:</td>
        <td>
          {{ $alamat_domisili['alamat'] ?? '-' }}
          <span style="display: block; margin-top: 4px;">
            {{ $provinsi_domisili }}, {{ $kota_domisili }}, {{ $kecamatan_domisili }}, {{ $kelurahan_domisili }}
          </span>
        </td>
      </tr>
      <tr>
        <td class="label">No Telepon</td>
        <td class="separator">:</td>
        <td>{{ $daftar->customer->no_hp_1 }}</td>
      </tr>
      <tr>
        <td class="label">Profesi</td>
        <td class="separator">:</td>
        <td>{{ $daftar->customer->pekerjaan }}</td>
      </tr>
    </table>

    <h4>Berkas :</h4>
    @if (count($dokumen) > 0)
      <ul style="margin: 0; padding-left: 18px; list-style: none;">
        @foreach ($dokumen as $index => $doc)
          <li>{{ $index + 1 }}. {{ $doc->dokumen ?? '-' }}</li>
        @endforeach
      </ul>
    @else
      Tidak ada berkas
    @endif

    <p>Dengan ini saya menyatakan mendaftarkan diri ikut program Haji KBHI Nurul Hayat dan selanjutnya akan mentaati syarat-syarat dan ketentuan yang berlaku. Demikian formulis ini saya isi dengan pernyataan yang sebenarnya.</p>
  </div>
</body>
</html>