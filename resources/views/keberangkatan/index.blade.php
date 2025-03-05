<x-layout>
  <div>
    <x-page-title>Group Keberangkatan</x-page-title>
  </div>

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

  <div class="mt-4">
    <button data-modal-target="modal-keberangkatan" data-modal-toggle="modal-keberangkatan" class="block text-white bg-[#099AA7] hover:bg-[#099AA7]/80 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="button">Tambah Keberangkatan
    </button>
  </div>

  <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-5">
    <table id="myTable" class="w-full text-sm text-left rtl:text-right text-black bg-white">
      <thead class="text-xs text-white uppercase bg-[#099AA7]">
        <tr>
          <th scope="col" class="px-6 py-3">No</th>
          <th scope="col" class="px-6 py-3">Keberangkatan</th>
          <th scope="col" class="px-6 py-3 text-center">Aksi</th>
        </tr>
      </thead>
      <tbody id="table-body">
        @forelse ($keberangkatan as $berangkat)
        <tr class="bg-white border-b border-[#099AA7] hover:bg-gray-100">
          <td class="px-6 py-4 font-medium text-black whitespace-nowrap">
            {{ $loop->iteration }}
          </td>
          <td class="px-6 py-4 font-medium text-black whitespace-nowrap">
            {{ $berangkat->keberangkatan }}
          </td>
          <td class="px-6 py-4 font-medium text-black whitespace-nowrap text-center">
            <!-- Tombol modal tambah peserta -->
            <button data-modal-target="modal-peserta-{{ $berangkat->id }}" data-modal-toggle="modal-peserta-{{ $berangkat->id }}" class="font-medium text-blue-600 hover:underline" type="button">
              Tambah Peserta
            </button>
            <span>|</span>
            <!-- Tombol modal detail keberangkatan -->
            <button data-modal-target="modal-detail-{{ $berangkat->id }}" data-modal-toggle="modal-detail-{{ $berangkat->id }}" class="font-medium text-blue-600 hover:underline" type="button">
              Detail
            </button>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="7" class="text-center text-red-500 font-semibold py-4">
            <p>Data Masih Kosong</p>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @include('keberangkatan.modal-peserta', ['gabungHaji' => $gabungHaji])

  @include('keberangkatan.modal-detail', ['gabungHaji' => $gabungHaji])

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
  
</x-layout>