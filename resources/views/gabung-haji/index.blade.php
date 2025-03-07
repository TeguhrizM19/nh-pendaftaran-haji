<x-layout>

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
    <x-page-title>Data Gabung KBIH</x-page-title>
  </div>

  <div class="mt-4 flex flex-wrap md:flex-row justify-between items-center gap-2">
    <!-- Tombol Tambah Gabung Haji (di kiri) -->
    <div class="w-full sm:w-auto">
        <a href="/gabung-haji/create"
            class="w-full sm:min-w-[120px] flex items-center justify-center gap-x-2 rounded-md bg-[#099AA7] px-3 py-3 text-sm font-semibold text-white shadow-sm hover:bg-[#099AA7]/80 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#099AA7]">
            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5" />
            </svg>
            Tambah Gabung Haji
        </a>
    </div>

    <!-- Filter & Search (di kanan) -->
    <div class="w-full md:w-auto flex flex-wrap md:flex-row flex-col gap-2 md:ml-auto">
        <!-- Filter Tahun Keberangkatan -->
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
            <button type="submit" id="search-btn" class="p-2.5 text-sm font-medium text-white bg-[#099AA7] rounded-lg hover:bg-[#099AA7]/80 focus:ring-4 focus:outline-none focus:ring-blue-300">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M18.796 4H5.204a1 1 0 0 0-.753 1.659l5.302 6.058a1 1 0 0 1 .247.659v4.874a.5.5 0 0 0 .2.4l3 2.25a.5.5 0 0 0 .8-.4v-7.124a1 1 0 0 1 .247-.659l5.302-6.059c.566-.646.106-1.658-.753-1.658Z"/>
                </svg>
            </button>
        </div>

        <!-- Search -->
        <form method="GET" action="{{ route('gabung-haji.index') }}" class="w-full md:w-[220px]">
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
          <th scope="col" class="px-6 py-3">No</th>
          <th scope="col" class="px-6 py-3">Keberangkatan</th>
          <th scope="col" class="px-6 py-3">No SPPH</th>
          <th scope="col" class="px-6 py-3">No PORSI</th>
          <th scope="col" class="px-6 py-3">Nama</th>
          <th scope="col" class="px-6 py-3">Jenis Kelamin</th>
          <th scope="col" class="px-6 py-3">No Telpone</th>
          <th scope="col" class="px-6 py-3">Cetak</th>
          <th scope="col" class="px-6 py-3 text-center">Aksi</th>
        </tr>
      </thead>
      <tbody id="table-body">
        @include('gabung-haji.partial-table', ['gabung_haji' => $gabung_haji])   
      </tbody>
    </table>
    
    {{-- Cek apakah data dipaginate --}}
    <div id="pagination-container" class="mt-4" style="{{ request()->hasAny(['search', 'no_porsi_haji_1', 'no_porsi_haji_2']) ? 'display: none;' : '' }}">
      <div id="pagination-links" class="mt-4">
        {{ $gabung_haji->links('pagination::tailwind') }}
      </div>
    </div>
  </div>
  
  <script>
    // Sweet Alert Konfirmasi Delete
    document.addEventListener("DOMContentLoaded", function () {
      document.querySelectorAll(".deleteForm").forEach(function (form) {
        form.addEventListener("submit", function (event) {
          event.preventDefault(); // Mencegah form langsung submit
          
          Swal.fire({
            title: "Apakah Anda yakin?",
            text: "Data akan dihapus secara permanen!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Batal"
          }).then((result) => {
            if (result.isConfirmed) {
              form.submit(); // Submit form jika dikonfirmasi
            }
          });
        });
      });
    });

    // Search
    document.addEventListener("DOMContentLoaded", function () {
      const searchInput = document.getElementById("search-input");
      const tableBody = document.getElementById("table-body");
      const paginationContainer = document.getElementById("pagination-container");

      searchInput.addEventListener("input", function () {
        let searchTerm = searchInput.value.trim();
        let url = searchTerm ? `/gabung-haji?search=${searchTerm}` : "/gabung-haji";

        fetch(url, {
          headers: {
            "X-Requested-With": "XMLHttpRequest"
          }
        })
        .then(response => response.json())
        .then(data => {
          if (data.html) {
            tableBody.innerHTML = data.html.trim();

            // Sembunyikan pagination jika pencarian dilakukan
            if (data.paginate) {
              paginationContainer.style.display = "block";
            } else {
              paginationContainer.style.display = "none";
            }
          }
        })
        .catch(error => console.error("Error fetching data:", error));
      });
    });

    // Filter rentang no porsi haji
    document.addEventListener("DOMContentLoaded", function () {
      const searchButton = document.getElementById("search-btn");
      const tableBody = document.getElementById("table-body");
      const paginationContainer = document.getElementById("pagination-container");
      const noPorsi1 = document.getElementById("no_porsi_haji_1");
      const noPorsi2 = document.getElementById("no_porsi_haji_2");

      // Fungsi untuk me-reset tabel ke kondisi awal
      function resetTable() {
        fetch(`/gabung-haji`, {
          headers: {
            "X-Requested-With": "XMLHttpRequest"
          }
        })
        .then(response => response.json())
        .then(data => {
          if (tableBody) {
            tableBody.innerHTML = data.html;
          }

          // Tampilkan pagination kembali
          if (paginationContainer) {
            paginationContainer.style.display = data.paginate ? "block" : "none";
          }
        })
        .catch(error => console.error("Error fetching data:", error));
      }

      // Event listener untuk tombol pencarian
      searchButton.addEventListener("click", function (event) {
        event.preventDefault();
        console.log("Tombol pencarian ditekan!");

        let noPorsi1Value = noPorsi1.value.trim();
        let noPorsi2Value = noPorsi2.value.trim();

        console.log("No Porsi Haji 1:", noPorsi1Value);
        console.log("No Porsi Haji 2:", noPorsi2Value);

        fetch(`/gabung-haji?no_porsi_haji_1=${noPorsi1Value}&no_porsi_haji_2=${noPorsi2Value}`, {
          headers: {
            "X-Requested-With": "XMLHttpRequest"
          }
        })
          .then(response => response.json())
          .then(data => {
            if (tableBody) {
              tableBody.innerHTML = data.html;
            }

            // Sembunyikan pagination jika filter aktif
            if (paginationContainer) {
              paginationContainer.style.display = data.paginate ? "block" : "none";
            }
          })
          .catch(error => console.error("Error fetching data:", error));
        });

      // Event listener saat tombol "x" ditekan pada input search
      [noPorsi1, noPorsi2].forEach(input => {
        input.addEventListener("input", function () {
          if (!noPorsi1.value.trim() && !noPorsi2.value.trim()) {
            resetTable();
          }
        });
      });
    });

    // Filter Tahun Keberangkatan
    $(document).ready(function () {
      $('#keberangkatan').select2({
        placeholder: "Pilih Keberangkatan",
        allowClear: true,
        width: '100%',
        dropdownCssClass: 'custom-select2'
      });

      $('#keberangkatan').on('change', function () {
        let tahunKeberangkatan = $(this).val();
        $.ajax({
          url: "{{ route('gabung-haji.index') }}",
          type: "GET",
          data: {
            keberangkatan: tahunKeberangkatan
          },
          success: function (response) {
            $('#table-body').html(response.html);

            // Sembunyikan pagination jika filter aktif
            if (response.paginate) {
              $('#pagination-container').show();
            } else {
              $('#pagination-container').hide();
            }
          }
        });
      });
    });

  </script>
  
</x-layout>