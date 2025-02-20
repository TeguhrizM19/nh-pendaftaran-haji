<x-layout>
  <div>
    <x-page-title>Tambah Data Pendaftar Haji</x-page-title>
  </div>

  <div class="rounded-lg shadow-lg p-4">
    <form action="/pendaftaran-haji" method="POST">
      @csrf
      
      <div class="w-full grid grid-cols-1 md:grid-cols-3 gap-7">
        {{-- Kolom 1 --}}
        <div>
          <div>
            <label class="block text-sm font-medium leading-6 text-[#099AA7]">Nomor Porsi Haji</label>
            <input type="number" name="no_porsi_haji" required placeholder="Nomor Porsi Haji"
              class="mb-3 block w-full rounded-md shadow-md border-0 p-2 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
          </div>

          <div class="w-full mb-4">
            <div class="shadow-md">
              <label for="customer_id" class="block text-sm font-medium leading-6 text-[#099AA7]">
                Pilih Customer
              </label>
              <select name="customer_id" id="customer_id" required 
                class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                <option value="">Pilih Customer</option>
                @foreach ($customers as $customer)
                  @php
                    // Decode data alamat KTP & domisili
                    $alamatKtp = json_decode($customer->alamat_ktp);
                    $alamatDomisili = json_decode($customer->alamat_domisili);

                    // Data KTP
                    $provinsiNama = $provinsi[$alamatKtp->provinsi_id]->provinsi ?? '';
                    $kotaNama = $kota[$alamatKtp->kota_id]->kota ?? '';
                    $kecamatanNama = $kecamatan[$alamatKtp->kecamatan_id]->kecamatan ?? '';
                    $kelurahanNama = $kelurahan[$alamatKtp->kelurahan_id]->kelurahan ?? '';
                    $kodePos = $kelurahan[$alamatKtp->kelurahan_id]->kode_pos ?? '';

                    // Data Domisili
                    $provinsiDomisili = $provinsi[$alamatDomisili->provinsi_id]->provinsi ?? '';
                    $kotaDomisili = $kota[$alamatDomisili->kota_id]->kota ?? '';
                    $kecamatanDomisili = $kecamatan[$alamatDomisili->kecamatan_id]->kecamatan ?? '';
                    $kelurahanDomisili = $kelurahan[$alamatDomisili->kelurahan_id]->kelurahan ?? '';
                    $kodePosDomisili = $kelurahan[$alamatDomisili->kelurahan_id]->kode_pos ?? '';
                  @endphp

                  <option value="{{ $customer->id }}"
                    data-tempat-lahir="{{ $customer->kota_lahir->kota ?? '' }}"
                    data-tgl-lahir="{{ $customer->tgl_lahir ?? '' }}" 
                    data-no-hp-1="{{ $customer->no_hp_1 ?? '' }}"
                    data-no-hp-2="{{ $customer->no_hp_2 ?? '' }}"
                    data-alamat-ktp="{{ $alamatKtp->alamat ?? '' }}"
                    data-jenis-id="{{ $customer->jenis_id ?? '' }}"
                    data-no-id="{{ $customer->no_id ?? '' }}"
                    data-warga="{{ $customer->warga ?? '' }}"
                    data-pekerjaan="{{ $customer->pekerjaan ?? '' }}"
                    data-pendidikan="{{ $customer->pendidikan ?? '' }}"
                    data-provinsi-nama="{{ $provinsiNama }}"
                    data-jenis-kelamin="{{ $customer->jenis_kelamin ?? '' }}"
                    data-status-nikah="{{ $customer->status_nikah ?? '' }}"
                    data-kota-nama="{{ $kotaNama }}"
                    data-kecamatan-nama="{{ $kecamatanNama }}"
                    data-kelurahan-nama="{{ $kelurahanNama }}"
                    data-kode-pos="{{ $kodePos }}"
                    
                    data-alamat-domisili="{{ $alamatDomisili->alamat ?? '' }}"
                    data-provinsi-domisili="{{ $provinsiDomisili }}"
                    data-kota-domisili="{{ $kotaDomisili }}"
                    data-kecamatan-domisili="{{ $kecamatanDomisili }}"
                    data-kelurahan-domisili="{{ $kelurahanDomisili }}"
                    data-kode-pos-domisili="{{ $kodePosDomisili }}"

                    {{-- Tambahkan ID wilayah domisili --}}
                    data-provinsi-domisili-id="{{ $alamatDomisili->provinsi_id ?? '' }}"
                    data-kota-domisili-id="{{ $alamatDomisili->kota_id ?? '' }}"
                    data-kecamatan-domisili-id="{{ $alamatDomisili->kecamatan_id ?? '' }}"
                    data-kelurahan-domisili-id="{{ $alamatDomisili->kelurahan_id ?? '' }}"
                  >
                    {{ $customer->nama }}
                  </option>


                @endforeach
              </select>
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
                  <option value="{{ $cbg->id }}">{{ $cbg->cabang }}</option>
                @endforeach
              </select>
            </div>
            <div class="shadow-md">
              <label for="wilayah_daftar" class="block text-sm font-medium leading-6 text-[#099AA7]">Wilayah Daftar</label>
              <select name="wilayah_daftar" id="wilayah_daftar" required
                class="w-full text-gray-900 bg-white border shadow-md border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                <option value="">Pilih</option>
                @forelse ($wilayahKota as $wilayah)
                  <option value="{{ $wilayah->id }}">{{ $wilayah->kota }}</option>
                @empty
                  <option value="">Wilayah Masih Kosong</option>
                @endforelse
              </select>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-4">
            <div>
              <label class="block text-sm font-medium leading-6 text-[#099AA7]">Estimasi Barangkat</label>
              <input type="number" name="estimasi" min="1900" max="2099" step="1" placeholder="YYYY" required
                class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900 shadow-md ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>

            <div>
              <label class="block text-sm font-medium leading-6 text-[#099AA7]">BPJS</label>
              <input type="number" name="bpjs" placeholder="No BPJS" required
              class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900 shadow-md ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
            <div>
              <label class="block text-sm font-medium leading-6 text-[#099AA7]">Bank</label>
              <input type="text" name="bank" placeholder="Bank/Jumlah Setoran" required
                class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900 shadow-md ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>

            <div class="shadow-md">
              <label for="sumber_info" class="block text-sm font-medium leading-6 text-[#099AA7]">Sumber Informasi</label>
              <select name="sumber_info_id" id="sumber_info" required
                class="w-full text-gray-900 bg-white border shadow-md border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                <option value="">Pilih Sumber Informasi</option>
                @foreach($sumberInfo as $sumber)
                  <option value="{{ $sumber->id }}">{{ $sumber->info }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="flex gap-6 mt-3">
            <!-- Kolom Paket Pendaftaran -->
            <div class="w-1/2">
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
            </div>
        
            <!-- Kolom Dokumen -->
            <div class="w-1/2">
              <h3 class="mb-3 font-semibold text-[#099AA7]">Dokumen</h3>
              <ul class="w-full text-sm font-medium shadow-lg text-gray-900 bg-white border border-gray-200 rounded-lg">
                @foreach ($dokumen as $dok)
                <li class="w-full border-b border-gray-200">
                  <div class="flex items-center ps-3">
                    <input id="dokumen{{ $dok->id }}" type="checkbox" name="dokumen[]" value="{{ $dok->id }}"
                      class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2"
                      {{ in_array($dok->id, $selectedDokumen ?? []) ? 'checked' : '' }}>

                    <label for="dokumen{{ $dok->id }}" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">
                      {{ $dok->dokumen }}
                    </label>
                  </div>
                </li>
                @endforeach
              </ul>
            </div>
          
          </div>
          <div>
            <label for="message" class="block mb-2 mt-4 text-sm font-medium text-[#099AA7]">
              Catatan
            </label>
            <textarea id="message" rows="4" name="catatan"
            class="mb-4 shadow-md block p-2.5 w-full text-sm text-black bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" 
            placeholder="Write your thoughts here..."></textarea>
          </div>
        </div>
        
        {{-- Kolom ke 2 --}}
        <div class="relative">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-2"> 
            <div>
              <label class="block text-sm font-medium leading-6 text-[#099AA7]">No HP 1</label>
              <input type="text" id="no_hp_1" name="no_hp_1" required placeholder="No HP 1" 
              class="mb-3 block w-full rounded-md bg-gray-100 border-0 p-2 text-gray-900 shadow-md ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" readonly />
            </div>
            <div>
              <label class="block text-sm font-medium leading-6 text-[#099AA7]">No HP 2</label>
              <input type="text" id="no_hp_2" name="no_hp_2" required placeholder="No HP 2"
              class="mb-3 block w-full rounded-md bg-gray-100 border-0 p-2 text-gray-900 shadow-md ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" readonly />
            </div>
          </div>
        
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <!-- Tempat Lahir -->
            <div class="shadow-md">
              <label for="tempat_lahir" class="block text-sm font-medium leading-6 text-[#099AA7]">
                Tempat Lahir
              </label>
              <input type="text" name="tempat_lahir" id="tempat_lahir" 
                class="w-full text-gray-900 bg-gray-100 border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500"
                readonly>
            </div>
          
            <!-- Tanggal Lahir -->
            <div>
              <label for="tgl_lahir" class="block text-sm font-medium leading-6 text-[#099AA7]">Tanggal Lahir</label>
              <input type="date" id="tgl_lahir" name="tgl_lahir" readonly
                class="block w-full rounded-md bg-gray-100 border border-gray-300 p-2 text-gray-900 shadow-md focus:ring-2 focus:ring-indigo-600 text-sm leading-6" />
            </div>
          </div>

          <!-- Jenis ID, No Identitas, dan Warga -->
          <div class="grid grid-cols-[1fr_2fr_1fr] gap-4">
            <!-- Jenis ID -->
            <div>
              <div>
                <label for="jenis_id" class="block text-sm font-medium leading-6 text-[#099AA7]">Jenis ID</label>
                <input type="text" id="jenis_id" name="jenis_id" readonly
                  class="w-full text-gray-900 bg-gray-100 border border-gray-300 rounded-lg shadow-md text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500" />
              </div>
            </div>

            <!-- Input No Identitas -->
            <div>
              <label for="no_id" class="block text-sm font-medium leading-6 text-[#099AA7]">No ID</label>
              <input type="text" id="no_id" name="no_id" readonly
                class="w-full text-gray-900 bg-gray-100 border border-gray-300 rounded-lg shadow-md text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500" />
            </div>

            <!-- Dropdown Warga -->
            <div>
              <label for="warga" class="block text-sm font-medium leading-6 text-[#099AA7]">Warga</label>
              <input type="text" id="warga" name="warga" readonly
                class="w-full text-gray-900 bg-gray-100 border border-gray-300 rounded-lg shadow-md text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500" />
            </div>          
          </div>

          <!-- Alamat KTP -->
          <div>
            <label for="alamat_ktp" class=" mt-4 block mb-2 text-sm font-medium text-[#099AA7]">
              Alamat Sesuai KTP
            </label>
            <textarea id="alamat_ktp" rows="2" name="alamat_ktp" required
              class="mb-4 block p-2.5 w-full shadow-md text-sm text-black rounded-lg border bg-gray-100 border-gray-300 focus:ring-blue-500 focus:border-blue-500" readonly
              placeholder="Alamat Sesuai KTP..."></textarea>
          </div>

          <!-- Provinsi -->
          <label for="provinsi" class="block text-sm font-medium leading-6 text-[#099AA7]">Provinsi</label>
          <input type="text" id="provinsi" name="provinsi_nama"
            class="w-full shadow-md text-gray-900 bg-gray-100 border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500"
            placeholder="Provinsi" readonly>
          <input type="hidden" name="provinsi_id" id="provinsi_id">

          <!-- Kota -->
          <label for="kota" class="block mt-4 text-sm font-medium leading-6 text-[#099AA7]">Kota</label>
          <input type="text" id="kota" name="kota_nama"
            class="w-full shadow-md text-gray-900 bg-gray-100 border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500"
            placeholder="Kota" readonly>
          <input type="hidden" name="kota_id" id="kota_id">

          <!-- Kecamatan -->
          <label for="kecamatan" class="mt-4 block text-sm font-medium leading-6 text-[#099AA7]">Kecamatan</label>
          <input type="text" id="kecamatan" name="kecamatan_nama" 
            class="w-full shadow-md text-gray-900 bg-gray-100 border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500" 
            placeholder="Kecamatan" readonly>
          <input type="hidden" name="kecamatan_id" id="kecamatan_id">
        
          <div class="relative">
            <div class="flex gap-4 mt-4">
              <!-- Kolom Kelurahan -->
              <div class="w-3/4">
                <label for="kelurahan" class="block text-sm font-medium leading-6 text-[#099AA7]">Kelurahan</label>
                  <input type="text" id="kelurahan" name="kelurahan_nama"
                  class="bg-gray-100 border border-gray-300 text-gray-900 shadow-md text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 cursor-not-allowed"
                  placeholder="Kelurahan" readonly>
                  <input type="hidden" name="kelurahan_id" id="kelurahan_id">
              </div>
      
              <!-- Kolom Kode Pos -->
              <div class="w-1/4">
                <label for="kode_pos" class="block text-sm font-medium leading-6 text-[#099AA7]">Kode Pos</label>
                <input type="text" id="kode_pos" name="kode_pos"
                  class="bg-gray-100 border border-gray-300 shadow-md text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 cursor-not-allowed"
                  placeholder="Kode Pos" readonly>
              </div>
            </div>
          </div>
        </div>
      
        {{-- Kolom 3 Alamat Domisili --}}
        <div class="relative">
          <div class="w-full mb-4">
            {{-- Jenis Kelamain & Status Nikah --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2"> 
              <!-- Jenis Kelamin -->
              <div>
                <label class="block text-sm font-medium leading-6 text-[#099AA7]">Jenis Kelamin</label>
                <input type="text" id="jenis_kelamin" name="jenis_kelamin" readonly placeholder="Jenis Kelamin"
                class="mb-3 block w-full rounded-md border border-gray-300 bg-gray-100 p-2 text-gray-900 shadow-md text-sm leading-6" />
              </div>
          
              <!-- Status Nikah -->
              <div>
                <label class="block text-sm font-medium leading-6 text-[#099AA7]">Status Nikah</label>
                <input type="text" id="status_nikah" name="status_nikah" readonly placeholder="Status Nikah"
                class="mb-3 block w-full rounded-md border border-gray-300 bg-gray-100 p-2 text-gray-900 shadow-md text-sm leading-6" />
              </div>
            </div>
          
            {{-- Pekerjaan & Pendidikan --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2"> 
              <!-- Pekerjaan -->
              <div>
                <label class="block text-sm font-medium leading-6 text-[#099AA7]">Pekerjaan</label>
                <input type="text" id="pekerjaan" name="pekerjaan" readonly placeholder="Pekerjaan"
                class="mb-3 block w-full rounded-md border border-gray-300 bg-gray-100 p-2 text-gray-900 shadow-md text-sm leading-6" />
              </div>
          
              <!-- Pendidikan -->
              <div>
                <label class="block text-sm font-medium leading-6 text-[#099AA7]">Pendidikan</label>
                <input type="text" id="pendidikan" name="pendidikan" readonly placeholder="Pendidikan"
                class="mb-3 block w-full rounded-md border border-gray-300 bg-gray-100 p-2 text-gray-900 shadow-md text-sm leading-6" />
              </div>
            </div>

            <label for="alamat_domisili" class="block mb-2 text-sm font-medium text-[#099AA7]">
              Alamat Domisili
            </label>
            <textarea id="alamat_domisili" rows="2" name="alamat_domisili" required
              class="mb-4 block shadow-md p-2.5 w-full text-sm text-black bg-gray-100 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
              placeholder="Alamat Domisili" readonly></textarea>
            </div>
        
            <!-- Provinsi Domisili -->
            <label for="provinsi_domisili" class="mt-4 block text-sm font-medium leading-6 text-[#099AA7]">
              Provinsi
            </label>
            <input type="text" id="provinsi_domisili" name="provinsi_domisili"
              class="w-full shadow-md text-gray-900 bg-gray-100 border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500"
              placeholder="Provinsi Domisili" readonly>
              <input type="hidden" id="provinsi_domisili_id" name="provinsi_domisili_id">

            <label for="kota_domisili" class="mt-4 block text-sm font-medium leading-6 text-[#099AA7]">Kota</label>
            <input type="text" id="kota_domisili" name="kota_domisili"
              class="w-full shadow-md text-gray-900 bg-gray-100 border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500"
              placeholder="Kota Domisili" readonly>
            <input type="hidden" id="kota_domisili_id" name="kota_domisili_id">

            <label for="kecamatan_domisili" class="mt-4 block text-sm font-medium leading-6 text-[#099AA7]">Kecamatan</label>
            <input type="text" id="kecamatan_domisili" name="kecamatan_domisili"
              class="w-full shadow-md text-gray-900 bg-gray-100 border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500"
              placeholder="Kecamatan Domisili" readonly>
            <input type="hidden" id="kecamatan_domisili_id" name="kecamatan_domisili_id">

            <div class="relative">
              <div class="flex gap-4 mt-4">
                <!-- Kolom Kelurahan -->
                <div class="w-3/4">
                  <label for="kelurahan_domisili" class="block text-sm font-medium leading-6 text-[#099AA7]">Kelurahan</label>
                  <input type="text" id="kelurahan_domisili" name="kelurahan_domisili"
                    class="w-full text-gray-900 bg-gray-100 border border-gray-300 rounded-lg shadow-md text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500"
                    placeholder="Kelurahan Domisili" readonly>
                  <input type="hidden" id="kelurahan_domisili_id" name="kelurahan_domisili_id">
                </div>
        
                <!-- Kolom Kode Pos -->
                <div class="w-1/4">
                  <label for="kode_pos" class="block text-sm font-medium leading-6 text-[#099AA7]">Kode Pos</label>
                  <input type="text" id="kode_pos_domisili" name="kode_pos_domisili"
                    class="w-full text-gray-900 bg-gray-100 border border-gray-300 rounded-lg shadow-md text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500"
                    placeholder="Kode Pos" readonly>
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

  // Sumber info
  $(document).ready(function () {
    $('#sumber_info').select2({
      placeholder: "Pilih", // Placeholder
      allowClear: true, // Bisa menghapus pilihan
      width: '100%' // Sesuaikan dengan Tailwind
    });
  });

  // Otomatis menampilkan data customer
  $(document).ready(function () {  
    $('#customer_id').on('change', function () {
      let selected = $(this).find(':selected');

      // Data Identitas
      let jenisId = selected.data('jenis-id') || '';
      let noId = selected.data('no-id') || '';
      let warga = selected.data('warga') || ''; 
      let jenisKelamin = selected.data('jenis-kelamin') || ''; 
      let statusNikah = selected.data('status-nikah') || ''; 
      let pekerjaan = selected.data('pekerjaan') || ''; 
      let pendidikan = selected.data('pendidikan') || ''; 
      let tempatLahir = selected.data('tempat-lahir') || ''; 
      let tglLahir = selected.data('tgl-lahir') || ''; 

      // Data Alamat KTP
      let alamatKtp = selected.data('alamat-ktp') || ''; 
      let provinsiNama = selected.data('provinsi-nama') || ''; 
      let kotaNama = selected.data('kota-nama') || ''; 
      let kecamatanNama = selected.data('kecamatan-nama') || ''; 
      let kelurahanNama = selected.data('kelurahan-nama') || ''; 
      let kodePos = selected.data('kode-pos') || '';

      // Data Alamat Domisili
      let alamatDomisili = selected.data('alamat-domisili') || ''; 
      let provinsiDomisili = selected.data('provinsi-domisili') || ''; 
      let kotaDomisili = selected.data('kota-domisili') || ''; 
      let kecamatanDomisili = selected.data('kecamatan-domisili') || ''; 
      let kelurahanDomisili = selected.data('kelurahan-domisili') || ''; 
      let kodePosDomisili = selected.data('kode-pos-domisili') || ''; 

      // ID Wilayah Domisili
      let provinsiDomisiliId = selected.data('provinsi-domisili-id') || '';
      let kotaDomisiliId = selected.data('kota-domisili-id') || '';
      let kecamatanDomisiliId = selected.data('kecamatan-domisili-id') || '';
      let kelurahanDomisiliId = selected.data('kelurahan-domisili-id') || '';

      // Data No HP
      let noHp1 = selected.data('no-hp-1') || ''; 
      let noHp2 = selected.data('no-hp-2') || ''; 

      // Set nilai input
      $('#jenis_id').val(jenisId);
      $('#no_id').val(noId);
      $('#warga').val(warga); 
      $('#jenis_kelamin').val(jenisKelamin); 
      $('#status_nikah').val(statusNikah); 
      $('#pekerjaan').val(pekerjaan); 
      $('#pendidikan').val(pendidikan); 
      $('#tempat_lahir').val(tempatLahir);
      $('#tgl_lahir').val(tglLahir);

      // Set nilai input Alamat KTP
      $('#alamat_ktp').val(alamatKtp);
      $('#provinsi').val(provinsiNama);
      $('#kota').val(kotaNama);
      $('#kecamatan').val(kecamatanNama);
      $('#kelurahan').val(kelurahanNama);
      $('#kode_pos').val(kodePos);

      // Set nilai input Alamat Domisili
      $('#alamat_domisili').val(alamatDomisili);
      $('#provinsi_domisili').val(provinsiDomisili);
      $('#kota_domisili').val(kotaDomisili);
      $('#kecamatan_domisili').val(kecamatanDomisili);
      $('#kelurahan_domisili').val(kelurahanDomisili);
      $('#kode_pos_domisili').val(kodePosDomisili);

      // Set nilai input hidden untuk ID Wilayah Domisili
      $('#provinsi_domisili_id').val(provinsiDomisiliId);
      $('#kota_domisili_id').val(kotaDomisiliId);
      $('#kecamatan_domisili_id').val(kecamatanDomisiliId);
      $('#kelurahan_domisili_id').val(kelurahanDomisiliId);

      // Set nilai input No HP
      $('#no_hp_1').val(noHp1);
      $('#no_hp_2').val(noHp2);
    });
});





  
  // wilayah indonesia munkin sudah tidak dipakai
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
  
    // // Ketika kecamatan dipilih, ambil kelurahan yang sesuai
    // $('#kecamatan').on('change', function () {
    //     let kecamatanID = $(this).val();
    //     $('#kelurahan').empty().append('<option value="">Pilih Kelurahan</option>');

    //     if (kecamatanID) {
    //         $.ajax({
    //             url: `/get-kelurahan/${kecamatanID}`,
    //             type: "GET",
    //             dataType: "json",
    //             success: function (data) {
    //                 $.each(data, function (key, value) {
    //                     $('#kelurahan').append(`<option value="${value.id}">${value.kelurahan}</option>`);
    //                 });
    //             }
    //         });
    //     }
    // });

    // // Ketika kelurahan dipilih, ambil kode pos
    // $('#kelurahan').on('change', function () {
    //     let kelurahanID = $(this).val();
    //     $('#kode_pos').val(''); // Reset kode pos

    //     if (kelurahanID) {
    //         $.ajax({
    //             url: `/get-kodepos/${kelurahanID}`,
    //             type: "GET",
    //             dataType: "json",
    //             success: function (data) {
    //                 $('#kode_pos').val(data.kode_pos);
    //             }
    //         });
    //     }
    // });

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