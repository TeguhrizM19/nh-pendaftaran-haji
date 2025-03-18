<x-layout>
  <div>
    <x-page-title>Ambil Semua Data Pendaftar Haji</x-page-title>
  </div>

  <div class="rounded-lg shadow-lg shadow-black mt-4 p-4">
    <form id="formPendaftaran" action="{{ route('pendaftaran-haji-ambilSemuaData') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="w-full grid grid-cols-1 md:grid-cols-3 gap-7">
        {{-- Kolom 1 --}}
        <div>
          <div class="relative">
            <div class="flex gap-2 mb-3 items-end">
              <!-- Kolom Nama (Lebih Lebar) -->
              <div class="w-full">
                <label class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">Nama Customer</label>
                  <input type="text" name="nama" id="nama" placeholder="Nama" value="{{ old('nama') }}" required
                  class="block w-full rounded-md border-0 p-2 text-gray-900  shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6 uppercase" />
              </div>
            </div>
          </div>

          <div>
            <label class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">Nomor Porsi Haji</label>
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
                Cabang Daftar
              </label>
              <select name="cabang_id" id="cabang_id" class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                @if(isset($daftar_haji->cabang_id))
                  <option value="{{ $daftar_haji->cabang_id }}" selected>{{ $cabang->cabang ?? 'Pilih Cabang' }}</option>
                @endif
              </select>
            </div>

            <div class="">
              <label for="wilayah_daftar" class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">Wilayah Daftar</label>
              <select name="wilayah_daftar" id="wilayah_daftar" class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                @if(isset($daftar_haji->wilayah_daftar))
                  <option value="{{ $daftar_haji->wilayah_daftar }}" selected>{{ $wilayahDaftar->kota_lahir ?? 'Pilih Wilayah Daftar' }}</option>
                @endif
              </select>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-4">
            <div>
              <label class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">Bank</label>
              <input type="text" name="bank" id="bank" value="{{ old('bank') }}" placeholder="Bank/Jumlah Setoran" 
                class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900  ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>

            <div class="">
              <label for="sumber_info" class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">Sumber Informasi</label>
              <select name="sumber_info_id" id="sumber_info"
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

          <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-4">
            <div>
              <label class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">BPJS</label>
              <input type="number" name="bpjs" id="bpjs" placeholder="No BPJS" value="{{ old('bpjs') }}"
              class="block w-full rounded-md border-0 p-2 text-gray-900 shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6 @error('bpjs') border-red-500 ring-red-500 focus:ring-red-500 @enderror" />
              
              @error('bpjs')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">Tahun Keberangkatan</label>
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

          <div class="flex gap-6 mt-3">
            <!-- Kolom Paket Pendaftaran -->
            <div class="w-full">
              <h3 class="mb-3 font-semibold text-[#099AA7]">Paket Pendaftaran</h3>
              <ul class="w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg">
                <!-- Layout desktop (2 kolom), di HP jadi 1 kolom -->
                <div class="grid grid-cols-1 md:grid-cols-1">
                  <!-- Reguler Tunai -->
                  <li class="border-b border-gray-200">
                    <div class="flex items-center ps-3">
                      <input id="reguler-tunai" type="radio" value="Reguler Tunai" name="paket_haji"
                        {{ old('paket_haji') == 'Reguler Tunai' ? 'checked' : '' }}
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
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4"> 
            {{-- Pelunasan Haji --}}
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
          
            <!-- Pelunasan manasik -->
            <div class="w-full">
              <h3 class="mb-3 font-semibold text-[#099AA7]">Pelunasan Manasik</h3>
              <ul class="w-full text-sm font-medium  text-gray-900 bg-white border border-gray-200 rounded-lg">
                <li class="w-full border-b border-gray-200">
                  <div class="flex items-center ps-3">
                    <input id="pelunasan_manasik" type="radio" value="Lunas" name="pelunasan_manasik"
                    {{ old('pelunasan_manasik') == 'Lunas' ? 'checked' : '' }}  
                    class="w-4 h-4 text-blue-600 bg-gray-300 border-gray-300 focus:ring-blue-500 focus:ring-2">
                    <label for="pelunasan_manasik" class="w-full py-3 ms-2 text-sm font-medium text-gray-900">
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
              <label class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">No HP 1</label>
              <input type="text" name="no_hp_1" id="no_hp_1" value="{{ old('no_hp_1', $customer->no_hp_1) }}" placeholder="No HP 1" 
              class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900  shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>
            <div>
              <label class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">No HP 2</label>
              <input type="text" name="no_hp_2" id="no_hp_2" value="{{ old('no_hp_2', $customer->no_hp_2) }}" placeholder="No HP 2"
              class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900  shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <!-- Tempat Lahir -->
            <div class=" shadow-slate-400">
              <label for="tempat_lahir" class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                Tempat Lahir
              </label>
              <select name="tempat_lahir" id="tempat_lahir" 
                class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
              </select>
            </div>
        
            <!-- Tanggal Lahir -->
            <div>
              <label for="tgl_lahir" class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">Tanggal Lahir</label>
              <input type="date" id="tgl_lahir" name="tgl_lahir" value="{{ old('tgl_lahir') }}" 
              class="block w-full rounded-md border border-gray-300 p-2 text-gray-900  shadow-slate-400 focus:ring-2 focus:ring-indigo-600 text-sm leading-6" />
            </div>
          </div>
        
          <!-- Jenis ID, No Identitas, dan Warga -->
          <div class="grid grid-cols-[1fr_2fr_1fr] gap-4">
            <!-- Dropdown Jenis ID -->
            <div>
              <div>
                <label for="jenis_id" class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">Jenis ID</label>
                <select id="jenis_id" name="jenis_id" 
                  class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg  shadow-slate-400 text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                  <option value="">Pilih</option>
                  <option value="KTP" {{ $customer->jenis_id == 'KTP' ? 'selected' : '' }}>KTP</option>
                  <option value="SIM" {{ $customer->jenis_id == 'SIM' ? 'selected' : '' }}>SIM</option>
                </select>
              </div>
            </div>
            <!-- Input No Identitas (Lebih Lebar) -->
            <div>
              <div>
                <label for="no_id" class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                  No Identitas
                </label>
                <input type="text" id="no_id" name="no_id" placeholder="Masukkan No Identitas" value="{{ old('no_id') }}"
                  class="block w-full rounded-md border-0 p-2 text-gray-900  shadow-slate-400 ring-1 ring-inset 
                  ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6 
                  @error('no_id') border-red-500 ring-red-500 focus:ring-red-500 @enderror" />
              
                @error('no_id')
                  <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
              </div>
            </div>

            <!-- Dropdown Warga -->
            <div>
              <label for="warga" class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">Warga</label>
              <select id="warga" name="warga" 
                class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg  shadow-slate-400 text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                <option value="">Pilih</option>
                <option value="WNI" {{ $customer->warga == 'WNI' ? 'selected' : '' }}>WNI</option>
                <option value="WNA" {{ $customer->warga == 'WNA' ? 'selected' : '' }}>WNA</option>
              </select>
            </div>           
          </div>
        
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <!-- Dropdown Jenis Kelamin -->
            <div class="w-full">
              <h3 class="mb-3 font-semibold text-[#099AA7]">Jenis Kelamin</h3>
              <ul class="w-full text-sm font-medium shadow-lg text-gray-900 bg-white border border-gray-200 rounded-lg">
                <li class="w-full border-b border-gray-200">
                  <div class="flex items-center ps-3">
                    <input id="laki-laki" type="radio" value="Laki-Laki" name="jenis_kelamin" 
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
            
            <div class="w-full">
              <h3 class="mb-3 font-semibold text-[#099AA7]">Status</h3>
              <ul class="w-full text-sm font-medium shadow-lg text-gray-900 bg-white border border-gray-200 rounded-lg">
                <li class="w-full border-b border-gray-200">
                  <div class="flex items-center ps-3">
                    <input id="menikah" type="radio" value="Menikah" name="status_nikah" 
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
              <label class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">Pekerjaan</label>
              <input type="text" name="pekerjaan" id="pekerjaan" placeholder="Pekerjaan" value="{{ old('pekerjaan') }}"
              class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900  shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>
            <div>
              <label for="pendidikan" class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">Pendidikan</label>
              <select id="pendidikan" name="pendidikan"
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
        
        {{-- Kolom 3 --}}
        <div class="relative">
          <!-- Alamat KTP -->
          <div>
            <label for="alamat_ktp" class="block mb-2 text-sm font-medium text-[#099AA7]">Alamat Sesuai KTP</label>
            <textarea id="alamat_ktp" rows="2" name="alamat_ktp" 
              class="block p-2.5 w-full text-sm text-black bg-white  rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 uppercase" 
              placeholder="Alamat KTP...">{{ old('alamat_ktp', $customer->alamat_ktp) }}</textarea>
          </div>

          <!-- Provinsi KTP -->
          <div class="">
            <div class=" shadow-slate-400 mt-4">
              <label for="provinsi_ktp" class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                Provinsi KTP
              </label>
              <select name="provinsi_ktp" id="provinsi_ktp" 
                class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                <option value="{{ $customer->provinsi_ktp ?? '' }}" selected>
                  {{ $provinsi_ktp->provinsi ?? 'Pilih Provinsi' }}
                </option>
              </select>
            </div>
          </div>

          <!-- Kota KTP -->
          <div class="">
            <label for="kota_ktp" class="mt-4 mb-2 block text-sm font-medium text-[#099AA7]">Kota</label>
            <select name="kota_ktp" id="kota_ktp" 
            data-selected="{{ $customer->kota_ktp ?? '' }}" 
              class="w-full text-gray-900  bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
              <option value="{{ $customer->kota_ktp ?? '' }}" selected>
                {{ $kota_ktp->kota ?? 'Pilih Kota' }}
              </option>
            </select>
          </div>

          <!-- Kecamatan KTP -->
          <div class="">
            <label for="kecamatan_ktp" class="mt-4 mb-2 block text-sm font-medium text-[#099AA7]">Kecamatan</label>
            <select name="kecamatan_ktp" id="kecamatan_ktp" 
              data-selected="{{ $customer->kecamatan_ktp ?? '' }}"
              class="w-full text-gray-900  bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
              <option value="{{ $customer->kecamatan_ktp ?? '' }}" selected>
                {{ $kecamatan_ktp->kecamatan ?? 'Pilih Kecamatan' }}
              </option>
            </select>
          </div>

          <!-- Kelurahan & Kode Pos KTP -->
          <div class="flex gap-4 mt-4">
            <div class="w-full ">
              <label for="kelurahan_ktp" class="block mb-2 text-sm font-medium text-[#099AA7]">Kelurahan</label>
              <select name="kelurahan_ktp" id="kelurahan_ktp" data-selected="{{ $customer->kelurahan_ktp ?? '' }}"
                class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                <option value="{{ $customer->kelurahan_ktp ?? '' }}" selected>
                  {{ $kelurahan_ktp->kelurahan ?? 'Pilih Kelurahan' }}
                </option>
              </select>
            </div>
          </div>

          <!-- Alamat Domisili -->
          <div>
            <label for="alamat_domisili" class="block mt-4 mb-2 text-sm font-medium text-[#099AA7]">Alamat Domisili</label>
            <textarea id="alamat_domisili" rows="2" name="alamat_domisili" 
              class="mb-4 block p-2.5 w-full  text-sm text-black bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 uppercase"
              placeholder="Alamat Domisili...">{{ old('alamat_domisili', $customer->alamat_domisili) }}</textarea>
          </div>
      
          <!-- Provinsi -->
          <div class="">
            <label for="provinsi_domisili" class="block mb-2 text-sm font-medium leading-6 text-[#099AA7]">Provinsi</label>
            <select name="provinsi_domisili" id="provinsi_domisili" 
              class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
              <option value="{{ $customer->provinsi_domisili ?? '' }}" selected>
                {{ $provinsi_domisili->provinsi ?? 'Pilih Provinsi' }}
              </option>
            </select>
          </div>

          <!-- Kota -->
          <div class="">
            <label for="kota_domisili" class="mt-4 mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                Kota
            </label>
            <select name="kota_domisili" id="kota_domisili" 
            data-selected="{{ $customer->kota_domisili ?? '' }}" 
              class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
              <option value="{{ $customer->kota_domisili ?? '' }}" selected>
                {{ $kota_domisili->kota ?? 'Pilih Kota' }}
              </option>
            </select>
          </div>

          <!-- Kecamatan -->
          <div class="">
            <label for="kecamatan_domisili" class="mt-4 mb-2 block text-sm font-medium leading-6 text-[#099AA7]">Kecamatan</label>
            <select name="kecamatan_domisili" id="kecamatan_domisili" 
            data-selected="{{ $customer->kecamatan_domisili ?? '' }}"
              class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
              <option value="{{ $customer->kecamatan_domisili ?? '' }}" selected>
                {{ $kecamatan_domisili->kecamatan ?? 'Pilih Kecamatan' }}
              </option>
            </select>
          </div>
      
          <!-- Kelurahan -->
          <div class="flex gap-4 mt-4"> 
            <!-- Kelurahan -->
            <div class="w-full ">
              <label for="kelurahan_domisili" class="block mb-2 text-sm font-medium leading-6 text-[#099AA7]">Kelurahan</label>
              <select name="kelurahan_domisili" id="kelurahan_domisili" 
              data-selected="{{ $customer->kelurahan_domisili ?? '' }}"
                class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                <option value="{{ $customer->kelurahan_domisili ?? '' }}" selected>
                  {{ $kelurahan_domisili->kelurahan ?? 'Pilih kelurahan' }}
                </option>
              </select>
            </div>
          
            <!-- Kode Pos -->
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
  // Konfirmasi data yang belum diisi
  document.getElementById("formPendaftaran").addEventListener("submit", function (event) {
    let fields = [
      { id: "no_porsi_haji", label: "No Porsi Haji" },
      { id: "cabang_id", label: "Cabang" },
      { id: "sumber_info", label: "Sumber Info" },
      { id: "wilayah_daftar", label: "Wilayah Daftar" },
      { id: "bpjs", label: "BPJS" },
      { id: "bank", label: "Bank" },
      { id: "keberangkatan", label: "Tahun Keberangkatan" },
      { id: "catatan", label: "Catatan" },
      { id: "no_hp_1", label: "No HP 1" },
      { id: "no_hp_2", label: "No HP 2" },
      { id: "jenis_id", label: "Jenis ID" },
      { id: "no_id", label: "No ID" },
      { id: "warga", label: "Warga" },
      { id: "tempat_lahir", label: "Tempat Lahir" },
      { id: "tgl_lahir", label: "Tanggal Lahir" },
      { id: "pekerjaan", label: "Pekerjaan" },
      { id: "pendidikan", label: "Pendidikan" },
      { id: "alamat_ktp", label: "Alamat KTP" },
      { id: "provinsi_ktp", label: "Provinsi KTP" },
      { id: "kota_ktp", label: "Kota KTP" },
      { id: "kecamatan_ktp", label: "Kecamatan KTP" },
      { id: "kelurahan_ktp", label: "Kelurahan KTP" },
      { id: "alamat_domisili", label: "Alamat Domisili" },
      { id: "provinsi_domisili", label: "Provinsi Domisili" },
      { id: "kota_domisili", label: "Kota Domisili" },
      { id: "kecamatan_domisili", label: "Kecamatan Domisili" },
      { id: "kelurahan_domisili", label: "Kelurahan Domisili" },
      { id: "ktp", label: "Upload KTP" },
      { id: "kk", label: "Upload KK" },
      { id: "surat", label: "Upload Surat" },
      { id: "spph", label: "Upload SPPH" },
      { id: "bpih", label: "Upload BPIH" },
      { id: "photo", label: "Upload Photo" }
    ];

    let emptyFields = fields.filter(field => {
      let value = document.getElementById(field.id)?.value.trim();
      return value === "";
    });

    // Cek radio button yang wajib diisi
    let radioFields = [
      { name: "paket_haji", label: "Paket Haji" },
      { name: "jenis_kelamin", label: "Jenis Kelamin" },
      { name: "status_nikah", label: "Status Nikah" },
      { name: "pelunasan", label: "Pelunasan Haji" }, // Ditambahkan untuk pelunasan haji
      { name: "pelunasan_manasik", label: "Pelunasan Manasik" } // Ditambahkan untuk pelunasan manasik
    ];

    radioFields.forEach(field => {
      let isChecked = document.querySelector(`input[name="${field.name}"]:checked`);
      if (!isChecked) {
        emptyFields.push({ label: field.label });
      }
    });

    if (emptyFields.length > 0) {
      event.preventDefault(); // Mencegah submit jika ada field kosong

      let fieldNames = emptyFields.map(field => `<li>${field.label}</li>`).join("");

      Swal.fire({
        title: "Data Yang Belum Diisi",
        html: `
          <div style="text-align: left; max-height: 300px; overflow-y: auto;">
            <ul style="columns: 2; -webkit-columns: 2; -moz-columns: 2; padding-left: 20px;">
              ${fieldNames}
            </ul>
          </div>
          <p style="text-align: center;">Tetap simpan data?</p>
        `,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#099AA7",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Ya, Simpan",
        cancelButtonText: "Batal"
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById("formPendaftaran").submit(); // Submit setelah konfirmasi
        }
      });
    }
  });

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