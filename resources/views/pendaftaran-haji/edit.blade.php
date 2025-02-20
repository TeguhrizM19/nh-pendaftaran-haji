<x-layout>
  <div>
    <x-page-title>Edit Data Pendaftar Haji</x-page-title>
  </div>

  <div class="rounded-lg shadow-lg shadow-black mt-4 p-4">
    <form action="/pendaftaran-haji/{{ $daftar_haji->id }}" method="POST">
      @method('PUT')
      @csrf

      <div class="w-full grid grid-cols-1 md:grid-cols-3 gap-7">
        {{-- Kolom 1 --}}
        <div> 
          <div>
            <label class="block text-sm font-medium leading-6 text-[#099AA7]">Nomor Porsi Haji</label>
            <input type="number" name="no_porsi_haji" required placeholder="Nomor Porsi Haji"
            value="{{ old('no_porsi_haji', $daftar_haji->no_porsi_haji) }}"
            class="mb-3 block w-full rounded-md shadow-md shadow-slate-400 border-0 p-2 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
          </div>
        
          <div class="w-full mb-4">
            <div class="shadow-md">
              <label for="customer_id" class="block text-sm font-medium leading-6 text-[#099AA7]">
                Pilih Customer
              </label>
              <input type="text" name="customer_id" required
              value="{{ old('nama', $daftar_haji->customer->nama) }}"
              class="mb-3 block w-full rounded-md border-0 p-2 bg-gray-100 text-gray-900 shadow-md shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" readonly />
              <input type="hidden" name="customer_id" value="{{ $daftar_haji->customer_id }}">
            </div>       
          </div>
        
          <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
            <div class="shadow-md">
              <label for="cabang_id" class="block text-sm font-medium leading-6 text-[#099AA7]">
                Cabang Daftar
              </label>
              <select name="cabang_id" id="cabang_id" required
                class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                <option value="">Pilih</option>
                @foreach($cabang as $cbg)
                  <option value="{{ $cbg->id }}" 
                    {{ $cbg->id == $daftar_haji->cabang_id ? 'selected' : '' }}>
                    {{ $cbg->cabang }}
                  </option>
                @endforeach
              </select>
            </div>
        
            <div class="shadow-md">
              <label for="wilayah_daftar" class="block text-sm font-medium leading-6 text-[#099AA7]">
                Wilayah Daftar
              </label>
              <select name="wilayah_daftar" id="wilayah_daftar" required
                class="w-full text-gray-900 bg-white border shadow-md shadow-slate-400 border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                <option value="">Pilih</option>
                @foreach ($wilayahKota as $wilayah)
                  <option value="{{ $wilayah->id }}" 
                    {{ $wilayah->id == $daftar_haji->wilayah_daftar ? 'selected' : '' }}>
                    {{ $wilayah->kota }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>
        
          <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-4">
            <div>
              <label class="block text-sm font-medium leading-6 text-[#099AA7]">Estimasi Berangkat</label>
              <input type="number" name="estimasi" min="1900" max="2099" step="1" required
              value="{{ old('estimasi', $daftar_haji->estimasi) }}"
              class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900 shadow-md shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>
        
            <div>
              <label class="block text-sm font-medium leading-6 text-[#099AA7]">BPJS</label>
              <input type="number" name="bpjs" required
              value="{{ old('bpjs', $daftar_haji->bpjs) }}"
              class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900 shadow-md shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>
          </div>
        
          <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
            <div>
              <label class="block text-sm font-medium leading-6 text-[#099AA7]">Bank</label>
              <input type="text" name="bank" required
              value="{{ old('bank', $daftar_haji->bank) }}"
              class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900 shadow-md shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>
        
            <div class="shadow-md">
              <label for="sumber_info" class="block text-sm font-medium leading-6 text-[#099AA7]">Sumber Informasi</label>
              <select name="sumber_info_id" id="sumber_info" required
                class="w-full text-gray-900 bg-white border shadow-md shadow-slate-400 border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                <option value="">Pilih Sumber Informasi</option>
                @foreach($sumberInfo as $sumber)
                  <option value="{{ $sumber->id }}" 
                    {{ $sumber->id == $daftar_haji->sumber_info_id ? 'selected' : '' }}>
                    {{ $sumber->info }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>
        
          <div class="flex gap-6 mt-3">
            <!-- Paket Pendaftaran -->
            <div class="w-1/2">
              <h3 class="mb-3 font-semibold text-[#099AA7]">Paket Pendaftaran</h3>
              @foreach (['Reguler Tunai', 'Reguler Talangan', 'Khusus/Plus'] as $paket)
                <div class="flex items-center ps-3">
                  <input type="radio" value="{{ $paket }}" name="paket_haji" required
                  class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2"
                  {{ $daftar_haji->paket_haji == $paket ? 'checked' : '' }}>
                  <label class="w-full py-3 ms-2 text-sm font-medium text-gray-900">
                    {{ $paket }}
                  </label>
                </div>
              @endforeach
            </div>
        
            <!-- Dokumen -->
            <div class="w-1/2">
              <h3 class="mb-3 font-semibold text-[#099AA7]">Dokumen</h3>
              @foreach ($dokumen as $dok)
              <div class="flex items-center ps-3">
                <input type="checkbox" name="dokumen[]" value="{{ $dok->id }}"
                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2"
                {{ in_array((string) $dok->id, $selected_documents) ? 'checked' : '' }}>
                <label class="w-full py-3 ms-2 text-sm font-medium text-gray-900">
                  {{ $dok->dokumen }}
                </label>
              </div>
              @endforeach
            </div>
          </div>
        
          <div>
            <label for="message" class="block mb-2 mt-4 text-sm font-medium text-[#099AA7]">
              Catatan
            </label>
            <textarea id="message" rows="4" name="catatan"
              class="mb-4 shadow-md shadow-slate-400 block p-2.5 w-full text-sm text-black bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500">{{ old('catatan', $daftar_haji->catatan) }}</textarea>
          </div>
        </div>
        
        {{-- Kolom 2 --}}
        <div class="relative">
          <!-- Grid untuk No HP -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
            <div>
              <label class="block text-sm font-medium leading-6 text-[#099AA7]">No HP 1</label>
              <input type="text" id="no_hp_1" name="" required placeholder="No HP 1"
              value="{{ old('no_hp_1', $daftar_haji->customer->no_hp_1) }}"
              class="mb-3 block w-full rounded-md bg-gray-100 border-0 p-2 text-gray-900 shadow-md shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6"
              readonly />
            </div>
            <div>
              <label class="block text-sm font-medium leading-6 text-[#099AA7]">No HP 2</label>
              <input type="text" id="no_hp_2" name="" required placeholder="No HP 2"
              value="{{ old('no_hp_2', $daftar_haji->customer->no_hp_2) }}"
              class="mb-3 block w-full rounded-md bg-gray-100 border-0 p-2 text-gray-900 shadow-md shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6"
              readonly />
            </div>
          </div>
        
          <!-- Grid untuk Tempat & Tanggal Lahir -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div class="shadow-md">
              <label for="tempat_lahir" class="block text-sm font-medium leading-6 text-[#099AA7]">
                Tempat Lahir
              </label>
              <input type="text" name="" id="tempat_lahir"
              value="{{ old('tempat_lahir', $daftar_haji->customer->kotaLahir->kota ?? '') }}"
              class="w-full text-gray-900 bg-gray-100 border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500"
              readonly>
            </div>
            <div>
              <label for="tgl_lahir" class="block text-sm font-medium leading-6 text-[#099AA7]">Tanggal Lahir</label>
              <input type="date" id="tgl_lahir" name=""
              value="{{ old('tgl_lahir', $daftar_haji->customer->tgl_lahir) }}"
              class="block w-full rounded-md bg-gray-100 border border-gray-300 p-2 text-gray-900 shadow-md shadow-slate-400 focus:ring-2 focus:ring-indigo-600 text-sm leading-6"
              readonly />
            </div>
          </div>
        
          <!-- Grid untuk Jenis ID, No Identitas, dan Warga -->
          <div class="grid grid-cols-[1fr_2fr_1fr] gap-4">
            <div>
              <label for="jenis_id" class="block text-sm font-medium leading-6 text-[#099AA7]">Jenis ID</label>
              <input type="text" id="jenis_id" name=""
              value="{{ old('jenis_id', $daftar_haji->customer->jenis_id) }}"
              class="w-full text-gray-900 bg-gray-100 border border-gray-300 rounded-lg shadow-md shadow-slate-400 text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500"
              readonly />
            </div>
            <div>
              <label for="no_id" class="block text-sm font-medium leading-6 text-[#099AA7]">No ID</label>
              <input type="text" id="no_id" name=""
              value="{{ old('no_id', $daftar_haji->customer->no_id) }}"
              class="w-full text-gray-900 bg-gray-100 border border-gray-300 rounded-lg shadow-md shadow-slate-400 text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500"
              readonly />
            </div>
            <div>
              <label for="warga" class="block text-sm font-medium leading-6 text-[#099AA7]">Warga</label>
              <input type="text" id="warga" name=""
              value="{{ old('warga', $daftar_haji->customer->warga) }}"
              class="w-full text-gray-900 bg-gray-100 border border-gray-300 rounded-lg shadow-md shadow-slate-400 text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500"
              readonly />
            </div>
          </div>

          @php
            $alamat_ktp = json_decode($daftar_haji->customer->alamat_ktp, true);
          @endphp
        
          <!-- Alamat KTP -->
          <div>
            <label for="alamat_ktp" class=" mt-4 block mb-2 text-sm font-medium text-[#099AA7]">
              Alamat Sesuai KTP
            </label>
            <textarea id="alamat_ktp" rows="2" name="" required
            class="mb-4 block p-2.5 w-full shadow-md shadow-slate-400 text-sm text-black rounded-lg border bg-gray-100 border-gray-300 focus:ring-blue-500 focus:border-blue-500"
            readonly>{{ old('alamat_ktp', $alamat_ktp['alamat'] ?? 'Alamat belum tersedia') }}</textarea>
          </div>
        
          <label class="block text-sm font-medium text-[#099AA7]">Provinsi</label>
          <input type="text" name="" class="bg-gray-100 shadow-md shadow-slate-400 mt-1 block w-full sm:text-sm border-gray-300 rounded-md" value="{{ old('provinsi', $provinsi->provinsi ?? '') }}" readonly>
        
          <label class="block text-sm font-medium text-[#099AA7] mt-4">Kota</label>
          <input type="text" name="kota" class="bg-gray-100 shadow-md shadow-slate-400 mt-1 block w-full sm:text-sm border-gray-300 rounded-md"
              value="{{ old('kota', $kota->kota ?? '') }}" readonly>
        
          <label class="block text-sm font-medium text-[#099AA7] mt-4">Kecamatan</label>
          <input type="text" name="" class="bg-gray-100 shadow-md shadow-slate-400 mt-1 block w-full sm:text-sm border-gray-300 rounded-md"
              value="{{ old('kecamatan', $kecamatan->kecamatan ?? '') }}" readonly>
        
          <div class="relative">
            <div class="flex gap-4 mt-4">
              <div class="w-3/4">
                <label class="block text-sm font-medium text-[#099AA7]">Kelurahan</label>
                <input type="text" name="" class="bg-gray-100 shadow-md shadow-slate-400 mt-1 block w-full sm:text-sm border-gray-300"
                value="{{ old('kelurahan', $kelurahan->kelurahan ?? '') }}" readonly>
              </div>
              <div class="w-1/4">
                <label class="block text-sm font-medium text-[#099AA7]">Kode Pos</label>
                <input type="text" name="" class="bg-gray-100 shadow-md shadow-slate-400 mt-1 block w-full sm:text-sm border-gray-300 rounded-md"
                value="{{ old('kode_pos', $kode_pos ?? '') }}" readonly>
              </div>
            </div>
          </div>
        </div>
      
        {{-- Kolom 3 Alamat Domisili --}}
        <div class="relative">
          <div class="w-full mb-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2"> 
              <div>
                <label class="block text-sm font-medium leading-6 text-[#099AA7]">Jenis Kelamin</label>
                <input type="text" id="jenis_kelamin" name="" readonly placeholder="Jenis Kelamin"
                value="{{ old('jenis_kelamin', $daftar_haji->customer->jenis_kelamin) }}"
                  class="mb-3 block w-full rounded-md border border-gray-300 bg-gray-100 p-2 text-gray-900 shadow-md shadow-slate-400 text-sm leading-6" />
              </div>
          
              <!-- Status Nikah -->
              <div>
                <label class="block text-sm font-medium leading-6 text-[#099AA7]">Status Nikah</label>
                <input type="text" id="status_nikah" name="" readonly placeholder="Status Nikah"
                value="{{ old('status_nikah', $daftar_haji->customer->status_nikah) }}"
                class="mb-3 block w-full rounded-md border border-gray-300 bg-gray-100 p-2 text-gray-900 shadow-md shadow-slate-400 text-sm leading-6" />
              </div>
            </div>
          
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2"> 
              <!-- Pekerjaan -->
              <div>
                <label class="block text-sm font-medium leading-6 text-[#099AA7]">Pekerjaan</label>
                <input type="text" id="pekerjaan" name="" readonly placeholder="Pekerjaan"
                value="{{ old('pekerjaan', $daftar_haji->customer->pekerjaan) }}"
                class="mb-3 block w-full rounded-md border border-gray-300 bg-gray-100 p-2 text-gray-900 shadow-md shadow-slate-400 text-sm leading-6" />
              </div>
          
              <!-- Pendidikan -->
              <div>
                <label class="block text-sm font-medium leading-6 text-[#099AA7]">Pendidikan</label>
                <input type="text" id="pendidikan" name="" readonly placeholder="Pendidikan"
                value="{{ old('pendidikan', $daftar_haji->customer->pendidikan) }}"
                class="mb-3 block w-full rounded-md border border-gray-300 bg-gray-100 p-2 text-gray-900 shadow-md shadow-slate-400 text-sm leading-6" />
              </div>
            </div>

            <label for="alamat_domisili" class="block mb-2 text-sm font-medium text-[#099AA7]">
              Alamat Domisili
            </label>
            <textarea id="alamat_domisili" rows="2" name="" required
            class="mb-4 block shadow-md shadow-slate-400 p-2.5 w-full text-sm text-black bg-gray-100 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
            placeholder="Alamat Domisili" readonly>{{ old('alamat_domisili', $alamat_domisili['alamat'] ?? 'Alamat belum tersedia') }}</textarea>

            <label for="provinsi_domisili" class="mt-4 block text-sm font-medium leading-6 text-[#099AA7]">
              Provinsi
            </label>
            <input type="text" id="provinsi_domisili" name=""
            class="w-full shadow-md shadow-slate-400 text-gray-900 bg-gray-100 border border-gray-300 rounded-lg text-sm px-3 py-2"
            value="{{ old('provinsi_domisili', $provinsi_domisili->provinsi ?? '') }}" readonly>

            <label for="kota_domisili" class="mt-4 block text-sm font-medium leading-6 text-[#099AA7]">Kota</label>
            <input type="text" id="kota_domisili" name=""
            class="w-full shadow-md shadow-slate-400 text-gray-900 bg-gray-100 border border-gray-300 rounded-lg text-sm px-3 py-2"
            value="{{ old('kota_domisili', $kota_domisili->kota ?? '') }}" readonly>

            <label for="kecamatan_domisili" class="mt-4 block text-sm font-medium leading-6 text-[#099AA7]">Kecamatan</label>
            <input type="text" id="kecamatan_domisili" name=""
            class="w-full shadow-md shadow-slate-400 text-gray-900 bg-gray-100 border border-gray-300 rounded-lg text-sm px-3 py-2"
            value="{{ old('kecamatan_domisili', $kecamatan_domisili->kecamatan ?? '') }}" readonly>

            <div class="relative">
              <div class="flex gap-4 mt-4">
                <div class="w-3/4">
                  <label for="kelurahan_domisili" class="block text-sm font-medium leading-6 text-[#099AA7]">Kelurahan</label>
                  <input type="text" id="kelurahan_domisili" name=""
                  class="w-full text-gray-900 bg-gray-100 border border-gray-300 rounded-lg shadow-md shadow-slate-400 text-sm px-3 py-2"
                  value="{{ old('kelurahan_domisili', $kelurahan_domisili->kelurahan ?? '') }}" readonly>
                </div>

                <div class="w-1/4">
                  <label for="kode_pos_domisili" class="block text-sm font-medium leading-6 text-[#099AA7]">Kode Pos</label>
                  <input type="text" id="kode_pos_domisili" name=""
                  class="w-full text-gray-900 bg-gray-100 border border-gray-300 rounded-lg shadow-md shadow-slate-400 text-sm px-3 py-2"
                  value="{{ old('kode_pos_domisili', $kode_pos_domisili ?? '') }}" readonly>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
        
      <!-- Container tombol dipisah dari form grid -->
      <div class="w-full flex justify-center mt-6">
        <a href="/pendaftaran-haji" 
        class="px-6 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
          Kembali
        </a>
        <button type="submit" class="px-6 py-2 bg-[#099AA7] text-white rounded-md hover:bg-[#077F8A] ml-4">
          Simpan
        </button>
      </div>
    </form>
  </div>

{{-- Select2 --}}
<script>
  // Customer
  $(document).ready(function () {
      $('#customer_id').select2({
          placeholder: "Pilih", // Placeholder
          allowClear: true, // Bisa menghapus pilihan
          width: '100%' // Sesuaikan dengan Tailwind
      });
  });

  // Wilayah daftar
  $(document).ready(function () {
      $('#wilayah_daftar').select2({
          placeholder: "Pilih", // Placeholder
          allowClear: true, // Bisa menghapus pilihan
          width: '100%' // Sesuaikan dengan Tailwind
      });
  });

  // Cabang
  $(document).ready(function () {
      $('#cabang_id').select2({
          placeholder: "Pilih", // Placeholder
          allowClear: true, // Bisa menghapus pilihan
          width: '100%' // Sesuaikan dengan Tailwind
      });
  });

  // Provinsi
  $(document).ready(function () {
      $('#provinsi').select2({
          placeholder: "Pilih Provinsi", // Placeholder
          allowClear: true, // Bisa menghapus pilihan
          width: '100%' // Sesuaikan dengan Tailwind
      });
  });

  // Kota
  $(document).ready(function () {
      $('#kota').select2({
          placeholder: "Pilih Kota", // Placeholder
          allowClear: true, // Bisa menghapus pilihan
          width: '100%' // Sesuaikan dengan Tailwind
      });
  });
  // Ketika provinsi dipilih, ambil kota yang sesuai
  $('#provinsi').on('change', function () {
    let provinsiID = $(this).val(); // Ambil ID provinsi yang dipilih
    $('#kota').empty().append('<option value="">Pilih Kota</option>'); // Kosongkan dropdown kota

    if (provinsiID) {
        $.ajax({
            url: `/get-kota/${provinsiID}`, // Panggil route Laravel
            type: "GET",
            dataType: "json",
            success: function (data) {
                $.each(data, function (key, value) {
                    $('#kota').append(`<option value="${value.id}">${value.kota}</option>`);
                });
            }
        });
      }
  });

  // Kecamatan
  $(document).ready(function () {
      $('#kecamatan').select2({
          placeholder: "Pilih Kecamatan", // Placeholder
          allowClear: true, // Bisa menghapus pilihan
          width: '100%' // Sesuaikan dengan Tailwind
      });
  });
  // Ketika kota dipilih, ambil kecamatan yang sesuai
  $('#kota').on('change', function () {
      let kotaID = $(this).val();
      $('#kecamatan').empty().append('<option value="">Pilih Kecamatan</option>');

      if (kotaID) {
          $.ajax({
              url: `/get-kecamatan/${kotaID}`,
              type: "GET",
              dataType: "json",
              success: function (data) {
                  $.each(data, function (key, value) {
                      $('#kecamatan').append(`<option value="${value.id}">${value.kecamatan}</option>`);
                  });
              }
          });
        }
    });

    // Kelurahan
    $(document).ready(function () {
        $('#kelurahan').select2({
            placeholder: "Pilih Kelurahan", // Placeholder
            allowClear: true, // Bisa menghapus pilihan
            width: '100%' // Sesuaikan dengan Tailwind
        });
    });

    // Ketika kecamatan dipilih, ambil kelurahan yang sesuai
    $('#kecamatan').on('change', function () {
        let kecamatanID = $(this).val();
        $('#kelurahan').empty().append('<option value="">Pilih Kelurahan</option>');

        if (kecamatanID) {
            $.ajax({
                url: `/get-kelurahan/${kecamatanID}`,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $.each(data, function (key, value) {
                        $('#kelurahan').append(`<option value="${value.id}">${value.kelurahan}</option>`);
                    });
                }
            });
        }
    });

    // Ketika kelurahan dipilih, ambil kode pos
    $('#kelurahan').on('change', function () {
        let kelurahanID = $(this).val();
        $('#kode_pos').val(''); // Reset kode pos

        if (kelurahanID) {
            $.ajax({
                url: `/get-kodepos/${kelurahanID}`,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $('#kode_pos').val(data.kode_pos);
                }
            });
        }
    });

    $(document).ready(function () {
    // Ketika cabang dipilih, ambil kode cabang dan alamat dari database
    $('#cabang_id').on('change', function () {
        let cabangID = $(this).val();
        $('#kode_cab').val(''); // Reset nilai kode cabang
        $('#alamat').val(''); // Reset nilai alamat

        if (cabangID) {
            $.ajax({
                url: `/get-cabang/${cabangID}`, // Panggil route backend
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $('#kode_cab').val(data.kode_cab);
                    $('#alamat').val(data.alamat);
                }
            });
        }
    });
});

</script>
</x-layout>