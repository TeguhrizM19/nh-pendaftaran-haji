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
    <x-page-title>Dokumen</x-page-title>
  </div>

  <button data-modal-target="modal-dokumen" data-modal-toggle="modal-dokumen" 
    class="px-3 py-2 mt-3 flex items-center justify-center gap-x-2 rounded-md bg-[#099AA7] text-sm font-semibold text-white shadow-sm hover:bg-[#099AA7]/80 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#099AA7]">
    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5" />
    </svg>
    Tambah Dokumen
  </button>

  <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-5">
    <table class="table-auto w-full text-sm text-left rtl:text-right text-black bg-white border-collapse">
      <thead class="text-xs text-white uppercase bg-[#099AA7]">
        <tr>
          <th scope="col" class="px-2 py-3 text-center">No</th>
          <th scope="col" class="px-2 py-3">Nama Dokumen</th>
          <th scope="col" class="px-2 py-3">Status</th>
          <th scope="col" class="px-2 py-3">Aksi</th>
        </tr>
      </thead>
      <tbody id="table-body">
        @forelse ($dokumen as $dok)
          <tr class="bg-white border-b border-[#099AA7] hover:bg-gray-100">
            <td scope="row" class="px-6 py-4 text-center font-medium text-black whitespace-nowrap">
              {{ $loop->iteration }}
            </td>
            <td scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap">
              {{ $dok->dokumen }}
            </td>
            <td scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap">
              {{ $dok->status }}
            </td>
            <td scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap">
              <button class="font-medium text-blue-600 hover:underline"
                data-modal-target="modal-edit-{{ $dok->id }}" z
                data-modal-toggle="modal-edit-{{ $dok->id }}">
                <svg class="w-6 h-6 text-green-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                  <path fill-rule="evenodd" d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z" clip-rule="evenodd"/>
                  <path fill-rule="evenodd" d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z" clip-rule="evenodd"/>
                </svg>
              </button>
            </td>
          </tr>
          <!-- Modal Edit Dokumen -->
          <div id="modal-edit-{{ $dok->id }}" tabindex="-1" aria-hidden="true"
            class="hidden fixed inset-0 z-50 flex justify-center items-center w-full h-full bg-gray-900 bg-opacity-50">
            <div class="relative p-4 w-full max-w-xl max-h-full">
              <div class="relative bg-white rounded-lg shadow-sm">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 border-b rounded-t border-gray-200">
                  <h3 class="text-xl font-semibold text-gray-900">Edit Dokumen</h3>
                  <button type="button"
                    class="text-gray-400 hover:text-gray-900 bg-transparent hover:bg-gray-200 rounded-lg text-sm w-8 h-8 flex justify-center items-center"
                    data-modal-hide="modal-edit-{{ $dok->id }}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                      viewBox="0 0 14 14">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7L1 13" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                  </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                  <form action="{{ route('dokumen.update', $dok->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $dok->id }}">

                    <label class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                      Nama Dokumen <span class="text-red-500 text-lg">*</span>
                    </label>
                    <input type="text" name="dokumen" value="{{ old('dokumen', $dok->dokumen) }}" placeholder="Nama Dokumen"
                      class="bg-gray-100 border-2 border-gray-500 text-gray-900 text-sm rounded-lg focus:ring-[#099AA7] focus:border-[#099AA7] block w-full p-2.5" 
                      required />

                    <div class="mt-3">
                      <label class="mb-2 block text-sm font-medium text-[#099AA7]">
                        Status
                      </label>
                      <ul class="w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg">
                        @foreach (['Aktif', 'Tidak Aktif'] as $status)
                          @php
                            $inputId = 'status_' . $dok->id . '_' . $status;
                          @endphp
                          <li class="w-full border-b border-gray-200 last:border-b-0">
                            <label for="{{ $inputId }}" class="flex items-center cursor-pointer p-3">
                              <input id="{{ $inputId }}" type="radio" value="{{ $status }}" name="status"
                                class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 focus:ring-2"
                                {{ old('status', $dok->status ?? '') == $status ? 'checked' : '' }}>
                              <span class="ms-2 text-sm font-medium text-gray-900">{{ $status }}</span>
                            </label>
                          </li>
                        @endforeach
                      </ul>
                    </div>
                  
                    <button type="submit"
                      class="mt-4 w-full text-white bg-[#099AA7] hover:bg-[#099AA7]/80 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                      Simpan
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        @empty
          <tr>
            <td colspan="4" class="text-center text-red-500 font-semibold py-4">Data Masih Kosong</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <!-- Modal Tambah Dokumen -->
  <div id="modal-dokumen" tabindex="-1" aria-hidden="true" 
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-xl max-h-full">
      <!-- Modal content -->
      <div class="relative bg-white rounded-lg shadow-sm">
        <!-- Modal header -->
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
          <h3 class="text-xl font-semibold text-gray-900">
            Masukkan Dokumen
          </h3>
          <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="modal-dokumen">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
            <span class="sr-only">Close modal</span>
          </button>
        </div>
        <!-- Modal body -->
        <div class="p-4 md:p-5">
          <form action="/dokumen" method="POST">
            @csrf
            <label class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
              Nama Dokumen <span class="text-red-500 text-lg">*</span>
            </label>
            <input type="text" name="dokumen" placeholder="Nama Dokumen"
              class="bg-gray-100 border-2 border-gray-500 text-gray-900 text-sm rounded-lg focus:ring-[#099AA7] focus:border-[#099AA7] block w-full p-2.5" 
              required />
          
            <button type="submit"
              class="mt-4 w-full text-white bg-[#099AA7] hover:bg-[#099AA7]/80 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
              Simpan
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</x-layout>