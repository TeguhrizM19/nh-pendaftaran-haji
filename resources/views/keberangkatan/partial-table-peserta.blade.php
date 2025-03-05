@forelse ($gabungHaji as $gabung) 
  <tr class="bg-white border-b border-[#099AA7] hover:bg-gray-100">
    <td class="px-6 py-4">
      {{-- Checkbox --}}
      <input type="checkbox" name="peserta[]" value="{{ $gabung->id }}" 
        class="w-4 h-4 text-blue-600 bg-gray-400 border-gray-700 rounded-sm focus:ring-blue-500"
        {{ $gabung->keberangkatan_id ? 'checked' : '' }}>
    </td>
    <td class="px-6 py-4 font-medium text-black whitespace-nowrap">
      {{ $loop->iteration }}
    </td>
    <td class="px-6 py-4 font-medium text-black whitespace-nowrap">
      {{ $gabung->no_spph }}
    </td>
    <td class="px-6 py-4 font-medium text-black whitespace-nowrap">
      @if (!empty($gabung->no_porsi))
        {{ $gabung->no_porsi }}
      @elseif (!empty($gabung->daftarHaji) && !empty($gabung->daftarHaji->no_porsi_haji))
        {{ $gabung->daftarHaji->no_porsi_haji }}
      @else
        -
      @endif
    </td>
    <td class="px-6 py-4 font-medium text-black whitespace-nowrap">
      {{ $gabung->customer->nama }}
    </td>
    <td class="px-6 py-4 font-medium text-black whitespace-nowrap">
      {{ $gabung->customer->jenis_kelamin }}
    </td>
    <td class="px-6 py-4 font-medium text-black whitespace-nowrap">
      {{ $gabung->customer->no_hp_1 }}
    </td>
  </tr>
  @empty
  <tr>
      <td colspan="7" class="text-center text-red-500 font-semibold py-4">Data Masih Kosong</td>
  </tr>
@endforelse


{{-- <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap"> 
      <a href="{{ isset($gabung->daftarHaji) ? route('daftar_haji.cetak', $gabung->daftarHaji->id) : route('gabung_haji.cetak', $gabung->id) }}" 
         target="_blank" 
         class="text-blue-600 hover:underline">
          Cetak
      </a>
    </th> --}}
    {{-- <td class="px-6 py-4 text-center">
      <div class="inline-flex items-center space-x-2">
        <a href="{{ isset($gabung->daftarHaji) ? url('/pendaftaran-haji/' . $gabung->daftarHaji->id . '/edit') : url('/gabung-haji/' . $gabung->id . '/edit') }}" 
          class="font-medium text-blue-600 hover:underline">
           Edit
        </a>       
        <span>|</span>
        <form action="{{ isset($gabung->daftarHaji) ? url('/pendaftaran-haji/' . $gabung->daftarHaji->id) : url('/gabung-haji/' . $gabung->id) }}" 
          method="POST" 
          class="deleteForm inline-block">
        @method('DELETE')
        @csrf
        <button type="submit" class="font-medium text-blue-600 hover:underline bg-transparent border-none p-0 cursor-pointer">
            Hapus
        </button>
        </form>    
      </div>
    </td> --}}