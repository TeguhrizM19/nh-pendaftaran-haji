<x-layout>
  <div>
    <x-page-title>Tambah Data Customer</x-page-title>
  </div>

  <div class="rounded-lg shadow-lg p-4">
    <form action="/customer" method="POST">
      @csrf
      <div class="w-full grid grid-cols-1 md:grid-cols-3 gap-7">
        {{-- Kolom 1 --}}
        <div>
          <label class="block text-sm font-medium leading-6 text-[#099AA7]">Nama</label>
          <input type="text" name="nama" required placeholder="Nama" 
          class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900 shadow-md ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6 uppercase" />

          <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
            <div>
              <label class="block text-sm font-medium leading-6 text-[#099AA7]">No HP 1</label>
              <input type="text" name="no_hp_1" required placeholder="No HP 1" 
              class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900 shadow-md ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>
            <div>
              <label class="block text-sm font-medium leading-6 text-[#099AA7]">No HP 2</label>
              <input type="text" name="no_hp_2" required placeholder="No HP 2"
              class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900 shadow-md ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <!-- Tempat Lahir -->
            <div class="shadow-md">
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
              class="block w-full rounded-md border border-gray-300 p-2 text-gray-900 shadow-md focus:ring-2 focus:ring-indigo-600 text-sm leading-6" />
            </div>
          </div>
        
          <!-- Jenis ID, No Identitas, dan Warga -->
          <div class="grid grid-cols-[1fr_2fr_1fr] gap-4">
            <!-- Dropdown Jenis ID -->
            <div>
              <div>
                <label for="jenis_id" class="block text-sm font-medium leading-6 text-[#099AA7]">Jenis ID</label>
                <select id="jenis_id" name="jenis_id" required
                  class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg shadow-md text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
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
              <input type="text" id="no_id" name="no_id" required placeholder="Masukkan No Identitas"
              class="block w-full rounded-md border-0 p-2 text-gray-900 shadow-md ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>

            <!-- Dropdown Warga -->
            <div>
              <label for="warga" class="block text-sm font-medium leading-6 text-[#099AA7]">Warga</label>
              <select id="warga" name="warga" required
                class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg shadow-md text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                <option value="">Pilih</option>
                <option value="WNI">WNI</option>
                <option value="WNA">WNA</option>
              </select>
            </div>            
          </div>
        
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <!-- Dropdown Jenis Kelamin -->
            <div>
              <label class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">Jenis Kelamin</label>
              <div class="flex items-center mb-2">
                <input id="laki-laki" type="radio" value="Laki-Laki" name="jenis_kelamin" required class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                <label for="laki-laki" class="ms-2 text-sm font-medium text-gray-900">Laki-Laki</label>
              </div>
              <div class="flex items-center">
                <input id="perempuan" type="radio" value="Perempuan" name="jenis_kelamin" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                <label for="perempuan" class="ms-2 text-sm font-medium text-gray-900">Perempuan</label>
              </div>
            </div>
        
            <!-- Dropdown Status -->
            <div>
              <label class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">Status</label>
              <div class="flex items-center mb-2">
                <input id="menikah" type="radio" value="Menikah" name="status_nikah" required class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                <label for="menikah" class="ms-2 text-sm font-medium text-gray-900">Menikah</label>
              </div>
              <div class="flex items-center mb-2">
                <input id="belum-menikah" type="radio" value="Belum Menikah" name="status_nikah" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                <label for="belum-menikah" class="ms-2 text-sm font-medium text-gray-900">Belum Menikah</label>
              </div>
              <div class="flex items-center">
                <input id="janda-duda" type="radio" value="Janda/Duda" name="status_nikah" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                <label for="janda-duda" class="ms-2 text-sm font-medium text-gray-900">Janda/Duda</label>
              </div>
            </div>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-4">
            <div>
              <label class="block text-sm font-medium leading-6 text-[#099AA7]">Pekerjaan</label>
              <input type="text" name="pekerjaan" required placeholder="Pekerjaan" 
              class="mb-3 block w-full rounded-md border-0 p-2 text-gray-900 shadow-md ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-sm leading-6" />
            </div>
            <div>
              <label for="pendidikan" class="block text-sm font-medium leading-6 text-[#099AA7]">Pendidikan</label>
              <select id="pendidikan" name="pendidikan" required
                class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg shadow-md text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
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
        </div>

        {{-- Kolom 2 Alamat KTP --}}
        <div class="relative">
          <div>
            <label for="alamat_ktp" class="block mb-2 text-sm font-medium text-[#099AA7]">
              Alamat Sesuai KTP
            </label>
            <textarea id="alamat_ktp" rows="2" name="alamat_ktp" required
            class="block p-2.5 w-full text-sm text-black bg-white shadow-md rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" 
            placeholder="Write your thoughts here..."></textarea>
          </div>

          <div class="shadow-md">
            <label for="provinsi" class="mt-4 block text-sm font-medium leading-6 text-[#099AA7]">
              Provinsi
            </label>
            <select name="provinsi_ktp_id" id="provinsi_ktp" required
            class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
              <option value="">Pilih Provinsi</option>
              @forelse ($provinsi as $prov)
                <option value="{{ $prov->id }}">{{ $prov->provinsi }}</option>
              @empty
                <option value="">Provinsi masih kosong</option>
              @endforelse
            </select>
          </div>

          <div class="shadow-md">
            <label for="kota_ktp" class="mt-4 block text-sm font-medium leading-6 text-[#099AA7]">Kota</label>
            <select name="kota_ktp_id" id="kota_ktp" required
            class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
              <option value="">Pilih Kota</option>
            </select>
          </div>

          <div class="shadow-md">
            <label for="kecamatan_ktp" class="mt-4 block text-sm font-medium leading-6 text-[#099AA7]">Kecamatan</label>
            <select name="kecamatan_ktp_id" id="kecamatan_ktp" required
            class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
              <option value="">Pilih Kecamatan</option>
            </select>
          </div>

          <div class="relative">
            <div class="flex gap-4 mt-4">
              <!-- Kolom Kelurahan (Lebih Lebar) -->
              <div class="w-3/4 shadow-md">
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
                  class="bg-gray-100 border border-gray-300 text-gray-900 shadow-md text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 cursor-not-allowed"
                  disabled>
              </div>
            </div>            
          </div>
        </div>
        
        {{-- Kolom 3 Alamat Domisili --}}
        <div class="relative">
          <div>
            <label for="alamat_domisili" class="block mb-2 text-sm font-medium text-[#099AA7]">
              Alamat Domisili
            </label>
            <textarea id="alamat_domisili" rows="2" name="alamat_domisili" required
            class="block p-2.5 w-full text-sm text-black bg-white shadow-md rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" 
            placeholder="Write your thoughts here..."></textarea>
          </div>

          <div class="shadow-md">
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
          </div>

          <div class="shadow-md">
            <label for="kota_domisili" class="mt-4 block text-sm font-medium leading-6 text-[#099AA7]">Kota</label>
            <select name="kota_domisili_id" id="kota_domisili" required
            class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
              <option value="">Pilih Kota</option>
            </select>
          </div>

          <div class="shadow-md">
            <label for="kecamatan_domisili" class="mt-4 block text-sm font-medium leading-6 text-[#099AA7]">Kecamatan</label>
            <select name="kecamatan_domisili_id" id="kecamatan_domisili" required
            class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
              <option value="">Pilih Kecamatan</option>
            </select>
          </div>

          <div class="relative">
            <div class="flex gap-4 mt-4">
              <!-- Kolom Kelurahan (Lebih Lebar) -->
              <div class="w-3/4 shadow-md">
                <label for="kelurahan_domisili" class="block text-sm font-medium leading-6 text-[#099AA7]">Kelurahan</label>
                <select name="kelurahan_domisili_id" id="kelurahan_domisili" required
                  class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                  <option value="">Pilih Kelurahan</option>
                </select>
              </div>

              <!-- Kolom Kode Pos (Lebih Kecil) -->
              <div class="w-1/4">
                <label for="kode_pos_domisili" class="block text-sm font-medium leading-6 text-[#099AA7]">Kode Pos</label>
                <input type="text" id="kode_pos_domisili"
                  class="bg-gray-100 border border-gray-300 text-gray-900 shadow-md text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 cursor-not-allowed"
                  disabled>
              </div>
            </div>
          </div>
        </div>
      </div>

        {{-- Form paspord belum dipakai --}}
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

      <!-- Container tombol dipisah dari form grid -->
      <div class="w-full flex justify-center mt-6">
        <a href="/customer" 
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
  // Tempat Lahir
  $(document).ready(function () {
    $('#tempat_lahir').select2({
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