<x-layout>

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
    <x-page-title>Data Gabung Haji</x-page-title>
  </div>

  <div class="mt-4 flex justify-between items-center">
    <a href="/gabung-haji/create"
        class="min-w-[120px] text-center rounded-md bg-[#099AA7] px-3 py-3 text-sm font-semibold text-white shadow-sm hover:bg-[#099AA7]/80 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#099AA7]">
        Tambah Gabung Haji
    </a>

    <form method="GET" action="{{ route('gabung-haji.index') }}" class="w-[300px]">
      <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
      <div class="relative">
        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
          <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
          </svg>
        </div>
        <input type="search" id="search-input" name="search" class="block w-full p-3 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Cari data..." />
      </div>
    </form>  
  </div>

  <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-5">
    <table id="myTable" class="w-full text-sm text-left rtl:text-right text-black bg-white">
      <thead class="text-xs text-white uppercase bg-[#099AA7]">
        <tr>
          <th scope="col" class="px-6 py-3">No</th>
          <th scope="col" class="px-6 py-3">No SPPH</th>
          <th scope="col" class="px-6 py-3">No PORSI</th>
          <th scope="col" class="px-6 py-3">Nama</th>
          <th scope="col" class="px-6 py-3">Jenis Kelamin</th>
          <th scope="col" class="px-6 py-3">No Telpone</th>
          <th scope="col" class="px-6 py-3">Catak</th>
          <th scope="col" class="px-6 py-3 text-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($gabung_haji as $gabung )
          <tr class="bg-white border-b border-[#099AA7] hover:bg-gray-100">
            <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap">
              {{ $loop->iteration }}
            </th>
            <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap">
              {{ $gabung->no_spph }}
            </th>
            <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap">
              {{ $gabung->no_porsi }}
            </th>
            <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap">
              {{ $gabung->customer->nama }}
            </th>
            <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap">
              {{ $gabung->customer->jenis_kelamin }}
            </th>
            <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap">
              {{ $gabung->customer->no_hp_1 }}
            </th>
            <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap">
              <a href="{{ route('gabung_haji.cetak', $gabung->id) }}" target="_blank" class="text-blue-600 hover:underline">
                <svg class="w-6 h-6 text-blue-500 inline-block" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M6 3a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2H6Zm1 4h10V5H7v2Zm0 2h10v2H7V9Zm0 4h10v2H7v-2Z" clip-rule="evenodd"/>
                </svg>
              </a>
            </th>
            <td class="px-6 py-4 text-center">
              <div class="inline-flex items-center space-x-2">
                <a href="/gabung-haji/{{ $gabung->id }}/edit" class="font-medium text-blue-600 hover:underline">
                  <svg class="w-6 h-6 text-green-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z" clip-rule="evenodd"/>
                    <path fill-rule="evenodd" d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z" clip-rule="evenodd"/>
                  </svg>
                </a>
                <span>|</span>
                <form action="/gabung-haji/{{ $gabung->id }}" method="POST" class="deleteForm inline-block">
                  @method('DELETE')
                  @csrf
                  <button type="submit" class="font-medium text-blue-600 hover:underline bg-transparent border-none p-0 cursor-pointer">
                    <svg class="w-6 h-6 text-red-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                      <path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd"/>
                    </svg>
                  </button>
                </form>
              </div>
            </td>
          </tr>
        @empty
        <tr>
          <td colspan="6" class="text-center text-red-500 font-semibold py-4">Data Masih Kosong</td>
        </tr>
        @endforelse     
      </tbody>
    </table>
    {{ $gabung_haji->links('pagination::tailwind') }}
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
    const tableRows = document.querySelectorAll("#myTable tbody tr");

    searchInput.addEventListener("keyup", function () {
      let searchTerm = searchInput.value.toLowerCase();

      tableRows.forEach((row) => {
        let rowData = row.textContent.toLowerCase();
        row.style.display = rowData.includes(searchTerm) ? "" : "none";
      });
    });

    // Event listener untuk tombol "X" (input clear)
    searchInput.addEventListener("input", function () {
      if (searchInput.value === "") {
        // Jika input kosong, tampilkan kembali semua baris tabel
        tableRows.forEach((row) => {
          row.style.display = "";
        });
      }
    });
  });
  </script>
  
</x-layout>