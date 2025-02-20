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
  <div class="mt-4">
    <a href="/gabung-haji/create"
    class="min-w-[120px] text-center rounded-md bg-[#099AA7] ms-auto px-3 py-3 text-sm font-semibold text-white shadow-sm hover:bg-[#099AA7]/80 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#099AA7]">
    Tambah Data
  </a>
  </div>

  <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-5">
    <table class="w-full text-sm text-left rtl:text-right text-black bg-white">
      <thead class="text-xs text-white uppercase bg-[#099AA7]">
        <tr>
          <th scope="col" class="px-6 py-3">
            No
          </th>
          <th scope="col" class="px-6 py-3">
            Nama
          </th>
          <th scope="col" class="px-6 py-3 text-center">
            Aksi
          </th>
        </tr>
      </thead>
      <tbody>
        @forelse ($gabung_haji as $gabung )
          <tr class="bg-white border-b border-[#099AA7] hover:bg-gray-100">
            <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap">
              {{ $loop->iteration }}
            </th>
            <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap">
              {{ $gabung->customer->nama }}
            </th>
            <td class="px-6 py-4 text-center">
              <div class="inline-flex items-center space-x-2">
                {{-- <a href="#" class="font-medium text-blue-600 hover:underline">Detail</a>
                <span>|</span> --}}
                <a href="/gabung-haji/{{ $gabung->id }}/edit" class="font-medium text-blue-600 hover:underline">Edit</a>
                <span>|</span>
                <form action="/gabung-haji/{{ $gabung->id }}" method="POST" class="deleteForm inline-block">
                  @method('DELETE')
                  @csrf
                  <button type="submit" class="font-medium text-blue-600 hover:underline bg-transparent border-none p-0 cursor-pointer">
                    Hapus
                  </button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td class="text-center">Data Masih Kosong</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <script>
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
  </script>
  
</x-layout>