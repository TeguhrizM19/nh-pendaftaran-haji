<x-layout>
  <div>
    <x-page-title>Ambil Semua Data Gabung Haji</x-page-title>
  </div>

  <div class="rounded-lg shadow-lg shadow-black mt-4 p-4">
    <form id="formPendaftaran" action="{{ route('gabung-haji.ambilSemuaData') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="customer_id" value="{{ $customer->id }}">

      <div class="w-full grid grid-cols-1 md:grid-cols-3 gap-7">
        <!-- Kolom 1 -->
        <div>
          <div class="relative">
            <div class="flex gap-2 mb-3 items-end">
              <!-- Kolom Nama (Lebih Lebar) -->
              <div class="w-full">
                <label class="block mb-1 text-sm font-medium leading-6 text-[#099AA7]">
                  Nama Lengkap <span class="text-red-500 text-lg">*</span>
                </label>
                <input type="text" name="nama" id="nama" placeholder="Nama Panggilan" value="{{ old('nama') }}" required
                class="block w-full rounded-md border-0 p-2 text-gray-900  shadow-slate-400  ring-1 
                ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 
                text-sm leading-6 uppercase" />
              </div>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-1 gap-2">
            <div>
              <label class="block mb-1 text-sm font-medium leading-6 text-[#099AA7]">Nama Panggilan</label>
              <input type="text" name="panggilan" id="panggilan" value="{{ old('panggilan') }}" placeholder="Nama Panggilan"
              class="mb-3 block w-full rounded-md  border-0 p-2 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6 uppercase" />
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
            <div>
              <label class="block mb-1 text-sm font-medium leading-6 text-[#099AA7]">
                No HP 1 <span class="text-red-500 text-lg">*</span>
              </label>
              <input type="text" name="no_hp_1" id="no_hp_1" value="{{ old('no_hp_1', $customer->no_hp_1) }}" placeholder="No HP 1" required 
              class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900  shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>
            <div>
              <label class="block mt-1 mb-1 text-sm font-medium leading-6 text-[#099AA7]">No HP 2</label>
              <input type="text" name="no_hp_2" id="no_hp_2" value="{{ old('no_hp_2', $customer->no_hp_2) }}" placeholder="No HP 2"
              class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900  shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Tempat Lahir -->
            <div class=" shadow-slate-400">
              <label for="tempat_lahir" class="block mb-1 text-sm font-medium leading-6 text-[#099AA7]">
                Tempat Lahir <span class="text-red-500 text-lg">*</span>
              </label>
              <select name="tempat_lahir" id="tempat_lahir" required 
                class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
              </select>
            </div>
        
            <!-- Tanggal Lahir -->
            <div>
              <label for="tgl_lahir" class="block mb-1 text-sm font-medium leading-6 text-[#099AA7]">
                Tanggal Lahir <span class="text-red-500 text-lg">*</span>
              </label>
              <input type="date" id="tgl_lahir" name="tgl_lahir" value="{{ old('tgl_lahir') }}" required 
              class="block w-full rounded-md border border-gray-300 p-2 text-gray-900  shadow-slate-400 focus:ring-2 focus:ring-indigo-600 text-sm leading-6" />
            </div>
          </div>
        
          <!-- Jenis ID, No Identitas, dan Warga -->
          <div class="grid grid-cols-[1fr_2fr_1fr] gap-4 mt-3">
            <!-- Dropdown Jenis ID -->
            <div>
              <div>
                <label for="jenis_id" class="block mb-1 text-sm font-medium leading-6 text-[#099AA7]">
                  Jenis ID <span class="text-red-500 text-lg">*</span>
                </label>
                <select id="jenis_id" name="jenis_id" required 
                  class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg  shadow-slate-400 text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                  <option value="">Pilih</option>
                  <option value="KTP" {{ $customer->jenis_id == 'KTP' ? 'selected' : '' }}>KTP</option>
                  <option value="SIM" {{ $customer->jenis_id == 'SIM' ? 'selected' : '' }}>SIM</option>
                </select>
              </div>
            </div>
            <!-- Input No Identitas (Lebih Lebar) -->
            <div>
              <label for="no_id" class="block mb-1 text-sm font-medium leading-6 text-[#099AA7]">
                No Identitas <span class="text-red-500 text-lg">*</span>
              </label>
              <input type="text" id="no_id" name="no_id" placeholder="Masukkan No Identitas" value="{{ old('no_id') }}" required
                class="block w-full rounded-md border-0 p-2 text-gray-900  shadow-slate-400 ring-1 ring-inset 
                ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6 
                @error('no_id') border-red-500 ring-red-500 focus:ring-red-500 @enderror" />
            
              @error('no_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>

            <!-- Dropdown Warga -->
            <div>
              <label for="warga" class="block mb-1 text-sm font-medium leading-6 text-[#099AA7]">
                Warga <span class="text-red-500 text-lg">*</span>
              </label>
              <select id="warga" name="warga" required 
                class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg  shadow-slate-400 text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                <option value="">Pilih</option>
                <option value="WNI" {{ $customer->warga == 'WNI' ? 'selected' : '' }}>WNI</option>
                <option value="WNA" {{ $customer->warga == 'WNA' ? 'selected' : '' }}>WNA</option>
              </select>
            </div>            
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-3">
            <!-- Dropdown Jenis Kelamin -->
            <div>
              <h3 class="mb-1 font-semibold text-[#099AA7]">
                Jenis Kelamin <span class="text-red-500 text-lg">*</span>
              </h3>
              <ul class="w-full text-sm font-medium shadow-lg text-gray-900 bg-white border border-gray-200 rounded-lg">
                <li class="w-full border-b border-gray-200">
                  <div class="flex items-center ps-3">
                    <input id="laki-laki" type="radio" value="Laki-Laki" name="jenis_kelamin" 
                      {{ old('jenis_kelamin') == 'Laki-Laki' ? 'checked' : '' }} required 
                      class="w-4 h-4 text-blue-600 bg-gray-300 border-gray-300 focus:ring-blue-500 focus:ring-2">
                    <label for="laki-laki" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">
                      Laki-Laki
                    </label>
                  </div>
                </li>
                <li class="w-full">
                  <div class="flex items-center ps-3">
                    <input id="perempuan" type="radio" value="Perempuan" name="jenis_kelamin" 
                      {{ old('jenis_kelamin') == 'Perempuan' ? 'checked' : '' }}
                      class="w-4 h-4 text-blue-600 bg-gray-300 border-gray-300 focus:ring-blue-500 focus:ring-2">
                    <label for="perempuan" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">
                      Perempuan
                    </label>
                  </div>
                </li>
              </ul>
            </div>
          
            <!-- Dropdown Status -->
            <div>
              <h3 class="mb-1 font-semibold text-[#099AA7]">
                Status <span class="text-red-500 text-lg">*</span>
              </h3>
              <ul class="w-full text-sm font-medium shadow-lg text-gray-900 bg-white border border-gray-200 rounded-lg">
                <li class="w-full border-b border-gray-200">
                  <div class="flex items-center ps-3">
                    <input id="menikah" type="radio" value="Menikah" name="status_nikah" 
                      {{ old('status_nikah') == 'Menikah' ? 'checked' : '' }} required 
                      class="w-4 h-4 text-blue-600 bg-gray-300 border-gray-300 focus:ring-blue-500 focus:ring-2">
                    <label for="menikah" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">
                      Menikah
                    </label>
                  </div>
                </li>
                <li class="w-full border-b border-gray-200">
                  <div class="flex items-center ps-3">
                    <input id="belum-menikah" type="radio" value="Belum Menikah" name="status_nikah" 
                      {{ old('status_nikah') == 'Belum Menikah' ? 'checked' : '' }}
                      class="w-4 h-4 text-blue-600 bg-gray-300 border-gray-300 focus:ring-blue-500 focus:ring-2">
                    <label for="belum-menikah" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">
                      Belum Menikah
                    </label>
                  </div>
                </li>
                <li class="w-full">
                  <div class="flex items-center ps-3">
                    <input id="janda-duda" type="radio" value="Janda/Duda" name="status_nikah" 
                      {{ old('status_nikah') == 'Janda/Duda' ? 'checked' : '' }}
                      class="w-4 h-4 text-blue-600 bg-gray-300 border-gray-300 focus:ring-blue-500 focus:ring-2">
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
              <label class="block mb-1 text-sm font-medium leading-6 text-[#099AA7]">
                Pekerjaan <span class="text-red-500 text-lg">*</span>
              </label>
              <input type="text" name="pekerjaan" id="pekerjaan" value="{{ old('pekerjaan') }}" placeholder="Pekerjaan" required 
              class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900  shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>
            <div>
              <label for="pendidikan" class="block mb-1 text-sm font-medium leading-6 text-[#099AA7]">
                Pendidikan <span class="text-red-500 text-lg">*</span>
              </label>
              <select id="pendidikan" name="pendidikan" required
                class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg  shadow-slate-400 text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                <option value="">Pilih</option>
                <option value="Tidak Sekolah" {{ old('pendidikan') == 'Tidak Sekolah' ? 'selected' : '' }}>Tidak Sekolah</option>
                <option value="TK" {{ old('pendidikan') == 'TK' ? 'selected' : '' }}>TK</option>
                <option value="SD" {{ old('pendidikan') == 'SD' ? 'selected' : '' }}>SD</option>
                <option value="SMP" {{ old('pendidikan') == 'SMP' ? 'selected' : '' }}>SMP</option>
                <option value="SMA" {{ old('pendidikan') == 'SMA' ? 'selected' : '' }}>SMA</option>
                <option value="S1" {{ old('pendidikan') == 'S1' ? 'selected' : '' }}>S1</option>
                <option value="S2" {{ old('pendidikan') == 'S2' ? 'selected' : '' }}>S2</option>
                <option value="S3" {{ old('pendidikan') == 'S3' ? 'selected' : '' }}>S3</option>
              </select> 
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
            <div>
              <label class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                Instansi
              </label>
              <input type="text" name="instansi" id="instansi" placeholder="instansi" value="{{ old('instansi') }}"
              class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900  shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>
            <div>
              <label class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                Jabatan
              </label>
              <input type="text" name="jabatan" id="jabatan" placeholder="jabatan" value="{{ old('jabatan') }}"
              class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900  shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Merokok -->
            <div class="w-full">
              <h3 class="mb-3 font-semibold text-[#099AA7]">
                Merokok
              </h3>
              <ul class="w-full text-sm font-medium shadow-lg text-gray-900 bg-white border border-gray-200 rounded-lg">
                <li class="w-full border-b border-gray-200">
                  <div class="flex items-center ps-3">
                    <input id="ya" type="radio" value="Ya" name="merokok" 
                      {{ old('merokok') == 'Ya' ? 'checked' : '' }} 
                      class="w-4 h-4 text-blue-600 bg-gray-300 border-gray-300 focus:ring-blue-500 focus:ring-2">
                    <label for="ya" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">
                      Ya
                    </label>
                  </div>
                </li>
                <li class="w-full">
                  <div class="flex items-center ps-3">
                    <input id="tidak" type="radio" value="Tidak" name="merokok" 
                      {{ old('merokok') == 'Tidak' ? 'checked' : '' }}
                      class="w-4 h-4 text-blue-600 bg-gray-300 border-gray-300 focus:ring-blue-500 focus:ring-2">
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
          <div>
            <label for="alamat_ktp" class="block mb-1 text-sm font-medium text-[#099AA7]">
              Alamat Sesuai KTP <span class="text-red-500 text-lg">*</span>
            </label>
            <textarea id="alamat_ktp" rows="2" name="alamat_ktp" required
            class="block p-2.5 w-full text-sm text-black bg-white  shadow-slate-400 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"  
            placeholder="Write your thoughts here...">{{ old('alamat_ktp', $customer->alamat_ktp) }}</textarea>
          </div>

          <div class=" shadow-slate-400">
            <label for="provinsi" class="mt-4 mb-1 block text-sm font-medium leading-6 text-[#099AA7]">
              Provinsi <span class="text-red-500 text-lg">*</span>
            </label>
            <select name="provinsi_ktp" id="provinsi_ktp" required 
            class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
            <option value="{{ $customer->provinsi_ktp ?? '' }}" selected>
              {{ $provinsi_ktp->provinsi ?? 'Pilih Provinsi' }}
            </option>
            </select>
          </div>

          <div class=" shadow-slate-400">
            <label for="kota_ktp" class="mt-4 mb-1 block text-sm font-medium leading-6 text-[#099AA7]">
              Kota <span class="text-red-500 text-lg">*</span>
            </label>
            <select name="kota_ktp" id="kota_ktp" data-selected="{{ $customer->kota_ktp ?? '' }}" required 
            class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
            <option value="{{ $customer->kota_ktp ?? '' }}" selected>
              {{ $kota_ktp->kota ?? 'Pilih Kota' }}
            </option>
            </select>
          </div>

          <div class=" shadow-slate-400">
            <label for="kecamatan_ktp" class="mt-4 mb-1 block text-sm font-medium leading-6 text-[#099AA7]">
              Kecamatan <span class="text-red-500 text-lg">*</span>
            </label>
            <select name="kecamatan_ktp" id="kecamatan_ktp" data-selected="{{ $customer->kecamatan_ktp ?? '' }}" required
            class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
            <option value="{{ $customer->kecamatan_ktp ?? '' }}" selected>
              {{ $kecamatan_ktp->kecamatan ?? 'Pilih Kecamatan' }}
            </option>
            </select>
          </div>

          <div class="relative">
            <div class="flex gap-4 mt-4">
              <!-- Kolom Kelurahan (Lebih Lebar) -->
              <div class="w-full  shadow-slate-400">
                <label for="kelurahan_ktp" class="block mb-1 text-sm font-medium leading-6 text-[#099AA7]">
                  Kelurahan <span class="text-red-500 text-lg">*</span>
                </label>
                <select name="kelurahan_ktp" id="kelurahan_ktp" data-selected="{{ $customer->kelurahan_ktp ?? '' }}" required
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
                class="bg-gray-100 border  shadow-slate-400 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 cursor-not-allowed"
                readonly>
              </div> --}}
            </div>          
          </div>

          <div>
            <label for="alamat_domisili" class="block mb-2 text-sm font-medium text-[#099AA7]">
              Alamat Domisili <span class="text-red-500 text-lg">*</span>
            </label>
            <textarea id="alamat_domisili" rows="2" name="alamat_domisili" required 
              class="mb-4 block p-2.5 w-full  shadow-slate-400 text-sm text-black bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
              placeholder="Alamat Domisili...">{{ old('alamat_domisili', $customer->alamat_domisili) }}</textarea>
          </div>

          <div class=" shadow-slate-400">
            <label for="provinsi_domisili" class="mt-4 mb-1 block text-sm font-medium leading-6 text-[#099AA7]">
              Provinsi <span class="text-red-500 text-lg">*</span>
            </label>
            <select name="provinsi_domisili" id="provinsi_domisili" required 
            class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
              <option value="{{ $customer->provinsi_domisili ?? '' }}" selected>
                {{ $provinsi_domisili->provinsi ?? 'Pilih Provinsi' }}
              </option>
            </select>
          </div>

          <div class=" shadow-slate-400">
            <label for="kota_domisili" class="mt-4 mb-1 block text-sm font-medium leading-6 text-[#099AA7]">
              Kota <span class="text-red-500 text-lg">*</span>
            </label>
            <select name="kota_domisili" id="kota_domisili" data-selected="{{ $customer->kota_domisili ?? '' }}" required 
            class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
            <option value="{{ $customer->kota_domisili ?? '' }}" selected>
              {{ $kota_domisili->kota ?? 'Pilih Kota' }}
            </option>
            </select>
          </div>

          <div class=" shadow-slate-400">
            <label for="kecamatan_domisili" class="mt-4 mb-1 block text-sm font-medium leading-6 text-[#099AA7]">
              Kecamatan <span class="text-red-500 text-lg">*</span>
            </label>
            <select name="kecamatan_domisili" id="kecamatan_domisili" required data-selected="{{ $customer->kecamatan_domisili ?? '' }}"
            class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
              <option value="{{ $customer->kecamatan_domisili ?? '' }}" selected>
                {{ $kecamatan_domisili->kecamatan ?? 'Pilih Kecamatan' }}
              </option>
            </select>
          </div>

          <div class="relative">
            <div class="flex gap-4 mt-4">
              <!-- Kolom Kelurahan (Lebih Lebar) -->
              <div class="w-full  shadow-slate-400">
                <label for="kelurahan_domisili" class="block mb-1 text-sm font-medium leading-6 text-[#099AA7]">
                  Kelurahan <span class="text-red-500 text-lg">*</span>
                </label>
                <select name="kelurahan_domisili" id="kelurahan_domisili" required data-selected="{{ $customer->kelurahan_domisili ?? '' }}"
                  class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                  <option value="{{ $customer->kelurahan_domisili ?? '' }}" selected>
                    {{ $kelurahan_domisili->kelurahan ?? 'Pilih kelurahan' }}
                  </option>
                </select>
              </div>

              <!-- Kolom Kode Pos (Lebih Kecil) -->
              {{-- <div class="w-1/4 ">
                <label for="kode_pos_domisili" class="block text-sm font-medium leading-6 text-[#099AA7]">Kode Pos</label>
                <input type="text" id="kode_pos_domisili" name="kode_pos_domisili"
                value="{{ old('kode_pos_domisili', $kode_pos_domisili) }}"
                class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 cursor-not-allowed"
                readonly>
              </div> --}}
            </div>
          </div>
        </div>
        
        <!-- Kolom 3 -->
        <div class="relative">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-1">
            <div>
              <label class="block text-sm font-medium mb-1 leading-6 text-[#099AA7]">No SPPH</label>
              <input type="number" name="no_spph" id="no_spph" placeholder="No SPPH" value="{{ old('no_spph') }}"
              class="block w-full rounded-md border-0 p-2 text-gray-900 shadow-slate-400 ring-1 ring-inset 
              ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6 
              @error('no_spph') border-red-500 ring-red-500 focus:ring-red-500 @enderror" />
              
              @error('no_spph')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="no_porsi" class="mb-1 block text-sm font-medium leading-6 text-[#099AA7]">
                Nomor Porsi
              </label>
              <input type="number" id="no_porsi" name="no_porsi" value="{{ old('no_porsi') }}" placeholder="Masukkan Nomor Porsi"
              class="block w-full rounded-md border-0 p-2 text-gray-900 shadow-slate-400 ring-1 ring-inset 
              ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6 
              @error('no_porsi') border-red-500 ring-red-500 focus:ring-red-500 @enderror"  />
              
              @error('no_porsi')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-3">
            <div>
              <label class="block mb-1 text-sm font-medium leading-6 text-[#099AA7]">
                Nama Bank <span class="text-red-500 text-lg">*</span>
              </label>
              <input type="text" name="nama_bank" id="nama_bank" required value="{{ old('nama_bank') }}" placeholder="Bank/Jumlah Setoran" class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900  ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6"  />
            </div>

            <div>
              <label for="kota_bank" class="block mb-1 text-sm font-medium leading-6 text-[#099AA7]">
                Kota Bank <span class="text-red-500 text-lg">*</span>
              </label>
              <div class="">
                <select name="kota_bank" id="kota_bank" required 
                  class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                  @if(isset($gabung_haji->kota_bank))
                    <option value="{{ $gabung_haji->kota_bank }}" selected>{{ $kotaBank->kota_lahir ?? 'Pilih Wilayah Daftar' }}</option>
                  @endif
                </select>
              </div>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mb-3">
            <div>
              <label class="block mb-1 text-sm font-medium leading-6 text-[#099AA7]">
                Depag <span class="text-red-500 text-lg">*</span>
              </label>
              <div>
                <select name="depag" id="depag" required 
                  class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500" >
                  @if(isset($gabung_haji->depag))
                    <option value="{{ $gabung_haji->depag }}" selected>
                      {{ $depag->kota ?? 'Pilih Depag' }}
                    </option>
                  @endif
                </select>
              </div>
            </div>

            <div>
              <label class="block mt-1 mb-1 text-sm font-medium leading-6 text-[#099AA7]">Tahun Keberangkatan</label>
              <select name="keberangkatan_id" id="keberangkatan" class="w-full text-gray-900 bg-white border  border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                <option value="">Pilih Tahun Keberangkatan</option>
                @foreach($keberangkatan as $berangkat)
                  <option value="{{ $berangkat->id }}" {{ old('keberangkatan_id') == $berangkat->id ? 'selected' : '' }}>
                    {{ $berangkat->keberangkatan }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>

          {{-- <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4"> 
            <!-- Pelunasan Haji -->
            <div class="w-full">
              <h3 class="mb-3 font-semibold text-[#099AA7]">Pelunasan Haji</h3>
              <ul class="w-full text-sm font-medium shadow-lg text-gray-900 bg-white border border-gray-200 rounded-lg">
                <li class="w-full border-b border-gray-200">
                  <div class="flex items-center ps-3">
                    <input id="lunas_haji" type="radio" value="Lunas" name="pelunasan" 
                      {{ old('pelunasan') == 'Lunas' ? 'checked' : '' }}
                      class="w-4 h-4 text-blue-600 bg-gray-300 border-gray-300 focus:ring-blue-500 focus:ring-2">
                    <label for="lunas_haji" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">
                      Lunas
                    </label>
                  </div>
                </li>
                <li class="w-full">
                  <div class="flex items-center ps-3">
                    <input id="belum_lunas_haji" type="radio" value="Belum Lunas" name="pelunasan" 
                      {{ old('pelunasan') == 'Belum Lunas' ? 'checked' : '' }}
                      class="w-4 h-4 text-blue-600 bg-gray-300 border-gray-300 focus:ring-blue-500 focus:ring-2">
                    <label for="belum_lunas_haji" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">
                      Belum Lunas
                    </label>
                  </div>
                </li>
              </ul>
            </div>
          
            <!-- Pelunasan Manasik -->
            <div class="w-full">
              <h3 class="mb-3 font-semibold text-[#099AA7]">Pelunasan Manasik</h3>
              <ul class="w-full text-sm font-medium shadow-lg text-gray-900 bg-white border border-gray-200 rounded-lg">
                <li class="w-full border-b border-gray-200">
                  <div class="flex items-center ps-3">
                    <input id="lunas_manasik" type="radio" value="Lunas" name="pelunasan_manasik" 
                      {{ old('pelunasan_manasik') == 'Lunas' ? 'checked' : '' }}
                      class="w-4 h-4 text-blue-600 bg-gray-300 border-gray-300 focus:ring-blue-500 focus:ring-2">
                    <label for="lunas_manasik" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">
                      Lunas
                    </label>
                  </div>
                </li>
                <li class="w-full">
                  <div class="flex items-center ps-3">
                    <input id="belum_lunas_manasik" type="radio" value="Belum Lunas" name="pelunasan_manasik" 
                      {{ old('pelunasan_manasik') == 'Belum Lunas' ? 'checked' : '' }}
                      class="w-4 h-4 text-blue-600 bg-gray-300 border-gray-300 focus:ring-blue-500 focus:ring-2">
                    <label for="belum_lunas_manasik" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">
                      Belum Lunas
                    </label>
                  </div>
                </li>
              </ul>
            </div>
          </div> --}}

          <div>
            <label for="catatan" class="block mt-3 mb-2 text-sm font-medium text-[#099AA7]">
              Catatan
            </label>
            <textarea id="catatan" rows="4" name="catatan"
            class="mb-4  block p-2.5 w-full text-sm text-black bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" 
            placeholder="Write your thoughts here...">{{ old('catatan') }}</textarea>
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
                            {{ in_array($data->id, old('perlengkapan', [])) ? 'checked' : '' }}
                            class="w-4 h-4 text-blue-600 bg-gray-300 border-gray-300 focus:ring-blue-500 focus:ring-2">
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
                            {{ in_array($dok->id, old('dokumen', [])) ? 'checked' : '' }}
                            class="w-4 h-4 text-blue-600 bg-gray-300 border-gray-300 focus:ring-blue-500 focus:ring-2">
                          <label class="w-full py-3 ms-2 text-sm font-medium text-gray-900">
                            {{ $dok->dokumen }}
                          </label>
                        </div>
                      </li>
                    @endforeach
                  </ul>

                  <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-3">
                    <!-- KTP -->
                    <div>
                      <label class="block mb-2 text-sm font-medium text-[#099AA7]" for="ktp">KTP</label>
                      <input name="ktp" class="block w-full text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-700 focus:outline-none" id="ktp" type="file" accept="image/*" class="file-input" onchange="imageInput(event)">
                    </div>
                    <!-- KK -->
                    <div>
                      <label class="block mb-2 text-sm font-medium text-[#099AA7]" for="kk">KK</label>
                      <input name="kk" class="block w-full text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-700 focus:outline-none" id="kk" type="file" accept="image/*" class="file-input" onchange="imageInput(event)">
                    </div>
                    <!-- Surat Nikah/Akte lahir/Ijazah -->
                    <div>
                      <label class="block mb-2 text-sm font-medium text-[#099AA7]" for="surat">Surat Nikah/Akte lahir/Ijazah</label>
                      <input name="surat" class="block w-full text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-700 focus:outline-none" id="surat" type="file" accept="image/*" class="file-input" onchange="imageInput(event)">
                    </div>
                    <!-- SPPH -->
                    <div>
                      <label class="block mb-2 text-sm font-medium text-[#099AA7]" for="spph">SPPH</label>
                      <input name="spph" class="block w-full text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-700 focus:outline-none" id="spph" type="file" accept="image/*" class="file-input" onchange="imageInput(event)">
                    </div>
                    <!-- BPIH -->
                    <div>
                      <label class="block mb-2 text-sm font-medium text-[#099AA7]" for="bpih">BPIH</label>
                      <input name="bpih" class="block w-full text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-700 focus:outline-none" id="bpih" type="file" accept="image/*" class="file-input" onchange="imageInput(event)">
                    </div>
                    <!-- Pas Photo -->
                    <div>
                      <label class="block mb-2 text-sm font-medium text-[#099AA7]" for="photo">Pas Photo</label>
                      <input name="photo" class="block w-full text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-700 focus:outline-none" id="photo" type="file" accept="image/*" class="file-input" onchange="imageInput(event)">
                    </div>
                  </div>
                </div>

                <!-- Kolom 3 Pasport -->
                <div class="mt-3">
                  <label class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                    Nama Sesuai Pasport
                  </label>
                  <input type="text" name="nama_pasport" id="nama_pasport" placeholder="Nama Sesuai Pasport" value="{{ old('nama_pasport') }}" class="block w-full rounded-md border-0 p-2 bg-gray-100 text-gray-900 shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6 uppercase" />

                  <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <div>
                      <label class="mb-2 mt-3 block text-sm font-medium leading-6 text-[#099AA7]">
                        Tempat Lahir Sesuai Pasport
                      </label>
                      <input type="text" name="tempat_lahir_pasport" id="tempat_lahir_pasport" placeholder="Tempat Lahir Sesuai Pasport" value="{{ old('tempat_lahir_pasport') }}" class="block w-full rounded-md border-0 p-2 bg-gray-100 text-gray-900 shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6 uppercase" />
                    </div>
                    <div>
                      <label class="mb-2 mt-3 block text-sm font-medium leading-6 text-[#099AA7]">
                        Tgl Lahir Sesuai Pasport
                      </label>
                      <input type="date" name="tgl_lahir_pasport" id="tgl_lahir_pasport" value="{{ old('tgl_lahir_pasport') }}" class="block w-full rounded-md border-0 p-2 bg-gray-100 text-gray-900 shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6 uppercase" />
                    </div>
                  </div>

                  <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <div>
                      <label class="mb-2 mt-3 block text-sm font-medium leading-6 text-[#099AA7]">
                        No Pasport
                      </label>
                      <input type="text" name="no_pasport" id="no_pasport" placeholder="No Pasport" value="{{ old('no_pasport') }}" class="block w-full rounded-md border-0 p-2 bg-gray-100 text-gray-900 shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6 uppercase" />
                    </div>
                    <div>
                      <label class="mb-2 mt-3 block text-sm font-medium leading-6 text-[#099AA7]">
                        Office Pasport
                      </label>
                      <input type="text" name="office_pasport" id="office_pasport" placeholder="Office Pasport" value="{{ old('office_pasport') }}" class="block w-full rounded-md border-0 p-2 bg-gray-100 text-gray-900 shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6 uppercase" />
                    </div>
                  </div>

                  <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <div>
                      <label class="mb-2 mt-3 block text-sm font-medium leading-6 text-[#099AA7]">
                        Issue Date
                      </label>
                      <input type="date" name="issue_date" id="issue_date" placeholder="Issue Date" value="{{ old('issue_date') }}" class="block w-full rounded-md border-0 p-2 bg-gray-100 text-gray-900 shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6 uppercase" />
                    </div>
                    <div>
                      <label class="mb-2 mt-3 block text-sm font-medium leading-6 text-[#099AA7]">
                        Experi Date
                      </label>
                      <input type="date" name="experi_date" id="experi_date" placeholder="Expiri Date" value="{{ old('experi_date') }}" class="block w-full rounded-md border-0 p-2 bg-gray-100 text-gray-900 shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6 uppercase" />
                    </div>
                  </div>
                </div>
              </div>              
            </div>
          </div>
        </div>
      </div>

      <!-- Tombol -->
      <div class="w-full flex justify-center mt-6 gap-3">
        <!-- Tombol Kembali -->
        <a href="/gabung-haji"
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
      
        <!-- Tombol Simpan -->
        <button type="submit"
          class="flex items-center justify-center px-6 py-3 text-sm font-semibold text-white bg-[#099AA7] rounded-md hover:bg-[#077F8A] shadow-sm">
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

  // Depag
  $(document).ready(function () { 
    $('#depag').select2({
      placeholder: "Pilih Depag",
      allowClear: true,
      width: '100%',
      ajax: {
        url: "{{ route('depag.search') }}", // Route API untuk pencarian cabang
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

  // JS untuk KTP
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
    // console.log("Loading kecamatan untuk kota ID:", kotaId); // Debugging
    if (!kotaId) return;

      $('#kecamatan_ktp').select2({
        placeholder: "Cari Kecamatan...",
        allowClear: true,
        ajax: {
          url: '/search-kecamatan/' + kotaId,
          dataType: 'json',
          delay: 250, // Kurangi delay untuk mempercepat loading
          data: function (params) {
            return { q: params.term || '' };
          },
          processResults: function (data) {
            // console.log("Data kecamatan diterima:", data); // Debugging
          return {
              results: $.map(data, function (item) {
                return { id: item.id, text: item.kecamatan };
              })
            };
          }
        }
      });

      if (kecamatanId) {
        // console.log("Memuat kecamatan terpilih:", kecamatanId);
        $.ajax({
          url: '/search-kecamatan/' + kotaId,
          dataType: 'json',
          success: function (data) {
            let kecamatan = data.find(item => item.id == kecamatanId);
            if (kecamatan) {
              let option = new Option(kecamatan.kecamatan, kecamatan.id, true, true);
              $('#kecamatan_ktp').empty().append(option).trigger('change');
              loadKelurahan(kecamatanId, selectedKelurahanId);
            }
          },
          error: function () {
            console.log("Gagal mengambil data kecamatan");
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
    // console.log("Loading kecamatan untuk kota ID:", kotaId); // Debugging
    if (!kotaId) return;

      $('#kecamatan_domisili').select2({
        placeholder: "Cari Kecamatan...",
        allowClear: true,
        ajax: {
          url: '/search-kecamatan/' + kotaId,
          dataType: 'json',
          delay: 250, // Kurangi delay untuk mempercepat loading
          data: function (params) {
              return { q: params.term || '' };
          },
          processResults: function (data) {
            // console.log("Data kecamatan diterima:", data); // Debugging
          return {
              results: $.map(data, function (item) {
                  return { id: item.id, text: item.kecamatan };
              })
            };
          }
        }
      });

      if (kecamatanId) {
        // console.log("Memuat kecamatan terpilih:", kecamatanId);
        $.ajax({
          url: '/search-kecamatan/' + kotaId,
          dataType: 'json',
          success: function (data) {
            let kecamatan = data.find(item => item.id == kecamatanId);
            if (kecamatan) {
              let option = new Option(kecamatan.kecamatan, kecamatan.id, true, true);
              $('#kecamatan_domisili').empty().append(option).trigger('change');
              loadKelurahan(kecamatanId, selectedKelurahanId);
            }
          },
          error: function () {
            console.log("Gagal mengambil data kecamatan");
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

  // Kompres Gambar
  function imageInput(event) {
    const file = event.target.files[0];
    if (file) {
      compressImage(event);
    }
  }

  function compressImage(event) {
    const files = event.target.files;
    const dataTransfer = new DataTransfer();
    const MAX_WIDTH = 800;
    const MAX_HEIGHT = 800;

    function processFile(file) {
      if (!file) return;
      const reader = new FileReader();
      reader.readAsDataURL(file);
      reader.onload = (e) => {
        const img = new Image();
        img.src = e.target.result;
        img.onload = () => {
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');

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
                lastModified: Date.now()
              });

              dataTransfer.items.add(compressedFile);
              event.target.files = dataTransfer.files; // Menetapkan file yang telah dikompresi
              
              console.log("File setelah dikompresi:", event.target.files);
          }, 'image/jpeg', 0.7);
        };
      };
    }

    if (files.length > 0) {
      processFile(files[0]); // Mulai proses kompresi pada file pertama
    }
  }

</script>
</x-layout>