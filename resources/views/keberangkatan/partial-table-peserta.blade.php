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
      {{ $gabung->keberangkatan->keberangkatan ?? '-' }}
    </td>
    <td class="px-6 py-4 font-medium text-black whitespace-nowrap">
      {{ $gabung->no_spph ?? '-' }}
    </td>
    <td class="px-6 py-4 font-medium text-black whitespace-nowrap">
      @if (!empty($gabung->no_porsi))
        {{ $gabung->no_porsi ?? '-' }}
      @elseif (!empty($gabung->daftarHaji) && !empty($gabung->daftarHaji->no_porsi_haji))
        {{ $gabung->daftarHaji->no_porsi_haji ?? '-' }}
      @else
        -
      @endif
    </td>
    <th scope="col" class="px-6 py-4 font-medium w-[150px] sm:w-[180px] md:w-[200px] lg:w-[250px] break-words sm:break-normal overflow-hidden text-ellipsis">
      {{ $gabung->customer->nama ?? '-' }}
    </td>
    <td class="px-6 py-4 font-medium text-black whitespace-nowrap">
      {{ $gabung->customer->jenis_kelamin ?? '-' }}
    </td>
    <td class="px-6 py-4 font-medium text-black whitespace-nowrap">
      {{ $gabung->customer->no_hp_1 ?? '-' }}
    </td>
    <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap">
        @if (!empty($gabung->pelunasan))
            {{ $gabung->pelunasan ?? '-' }}
        @elseif (!empty($gabung->daftarHaji) && !empty($gabung->daftarHaji->pelunasan))
            {{ $gabung->daftarHaji->pelunasan ?? '-' }}
        @else
            -
        @endif
      </th>
      <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap">
        @if (!empty($gabung->pelunasan_manasik))
            {{ $gabung->pelunasan_manasik ?? '-' }}
        @elseif (!empty($gabung->daftarHaji) && !empty($gabung->daftarHaji->pelunasan_manasik))
            {{ $gabung->daftarHaji->pelunasan_manasik ?? '-' }}
        @else
            -
        @endif
      </th>
  </tr>
  @empty
  <tr>
    <td colspan="7" class="text-center text-red-500 font-semibold py-4">Data Masih Kosong</td>
  </tr>
@endforelse

<script>
  $(document).ready(function () {
    let pesertaTerhapus = new Set(); // Simpan daftar peserta yang akan dihapus

      // Handle perubahan checkbox
      $(document).on('change', '.peserta-checkbox', function () {
        let pesertaId = $(this).val();

      if ($(this).is(':checked')) {
        $(this).addClass('newly-checked'); // Tambahkan class jika baru dicentang
          pesertaTerhapus.delete(pesertaId); // Hapus dari daftar peserta yang akan dihapus
      } else {
        $(this).removeClass('newly-checked'); // Hapus class jika tidak dicentang
          pesertaTerhapus.add(pesertaId); // Tambahkan ke daftar peserta yang akan dihapus
      }
    });

    // Pastikan tidak ada event ganda
    $('#form-simpan').off('submit').on('submit', function (e) {
      e.preventDefault();
      simpanPesertaKeberangkatan();
    });

    $('#form-hapus').off('submit').on('submit', function (e) {
      e.preventDefault();
      hapusPesertaKeberangkatan();
    });

    function simpanPesertaKeberangkatan() {
      let keberangkatanId = $('#tahun-keberangkatan').val();
      let pesertaIds = [];

      $('.peserta-checkbox.newly-checked:checked').each(function () {
        pesertaIds.push($(this).val());
      });

      if (keberangkatanId === '') {
        Swal.fire({
          title: "Peringatan!",
          text: "Pilih tahun keberangkatan terlebih dahulu!",
          icon: "warning",
          confirmButtonColor: "#099AA7",
          confirmButtonText: "OK"
        });
        return;
      }

      if (pesertaIds.length === 0) {
        Swal.fire({
          title: "Peringatan!",
          text: "Pilih minimal satu peserta!",
          icon: "warning",
          confirmButtonColor: "#099AA7",
          confirmButtonText: "OK"
        });
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
          Swal.fire({
            title: "Berhasil!",
            text: response.message,
            icon: "success",
            confirmButtonColor: "#099AA7",
            confirmButtonText: "OK"
          }).then(() => {
            location.reload();
          });
        },
        error: function () {
          Swal.fire({
            title: "Gagal!",
            text: "Terjadi kesalahan, silakan coba lagi!",
            icon: "error",
            confirmButtonColor: "#099AA7",
            confirmButtonText: "OK"
          });
        }
      });
    }

    function hapusPesertaKeberangkatan() {
      if (pesertaTerhapus.size === 0) {
        Swal.fire({
          title: "Peringatan!",
          text: "Pilih peserta yang akan dihapus dengan menghilangkan centangnya!",
          icon: "warning",
          confirmButtonColor: "#099AA7",
          confirmButtonText: "OK"
        });
        return;
      }

      $.ajax({
        url: "{{ route('hapus.peserta.keberangkatan') }}",
        type: "POST",
        data: {
          peserta_ids: Array.from(pesertaTerhapus),
          _token: "{{ csrf_token() }}"
        },
        success: function (response) {
          Swal.fire({
            title: "Berhasil!",
            text: response.message,
            icon: "success",
            confirmButtonColor: "#099AA7",
            confirmButtonText: "OK"
          }).then(() => {
            location.reload();
          });
        },
        error: function () {
          Swal.fire({
            title: "Gagal!",
            text: "Terjadi kesalahan, silakan coba lagi!",
            icon: "error",
            confirmButtonColor: "#099AA7",
            confirmButtonText: "OK"
          });
        }
      });
    }

    // Filter Tahun Keberangkatan
    $('#filter-keberangkatan').select2({
      placeholder: "Pilih Keberangkatan",
      allowClear: true,
      width: '100%',
      dropdownCssClass: 'custom-select2'
    });

    $('#filter-keberangkatan').on('change', function () {
      let tahunKeberangkatan = $(this).val();
      $.ajax({
        url: "/keberangkatan",
        type: "GET",
        data: { keberangkatan: tahunKeberangkatan },
        success: function (response) {
          $('#table-body').html(response.html);

          // Memastikan daftar hapus tetap ada setelah filter diterapkan
          pesertaTerhapus.forEach(id => {
            let checkbox = $(`.peserta-checkbox[value="${id}"]`);
            if (checkbox.length > 0) {
                checkbox.prop('checked', false);
            }
          });

          // Hindari event handler ganda setelah AJAX
          $('#form-simpan').off('submit').on('submit', function (e) {
            e.preventDefault();
            simpanPesertaKeberangkatan();
          });

          $('#form-hapus').off('submit').on('submit', function (e) {
            e.preventDefault();
            hapusPesertaKeberangkatan();
          });

          // Sembunyikan pagination jika filter aktif
          if (response.paginate) {
            $('#pagination-container').show();
          } else {
            $('#pagination-container').hide();
          }
        }
      });
    });
  });

</script>




