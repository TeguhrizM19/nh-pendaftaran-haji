<x-layout>
  <div>
    <x-page-title>Form Pendaftaran Haji</x-page-title>
  </div>

  <div class="rounded-lg shadow-lg shadow-black mt-4 p-4">
    <form id="formPendaftaran" action="/pendaftaran-haji" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="w-full grid grid-cols-1 md:grid-cols-3 gap-7">
        {{-- Kolom 1 --}}
        <div>
          <div class="relative">
            <div class="flex flex-col-reverse sm:flex-row sm:items-end gap-2 w-full">
              <!-- Input Nama Customer -->
              <div class="w-full sm:w-96">
                <label class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                  Nama Lengkap Customer <span class="text-red-500 text-lg">*</span>
                </label>
                <input type="text" name="nama" placeholder="Nama" value="{{ old('nama') }}" required
                class="block w-full rounded-md border-0 p-2 text-gray-900 shadow-slate-400 ring-1 
                ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 
                text-sm leading-6 uppercase" />
              </div>
              <!-- Tombol Cari -->
              <div class="w-full sm:w-auto flex justify-end">
                <button type="button" id="openSearch"
                  class="w-full sm:w-auto px-4 py-2 bg-[#099AA7] text-white rounded-lg shadow-slate-400 flex items-center gap-2 justify-center">
                  🔍 <span>Cari</span>
                </button>
              </div>
            </div>                        
          </div>

          <div>
            <label for="no_porsi_haji" class="mb-2 mt-3 block text-sm font-medium leading-6 text-[#099AA7]">
              Nomor Porsi Haji
            </label>
            <input type="number" id="no_porsi_haji" name="no_porsi_haji" value="{{ old('no_porsi_haji') }}" placeholder="Masukkan Nomor Porsi Haji" 
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
              <select name="cabang_id" id="cabang_id" required
                class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                <option value="">Pilih</option>
                @foreach($cabang as $cbg)
                <option value="{{ $cbg->id }}" {{ old('cabang_id') == $cbg->id ? 'selected' : '' }}>
                  {{ $cbg->cabang }}
                </option>
                @endforeach
              </select>
            </div>
            <div class="">
              <label for="wilayah_daftar" class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                Wilayah Daftar <span class="text-red-500 text-lg">*</span>
              </label>
              <select name="wilayah_daftar" id="wilayah_daftar" required>
                <option value="">Pilih</option>
                @forelse ($wilayahKota as $wilayah)
                  <option value="{{ $wilayah->id }}" {{ old('wilayah_daftar') == $wilayah->id ? 'selected' : '' }}>
                      {{ $wilayah->kota_lahir }}
                  </option>
                @empty
                  <option value="">Wilayah Masih Kosong</option>
                @endforelse
              </select>            
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-4">
            <div>
              <label class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">Bank</label>
              <input type="text" name="bank" id="bank" placeholder="Bank/Jumlah Setoran" value="{{ old('bank') }}"
                class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900  ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>

            <div>
              <label for="sumber_info" class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                Sumber Informasi <span class="text-red-500 text-lg">*</span>
              </label>
              <select name="sumber_info_id" id="sumber_info" required 
              class="w-full text-gray-900 bg-white border  border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                <option value="">Pilih Sumber Informasi</option>
                @foreach($sumberInfo as $sumber)
                  <option value="{{ $sumber->id }}" {{ old('sumber_info_id') == $sumber->id ? 'selected' : '' }}>
                    {{ $sumber->info }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
            <div>
              <label class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">BPJS</label>
              <input type="number" name="bpjs" id="bpjs" placeholder="No BPJS" value="{{ old('bpjs') }}"
              class="block w-full rounded-md border-0 p-2 text-gray-900 shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6 @error('bpjs') border-red-500 ring-red-500 focus:ring-red-500 @enderror" />
              
              @error('bpjs')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label class="block mb-2 text-sm font-medium leading-6 text-[#099AA7]">Tahun Keberangkatan</label>
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

          <div class="mt-3">
            <h3 class="mb-3 font-semibold text-[#099AA7]">
              Paket Pendaftaran <span class="text-red-500 text-lg">*</span>
            </h3>
            <ul class="w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg">
              <!-- Layout desktop (2 kolom), di HP jadi 1 kolom -->
              <div class="grid grid-cols-1 md:grid-cols-1">
                <!-- Reguler Tunai -->
                <li class="border-b border-gray-200">
                  <div class="flex items-center ps-3">
                    <input id="reguler-tunai" type="radio" value="Reguler Tunai" name="paket_haji"
                      {{ old('paket_haji') == 'Reguler Tunai' ? 'checked' : '' }} required
                      class="w-4 h-4 text-blue-600 bg-gray-300 border-gray-300 focus:ring-blue-500 focus:ring-2">
                    <label for="reguler-tunai" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">
                      Reguler Tunai
                    </label>
                  </div>
                </li>
                <!-- Reguler Talangan (di desktop ada di bawah Reguler Tunai, di HP tetap urut) -->
                <li class="border-b border-gray-200">
                  <div class="flex items-center ps-3">
                    <input id="reguler-talangan" type="radio" value="Reguler Talangan" name="paket_haji"
                      {{ old('paket_haji') == 'Reguler Talangan' ? 'checked' : '' }}
                      class="w-4 h-4 text-blue-600 bg-gray-300 border-gray-300 focus:ring-blue-500 focus:ring-2">
                    <label for="reguler-talangan" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">
                      Reguler Talangan
                    </label>
                  </div>
                </li>
              </div>
              <!-- Khusus/Plus (di HP ada di bawah Reguler Talangan) -->
              <li class="w-full">
                <div class="flex items-center ps-3">
                  <input id="khusus" type="radio" value="Khusus/Plus" name="paket_haji"
                    {{ old('paket_haji') == 'Khusus/Plus' ? 'checked' : '' }}
                    class="w-4 h-4 text-blue-600 bg-gray-300 border-gray-300 focus:ring-blue-500 focus:ring-2">
                  <label for="khusus" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">
                    Khusus/Plus
                  </label>
                </div>
              </li>
            </ul>
          </div>              

          <div>
            <label for="catatan" class="block mb-2 mt-4 text-sm font-medium text-[#099AA7]">
              Catatan
            </label>
            <textarea id="catatan" rows="4" name="catatan"
            class="mb-4  block p-2.5 w-full text-sm text-black bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" 
            placeholder="Write your thoughts here...">{{ old('catatan') }}</textarea>
          </div>
        </div>

        {{-- Kolom 2 --}}
        <div class="relative">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
            <div>
              <label class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                No HP 1 <span class="text-red-500 text-lg">*</span>
              </label>
              <input type="text" name="no_hp_1" id="no_hp_1" placeholder="No HP 1" value="{{ old('no_hp_1') }}" required 
              class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900  shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>
            <div>
              <label class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">No HP 2</label>
              <input type="text" name="no_hp_2" id="no_hp_2" placeholder="No HP 2" value="{{ old('no_hp_2') }}"
              class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900  shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <!-- Tempat Lahir -->
            <div class=" shadow-slate-400">
              <label for="tempat_lahir" class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                Tempat Lahir <span class="text-red-500 text-lg">*</span>
              </label>
              <select name="tempat_lahir" id="tempat_lahir" required 
              class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                <option value="">Pilih Tempat Lahir</option>
                @forelse ($tempatLahir as $kt)
                  <option value="{{ $kt->id }}" {{ old('tempat_lahir') == $kt->id ? 'selected' : '' }}>
                    {{ $kt->kota_lahir }}
                  </option>
                @empty
                  <option value="">Tempat Lahir masih kosong</option>
                @endforelse
              </select>
            </div>
        
            <!-- Tanggal Lahir -->
            <div>
              <label for="tgl_lahir" class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                Tanggal Lahir <span class="text-red-500 text-lg">*</span>
              </label>
              <input type="date" id="tgl_lahir" name="tgl_lahir" value="{{ old('tgl_lahir') }}" required
              class="block w-full rounded-md border border-gray-300 p-2 text-gray-900  shadow-slate-400 focus:ring-2 focus:ring-indigo-600 text-sm leading-6" />
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
                  class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg  shadow-slate-400 text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                  <option value="">Pilih</option>
                  <option value="KTP" {{ old('jenis_id') == 'KTP' ? 'selected' : '' }}>KTP</option>
                  <option value="SIM" {{ old('jenis_id') == 'SIM' ? 'selected' : '' }}>SIM</option>
                </select>
              </div>
            </div>
            <!-- Input No Identitas (Lebih Lebar) -->
            <div>
              <label for="no_id" class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
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
              <label for="warga" class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                Warga <span class="text-red-500 text-lg">*</span>
              </label>
              <select id="warga" name="warga" required
                class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg  shadow-slate-400 text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                <option value="">Pilih</option>
                <option value="WNI" {{ old('warga') == 'WNI' ? 'selected' : '' }}>WNI</option>
                <option value="WNA" {{ old('warga') == 'WNA' ? 'selected' : '' }}>WNA</option>
              </select>
            </div>            
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4"> 
            <!-- Jenis Kelamin -->
            <div class="w-full">
              <h3 class="mb-3 font-semibold text-[#099AA7]">
                Jenis Kelamin <span class="text-red-500 text-lg">*</span>
              </h3>
              <ul class="w-full text-sm font-medium shadow-lg text-gray-900 bg-white border border-gray-200 rounded-lg">
                <li class="w-full border-b border-gray-200">
                  <div class="flex items-center ps-3">
                    <input id="laki-laki" type="radio" value="Laki-Laki" name="jenis_kelamin" required 
                      {{ old('jenis_kelamin') == 'Laki-Laki' ? 'checked' : '' }} 
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
          
            <!-- Status Nikah -->
            <div class="w-full">
              <h3 class="mb-3 font-semibold text-[#099AA7]">
                Status <span class="text-red-500 text-lg">*</span>
              </h3>
              <ul class="w-full text-sm font-medium shadow-lg text-gray-900 bg-white border border-gray-200 rounded-lg">
                <li class="w-full border-b border-gray-200">
                  <div class="flex items-center ps-3">
                    <input id="menikah" type="radio" value="Menikah" name="status_nikah" required 
                      {{ old('status_nikah') == 'Menikah' ? 'checked' : '' }}
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
              <label class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                Pekerjaan <span class="text-red-500 text-lg">*</span>
              </label>
              <input type="text" name="pekerjaan" id="pekerjaan" placeholder="Pekerjaan" value="{{ old('pekerjaan') }}" required
              class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900  shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>
            <div>
              <label for="pendidikan" class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
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
          
          <!-- Kolom Dokumen -->
          <div class="w-full">
            <h3 class="mb-3 font-semibold text-[#099AA7]">Dokumen</h3>
            <ul class="w-full text-sm font-medium shadow-lg text-gray-900 bg-white border border-gray-200 rounded-lg">
              @foreach ($dokumen as $dok)
                <li class="w-full border-b border-gray-200">
                  <div class="flex items-center ps-3">
                    <input id="dokumen{{ $dok->id }}" type="checkbox" name="dokumen[]" value="{{ $dok->id }}"
                      class="w-4 h-4 text-blue-600 bg-gray-300 border-gray-300 focus:ring-blue-500 focus:ring-2"
                      {{ in_array($dok->id, old('dokumen', $selectedDokumen ?? [])) ? 'checked' : '' }}>
                    <label for="dokumen{{ $dok->id }}" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">
                      {{ $dok->dokumen }}
                    </label>
                  </div>
                </li>
              @endforeach
            </ul>
          </div>
          
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
        
        {{-- Kolom 3 Alamat --}}
        <div class="relative">
          <div>
            <label for="alamat_ktp" class="block mb-2 text-sm font-medium text-[#099AA7]">
              Alamat Sesuai KTP <span class="text-red-500 text-lg">*</span>
            </label>
            <textarea id="alamat_ktp" rows="2" name="alamat_ktp" required 
            class="block p-2.5 w-full text-sm text-black bg-white  shadow-slate-400 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 uppercase" 
            placeholder="Write your thoughts here...">{{ old('alamat_ktp') }}</textarea>
          </div>

          <div class=" shadow-slate-400">
            <label for="provinsi" class="mt-4 mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
              Provinsi <span class="text-red-500 text-lg">*</span>
            </label>
            <select name="provinsi_ktp" id="provinsi_ktp" required 
            class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
              <option value="">Pilih Provinsi</option>
              @foreach ($provinsi as $prov)
                <option value="{{ $prov->id }}" {{ old('provinsi_ktp', $selectedProvinsi ?? '') == $prov->id ? 'selected' : '' }}>
                  {{ $prov->provinsi }}
                </option>
              @endforeach
            </select>
          </div>

          <div class=" shadow-slate-400">
            <label for="kota_ktp" class="mt-4 mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
              Kota <span class="text-red-500 text-lg">*</span>
            </label>
            <select name="kota_ktp" id="kota_ktp" required 
            class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
              <option value="">Pilih Kota</option>
              @if(old('kota_ktp', $selectedKota ?? false))
                <option value="{{ old('kota_ktp', $selectedKota) }}" selected>{{ $namaKota ?? 'Kota Terpilih' }}</option>
              @endif
            </select>
          </div>

          <div class=" shadow-slate-400">
            <label for="kecamatan_ktp" class="mt-4 mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
              Kecamatan <span class="text-red-500 text-lg">*</span>
            </label>
            <select name="kecamatan_ktp" id="kecamatan_ktp" required
            class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
              <option value="">Pilih Kecamatan</option>
              @if(old('kecamatan_ktp', $selectedKecamatan ?? false))
                <option value="{{ old('kecamatan_ktp', $selectedKecamatan) }}" selected>{{ $namaKecamatan ?? 'Kecamatan Terpilih' }}</option>
              @endif
            </select>
          </div>

          <div class="relative">
            <div class="flex gap-4 mt-4">
              <!-- Kolom Kelurahan (Lebih Lebar) -->
              <div class="w-full  shadow-slate-400">
                <label for="kelurahan_ktp" class="block mb-2 text-sm font-medium leading-6 text-[#099AA7]">
                  Kelurahan <span class="text-red-500 text-lg">*</span>
                </label>
                <select name="kelurahan_ktp" id="kelurahan_ktp" required
                class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                  <option value="">Pilih Kelurahan</option>
                  @if(old('kelurahan_ktp', $selectedKelurahan ?? false))
                    <option value="{{ old('kelurahan_ktp', $selectedKelurahan) }}" selected>{{ $namaKelurahan ?? 'Kelurahan Terpilih' }}</option>
                  @endif
                </select>
              </div>
      
              <!-- Kolom Kode Pos (Lebih Kecil) -->
              {{-- <div class="w-1/4">
                <label for="kode_pos_ktp" class="block mb-2 text-sm font-medium leading-6 text-[#099AA7]">
                  Kode Pos
                </label>
                <input type="text" id="kode_pos_ktp"
                  class="bg-gray-100 border border-gray-300 text-gray-900  shadow-slate-400 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 cursor-not-allowed"
                  disabled>
              </div> --}}
            </div>            
          </div>

          <div>
            <div class="flex items-center gap-4 mb-2 mt-4">
              <label for="alamat_domisili" class="text-sm font-medium text-[#099AA7]">
                Alamat Domisili <span class="text-red-500 text-lg">*</span>
              </label>
              <div class="flex items-center gap-2">
                <input id="copy-checkbox" type="checkbox" name="copy_checkbox" class="w-5 h-5 text-blue-600 bg-gray-200 border-gray-300 rounded-sm focus:ring-blue-500 focus:ring-2" {{ old('copy_checkbox') ? 'checked' : '' }}>
                <label for="copy-checkbox" class="text-sm font-medium text-gray-900">
                  Gunakan Alamat KTP
                </label>
              </div>
            </div>
            <textarea id="alamat_domisili" rows="2" name="alamat_domisili" required
            class="block mb-2 p-2.5 w-full text-sm text-black bg-white  shadow-slate-400 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 uppercase" 
            placeholder="Write your thoughts here...">{{ old('alamat_domisili') }}</textarea>
          </div>

          <div class=" shadow-slate-400">
            <label for="provinsi_domisili" class="mt-4 mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
              Provinsi <span class="text-red-500 text-lg">*</span>
            </label>
            <select name="provinsi_domisili" id="provinsi_domisili" required 
            class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
              <option value="">Pilih Provinsi</option>
              @foreach ($provinsi as $prov)
                <option value="{{ $prov->id }}" {{ old('provinsi_domisili', $selectedProvinsiDom ?? '') == $prov->id ? 'selected' : '' }}>
                  {{ $prov->provinsi }}
                </option>
              @endforeach
            </select>
            <input type="hidden" name="provinsi_domisili" id="hidden_provinsi_domisili" value="{{ old('provinsi_domisili') }}">
          </div>

          <div class=" shadow-slate-400">
            <label for="kota_domisili" class="mt-4 mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
              Kota <span class="text-red-500 text-lg">*</span>
            </label>
            <select name="kota_domisili" id="kota_domisili" required 
            class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
              <option value="{{ old('kota_domisili', $selectedKotaDom ?? '') }}" selected>
                {{ $namaKotaDom ?? 'Pilih Kota' }}
              </option>
            </select>
            <input type="hidden" name="kota_domisili" id="hidden_kota_domisili" value="{{ old('kota_domisili') }}">
          </div>

          <div class=" shadow-slate-400">
            <label for="kecamatan_domisili" class="mt-4 mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
              Kecamatan <span class="text-red-500 text-lg">*</span>
            </label>
            <select name="kecamatan_domisili" id="kecamatan_domisili" required
            class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
              <option value="{{ old('kecamatan_domisili', $selectedKecamatanDom ?? '') }}" selected>
                {{ $namaKecamatanDom ?? 'Pilih Kecamatan' }}
              </option>
            </select>
            <input type="hidden" name="kecamatan_domisili" id="hidden_kecamatan_domisili" value="{{ old('kecamatan_domisili') }}">
          </div>

          <div class="relative">
            <div class="flex gap-4 mt-4">
              <!-- Kolom Kelurahan (Lebih Lebar) -->
              <div class="w-full  shadow-slate-400">
                <label for="kelurahan_domisili" class="block mb-2 text-sm font-medium leading-6 text-[#099AA7]">
                  Kelurahan <span class="text-red-500 text-lg">*</span>
                </label>
                <select name="kelurahan_domisili" id="kelurahan_domisili" required
                class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                  <option value="{{ old('kelurahan_domisili', $selectedKelurahanDom ?? '') }}" selected>
                    {{ $namaKelurahanDom ?? 'Pilih Kelurahan' }}
                  </option>
                </select>
                <input type="hidden" name="kelurahan_domisili" id="hidden_kelurahan_domisili" value="{{ old('kelurahan_domisili') }}">
              </div>

              <!-- Kolom Kode Pos (Lebih Kecil) -->
              {{-- <div class="w-1/4">
                <label for="kode_pos_domisili" class="block mb-2 text-sm font-medium leading-6 text-[#099AA7]">Kode Pos</label>
                <input type="text" id="kode_pos_domisili"
                  class="bg-gray-100 border border-gray-300 text-gray-900  shadow-slate-400 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 cursor-not-allowed"
                  disabled>
              </div> --}}
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

    <!-- Modal Box -->
  <div id="searchModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white w-full sm:w-[1000px] max-h-[90vh] p-6 rounded-lg shadow-lg relative flex flex-col">
      <!-- Tombol Close -->
      <button id="closeSearch" class="absolute top-4 right-4 bg-[#099AA7] rounded-full p-2 shadow-lg z-20">
        <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" 
          width="24" height="24" fill="none" viewBox="0 0 24 24">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
            d="M6 18 17.94 6M18 18 6.06 6"/>
        </svg>
      </button>

      <!-- Input Pencarian -->
      <div class="sticky top-0 bg-white z-10 pb-4">
        <input type="text" id="searchInput"
          class="w-full p-4 border rounded-lg text-lg focus:outline-none focus:ring-2 focus:ring-[#099AA7]"
          placeholder="Search Data..." autocomplete="off">
      </div>

      <!-- Dropdown hasil pencarian -->
      <div id="searchResults" class="mt-4 bg-white shadow-lg rounded-lg max-h-[60vh] overflow-y-auto hidden flex-1">
        <ul id="customerList" class="divide-y divide-gray-200">
          <!-- Hasil pencarian akan ditampilkan di sini -->
        </ul>
      </div>
    </div>
  </div>

<script>
  // Konfirmasi data yang belum diisi
  // document.getElementById("formPendaftaran").addEventListener("submit", function(event) {
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

  // Tampilkan modal pencarian
  document.getElementById("openSearch").addEventListener("click", function () {
  document.getElementById("searchModal").classList.remove("hidden");
  document.getElementById("searchInput").focus();
  });

  // Pencarian real-time Repeat dan Ambil Data
  document.getElementById("searchInput").addEventListener("input", function () {
    let query = this.value.trim();
    let searchResults = document.getElementById("searchResults");
    let customerList = document.getElementById("customerList");

    if (query === "") {
      searchResults.classList.add("hidden");
      customerList.innerHTML = "";
      return;
    }

    fetch(`/search-pendaftaran?query=${encodeURIComponent(query)}`)
      .then(response => response.json())
      .then(data => {
        console.log("Response Data:", data); // Debugging

        customerList.innerHTML = ""; // Kosongkan hasil sebelumnya

        data.customers.forEach(customer => {
          let daftarHaji = data.daftarHaji.find(daftar => daftar.customer_id === customer.id);

          let li = document.createElement("li");
          li.classList.add("flex", "justify-start", "items-center", "p-4", "hover:bg-blue-100", "cursor-pointer", "gap-4");

          li.innerHTML = `
            <div class="flex-1">
              <span class="font-semibold">NIK: ${customer.no_id}</span>
              <span class="block text-gray-600">Nama: ${customer.nama}</span>
            </div>
            <div class="flex gap-2">
              <a href="/repeat-data-pendaftaran/${customer.id}" class="repeat-btn bg-[#099AA7] text-white px-4 py-2 rounded-lg text-sm">
                🔄 Repeat Data
              </a>
              <a href="/ambil-semua-data-pendaftaran/${customer.id}" class="ambil-btn bg-green-500 text-white px-4 py-2 rounded-lg text-sm">
                📥 Ambil Data
              </a>
            </div>
          `;

          customerList.appendChild(li);
        });

        searchResults.classList.remove("hidden");
      })
      .catch(error => console.error('Error:', error));
  });

  // Menutup modal saat tombol close diklik
  document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("searchModal");
    const closeBtn = document.getElementById("closeSearch");

    if (closeBtn && modal) {
      closeBtn.addEventListener("click", function () {
        modal.classList.add("hidden"); // Menyembunyikan modal
      });
    }
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
      // Copy data dari KTP ke domisili
      document.getElementById('alamat_domisili').value = document.getElementById('alamat_ktp').value;
      document.getElementById('provinsi_domisili').value = document.getElementById('provinsi_ktp').value;
      document.getElementById('hidden_provinsi_domisili').value = document.getElementById('provinsi_ktp').value;
      $('#provinsi_domisili').trigger('change');

      setTimeout(() => {
        document.getElementById('kota_domisili').value = document.getElementById('kota_ktp').value;
        document.getElementById('hidden_kota_domisili').value = document.getElementById('kota_ktp').value;
        $('#kota_domisili').trigger('change');
      }, 1000);
      
      setTimeout(() => {
        document.getElementById('kecamatan_domisili').value = document.getElementById('kecamatan_ktp').value;
        document.getElementById('hidden_kecamatan_domisili').value = document.getElementById('kecamatan_ktp').value;
        $('#kecamatan_domisili').trigger('change');
      }, 1800);
      
      setTimeout(() => {
        document.getElementById('kelurahan_domisili').value = document.getElementById('kelurahan_ktp').value;
        document.getElementById('hidden_kelurahan_domisili').value = document.getElementById('kelurahan_ktp').value;
        $('#kelurahan_domisili').trigger('change');
      }, 2300);

      document.getElementById('kode_pos_domisili').value = document.getElementById('kode_pos_ktp').value;

      // Kunci input agar tidak bisa diedit manual
      document.getElementById('alamat_domisili').readOnly = true;
      $('#provinsi_domisili, #kota_domisili, #kecamatan_domisili, #kelurahan_domisili').prop('disabled', true);
    } else {
      // Kosongkan semua input
      document.getElementById('alamat_domisili').value = "";
      document.getElementById('provinsi_domisili').value = "";
      document.getElementById('hidden_provinsi_domisili').value = "";
      $('#provinsi_domisili').trigger('change');

      document.getElementById('kota_domisili').value = "";
      document.getElementById('hidden_kota_domisili').value = "";
      $('#kota_domisili').trigger('change');

      document.getElementById('kecamatan_domisili').value = "";
      document.getElementById('hidden_kecamatan_domisili').value = "";
      $('#kecamatan_domisili').trigger('change');

      document.getElementById('kelurahan_domisili').value = "";
      document.getElementById('hidden_kelurahan_domisili').value = "";
      $('#kelurahan_domisili').trigger('change');

      document.getElementById('kode_pos_domisili').value = "";

      // Aktifkan kembali input supaya bisa diisi manual
      document.getElementById('alamat_domisili').readOnly = false;
      $('#provinsi_domisili, #kota_domisili, #kecamatan_domisili, #kelurahan_domisili').prop('disabled', false);
    }
  });

  // Select2
  // Tempat Lahir
  $(document).ready(function () {
    $('#tempat_lahir').select2({
      placeholder: "Pilih Tempat Lahir",
      allowClear: true,
      width: '100%'
    });

    // Ambil nilai old value dari Laravel
    var oldTempatLahir = "{{ old('tempat_lahir') }}";

    // Jika old value ada, set di Select2
    if (oldTempatLahir) {
      $('#tempat_lahir').val(oldTempatLahir).trigger('change');
    }
  });

  // Wilayah daftar
  $(document).ready(function () {
    $('#wilayah_daftar').select2({
      placeholder: "Pilih",
      allowClear: true,
      width: '100%'
    });

    // Ambil nilai old value dari Laravel
    var oldWilayah = "{{ old('wilayah_daftar') }}";

    // Jika old value ada, set di Select2
    if (oldWilayah) {
      $('#wilayah_daftar').val(oldWilayah).trigger('change');
    }
  });

  // Cabang
  $(document).ready(function () {
    $('#cabang_id').select2({
      placeholder: "Pilih", // Placeholder
      allowClear: true, // Bisa menghapus pilihan
      width: '100%' // Sesuaikan dengan Tailwind
    });

    // Ambil nilai old value dari Laravel
    var oldValue = "{{ old('cabang_id') }}";

    // Jika oldValue ada, set di Select2
    if (oldValue) {
      $('#cabang_id').val(oldValue).trigger('change');
    }
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

  // Keberangkatan
  $(document).ready(function () {
    $('#keberangkatan').select2({
      placeholder: "Pilih Keberangkatan",
      allowClear: true,
      width: '100%'
    });

    // Ambil nilai old value dari Laravel
    var oldSumberInfo = "{{ old('keberangkatan') }}";

    // Jika old value ada, set di Select2
    if (oldSumberInfo) {
      $('#keberangkatan').val(oldSumberInfo).trigger('change');
    }
  });


  // JS untuk Alamat KTP
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


  // JS untuk Alamat Domisili
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

  // Input type hidden untuk provinsi_domisili sampai kelurahan_domisili
  $('#provinsi_domisili').on('change', function () {
    $('#hidden_provinsi_domisili').val($(this).val());
  });
  $('#kota_domisili').on('change', function () {
      $('#hidden_kota_domisili').val($(this).val());
  });
  $('#kecamatan_domisili').on('change', function () {
      $('#hidden_kecamatan_domisili').val($(this).val());
  });
  $('#kelurahan_domisili').on('change', function () {
      $('#hidden_kelurahan_domisili').val($(this).val());
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