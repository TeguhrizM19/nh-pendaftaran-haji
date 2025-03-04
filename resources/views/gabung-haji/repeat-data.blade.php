<x-layout>
  <div>
    <x-page-title>Repeat Data Gabung Haji</x-page-title>
  </div>

  <div class="rounded-lg shadow-lg shadow-black mt-4 p-4">
    <form action="{{ route('gabung-haji.storeRepeatData', $gabung_haji->id) }}" method="POST">
      @csrf
      <input type="hidden" name="customer_id" value="{{ $customer->id }}">

      <div class="w-full grid grid-cols-1 md:grid-cols-3 gap-7">
        {{-- Kolom 1 --}}
        <div>
          <div class="relative">
            <div class="flex gap-2 mb-3 items-end">
              <!-- Kolom Nama (Lebih Lebar) -->
              <div class="w-full">
                <label class="block text-sm font-medium leading-6 text-[#099AA7]">Nama Customer</label>
                <input type="text" name="nama" value="{{ old('nama', $customer->nama) }}" placeholder="Nama" 
                class="block w-full rounded-md border-0 p-2 text-gray-900 shadow-md shadow-slate-400  ring-1 
                ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 
                text-sm leading-6 uppercase" />
              </div>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-1 gap-2">
            <div>
              <label class="block text-sm font-medium leading-6 text-[#099AA7]">Nama Panggilan</label>
              <input type="text" name="panggilan" value="{{ old('panggilan', $customer->panggilan) }}" placeholder="Nama Panggilan"
              class="mb-3 block w-full rounded-md shadow-md border-0 p-2 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6 uppercase" />
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
            <div>
              <label class="block text-sm mb-2 font-medium leading-6 text-[#099AA7]">Nomor spph</label>
              <input type="number" name="no_spph" placeholder="Nomor SPPH" value="{{ old('no_spph') }}" required
              class="mb-3 block w-full rounded-md shadow-md border-0 p-2 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>
            
            <div>
              <label class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">Nomor Porsi Haji</label>
              <input type="number" id="no_porsi" name="no_porsi" placeholder="Masukkan Nomor Porsi" value="{{ old('no_porsi') }}" required
              class="block w-full rounded-md border-0 p-2 text-gray-900 shadow-slate-400 ring-1 ring-inset 
              ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6 
              @error('no_porsi_haji') border-red-500 ring-red-500 focus:ring-red-500 @enderror" />
              
              @error('no_porsi')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
            <div>
              <label class="block text-sm font-medium leading-6 text-[#099AA7]">Nama Bank</label>
              <input type="text" name="nama_bank" value="{{ old('nama_bank', $gabung_haji->nama_bank) }}" placeholder="Bank/Jumlah Setoran" 
                class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900 shadow-md ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>

            <div>
              <label for="kota_bank" class="block text-sm font-medium leading-6 text-[#099AA7]">
                Kota Bank
              </label>
              <div class="shadow-md">
                <select name="kota_bank" id="kota_bank" 
                  class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                  @if(isset($gabung_haji->kota_bank))
                    <option value="{{ $gabung_haji->kota_bank }}" selected>{{ $kotaBank->kota ?? 'Pilih Wilayah Daftar' }}</option>
                  @endif
                </select>
              </div>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-1 gap-2">
            <div>
              <label class="block text-sm font-medium leading-6 text-[#099AA7]">Depag</label>
              <input type="text" name="depag" value="{{ old('depag', $gabung_haji->depag) }}" placeholder="depag" 
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
            placeholder="Write your thoughts here...">{{ old('catatan', $gabung_haji->catatan) }}</textarea>
          </div>
        </div>

        {{-- Kolom 2 --}}
        <div class="relative">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
            <div>
              <label class="block text-sm font-medium leading-6 text-[#099AA7]">No HP 1</label>
              <input type="text" name="no_hp_1" value="{{ old('no_hp_1', $customer->no_hp_1) }}" placeholder="No HP 1" 
              class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900 shadow-md shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>
            <div>
              <label class="block text-sm font-medium leading-6 text-[#099AA7]">No HP 2</label>
              <input type="text" name="no_hp_2" value="{{ old('no_hp_2', $customer->no_hp_2) }}" placeholder="No HP 2"
              class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900 shadow-md shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <!-- Tempat Lahir -->
            <div class="shadow-md shadow-slate-400">
              <label for="tempat_lahir" class="block text-sm font-medium leading-6 text-[#099AA7]">
                Tempat Lahir
              </label>
              <select name="tempat_lahir" id="tempat_lahir" 
                class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                <option value="{{ $customer->tempat_lahir }}" selected>
                  {{ $customer->tempatLahir->kota ?? 'Pilih Tempat Lahir' }}
                </option>
              </select>
            </div>
        
            <!-- Tanggal Lahir -->
            <div>
              <label for="tgl_lahir" class="block text-sm font-medium leading-6 text-[#099AA7]">
                Tanggal Lahir
              </label>
              <input type="date" id="tgl_lahir" name="tgl_lahir" value="{{ old('tgl_lahir', $customer->tgl_lahir) }}"
              class="block w-full rounded-md border border-gray-300 p-2 text-gray-900 shadow-md shadow-slate-400 focus:ring-2 focus:ring-indigo-600 text-sm leading-6" />
            </div>
          </div>
        
          <!-- Jenis ID, No Identitas, dan Warga -->
          <div class="grid grid-cols-[1fr_2fr_1fr] gap-4">
            <!-- Dropdown Jenis ID -->
            <div>
              <div>
                <label for="jenis_id" class="block mb-2 text-sm font-medium leading-6 text-[#099AA7]">Jenis ID</label>
                <select id="jenis_id" name="jenis_id" 
                  class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg shadow-md shadow-slate-400 text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                  <option value="">Pilih</option>
                  <option value="KTP" {{ $customer->jenis_id == 'KTP' ? 'selected' : '' }}>KTP</option>
                  <option value="SIM" {{ $customer->jenis_id == 'SIM' ? 'selected' : '' }}>SIM</option>
                </select>
              </div>
            </div>
            <!-- Input No Identitas (Lebih Lebar) -->
            <div>
              <label for="no_id" class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                No Identitas
              </label>
              <input type="text" id="no_id" name="no_id" value="{{ old('no_id', $customer->no_id) }}" placeholder="Masukkan No Identitas"
              class="block w-full rounded-md border-0 p-2 text-gray-900  shadow-slate-400 ring-1 ring-inset 
                ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6 
                @error('no_id') border-red-500 ring-red-500 focus:ring-red-500 @enderror" />
            
              @error('no_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>

            <!-- Dropdown Warga -->
            <div>
              <label for="warga" class="block text-sm mb-2 font-medium leading-6 text-[#099AA7]">Warga</label>
              <select id="warga" name="warga" 
                class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg shadow-md shadow-slate-400 text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                <option value="">Pilih</option>
                <option value="WNI" {{ $customer->warga == 'WNI' ? 'selected' : '' }}>WNI</option>
                <option value="WNA" {{ $customer->warga == 'WNA' ? 'selected' : '' }}>WNA</option>
              </select>
            </div>            
          </div>

          <div>
            <label for="alamat_ktp" class="block mt-4 mb-2 text-sm font-medium text-[#099AA7]">
              Alamat Sesuai KTP
            </label>
            <textarea id="alamat_ktp" rows="2" name="alamat_ktp"
            class="block p-2.5 w-full text-sm text-black bg-white shadow-md shadow-slate-400 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" 
            placeholder="Write your thoughts here...">{{ old('alamat_ktp', $customer->alamat_ktp) }}</textarea>
          </div>

          <div class="shadow-md shadow-slate-400">
            <label for="provinsi" class="mt-4 block text-sm font-medium leading-6 text-[#099AA7]">
              Provinsi
            </label>
            <select name="provinsi_ktp" id="provinsi_ktp"
            class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
            <option value="{{ $customer->provinsi_ktp ?? '' }}" selected>
              {{ $provinsi_ktp->provinsi ?? 'Pilih Provinsi' }}
            </option>
            </select>
          </div>

          <div class="shadow-md shadow-slate-400">
            <label for="kota_ktp" class="mt-4 block text-sm font-medium leading-6 text-[#099AA7]">Kota</label>
            <select name="kota_ktp" id="kota_ktp" data-selected="{{ $customer->kota_ktp ?? '' }}"
            class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
            <option value="{{ $customer->kota_ktp ?? '' }}" selected>
              {{ $kota_ktp->kota ?? 'Pilih Kota' }}
            </option>
            </select>
          </div>

          <div class="shadow-md shadow-slate-400">
            <label for="kecamatan_ktp" class="mt-4 block text-sm font-medium leading-6 text-[#099AA7]">Kecamatan</label>
            <select name="kecamatan_ktp" id="kecamatan_ktp" data-selected="{{ $customer->kecamatan_ktp ?? '' }}"
            class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
            <option value="{{ $customer->kecamatan_ktp ?? '' }}" selected>
              {{ $kecamatan_ktp->kecamatan ?? 'Pilih Kecamatan' }}
            </option>
            </select>
          </div>

          <div class="relative">
            <div class="flex gap-4 mt-4">
              <!-- Kolom Kelurahan (Lebih Lebar) -->
              <div class="w-full shadow-md shadow-slate-400">
                <label for="kelurahan_ktp" class="block text-sm font-medium leading-6 text-[#099AA7]">Kelurahan</label>
                <select name="kelurahan_ktp" id="kelurahan_ktp" data-selected="{{ $customer->kelurahan_ktp ?? '' }}"
                class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                  <option value="{{ $customer->kelurahan_ktp ?? '' }}" selected>
                    {{ $kelurahan_ktp->kelurahan ?? 'Pilih Kelurahan' }}
                  </option>
                </select>
              </div>
      
              <!-- Kolom Kode Pos (Lebih Kecil) -->
              {{-- <div class="w-1/4">
                <label for="kode_pos_ktp" class="block text-sm font-medium leading-6 text-[#099AA7]">Kode Pos</label>
                <input type="text" id="kode_pos_ktp" name="kode_pos_ktp" 
                value="{{ old('kode_pos_ktp', $kode_pos ?? '') }}"
                class="bg-gray-100 border shadow-md shadow-slate-400 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 cursor-not-allowed"
                readonly>
              </div> --}}
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
                <li class="w-full border-b border-gray-200 last:border-b-0 bg-gray-50 hover:bg-gray-100">
                  <div class="flex items-center ps-3">
                    <input id="{{ strtolower($gender) }}" type="radio" value="{{ $gender }}" name="jenis_kelamin"
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
                <li class="w-full border-b border-gray-200 last:border-b-0 bg-gray-50 hover:bg-gray-100">
                  <div class="flex items-center ps-3">
                    <input id="{{ str_replace('/', '-', strtolower($status)) }}" type="radio" value="{{ $status }}" name="status_nikah"
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
              <input type="text" name="pekerjaan" value="{{ old('pekerjaan', $customer->pekerjaan) }}" placeholder="Pekerjaan" 
              class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900 shadow-md shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>
            <div>
              <label for="pendidikan" class="block text-sm font-medium leading-6 text-[#099AA7]">Pendidikan</label>
              <select id="pendidikan" name="pendidikan" 
                class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg shadow-md shadow-slate-400 text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                <option value="">Pilih</option>
                <option value="Tidak Sekolah">Tidak Sekolah</option>
                <option value="Tidak Sekolah" {{ old('pendidikan', $customer->pendidikan) == "Tidak Sekolah" ? 'selected' : '' }}>Tidak Sekolah</option>
                <option value="TK" {{ old('pendidikan', $customer->pendidikan) == "TK" ? 'selected' : '' }}>TK</option>
                <option value="SD" {{ old('pendidikan', $customer->pendidikan) == "SD" ? 'selected' : '' }}>SD</option>
                <option value="SMP" {{ old('pendidikan', $customer->pendidikan) == "SMP" ? 'selected' : '' }}>SMP</option>
                <option value="SMA" {{ old('pendidikan', $customer->pendidikan) == "SMA" ? 'selected' : '' }}>SMA</option>
                <option value="S1" {{ old('pendidikan', $customer->pendidikan) == "S1" ? 'selected' : '' }}>S1</option>
                <option value="S2" {{ old('pendidikan', $customer->pendidikan) == "S2" ? 'selected' : '' }}>S2</option>
                <option value="S3" {{ old('pendidikan', $customer->pendidikan) == "S3" ? 'selected' : '' }}>S3</option>
              </select>
            </div>
          </div>

          <div>
            <label for="alamat_domisili" class="block mb-2 text-sm font-medium text-[#099AA7]">
              Alamat Domisili
            </label>
            <textarea id="alamat_domisili" rows="2" name="alamat_domisili" required
              class="mb-4 block p-2.5 w-full shadow-md shadow-slate-400 text-sm text-black bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
              placeholder="Alamat Domisili...">{{ old('alamat_domisili', $customer->alamat_domisili) }}</textarea>
          </div>

          <div class="shadow-md shadow-slate-400">
            <label for="provinsi_domisili" class="mt-4 block text-sm font-medium leading-6 text-[#099AA7]">Provinsi</label>
            <select name="provinsi_domisili" id="provinsi_domisili"
            class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
              <option value="{{ $customer->provinsi_domisili ?? '' }}" selected>
                {{ $provinsi_domisili->provinsi ?? 'Pilih Provinsi' }}
              </option>
            </select>
          </div>

          <div class="shadow-md shadow-slate-400">
            <label for="kota_domisili" class="mt-4 block text-sm font-medium leading-6 text-[#099AA7]">Kota</label>
            <select name="kota_domisili" id="kota_domisili" data-selected="{{ $customer->kota_domisili ?? '' }}"
            class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
            <option value="{{ $customer->kota_domisili ?? '' }}" selected>
              {{ $kota_domisili->kota ?? 'Pilih Kota' }}
            </option>
            </select>
          </div>

          <div class="shadow-md shadow-slate-400">
            <label for="kecamatan_domisili" class="mt-4 block text-sm font-medium leading-6 text-[#099AA7]">Kecamatan</label>
            <select name="kecamatan_domisili" id="kecamatan_domisili" data-selected="{{ $customer->kecamatan_domisili ?? '' }}"
            class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
              <option value="{{ $customer->kecamatan_domisili ?? '' }}" selected>
                {{ $kecamatan_domisili->kecamatan ?? 'Pilih Kecamatan' }}
              </option>
            </select>
          </div>

          <div class="relative">
            <div class="flex gap-4 mt-4">
              <!-- Kolom Kelurahan (Lebih Lebar) -->
              <div class="w-full shadow-md shadow-slate-400">
                <label for="kelurahan_domisili" class="block text-sm font-medium leading-6 text-[#099AA7]">Kelurahan</label>
                <select name="kelurahan_domisili" id="kelurahan_domisili" data-selected="{{ $customer->kelurahan_domisili ?? '' }}"
                  class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                  <option value="{{ $customer->kelurahan_domisili ?? '' }}" selected>
                    {{ $kelurahan_domisili->kelurahan ?? 'Pilih kelurahan' }}
                  </option>
                </select>
              </div>

              <!-- Kolom Kode Pos (Lebih Kecil) -->
              {{-- <div class="w-1/4 shadow-md">
                <label for="kode_pos_domisili" class="block text-sm font-medium leading-6 text-[#099AA7]">Kode Pos</label>
                <input type="text" id="kode_pos_domisili" name="kode_pos_domisili"
                value="{{ old('kode_pos_domisili', $kode_pos_domisili) }}"
                class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 cursor-not-allowed"
                readonly>
              </div> --}}
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
  // Select2
  // Tempat Lahir
  $(document).ready(function () { 
    $('#tempat_lahir').select2({
      placeholder: "Pilih Tempat Lahir",
      allowClear: true,
      width: '100%',
      ajax: {
        url: "{{ route('tempat-lahir.search') }}", // Route API untuk pencarian cabang
        dataType: 'json',
        delay: 250, // Mengurangi beban server dengan menunda request
        data: function (params) {
          return { q: params.term || '' }; // Langsung mencari meskipun input kosong
        },
        processResults: function (data) {
          return {
            results: $.map(data, function (item) {
              return { id: item.id, text: item.kota };
            })
          };
        },
        cache: true
      }
    });
  });

  // Kota Bank
  $(document).ready(function () { 
    $('#kota_bank').select2({
      placeholder: "Pilih Kota",
      allowClear: true,
      width: '100%',
      ajax: {
        url: "{{ route('kota-bank.search') }}", // Route API untuk pencarian cabang
        dataType: 'json',
        delay: 250, // Mengurangi beban server dengan menunda request
        data: function (params) {
          return { q: params.term || '' }; // Langsung mencari meskipun input kosong
        },
        processResults: function (data) {
          return {
            results: $.map(data, function (item) {
              return { id: item.id, text: item.kota };
            })
          };
        },
        cache: true
      }
    });
  });

  // JS untuk KTP
  // Provinsi
  // Provinsi KTP
  $(document).ready(function () {
    $('#provinsi_ktp').select2({
      placeholder: "Cari Provinsi...",
      ajax: {
        url: '/search-provinsi',
        dataType: 'json',
        delay: 250,
        data: function (params) {
          return { q: params.term || '' };
        },
        processResults: function (data) {
          return {
            results: $.map(data, function (item) {
              return { id: item.id, text: item.provinsi };
            })
          };
        }
      }
    });

    let selectedProvinsiId = $('#provinsi_ktp').val();
    let selectedKotaId = $('#kota_ktp').data('selected');
    let selectedKecamatanId = $('#kecamatan_ktp').data('selected');
    let selectedKelurahanId = $('#kelurahan_ktp').data('selected');

    $('#kota_ktp').select2({
      placeholder: "Cari Kota...",
      ajax: {
        url: function () {
          return selectedProvinsiId ? '/search-kota/' + selectedProvinsiId : null;
        },
        dataType: 'json',
        delay: 250,
        data: function (params) {
          return { q: params.term || '' };
        },
        processResults: function (data) {
          return {
            results: $.map(data, function (item) {
              return { id: item.id, text: item.kota };
            })
          };
        }
      }
    });

    if (selectedKotaId) {
      $.ajax({
        url: '/search-kota/' + selectedProvinsiId,
        dataType: 'json',
        success: function (data) {
          let kota = data.find(item => item.id == selectedKotaId);
          if (kota) {
            let option = new Option(kota.kota, kota.id, true, true);
            $('#kota_ktp').append(option).trigger('change');
          }

          loadKecamatan(selectedKotaId, selectedKecamatanId);
        }
      });
    }

    function loadKecamatan(kotaId, kecamatanId) {
      $('#kecamatan_ktp').select2({
        placeholder: "Cari Kecamatan...",
        allowClear: true,
        ajax: {
          url: kotaId ? '/search-kecamatan/' + kotaId : null,
          dataType: 'json',
          delay: 250,
          data: function (params) {
            return { q: params.term || '' };
          },
          processResults: function (data) {
            return {
              results: $.map(data, function (item) {
                  return { id: item.id, text: item.kecamatan };
              })
            };
          }
        }
      });

      if (kecamatanId) {
        let option = new Option("Loading...", kecamatanId, true, true);
        $('#kecamatan_ktp').append(option).trigger('change');

        $.ajax({
          url: '/search-kecamatan/' + kotaId,
          dataType: 'json',
          success: function (data) {
            let kecamatan = data.find(item => item.id == kecamatanId);
            if (kecamatan) {
                let option = new Option(kecamatan.kecamatan, kecamatan.id, true, true);
                $('#kecamatan_ktp').empty().append(option).trigger('change');

                // **Panggil loadKelurahan setelah kecamatan terpilih**
                loadKelurahan(kecamatanId, selectedKelurahanId);
            }
          }
        });
      }
    }

    function loadKelurahan(kecamatanId, kelurahanId) {
      $('#kelurahan_ktp').select2({
        placeholder: "Cari Kelurahan...",
        allowClear: true,
        ajax: {
          url: kecamatanId ? '/search-kelurahan/' + kecamatanId : null,
          dataType: 'json',
          delay: 250,
          data: function (params) {
            return { q: params.term || '' };
          },
          processResults: function (data) {
            return {
              results: $.map(data, function (item) {
                return { id: item.id, text: item.kelurahan };
              })
            };
          }
        }
      });

      if (kelurahanId) {
        let option = new Option("Loading...", kelurahanId, true, true);
        $('#kelurahan_ktp').append(option).trigger('change');

        $.ajax({
          url: '/search-kelurahan/' + kecamatanId,
          dataType: 'json',
          success: function (data) {
            let kelurahan = data.find(item => item.id == kelurahanId);
            if (kelurahan) {
              let option = new Option(kelurahan.kelurahan, kelurahan.id, true, true);
              $('#kelurahan_ktp').empty().append(option).trigger('change');
            }
          }
        });
      }
    }

    $('#provinsi_ktp').change(function () {
      let provinsiId = $(this).val();
      $('#kota_ktp').val(null).trigger('change');
      $('#kecamatan_ktp').val(null).trigger('change');
      $('#kelurahan_ktp').val(null).trigger('change');

      $('#kota_ktp').select2({
        placeholder: "Cari Kota...",
        ajax: {
          url: provinsiId ? '/search-kota/' + provinsiId : null,
          dataType: 'json',
          delay: 250,
          data: function (params) {
            return { q: params.term || '' };
          },
          processResults: function (data) {
            return {
              results: $.map(data, function (item) {
                return { id: item.id, text: item.kota };
              })
            };
          }
        }
      });
    });

    $('#kota_ktp').change(function () {
        let kotaId = $(this).val();
        $('#kecamatan_ktp').val(null).trigger('change');
        $('#kelurahan_ktp').val(null).trigger('change');

        loadKecamatan(kotaId, null);
    });

    $('#kecamatan_ktp').change(function () {
        let kecamatanId = $(this).val();
        $('#kelurahan_ktp').val(null).trigger('change');
        loadKelurahan(kecamatanId, null);
    });
  });


  // JS untuk Domisili
  // Provinsi Domisili
  $(document).ready(function () {
    $('#provinsi_domisili').select2({
      placeholder: "Cari Provinsi...",
      ajax: {
        url: '/search-provinsi',
        dataType: 'json',
        delay: 250,
        data: function (params) {
          return { q: params.term || '' };
        },
        processResults: function (data) {
          return {
            results: $.map(data, function (item) {
              return { id: item.id, text: item.provinsi };
            })
          };
        }
      }
    });

    let selectedProvinsiId = $('#provinsi_domisili').val();
    let selectedKotaId = $('#kota_domisili').data('selected');
    let selectedKecamatanId = $('#kecamatan_domisili').data('selected');
    let selectedKelurahanId = $('#kelurahan_domisili').data('selected');

    $('#kota_domisili').select2({
      placeholder: "Cari Kota...",
      ajax: {
        url: function () {
          return selectedProvinsiId ? '/search-kota/' + selectedProvinsiId : null;
        },
        dataType: 'json',
        delay: 250,
        data: function (params) {
          return { q: params.term || '' };
        },
        processResults: function (data) {
          return {
            results: $.map(data, function (item) {
              return { id: item.id, text: item.kota };
            })
          };
        }
      }
    });

    if (selectedKotaId) {
      $.ajax({
        url: '/search-kota/' + selectedProvinsiId,
        dataType: 'json',
        success: function (data) {
          let kota = data.find(item => item.id == selectedKotaId);
          if (kota) {
            let option = new Option(kota.kota, kota.id, true, true);
            $('#kota_domisili').append(option).trigger('change');
          }

          loadKecamatan(selectedKotaId, selectedKecamatanId);
        }
      });
    }

    function loadKecamatan(kotaId, kecamatanId) {
      $('#kecamatan_domisili').select2({
        placeholder: "Cari Kecamatan...",
        allowClear: true,
        ajax: {
          url: kotaId ? '/search-kecamatan/' + kotaId : null,
          dataType: 'json',
          delay: 250,
          data: function (params) {
            return { q: params.term || '' };
          },
          processResults: function (data) {
            return {
              results: $.map(data, function (item) {
                  return { id: item.id, text: item.kecamatan };
              })
            };
          }
        }
      });

      if (kecamatanId) {
        let option = new Option("Loading...", kecamatanId, true, true);
        $('#kecamatan_domisili').append(option).trigger('change');

        $.ajax({
          url: '/search-kecamatan/' + kotaId,
          dataType: 'json',
          success: function (data) {
            let kecamatan = data.find(item => item.id == kecamatanId);
            if (kecamatan) {
                let option = new Option(kecamatan.kecamatan, kecamatan.id, true, true);
                $('#kecamatan_domisili').empty().append(option).trigger('change');

                // **Panggil loadKelurahan setelah kecamatan terpilih**
                loadKelurahan(kecamatanId, selectedKelurahanId);
            }
          }
        });
      }
    }

    function loadKelurahan(kecamatanId, kelurahanId) {
      $('#kelurahan_domisili').select2({
        placeholder: "Cari Kelurahan...",
        allowClear: true,
        ajax: {
          url: kecamatanId ? '/search-kelurahan/' + kecamatanId : null,
          dataType: 'json',
          delay: 250,
          data: function (params) {
            return { q: params.term || '' };
          },
          processResults: function (data) {
            return {
              results: $.map(data, function (item) {
                return { id: item.id, text: item.kelurahan };
              })
            };
          }
        }
      });

      if (kelurahanId) {
        let option = new Option("Loading...", kelurahanId, true, true);
        $('#kelurahan_domisili').append(option).trigger('change');

        $.ajax({
          url: '/search-kelurahan/' + kecamatanId,
          dataType: 'json',
          success: function (data) {
            let kelurahan = data.find(item => item.id == kelurahanId);
            if (kelurahan) {
              let option = new Option(kelurahan.kelurahan, kelurahan.id, true, true);
              $('#kelurahan_domisili').empty().append(option).trigger('change');
            }
          }
        });
      }
    }

    $('#provinsi_domisili').change(function () {
      let provinsiId = $(this).val();
      $('#kota_domisili').val(null).trigger('change');
      $('#kecamatan_domisili').val(null).trigger('change');
      $('#kelurahan_domisili').val(null).trigger('change');

      $('#kota_domisili').select2({
        placeholder: "Cari Kota...",
        ajax: {
          url: provinsiId ? '/search-kota/' + provinsiId : null,
          dataType: 'json',
          delay: 250,
          data: function (params) {
            return { q: params.term || '' };
          },
          processResults: function (data) {
            return {
              results: $.map(data, function (item) {
                return { id: item.id, text: item.kota };
              })
            };
          }
        }
      });
    });

    $('#kota_domisili').change(function () {
        let kotaId = $(this).val();
        $('#kecamatan_domisili').val(null).trigger('change');
        $('#kelurahan_domisili').val(null).trigger('change');

        loadKecamatan(kotaId, null);
    });

    $('#kecamatan_domisili').change(function () {
        let kecamatanId = $(this).val();
        $('#kelurahan_domisili').val(null).trigger('change');
        loadKelurahan(kecamatanId, null);
    });
  });

</script>
</x-layout>