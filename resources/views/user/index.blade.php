<x-layout>
  <div>
    <x-page-title>Tabel User</x-page-title>
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

  <!-- Tombol Tambah User -->
  <div class="w-full md:w-auto flex justify-start mt-3">
    <button data-modal-target="modal-user" data-modal-toggle="modal-user" 
      class="flex text-white bg-[#099AA7] hover:bg-[#099AA7]/80 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-1.5">
      <svg class="w-6 h-6 mr-2 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/>
      </svg>
      Tambah User
    </button>
  </div>

  <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-5">
    <table id="myTable" class="w-full text-sm text-left rtl:text-right text-black bg-white">
      <thead class="text-xs text-white uppercase bg-[#099AA7]">
        <tr>
          <th scope="col" class="px-6 py-3">No</th>
          <th scope="col" class="px-6 py-3">Nama</th>
          <th scope="col" class="px-6 py-3">Username</th>
          <th scope="col" class="px-6 py-3">cabang</th>
          <th scope="col" class="px-6 py-3 text-center">Aksi</th>
        </tr>
      </thead>
      <tbody id="table-body">
        @forelse ($users as $user )
        <tr class="bg-white border-b border-[#099AA7] hover:bg-gray-100">
          <td class="px-6 py-4 font-medium text-black whitespace-nowrap">
            {{ $loop->iteration }}
          </td>
          <td class="px-6 py-4 font-medium text-black whitespace-nowrap">
            {{ $user->name }}
          </td>
          <td class="px-6 py-4 font-medium text-black whitespace-nowrap">
            {{ $user->username }}
          </td>
          <td class="px-6 py-4 font-medium text-black whitespace-nowrap">
            {{ $user->cabang->cabang ?? '-' }}
          </td>
          <td class="px-6 py-4 text-center">
            <div class="inline-flex items-center space-x-2">
              {{-- <a href="/pendaftaran-haji/{{ $user->id }}/edit" class="font-medium text-blue-600 hover:underline">
                <svg class="w-6 h-6 text-green-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                  <path fill-rule="evenodd" d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z" clip-rule="evenodd"/>
                  <path fill-rule="evenodd" d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z" clip-rule="evenodd"/>
                </svg>
              </a>
              <span>|</span> --}}
              <form action="/user/{{ $user->id }}" method="POST" class="deleteForm inline-block">
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
          <td colspan="7" class="text-center text-red-500 font-semibold py-4">
            <p>Data Masih Kosong</p>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
    {{-- Cek apakah data dipaginate --}}
    {{-- <div id="pagination-container" class="mt-4" style="{{ request()->hasAny(['search', 'no_porsi_haji_1', 'no_porsi_haji_2']) ? 'display: none;' : '' }}">
      <div id="pagination-links" class="mt-4">
        {{ $daftar_haji->links('pagination::tailwind') }}
      </div>
    </div> --}}
  </div>


  <!-- Modal Tambah Tahun Keberangkatan -->
  <div id="modal-user" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
      <!-- Modal content -->
      <div class="relative bg-white rounded-lg shadow-sm">
        <!-- Modal header -->
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
          <h3 class="text-xl font-semibold text-gray-900">
            Tambah User
          </h3>
          <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="modal-user">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
            <span class="sr-only">Close modal</span>
          </button>
        </div>
        <!-- Modal body -->
        <div class="p-4 md:p-5">
          <form action="/user" method="POST" class="space-y-4">
            @csrf
            <div>
              <label for="name" class="mb-2 mt-3 block text-sm font-medium leading-6 text-[#099AA7]">
                Nama
              </label>
              <input type="text" name="name" id="name" class="bg-gray-50 border-2 border-gray-700 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Masukkan Nama" required />
            </div>
            <div>
              <label for="username" class="mb-2 mt-3 block text-sm font-medium leading-6 text-[#099AA7]">
                Username
              </label>
              <input type="text" name="username" id="username" class="bg-gray-50 border-2 border-gray-700 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Masukkan Username" required />
            </div>
            <div>
              <label for="password" class="mb-2 mt-3 block text-sm font-medium leading-6 text-[#099AA7]">
                Password
              </label>
              <input type="text" name="password" id="password" class="bg-gray-50 border-2 border-gray-700 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Masukkan Password" required />
            </div>
            <div>
              <label for="cabang_id" class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                Cabang Daftar <span class="text-red-500 text-lg">*</span>
              </label>
              <select name="cabang_id" id="cabang_id" required
                class="w-full text-gray-900 bg-white border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                <option value="">Pilih</option>
                @foreach($cabang as $cbg)
                <option value="{{ $cbg->id }}" {{ old('cabang_id') == $cbg->id ? 'selected' : '' }}>
                  {{ $cbg->cabang }}
                </option>
                @endforeach
              </select>
            </div>
            <div>
              <label for="level" class="mb-2 mt-3 block text-sm font-medium leading-6 text-[#099AA7]">
                Level
              </label>
              <select name="level" id="level" class="bg-gray-50 border-2 border-gray-700 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                @php
                  $levels = ['super_admin', 'admin', 'qc'];
                @endphp
                @foreach ($levels as $level)
                  <option value="{{ $level }}">{{ ucfirst(str_replace('_', ' ', $level)) }}</option>
                @endforeach
              </select>
            </div>            
            <button type="submit" class="w-full text-white bg-[#099AA7] hover:bg-[#099AA7]/80 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan</button>
          </form>
        </div>
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

  // Cabang
  $(document).ready(function () {
    $('#cabang_id').select2({
      placeholder: "Pilih", // Placeholder
      allowClear: true, // Bisa menghapus pilihan
      width: '100%' // Sesuaikan dengan Tailwind
    });

    // Ambil nilai old value dari Laravel
    var oldValue = "{{ old('cabang_id') }}";

    // Jika oldValue ada, set di Select2
    if (oldValue) {
      $('#cabang_id').val(oldValue).trigger('change');
    }
  });
  </script>

</x-layout>