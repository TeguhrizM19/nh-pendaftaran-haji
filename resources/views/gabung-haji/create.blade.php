<x-layout>
  <div>
    <x-page-title>Form gabung KBIH</x-page-title>
  </div>

  <div class="rounded-lg shadow-lg shadow-black mt-4 p-4">
    <form action="/gabung-haji" method="POST">
      @csrf

      <div class="w-full grid grid-cols-1 md:grid-cols-3 gap-7">
        {{-- Kolom 1 --}}
        <div>
          <div class="relative">
            <div class="flex flex-col-reverse sm:flex-row sm:items-end gap-2 w-full">
              <!-- Input Nama Customer -->
              <div class="w-full sm:w-96">
                <label class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">Nama Lengkap</label>
                <input type="text" name="nama" placeholder="Nama Lengkap" value="{{ old('nama') }}" required
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

          <div class="grid grid-cols-1 md:grid-cols-1 gap-2 mt-3">
            <div>
              <label class="block text-sm font-medium mb-2 leading-6 text-[#099AA7]">Nama Panggilan</label>
              <input type="text" name="panggilan" placeholder="Nama Panggilan" value="{{ old('panggilan') }}"
              class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6 uppercase" />
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mb-3">
            <div>
              <label class="block text-sm font-medium mb-2 leading-6 text-[#099AA7]">No SPPH</label>
              <input type="number" name="no_spph" placeholder="No SPPH" value="{{ old('no_spph') }}"
              class="block w-full rounded-md border-0 p-2 text-gray-900 shadow-slate-400 ring-1 ring-inset 
              ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6 
              @error('no_spph') border-red-500 ring-red-500 focus:ring-red-500 @enderror" />
              
              @error('no_spph')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="no_porsi" class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                Nomor Porsi
              </label>
              <input type="number" id="no_porsi" name="no_porsi" value="{{ old('no_porsi') }}" placeholder="Porsi Haji"
              class="block w-full rounded-md border-0 p-2 text-gray-900 shadow-slate-400 ring-1 ring-inset 
              ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6 
              @error('no_porsi') border-red-500 ring-red-500 focus:ring-red-500 @enderror" />
              
              @error('no_porsi')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
            <div>
              <label class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">Nama Bank</label>
              <input type="text" name="nama_bank" placeholder="Bank/Jumlah Setoran" value="{{ old('nama_bank') }}" required
                class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>

            <div>
              <label for="kota_bank" class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                Kota Bank
              </label>
              <div>
                <select name="kota_bank" id="kota_bank"
                  class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                  <option value="">Pilih Kota Bank</option>
                  @foreach ($kotaBank as $kb)
                    <option value="{{ $kb->id }}" {{ old('kota_bank', $selectedKotaBank ?? '') == $kb->id ? 'selected' : '' }}>
                      {{ $kb->kota_lahir }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
            <div>
              <label for="depag" class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                Depag
              </label>
                <select name="depag" id="depag" required
                  class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                  <option value="">Pilih Kota Bank</option>
                  @foreach ($depag as $dp)
                    <option value="{{ $dp->id }}" {{ old('depag', $selectedDepag ?? '') == $dp->id ? 'selected' : '' }}>
                      {{ $dp->kota }}
                    </option>
                  @endforeach
                </select>
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

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4"> 
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
          </div>

          <div class="flex gap-6 mt-3">
            <!-- Kolom Dokumen -->
            <div class="w-full">
              <h3 class="mb-3 font-semibold text-[#099AA7]">Dokumen</h3>
              <ul class="w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg">
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
          </div>

          <div>
            <label for="message" class="block mt-3 mb-2 text-sm font-medium text-[#099AA7]">
              Catatan
            </label>
            <textarea id="message" rows="4" name="catatan"
            class="mb-4 block p-2.5 w-full text-sm text-black bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" 
            placeholder="Write your thoughts here...">{{ old('catatan') }}</textarea>
          </div>
        </div>

        {{-- Kolom 2 --}}
        <div class="relative">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
            <div>
              <label class="block text-sm font-medium mb-2 leading-6 text-[#099AA7]">No HP 1</label>
              <input type="text" name="no_hp_1" placeholder="No HP 1" value="{{ old('no_hp_1') }}" required
              class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900 shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>
            <div>
              <label class="block text-sm font-medium mb-2 leading-6 text-[#099AA7]">No HP 2</label>
              <input type="text" name="no_hp_2" placeholder="No HP 2" value="{{ old('no_hp_2') }}"
              class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900 shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <!-- Tempat Lahir -->
            <div class=" shadow-slate-400">
              <label for="tempat_lahir" class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                Tempat Lahir
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
              <label for="tgl_lahir" class="block text-sm mb-2 font-medium leading-6 text-[#099AA7]">
                Tanggal Lahir
              </label>
              <input type="date" id="tgl_lahir" name="tgl_lahir" value="{{ old('tgl_lahir') }}" required
              class="block w-full rounded-md border border-gray-300 p-2 text-gray-900 shadow-slate-400 focus:ring-2 focus:ring-indigo-600 text-sm leading-6" />
            </div>
          </div>
        
          <!-- Jenis ID, No Identitas, dan Warga -->
          <div class="grid grid-cols-[1fr_2fr_1fr] gap-4">
            <!-- Dropdown Jenis ID -->
            <div>
              <div>
                <label for="jenis_id" class="block text-sm font-medium leading-6 text-[#099AA7]">Jenis ID</label>
                <select id="jenis_id" name="jenis_id"
                  class="w-full mt-2 text-gray-900 bg-white border border-gray-300 rounded-lg shadow-slate-400 text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                  <option value="">Pilih</option>
                  <option value="KTP" {{ old('jenis_id') == 'KTP' ? 'selected' : '' }}>KTP</option>
                  <option value="SIM" {{ old('jenis_id') == 'SIM' ? 'selected' : '' }}>SIM</option>
                </select>
              </div>
            </div>
            <!-- Input No Identitas (Lebih Lebar) -->
            <div>
              <label for="no_id" class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                No Identitas
              </label>
              <input type="text" id="no_id" name="no_id" placeholder="Masukkan No Identitas" value="{{ old('no_id') }}"
                class="block w-full rounded-md border-0 p-2 text-gray-900 shadow-slate-400 ring-1 ring-inset 
                ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6 
                @error('no_id') border-red-500 ring-red-500 focus:ring-red-500 @enderror" />
            
                @error('no_id')
                  <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Dropdown Warga -->
            <div>
              <label for="warga" class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">Warga</label>
              <select id="warga" name="warga"
                class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg shadow-slate-400 text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                <option value="">Pilih</option>
                <option value="WNI" {{ old('warga') == 'WNI' ? 'selected' : '' }}>WNI</option>
                <option value="WNA" {{ old('warga') == 'WNA' ? 'selected' : '' }}>WNA</option>
              </select>
            </div>            
          </div>
        
          <div>
            <label for="alamat_ktp" class="block mb-2 mt-4 text-sm font-medium text-[#099AA7]">
              Alamat Sesuai KTP
            </label>
            <textarea id="alamat_ktp" rows="2" name="alamat_ktp" required
            class="block p-2.5 w-full text-sm text-black bg-white shadow-slate-400 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 uppercase" 
            placeholder="Write your thoughts here...">{{ old('alamat_ktp') }}</textarea>
          </div>

          <div class=" shadow-slate-400">
            <label for="provinsi" class="mt-4 mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
              Provinsi
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
            <label for="kota_ktp" class="mt-4 mb-2 block text-sm font-medium leading-6 text-[#099AA7]">Kota</label>
            <select name="kota_ktp" id="kota_ktp" required
            class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
              <option value="">Pilih Kota</option>
              @if(old('kota_ktp', $selectedKota ?? false))
                <option value="{{ old('kota_ktp', $selectedKota) }}" selected>{{ $namaKota ?? 'Kota Terpilih' }}</option>
              @endif
            </select>
          </div>

          <div class=" shadow-slate-400">
            <label for="kecamatan_ktp" class="mt-4 mb-2 block text-sm font-medium leading-6 text-[#099AA7]">Kecamatan</label>
            <select name="kecamatan_ktp" id="kecamatan_ktp" value="{{ old('kecamatan_ktp') }}"
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
              <div class="w-full shadow-slate-400">
                <label for="kelurahan_ktp" class="block mb-2 text-sm font-medium leading-6 text-[#099AA7]">Kelurahan</label>
                <select name="kelurahan_ktp" id="kelurahan_ktp"
                class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                  <option value="">Pilih Kelurahan</option>
                  @if(old('kelurahan_ktp', $selectedKelurahan ?? false))
                    <option value="{{ old('kelurahan_ktp', $selectedKelurahan) }}" selected>{{ $namaKelurahan ?? 'Kelurahan Terpilih' }}</option>
                  @endif
                </select>
              </div>
      
              <!-- Kolom Kode Pos (Lebih Kecil) -->
              {{-- <div class="w-1/4">
                <label for="kode_pos_ktp" class="block text-sm font-medium leading-6 text-[#099AA7]">
                  Kode Pos
                </label>
                <input type="text" id="kode_pos_ktp"
                  class="bg-gray-100 border border-gray-300 text-gray-900 shadow-slate-400 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 cursor-not-allowed"
                  disabled>
              </div> --}}
            </div>            
          </div>
        </div>
        
        {{-- Kolom 3 --}}
        <div class="relative">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Dropdown Jenis Kelamin -->
            <div>
              <label class="mb-2 block text-sm font-medium text-[#099AA7]">Jenis Kelamin</label>
              <ul class="w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg">
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
              <label class="mb-2 block text-sm font-medium text-[#099AA7]">Status</label>
              <ul class="w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg">
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
              <label class="block mb-2 text-sm font-medium leading-6 text-[#099AA7]">Pekerjaan</label>
              <input type="text" name="pekerjaan" placeholder="Pekerjaan" value="{{ old('pekerjaan') }}"
              class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900 shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>
            <div>
              <label for="pendidikan" class="block mb-2 text-sm font-medium leading-6 text-[#099AA7]">Pendidikan</label>
              <select id="pendidikan" name="pendidikan"
                class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg shadow-slate-400 text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
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

          <div>
            <div class="flex items-center gap-4 mb-2 mt-1">
              <label for="alamat_domisili" class="text-sm font-medium text-[#099AA7]">
                Alamat Domisili
              </label>
              <div class="flex items-center gap-2">
                <input id="copy-checkbox" type="checkbox" name="copy_checkbox"
                class="w-5 h-5 text-blue-600 bg-gray-200 border-gray-300 rounded-sm focus:ring-blue-500 focus:ring-2" {{ old('copy_checkbox') ? 'checked' : '' }}>
                <label for="copy-checkbox" class="text-sm font-medium text-gray-900">
                  Gunakan Alamat KTP
                </label>
              </div>
            </div>            
            <textarea id="alamat_domisili" rows="2" name="alamat_domisili" required
            class="block p-2.5 w-full text-sm text-black bg-white shadow-slate-400 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 uppercase" 
            placeholder="Write your thoughts here...">{{ old('alamat_domisili') }}</textarea>
          </div>

          <div class=" shadow-slate-400">
            <label for="provinsi_domisili" 
            class="mt-4 mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
              Provinsi
            </label>
            <select name="provinsi_domisili" id="provinsi_domisili" required
            class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
              <option value="">Pilih Provinsi</option>
              @foreach ($provinsi as $prov)
                <option value="{{ $prov->id }}" 
                  {{ old('provinsi_domisili', $selectedProvinsiDom ?? '') == $prov->id ? 'selected' : '' }}>
                  {{ $prov->provinsi }}
                </option>
              @endforeach
            </select>
            <input type="hidden" name="provinsi_domisili" id="hidden_provinsi_domisili" value="{{ old('provinsi_domisili') }}">
          </div>

          <div class=" shadow-slate-400">
            <label for="kota_domisili" class="mt-4 mb-2 block text-sm font-medium leading-6 text-[#099AA7]">Kota</label>
            <select name="kota_domisili" id="kota_domisili" required
            class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
              <option value="{{ old('kota_domisili', $selectedKotaDom ?? '') }}" selected>
                {{ $namaKotaDom ?? 'Pilih Kota' }}
              </option>
            </select>
            <input type="hidden" name="kota_domisili" id="hidden_kota_domisili" value="{{ old('kota_domisili') }}">
          </div>

          <div class=" shadow-slate-400">
            <label for="kecamatan_domisili" class="mt-4 mb-2 block text-sm font-medium leading-6 text-[#099AA7]">Kecamatan</label>
            <select name="kecamatan_domisili" id="kecamatan_domisili"
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
              <div class="w-full shadow-slate-400">
                <label for="kelurahan_domisili" class="block mb-2 text-sm font-medium leading-6 text-[#099AA7]">Kelurahan</label>
                <select name="kelurahan_domisili" id="kelurahan_domisili"
                class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                  <option value="{{ old('kelurahan_domisili', $selectedKelurahanDom ?? '') }}" selected>
                    {{ $namaKelurahanDom ?? 'Pilih Kelurahan' }}
                  </option>
                </select>
                <input type="hidden" name="kelurahan_domisili" id="hidden_kelurahan_domisili" value="{{ old('kelurahan_domisili') }}">
              </div>

              <!-- Kolom Kode Pos (Lebih Kecil) -->
              {{-- <div class="w-1/4">
                <label for="kode_pos_domisili" class="block text-sm font-medium leading-6 text-[#099AA7]">Kode Pos</label>
                <input type="text" id="kode_pos_domisili"
                  class="bg-gray-100 border border-gray-300 text-gray-900 shadow-slate-400 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 cursor-not-allowed"
                  disabled>
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
  // Tampilkan modal pencarian
  document.getElementById("openSearch").addEventListener("click", function () {
  document.getElementById("searchModal").classList.remove("hidden");
  document.getElementById("searchInput").focus();
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
        console.log("Response Data:", data); // Debugging

        customerList.innerHTML = ""; // Kosongkan hasil sebelumnya

        data.customers.forEach(customer => {
          let gabungHaji = data.gabungHaji.find(gabung => gabung.customer_id === customer.id);

          let li = document.createElement("li");
          li.classList.add("flex", "justify-start", "items-center", "p-4", "hover:bg-blue-100", "cursor-pointer", "gap-4");

          li.innerHTML = `
            <div class="flex-1">
              <span class="font-semibold">NIK: ${customer.no_id}</span>
              <span class="block text-gray-600">Nama: ${customer.nama}</span>
            </div>
            <div class="flex gap-2">
              <a href="/repeat-data-gabung/${customer.id}" class="repeat-btn bg-[#099AA7] text-white px-4 py-2 rounded-lg text-sm">
                🔄 Repeat Data
              </a>
              <a href="/ambil-semua-data-gabung/${customer.id}" class="ambil-btn bg-green-500 text-white px-4 py-2 rounded-lg text-sm">
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

    // Set old value jika ada
    var selectedKotaBank = "{{ old('kota_bank', $selectedKotaBank ?? '') }}";
    if (selectedKotaBank) {
      $('#kota_bank').val(selectedKotaBank).trigger('change');
    }
  });

  // Depag
  $(document).ready(function () {
    $('#depag').select2({
      placeholder: "Pilih", // Placeholder
      allowClear: true, // Bisa menghapus pilihan
      width: '100%' // Sesuaikan dengan Tailwind
    });

    // Set old value jika ada
    var selectedKotaBank = "{{ old('depag', $selectedDepag ?? '') }}";
    if (selectedKotaBank) {
      $('#depag').val(selectedKotaBank).trigger('change');
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

</script>
</x-layout>