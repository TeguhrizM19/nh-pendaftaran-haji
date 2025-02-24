<x-layout>
  <div>
    <x-page-title>Form gabung Haji</x-page-title>
  </div>

  <div class="rounded-lg shadow-lg shadow-black mt-4 p-4">
    <form action="/gabung-haji" method="POST">
      @csrf

      <div class="w-full grid grid-cols-1 md:grid-cols-3 gap-7">
        {{-- Kolom 1 --}}
        <div>
          <div class="relative">
            <div class="flex gap-2 mb-3 items-end">
              <!-- Kolom Nama (Lebih Lebar) -->
              <div class="w-96">
                <label class="block text-sm font-medium leading-6 text-[#099AA7]">
                  Nama Lengkap Customer
                </label>
                <input type="text" name="nama" placeholder="Nama" required
                class="block w-full rounded-md border-0 p-2 text-gray-900 shadow-md shadow-slate-400  ring-1 
                ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 
                text-sm leading-6 uppercase" />
              </div>
              <!-- Tombol Cari -->
              <div class="w-1/6">
                <button type="button" id="openSearch"
                  class="px-2 py-2 bg-[#099AA7] text-white rounded-lg shadow-md shadow-slate-400">
                  🔍 Cari
                </button>
              </div>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-1 gap-2">
            <div>
              <label class="block text-sm font-medium leading-6 text-[#099AA7]">Nama Panggilan</label>
              <input type="text" name="panggilan" placeholder="Nama Panggilan" required
              class="mb-3 block w-full rounded-md shadow-md border-0 p-2 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6 uppercase" />
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
            <div>
              <label class="block text-sm font-medium leading-6 text-[#099AA7]">No SPPH</label>
              <input type="number" name="no_spph" placeholder="No SPPH" required
              class="mb-3 block w-full rounded-md shadow-md border-0 p-2 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6 uppercase" />
            </div>
            <div>
              <label class="block text-sm font-medium leading-6 text-[#099AA7]">Nomor Porsi</label>
              <input type="number" name="no_porsi" placeholder="Nomor Porsi Haji" required
              class="mb-3 block w-full rounded-md shadow-md border-0 p-2 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
            <div>
              <label class="block text-sm font-medium leading-6 text-[#099AA7]">Nama Bank</label>
              <input type="text" name="nama_bank" placeholder="Bank/Jumlah Setoran" required
                class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900 shadow-md ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>

            <div>
              <label for="kota_bank" class="block text-sm font-medium leading-6 text-[#099AA7]">
                Kota Bank
              </label>
              <div class="shadow-md">
                <select name="kota_bank" id="kota_bank" required
                  class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                  <option value="">Pilih Kota Bank</option>
                  @forelse ($kota as $kt)
                    <option value="{{ $kt->id }}">{{ $kt->kota }}</option>
                  @empty
                    <option value="">Kota Bank masih kosong</option>
                  @endforelse
                </select>
              </div>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-1 gap-2">
            <div>
              <label class="block text-sm font-medium leading-6 text-[#099AA7]">Depag</label>
              <input type="text" name="depag" placeholder="depag" required
              class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900 shadow-md ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>
          </div>

          {{-- <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-4">
            <div>
              <label class="block text-sm font-medium leading-6 text-[#099AA7]">Estimasi Barangkat</label>
              <input type="number" name="estimasi" min="1900" max="2099" step="1" placeholder="YYYY" 
                class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900 shadow-md ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>

            <div>
              <label class="block text-sm font-medium leading-6 text-[#099AA7]">BPJS</label>
              <input type="number" name="bpjs" placeholder="No BPJS" 
              class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900 shadow-md ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>
          </div> --}}

          <div class="flex gap-6 mt-3">
            <!-- Kolom Paket Pendaftaran -->
            {{-- <div class="w-1/2">
              <h3 class="mb-3 font-semibold text-[#099AA7]">Paket Pendaftaran</h3>
              <ul class="w-full text-sm font-medium shadow-lg text-gray-900 bg-white border border-gray-200 rounded-lg">
                <li class="w-full border-b border-gray-200">
                  <div class="flex items-center ps-3">
                    <input id="reguler-tunai" type="radio" value="Reguler Tunai" name="paket_haji" 
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
        
            <!-- Kolom Dokumen -->
            {{-- <div class="w-1/2">
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
            </div> --}}
          
          </div>
          <div>
            <label for="message" class="block mb-2 text-sm font-medium text-[#099AA7]">
              Catatan
            </label>
            <textarea id="message" rows="4" name="catatan"
            class="mb-4 shadow-md block p-2.5 w-full text-sm text-black bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" 
            placeholder="Write your thoughts here..."></textarea>
          </div>
        </div>

        {{-- Kolom 2 --}}
        <div class="relative">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
            <div>
              <label class="block text-sm font-medium leading-6 text-[#099AA7]">No HP 1</label>
              <input type="text" name="no_hp_1" placeholder="No HP 1" required
              class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900 shadow-md shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>
            <div>
              <label class="block text-sm font-medium leading-6 text-[#099AA7]">No HP 2</label>
              <input type="text" name="no_hp_2" placeholder="No HP 2" required
              class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900 shadow-md shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <!-- Tempat Lahir -->
            <div class="shadow-md shadow-slate-400">
              <label for="tempat_lahir" class="block text-sm font-medium leading-6 text-[#099AA7]">
                Tempat Lahir
              </label>
              <select name="tempat_lahir" id="tempat_lahir" required
                class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                <option value="">Pilih Tempat Lahir</option>
                @forelse ($kota as $kt)
                  <option value="{{ $kt->id }}">{{ $kt->kota }}</option>
                @empty
                  <option value="">Tempat Lahir masih kosong</option>
                @endforelse
              </select>
            </div>
        
            <!-- Tanggal Lahir -->
            <div>
              <label for="tgl_lahir" class="block text-sm font-medium leading-6 text-[#099AA7]">Tanggal Lahir</label>
              <input type="date" id="tgl_lahir" name="tgl_lahir" required
              class="block w-full rounded-md border border-gray-300 p-2 text-gray-900 shadow-md shadow-slate-400 focus:ring-2 focus:ring-indigo-600 text-sm leading-6" />
            </div>
          </div>
        
          <!-- Jenis ID, No Identitas, dan Warga -->
          <div class="grid grid-cols-[1fr_2fr_1fr] gap-4">
            <!-- Dropdown Jenis ID -->
            <div>
              <div>
                <label for="jenis_id" class="block text-sm font-medium leading-6 text-[#099AA7]">Jenis ID</label>
                <select id="jenis_id" name="jenis_id" required
                  class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg shadow-md shadow-slate-400 text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                  <option value="">Pilih</option>
                  <option value="KTP">KTP</option>
                  <option value="SIM">SIM</option>
                </select>
              </div>
            </div>
            <!-- Input No Identitas (Lebih Lebar) -->
            <div>
              <label for="no_id" class="block text-sm font-medium leading-6 text-[#099AA7]">
                No Identitas
              </label>
              <input type="text" id="no_id" name="no_id" placeholder="Masukkan No Identitas" required
              class="block w-full rounded-md border-0 p-2 text-gray-900 shadow-md shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>

            <!-- Dropdown Warga -->
            <div>
              <label for="warga" class="block text-sm font-medium leading-6 text-[#099AA7]">Warga</label>
              <select id="warga" name="warga" required
                class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg shadow-md shadow-slate-400 text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                <option value="">Pilih</option>
                <option value="WNI">WNI</option>
                <option value="WNA">WNA</option>
              </select>
            </div>            
          </div>
        
          <div>
            <label for="alamat_ktp" class="block mb-2 mt-4 text-sm font-medium text-[#099AA7]">
              Alamat Sesuai KTP
            </label>
            <textarea id="alamat_ktp" rows="2" name="alamat_ktp" required
            class="block p-2.5 w-full text-sm text-black bg-white shadow-md shadow-slate-400 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" 
            placeholder="Write your thoughts here..."></textarea>
          </div>

          <div class="shadow-md shadow-slate-400">
            <label for="provinsi" class="mt-4 block text-sm font-medium leading-6 text-[#099AA7]">
              Provinsi
            </label>
            <select name="provinsi_ktp_id" id="provinsi_ktp"
            class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
              <option value="">Pilih Provinsi</option>
              @forelse ($provinsi as $prov)
                <option value="{{ $prov->id }}">{{ $prov->provinsi }}</option>
              @empty
                <option value="">Provinsi masih kosong</option>
              @endforelse
            </select>
          </div>

          <div class="shadow-md shadow-slate-400">
            <label for="kota_ktp" class="mt-4 block text-sm font-medium leading-6 text-[#099AA7]">Kota</label>
            <select name="kota_ktp_id" id="kota_ktp" required
            class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
              <option value="">Pilih Kota</option>
            </select>
          </div>

          <div class="shadow-md shadow-slate-400">
            <label for="kecamatan_ktp" class="mt-4 block text-sm font-medium leading-6 text-[#099AA7]">Kecamatan</label>
            <select name="kecamatan_ktp_id" id="kecamatan_ktp" required
            class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
              <option value="">Pilih Kecamatan</option>
            </select>
          </div>

          <div class="relative">
            <div class="flex gap-4 mt-4">
              <!-- Kolom Kelurahan (Lebih Lebar) -->
              <div class="w-3/4 shadow-md shadow-slate-400">
                <label for="kelurahan_ktp" class="block text-sm font-medium leading-6 text-[#099AA7]">Kelurahan</label>
                <select name="kelurahan_ktp_id" id="kelurahan_ktp" required
                class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                  <option value="">Pilih Kelurahan</option>
                </select>
              </div>
      
              <!-- Kolom Kode Pos (Lebih Kecil) -->
              <div class="w-1/4">
                <label for="kode_pos_ktp" class="block text-sm font-medium leading-6 text-[#099AA7]">
                  Kode Pos
                </label>
                <input type="text" id="kode_pos_ktp"
                  class="bg-gray-100 border border-gray-300 text-gray-900 shadow-md shadow-slate-400 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 cursor-not-allowed"
                  disabled>
              </div>
            </div>            
          </div>
        </div>
        
        {{-- Kolom 3 Alamat Domisili --}}
        <div class="relative">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Dropdown Jenis Kelamin -->
            <div>
              <label class="mb-2 block text-sm font-medium text-[#099AA7]">Jenis Kelamin</label>
              <ul class="w-full text-sm font-medium shadow-lg text-gray-900 bg-white border border-gray-200 rounded-lg">
                @foreach (['Laki-Laki', 'Perempuan'] as $gender)
                <li class="w-full border-b border-gray-200 last:border-b-0">
                  <div class="flex items-center ps-3">
                    <input id="{{ strtolower($gender) }}" type="radio" value="{{ $gender }}" name="jenis_kelamin" required
                      class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 focus:ring-2"
                      {{ old('jenis_kelamin', $customer->jenis_kelamin ?? '') == $gender ? 'checked' : '' }}>
                    <label for="{{ strtolower($gender) }}" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">
                      {{ $gender }}
                    </label>
                  </div>
                </li>
                @endforeach
              </ul>
            </div>
          
            <!-- Dropdown Status -->
            <div>
              <label class="mb-2 block text-sm font-medium text-[#099AA7]">Status</label>
              <ul class="w-full text-sm font-medium shadow-lg text-gray-900 bg-white border border-gray-200 rounded-lg">
                @foreach (['Menikah', 'Belum Menikah', 'Janda/Duda'] as $status)
                <li class="w-full border-b border-gray-200 last:border-b-0">
                  <div class="flex items-center ps-3">
                    <input id="{{ str_replace('/', '-', strtolower($status)) }}" type="radio" value="{{ $status }}" name="status_nikah" required
                      class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 focus:ring-2"
                      {{ old('status_nikah', $customer->status_nikah ?? '') == $status ? 'checked' : '' }}>
                    <label for="{{ str_replace('/', '-', strtolower($status)) }}" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">
                      {{ $status }}
                    </label>
                  </div>
                </li>
                @endforeach
              </ul>
            </div>
          </div>
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-4">
            <div>
              <label class="block text-sm font-medium leading-6 text-[#099AA7]">Pekerjaan</label>
              <input type="text" name="pekerjaan" placeholder="Pekerjaan" required
              class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900 shadow-md shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>
            <div>
              <label for="pendidikan" class="block text-sm font-medium leading-6 text-[#099AA7]">Pendidikan</label>
              <select id="pendidikan" name="pendidikan" required
                class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg shadow-md shadow-slate-400 text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                <option value="">Pilih</option>
                <option value="Tidak Sekolah">Tidak Sekolah</option>
                <option value="TK">TK</option>
                <option value="SD">SD</option>
                <option value="SMP">SMP</option>
                <option value="SMA">SMA</option>
                <option value="S1">S1</option>
                <option value="S2">S2</option>
                <option value="S3">S3</option>
              </select>
            </div>
          </div>

          <div>
            <div class="flex items-center gap-4 mb-2">
              <label for="alamat_domisili" class="text-sm font-medium text-[#099AA7]">
                Alamat Domisili
              </label>
              <div class="flex items-center gap-2">
                <input id="copy-checkbox" type="checkbox" class="w-5 h-5 text-blue-600 bg-gray-200 border-gray-300 rounded-sm focus:ring-blue-500 focus:ring-2">
                <label for="copy-checkbox" class="text-sm font-medium text-gray-900">
                  Gunakan Alamat KTP
                </label>
              </div>
            </div>            
            <textarea id="alamat_domisili" rows="2" name="alamat_domisili" required
            class="block p-2.5 w-full text-sm text-black bg-white shadow-md shadow-slate-400 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" 
            placeholder="Write your thoughts here..."></textarea>
          </div>

          <div class="shadow-md shadow-slate-400">
            <label for="provinsi_domisili" class="mt-4 block text-sm font-medium leading-6 text-[#099AA7]">Provinsi</label>
            <select name="provinsi_domisili_id" id="provinsi_domisili" required
            class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
              <option value="">Pilih Provinsi</option>
              @forelse ($provinsi as $prov)
                <option value="{{ $prov->id }}">{{ $prov->provinsi }}</option>
              @empty
                <option value="">Provinsi masih kosong</option>
              @endforelse
            </select>
            <input type="hidden" name="provinsi_domisili_id" id="hidden_provinsi_domisili">
          </div>

          <div class="shadow-md shadow-slate-400">
            <label for="kota_domisili" class="mt-4 block text-sm font-medium leading-6 text-[#099AA7]">Kota</label>
            <select name="kota_domisili_id" id="kota_domisili" required
            class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
              <option value="">Pilih Kota</option>
            </select>
            <input type="hidden" name="kota_domisili_id" id="hidden_kota_domisili">
          </div>

          <div class="shadow-md shadow-slate-400">
            <label for="kecamatan_domisili" class="mt-4 block text-sm font-medium leading-6 text-[#099AA7]">Kecamatan</label>
            <select name="kecamatan_domisili_id" id="kecamatan_domisili" required
            class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
              <option value="">Pilih Kecamatan</option>
            </select>
            <input type="hidden" name="kecamatan_domisili_id" id="hidden_kecamatan_domisili">
          </div>

          <div class="relative">
            <div class="flex gap-4 mt-4">
              <!-- Kolom Kelurahan (Lebih Lebar) -->
              <div class="w-3/4 shadow-md shadow-slate-400">
                <label for="kelurahan_domisili" class="block text-sm font-medium leading-6 text-[#099AA7]">Kelurahan</label>
                <select name="kelurahan_domisili_id" id="kelurahan_domisili" required
                  class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                  <option value="">Pilih Kelurahan</option>
                </select>
                <input type="hidden" name="kelurahan_domisili_id" id="hidden_kelurahan_domisili">
              </div>

              <!-- Kolom Kode Pos (Lebih Kecil) -->
              <div class="w-1/4">
                <label for="kode_pos_domisili" class="block text-sm font-medium leading-6 text-[#099AA7]">Kode Pos</label>
                <input type="text" id="kode_pos_domisili"
                  class="bg-gray-100 border border-gray-300 text-gray-900 shadow-md shadow-slate-400 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 cursor-not-allowed"
                  disabled>
              </div>
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

  <!-- Modal Box -->
  <div id="searchModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white w-[1000px] p-6 rounded-lg shadow-lg relative">
      <!-- Tombol Close -->
      <button id="closeSearch" class="absolute top-3 right-3 text-gray-500 text-xl">✖</button>

      <!-- Input Pencarian -->
      <input type="text" id="searchInput"
      class="w-full p-4 border rounded-lg text-lg focus:outline-none focus:ring-2 focus:ring-[#099AA7]"
      placeholder="Search Data..." autocomplete="off">

      <!-- Dropdown hasil pencarian -->
      <div id="searchResults" class="mt-4 bg-white shadow-lg rounded-lg hidden">
        <ul id="customerList">
          <!-- Hasil pencarian akan ditampilkan di sini -->
        </ul>
      </div>
    </div>
  </div>

<script>
  // Tampilkan modal pencarian
  document.getElementById("openSearch").addEventListener("click", function () {
  document.getElementById("searchModal").classList.remove("hidden");
  document.getElementById("searchInput").focus();
  });

  // Tutup modal pencarian
  document.getElementById("closeSearch").addEventListener("click", function () {
  document.getElementById("searchModal").classList.add("hidden");
  });

  // Pencarian real-time menggunakan AJAX
  document.getElementById("searchInput").addEventListener("input", function () {
    let query = this.value.trim();
    let searchResults = document.getElementById("searchResults");
    let customerList = document.getElementById("customerList");

    if (query === "") {
      searchResults.classList.add("hidden");
      customerList.innerHTML = "";
      return;
    }

    fetch(`/search-gabung?query=${encodeURIComponent(query)}`)
    .then(response => response.json())
    .then(data => {
      customerList.innerHTML = ""; // Kosongkan hasil sebelumnya

      if (data.length > 0) {
        data.forEach(item => {
          let li = document.createElement("li");
          li.classList.add("flex", "justify-start", "items-center", "p-4", "hover:bg-blue-100", "cursor-pointer", "gap-4");

          li.innerHTML = `
            <div class="flex-1">
              <span class="font-semibold">No. Porsi: ${item.no_porsi}</span>
              <span class="block text-gray-600">Nama: ${item.customer ? item.customer.nama : 'Tidak Ada'}</span>
            </div>
            <div class="flex gap-2">
              <a href="/repeat-data-gabung/${item.id}" class="repeat-btn bg-[#099AA7] text-white px-4 py-2 rounded-lg text-sm">
                🔄 Repeat Data
              </a>
              <a href="/ambil-semua-data-gabung/${item.id}" class="ambil-btn bg-green-500 text-white px-4 py-2 rounded-lg text-sm">
                📥 Ambil Data
              </a>
            </div>
          `;

          customerList.appendChild(li);
        });

        searchResults.classList.remove("hidden");
      } else {
        customerList.innerHTML = `<li class="p-4 text-gray-500">Tidak ada hasil ditemukan</li>`;
      }
    })
    .catch(error => console.error('Error:', error));

  });

  // Tutup dropdown saat kehilangan fokus
  document.getElementById("searchInput").addEventListener("blur", function () {
    setTimeout(() => {
      document.getElementById("searchResults").classList.add("hidden");
    }, 200);
  });

  // Event delegation untuk tombol Repeat
  document.getElementById("customerList").addEventListener("click", function (e) {
    let listItem = e.target.closest("li");
    if (!listItem) return;

    let customerId = listItem.dataset.id;

    if (e.target.classList.contains("repeat-btn")) {
      // Arahkan ke halaman dengan ID di URL (GET method)
      window.location.href = `/repeat-data-customer/${customerId}`;
    }
  });


  // Checkbox Gunakan alamat KTP
  document.getElementById('copy-checkbox').addEventListener('change', function () { 
    const isChecked = this.checked;

    if (isChecked) {
        document.getElementById('alamat_domisili').value = document.getElementById('alamat_ktp').value;
        document.getElementById('provinsi_domisili').value = document.getElementById('provinsi_ktp').value;
        document.getElementById('hidden_provinsi_domisili').value = document.getElementById('provinsi_ktp').value;

        document.getElementById('provinsi_domisili').dispatchEvent(new Event('change'));

        setTimeout(() => {
            document.getElementById('kota_domisili').value = document.getElementById('kota_ktp').value;
            document.getElementById('hidden_kota_domisili').value = document.getElementById('kota_ktp').value;
            document.getElementById('kota_domisili').dispatchEvent(new Event('change'));
        }, 500);

        setTimeout(() => {
            document.getElementById('kecamatan_domisili').value = document.getElementById('kecamatan_ktp').value;
            document.getElementById('hidden_kecamatan_domisili').value = document.getElementById('kecamatan_ktp').value;
            document.getElementById('kecamatan_domisili').dispatchEvent(new Event('change'));
        }, 1000);

        setTimeout(() => {
            document.getElementById('kelurahan_domisili').value = document.getElementById('kelurahan_ktp').value;
            document.getElementById('hidden_kelurahan_domisili').value = document.getElementById('kelurahan_ktp').value;
            document.getElementById('kelurahan_domisili').dispatchEvent(new Event('change'));
        }, 1500);

        document.getElementById('kode_pos_domisili').value = document.getElementById('kode_pos_ktp').value;
    } else {
        document.getElementById('alamat_domisili').value = "";
        document.getElementById('provinsi_domisili').value = "";
        document.getElementById('hidden_provinsi_domisili').value = "";
        document.getElementById('kota_domisili').value = "";
        document.getElementById('hidden_kota_domisili').value = "";
        document.getElementById('kecamatan_domisili').value = "";
        document.getElementById('hidden_kecamatan_domisili').value = "";
        document.getElementById('kelurahan_domisili').value = "";
        document.getElementById('hidden_kelurahan_domisili').value = "";
        document.getElementById('kode_pos_domisili').value = "";
    }
  });

  // Select2
  // Tempat Lahir
  $(document).ready(function () {
    $('#tempat_lahir').select2({
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

  // Kota Bank
  $(document).ready(function () {
    $('#kota_bank').select2({
      placeholder: "Pilih", // Placeholder
      allowClear: true, // Bisa menghapus pilihan
      width: '100%' // Sesuaikan dengan Tailwind
    });
  });

  // JS untuk KTP
  // Provinsi
  $(document).ready(function () {
    $('#provinsi_ktp').select2({
      placeholder: "Pilih Provinsi", // Placeholder
      allowClear: true, // Bisa menghapus pilihan
      width: '100%' // Sesuaikan dengan Tailwind
    });
  });

  // Kota
  $(document).ready(function () {
    $('#kota_ktp').select2({
      placeholder: "Pilih Kota", // Placeholder
      allowClear: true, // Bisa menghapus pilihan
      width: '100%' // Sesuaikan dengan Tailwind
    });
  });
  // Ketika provinsi dipilih, ambil kota yang sesuai
  $('#provinsi_ktp').on('change', function () {
      let provinsiID = $(this).val(); // Ambil ID provinsi yang dipilih
      $('#kota_ktp').empty().append('<option value="">Pilih Kota</option>'); // Kosongkan dropdown kota

      if (provinsiID) {
        $.ajax({
          url: `/get-kota/${provinsiID}`, // Panggil route Laravel
          type: "GET",
          dataType: "json",
          success: function (data) {
              $.each(data, function (key, value) {
                  $('#kota_ktp').append(`<option value="${value.id}">${value.kota}</option>`);
              });
            }
        });
      }
    });

        // Kecamatan
        $(document).ready(function () {
            $('#kecamatan_ktp').select2({
                placeholder: "Pilih Kecamatan", // Placeholder
                allowClear: true, // Bisa menghapus pilihan
                width: '100%' // Sesuaikan dengan Tailwind
            });
        });
        // Ketika kota dipilih, ambil kecamatan yang sesuai
        $('#kota_ktp').on('change', function () {
            let kotaID = $(this).val();
            $('#kecamatan_ktp').empty().append('<option value="">Pilih Kecamatan</option>');

            if (kotaID) {
                $.ajax({
                    url: `/get-kecamatan/${kotaID}`,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $.each(data, function (key, value) {
                            $('#kecamatan_ktp').append(`<option value="${value.id}">${value.kecamatan}</option>`);
                        });
                    }
                });
            }
        });

        // Kelurahan
        $(document).ready(function () {
            $('#kelurahan_ktp').select2({
                placeholder: "Pilih Kelurahan", // Placeholder
                allowClear: true, // Bisa menghapus pilihan
                width: '100%' // Sesuaikan dengan Tailwind
            });
        });

        // Ketika kecamatan dipilih, ambil kelurahan yang sesuai
        $('#kecamatan_ktp').on('change', function () {
            let kecamatanID = $(this).val();
            $('#kelurahan_ktp').empty().append('<option value="">Pilih Kelurahan</option>');

            if (kecamatanID) {
                $.ajax({
                    url: `/get-kelurahan/${kecamatanID}`,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $.each(data, function (key, value) {
                            $('#kelurahan_ktp').append(`<option value="${value.id}">${value.kelurahan}</option>`);
                        });
                    }
                });
            }
        });

        // Ketika kelurahan dipilih, ambil kode pos
        $('#kelurahan_ktp').on('change', function () {
            let kelurahanID = $(this).val();
            $('#kode_pos_ktp').val(''); // Reset kode pos

            if (kelurahanID) {
                $.ajax({
                    url: `/get-kodepos/${kelurahanID}`,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $('#kode_pos_ktp').val(data.kode_pos);
                    }
                });
            }
        });


  // JS untuk Domisili
  // Provinsi
  $(document).ready(function () {
      $('#provinsi_domisili').select2({
          placeholder: "Pilih Provinsi", // Placeholder
          allowClear: true, // Bisa menghapus pilihan
          width: '100%' // Sesuaikan dengan Tailwind
      });
  });

  // Kota
  $(document).ready(function () {
      $('#kota_domisili').select2({
          placeholder: "Pilih Kota", // Placeholder
          allowClear: true, // Bisa menghapus pilihan
          width: '100%' // Sesuaikan dengan Tailwind
      });
  });
  // Ketika provinsi dipilih, ambil kota yang sesuai
  $('#provinsi_domisili').on('change', function () {
            let provinsiID = $(this).val(); // Ambil ID provinsi yang dipilih
            $('#kota_domisili').empty().append('<option value="">Pilih Kota</option>'); // Kosongkan dropdown kota

            if (provinsiID) {
                $.ajax({
                    url: `/get-kota/${provinsiID}`, // Panggil route Laravel
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $.each(data, function (key, value) {
                            $('#kota_domisili').append(`<option value="${value.id}">${value.kota}</option>`);
                        });
                    }
                });
            }
        });

        // Kecamatan
        $(document).ready(function () {
            $('#kecamatan_domisili').select2({
                placeholder: "Pilih Kecamatan", // Placeholder
                allowClear: true, // Bisa menghapus pilihan
                width: '100%' // Sesuaikan dengan Tailwind
            });
        });
        // Ketika kota dipilih, ambil kecamatan yang sesuai
        $('#kota_domisili').on('change', function () {
            let kotaID = $(this).val();
            $('#kecamatan_domisili').empty().append('<option value="">Pilih Kecamatan</option>');

            if (kotaID) {
                $.ajax({
                    url: `/get-kecamatan/${kotaID}`,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $.each(data, function (key, value) {
                            $('#kecamatan_domisili').append(`<option value="${value.id}">${value.kecamatan}</option>`);
                        });
                    }
                });
            }
        });

        // Kelurahan
        // Inisialisasi Select2 untuk Kelurahan Domisili
$(document).ready(function () {
    $('#kelurahan_domisili').select2({
        placeholder: "Pilih Kelurahan",
        allowClear: true,
        width: '100%'
    });
});

// Ketika kecamatan domisili dipilih, ambil kelurahan yang sesuai
$('#kecamatan_domisili').on('change', function () {
    let kecamatanID = $(this).val();
    $('#kelurahan_domisili').empty().append('<option value="">Pilih Kelurahan</option>');

    if (kecamatanID) {
        $.ajax({
            url: `/get-kelurahan/${kecamatanID}`,
            type: "GET",
            dataType: "json",
            success: function (data) {
                $.each(data, function (key, value) {
                    $('#kelurahan_domisili').append(`<option value="${value.id}">${value.kelurahan}</option>`);
                });
            }
        });
    }
});

// Ketika kelurahan domisili dipilih, ambil kode pos yang sesuai
$('#kelurahan_domisili').on('change', function () {
    let kelurahanID = $(this).val();
    $('#kode_pos_domisili').val(''); // Reset kode pos

    if (kelurahanID) {
        $.ajax({
            url: `/get-kodepos/${kelurahanID}`,
            type: "GET",
            dataType: "json",
            success: function (data) {
                $('#kode_pos_domisili').val(data.kode_pos);
            }
        });
    }
});

</script>
</x-layout>