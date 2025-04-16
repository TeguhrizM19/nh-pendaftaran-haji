@forelse ($daftar_haji as $daftar )
  <tr class="bg-white border-b border-[#099AA7] hover:bg-gray-100">
    <td class="px-6 py-4 font-medium text-black whitespace-nowrap">
      {{ $loop->iteration + $daftar_haji->firstItem() - 1 }}
    </td>
    <td class="px-6 py-4 font-medium text-black whitespace-nowrap">
      {{ $daftar->keberangkatan->keberangkatan ?? '-' }}
    </td>
    <td class="px-6 py-4 font-medium text-black whitespace-nowrap">
      {{ $daftar->no_porsi_haji ?? '-' }}
    </td>
    <th scope="col" class="px-6 py-4 font-medium w-[150px] sm:w-[180px] md:w-[200px] lg:w-[250px] break-words sm:break-normal overflow-hidden text-ellipsis">
      {{ $daftar->customer->nama ?? '-' }}
    </td>
    <td class="px-6 py-4 font-medium text-black whitespace-nowrap">
      {{ $daftar->paket_haji ?? '-' }}
    </td>
    <td class="px-6 py-4 font-medium text-black whitespace-nowrap">
      {{ $daftar->customer->jenis_kelamin ?? '-' }}
    </td>
    <td class="px-6 py-4 font-medium text-black whitespace-nowrap">
      {{ $daftar->customer->no_hp_1 ?? '-' }}
    </td>
    <td class="px-6 py-4 font-medium text-black whitespace-nowrap">
      {{ $daftar->pelunasan ?? '-' }}
    </td>
    {{-- <td class="px-6 py-4 font-medium text-black whitespace-nowrap">
      {{ $daftar->pelunasan_manasik ?? '-' }}
    </td> --}}

    <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap">
      <ul class="list-disc pl-5">
        <li>
          Operasional : 
          @php
            $biayaOperasional = $daftar->keberangkatan->operasional ?? 0;
            $dibayarOperasional = $daftar->pembayaran->where('pilihan_biaya', '4-000001')->sum('nominal');
          @endphp
          {{ $dibayarOperasional >= $biayaOperasional && $biayaOperasional > 0 ? 'LUNAS' : 'Belum Lunas' }}
        </li>
    
        <li>
          Manasik : 
          @php
            $biayaManasik = $daftar->keberangkatan->manasik ?? 0;
            $dibayarManasik = $daftar->pembayaran->where('pilihan_biaya', '4-000002')->sum('nominal');
          @endphp
          {{ $dibayarManasik >= $biayaManasik && $biayaManasik > 0 ? 'LUNAS' : 'Belum Lunas' }}
        </li>
    
        <li>
          Dam : 
          @php
            $biayaDam = $daftar->keberangkatan->dam ?? 0;
            $dibayarDam = $daftar->pembayaran->where('pilihan_biaya', '4-000003')->sum('nominal');
          @endphp
          {{ $dibayarDam >= $biayaDam && $biayaDam > 0 ? 'LUNAS' : 'Belum Lunas' }}
        </li>
      </ul>
    </th>
    
    <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap">
      <a href="{{ route('daftar_haji.cetak', $daftar->id) }}" target="_blank" class="text-blue-600 hover:underline">
        <svg class="w-6 h-6 text-red-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
          <path fill-rule="evenodd" d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2 2 2 0 0 0 2 2h12a2 2 0 0 0 2-2 2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2V4a2 2 0 0 0-2-2h-7Zm-6 9a1 1 0 0 0-1 1v5a1 1 0 1 0 2 0v-1h.5a2.5 2.5 0 0 0 0-5H5Zm1.5 3H6v-1h.5a.5.5 0 0 1 0 1Zm4.5-3a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h1.376A2.626 2.626 0 0 0 15 15.375v-1.75A2.626 2.626 0 0 0 12.375 11H11Zm1 5v-3h.375a.626.626 0 0 1 .625.626v1.748a.625.625 0 0 1-.626.626H12Zm5-5a1 1 0 0 0-1 1v5a1 1 0 1 0 2 0v-1h1a1 1 0 1 0 0-2h-1v-1h1a1 1 0 1 0 0-2h-2Z" clip-rule="evenodd"/>
        </svg>
      </a>
    </th>
  
    <td class="px-6 py-4 text-center">
      <div class="inline-flex items-center space-x-2">
        <a href="/pendaftaran-haji/{{ $daftar->id }}/edit" class="font-medium text-blue-600 hover:underline">
          <svg class="w-6 h-6 text-green-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
            <path fill-rule="evenodd" d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z" clip-rule="evenodd"/>
            <path fill-rule="evenodd" d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z" clip-rule="evenodd"/>
          </svg>
        </a>
        <span>|</span>
          {{-- Pembayaran --}}
          {{-- <a href="/pembayaran/{{ $daftar->id }}" class="font-medium text-blue-600 hover:underline">
            <svg class="w-6 h-6 text-green-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
              <path stroke="currentColor" stroke-linecap="square" stroke-linejoin="round" stroke-width="2" d="M16.5 15v1.5m0 0V18m0-1.5H15m1.5 0H18M3 9V6a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v3M3 9v6a1 1 0 0 0 1 1h5M3 9h16m0 0v1M6 12h3m12 4.5a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Z"/>
            </svg>
          </a>
        <span>|</span> --}}
        <form action="/pendaftaran-haji/{{ $daftar->id }}" method="POST" class="deleteForm inline-block">
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
</script>