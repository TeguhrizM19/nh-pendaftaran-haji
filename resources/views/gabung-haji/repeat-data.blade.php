<x-layout>
  <div>
    <x-page-title>Repeat Data gabung Haji</x-page-title>
  </div>

  <div class="rounded-lg shadow-lg shadow-black mt-4 p-4">
    {{-- <pre>{{ dd($gabung_haji) }}</pre> --}}

    {{-- <p>Form action: {{ route('gabung-haji-storeRepeatData', $gabung_haji->id) }}</p> --}}
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
              <label class="block text-sm font-medium leading-6 text-[#099AA7]">No Porsi</label>
              <input type="number" name="no_porsi" value="{{ old('no_porsi', $gabung_haji->no_porsi) }}" placeholder="No SPPH"
              class="mb-3 block w-full rounded-md shadow-md border-0 p-2 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6 uppercase" />
            </div>
            <div>
              <label class="block text-sm font-medium leading-6 text-[#099AA7]">Nomor spph</label>
              <input type="number" name="no_spph" value="{{ old('no_spph', $gabung_haji->no_spph) }}" placeholder="Nomor SPPH"
              class="mb-3 block w-full rounded-md shadow-md border-0 p-2 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
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
                  <option value="">Pilih Kota Bank</option>
                  @forelse ($kotaBank as $kb)
                    <option value="{{ $kb->id }}" {{ $kb->id == $gabung_haji->kota_bank ? 'selected' : '' }}>
                      {{ $kb->kota }}
                    </option>
                  @empty
                    <option value="">Wilayah Masih Kosong</option>
                  @endforelse
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

        {{-- Kolom 2 Alamat KTP --}}
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
                <option value="">Pilih Tempat Lahir</option>
                @forelse ($tempat_lahir as $tl)
                  <option value="{{ $tl->id }}" 
                    {{ $customer->tempat_lahir == $tl->id ? 'selected' : '' }}>
                    {{ $tl->kota }}
                  </option>
                @empty
                  <option value="">Tempat Lahir masih kosong</option>
                @endforelse
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
                <label for="jenis_id" class="block text-sm font-medium leading-6 text-[#099AA7]">Jenis ID</label>
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
              <label for="no_id" class="block text-sm font-medium leading-6 text-[#099AA7]">
                No Identitas
              </label>
              <input type="text" id="no_id" name="no_id" value="{{ old('no_id', $customer->no_id) }}" placeholder="Masukkan No Identitas"
              class="block w-full rounded-md border-0 p-2 text-gray-900 shadow-md shadow-slate-400 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>

            <!-- Dropdown Warga -->
            <div>
              <label for="warga" class="block text-sm font-medium leading-6 text-[#099AA7]">Warga</label>
              <select id="warga" name="warga" 
                class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg shadow-md shadow-slate-400 text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                <option value="">Pilih</option>
                <option value="WNI" {{ $customer->warga == 'WNI' ? 'selected' : '' }}>WNI</option>
                <option value="WNA" {{ $customer->warga == 'WNA' ? 'selected' : '' }}>WNA</option>
              </select>
            </div>            
          </div>
        
          @php
            $alamatKtp = json_decode($customer->alamat_ktp, true)['alamat'] ?? '';
          @endphp
          <div>
            <label for="alamat_ktp" class="block mt-4 mb-2 text-sm font-medium text-[#099AA7]">
              Alamat Sesuai KTP
            </label>
            <textarea id="alamat_ktp" rows="2" name="alamat_ktp"
            class="block p-2.5 w-full text-sm text-black bg-white shadow-md shadow-slate-400 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" 
            placeholder="Write your thoughts here...">{{ $alamatKtp }}</textarea>
          </div>

          <div class="shadow-md shadow-slate-400">
            <label for="provinsi" class="mt-4 block text-sm font-medium leading-6 text-[#099AA7]">
              Provinsi
            </label>
            <select name="provinsi_ktp_id" id="provinsi_ktp"
            class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
            <option value="">Pilih Provinsi</option>
              @forelse ($provinsi as $prov)
                <option value="{{ $prov->id }}" 
                  {{ old('provinsi_ktp_id', $provinsi_selected->id ?? '') == $prov->id ? 'selected' : '' }}>
                  {{ $prov->provinsi }}
                </option>
              @empty
                <option value="">Provinsi masih kosong</option>
            @endforelse
            </select>
          </div>

          <div class="shadow-md shadow-slate-400">
            <label for="kota_ktp" class="mt-4 block text-sm font-medium leading-6 text-[#099AA7]">Kota</label>
            <select name="kota_ktp_id" id="kota_ktp"
            class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
              <option value="">Pilih Kota</option>
              @forelse ($kota as $kt)
                <option value="{{ $kt->id }}" 
                  {{ old('kota_ktp_id', $kota_selected->id ?? '') == $kt->id ? 'selected' : '' }}>
                  {{ $kt->kota }}
                </option>
              @empty
                <option value="">Kota masih kosong</option>
              @endforelse
            </select>
          </div>

          <div class="shadow-md shadow-slate-400">
            <label for="kecamatan_ktp" class="mt-4 block text-sm font-medium leading-6 text-[#099AA7]">Kecamatan</label>
            <select name="kecamatan_ktp_id" id="kecamatan_ktp"
            class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
              <option value="">Pilih Kecamatan</option>
              @forelse ($kecamatan as $kc)
                <option value="{{ $kc->id }}" 
                  {{ old('kecamatan_ktp_id', $kecamatan_selected->id ?? '') == $kc->id ? 'selected' : '' }}>
                  {{ $kc->kecamatan }}
                </option>
              @empty
                <option value="">Kota masih kosong</option>
              @endforelse
            </select>
          </div>

          <div class="relative">
            <div class="flex gap-4 mt-4">
              <!-- Kolom Kelurahan (Lebih Lebar) -->
              <div class="w-full shadow-md shadow-slate-400">
                <label for="kelurahan_ktp" class="block text-sm font-medium leading-6 text-[#099AA7]">Kelurahan</label>
                <select name="kelurahan_ktp_id" id="kelurahan_ktp"
                class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                  <option value="">Pilih Kelurahan</option>
                  @forelse ($kelurahan as $kl)
                      <option value="{{ $kl->id }}" data-kode-pos="{{ $kl->kode_pos }}"
                        {{ old('kelurahan_ktp_id', $kelurahan_selected->id ?? '') == $kl->id ? 'selected' : '' }}>
                        {{ $kl->kelurahan }}
                      </option>
                    @empty
                      <option value="">Kelurahan masih kosong</option>
                    @endforelse
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

          @php
            $alamatDomisili = is_array($customer->alamat_domisili) 
              ? $customer->alamat_domisili
              : json_decode($customer->alamat_domisili, true) ?? [];
          @endphp
          <div>
            <label for="alamat_domisili" class="block mb-2 text-sm font-medium text-[#099AA7]">
              Alamat Domisili
            </label>
            <textarea id="alamat_domisili" rows="2" name="alamat_domisili" required
              class="mb-4 block p-2.5 w-full shadow-md shadow-slate-400 text-sm text-black bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
              placeholder="Alamat Domisili...">{{ old('alamat_domisili', $alamatDomisili['alamat'] ?? '') }}</textarea>
          </div>

          <div class="shadow-md shadow-slate-400">
            <label for="provinsi_domisili" class="mt-4 block text-sm font-medium leading-6 text-[#099AA7]">Provinsi</label>
            <select name="provinsi_domisili_id" id="provinsi_domisili"
            class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
              <option value="">Pilih Provinsi</option>
              @foreach ($provinsi as $prov)
                <option value="{{ $prov->id }}" {{ old('provinsi_domisili_id', $alamatDomisili['provinsi_id'] ?? '') == $prov->id ? 'selected' : '' }}>
                  {{ $prov->provinsi }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="shadow-md shadow-slate-400">
            <label for="kota_domisili" class="mt-4 block text-sm font-medium leading-6 text-[#099AA7]">Kota</label>
            <select name="kota_domisili_id" id="kota_domisili"
            class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
              <option value="">Pilih Kota</option>
              @foreach ($kota as $kt)
                <option value="{{ $kt->id }}" {{ old('kota_domisili_id', $alamat_domisili['kota_id'] ?? '') == $kt->id ? 'selected' : '' }}>
                  {{ $kt->kota }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="shadow-md shadow-slate-400">
            <label for="kecamatan_domisili" class="mt-4 block text-sm font-medium leading-6 text-[#099AA7]">Kecamatan</label>
            <select name="kecamatan_domisili_id" id="kecamatan_domisili"
            class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
              <option value="">Pilih Kecamatan</option>
              @foreach ($kecamatan as $kc)
                <option value="{{ $kc->id }}" {{ old('kecamatan_domisili_id', $alamat_domisili['kecamatan_id'] ?? '') == $kc->id ? 'selected' : '' }}>
                  {{ $kc->kecamatan }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="relative">
            <div class="flex gap-4 mt-4">
              <!-- Kolom Kelurahan (Lebih Lebar) -->
              <div class="w-full shadow-md shadow-slate-400">
                <label for="kelurahan_domisili" class="block text-sm font-medium leading-6 text-[#099AA7]">Kelurahan</label>
                <select name="kelurahan_domisili_id" id="kelurahan_domisili"
                  class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                  <option value="">Pilih Kelurahan</option>
                  @foreach ($kelurahan as $kl)
                    <option value="{{ $kl->id }}" data-kode-pos="{{ $kl->kode_pos }}"
                      {{ old('kelurahan_domisili_id', $alamat_domisili['kelurahan_id'] ?? '') == $kl->id ? 'selected' : '' }}>
                      {{ $kl->kelurahan }}
                    </option>
                  @endforeach
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

<script>
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