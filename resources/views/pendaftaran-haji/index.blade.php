<x-layout>

  {{-- Pesan Data Berhasil Disimpan --}}
  @if(session('success'))
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      Swal.fire({
        title: "Berhasil!",
        text: "{!! session('success') !!}",
        icon: "success",
        confirmButtonText: "OK",
        confirmButtonColor: "#099AA7"
      });
    });
  </script>
  @endif

  <div>
    <x-page-title>Data Pendaftaran Haji</x-page-title>
  </div>

  <div class="mt-4 flex flex-wrap md:flex-row justify-between items-center gap-2">
    <!-- Tombol Tambah Gabung Haji (di kiri) -->
    <div class="w-full sm:w-auto">
      <a href="/pendaftaran-haji/create"
        class="w-full sm:min-w-[120px] flex items-center justify-center gap-x-2 rounded-md bg-[#099AA7] px-3 py-3 text-sm font-semibold text-white shadow-sm hover:bg-[#099AA7]/80 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#099AA7]">
        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5" />
        </svg>
        Tambah Pendaftaran
      </a>
    </div>

    <div class="w-full md:w-auto flex flex-wrap md:flex-row flex-col gap-2 md:ml-auto">
      <div class="grid grid-cols-1 gap-2">
        <!-- Filter Pelunasan Haji -->
        <form>
          <div class="w-full md:w-auto flex items-center">
            <select name="pelunasan" id="pelunasan_haji" class="w-full md:w-auto text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-3 focus:ring-blue-300 focus:border-blue-500">
              <option value="">Pelunasan Haji</option>
              <option value="Lunas">Lunas</option>
              <option value="Belum Lunas">Belum Lunas</option>
            </select>
          </div>
        </form>

        <!-- Filter Pelunasan Manasik -->
        <form>
          <div class="w-full md:w-auto flex items-center">
            <select name="pelunasan_manasik" id="pelunasan_manasik" class="w-full md:w-auto text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-3 focus:ring-blue-300 focus:border-blue-500">
              <option value="">Pelunasan Manasik</option>
              <option value="Lunas">Lunas</option>
              <option value="Belum Lunas">Belum Lunas</option>
            </select>
          </div>
        </form>
      </div>

      <!-- Filter No Porsi Haji -->
      <div class="grid grid-cols-1 gap-2">
        <div class="w-full">
          <input type="search" id="no_porsi_haji_1" name="no_porsi_haji_1"
            class="w-full p-3 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
            placeholder="No Porsi Haji 1...">
        </div>
        
        <div class="w-full">
          <input type="search" id="no_porsi_haji_2" name="no_porsi_haji_2"
            class="w-full p-3 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
            placeholder="No Porsi Haji 2...">
        </div>
      </div>
      
      <div class="grid grid-cols-1 gap-2">
        <!-- Search -->
        <form method="GET" action="{{ route('pendaftaran-haji.index') }}" class="w-full md:w-[220px]">
          <label for="default-search" class="sr-only">Search</label>
          <div class="relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
              <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
              </svg>
            </div>
            <input type="search" id="search-input" name="search" value="{{ request('search') }}" class="block w-full p-3 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Cari Semua Data...">
          </div>
        </form>

        <div class="w-full md:w-auto">
          <select name="keberangkatan" id="keberangkatan" class="w-full md:w-auto text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-3 focus:ring-blue-300 focus:border-blue-500">
            <option value="">Pilih Tahun</option>
            @foreach ($keberangkatan as $berangkat)
            <option value="{{ $berangkat->id }}">{{ $berangkat->keberangkatan }}</option>
            @endforeach
          </select>
        </div>
      </div>

    </div>
  </div>

  {{-- <div class="mt-4 flex flex-wrap items-center justify-between gap-4 md:flex-nowrap">
    <!-- Tombol Tambah Pendaftaran -->
    <div class="w-full md:w-auto flex justify-center">
      <a href="/pendaftaran-haji/create"
        class="min-w-max flex items-center justify-center gap-x-2 rounded-md bg-[#099AA7] px-4 py-3 text-sm font-semibold text-white shadow-sm hover:bg-[#099AA7]/80 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#099AA7] whitespace-nowrap">
        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/>
        </svg>
        Tambah Pendaftaran
      </a>
    </div>    
  
    <!-- Input Pencarian -->
    <div class="w-full flex flex-wrap items-center justify-center gap-2 md:justify-end">
      <!-- Filter No Porsi Haji -->
      <div class="flex flex-wrap items-center gap-2">
        <input type="search" id="no_porsi_haji_1" name="no_porsi_haji_1"
          class="w-full md:w-auto p-3 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
          placeholder="No Porsi Haji..." />
  
        <input type="search" id="no_porsi_haji_2" name="no_porsi_haji_2"
          class="w-full md:w-auto p-3 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
          placeholder="No Porsi Haji..." />
  
        <button type="submit" id="search-btn"
          class="p-2.5 text-sm font-medium text-white bg-[#099AA7] rounded-lg hover:bg-[#099AA7]/80 focus:ring-4 focus:outline-none focus:ring-blue-300">
          <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
              d="M18.796 4H5.204a1 1 0 0 0-.753 1.659l5.302 6.058a1 1 0 0 1 .247.659v4.874a.5.5 0 0 0 .2.4l3 2.25a.5.5 0 0 0 .8-.4v-7.124a1 1 0 0 1 .247-.659l5.302-6.059c.566-.646.106-1.658-.753-1.658Z" />
          </svg>
        </button>
      </div>
  
      <!-- Search -->
      <form method="GET" action="{{ route('pendaftaran-haji.index') }}" class="w-full md:w-[220px]">
        <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
        <div class="relative">
          <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
              fill="none" viewBox="0 0 20 20">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
            </svg>
          </div>
          <input type="search" id="search-input" name="search" value="{{ request('search') }}"
            class="block w-full p-3 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
            placeholder="Cari data..." />
        </div>
      </form>
    </div>
  </div>   --}}

  <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-5">
    <table id="myTable" class="w-full text-sm text-left rtl:text-right text-black bg-white">
      <thead class="text-xs text-white uppercase bg-[#099AA7]">
        <tr>
          <th scope="col" class="px-6 py-3">No</th>
          <th scope="col" class="px-6 py-3">Keberangkatan</th>
          <th scope="col" class="px-6 py-3">No Porsi Haji</th>
          <th scope="col" class="px-4 py-3 w-[150px] sm:w-[180px] md:w-[200px] lg:w-[250px] break-words sm:break-normal overflow-hidden text-ellipsis">
            Nama
          </th>
          <th scope="col" class="px-6 py-3">Paket Pendaftaran</th>
          <th scope="col" class="px-6 py-3">Jenis Kelamin</th>
          <th scope="col" class="px-6 py-3">No Telpone</th>
          <th scope="col" class="px-6 py-3">Pelunasan Haji</th>
          <th scope="col" class="px-6 py-3">Pelunasan Manasik</th>
          <th scope="col" class="px-6 py-3">Cetak</th>
          <th scope="col" class="px-6 py-3 text-center">Aksi</th>
        </tr>
      </thead>
      <tbody id="table-body">
        @include('pendaftaran-haji.partial-table') 
      </tbody>
    </table>
    {{-- Cek apakah data dipaginate --}}
    <div id="pagination-container" class="mt-4">
      <div id="pagination-links">
        {{ $daftar_haji->links('pagination::tailwind') }}
      </div>
    </div>
  </div>

  {{-- Style select2 agar lebih panjang --}}
  <style>
    .select2-container .select2-selection--single {
    height: 45px !important; /* Sesuaikan dengan tinggi input search */
    display: flex;
    align-items: center;
    padding: 8px; /* Sesuaikan dengan padding input */
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 45px !important; /* Samakan dengan tinggi input */
    }
  </style>

