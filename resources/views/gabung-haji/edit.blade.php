<x-layout>
  <div>
    <x-page-title>Form Edit gabung KBIH</x-page-title>
  </div>

  <div class="rounded-lg shadow-lg shadow-black mt-4 p-4">
    <form id="formPendaftaran" action="/gabung-haji/{{ $gabung_haji->id }}" method="POST">
      @method('PUT')
      @csrf

      <div class="w-full grid grid-cols-1 md:grid-cols-3 gap-7">
        {{-- Kolom 1 --}}
        <div>
          <div class="relative">
            <div class="flex gap-2 mb-3 items-end">
              <!-- Kolom Nama (Lebih Lebar) -->
              <div class="w-full">
                <label class="block text-sm mb-1 font-medium leading-6 text-[#099AA7]">
                  Nama Lengkap <span class="text-red-500 text-lg">*</span>
                </label>
                <input type="text" name="nama" id="nama" value="{{ old('nama', $customer->nama) }}" placeholder="Nama Lengkap" required class="block w-full rounded-md border-0 p-2 text-gray-900  shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6 uppercase" />
              </div>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-1 gap-2">
            <div>
              <label class="block mb-1 text-sm font-medium leading-6 text-[#099AA7]">Nama Panggilan</label>
              <input type="text" name="panggilan" id="panggilan" value="{{ old('panggilan', $customer->panggilan) }}" placeholder="Nama Panggilan"
              class="mb-3 block w-full rounded-md  border-0 p-2 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6 uppercase" />
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
            <div>
              <label class="block mb-1 text-sm font-medium leading-6 text-[#099AA7]">
                No HP 1 <span class="text-red-500 text-lg">*</span>
              </label>
              <input type="text" name="no_hp_1" id="no_hp_1" value="{{ old('no_hp_1', $customer->no_hp_1) }}" placeholder="No HP 1" required class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900  shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>
            <div>
              <label class="block mb-1 mt-1 text-sm font-medium leading-6 text-[#099AA7]">No HP 2</label>
              <input type="text" name="no_hp_2" id="no_hp_2" value="{{ old('no_hp_2', $customer->no_hp_2) }}" placeholder="No HP 2" class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900  shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-2">
            <!-- Tempat Lahir -->
            <div class=" shadow-slate-400">
              <label for="tempat_lahir" class="block mb-1 text-sm font-medium leading-6 text-[#099AA7]">
                Tempat Lahir <span class="text-red-500 text-lg">*</span>
              </label>
              <select name="tempat_lahir" id="tempat_lahir" required 
                class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                <option value="{{ $customer->tempat_lahir }}" selected>
                  {{ $customer->tempatLahir->kota_lahir ?? 'Pilih Tempat Lahir' }}
                </option>
              </select>
            </div>
        
            <!-- Tanggal Lahir -->
            <div>
              <label for="tgl_lahir" class="block mb-1 text-sm font-medium leading-6 text-[#099AA7]">
                Tanggal Lahir <span class="text-red-500 text-lg">*</span>
              </label>
              <input type="date" id="tgl_lahir" name="tgl_lahir" value="{{ old('tgl_lahir', $customer->tgl_lahir) }}" required 
              class="block w-full rounded-md border border-gray-300 p-2 text-gray-900  shadow-slate-400 focus:ring-2 focus:ring-indigo-600 text-sm leading-6" />
            </div>
          </div>
        
          <!-- Jenis ID, No Identitas, dan Warga -->
          <div class="grid grid-cols-[1fr_2fr_1fr] gap-4">
            <!-- Dropdown Jenis ID -->
            <div>
              <div>
                <label for="jenis_id" class="block text-sm mb-1 font-medium leading-6 text-[#099AA7]">
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
              <label for="no_id" class="mb-1 block text-sm font-medium leading-6 text-[#099AA7]">
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
              <label for="warga" class="block text-sm mb-1 font-medium leading-6 text-[#099AA7]">
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

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
            <!-- Dropdown Jenis Kelamin -->
            <div>
              <label class="mb-2 block text-sm font-medium text-[#099AA7]">
                Jenis Kelamin <span class="text-red-500 text-lg">*</span>
              </label>
              <ul class="w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg">
                @foreach (['Laki-Laki', 'Perempuan'] as $gender)
                <li class="w-full border-b border-gray-200">
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
              <label class="mb-2 block text-sm font-medium text-[#099AA7]">
                Status <span class="text-red-500 text-lg">*</span>
              </label>
              <ul class="w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg">
                @foreach (['Menikah', 'Belum Menikah', 'Janda/Duda'] as $status)
                <li class="w-full border-b border-gray-200">
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
              <label class="block mb-1 text-sm font-medium leading-6 text-[#099AA7]">
                Pekerjaan <span class="text-red-500 text-lg">*</span>
              </label>
              <input type="text" name="pekerjaan" id="pekerjaan" value="{{ old('pekerjaan', $customer->pekerjaan) }}" placeholder="Pekerjaan" required 
              class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900  shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>
            <div>
              <label for="pendidikan" class="block mb-1 text-sm font-medium leading-6 text-[#099AA7]">
                Pendidikan <span class="text-red-500 text-lg">*</span>
              </label>
              <select id="pendidikan" name="pendidikan" required 
                class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg  shadow-slate-400 text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
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

          <div class="shadow-slate-400">
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

          <div class="shadow-slate-400">
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
            
            <div>
              <label for="alamat_domisili" class="block mb-2 mt-3 text-sm font-medium text-[#099AA7]">
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
              <select name="kecamatan_domisili" id="kecamatan_domisili" data-selected="{{ $customer->kecamatan_domisili ?? '' }}" required
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
                  <select name="kelurahan_domisili" id="kelurahan_domisili" data-selected="{{ $customer->kelurahan_domisili ?? '' }}" required
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
        </div>
        
        {{-- Kolom 3 --}}
        <div class="relative">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-1">
            <div>
              <label class="block text-sm mb-1 font-medium leading-6 text-[#099AA7]">Nomor spph</label>
              <input type="number" name="no_spph" id="no_spph" value="{{ old('no_spph', $gabung_haji->no_spph) }}" placeholder="Nomor SPPH"
              class="block w-full rounded-md border-0 p-2 text-gray-900 shadow-slate-400 ring-1 ring-insetring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6 
              @error('no_spph') border-red-500 ring-red-500 focus:ring-red-500 @enderror" />
              
              @error('no_spph')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label class="mb-1 block text-sm font-medium leading-6 text-[#099AA7]">
                Nomor Porsi
              </label>
              <input type="number" name="no_porsi" id="no_porsi" value="{{ old('no_porsi', $gabung_haji->no_porsi) }}" placeholder="Nomor Porsi" 
              class="block w-full rounded-md border-0 p-2 text-gray-900 shadow-slate-400 ring-1 ring-insetring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6 
              @error('no_porsi') border-red-500 ring-red-500 focus:ring-red-500 @enderror" />
              
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
              <input type="text" name="nama_bank" id="nama_bank" required value="{{ old('nama_bank', $gabung_haji->nama_bank) }}" placeholder="Bank/Jumlah Setoran"  
                class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900  ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>

            <div>
              <label for="kota_bank" class="mb-1 block text-sm font-medium leading-6 text-[#099AA7]">
                Kota Bank <span class="text-red-500 text-lg">*</span>
              </label>
              <div class="">
                <select name="kota_bank" id="kota_bank" required 
                  class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                  @if(isset($gabung_haji->kota_bank))
                    <option value="{{ $gabung_haji->kota_bank }}" selected>
                      {{ $kotaBank->kota_lahir ?? 'Pilih Wilayah Daftar' }}
                    </option>
                  @endif
                </select>
              </div>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mb-2">
            <div>
              <label class="block mb-1 text-sm font-medium leading-6 text-[#099AA7]">
                Depag <span class="text-red-500 text-lg">*</span>
              </label>
              <div class="">
                <select name="depag" id="depag" required 
                  class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                  @if(isset($gabung_haji->depag))
                    <option value="{{ $gabung_haji->depag }}" selected>
                      {{ $depag->kota ?? 'Pilih Depag' }}
                    </option>
                  @endif
                </select>
              </div>
            </div>

            <div>
              <label class="mb-1 mt-1 block text-sm font-medium leading-6 text-[#099AA7]">Tahun Keberangkatan</label>
              <select name="keberangkatan_id" id="keberangkatan" class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                @if($keberangkatan)
                  <option value="{{ $keberangkatan->id }}" selected>
                    {{ $keberangkatan->keberangkatan }}
                  </option>
                @endif
              </select>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <!-- Dropdown Pelunasan haji -->
            <div class="w-full">
              <h3 class="mb-3 font-semibold text-[#099AA7]">Pelunasan haji</h3>
              <ul class="w-full text-sm font-medium  text-gray-900 bg-white border border-gray-200 rounded-lg">
                <li class="w-full border-b border-gray-200">
                  <div class="flex items-center ps-3">
                    <input id="pelunasan_haji" type="radio" value="Lunas" name="pelunasan" 
                      class="w-4 h-4 text-blue-600 bg-gray-300 border-gray-300 focus:ring-blue-500 focus:ring-2"
                      {{ $gabung_haji->pelunasan == 'Lunas' ? 'checked' : '' }}>
                    <label for="pelunasan_haji" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">
                      Lunas
                    </label>
                  </div>
                </li>
                <li class="w-full">
                  <div class="flex items-center ps-3">
                    <input id="belum_lunas" type="radio" value="Belum Lunas" name="pelunasan"
                      class="w-4 h-4 text-blue-600 bg-gray-300 border-gray-300 focus:ring-blue-500 focus:ring-2"
                      {{ $gabung_haji->pelunasan == 'Belum Lunas' ? 'checked' : '' }}>
                    <label for="belum_lunas" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">
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
                      {{ $gabung_haji->pelunasan_manasik == 'Lunas' ? 'checked' : '' }}>
                    <label for="pelunasan_manasik" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">
                      Lunas
                    </label>
                  </div>
                </li>
                <li class="w-full">
                  <div class="flex items-center ps-3">
                    <input id="belum_lunas_manasik" type="radio" value="Belum Lunas" name="pelunasan_manasik"
                      class="w-4 h-4 text-blue-600 bg-gray-300 border-gray-300 focus:ring-blue-500 focus:ring-2"
                      {{ $gabung_haji->pelunasan_manasik == 'Belum Lunas' ? 'checked' : '' }}>
                    <label for="belum_lunas_manasik" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">
                      Belum Lunas
                    </label>
                  </div>
                </li>
              </ul>
            </div> --}}
          </div>

          <!-- Kolom Dokumen -->
          <div class="w-full">
            <h3 class="mb-2 mt-3 font-semibold text-[#099AA7]">Dokumen</h3>  
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
          </div>

          <div>
            <label for="catatan" class="block mt-3 mb-1 text-sm font-medium text-[#099AA7]">
              Catatan
            </label>
            <textarea id="catatan" rows="4" name="catatan"
            class="mb-4  block p-2.5 w-full text-sm text-black bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" 
            placeholder="Write your thoughts here...">{{ old('catatan', $gabung_haji->catatan) }}</textarea>
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
  // document.getElementById("formPendaftaran").addEventListener("submit", function(event) {
  //   let fields = [
  //     { id: "paggilan", label: "Nama Panggilan" },
  //     { id: "no_spph", label: "No SPPH" },
  //     { id: "no_porsi", label: "No Porsi Haji" },
  //     { id: "nama_bank", label: "Nama Bank" },
  //     { id: "kota_bank", label: "Kot bank" },
  //     { id: "depag", label: "Depag" },
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
  //     { name: "status_nikah", label: "Status Nikah" }
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
          delay: 500,
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