<x-layout>

  {{-- Pesan Data Berhasil Disimpan --}}
  @if(session('success'))
    <style>
      .swal-confirm-btn {
        background-color: #099AA7 !important;
        color: #fff !important;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
      }
    </style>

    <script>
      document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
          title: "Berhasil!",
          text: "Data berhasil disimpan!",
          icon: "success",
          confirmButtonText: "OK",
          customClass: {
            confirmButton: 'swal-confirm-btn'
          },
          buttonsStyling: false // penting: matikan styling default SweetAlert
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
            <option value="">Pilih Keberangkatan</option>
            @foreach ($keberangkatan as $berangkat)
              <option value="{{ $berangkat->id }}">{{ $berangkat->keberangkatan }}</option>
            @endforeach
          </select>
        </div>
      </div>
    </div>
  </div>

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
          <th scope="col" class="px-6 py-3">Pelunasan Biaya</th>
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
          $('#table-body').html(`
              <tr>
                <td colspan="11" class="py-10">
                  <div class="flex justify-center items-center h-32">
                    <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-[#099AA7]" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                      <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                    </svg>
                  </div>
                </td>
              </tr>
            `);
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