<script>
  // Semua Filter
  $(document).ready(function () {
    // Inisialisasi Select2
    $('#keberangkatan').select2({
      allowClear: true,
      placeholder: "Pilih Keberangkatan",
      width: '100%'
    });

    $('#pelunasan_haji').select2({
      allowClear: true,
      placeholder: "Pilih Pelunasan Haji",
      width: '100%'
    });

    $('#pelunasan_manasik').select2({
      allowClear: true,
      placeholder: "Pilih Pelunasan Manasik",
      width: '100%'
    });

    // Fungsi untuk mengambil data yang difilter
    function fetchFilteredData(page = 1) {
      let pelunasan = $('#pelunasan_haji').val();
      let pelunasanManasik = $('#pelunasan_manasik').val();
      let keberangkatan = $('#keberangkatan').val();
      let noPorsi1 = $('#no_porsi_haji_1').val().trim();
      let noPorsi2 = $('#no_porsi_haji_2').val().trim();
      let search = $('#search-input').val().trim();

      let params = { page: page };

      if (pelunasan === "Lunas") {
        params.pelunasan = "Lunas";
      } else if (pelunasan) {
        params.pelunasan = "Belum Lunas";
      }

      if (pelunasanManasik === "Lunas") {
        params.pelunasan_manasik = "Lunas";
      } else if (pelunasanManasik) {
        params.pelunasan_manasik = "Belum Lunas";
      }

      if (keberangkatan) params.keberangkatan = keberangkatan;
      if (noPorsi1) params.no_porsi_haji_1 = noPorsi1;
      if (noPorsi2) params.no_porsi_haji_2 = noPorsi2;
      if (search) params.search = search;

      $.ajax({
        url: "{{ route('pendaftaran-haji.index') }}",
        type: "GET",
        data: params,
        beforeSend: function () {
          $('#table-body').html('<p class="text-center">Loading...</p>');
        },
        success: function (response) {
          $('#table-body').html(response.html);
          if (response.paginate) {
            $('#pagination-links').html(response.pagination);
          } else {
            $('#pagination-links').empty();
          }
        },
        error: function () {
          alert('Gagal mengambil data.');
        }
      });
    }

    // Event listener untuk clear Select2
    $('#keberangkatan, #pelunasan_haji, #pelunasan_manasik').on('select2:clear', function () {
      $(this).val(null).trigger('change');
      fetchFilteredData();
    });

    // Event listener untuk perubahan filter
    $('#keberangkatan, #pelunasan_haji, #pelunasan_manasik, #no_porsi_haji_1, #no_porsi_haji_2, #search-input').on('change input', function () {
      fetchFilteredData();
    });

    // Event listener untuk tombol search
    $('#search-btn').on('click', function (event) {
      event.preventDefault();
      fetchFilteredData();
    });

    // Event listener untuk pencarian otomatis jika input kosong
    $('#search-input').on('keyup input', function () {
      if ($(this).val().trim() === '') {
        fetchFilteredData();
      }
    });

    // Event listener untuk pagination
    $(document).on('click', '#pagination-links a', function (e) {
      e.preventDefault();
      let url = $(this).attr('href');
      let page = url.split('page=')[1];
      fetchFilteredData(page);
    });
  });

</script>
</x-layout>