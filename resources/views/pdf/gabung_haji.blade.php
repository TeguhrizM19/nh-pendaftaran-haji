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
      font-weight: bold;
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
    <table class="header-table">
      <tr class="top-section">
        <td rowspan="2" class="header-logo">
          <img src="{{ public_path('images/logo_haji_umroh.jpg') }}" style="width: 160px;" alt="logo">
        </td>
        <td colspan="3" class="header-title">YAYASAN NURUL HAYAT SURABAYA</td>
      </tr>
      <tr class="sub-header">
        <td>FORM <br> KBIH-01</td>
        <td>FORM BERGABUNG <br> HAJI</td>
        <td style="padding: 0px">
          <table border="1" style="border-collapse: collapse; width: 100%;">
            <tr style="border-collapse: collapse; width: 100%; border: 1px solid black;">
              <td style="font-size: 14px; font-weight: normal; text-align: left; border: none; margin: 2px; padding: 2px;">Diterbitkan</td>
              <td style="font-size: 14px; font-weight: normal; text-align: left; border: none; margin: 2px; padding: 2px;"> : 01-04-2018</td>
            </tr>
            <tr style="border-collapse: collapse; width: 100%; border: 1px solid black;">
              <td style="font-size: 14px; font-weight: normal; text-align: left; border: none; margin: 2px; padding: 2px;">Revisi</td>
              <td style="font-size: 14px; font-weight: normal; text-align: left; border: none; margin: 2px; padding: 2px;"> : 00</td>
            </tr>
            <tr style="border-collapse: collapse; width: 100%; border: 1px solid black;">
              <td style="font-size: 14px; font-weight: normal; text-align: left; border: none; margin: 2px; padding: 2px;">Halaman</td>
              <td style="font-size: 14px; font-weight: normal; text-align: left; border: none; margin: 2px; padding: 2px;"> : 1 dari 1</td>
            </tr>
          </table>
        </td>
      </tr>
    </table>

    <table class="table-format" style="margin-top: 20px">
      <tr>
        <td class="label">Nomor SPPH</td>
        <td class="separator">:</td>
        <td>{{ $gabung->no_spph }}</td>
      </tr>
      <tr>
        <td class="label">Nomor Porsi</td>
        <td class="separator">:</td>
        <td>{{ $gabung->no_porsi }}</td>
      </tr>
      <tr>
        <td class="label">Bank & Kota</td>
        <td class="separator">:</td>
        <td>
          {{ $gabung->nama_bank ?? '-' }} &
          {{ $gabung->kotaBank->kota ?? '-' }}
        </td>
      </tr>
      <tr>
        <td class="label">Depag</td>
        <td class="separator">:</td>
        <td>{{ $depag->kota ?? '-' }}</td>
      </tr>
    </table>

    <h4>DATA PRIBADI :</h4> 
    <table class="table-format">
      <tr>
        <td class="label">Nama Lengkap</td>
        <td class="separator">:</td>
        <td>{{ $gabung->customer->nama }}</td>
      </tr>
      <tr>
        <td class="label">Jenis Kelamin</td>
        <td class="separator">:</td>
        <td>{{ $gabung->customer->jenis_kelamin }}</td>
      </tr>
      <tr> 
        <td class="label">Tempat & Tanggal Lahir</td>
        <td class="separator">:</td>
        <td>
          {{ $gabung->customer->tempatLahir->kota ?? '-' }} / 
          {{ \Carbon\Carbon::parse($gabung->customer->tgl_lahir)->translatedFormat('d-F-Y') }}
        </td>
      </tr>   
      <tr>    
        <td class="label" style="vertical-align: top;">Alamat KTP</td>
        <td class="separator" style="vertical-align: top;">:</td>
        <td>
          {{ $gabung->customer->alamat_ktp }} <br>
          <span style="display: block; margin-top: 4px;">
            {{ optional($gabung->customer->provinsiKtp)->provinsi ?? '-' }},
            {{ optional($gabung->customer->kotaKtp)->kota ?? '-' }},
            {{ optional($gabung->customer->kecamatanKtp)->kecamatan ?? '-' }},
            {{ optional($gabung->customer->kelurahanKtp)->kelurahan ?? '-' }}
          </span>
        </td>
      </tr>
      <tr>
        <td class="label" style="vertical-align: top;">Alamat Domisili</td>
        <td class="separator" style="vertical-align: top;">:</td>
        <td>
          {{ $gabung->customer->alamat_domisili }}
          <span style="display: block; margin-top: 4px;">
            {{ optional($gabung->customer->provinsiDomisili)->provinsi ?? '-' }},
            {{ optional($gabung->customer->kotaDomisili)->kota ?? '-' }},
            {{ optional($gabung->customer->kecamatanDomisili)->kecamatan ?? '-' }},
            {{ optional($gabung->customer->kelurahanDomisili)->kelurahan ?? '-' }}
          </span>
        </td>
      </tr>
      <tr>
        <td class="label">No Telepon</td>
        <td class="separator">:</td>
        <td>{{ $gabung->customer->no_hp_1 ?? '-' }}</td>
      </tr>
      <tr>
        <td class="label">Profesi</td>
        <td class="separator">:</td>
        <td>{{ $gabung->customer->pekerjaan ?? '-' }}</td>
      </tr>
    </table>

    {{-- <h4>Berkas yang diserahkan :</h4>
    @if (count($dokumen) > 0)
      <ul style="margin: 0; padding-left: 18px; list-style: none;">
        @foreach ($dokumen as $index => $doc)
          <li>{{ $index + 1 }}. {{ $doc->dokumen ?? '-' }}</li>
        @endforeach
      </ul>
    @else
      Tidak ada berkas
    @endif --}}

    <p>Dengan mengucapkan <em>Bismillaahirrohmaanirrohiim</em>, Saya mendaftarkan diri ikut bergabungdi KBIH (Kelompok Bimbingan Ibadah Haji) NH</p>
  
    <table style="width: 100%; text-align: center; border-collapse: collapse;">
      <tr>
        <td style="height: 30px;"></td>
      </tr>
      <tr>
        <td style="width: 40%;"></td> <!-- Spasi di tengah -->
        <td style="width: 40%;"></td> <!-- Spasi di tengah -->
        <td style="width: 50%; text-align: left;">
          Surabaya, {{ \Carbon\Carbon::parse($gabung->created_at)->translatedFormat('d F Y') }}
        </td>
      </tr>
      <tr>
        <td style="height: 40px;"></td>
      </tr>
      <tr>
        <td style="width: 40%; text-align: center;">Pendaftar</td>
        <td style="width: 80%;"></td> <!-- Spasi di tengah -->
        <td style="width: 40%; text-align: center;">Petugas KBIH</td>
      </tr>
      <tr>
        <td style="height: 60px;"></td>
      </tr>
      <tr>
        <td style="text-align: center;">{{ $gabung->customer->nama }}</td>
        <td></td>
        <td style="text-align: center;">
          {{ $gabung->create_user ?? 'Admin' }}
        </td>
      </tr>
    </table>
  </div>
</body>
</html>