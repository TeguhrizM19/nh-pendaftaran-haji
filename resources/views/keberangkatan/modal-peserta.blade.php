@foreach ($keberangkatan as $berangkat)
  <div id="modal-peserta-{{ $berangkat->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-auto fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-11/12 max-w-6xl max-h-full"> <!-- Perbaikan ukuran modal -->
      <div class="relative bg-white rounded-lg shadow-sm">
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
          <h3 class="text-xl font-semibold text-gray-900">
            Tambah Peserta Tahun {{ $berangkat->keberangkatan }}
          </h3>
          <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="modal-peserta-{{ $berangkat->id }}">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
            <span class="sr-only">Close modal</span>
          </button>
        </div>
        
        <!-- Modal body -->
        <div class="p-4 md:p-5">
          <!-- Tabel -->
          <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-5"> 
            <form action="{{ route('update.keberangkatan') }}" method="POST">
              @csrf
              <input type="hidden" name="keberangkatan_id" value="{{ $berangkat->id }}"> <!-- Simpan ID Keberangkatan -->
      
              <table id="myTable" class="w-full text-sm text-left text-black bg-white">
                <thead class="text-xs text-white uppercase bg-[#099AA7]">
                  <tr>
                    <th class="px-6 py-3">Pilih</th>
                    <th class="px-6 py-3">No</th>
                    <th class="px-6 py-3">No SPPH</th>
                    <th class="px-6 py-3">No PORSI</th>
                    <th class="px-6 py-3">Nama</th>
                    <th class="px-6 py-3">Jenis Kelamin</th>
                    <th class="px-6 py-3">No Telepon</th>
                  </tr>
                </thead>
                <tbody id="table-body">
                  @include('keberangkatan.partial-table-peserta') {{-- Memanggil data dari partial --}}
                </tbody>
              </table>
      
              <button type="submit" class="mt-4 w-full text-white bg-[#099AA7] hover:bg-[#099AA7]/80 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                Simpan
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endforeach
