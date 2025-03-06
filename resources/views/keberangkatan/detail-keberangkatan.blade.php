<x-layout>
  @foreach ($keberangkatan as $berangkat)
  <div>
    <x-page-title>Detail Keberangkatan Tahun {{ $berangkat->keberangkatan }}</x-page-title>
  </div>

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
          @include('keberangkatan.partial-table-detail', ['gabungHaji' => $gabungHajiDetail->filter(fn($gabung) => $gabung->keberangkatan_id == $berangkat->id)])
        </tbody>
      </table>

      <div class="justify-center flex gap-2">
        <a href="/keberangkatan"
          class="mt-4 flex items-center gap-2 text-white bg-[#099AA7] hover:bg-[#099AA7]/80 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-md text-sm px-5 py-2.5">
          <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="m17 16-4-4 4-4m-6 8-4-4 4-4" />
          </svg>
          Tabel Keberangkatan
        </a>
    
        <button type="submit"
          class="mt-4 flex items-center gap-2 text-white bg-[#099AA7] hover:bg-[#099AA7]/80 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-md text-sm px-5 py-2.5">
          <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
              d="M11 16h2m6.707-9.293-2.414-2.414A1 1 0 0 0 16.586 4H5a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V7.414a1 1 0 0 0-.293-.707ZM16 20v-6a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v6h8ZM9 4h6v3a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1V4Z" />
          </svg>
          Simpan
        </button>
      </div>    
    </form>
  </div>
  @endforeach

</x-layout>