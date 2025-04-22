<x-layout>
  <div>
    <x-page-title>Edit Data Pendaftar Haji</x-page-title>
  </div>

  <div class="rounded-lg shadow-lg shadow-black mt-4 p-4">
    <form id="formPendaftaran" action="/pendaftaran-haji/{{ $daftar_haji->id }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="w-full grid grid-cols-1 md:grid-cols-3 gap-7">
        <!-- Kolom 1 -->
        <div>
          <div class="relative">
            <div class="flex gap-2 mb-3 items-end">
              <!-- Kolom Nama (Lebih Lebar) -->
              <div class="w-full">
                <label class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                  Nama Customer <span class="text-red-500 text-lg">*</span>
                </label>
                  <input type="text" name="nama" id="nama" value="{{ old('nama', $customer->nama) }}" required placeholder="Nama" class="block w-full rounded-md border-0 p-2 text-gray-900 shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6 uppercase" />
              </div>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
            <div>
              <label class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                No HP 1 <span class="text-red-500 text-lg">*</span>
              </label>
              <input type="text" name="no_hp_1" id="no_hp_1" value="{{ old('no_hp_1', $customer->no_hp_1) }}" placeholder="No HP 1" required 
              class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900 shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>
            <div>
              <label class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">No HP 2</label>
              <input type="text" name="no_hp_2" id="no_hp_2" value="{{ old('no_hp_2', $customer->no_hp_2) }}" placeholder="No HP 2"
              class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900 shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <!-- Tempat Lahir -->
            <div class=" shadow-slate-400">
              <label for="tempat_lahir" class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                Tempat Lahir <span class="text-red-500 text-lg">*</span>
              </label>
              <select name="tempat_lahir" id="tempat_lahir" 
                class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                <option value="{{ $customer->tempat_lahir }}" selected>
                  {{ $customer->tempatLahir->kota_lahir ?? 'Pilih Tempat Lahir' }}
                </option>
              </select>
            </div>
        
            <!-- Tanggal Lahir -->
            <div>
              <label for="tgl_lahir" class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                Tanggal Lahir <span class="text-red-500 text-lg">*</span>
              </label>
              <input type="date" id="tgl_lahir" name="tgl_lahir" value="{{ old('tgl_lahir', $customer->tgl_lahir) }}" required 
              class="block w-full rounded-md border border-gray-300 p-2 text-gray-900 shadow-slate-400 focus:ring-2 focus:ring-indigo-600 text-sm leading-6" />
            </div>
          </div>
        
          <!-- Jenis ID, No Identitas, dan Warga -->
          <div class="grid grid-cols-[1fr_2fr_1fr] gap-4">
            <!-- Dropdown Jenis ID -->
            <div>
              <div>
                <label for="jenis_id" class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                  Jenis ID <span class="text-red-500 text-lg">*</span>
                </label>
                <select id="jenis_id" name="jenis_id" required 
                  class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg shadow-slate-400 text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                  <option value="">Pilih</option>
                  <option value="KTP" {{ $customer->jenis_id == 'KTP' ? 'selected' : '' }}>KTP</option>
                  <option value="SIM" {{ $customer->jenis_id == 'SIM' ? 'selected' : '' }}>SIM</option>
                </select>
              </div>
            </div>
            <!-- Input No Identitas (Lebih Lebar) -->
            <div>
              <label for="no_id" class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                No Identitas <span class="text-red-500 text-lg">*</span>
              </label>
              <input type="text" id="no_id" name="no_id" value="{{ old('no_id', $customer->no_id) }}" placeholder="Masukkan No Identitas" required
              class="block w-full rounded-md border-0 p-2 text-gray-900  shadow-slate-400 ring-1 ring-inset 
                ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6 
                @error('no_id') border-red-500 ring-red-500 focus:ring-red-500 @enderror" />
            
              @error('no_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>

            <!-- Dropdown Warga -->
            <div>
              <label for="warga" class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                Warga <span class="text-red-500 text-lg">*</span>
              </label>
              <select id="warga" name="warga" required 
                class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg shadow-slate-400 text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                <option value="">Pilih</option>
                  <option value="WNI" {{ $customer->warga == 'WNI' ? 'selected' : '' }}>WNI</option>
                  <option value="WNA" {{ $customer->warga == 'WNA' ? 'selected' : '' }}>WNA</option>
              </select>
            </div>            
          </div>
        
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <!-- Dropdown Jenis Kelamin -->
            <div class="w-full">
              <h3 class="mb-3 font-semibold text-[#099AA7]">
                Jenis Kelamin <span class="text-red-500 text-lg">*</span>
              </h3>
              <ul class="w-full text-sm font-medium  text-gray-900 bg-white border border-gray-200 rounded-lg">
                <li class="w-full border-b border-gray-200">
                  <div class="flex items-center ps-3">
                    <input id="laki-laki" type="radio" value="Laki-Laki" name="jenis_kelamin" required 
                      class="w-4 h-4 text-blue-600 bg-gray-300 border-gray-300 focus:ring-blue-500 focus:ring-2"
                      {{ $customer->jenis_kelamin == 'Laki-Laki' ? 'checked' : '' }}>
                    <label for="laki-laki" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">
                      Laki-Laki
                    </label>
                  </div>
                </li>
                <li class="w-full">
                  <div class="flex items-center ps-3">
                    <input id="perempuan" type="radio" value="Perempuan" name="jenis_kelamin"
                      class="w-4 h-4 text-blue-600 bg-gray-300 border-gray-300 focus:ring-blue-500 focus:ring-2"
                      {{ $customer->jenis_kelamin == 'Perempuan' ? 'checked' : '' }}>
                    <label for="perempuan" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">
                      Perempuan
                    </label>
                  </div>
                </li>
              </ul>
            </div>
            
            <div class="w-full">
              <h3 class="mb-3 font-semibold text-[#099AA7]">
                Status <span class="text-red-500 text-lg">*</span>
              </h3>
              <ul class="w-full text-sm font-medium  text-gray-900 bg-white border border-gray-200 rounded-lg">
                <li class="w-full border-b border-gray-200">
                  <div class="flex items-center ps-3">
                    <input id="menikah" type="radio" value="Menikah" name="status_nikah" required 
                      class="w-4 h-4 text-blue-600 bg-gray-300 border-gray-300 focus:ring-blue-500 focus:ring-2"
                      {{ $customer->status_nikah == 'Menikah' ? 'checked' : '' }}>
                    <label for="menikah" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">
                      Menikah
                    </label>
                  </div>
                </li>
                <li class="w-full border-b border-gray-200">
                  <div class="flex items-center ps-3">
                    <input id="belum-menikah" type="radio" value="Belum Menikah" name="status_nikah"
                      class="w-4 h-4 text-blue-600 bg-gray-300 border-gray-300 focus:ring-blue-500 focus:ring-2"
                      {{ $customer->status_nikah == 'Belum Menikah' ? 'checked' : '' }}>
                    <label for="belum-menikah" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">
                      Belum Menikah
                    </label>
                  </div>
                </li>
                <li class="w-full">
                  <div class="flex items-center ps-3">
                    <input id="janda-duda" type="radio" value="Janda/Duda" name="status_nikah"
                      class="w-4 h-4 text-blue-600 bg-gray-300 border-gray-300 focus:ring-blue-500 focus:ring-2"
                      {{ $customer->status_nikah == 'Janda/Duda' ? 'checked' : '' }}>
                    <label for="janda-duda" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">
                      Janda/Duda
                    </label>
                  </div>
                </li>
              </ul>
            </div>
          </div>
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-4">
            <div>
              <label class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                Pekerjaan <span class="text-red-500 text-lg">*</span>
              </label>
              <input type="text" name="pekerjaan" id="pekerjaan" value="{{ old('pekerjaan', $customer->pekerjaan) }}" placeholder="Pekerjaan" required 
              class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900 shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>
            <div>
              <label for="pendidikan" class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                Pendidikan <span class="text-red-500 text-lg">*</span>
              </label>
              <select id="pendidikan" name="pendidikan" required
              class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg shadow-slate-400 text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                <option value="">Pilih</option>
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

          <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
            <div>
              <label class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                Instansi
              </label>
              <input type="text" name="instansi" id="instansi" placeholder="instansi" value="{{ old('instansi', $customer->instansi) }}""
              class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900  shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>
            <div>
              <label class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                Jabatan
              </label>
              <input type="text" name="jabatan" id="jabatan" placeholder="jabatan" value="{{ old('jabatan', $customer->jabatan) }}"
              class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900  shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Merokok -->
            <div class="w-full">
              <h3 class="mb-3 font-semibold text-[#099AA7]">
                Merokok
              </h3>
              <ul class="w-full text-sm font-medium  text-gray-900 bg-white border border-gray-200 rounded-lg">
                <li class="w-full border-b border-gray-200">
                  <div class="flex items-center ps-3">
                    <input id="ya" type="radio" value="Ya" name="merokok" 
                      class="w-4 h-4 text-blue-600 bg-gray-300 border-gray-300 focus:ring-blue-500 focus:ring-2"
                      {{ $customer->merokok == 'Ya' ? 'checked' : '' }}>
                    <label for="ya" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">
                      Ya
                    </label>
                  </div>
                </li>
                <li class="w-full">
                  <div class="flex items-center ps-3">
                    <input id="tidak" type="radio" value="Tidak" name="merokok"
                      class="w-4 h-4 text-blue-600 bg-gray-300 border-gray-300 focus:ring-blue-500 focus:ring-2"
                      {{ $customer->merokok == 'Tidak' ? 'checked' : '' }}>
                    <label for="tidak" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">
                      Tidak
                    </label>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <!-- Kolom 2 -->
        <div class="relative">
          <!-- Alamat KTP -->
          <div>
            <label for="alamat_ktp" class="block mb-2 text-sm font-medium text-[#099AA7]">
              Alamat Sesuai KTP <span class="text-red-500 text-lg">*</span>
            </label>
            <textarea id="alamat_ktp" rows="2" name="alamat_ktp"  class="block p-2.5 w-full text-sm text-black bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 uppercase" required
            placeholder="Alamat KTP...">{{ old('alamat_ktp', $customer->alamat_ktp) }}</textarea>
          </div>
      
          <!-- Provinsi KTP -->
          <div class="mt-4">
            <label for="provinsi_ktp" class="mb-2 block text-sm font-medium text-[#099AA7]">
              Provinsi KTP <span class="text-red-500 text-lg">*</span>
            </label>
            <select name="provinsi_ktp" id="provinsi_ktp" required 
              class="block w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm p-2.5 focus:ring-blue-300 focus:border-blue-500">
              <option value="{{ $customer->provinsi_ktp ?? '' }}" selected>
                {{ $provinsi_ktp->provinsi ?? 'Pilih Provinsi' }}
              </option>
            </select>
          </div>
      
          <!-- Kota KTP -->
          <div class="mt-4">
            <label for="kota_ktp" class="mb-2 block text-sm font-medium text-[#099AA7]">
              Kota <span class="text-red-500 text-lg">*</span>
            </label>
            <select name="kota_ktp" id="kota_ktp" data-selected="{{ $customer->kota_ktp ?? '' }}" required 
              class="block w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm p-2.5 focus:ring-blue-300 focus:border-blue-500">
              <option value="{{ $customer->kota_ktp ?? '' }}" selected>
                {{ $kota_ktp->kota ?? 'Pilih Kota' }}
              </option>
            </select>
          </div>
      
          <!-- Kecamatan KTP -->
          <div class="mt-4">
            <label for="kecamatan_ktp" class="mb-2 block text-sm font-medium text-[#099AA7]">
              Kecamatan <span class="text-red-500 text-lg">*</span>
            </label>
            <select name="kecamatan_ktp" id="kecamatan_ktp" data-selected="{{ $customer->kecamatan_ktp ?? '' }}"
              class="block w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm p-2.5 focus:ring-blue-300 focus:border-blue-500">
              <option value="{{ $customer->kecamatan_ktp ?? '' }}" selected>
                {{ $kecamatan_ktp->kecamatan ?? 'Pilih Kecamatan' }}
              </option>
            </select>
          </div>
      
          <!-- Kelurahan KTP -->
          <div class="mt-4">
            <label for="kelurahan_ktp" class="mb-2 block text-sm font-medium text-[#099AA7]">
              Kelurahan <span class="text-red-500 text-lg">*</span>
            </label>
            <select name="kelurahan_ktp" id="kelurahan_ktp" data-selected="{{ $customer->kelurahan_ktp ?? '' }}"
              class="block w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm p-2.5 focus:ring-blue-300 focus:border-blue-500">
              <option value="{{ $customer->kelurahan_ktp ?? '' }}" selected>
                {{ $kelurahan_ktp->kelurahan ?? 'Pilih Kelurahan' }}
              </option>
            </select>
          </div>
      
          <!-- Alamat Domisili -->
          <div class="mt-4">
            <label for="alamat_domisili" class="block mb-2 text-sm font-medium text-[#099AA7]">
              Alamat Domisili <span class="text-red-500 text-lg">*</span>
            </label>
            <textarea id="alamat_domisili" rows="2" name="alamat_domisili" required 
              class="block p-2.5 w-full text-sm text-black bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 uppercase" placeholder="Alamat Domisili...">{{ old('alamat_domisili', $customer->alamat_domisili) }}</textarea>
          </div>
      
          <!-- Provinsi Domisili -->
          <div class="mt-4">
            <label for="provinsi_domisili" class="mb-2 block text-sm font-medium text-[#099AA7]">
              Provinsi <span class="text-red-500 text-lg">*</span>
            </label>
            <select name="provinsi_domisili" id="provinsi_domisili" required 
              class="block w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm p-2.5 focus:ring-blue-300 focus:border-blue-500">
              <option value="{{ $customer->provinsi_domisili ?? '' }}" selected>
                {{ $provinsi_domisili->provinsi ?? 'Pilih Provinsi' }}
              </option>
            </select>
          </div>
      
          <!-- Kota Domisili -->
          <div class="mt-4">
            <label for="kota_domisili" class="mb-2 block text-sm font-medium text-[#099AA7]">
              Kota <span class="text-red-500 text-lg">*</span>
            </label>
            <select name="kota_domisili" id="kota_domisili" data-selected="{{ $customer->kota_domisili ?? '' }}" required 
              class="block w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm p-2.5 focus:ring-blue-300 focus:border-blue-500">
              <option value="{{ $customer->kota_domisili ?? '' }}" selected>
                {{ $kota_domisili->kota ?? 'Pilih Kota' }}
              </option>
            </select>
          </div>
      
          <!-- Kecamatan Domisili -->
          <div class="mt-4">
            <label for="kecamatan_domisili" class="mb-2 block text-sm font-medium text-[#099AA7]">
              Kecamatan <span class="text-red-500 text-lg">*</span>
            </label>
            <select name="kecamatan_domisili" id="kecamatan_domisili" data-selected="{{ $customer->kecamatan_domisili ?? '' }}"
              class="block w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm p-2.5 focus:ring-blue-300 focus:border-blue-500">
              <option value="{{ $customer->kecamatan_domisili ?? '' }}" selected>
                {{ $kecamatan_domisili->kecamatan ?? 'Pilih Kecamatan' }}
              </option>
            </select>
          </div>
      
          <!-- Kelurahan Domisili -->
          <div class="mt-4">
            <label for="kelurahan_domisili" class="mb-2 block text-sm font-medium text-[#099AA7]">
              Kelurahan <span class="text-red-500 text-lg">*</span>
            </label>
            <select name="kelurahan_domisili" id="kelurahan_domisili" data-selected="{{ $customer->kelurahan_domisili ?? '' }}"
              class="block w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm p-2.5 focus:ring-blue-300 focus:border-blue-500">
              <option value="{{ $customer->kelurahan_domisili ?? '' }}" selected>
                {{ $kelurahan_domisili->kelurahan ?? 'Pilih Kelurahan' }}
              </option>
            </select>
          </div>
        </div>
        
        <!-- Kolom 3 -->
        <div class="relative">
          <div>
            <label class="mb-2 mt-1 block text-sm font-medium leading-6 text-[#099AA7]">
              Nomor Porsi Haji
            </label>
            <input type="number" name="no_porsi_haji" id="no_porsi_haji" value="{{ old('no_porsi_haji', $daftar_haji->no_porsi_haji) }}" placeholder="Nomor Porsi Haji"
            class="block w-full rounded-md border-0 p-2 text-gray-900 shadow-slate-400 ring-1 ring-inset 
            ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6 
            @error('no_porsi_haji') border-red-500 ring-red-500 focus:ring-red-500 @enderror" />
            
            @error('no_porsi_haji')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-3">
            <div class="">
              <label for="cabang_id" class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                Cabang Daftar <span class="text-red-500 text-lg">*</span>
              </label>
              <select name="cabang_id" id="cabang_id" required class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                @if(isset($daftar_haji->cabang_id))
                  <option value="{{ $daftar_haji->cabang_id }}" selected>{{ $cabang->cabang ?? 'Pilih Cabang' }}</option>
                @endif
              </select>
            </div>

            <div class="">
              <label for="wilayah_daftar" class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                Wilayah Daftar <span class="text-red-500 text-lg">*</span>
              </label>
              <select name="wilayah_daftar" id="wilayah_daftar" required class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                @if(isset($daftar_haji->wilayah_daftar))
                  <option value="{{ $daftar_haji->wilayah_daftar }}" selected>{{ $wilayahDaftar->kota_lahir ?? 'Pilih Wilayah Daftar' }}</option>
                @endif
              </select>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-4">
            <div>
              <label class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                Bank <span class="text-red-500 text-lg">*</span>
              </label>
              <input type="text" name="bank" id="bank" value="{{ old('bank', $daftar_haji->bank) }}" placeholder="Bank/Jumlah Setoran" required 
                class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>

            <div class="">
              <label for="sumber_info" class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                Sumber Informasi <span class="text-red-500 text-lg">*</span>
              </label>
              <select name="sumber_info_id" id="sumber_info" required 
                class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
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

          <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
            <div>
              <label for="bpjs" class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">BPJS</label>
              <input type="number" id="bpjs" name="bpjs" value="{{ old('bpjs', $daftar_haji->bpjs) }}" placeholder="No BPJS" class="block w-full rounded-md border-0 p-2 text-gray-900 shadow-slate-400 ring-1 ring-insetring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6 
              @error('bpjs') border-red-500 ring-red-500 focus:ring-red-500 @enderror" />
              
              @error('bpjs')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                Tahun Keberangkatan
              </label>
              <select name="keberangkatan_id" id="keberangkatan" 
              class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                @if($keberangkatan)
                  <option value="{{ $keberangkatan->id }}" selected>
                    {{ $keberangkatan->keberangkatan }}
                  </option>
                @endif
              </select>
            </div>
          </div>

          <div class="mt-3">
            <h3 class="mb-3 font-semibold text-[#099AA7]">
              Paket Pendaftaran <span class="text-red-500 text-lg">*</span>
            </h3>
            <ul class="w-full text-sm font-medium  text-gray-900 bg-white border border-gray-200 rounded-lg">
              <!-- Layout desktop (2 kolom), di HP jadi 1 kolom -->
              <div class="grid grid-cols-1 md:grid-cols-2">
                <!-- Reguler Tunai -->
                <li class="border-b border-gray-200">
                  <div class="flex items-center ps-3">
                    <input type="radio" value="Reguler Tunai" name="paket_haji" required
                      class="w-4 h-4 text-blue-600 bg-gray-300 border-gray-300 focus:ring-blue-500 focus:ring-2"
                      {{ $daftar_haji->paket_haji == 'Reguler Tunai' ? 'checked' : '' }}>
                    <label class="w-full py-3 ms-2 text-sm font-medium text-gray-900">
                      Reguler Tunai
                    </label>
                  </div>
                </li>
          
                <!-- Khusus/Plus (di Desktop, ada di samping Reguler Tunai) -->
                <li class="border-b border-gray-200 md:border-b-0">
                  <div class="flex items-center ps-3">
                    <input type="radio" value="Khusus/Plus" name="paket_haji"
                      class="w-4 h-4 text-blue-600 bg-gray-300 border-gray-300 focus:ring-blue-500 focus:ring-2"
                      {{ $daftar_haji->paket_haji == 'Khusus/Plus' ? 'checked' : '' }}>
                    <label class="w-full py-3 ms-2 text-sm font-medium text-gray-900">
                      Khusus/Plus
                    </label>
                  </div>
                </li>
              </div>
          
              <!-- Reguler Talangan (di Desktop ada di bawah Reguler Tunai, di HP tetap urut) -->
              <li class="w-full">
                <div class="flex items-center ps-3">
                  <input type="radio" value="Reguler Talangan" name="paket_haji"
                    class="w-4 h-4 text-blue-600 bg-gray-300 border-gray-300 focus:ring-blue-500 focus:ring-2"
                    {{ $daftar_haji->paket_haji == 'Reguler Talangan' ? 'checked' : '' }}>
                  <label class="w-full py-3 ms-2 text-sm font-medium text-gray-900">
                    Reguler Talangan
                  </label>
                </div>
              </li>
            </ul>
          </div>    
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <!-- Pelunasan haji -->
            <div class="w-full">
              <h3 class="mb-3 font-semibold text-[#099AA7]">Pelunasan haji</h3>
              <ul class="w-full text-sm font-medium  text-gray-900 bg-white border border-gray-200 rounded-lg">
                <li class="w-full border-b border-gray-200">
                  <div class="flex items-center ps-3">
                    <input id="pelunasan_haji" type="radio" value="Lunas" name="pelunasan"
                      class="w-4 h-4 text-blue-600 bg-gray-300 border-gray-300 focus:ring-blue-500 focus:ring-2"
                      {{ $daftar_haji->pelunasan == 'Lunas' ? 'checked' : '' }}>
                    <label for="pelunasan_haji" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">
                      Lunas
                    </label>
                  </div>
                </li>
                <li class="w-full">
                  <div class="flex items-center ps-3">
                    <input id="belum_lunas_haji" type="radio" value="Belum Lunas" name="pelunasan"
                      class="w-4 h-4 text-blue-600 bg-gray-300 border-gray-300 focus:ring-blue-500 focus:ring-2"
                      {{ $daftar_haji->pelunasan == 'Belum Lunas' ? 'checked' : '' }}>
                    <label for="belum_lunas_haji" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">
                      Belum Lunas
                    </label>
                  </div>
                </li>
              </ul>
            </div>
            
            <!-- Pelunasan manasik -->
            {{-- <div class="w-full">
              <h3 class="mb-3 font-semibold text-[#099AA7]">Pelunasan Manasik</h3>
              <ul class="w-full text-sm font-medium  text-gray-900 bg-white border border-gray-200 rounded-lg">
                <li class="w-full border-b border-gray-200">
                  <div class="flex items-center ps-3">
                    <input id="pelunasan_manasik" type="radio" value="Lunas" name="pelunasan_manasik"
                      class="w-4 h-4 text-blue-600 bg-gray-300 border-gray-300 focus:ring-blue-500 focus:ring-2"
                      {{ $daftar_haji->pelunasan_manasik == 'Lunas' ? 'checked' : '' }}>
                    <label for="pelunasan_manasik" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">
                      Lunas
                    </label>
                  </div>
                </li>
                <li class="w-full">
                  <div class="flex items-center ps-3">
                    <input id="belum_lunas_manasik" type="radio" value="Belum Lunas" name="pelunasan_manasik"
                      class="w-4 h-4 text-blue-600 bg-gray-300 border-gray-300 focus:ring-blue-500 focus:ring-2"
                      {{ $daftar_haji->pelunasan_manasik == 'Belum Lunas' ? 'checked' : '' }}>
                    <label for="belum_lunas_manasik" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">
                      Belum Lunas
                    </label>
                  </div>
                </li>
              </ul>
            </div> --}}
          </div>

          <!-- Kolom Dokumen -->
          {{-- <div class="w-full">
            <h3 class="mb-3 mt-3 font-semibold text-[#099AA7]">Dokumen</h3>  
            <ul class="w-full text-sm font-medium  text-gray-900 bg-white border border-gray-200 rounded-lg">
              @foreach ($dokumen as $dok)
                <li class="w-full border-b border-gray-200 last:border-b-0">
                  <div class="flex items-center ps-3">
                    <input type="checkbox" name="dokumen[]" value="{{ $dok->id }}"
                      class="w-4 h-4 text-blue-600 bg-gray-300 border-gray-300 focus:ring-blue-500 focus:ring-2"
                      {{ in_array((string) $dok->id, (array) $selected_documents) ? 'checked' : '' }}>
                    <label class="w-full py-3 ms-2 text-sm font-medium text-gray-900">
                      {{ $dok->dokumen }}
                    </label>
                  </div>
                </li>
              @endforeach
            </ul>
          </div> --}}
          
          {{-- <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-3">
            <!-- KTP -->
            <div>
              <label class="block mb-2 text-sm font-medium text-[#099AA7]" for="ktp">KTP</label>
              
              <!-- Input untuk upload file baru -->
              <input name="ktp" class="block w-full text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" 
                id="ktp" type="file">
            
              <!-- Menampilkan file yang sudah di-upload sebelumnya -->
              @if (!empty($customer->ktp))
                <p class="mt-2 text-sm">
                  File saat ini: 
                  <a href="{{ asset('../public_html/folder-image-truenas/' . $customer->ktp) }}" class="text-blue-600 underline" target="_blank">
                    {{ $customer->ktp }}
                  </a>
                </p>
              @endif
            </div>

            <!-- KK -->
            <div>
              <label class="block mb-2 text-sm font-medium text-[#099AA7]" for="kk">KK</label>
              
              <!-- Input untuk upload file baru -->
              <input name="kk" class="block w-full text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" 
                id="kk" type="file">
            
              <!-- Menampilkan file yang sudah di-upload sebelumnya -->
              @if (!empty($customer->kk))
                <p class="mt-2 text-sm">
                  File saat ini: 
                  <a href="{{ asset('uploads/dokumen_haji/' . $customer->kk) }}" class="text-blue-600 underline" target="_blank">
                    {{ $customer->kk }}
                  </a>
                </p>
              @endif
            </div>

            <!-- Surat Nikah/Akte lahir/Ijazah -->
            <div>
              <label class="block mb-2 text-sm font-medium text-[#099AA7]" for="surat">Surat Nikah/Akte lahir/Ijazah</label>
              
              <!-- Input untuk upload file baru -->
              <input name="surat" class="block w-full text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" 
                id="surat" type="file">
            
              <!-- Menampilkan file yang sudah di-upload sebelumnya -->
              @if (!empty($customer->surat))
                <p class="mt-2 text-sm">
                  File saat ini: 
                  <a href="{{ asset('uploads/dokumen_haji/' . $customer->surat) }}" class="text-blue-600 underline" target="_blank">
                    {{ $customer->surat }}
                  </a>
                </p>
              @endif
            </div>

            <!-- SPPH -->
            <div>
              <label class="block mb-2 text-sm font-medium text-[#099AA7]" for="spph">SPPH</label>
              
              <!-- Input untuk upload file baru -->
              <input name="spph" class="block w-full text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" 
                id="spph" type="file">
            
              <!-- Menampilkan file yang sudah di-upload sebelumnya -->
              @if (!empty($customer->spph))
                <p class="mt-2 text-sm">
                  File saat ini: 
                  <a href="{{ asset('uploads/dokumen_haji/' . $customer->spph) }}" class="text-blue-600 underline" target="_blank">
                    {{ $customer->spph }}
                  </a>
                </p>
              @endif
            </div>

            <!-- BPIH -->
            <div>
              <label class="block mb-2 text-sm font-medium text-[#099AA7]" for="bpih">BPIH</label>
              
              <!-- Input untuk upload file baru -->
              <input name="bpih" class="block w-full text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" 
                id="bpih" type="file">
            
              <!-- Menampilkan file yang sudah di-upload sebelumnya -->
              @if (!empty($customer->bpih))
                <p class="mt-2 text-sm">
                  File saat ini: 
                  <a href="{{ asset('uploads/dokumen_haji/' . $customer->bpih) }}" class="text-blue-600 underline" target="_blank">
                    {{ $customer->bpih }}
                  </a>
                </p>
              @endif
            </div>

            <!-- Pas Photo -->
            <div>
              <label class="block mb-2 text-sm font-medium text-[#099AA7]" for="photo">Pas Photo</label>
              
              <!-- Input untuk upload file baru -->
              <input name="photo" class="block w-full text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" 
                id="photo" type="file">
            
              <!-- Menampilkan file yang sudah di-upload sebelumnya -->
              @if (!empty($customer->photo))
                <p class="mt-2 text-sm">
                  File saat ini: 
                  <a href="{{ asset('uploads/dokumen_haji/' . $customer->photo) }}" class="text-blue-600 underline" target="_blank">
                    {{ $customer->photo }}
                  </a>
                </p>
              @endif
            </div>
          </div> --}}

          <div>
            <label for="catatan" class="block mb-2 mt-4 text-sm font-medium text-[#099AA7]">
              Catatan
            </label>
            <textarea id="catatan" rows="4" name="catatan"
            class="mb-4 block p-2.5 w-full text-sm text-black bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" 
            placeholder="Write your thoughts here...">{{ old('catatan', $daftar_haji->catatan) }}</textarea>
          </div>
        </div>         
      </div>

      <!-- Modal Tambah Perlengkapan -->
      <div id="modal-perlengkapan" tabindex="-1" aria-hidden="true" 
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-7xl max-h-full">
          <!-- Modal content -->
          <div class="relative bg-white rounded-lg shadow-sm">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
              <h3 class="text-xl font-semibold text-gray-900">
                Masukkan Perlengkapan
              </h3>
              <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="modal-perlengkapan">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close modal</span>
              </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5">
              <div class="w-full grid grid-cols-1 md:grid-cols-3 gap-7">
      
                <!-- Kolom Perlengkapan -->
                <div class="mt-3">
                  <span class="font-medium text-gray-900 block mb-2">
                    Perlengkapan yang sudah dibagikan
                  </span>
                  <ul class="w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg">
                    @foreach ($perlengkapan as $data)
                      <li class="w-full border-b border-gray-200 last:border-b-0">
                        <div class="flex items-center ps-3">
                          <input type="checkbox" name="perlengkapan[]" value="{{ $data->id }}"
                            class="w-4 h-4 text-blue-600 bg-gray-300 border-gray-300 focus:ring-blue-500 focus:ring-2"
                            {{ in_array((string) $data->id, (array) $selected_perlengkapan) ? 'checked' : '' }}>
                          <label class="w-full py-3 ms-2 text-sm font-medium text-gray-900">
                            {{ $data->perlengkapan }}
                          </label>
                        </div>
                      </li>
                    @endforeach
                  </ul>
                </div>
              
                <!-- Kolom Dokumen -->
                <div class="mt-3">
                  <span class="font-medium text-gray-900 block mb-2">Dokumen</span>
                  <ul class="w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg">
                    @foreach ($dokumen as $dok)
                      <li class="w-full border-b border-gray-200 last:border-b-0">
                        <div class="flex items-center ps-3">
                          <input type="checkbox" name="dokumen[]" value="{{ $dok->id }}"
                            class="w-4 h-4 text-blue-600 bg-gray-300 border-gray-300 focus:ring-blue-500 focus:ring-2"
                            {{ in_array((string) $dok->id, (array) $selected_documents) ? 'checked' : '' }}>
                          <label class="w-full py-3 ms-2 text-sm font-medium text-gray-900">
                            {{ $dok->dokumen }}
                          </label>
                        </div>
                      </li>
                    @endforeach
                  </ul>
                  <!-- Upload File -->
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-3">
                    <!-- KTP -->
                    <div>
                      <label class="block mb-2 text-sm font-medium text-[#099AA7]" for="ktp">KTP</label>
                      
                      <!-- Input untuk upload file baru -->
                      <input name="ktp" class="block w-full text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" 
                        id="ktp" type="file">
                    
                      <!-- Menampilkan file yang sudah di-upload sebelumnya -->
                      @if (!empty($customer->ktp))
                        <p class="mt-2 text-sm">
                          File saat ini: 
                          <a href="{{ asset('../public_html/folder-image-truenas/' . $customer->ktp) }}" class="text-blue-600 underline" target="_blank">
                            {{ $customer->ktp }}
                          </a>
                        </p>
                      @endif
                    </div>
        
                    <!-- KK -->
                    <div>
                      <label class="block mb-2 text-sm font-medium text-[#099AA7]" for="kk">KK</label>
                      
                      <!-- Input untuk upload file baru -->
                      <input name="kk" class="block w-full text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" 
                        id="kk" type="file">
                    
                      <!-- Menampilkan file yang sudah di-upload sebelumnya -->
                      @if (!empty($customer->kk))
                        <p class="mt-2 text-sm">
                          File saat ini: 
                          <a href="{{ asset('uploads/dokumen_haji/' . $customer->kk) }}" class="text-blue-600 underline" target="_blank">
                            {{ $customer->kk }}
                          </a>
                        </p>
                      @endif
                    </div>
        
                    <!-- Surat Nikah/Akte lahir/Ijazah -->
                    <div>
                      <label class="block mb-2 text-sm font-medium text-[#099AA7]" for="surat">Surat Nikah/Akte lahir/Ijazah</label>
                      
                      <!-- Input untuk upload file baru -->
                      <input name="surat" class="block w-full text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" 
                        id="surat" type="file">
                    
                      <!-- Menampilkan file yang sudah di-upload sebelumnya -->
                      @if (!empty($customer->surat))
                        <p class="mt-2 text-sm">
                          File saat ini: 
                          <a href="{{ asset('uploads/dokumen_haji/' . $customer->surat) }}" class="text-blue-600 underline" target="_blank">
                            {{ $customer->surat }}
                          </a>
                        </p>
                      @endif
                    </div>
        
                    <!-- SPPH -->
                    <div>
                      <label class="block mb-2 text-sm font-medium text-[#099AA7]" for="spph">SPPH</label>
                      
                      <!-- Input untuk upload file baru -->
                      <input name="spph" class="block w-full text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" 
                        id="spph" type="file">
                    
                      <!-- Menampilkan file yang sudah di-upload sebelumnya -->
                      @if (!empty($customer->spph))
                        <p class="mt-2 text-sm">
                          File saat ini: 
                          <a href="{{ asset('uploads/dokumen_haji/' . $customer->spph) }}" class="text-blue-600 underline" target="_blank">
                            {{ $customer->spph }}
                          </a>
                        </p>
                      @endif
                    </div>
        
                    <!-- BPIH -->
                    <div>
                      <label class="block mb-2 text-sm font-medium text-[#099AA7]" for="bpih">BPIH</label>
                      
                      <!-- Input untuk upload file baru -->
                      <input name="bpih" class="block w-full text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" 
                        id="bpih" type="file">
                    
                      <!-- Menampilkan file yang sudah di-upload sebelumnya -->
                      @if (!empty($customer->bpih))
                        <p class="mt-2 text-sm">
                          File saat ini: 
                          <a href="{{ asset('uploads/dokumen_haji/' . $customer->bpih) }}" class="text-blue-600 underline" target="_blank">
                            {{ $customer->bpih }}
                          </a>
                        </p>
                      @endif
                    </div>
        
                    <!-- Pas Photo -->
                    <div>
                      <label class="block mb-2 text-sm font-medium text-[#099AA7]" for="photo">Pas Photo</label>
                      
                      <!-- Input untuk upload file baru -->
                      <input name="photo" class="block w-full text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" 
                        id="photo" type="file">
                    
                      <!-- Menampilkan file yang sudah di-upload sebelumnya -->
                      @if (!empty($customer->photo))
                        <p class="mt-2 text-sm">
                          File saat ini: 
                          <a href="{{ asset('uploads/dokumen_haji/' . $customer->photo) }}" class="text-blue-600 underline" target="_blank">
                            {{ $customer->photo }}
                          </a>
                        </p>
                      @endif
                    </div>
                  </div>
                </div>

                <!-- Kolom 3 Pasport -->
                <div class="mt-3">
                  <label class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                    Nama Sesuai Pasport
                  </label>
                  <input type="text" name="nama_pasport" id="nama_pasport" placeholder="Nama Sesuai Pasport" value="{{ old('nama_pasport', $daftar_haji->nama_pasport) }}" class="block w-full rounded-md border-0 p-2 bg-gray-100 text-gray-900 shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6 uppercase" />

                  <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <div>
                      <label class="mb-2 mt-3 block text-sm font-medium leading-6 text-[#099AA7]">
                        Tempat Lahir Sesuai Pasport
                      </label>
                      <input type="text" name="tempat_lahir_pasport" id="tempat_lahir_pasport" placeholder="Tempat Lahir Sesuai Pasport" value="{{ old('tempat_lahir_pasport', $daftar_haji->tempat_lahir_pasport) }}" class="block w-full rounded-md border-0 p-2 bg-gray-100 text-gray-900 shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6 uppercase" />
                    </div>
                    <div>
                      <label class="mb-2 mt-3 block text-sm font-medium leading-6 text-[#099AA7]">
                        Tgl Lahir Sesuai Pasport
                      </label>
                      <input type="date" name="tgl_lahir_pasport" id="tgl_lahir_pasport" value="{{ old('tgl_lahir_pasport', $daftar_haji->tgl_lahir_pasport) }}" class="block w-full rounded-md border-0 p-2 bg-gray-100 text-gray-900 shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6 uppercase" />
                    </div>
                  </div>

                  <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <div>
                      <label class="mb-2 mt-3 block text-sm font-medium leading-6 text-[#099AA7]">
                        No Pasport
                      </label>
                      <input type="text" name="no_pasport" id="no_pasport" placeholder="No Pasport" value="{{ old('no_pasport', $daftar_haji->no_pasport) }}" class="block w-full rounded-md border-0 p-2 bg-gray-100 text-gray-900 shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6 uppercase" />
                    </div>
                    <div>
                      <label class="mb-2 mt-3 block text-sm font-medium leading-6 text-[#099AA7]">
                        Office Pasport
                      </label>
                      <input type="text" name="office_pasport" id="office_pasport" placeholder="Office Pasport" value="{{ old('office_pasport', $daftar_haji->office_pasport) }}" class="block w-full rounded-md border-0 p-2 bg-gray-100 text-gray-900 shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6 uppercase" />
                    </div>
                  </div>

                  <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <div>
                      <label class="mb-2 mt-3 block text-sm font-medium leading-6 text-[#099AA7]">
                        Issue Date
                      </label>
                      <input type="date" name="issue_date" id="issue_date" placeholder="Issue Date" value="{{ old('issue_date', $daftar_haji->issue_date) }}" class="block w-full rounded-md border-0 p-2 bg-gray-100 text-gray-900 shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6 uppercase" />
                    </div>
                    <div>
                      <label class="mb-2 mt-3 block text-sm font-medium leading-6 text-[#099AA7]">
                        Experi Date
                      </label>
                      <input type="date" name="experi_date" id="experi_date" placeholder="Expiri Date" value="{{ old('experi_date', $daftar_haji->experi_date) }}" class="block w-full rounded-md border-0 p-2 bg-gray-100 text-gray-900 shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6 uppercase" />
                    </div>
                  </div>
                </div>
              </div>              
            </div>
          </div>
        </div>
      </div>

      <!-- Container tombol dipisah dari form grid -->
      <div class="w-full flex justify-center mt-6 gap-3">
        <a href="/pendaftaran-haji"
          class="flex items-center justify-center px-6 py-3 text-sm font-semibold text-white bg-gray-500 rounded-md hover:bg-gray-600 shadow-sm">
          Kembali
        </a>

        <!-- Tombol Tambah Perlengkapan -->
        <button type="button" data-modal-target="modal-perlengkapan" data-modal-toggle="modal-perlengkapan"
          class="flex items-center justify-center px-6 py-3 text-sm font-semibold text-white bg-blue-600 rounded-md hover:bg-blue-600/80 shadow-sm gap-x-2 focus:outline-none focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
          <svg class="w-5 h-5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5" />
          </svg>
          Perlengkapan, Dokumen, Pasport
        </button>

        <button type="submit" class="px-6 py-2 bg-[#099AA7] text-white rounded-md hover:bg-[#077F8A]">
          Simpan
        </button>
      </div>
    </form>
  </div>

  {{-- Select2 --}}
<script>
  // Konfirmasi data yang belum diisi
  // document.getElementById("formPendaftaran").addEventListener("submit", function (event) {
  //   let fields = [
  //     { id: "no_porsi_haji", label: "No Porsi Haji" },
  //     { id: "cabang_id", label: "Cabang" },
  //     { id: "sumber_info", label: "Sumber Info" },
  //     { id: "wilayah_daftar", label: "Wilayah Daftar" },
  //     { id: "bpjs", label: "BPJS" },
  //     { id: "bank", label: "Bank" },
  //     { id: "keberangkatan", label: "Tahun Keberangkatan" },
  //     { id: "catatan", label: "Catatan" },
  //     { id: "no_hp_1", label: "No HP 1" },
  //     { id: "no_hp_2", label: "No HP 2" },
  //     { id: "jenis_id", label: "Jenis ID" },
  //     { id: "no_id", label: "No ID" },
  //     { id: "warga", label: "Warga" },
  //     { id: "tempat_lahir", label: "Tempat Lahir" },
  //     { id: "tgl_lahir", label: "Tanggal Lahir" },
  //     { id: "pekerjaan", label: "Pekerjaan" },
  //     { id: "pendidikan", label: "Pendidikan" },
  //     { id: "alamat_ktp", label: "Alamat KTP" },
  //     { id: "provinsi_ktp", label: "Provinsi KTP" },
  //     { id: "kota_ktp", label: "Kota KTP" },
  //     { id: "kecamatan_ktp", label: "Kecamatan KTP" },
  //     { id: "kelurahan_ktp", label: "Kelurahan KTP" },
  //     { id: "alamat_domisili", label: "Alamat Domisili" },
  //     { id: "provinsi_domisili", label: "Provinsi Domisili" },
  //     { id: "kota_domisili", label: "Kota Domisili" },
  //     { id: "kecamatan_domisili", label: "Kecamatan Domisili" },
  //     { id: "kelurahan_domisili", label: "Kelurahan Domisili" },
  //     { id: "ktp", label: "Upload KTP" },
  //     { id: "kk", label: "Upload KK" },
  //     { id: "surat", label: "Upload Surat" },
  //     { id: "spph", label: "Upload SPPH" },
  //     { id: "bpih", label: "Upload BPIH" },
  //     { id: "photo", label: "Upload Photo" }
  //   ];

  //   let emptyFields = fields.filter(field => {
  //     let value = document.getElementById(field.id)?.value.trim();
  //     return value === "";
  //   });

  //   // Cek radio button yang wajib diisi
  //   let radioFields = [
  //     { name: "paket_haji", label: "Paket Haji" },
  //     { name: "jenis_kelamin", label: "Jenis Kelamin" },
  //     { name: "status_nikah", label: "Status Nikah" },
  //     { name: "pelunasan", label: "Pelunasan Haji" }, // Ditambahkan untuk pelunasan haji
  //     { name: "pelunasan_manasik", label: "Pelunasan Manasik" } // Ditambahkan untuk pelunasan manasik
  //   ];

  //   radioFields.forEach(field => {
  //     let isChecked = document.querySelector(`input[name="${field.name}"]:checked`);
  //     if (!isChecked) {
  //       emptyFields.push({ label: field.label });
  //     }
  //   });

  //   if (emptyFields.length > 0) {
  //     event.preventDefault(); // Mencegah submit jika ada field kosong

  //     let fieldNames = emptyFields.map(field => `<li>${field.label}</li>`).join("");

  //     Swal.fire({
  //       title: "Data Yang Belum Diisi",
  //       html: `
  //         <div style="text-align: left; max-height: 300px; overflow-y: auto;">
  //           <ul style="columns: 2; -webkit-columns: 2; -moz-columns: 2; padding-left: 20px;">
  //             ${fieldNames}
  //           </ul>
  //         </div>
  //         <p style="text-align: center;">Tetap simpan data?</p>
  //       `,
  //       icon: "warning",
  //       showCancelButton: true,
  //       confirmButtonColor: "#099AA7",
  //       cancelButtonColor: "#3085d6",
  //       confirmButtonText: "Ya, Simpan",
  //       cancelButtonText: "Batal"
  //     }).then((result) => {
  //       if (result.isConfirmed) {
  //         document.getElementById("formPendaftaran").submit(); // Submit setelah konfirmasi
  //       }
  //     });
  //   }
  // });

  // Cabang
  $(document).ready(function () { 
    $('#cabang_id').select2({
      placeholder: "Pilih Cabang",
      allowClear: true,
      width: '100%',
      ajax: {
        url: "{{ route('cabang.search') }}", // Route API untuk pencarian cabang
        dataType: 'json',
        delay: 250, // Mengurangi beban server dengan menunda request
        data: function (params) {
          return { q: params.term || '' }; // Langsung mencari meskipun input kosong
        },
        processResults: function (data) {
          return {
            results: $.map(data, function (item) {
              return { id: item.id, text: item.cabang };
            })
          };
        },
        cache: true
      }
    });
  });

  // Wilayah Daftar
  $(document).ready(function () { 
    $('#wilayah_daftar').select2({
      placeholder: "Pilih Wilayah Daftar",
      allowClear: true,
      width: '100%',
      ajax: {
        url: "{{ route('wilayah.search') }}", // Route API untuk pencarian cabang
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

  // Keberangkatan
  $(document).ready(function () { 
    $('#keberangkatan').select2({
      placeholder: "Pilih Tahun Kerangkatan",
      allowClear: true,
      width: '100%',
      ajax: {
        url: "{{ route('keberangkatan.search') }}", // Route API untuk pencarian cabang
        dataType: 'json',
        delay: 250, // Mengurangi beban server dengan menunda request
        data: function (params) {
          return { q: params.term || '' }; // Langsung mencari meskipun input kosong
        },
        processResults: function (data) {
          return {
            results: $.map(data, function (item) {
              return { id: item.id, text: item.keberangkatan };
            })
          };
        },
        cache: true
      }
    });
  });

  // Sumber Info
  $(document).ready(function () {
    $('#sumber_info').select2({
      placeholder: "Pilih Sumber Informasi",
      allowClear: true,
      width: '100%'
    });

    // Ambil nilai old value dari Laravel
    var oldSumberInfo = "{{ old('sumber_info_id') }}";

    // Jika old value ada, set di Select2
    if (oldSumberInfo) {
      $('#sumber_info').val(oldSumberInfo).trigger('change');
    }
  });

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

  // Kompres File
  document.addEventListener("DOMContentLoaded", function () {
    // Pilih semua input file dalam form
    const fileInputs = document.querySelectorAll('input[type="file"]');

    fileInputs.forEach(input => {
        input.addEventListener("change", function (event) {
            compressImage(event.target);
        });
    });

    function compressImage(inputElement) {
        const file = inputElement.files[0];
        if (!file) return;

        const MAX_WIDTH = 800;
        const MAX_HEIGHT = 800;

        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = function (e) {
            const img = new Image();
            img.src = e.target.result;
            img.onload = function () {
                const canvas = document.createElement("canvas");
                const ctx = canvas.getContext("2d");

                let width = img.width;
                let height = img.height;

                if (width > height) {
                    if (width > MAX_WIDTH) {
                        height *= MAX_WIDTH / width;
                        width = MAX_WIDTH;
                    }
                } else {
                    if (height > MAX_HEIGHT) {
                        width *= MAX_HEIGHT / height;
                        height = MAX_HEIGHT;
                    }
                }

                canvas.width = width;
                canvas.height = height;
                ctx.drawImage(img, 0, 0, width, height);

                canvas.toBlob((blob) => {
                    const compressedFile = new File([blob], file.name, {
                        type: "image/jpeg",
                        lastModified: Date.now(),
                    });

                    // Buat DataTransfer untuk menggantikan file lama
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(compressedFile);
                    inputElement.files = dataTransfer.files;

                    console.log("✅ File dikompresi:", inputElement.files[0]);
                }, "image/jpeg", 0.7);
            };
        };
    }
  });

</script>
</x-layout>