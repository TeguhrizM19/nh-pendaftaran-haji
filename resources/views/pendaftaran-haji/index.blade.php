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

  <div class="mt-4 flex justify-between items-center">
    <a href="/pendaftaran-haji/create"
      class="min-w-[120px] text-center rounded-md bg-[#099AA7] px-3 py-3 text-sm font-semibold text-white shadow-sm hover:bg-[#099AA7]/80 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#099AA7]">
      Tambah Pendaftaran
    </a>

    <div class="flex gap-4">
      {{-- Filter No Porsi Haji --}}
      <div class="flex gap-1">
        <div class="relative">
          <input type="search" id="no_porsi_haji_1" name="no_porsi_haji_1" class="block w-full p-3 ps-5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="No Porsi Haji..." />
        </div>
        {{-- <div class="relative">
          <input type="search" id="no_porsi_haji_2" name="no_porsi_haji_2" class="block w-full p-3 ps-5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="No Porsi Haji..." />
        </div>
        <button type="submit" class="p-2.5 text-sm font-medium text-white bg-[#099AA7] rounded-lg hover:bg-[#099AA7]/80 focus:ring-4 focus:outline-none focus:ring-blue-300">
          <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M18.796 4H5.204a1 1 0 0 0-.753 1.659l5.302 6.058a1 1 0 0 1 .247.659v4.874a.5.5 0 0 0 .2.4l3 2.25a.5.5 0 0 0 .8-.4v-7.124a1 1 0 0 1 .247-.659l5.302-6.059c.566-.646.106-1.658-.753-1.658Z"/>
          </svg>          
        </button>    --}}
      </div>
      {{-- Search --}}
      <form method="GET" action="{{ route('pendaftaran-haji.index') }}" class="w-[300px]">
        <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
        <div class="relative">
          <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
            </svg>
          </div>
          <input type="search" id="search-input" name="search" value="{{ request('search') }}" class="block w-full p-3 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Cari data..." />
        </div>
      </form>  
    </div>
  </div>

  <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-5">
    <table id="myTable" class="w-full text-sm text-left rtl:text-right text-black bg-white">
      <thead class="text-xs text-white uppercase bg-[#099AA7]">
        <tr>
          <th scope="col" class="px-6 py-3">No</th>
          <th scope="col" class="px-6 py-3">No Porsi Haji</th>
          <th scope="col" class="px-6 py-3">Nama</th>
          <th scope="col" class="px-6 py-3">Paket Pendaftaran</th>
          <th scope="col" class="px-6 py-3">Jenis Kelamin</th>
          <th scope="col" class="px-6 py-3">No Telpone</th>
          <th scope="col" class="px-6 py-3">Cetak</th>
          <th scope="col" class="px-6 py-3 text-center">Aksi</th>
        </tr>
      </thead>
      <tbody id="table-body">
        @include('pendaftaran-haji.partial-table') 
      </tbody>
    </table>
    @if(!request('search'))
      {{ $daftar_haji->links('pagination::tailwind') }}
    @endif
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

    searchInput.addEventListener("input", function () {
        let searchTerm = searchInput.value.trim();

        let url = searchTerm ? `/pendaftaran-haji?search=${searchTerm}` : "/pendaftaran-haji";

        fetch(url, {
            headers: {
                "X-Requested-With": "XMLHttpRequest"
            }
        })
            .then(response => response.text())
            .then(data => {
                tableBody.innerHTML = data;
            })
            .catch(error => console.error("Error fetching data:", error));
    });
});

  // // No Porsi Haji 1
  // $(document).ready(function () {
  //   $('#no_porsi_haji_1').select2({
  //     placeholder: "Cari No. Porsi Haji",
  //     allowClear: true,
  //     width: '70%',
  //     hight: '100%',
  //     ajax: {
  //       url: '/get-no-porsi', // URL ke controller
  //       dataType: 'json',
  //       delay: 250, // Hindari spam request
  //       data: function (params) {
  //         return {
  //           q: params.term // Kirim query pencarian
  //         };
  //       },
  //       processResults: function (data) {
  //         return {
  //           results: $.map(data, function (item) {
  //             return {
  //               id: item.id, // ID tetap
  //               text: item.no_porsi_haji // Tampilkan No. Porsi Haji
  //             };
  //           })
  //         };
  //       }
  //     }
  //   });

  //   // Pastikan tinggi Select2 sama dengan input search
  //   $('.select2-selection').css('height', '45px');
  // });

  // // No Porsi Haji 2
  // $(document).ready(function () {
  //   $('#no_porsi_haji_2').select2({
  //     placeholder: "Cari No. Porsi Haji",
  //     allowClear: true,
  //     width: '70%',
  //     hight: '100%',
  //     ajax: {
  //       url: '/get-no-porsi', // URL ke controller
  //       dataType: 'json',
  //       delay: 250, // Hindari spam request
  //       data: function (params) {
  //         return {
  //           q: params.term // Kirim query pencarian
  //         };
  //       },
  //       processResults: function (data) {
  //         return {
  //           results: $.map(data, function (item) {
  //             return {
  //               id: item.id, // ID tetap
  //               text: item.no_porsi_haji // Tampilkan No. Porsi Haji
  //             };
  //           })
  //         };
  //       }
  //     }
  //   });

  //   // Pastikan tinggi Select2 sama dengan input search
  //   $('.select2-selection').css('height', '45px');
  // });

  // Filter No Porsi Haji
  // $(document).ready(function () {
  //   function initSelect2(id) {
  //       $('#' + id).select2({
  //           placeholder: "Cari No. Porsi Haji",
  //           allowClear: true,
  //           width: '70%',
  //           ajax: {
  //               url: '/get-no-porsi', // Endpoint untuk mendapatkan data
  //               dataType: 'json',
  //               delay: 250,
  //               data: function (params) {
  //                   return { q: params.term };
  //               },
  //               processResults: function (data) {
  //                   return {
  //                       results: $.map(data, function (item) {
  //                           return {
  //                               id: item.id,
  //                               text: item.no_porsi_haji
  //                           };
  //                       })
  //                   };
  //               }
  //           }
  //       });
  //   }

  //   // Inisialisasi Select2 untuk kedua input
  //   initSelect2('no_porsi_haji_1');
  //   initSelect2('no_porsi_haji_2');

  //   // Ketika kedua Select2 berubah, ambil datanya dan kirimkan filter ke server
  //   $('#no_porsi_haji_1, #no_porsi_haji_2').on('change', function () {
  //   let noPorsi1 = $('#no_porsi_haji_1').val();
  //   let noPorsi2 = $('#no_porsi_haji_2').val();

  //   console.log("Filter dari:", noPorsi1, "sampai", noPorsi2); // Debugging

  //   if (noPorsi1 && noPorsi2) {
  //       $.ajax({
  //           url: '/filter-no-porsi',
  //           type: 'GET',
  //           data: { start: noPorsi1, end: noPorsi2 },
  //           success: function (response) {
  //               console.log("Response data:", response); // Debugging
  //               $('#table-body').html(response);
  //               console.log("Tabel diperbarui!");
  //           }
  //       });
  //     }
  //   });
  // });


  </script>
</x-layout>