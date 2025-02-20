<x-layout>
  <div>
    <x-page-title>Edit Data Gabung Haji</x-page-title>
  </div>

  <div class="rounded-lg shadow-lg p-4">
    <form action="/gabung-haji/{{ $gabung_haji->id }}" method="POST">
      @method('PUT')
      @csrf

      <div class="w-full grid grid-cols-1 md:grid-cols-3 gap-7">
        {{-- Kolom 1 --}}
        <div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
            <div>
              <label for="customer_id" class="block text-sm font-medium leading-6 text-[#099AA7]">
                Pilih Customer
              </label>
              <input type="text" name="customer_id" required
                value="{{ old('nama', $gabung_haji->customer->nama) }}"
                class="mb-3 block w-full rounded-md border-0 p-2 bg-gray-100 text-gray-900 shadow-md ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" readonly />
            </div> 

            <div>
              <label class="block text-sm font-medium leading-6 text-[#099AA7]">Nama Panggilan</label>
              <input type="text" name="" placeholder="Nama Panggilan"
              class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
            <div>
              <label class="block text-sm font-medium leading-6 text-[#099AA7]">No SPPH</label>
              <input type="number" name="no_spph" required value="{{ old('no_spph', $gabung_haji->no_spph) }}" placeholder="No SPPH"
              class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900 shadow-md ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>

            <div>
              <label class="block text-sm font-medium leading-6 text-[#099AA7]">No Porsi</label>
              <input type="number" name="no_porsi" required value="{{ old('no_porsi', $gabung_haji->no_porsi) }}" placeholder="No Porsi"
              class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900 shadow-md ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
            <div>
              <label class="block text-sm font-medium leading-6 text-[#099AA7]">Nama Bank</label>
              <input type="text" name="nama_bank" required value="{{ old('nama_bank', $gabung_haji->nama_bank) }}" placeholder="Nama Bank"
                class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900 shadow-md ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>

            <div>
              <label for="kota_bank" class="block text-sm font-medium leading-6 text-[#099AA7]">Kota Bank</label>
              <div class="shadow-md">
                <select name="kota_bank" id="kota_bank" required
                  class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                  <option value="">Pilih</option>
                  @forelse ($kotaBank as $kota)
                      <option value="{{ $kota->id }}"
                        {{ $kota->id == $gabung_haji->kota_bank ? 'selected' : '' }}>
                        {{ $kota->kota }}
                      </option>
                  @empty
                      <option value="">Kota Masih Kosong</option>
                  @endforelse
                </select>
              </div>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
            <div>
              <label class="block text-sm font-medium leading-6 text-[#099AA7]">Estimasi Berangkat</label>
              <input type="number" name="estimasi" required min="1900" max="2099" step="1" value="{{ old('estimasi', $gabung_haji->estimasi) }}" placeholder="YYYY"
                class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900 shadow-md ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>

            <div>
              <label class="block text-sm font-medium leading-6 text-[#099AA7]">Depag</label>
              <input type="text" name="depag" required value="{{ old('depag', $gabung_haji->depag) }}" placeholder="Depag"
              class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900 shadow-md ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>
          </div>

          <!-- Kolom Paket Pendaftaran -->
          {{-- <div class="w-1/2">
            <h3 class="mb-3 font-semibold text-[#099AA7]">Paket Pendaftaran</h3>
            <ul class="w-full text-sm font-medium shadow-lg text-gray-900 bg-white border border-gray-200 rounded-lg">
              <li class="w-full border-b border-gray-200">
                <div class="flex items-center ps-3">
                  <input id="reguler-tunai" type="radio" value="Reguler Tunai" name="paket_haji" required
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                  <label for="reguler-tunai" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">
                    Reguler Tunai
                  </label>
                </div>
              </li>
              <li class="w-full border-b border-gray-200">
                <div class="flex items-center ps-3">
                  <input id="reguler-talangan" type="radio" value="Reguler Talangan" name="paket_haji"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                  <label for="reguler-talangan" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">
                    Reguler Talangan
                  </label>
                </div>
              </li>
              <li class="w-full">
                <div class="flex items-center ps-3">
                  <input id="khusus" type="radio" value="Khusus/Plus" name="paket_haji"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                  <label for="khusus" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">
                    Khusus/Plus
                  </label>
                </div>
              </li>
            </ul>
          </div> --}}

          <div>
            <label for="message" class="block mb-2 mt-4 text-sm font-medium text-[#099AA7]">
              Catatan
            </label>
            <textarea id="message" rows="4" name="catatan"
            class="mb-4 block p-2.5 w-full shadow-md text-sm text-black bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" 
            placeholder="Write your thoughts here...">{{ old('catatan', $gabung_haji->catatan) }}</textarea>
          </div>
        </div>
        
        {{-- Kolom 2 --}}
        <div class="relative">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
            <div>
              <label class="block text-sm font-medium leading-6 text-[#099AA7]">No HP 1</label>
              <input type="text" id="no_hp_1" name="no_hp_1" required placeholder="No HP 1"
                value="{{ old('no_hp_1', $gabung_haji->no_hp_1) }}"
                class="mb-3 block w-full rounded-md bg-gray-100 border-0 p-2 text-gray-900 shadow-md ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6"
                readonly />
            </div>
            <div>
              <label class="block text-sm font-medium leading-6 text-[#099AA7]">No HP 2</label>
              <input type="text" id="no_hp_2" name="no_hp_2" required placeholder="No HP 2"
                value="{{ old('no_hp_2', $gabung_haji->no_hp_2) }}"
                class="mb-3 block w-full rounded-md bg-gray-100 border-0 p-2 text-gray-900 shadow-md ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6"
                readonly />
            </div>
          </div>
        
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div class="shadow-md">
              <label for="tempat_lahir" class="block text-sm font-medium leading-6 text-[#099AA7]">
                Tempat Lahir
              </label>
              <input type="text" name="tempat_lahir" id="tempat_lahir"
                value="{{ $gabung_haji->kotaLahir->kota ?? '' }}"
                class="w-full text-gray-900 bg-gray-100 border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500"
                readonly>
            </div>
            <div>
              <label for="tgl_lahir" class="block text-sm font-medium leading-6 text-[#099AA7]">Tanggal Lahir</label>
              <input type="date" id="tgl_lahir" name="tgl_lahir"
                value="{{ old('tgl_lahir', $gabung_haji->tgl_lahir) }}"
                class="block w-full rounded-md bg-gray-100 border border-gray-300 p-2 text-gray-900 shadow-md focus:ring-2 focus:ring-indigo-600 text-sm leading-6"
                readonly />
            </div>
          </div>

          <!-- Jenis ID, No Identitas, dan Warga -->
          <div class="grid grid-cols-[1fr_2fr_1fr] gap-4">
            <!-- Jenis ID -->
            <div>
              <div>
                <label for="jenis_id" class="block text-sm font-medium leading-6 text-[#099AA7]">Jenis ID</label>
                <input type="text" id="jenis_id" name="jenis_id" value="{{ old('jenis_id', $gabung_haji->jenis_id) }}" readonly
                  class="w-full text-gray-900 bg-gray-100 border border-gray-300 rounded-lg shadow-md text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500" />
              </div>
            </div>

            <!-- Input No Identitas -->
            <div>
              <label for="no_id" class="block text-sm font-medium leading-6 text-[#099AA7]">No ID</label>
              <input type="text" id="no_id" name="no_id" value="{{ old('no_id', $gabung_haji->no_id) }}" readonly
                class="w-full text-gray-900 bg-gray-100 border border-gray-300 rounded-lg shadow-md text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500" />
            </div>

            <!-- Warga -->
            <div>
              <label for="warga" class="block text-sm font-medium leading-6 text-[#099AA7]">Warga</label>
              <input type="text" id="warga" name="warga" value="{{ old('warga', $gabung_haji->warga) }}" readonly
                class="w-full text-gray-900 bg-gray-100 border border-gray-300 rounded-lg shadow-md text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500" />
            </div>          
          </div>

          <div>
            <label for="alamat_ktp" class=" mt-4 block mb-2 text-sm font-medium text-[#099AA7]">
              Alamat Sesuai KTP
            </label>
            <textarea id="alamat_ktp" rows="2" name="alamat_ktp" required
            class="mb-4 block p-2.5 w-full shadow-md text-sm text-black rounded-lg border bg-gray-100 border-gray-300 focus:ring-blue-500 focus:border-blue-500"
            readonly>{{ old('alamat_ktp', $alamat_ktp['alamat'] ?? '') }}</textarea>
          </div>

          <!-- Provinsi -->
          <label class="block text-sm font-medium text-[#099AA7]">Provinsi</label>
          <input type="text" name="provinsi" class="bg-gray-100 shadow-md mt-1 block w-full sm:text-sm border-gray-300 rounded-md"
            value="{{ old('provinsi', $provinsi->provinsi ?? '') }}" readonly>

          <!-- Kota -->
          <label class="block text-sm font-medium text-[#099AA7] mt-4">Kota</label>
          <input type="text" name="kota" class="bg-gray-100 shadow-md mt-1 block w-full sm:text-sm border-gray-300 rounded-md"
              value="{{ old('kota', $kota->kota ?? '') }}" readonly>
        
          <!-- Kecamatan -->
          <label class="block text-sm font-medium text-[#099AA7] mt-4">Kecamatan</label>
          <input type="text" name="kecamatan" class="bg-gray-100 shadow-md mt-1 block w-full sm:text-sm border-gray-300 rounded-md"
              value="{{ old('kecamatan', $kecamatan->kecamatan ?? '') }}" readonly>

          <!-- Kelurahan & Kode Pos dalam flex -->
          <div class="relative">
            <div class="flex gap-4 mt-4">
              <div class="w-3/4">
                <!-- Kelurahan -->
              <label class="block text-sm font-medium text-[#099AA7]">Kelurahan</label>
              <input type="text" name="kelurahan" class="bg-gray-100 shadow-md mt-1 block w-full sm:text-sm border-gray-300 rounded-md"
                  value="{{ old('kelurahan', $kelurahan->kelurahan ?? '') }}" readonly>
              </div>
              <div class="w-1/4">
                <!-- Kode Pos -->
                <label class="block text-sm font-medium text-[#099AA7]">Kode Pos</label>
                <input type="text" name="kode_pos" class="bg-gray-100 shadow-md mt-1 block w-full sm:text-sm border-gray-300 rounded-md"
                    value="{{ old('kode_pos', $kode_pos ?? '') }}" readonly>
              </div>
            </div>
          </div>
        </div>
      
          {{-- Kolom 3 --}}
          <div class="relative">
            <div class="w-full mb-4">
              {{-- Jenis Kelamin & Status Nikah --}}
              <div class="grid grid-cols-1 md:grid-cols-2 gap-2"> 
                <!-- Jenis Kelamin -->
                <div>
                  <label class="block text-sm font-medium leading-6 text-[#099AA7]">Jenis Kelamin</label>
                  <input type="text" id="jenis_kelamin" name="jenis_kelamin" readonly placeholder="Jenis Kelamin"
                    value="{{ old('jenis_kelamin', $gabung_haji->jenis_kelamin ?? '') }}"
                    class="mb-3 block w-full rounded-md border border-gray-300 bg-gray-100 p-2 text-gray-900 shadow-md text-sm leading-6" />
                </div>
            
                <!-- Status Nikah -->
                <div>
                  <label class="block text-sm font-medium leading-6 text-[#099AA7]">Status Nikah</label>
                  <input type="text" id="status_nikah" name="status_nikah" readonly placeholder="Status Nikah"
                    value="{{ old('status_nikah', $gabung_haji->status_nikah ?? '') }}"
                    class="mb-3 block w-full rounded-md border border-gray-300 bg-gray-100 p-2 text-gray-900 shadow-md text-sm leading-6" />
                </div>
              </div>
            
              {{-- Pekerjaan & Pendidikan --}}
              <div class="grid grid-cols-1 md:grid-cols-2 gap-2"> 
                <!-- Pekerjaan -->
                <div>
                  <label class="block text-sm font-medium leading-6 text-[#099AA7]">Pekerjaan</label>
                  <input type="text" id="pekerjaan" name="pekerjaan" readonly placeholder="Pekerjaan"
                    value="{{ old('pekerjaan', $gabung_haji->pekerjaan ?? '') }}"
                    class="mb-3 block w-full rounded-md border border-gray-300 bg-gray-100 p-2 text-gray-900 shadow-md text-sm leading-6" />
                </div>
            
                <!-- Pendidikan -->
                <div>
                  <label class="block text-sm font-medium leading-6 text-[#099AA7]">Pendidikan</label>
                  <input type="text" id="pendidikan" name="pendidikan" readonly placeholder="Pendidikan"
                    value="{{ old('pendidikan', $gabung_haji->pendidikan ?? '') }}"
                    class="mb-3 block w-full rounded-md border border-gray-300 bg-gray-100 p-2 text-gray-900 shadow-md text-sm leading-6" />
                </div>
              </div>
  
              <label for="alamat_domisili" class="block mb-2 text-sm font-medium text-[#099AA7]">
                Alamat Domisili
              </label>
              <textarea id="alamat_domisili" rows="2" name="alamat_domisili" required
                class="mb-4 block shadow-md p-2.5 w-full text-sm text-black bg-gray-100 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                placeholder="Alamat Domisili" readonly>{{ old('alamat_domisili', $alamat_domisili['alamat'] ?? '') }}</textarea>
  
              <!-- Provinsi Domisili -->
              <label for="provinsi_domisili" class="mt-4 block text-sm font-medium leading-6 text-[#099AA7]">
                Provinsi
              </label>
              <input type="text" id="provinsi_domisili" name="provinsi_domisili"
                class="w-full shadow-md text-gray-900 bg-gray-100 border border-gray-300 rounded-lg text-sm px-3 py-2"
                value="{{ old('provinsi_domisili', $provinsi_domisili->provinsi ?? '') }}" readonly>
  
              <!-- Kota Domisili -->
              <label for="kota_domisili" class="mt-4 block text-sm font-medium leading-6 text-[#099AA7]">Kota</label>
              <input type="text" id="kota_domisili" name="kota_domisili"
                class="w-full shadow-md text-gray-900 bg-gray-100 border border-gray-300 rounded-lg text-sm px-3 py-2"
                value="{{ old('kota_domisili', $kota_domisili->kota ?? '') }}" readonly>
  
                <!-- Kecamatan Domisili -->
                <label for="kecamatan_domisili" class="mt-4 block text-sm font-medium leading-6 text-[#099AA7]">Kecamatan</label>
                <input type="text" id="kecamatan_domisili" name="kecamatan_domisili"
                  class="w-full shadow-md text-gray-900 bg-gray-100 border border-gray-300 rounded-lg text-sm px-3 py-2"
                  value="{{ old('kecamatan_domisili', $kecamatan_domisili->kecamatan ?? '') }}" readonly>
  
            <div class="relative">
              <div class="flex gap-4 mt-4">
                <!-- Kolom Kelurahan -->
                <div class="w-3/4">
                  <label for="kelurahan_domisili" class="block text-sm font-medium leading-6 text-[#099AA7]">Kelurahan</label>
                  <input type="text" id="kelurahan_domisili" name="kelurahan_domisili"
                    class="w-full text-gray-900 bg-gray-100 border border-gray-300 rounded-lg shadow-md text-sm px-3 py-2"
                    value="{{ old('kelurahan_domisili', $kelurahan_domisili->kelurahan ?? '') }}" readonly>
                </div>
  
                <!-- Kolom Kode Pos -->
                <div class="w-1/4">
                  <label for="kode_pos_domisili" class="block text-sm font-medium leading-6 text-[#099AA7]">Kode Pos</label>
                  <input type="text" id="kode_pos_domisili" name="kode_pos_domisili"
                    class="w-full text-gray-900 bg-gray-100 border border-gray-300 rounded-lg shadow-md text-sm px-3 py-2"
                    value="{{ old('kode_pos_domisili', $kode_pos_domisili ?? '') }}" readonly>
                </div>
              </div>
            </div>
          </div>
          <!-- Container tombol dipisah dari form grid -->
          <div class="w-full flex justify-center mt-6">
            <a href="/gabung-haji" 
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

  // Bank Kota
  $(document).ready(function () {
      $('#kota_bank').select2({
          placeholder: "Pilih", // Placeholder
          allowClear: true, // Bisa menghapus pilihan
          width: '100%' // Sesuaikan dengan Tailwind
      });
  });

  // // Otomatis menampilkan data customer
  // $(document).ready(function () { 
  //   $('#customer_id').on('change', function () {
  //     let selected = $(this).find(':selected');

  //     // Data Identitas
  //     let jenisId = selected.data('jenis-id') || '';
  //     let noId = selected.data('no-id') || '';
  //     let warga = selected.data('warga') || ''; 
  //     let jenisKelamin = selected.data('jenis-kelamin') || ''; 
  //     let statusNikah = selected.data('status-nikah') || ''; 
  //     let pekerjaan = selected.data('pekerjaan') || ''; 
  //     let pendidikan = selected.data('pendidikan') || ''; 
  //     let tempatLahir = selected.data('tempat-lahir') || ''; 
  //     let tglLahir = selected.data('tgl-lahir') || ''; 

  //     // Data Alamat KTP
  //     let alamatKtp = selected.data('alamat-ktp') || ''; 
  //     let provinsiNama = selected.data('provinsi-nama') || ''; 
  //     let kotaNama = selected.data('kota-nama') || ''; 
  //     let kecamatanNama = selected.data('kecamatan-nama') || ''; 
  //     let kelurahanNama = selected.data('kelurahan-nama') || ''; 
  //     let kodePos = selected.data('kode-pos') || '';

  //     // Data Alamat Domisili
  //     let alamatDomisili = selected.data('alamat-domisili') || ''; 
  //     let provinsiDomisili = selected.data('provinsi-domisili') || ''; 
  //     let kotaDomisili = selected.data('kota-domisili') || ''; 
  //     let kecamatanDomisili = selected.data('kecamatan-domisili') || ''; 
  //     let kelurahanDomisili = selected.data('kelurahan-domisili') || ''; 
  //     let kodePosDomisili = selected.data('kode-pos-domisili') || ''; 

  //     // ID Wilayah Domisili
  //     let provinsiDomisiliId = selected.data('provinsi-domisili-id') || '';
  //     let kotaDomisiliId = selected.data('kota-domisili-id') || '';
  //     let kecamatanDomisiliId = selected.data('kecamatan-domisili-id') || '';
  //     let kelurahanDomisiliId = selected.data('kelurahan-domisili-id') || '';

  //     // Data No HP
  //     let noHp1 = selected.data('no-hp-1') || ''; 
  //     let noHp2 = selected.data('no-hp-2') || ''; 

  //     // Set nilai input
  //     $('#jenis_id').val(jenisId);
  //     $('#no_id').val(noId);
  //     $('#warga').val(warga); 
  //     $('#jenis_kelamin').val(jenisKelamin); 
  //     $('#status_nikah').val(statusNikah); 
  //     $('#pekerjaan').val(pekerjaan); 
  //     $('#pendidikan').val(pendidikan); 
  //     $('#tempat_lahir').val(tempatLahir);
  //     $('#tgl_lahir').val(tglLahir);

  //     // Set nilai input Alamat KTP
  //     $('#alamat_ktp').val(alamatKtp);
  //     $('#provinsi').val(provinsiNama);
  //     $('#kota').val(kotaNama);
  //     $('#kecamatan').val(kecamatanNama);
  //     $('#kelurahan').val(kelurahanNama);
  //     $('#kode_pos').val(kodePos);

  //     // Set nilai input Alamat Domisili
  //     $('#alamat_domisili').val(alamatDomisili);
  //     $('#provinsi_domisili').val(provinsiDomisili);
  //     $('#kota_domisili').val(kotaDomisili);
  //     $('#kecamatan_domisili').val(kecamatanDomisili);
  //     $('#kelurahan_domisili').val(kelurahanDomisili);
  //     $('#kode_pos_domisili').val(kodePosDomisili);

  //     // Set nilai input hidden untuk ID Wilayah Domisili
  //     $('#provinsi_domisili_id').val(provinsiDomisiliId);
  //     $('#kota_domisili_id').val(kotaDomisiliId);
  //     $('#kecamatan_domisili_id').val(kecamatanDomisiliId);
  //     $('#kelurahan_domisili_id').val(kelurahanDomisiliId);

  //     // Set nilai input No HP
  //     $('#no_hp_1').val(noHp1);
  //     $('#no_hp_2').val(noHp2);
  //   });
  // });

  // // Provinsi
  // $(document).ready(function () {
  //     $('#provinsi').select2({
  //         placeholder: "Pilih Provinsi", // Placeholder
  //         allowClear: true, // Bisa menghapus pilihan
  //         width: '100%' // Sesuaikan dengan Tailwind
  //     });
  // });

  // // Kota
  // $(document).ready(function () {
  //     $('#kota').select2({
  //         placeholder: "Pilih Kota", // Placeholder
  //         allowClear: true, // Bisa menghapus pilihan
  //         width: '100%' // Sesuaikan dengan Tailwind
  //     });
  // });
  // // Ketika provinsi dipilih, ambil kota yang sesuai
  // $('#provinsi').on('change', function () {
  //   let provinsiID = $(this).val(); // Ambil ID provinsi yang dipilih
  //   $('#kota').empty().append('<option value="">Pilih Kota</option>'); // Kosongkan dropdown kota

  //   if (provinsiID) {
  //       $.ajax({
  //           url: `/get-kota/${provinsiID}`, // Panggil route Laravel
  //           type: "GET",
  //           dataType: "json",
  //           success: function (data) {
  //               $.each(data, function (key, value) {
  //                   $('#kota').append(`<option value="${value.id}">${value.kota}</option>`);
  //               });
  //           }
  //       });
  //     }
  // });

  // // Kecamatan
  // $(document).ready(function () {
  //     $('#kecamatan').select2({
  //         placeholder: "Pilih Kecamatan", // Placeholder
  //         allowClear: true, // Bisa menghapus pilihan
  //         width: '100%' // Sesuaikan dengan Tailwind
  //     });
  // });
  // // Ketika kota dipilih, ambil kecamatan yang sesuai
  // $('#kota').on('change', function () {
  //     let kotaID = $(this).val();
  //     $('#kecamatan').empty().append('<option value="">Pilih Kecamatan</option>');

  //     if (kotaID) {
  //         $.ajax({
  //             url: `/get-kecamatan/${kotaID}`,
  //             type: "GET",
  //             dataType: "json",
  //             success: function (data) {
  //                 $.each(data, function (key, value) {
  //                     $('#kecamatan').append(`<option value="${value.id}">${value.kecamatan}</option>`);
  //                 });
  //             }
  //         });
  //       }
  //   });

  //   // Kelurahan
  //   $(document).ready(function () {
  //       $('#kelurahan').select2({
  //           placeholder: "Pilih Kelurahan", // Placeholder
  //           allowClear: true, // Bisa menghapus pilihan
  //           width: '100%' // Sesuaikan dengan Tailwind
  //       });
  //   });

  //   // Ketika kecamatan dipilih, ambil kelurahan yang sesuai
  //   $('#kecamatan').on('change', function () {
  //       let kecamatanID = $(this).val();
  //       $('#kelurahan').empty().append('<option value="">Pilih Kelurahan</option>');

  //       if (kecamatanID) {
  //           $.ajax({
  //               url: `/get-kelurahan/${kecamatanID}`,
  //               type: "GET",
  //               dataType: "json",
  //               success: function (data) {
  //                   $.each(data, function (key, value) {
  //                       $('#kelurahan').append(`<option value="${value.id}">${value.kelurahan}</option>`);
  //                   });
  //               }
  //           });
  //       }
  //   });

  //   // Ketika kelurahan dipilih, ambil kode pos
  //   $('#kelurahan').on('change', function () {
  //       let kelurahanID = $(this).val();
  //       $('#kode_pos').val(''); // Reset kode pos

  //       if (kelurahanID) {
  //           $.ajax({
  //               url: `/get-kodepos/${kelurahanID}`,
  //               type: "GET",
  //               dataType: "json",
  //               success: function (data) {
  //                   $('#kode_pos').val(data.kode_pos);
  //               }
  //           });
  //       }
  //   });

  //   $(document).ready(function () {
  //   // Ketika cabang dipilih, ambil kode cabang dan alamat dari database
  //   $('#cabang_id').on('change', function () {
  //       let cabangID = $(this).val();
  //       $('#kode_cab').val(''); // Reset nilai kode cabang
  //       $('#alamat').val(''); // Reset nilai alamat

  //       if (cabangID) {
  //           $.ajax({
  //               url: `/get-cabang/${cabangID}`, // Panggil route backend
  //               type: "GET",
  //               dataType: "json",
  //               success: function (data) {
  //                   $('#kode_cab').val(data.kode_cab);
  //                   $('#alamat').val(data.alamat);
  //               }
  //           });
  //       }
  //   });
  // });

</script>
</x-layout>