<x-layout>
  <div>
    <x-page-title>Tambah Peserta Keberangkatan</x-page-title>
  </div>

  <style>
    .select2-container .select2-selection--single {
    height: 45px !important; /* Atur tinggi */
    display: flex;
    align-items: center; /* Pusatkan teks */
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
      line-height: 45px !important; /* Sesuaikan dengan tinggi */
    }
  </style>

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

  <div class="mt-4 flex flex-wrap md:flex-row justify-between items-center gap-2">
    <div class="w-full sm:w-auto flex items-center gap-2">
      @if (Auth::user()->level == 'super_admin')
      <button data-modal-target="modal-keberangkatan" data-modal-toggle="modal-keberangkatan" 
        class="w-10 flex items-center justify-center gap-x-2 rounded-md bg-[#099AA7] py-1 text-sm font-semibold text-white shadow-sm hover:bg-[#099AA7]/80 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#099AA7]">
        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5" />
        </svg>
      </button>
      @endif
      <form id="form-simpan" class="w-full md:w-auto flex items-center gap-2">
        <select name="keberangkatan_id" id="tahun-keberangkatan" 
          class="w-full md:w-auto text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-3 focus:ring-blue-300 focus:border-blue-500">
          <option value="">Tahun</option>
          @foreach ($keberangkatan as $berangkat)
          <option value="{{ $berangkat->id }}">{{ $berangkat->keberangkatan }}</option>
          @endforeach
        </select>
        <button type="submit" class="px-3 py-1.5 rounded-md bg-[#099AA7] text-sm font-semibold text-white shadow-sm hover:bg-[#099AA7]/80">Simpan</button>
        <button type="submit" form="form-hapus" class="px-3 py-1.5 rounded-md bg-red-600 text-sm font-semibold text-white shadow-sm hover:bg-red-500">Hapus</button>
      </form>
      <form id="form-hapus"></form>
    </div>

    <div class="w-full md:w-auto flex flex-wrap md:flex-row flex-col gap-2 md:ml-auto">
      <!-- Filter Pelunasan Haji -->
      <form id="filterForm">
        <div class="w-full md:w-auto flex items-center">
          <select name="pelunasan" id="pelunasan_haji" class="w-full md:w-auto text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-3 focus:ring-blue-300 focus:border-blue-500">
            <option value="">Pelunasan Haji</option>
            <option value="Lunas">Lunas</option>
            <option value="Belum Lunas">Belum Lunas</option>
          </select>
        </div>
      </form>  

      <div class="w-full md:w-auto">
        <select name="keberangkatan" id="keberangkatan" required class="w-full md:w-auto text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-3 focus:ring-blue-300 focus:border-blue-500">
          <option value="">Pilih Tahun</option>
          @foreach ($keberangkatan as $berangkat)
          <option value="{{ $berangkat->id }}">{{ $berangkat->keberangkatan }}</option>
          @endforeach
        </select>
      </div>

      <!-- Filter No Porsi Haji -->
      <div class="flex flex-wrap gap-2 w-full md:w-auto">
        <input type="search" id="no_porsi_haji_1" name="no_porsi_haji_1" class="w-full md:w-[150px] p-3 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="No Porsi Haji...">
        <input type="search" id="no_porsi_haji_2" name="no_porsi_haji_2" class="w-full md:w-[150px] p-3 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="No Porsi Haji...">
      </div>

      <!-- Search -->
      <form method="GET" action="{{ route('keberangkatan.index') }}" class="w-full md:w-[220px]">
        <label for="default-search" class="sr-only">Search</label>
        <div class="relative">
          <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
            </svg>
          </div>
          <input type="search" id="search-input" name="search" value="{{ request('search') }}" class="block w-full p-3 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Cari data...">
        </div>
      </form>
    </div>
  </div>

  <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-5">
    <table id="myTable" class="w-full text-sm text-left rtl:text-right text-black bg-white">
      <thead class="text-xs text-white uppercase bg-[#099AA7]">
        <tr>
          <th scope="col" class="px-6 py-3">Pilih</th>
          <th scope="col" class="px-6 py-3">No</th>
          <th scope="col" class="px-6 py-3">Keberangkatan</th>
          <th scope="col" class="px-6 py-3">No SPPH</th>
          <th scope="col" class="px-6 py-3">No PORSI</th>
          <th scope="col" class="px-4 py-3 w-[150px] break-all whitespace-normal">Nama</th>
          <th scope="col" class="px-6 py-3">Jenis Kelamin</th>
          <th scope="col" class="px-6 py-3">No Telpone</th>
          <th scope="col" class="px-2 py-3">Pelunasan Haji</th>
          <th scope="col" class="px-2 py-3 w-36">Pelunasan Manasik</th>
        </tr>
      </thead>
      <tbody id="table-body">
        @include('keberangkatan.partial-table-peserta', ['gabung_haji' => $gabung_haji])   
      </tbody>
    </table>
    
    <!-- Paginate -->
    <div id="pagination-container" class="mt-4">
      <div id="pagination-links">
        {{ $gabung_haji->links('pagination::tailwind') }}
      </div>
    </div>
  </div>

  <!-- Modal Tambah Tahun Keberangkatan -->
  <div id="modal-keberangkatan" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
      <!-- Modal content -->
      <div class="relative bg-white rounded-lg shadow-sm">
        <!-- Modal header -->
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
          <h3 class="text-xl font-semibold text-gray-900">
            Tahun Keberangkatan
          </h3>
          <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="modal-keberangkatan">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
            <span class="sr-only">Close modal</span>
          </button>
        </div>
        <!-- Modal body -->
        <div class="p-4 md:p-5">
          <form action="/keberangkatan" method="POST" class="space-y-4">
            @csrf
            <div>
              <input type="text" name="keberangkatan" id="keberangkatan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Masukkan Tahun Keberangkatan" required />
            </div>
            <button type="submit" class="mt-4 w-full text-white bg-[#099AA7] hover:bg-[#099AA7]/80 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Menambahkan peserta baru dg memilih tahun keberangkatan dulu
    $(document).ready(function () {
      $('#tahun-keberangkatan').select2({
        placeholder: "Pilih Keberangkatan",
        allowClear: true,
        width: '100%',
        dropdownCssClass: 'custom-select2'
      });
    });

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

      // Fungsi untuk mengambil data yang difilter
      function fetchFilteredData(page = 1) {
        let pelunasan = $('#pelunasan_haji').val();
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

        if (keberangkatan) params.keberangkatan = keberangkatan;
        if (noPorsi1) params.no_porsi_haji_1 = noPorsi1;
        if (noPorsi2) params.no_porsi_haji_2 = noPorsi2;
        if (search) params.search = search;

        $.ajax({
          url: "{{ route('keberangkatan.index') }}",
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
      $('#keberangkatan, #pelunasan_haji').on('select2:clear', function () {
        $(this).val(null).trigger('change');
        fetchFilteredData();
      });

      // Event listener untuk perubahan filter
      $('#keberangkatan, #pelunasan_haji, #no_porsi_haji_1, #no_porsi_haji_2, #search-input').on('change input', function () {
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