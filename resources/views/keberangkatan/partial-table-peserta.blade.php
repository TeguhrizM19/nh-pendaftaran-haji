@forelse ($gabung_haji as $gabung) 
  <tr class="bg-white border-b border-[#099AA7] hover:bg-gray-100">
    <td class="px-6 py-4">
      {{-- Checkbox --}}
      <input type="checkbox" name="peserta[]" value="{{ $gabung->id }}" 
        class="peserta-checkbox w-4 h-4 text-blue-600 bg-gray-400 border-gray-700 rounded-sm focus:ring-blue-500"
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

<script>
  $(document).ready(function () {
    $('#btn-simpan').on('click', function (e) {
        e.preventDefault();
        simpanPesertaKeberangkatan();
    });

    $('#btn-hapus').on('click', function (e) {
        e.preventDefault();
        hapusPesertaKeberangkatan();
    });

    function simpanPesertaKeberangkatan() {
        let keberangkatanId = $('#tahun-keberangkatan').val();
        let pesertaIds = [];

        $('.peserta-checkbox:checked').each(function () {
            pesertaIds.push($(this).val());
        });

        if (keberangkatanId === '') {
            alert('Pilih tahun keberangkatan terlebih dahulu!');
            return;
        }

        if (pesertaIds.length === 0) {
            alert('Pilih minimal satu peserta!');
            return;
        }

        $.ajax({
            url: "{{ route('simpan.peserta.keberangkatan') }}",
            type: "POST",
            data: {
                keberangkatan_id: keberangkatanId,
                peserta_ids: pesertaIds,
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {
                Swal.fire("Berhasil!", response.message, "success").then(() => {
                    location.reload();
                });
            },
            error: function (xhr) {
                Swal.fire("Gagal!", "Terjadi kesalahan, silakan coba lagi!", "error");
            }
        });
    }

    function hapusPesertaKeberangkatan() {
        let keberangkatanId = $('#tahun-keberangkatan').val();
        let pesertaIds = [];

        $('.peserta-checkbox:checked').each(function () {
            pesertaIds.push($(this).val());
        });

        if (keberangkatanId === '') {
            alert('Pilih tahun keberangkatan terlebih dahulu!');
            return;
        }

        if (pesertaIds.length === 0) {
            alert('Pilih minimal satu peserta untuk dihapus!');
            return;
        }

        $.ajax({
            url: "{{ route('hapus.peserta.keberangkatan') }}",
            type: "POST",
            data: {
                keberangkatan_id: keberangkatanId,
                peserta_ids: pesertaIds,
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {
                Swal.fire("Berhasil!", response.message, "success").then(() => {
                    location.reload();
                });
            },
            error: function (xhr) {
                Swal.fire("Gagal!", "Terjadi kesalahan, silakan coba lagi!", "error");
            }
        });
    }
});

  
</script>
  