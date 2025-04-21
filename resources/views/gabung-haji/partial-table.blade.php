@forelse ($gabung_haji as $gabung )
  <tr class="bg-white border-b border-[#099AA7] hover:bg-gray-100">
    <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap">
      {{ $loop->iteration + $gabung_haji->firstItem() - 1 }}
    </th>
    <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap">
      {{ $gabung->keberangkatan->keberangkatan ?? '-' }}
    </th>
    <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap">
      {{ $gabung->no_spph ?? '-' }}
    </th>
    <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap">
      @if (!empty($gabung->no_porsi))
        {{ $gabung->no_porsi ?? '-' }}
      @elseif (!empty($gabung->daftarHaji) && !empty($gabung->daftarHaji->no_porsi_haji))
        {{ $gabung->daftarHaji->no_porsi_haji ?? '-' }}
      @else
        -
      @endif
    </th>
    <th scope="col" class="px-6 py-4 font-medium w-[150px] sm:w-[180px] md:w-[200px] lg:w-[250px] break-words sm:break-normal overflow-hidden text-ellipsis">
      {{ $gabung->customer->nama ?? '-' }}
    </th>
    <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap">
      {{ $gabung->customer->jenis_kelamin ?? '-' }}
    </th>
    <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap">
      {{ $gabung->customer->no_hp_1 ?? '-' }}
    </th>
    
    <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap">
      @if (!empty($gabung->pelunasan))
        {{ $gabung->pelunasan }}
      @elseif (!empty($gabung->daftarHaji) && !empty($gabung->daftarHaji->pelunasan))
        {{ $gabung->daftarHaji->pelunasan ?? '-' }}
      @else
        -
      @endif
    </th>
    
    <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap">
      <ul class="list-disc pl-5">
        <li>
          Operasional : 
          @php
            $biayaOperasional = $gabung->keberangkatan->operasional ?? 0;
            $dibayarOperasional = $gabung->pembayaran->where('pilihan_biaya', '4-000001')->sum('nominal');
          @endphp
          {{ $dibayarOperasional >= $biayaOperasional && $biayaOperasional > 0 ? 'LUNAS' : 'Belum Lunas' }}
        </li>
    
        <li>
          Manasik : 
          @php
            $biayaManasik = $gabung->keberangkatan->manasik ?? 0;
            $dibayarManasik = $gabung->pembayaran->where('pilihan_biaya', '4-000002')->sum('nominal');
          @endphp
          {{ $dibayarManasik >= $biayaManasik && $biayaManasik > 0 ? 'LUNAS' : 'Belum Lunas' }}
        </li>
    
        <li>
          Dam : 
          @php
            $biayaDam = $gabung->keberangkatan->dam ?? 0;
            $dibayarDam = $gabung->pembayaran->where('pilihan_biaya', '4-000003')->sum('nominal');
          @endphp
          {{ $dibayarDam >= $biayaDam && $biayaDam > 0 ? 'LUNAS' : 'Belum Lunas' }}
        </li>
      </ul>
    </th>
    
    {{-- <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap"> 
      <a href="{{ isset($gabung->daftarHaji) ? route('daftar_haji.cetak', $gabung->daftarHaji->id) : route('gabung_haji.cetak', $gabung->id) }}" 
        target="_blank" 
        class="text-blue-600 hover:underline">
        <svg class="w-6 h-6 text-red-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
          <path fill-rule="evenodd" d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2 2 2 0 0 0 2 2h12a2 2 0 0 0 2-2 2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2V4a2 2 0 0 0-2-2h-7Zm-6 9a1 1 0 0 0-1 1v5a1 1 0 1 0 2 0v-1h.5a2.5 2.5 0 0 0 0-5H5Zm1.5 3H6v-1h.5a.5.5 0 0 1 0 1Zm4.5-3a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h1.376A2.626 2.626 0 0 0 15 15.375v-1.75A2.626 2.626 0 0 0 12.375 11H11Zm1 5v-3h.375a.626.626 0 0 1 .625.626v1.748a.625.625 0 0 1-.626.626H12Zm5-5a1 1 0 0 0-1 1v5a1 1 0 1 0 2 0v-1h1a1 1 0 1 0 0-2h-1v-1h1a1 1 0 1 0 0-2h-2Z" clip-rule="evenodd"/>
        </svg>   
      </a>
    </th> --}}

    <td class="px-6 py-4 text-center"> 
      <div class="inline-flex flex-col items-center space-y-1">
        {{-- Baris pertama: Edit | Pembayaran --}}
        <div class="inline-flex items-center space-x-2">
          {{-- Edit --}}
          <a href="{{ isset($gabung->daftarHaji) ? url('/pendaftaran-haji/' . $gabung->daftarHaji->id . '/edit') : url('/gabung-haji/' . $gabung->id . '/edit') }}" 
            class="font-medium text-blue-600 hover:underline">
            <svg class="w-6 h-6 text-green-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
              <path fill-rule="evenodd" d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z" clip-rule="evenodd"/>
              <path fill-rule="evenodd" d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z" clip-rule="evenodd"/>
            </svg>
          </a>
          <span>|</span>
          {{-- Pembayaran --}}
          <a href="/pembayaran/{{ $gabung->id }}" class="font-medium text-blue-600 hover:underline">
            <svg class="w-6 h-6 text-green-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
              <path stroke="currentColor" stroke-linecap="square" stroke-linejoin="round" stroke-width="2" d="M16.5 15v1.5m0 0V18m0-1.5H15m1.5 0H18M3 9V6a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v3M3 9v6a1 1 0 0 0 1 1h5M3 9h16m0 0v1M6 12h3m12 4.5a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Z"/>
            </svg>
          </a>
        </div>
    
        {{-- Baris kedua: Kelengkapan | Delete --}}
        <div class="inline-flex items-center space-x-2">
          <!-- Kelengkapan -->
          {{-- <a href="/kelengkapan/{{ $gabung->id }}" class="font-medium text-blue-600 hover:underline">
            <svg class="w-6 h-6 text-yellow-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
              <path fill-rule="evenodd" d="M5.024 3.783A1 1 0 0 1 6 3h12a1 1 0 0 1 .976.783L20.802 12h-4.244a1.99 1.99 0 0 0-1.824 1.205 2.978 2.978 0 0 1-5.468 0A1.991 1.991 0 0 0 7.442 12H3.198l1.826-8.217ZM3 14v5a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-5h-4.43a4.978 4.978 0 0 1-9.14 0H3Zm5-7a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H9a1 1 0 0 1-1-1Zm0 2a1 1 0 0 0 0 2h8a1 1 0 1 0 0-2H8Z" clip-rule="evenodd"/>
            </svg>
          </a> --}}
          <a href="{{ isset($gabung->daftarHaji) ? route('daftar_haji.cetak', $gabung->daftarHaji->id) : route('gabung_haji.cetak', $gabung->id) }}" 
            target="_blank" 
            class="text-blue-600 hover:underline">
            <svg class="w-6 h-6 text-red-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
              <path fill-rule="evenodd" d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2 2 2 0 0 0 2 2h12a2 2 0 0 0 2-2 2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2V4a2 2 0 0 0-2-2h-7Zm-6 9a1 1 0 0 0-1 1v5a1 1 0 1 0 2 0v-1h.5a2.5 2.5 0 0 0 0-5H5Zm1.5 3H6v-1h.5a.5.5 0 0 1 0 1Zm4.5-3a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h1.376A2.626 2.626 0 0 0 15 15.375v-1.75A2.626 2.626 0 0 0 12.375 11H11Zm1 5v-3h.375a.626.626 0 0 1 .625.626v1.748a.625.625 0 0 1-.626.626H12Zm5-5a1 1 0 0 0-1 1v5a1 1 0 1 0 2 0v-1h1a1 1 0 1 0 0-2h-1v-1h1a1 1 0 1 0 0-2h-2Z" clip-rule="evenodd"/>
            </svg>   
          </a>
          <span>|</span>
          {{-- Delete --}}
          <form action="{{ isset($gabung->daftarHaji) ? url('/pendaftaran-haji/' . $gabung->daftarHaji->id) : url('/gabung-haji/' . $gabung->id) }}" 
            method="POST" 
            class="deleteForm inline-block">
            @method('DELETE')
            @csrf
            <button type="submit" class="font-medium text-blue-600 hover:underline bg-transparent border-none p-0 cursor-pointer" alt="Delete">
              <svg class="w-6 h-6 text-red-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd"/>
              </svg>
            </button>
          </form>
        </div>
      </div>
    </td>
  </tr>
@empty
<tr>
  <td colspan="6" class="text-center text-red-500 font-semibold py-4">Data Masih Kosong</td>
</tr>
@endforelse

{{-- Style warna dari Sweet Alert Konfirmasi Delete --}}
<style>
  .btn-swal-hapus {
    background-color: #d33 !important;
    color: white !important;
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 0.375rem;
    margin-right: 0.5rem;
  }

  .btn-swal-batal {
    background-color: #3085d6 !important;
    color: white !important;
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 0.375rem;
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
          confirmButtonText: "Ya, Hapus!",
          cancelButtonText: "Batal",
          buttonsStyling: false,
          customClass: {
            confirmButton: 'btn-swal-hapus',  // custom button hapus
            cancelButton: 'btn-swal-batal'    // custom button batal
          }
        }).then((result) => {
          if (result.isConfirmed) {
            form.submit();
          }
        });
      });
    });
  });
</script>
