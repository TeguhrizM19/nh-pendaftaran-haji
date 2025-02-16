<x-layout>
  <div>
    <x-page-title>Edit Data Pendaftar Haji</x-page-title>
  </div>

  <div class="rounded-lg shadow-lg p-4">
    <form action="/pendaftaran-haji/{{ $daftar_haji->id }}" method="POST">
      @method('PUT')
      @csrf

      <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-7">
        {{-- Kolom 1 --}}
        <div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
            <div>
              <label for="customer_id" class="block text-sm font-medium leading-6 text-[#099AA7]">
                Nama Customer
              </label>
              <select name="customer_id" id="customer_id" required
                class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2">
                <option value="">Pilih Customer</option>
                @foreach ($customers as $customer)
                  <option value="{{ $customer->id }}" 
                    {{ $daftar_haji->customer_id == $customer->id ? 'selected' : '' }}>
                    {{ $customer->nama }}
                  </option>
                @endforeach
              </select>
            </div>
          
            <div>
              <label for="wilayah_daftar" class="block text-sm font-medium leading-6 text-[#099AA7]">
                  Wilayah Daftar
              </label>
              <select name="wilayah_daftar" id="wilayah_daftar" required
                class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                <option value="">Pilih</option>
                @forelse ($kota as $kt)
                  <option value="{{ $kt->id }}" 
                    {{ $daftar_haji->wilayah_daftar == $kt->id ? 'selected' : '' }}>
                    {{ $kt->kota }}
                  </option>
                @empty
                  <option value="">Wilayah masih kosong</option>
                @endforelse
              </select>
            </div>
          </div>

          <div class="flex gap-4 mt-4"> 
            <!-- Pilih Cabang -->
            <div class="w-3/4">
              <label for="cabang_id" class="block text-sm font-medium leading-6 text-[#099AA7]">
                Cabang
              </label>
              <select name="cabang_id" id="cabang_id" required
                class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                <option value="">Pilih Cabang</option>
                @foreach ($cabang as $cab)
                  <option value="{{ $cab->id }}" 
                    {{ $daftar_haji->cabang_id == $cab->id ? 'selected' : '' }}>
                    {{ $cab->cabang }}
                  </option>
                @endforeach
              </select>
            </div>
        
            <!-- Kode Cabang -->
            <div class="w-1/4">
              <label for="kode_cab" class="block text-sm font-medium leading-6 text-[#099AA7]">Kode Cabang</label>
              <input type="text" id="kode_cab" name="kode_cab"
                class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 cursor-not-allowed"
                value="{{ $daftar_haji->cabang ? $daftar_haji->cabang->kode_cab : '' }}" readonly>
            </div>
          </div>
        
          <!-- Alamat Cabang -->
          <div class="mt-4">
            <label for="alamat" class="block text-sm font-medium leading-6 text-[#099AA7]">
              Alamat Cabang
            </label>
            <input type="text" id="alamat"
              class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 cursor-not-allowed"
              value="{{ $daftar_haji->cabang ? $daftar_haji->cabang->alamat : '' }}" readonly>
          </div>
          
          <div class="my-4">
            <label class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">Paket Pendaftaran</label>
            <div class="flex items-center gap-6">
              <div class="flex items-center">
                <input id="reguler-tunai" type="radio" value="Reguler Tunai" name="paket_haji" required class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500" 
                {{ $daftar_haji->paket_haji == 'Reguler Tunai' ? 'checked' : '' }}>
                <label for="reguler-tunai" class="ms-2 text-sm font-medium text-gray-900">Reguler Tunai</label>
              </div>
              <div class="flex items-center">
                <input id="reguler-talangan" type="radio" value="Reguler Talangan" name="paket_haji" required class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                {{ $daftar_haji->paket_haji == 'Reguler Talangan' ? 'checked' : '' }}>
                <label for="reguler-talangan" class="ms-2 text-sm font-medium text-gray-900">Reguler Talangan</label>
              </div>
              <div class="flex items-center">
                <input id="khusus" type="radio" value="Khusus/Plus" name="paket_haji" required class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500" 
                {{ $daftar_haji->paket_haji == 'Khusus/Plus' ? 'checked' : '' }}>
                <label for="khusus" class="ms-2 text-sm font-medium text-gray-900">Khusus/Plus</label>
              </div>
            </div>
          </div>
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-4">
            <div>
              <label class="block text-sm font-medium leading-6 text-[#099AA7]">Estimasi</label>
              <input type="number" name="estimasi" required min="1900" max="2099" step="1" placeholder="YYYY" value="{{ $daftar_haji->estimasi }}"
                class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>

            <div>
              <label class="block text-sm font-medium leading-6 text-[#099AA7]">BPJS</label>
              <input type="number" name="bpjs" required placeholder="No BPJS" value="{{ $daftar_haji->estimasi }}"
              class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>
          </div>
                    
          <h3 class="mb-4 font-semibold text-gray-900">Dokumen</h3>
          <ul class="w-75 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg">
            @foreach ($documents as $document)
            <li class="w-full border-b border-gray-300 rounded-t-lg">
              <label class="flex items-center ps-3 py-3 w-full cursor-pointer">
                <input type="checkbox" name="dok_id[]" value="{{ $document->id }}"
                  class="w-4 h-4 text-[#099AA7] bg-gray-100 border-gray-400 rounded-sm focus:ring-[#099AA7] focus:ring-2"
                  {{ in_array($document->id, $selected_documents) ? 'checked' : '' }}>
                <span class="ms-2 text-sm font-medium text-gray-900">{{ $document->dokumen }}</span>
              </label>
            </li>
            @endforeach
          </ul>
        </div>
        
        {{-- Wilayah Indo --}}
        <div class="relative">
          <div>
            <label for="message" class="block mb-2 text-sm font-medium text-[#099AA7]">
              Alamat Domisili
            </label>
            <textarea id="message" rows="2" name="domisili" required
            class="mb-4 block p-2.5 w-full text-sm text-black bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" 
            placeholder="Write your thoughts here...">{{ old('alamat', $daftar_haji->domisili) }}</textarea>
          </div>

          <label for="provinsi" class="block text-sm font-medium leading-6 text-[#099AA7]">
            Provinsi
          </label>
          <select name="provinsi_id" id="provinsi" required
            class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
            <option value="">Pilih Provinsi</option>
            @forelse ($provinsi as $prov)
              <option value="{{ $prov->id }}" {{ old('provinsi_id', $daftar_haji->provinsi_id) == $prov->id ? 'selected' : '' }}>
                {{ $prov->provinsi }}
              </option>
            @empty
              <option value="">Provinsi masih kosong</option>
            @endforelse
          </select>

          <label for="kota" class="mt-4 block text-sm font-medium leading-6 text-[#099AA7]">Kota</label>
          <select name="kota_id" id="kota" required
            class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
            <option value="">Pilih Kota</option>
            @forelse ($kota as $kt)
              <option value="{{ $kt->id }}" 
                {{ old('kota_id', $daftar_haji->kota_id) == $kt->id ? 'selected' : '' }}>
                {{ $kt->kota }}
              </option>
            @empty
              <option value="">Kota masih kosong</option>
            @endforelse
          </select>

          <label for="kecamatan" class="mt-4 block text-sm font-medium leading-6 text-[#099AA7]">Kecamatan</label>
          <select name="kecamatan_id" id="kecamatan" required
            class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
            <option value="">Pilih Kecamatan</option>
            @forelse ($kecamatan as $kc)
              <option value="{{ $kc->id }}" 
                {{ old('kecamatan_id', $daftar_haji->kecamatan_id) == $kc->id ? 'selected' : '' }}>
                {{ $kc->kecamatan }}
              </option>
            @empty
              <option value="">Kecamatan masih kosong</option>
            @endforelse
          </select>

          <div class="relative">
            <div class="flex gap-4 mt-4">
              <!-- Kolom Kelurahan (Lebih Lebar) -->
              <div class="w-3/4">
                <label for="kelurahan" class="block text-sm font-medium leading-6 text-[#099AA7]">Kelurahan</label>
                <select name="kelurahan_id" id="kelurahan" required
                  class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                  <option value="">Pilih Kelurahan</option>
                  @forelse ($kelurahan as $kl)
                    <option value="{{ $kl->id }}" data-kode-pos="{{ $kl->kode_pos }}"
                      {{ old('kelurahan_id', $daftar_haji->kelurahan_id) == $kl->id ? 'selected' : '' }}>
                      {{ $kl->kelurahan }}
                    </option>
                  @empty
                    <option value="">Kelurahan masih kosong</option>
                  @endforelse
                </select>
              </div>
          
              <!-- Kolom Kode Pos (Lebih Kecil) -->
              <div class="w-1/4">
                <label for="kode_pos" class="block text-sm font-medium leading-6 text-[#099AA7]">Kode Pos</label>
                <input type="text" id="kode_pos" name="kode_pos" value="{{ old('kode_pos', $daftar_haji->kelurahan->kode_pos ?? '') }}"
                  class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 cursor-not-allowed"
                  readonly>
              </div>
            </div>
          </div>

          <div>
            <label for="message" class="block mb-2 mt-4 text-sm font-medium text-[#099AA7]">
              Catatan
            </label>
            <textarea id="message" rows="4" name="catatan" required
            class="mb-4 block p-2.5 w-full text-sm text-black bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" 
            placeholder="Write your thoughts here...">{{ old('alamat', $daftar_haji->catatan) }}</textarea>
          </div>
        </div>
      
        {{-- Kolom 3 Pasport --}}
        {{-- <div>
            <label for="nama_pasport" class="block text-sm font-medium leading-6 text-[#099AA7]">Nama Pasport</label>
            <input type="text" id="nama_pasport" name="nama_pasport" required placeholder="Nama Pasport"
            class="block w-full rounded-md border-0 p-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 mt-4">
              <!-- Tempat Lahir Dipasport -->
              <div>
                  <label for="lhr_pasport" class="block text-sm font-medium leading-6 text-[#099AA7]">Tempat Lahir di Pasport</label>
                  <select name="lhr_pasport" id="lhr_pasport"
                      class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                      <option value="">Pilih</option>
                      @forelse ($kota as $kt)
                          <option value="{{ $kt->id }}">{{ $kt->kota }}</option>
                      @empty
                          <option value="">Tempat Lahir masih kosong</option>
                      @endforelse
                  </select>
              </div>
          
              <!-- Tanggal Lahir di Pasport -->
              <div>
                <label for="	tgl_lahir_pasport" class="block text-sm font-medium leading-6 text-[#099AA7]">Tanggal Lahir di Pasport</label>
                <input type="date" id="	tgl_lahir_pasport" name="	tgl_lahir_pasport" required
                    class="block w-full rounded-md border border-gray-300 p-2 text-gray-900 shadow-sm focus:ring-2 focus:ring-indigo-600 text-sm leading-6" />
              </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
              <div>
                <label class="block text-sm font-medium leading-6 text-[#099AA7]">No Pasport</label>
                <input type="text" name="no_pasport" required placeholder="No Pasport" 
                class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
              </div>
              <!-- Tempat Pasport Dibuat -->
              <div>
                <label for="kota_pasport" class="block text-sm font-medium leading-6 text-[#099AA7]">Kota Pasport Dibuat</label>
                <select name="kota_pasport" id="kota_pasport"
                    class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                    <option value="">Pilih</option>
                    @forelse ($kota as $kt)
                        <option value="{{ $kt->id }}">{{ $kt->kota }}</option>
                    @empty
                        <option value="">Data Masih Kosong</option>
                    @endforelse
                </select>
              </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
              <!-- Tempat Lahir Dipasport -->
              <div>
                <label for="tgl_terbit_pasport" class="block text-sm font-medium leading-6 text-[#099AA7]">Tanggal Terbit Pasport</label>
                <input type="date" id="tgl_terbit_pasport" name="tgl_terbit_pasport" required
                    class="block w-full rounded-md border border-gray-300 p-2 text-gray-900 shadow-sm focus:ring-2 focus:ring-indigo-600 text-sm leading-6" />
              </div>
          
              <!-- Tanggal Lahir di Pasport -->
              <div>
                <label for="	tgl_kadaluarsa_pasport	" class="block text-sm font-medium leading-6 text-[#099AA7]">Tanggal Kadaluarsa Pasport</label>
                <input type="date" id="	tgl_kadaluarsa_pasport" name="tgl_kadaluarsa_pasport" required
                    class="block w-full rounded-md border border-gray-300 p-2 text-gray-900 shadow-sm focus:ring-2 focus:ring-indigo-600 text-sm leading-6" />
              </div>
            </div>
          </div>
        </div> --}}

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

  // Tempat Lahir di Pasport
  $(document).ready(function () {
      $('#lhr_pasport').select2({
          placeholder: "Pilih", // Placeholder
          allowClear: true, // Bisa menghapus pilihan
          width: '100%' // Sesuaikan dengan Tailwind
      });
  });

  // Tempat Pasport DIbuat
  $(document).ready(function () {
      $('#kota_pasport').select2({
          placeholder: "Pilih", // Placeholder
          allowClear: true, // Bisa menghapus pilihan
          width: '100%' // Sesuaikan dengan Tailwind
      });
  });

  // Provinsi
  $(document).ready(function () {
      $('#provinsi').select2({
          placeholder: "Pilih Provinsi", // Placeholder
          allowClear: true, // Bisa menghapus pilihan
          width: '100%' // Sesuaikan dengan Tailwind
      });
  });

  // Kota
  $(document).ready(function () {
      $('#kota').select2({
          placeholder: "Pilih Kota", // Placeholder
          allowClear: true, // Bisa menghapus pilihan
          width: '100%' // Sesuaikan dengan Tailwind
      });
  });
  // Ketika provinsi dipilih, ambil kota yang sesuai
  $('#provinsi').on('change', function () {
    let provinsiID = $(this).val(); // Ambil ID provinsi yang dipilih
    $('#kota').empty().append('<option value="">Pilih Kota</option>'); // Kosongkan dropdown kota

    if (provinsiID) {
        $.ajax({
            url: `/get-kota/${provinsiID}`, // Panggil route Laravel
            type: "GET",
            dataType: "json",
            success: function (data) {
                $.each(data, function (key, value) {
                    $('#kota').append(`<option value="${value.id}">${value.kota}</option>`);
                });
            }
        });
      }
  });

  // Kecamatan
  $(document).ready(function () {
      $('#kecamatan').select2({
          placeholder: "Pilih Kecamatan", // Placeholder
          allowClear: true, // Bisa menghapus pilihan
          width: '100%' // Sesuaikan dengan Tailwind
      });
  });
  // Ketika kota dipilih, ambil kecamatan yang sesuai
  $('#kota').on('change', function () {
      let kotaID = $(this).val();
      $('#kecamatan').empty().append('<option value="">Pilih Kecamatan</option>');

      if (kotaID) {
          $.ajax({
              url: `/get-kecamatan/${kotaID}`,
              type: "GET",
              dataType: "json",
              success: function (data) {
                  $.each(data, function (key, value) {
                      $('#kecamatan').append(`<option value="${value.id}">${value.kecamatan}</option>`);
                  });
              }
          });
        }
    });

    // Kelurahan
    $(document).ready(function () {
        $('#kelurahan').select2({
            placeholder: "Pilih Kelurahan", // Placeholder
            allowClear: true, // Bisa menghapus pilihan
            width: '100%' // Sesuaikan dengan Tailwind
        });
    });

    // Ketika kecamatan dipilih, ambil kelurahan yang sesuai
    $('#kecamatan').on('change', function () {
        let kecamatanID = $(this).val();
        $('#kelurahan').empty().append('<option value="">Pilih Kelurahan</option>');

        if (kecamatanID) {
            $.ajax({
                url: `/get-kelurahan/${kecamatanID}`,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $.each(data, function (key, value) {
                        $('#kelurahan').append(`<option value="${value.id}">${value.kelurahan}</option>`);
                    });
                }
            });
        }
    });

    // Ketika kelurahan dipilih, ambil kode pos
    $('#kelurahan').on('change', function () {
        let kelurahanID = $(this).val();
        $('#kode_pos').val(''); // Reset kode pos

        if (kelurahanID) {
            $.ajax({
                url: `/get-kodepos/${kelurahanID}`,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $('#kode_pos').val(data.kode_pos);
                }
            });
        }
    });

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