@forelse ($keberangkatan as $berangkat) 
  <tr class="bg-white border-b border-[#099AA7] hover:bg-gray-100">
    <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap">
      {{ $loop->iteration + $keberangkatan->firstItem() - 1 }}
    </th>
    <th class="px-6 py-4 font-medium text-black whitespace-nowrap">
      {{ $berangkat->keberangkatan ?? '-' }}
    </th>
    <th class="px-6 py-4 font-medium text-black whitespace-nowrap">
      {{ $berangkat->manasik ? 'Rp. ' . number_format($berangkat->manasik, 0, ',', '.') : '-' }}
    </th>
    <th class="px-6 py-4 font-medium text-black whitespace-nowrap">
        {{ $berangkat->operasional ? 'Rp. ' . number_format($berangkat->operasional, 0, ',', '.') : '-' }}
    </th>
    <th class="px-6 py-4 font-medium text-black whitespace-nowrap">
        {{ $berangkat->dam ? 'Rp. ' . number_format($berangkat->dam, 0, ',', '.') : '-' }}
    </th>  
    <td class="px-6 py-4 text-center">
      <div class="inline-flex items-center space-x-2">
        <button class="font-medium text-blue-600 hover:underline"
          data-modal-target="modal-edit-{{ $berangkat->id }}" z
          data-modal-toggle="modal-edit-{{ $berangkat->id }}">
          <svg class="w-6 h-6 text-green-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
            <path fill-rule="evenodd" d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z" clip-rule="evenodd"/>
            <path fill-rule="evenodd" d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z" clip-rule="evenodd"/>
          </svg>
        </button>
        <span>|</span>
        <form action="/keberangkatan/{{ $berangkat->id }}" method="POST" class="deleteForm inline-block">
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

  <!-- Modal Edit -->
  <div id="modal-edit-{{ $berangkat->id }}" tabindex="-1" aria-hidden="true" 
    class="hidden fixed inset-0 z-50 flex justify-center items-center w-full h-full bg-gray-900 bg-opacity-50">
    <div class="relative p-4 w-full max-w-md max-h-full">
      <div class="relative bg-white rounded-lg shadow-sm">
        <!-- Modal header -->
        <div class="flex items-center justify-between p-4 border-b rounded-t border-gray-200">
          <h3 class="text-xl font-semibold text-gray-900">Edit Data</h3>
          <button type="button" class="text-gray-400 hover:text-gray-900 bg-transparent hover:bg-gray-200 rounded-lg text-sm w-8 h-8 flex justify-center items-center"
                  data-modal-hide="modal-edit-{{ $berangkat->id }}">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7L1 13"/>
            </svg>
            <span class="sr-only">Close modal</span>
          </button>
        </div>
        <!-- Modal body -->
        <div class="p-4">
          <form action="{{ route('keberangkatan.update', $berangkat->id) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $berangkat->id }}">
            <div>
              <label class="mb-2 block text-sm font-medium text-[#099AA7]">
                Tahun Keberangkatan <span class="text-red-500 text-lg">*</span>
              </label>
              <input type="text" name="keberangkatan" value="{{ $berangkat->keberangkatan }}"
                class="bg-gray-100 mb-3 border-2 border-gray-500 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                required pattern="\d{4}" />
            </div>
            <div>
              <label class="mb-2 block text-sm font-medium text-[#099AA7]">
                Manasik
              </label>
              <input type="text" name="manasik" id="manasik_{{ $berangkat->id }}" 
                value="{{ $berangkat->manasik ? 'Rp. ' . number_format($berangkat->manasik, 0, ',', '.') : '' }}"
                class="bg-gray-100 mb-3 border-2 border-gray-500 text-gray-900 text-sm rounded-lg block w-full p-2.5" 
                placeholder="Masukkan Nominal Manasik" />

              <input type="hidden" name="manasik_raw" id="manasik_raw_{{ $berangkat->id }}" value="{{ $berangkat->manasik }}">
            </div>

            <div>
              <label class="mb-2 block text-sm font-medium text-[#099AA7]">
                Operasional
              </label>
              <input type="text" name="operasional" id="operasional_{{ $berangkat->id }}" 
                value="{{ $berangkat->operasional ? 'Rp. ' . number_format($berangkat->operasional, 0, ',', '.') : '' }}"
                class="bg-gray-100 mb-3 border-2 border-gray-500 text-gray-900 text-sm rounded-lg block w-full p-2.5" 
                placeholder="Masukkan Nominal Operasional" />

              <input type="hidden" name="operasional_raw" id="operasional_raw_{{ $berangkat->id }}" value="{{ $berangkat->operasional }}">
            </div>

            <div>
              <label class="mb-2 block text-sm font-medium text-[#099AA7]">
                Dam
              </label>
              <input type="text" name="dam" id="dam_{{ $berangkat->id }}" 
                value="{{ $berangkat->dam ? 'Rp. ' . number_format($berangkat->dam, 0, ',', '.') : '' }}"
                class="bg-gray-100 border-2 border-gray-500 text-gray-900 text-sm rounded-lg block w-full p-2.5" 
                placeholder="Masukkan Nominal Dam" />

              <input type="hidden" name="dam_raw" id="dam_raw_{{ $berangkat->id }}" value="{{ $berangkat->dam }}">
            </div>
            <button type="submit"
              class="mt-4 w-full text-white bg-[#099AA7] hover:bg-[#099AA7]/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
              Simpan
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
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

  // Format Uang
  document.addEventListener("DOMContentLoaded", function () {
    function formatCurrency(inputId, hiddenId) {
      let inputField = document.getElementById(inputId);
      let hiddenField = document.getElementById(hiddenId);

      if (!inputField || !hiddenField) return;

      // Format awal saat modal muncul
      let initialValue = hiddenField.value;
      if (initialValue) {
        inputField.value = "Rp. " + new Intl.NumberFormat("id-ID").format(initialValue);
      }

      // Saat user mengetik
      inputField.addEventListener("input", function (e) {
        let value = e.target.value.replace(/\D/g, ""); // Hanya angka
        hiddenField.value = value; // Simpan angka asli tanpa format

        if (value) {
          e.target.value = "Rp. " + new Intl.NumberFormat("id-ID").format(value);
        } else {
          e.target.value = "";
        }
      });

      // Saat fokus (biar terlihat angka asli)
      inputField.addEventListener("focus", function () {
        inputField.value = hiddenField.value;
      });

      // Saat blur (kembali ke format Rp)
      inputField.addEventListener("blur", function () {
        let value = hiddenField.value;
        if (value) {
          inputField.value = "Rp. " + new Intl.NumberFormat("id-ID").format(value);
        }
      });
    }

    // Aktifkan format untuk semua input uang di modal edit
    document.querySelectorAll("[id^='manasik_']").forEach((el) => {
      let id = el.id.replace("manasik_", "");
      formatCurrency("manasik_" + id, "manasik_raw_" + id);
      formatCurrency("operasional_" + id, "operasional_raw_" + id);
      formatCurrency("dam_" + id, "dam_raw_" + id);
    });
  });

</script>

