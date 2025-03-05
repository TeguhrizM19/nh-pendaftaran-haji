@forelse ($gabungHaji as $gabung) 
  <tr class="bg-white border-b border-[#099AA7] hover:bg-gray-100">
    <td class="px-6 py-4">
      <input type="hidden" name="peserta_status[{{ $gabung->id }}]" value="unchecked">
      <input type="checkbox" name="peserta[]" value="{{ $gabung->id }}" 
        class="w-4 h-4 text-blue-600 bg-gray-400 border-gray-700 rounded-sm focus:ring-blue-500"
        checked
        onchange="this.previousElementSibling.value = this.checked ? 'checked' : 'unchecked'">
    </td>
    <td class="px-6 py-4 font-medium text-black whitespace-nowrap">
      {{ $loop->iteration }}
    </td>
    <td class="px-6 py-4 font-medium text-black whitespace-nowrap">
      {{ $gabung->no_spph }}
    </td>
    <td class="px-6 py-4 font-medium text-black whitespace-nowrap">
      {{ $gabung->no_porsi ?? $gabung->daftarHaji->no_porsi_haji ?? '-' }}
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
    <td colspan="7" class="text-center text-red-500 font-semibold py-4">Tidak ada peserta dalam keberangkatan ini</td>
  </tr>
@endforelse
