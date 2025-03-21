<x-layout>
  <div>
    <x-page-title>Tahun Keberangkatan Dan Nominal Pembayaran</x-page-title>
  </div>

  @if(session('success'))
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      Swal.fire({
        title: "Berhasil!",
        text: "{!! session('success') !!}",
        icon: "success",
        confirmButtonText: "OK",
        confirmButtonColor: "#099AA7"
      });
    });
  </script>
  @endif

  <div class="mt-3">
    <button data-modal-target="modal-keberangkatan" data-modal-toggle="modal-keberangkatan" 
      class="px-3 py-2 flex items-center justify-center gap-x-2 rounded-md bg-[#099AA7] py-1 text-sm font-semibold text-white shadow-sm hover:bg-[#099AA7]/80 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#099AA7]">
      <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5" />
      </svg>
      Tambah Data
    </button>
  </div>

  <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-5">
    <table id="myTable" class="w-full text-sm text-left rtl:text-right text-black bg-white">
      <thead class="text-xs text-white uppercase bg-[#099AA7]">
        <tr>
          <th scope="col" class="px-6 py-3">No</th>
          <th scope="col" class="px-6 py-3">Tahun Keberangkatan</th>
          <th scope="col" class="px-6 py-3">Manasik</th>
          <th scope="col" class="px-6 py-3">Operasional</th>
          <th scope="col" class="px-6 py-3">Dam</th>
          <th scope="col" class="px-6 py-3 text-center">Aksi</th>
        </tr>
      </thead>
      <tbody id="table-body">
        @include('keberangkatan.partial-table-tahun-keberangkatan', ['kebarangkatan' => $keberangkatan])
      </tbody>
    </table>
    
    <!-- Paginate -->
    <div id="pagination-container" class="mt-4">
      <div id="pagination-links">
        {{ $keberangkatan->links('pagination::tailwind') }}
      </div>
    </div>
  </div>

  <!-- Modal Create -->
  <div id="modal-keberangkatan" tabindex="-1" aria-hidden="true" 
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
      <!-- Modal content -->
      <div class="relative bg-white rounded-lg shadow-sm">
        <!-- Modal header -->
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
          <h3 class="text-xl font-semibold text-gray-900">
            Masukkan Data
          </h3>
          <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="modal-keberangkatan">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
            <span class="sr-only">Close modal</span>
          </button>
        </div>
        <!-- Modal body -->
        <div class="p-4 md:p-5">
          <form action="/keberangkatan" method="POST" class="space-y-4">
            @csrf
            <div>
              <label class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                Tahun Keberangkatan <span class="text-red-500 text-lg">*</span>
              </label>
              <input type="text" name="keberangkatan" id="keberangkatan" 
              class="bg-gray-100 border-2 border-gray-500 text-gray-900 text-sm rounded-lg focus:ring-[#099AA7] focus:border-[#099AA7] block w-full p-2.5" 
              placeholder="YYYY" required 
              pattern="\d{4}" title="Harus 4 digit angka (YYYY)" />
            </div>
            <div>
              <label class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                Manasik
              </label>
              <input type="text" name="manasik" id="manasik" class="bg-gray-100 border-2 border-gray-500 text-gray-900 text-sm rounded-lg focus:ring-[#099AA7] focus:border-[#099AA7] block w-full p-2.5" placeholder="Masukkan Nominal Manasik" />
              <input type="hidden" name="manasik_raw" id="manasik_raw">
            </div>
            <div>
              <label class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                Operasional
              </label>
              <input type="text" name="operasional" id="operasional" class="bg-gray-100 border-2 border-gray-500 text-gray-900 text-sm rounded-lg focus:ring-[#099AA7] focus:border-[#099AA7] block w-full p-2.5" 
              placeholder="Masukkan Nominal Operasional" />
              <input type="hidden" name="operasional_raw" id="operasional_raw">
            </div>
            <div>
              <label class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                Dam
              </label>
              <input type="text" name="dam" id="dam" class="bg-gray-100 border-2 border-gray-500 text-gray-900 text-sm rounded-lg focus:ring-[#099AA7] focus:border-[#099AA7] block w-full p-2.5" 
              placeholder="Masukkan Nominal Dam" />
              <input type="hidden" name="dam_raw" id="dam_raw">
            </div>
            <button type="submit" class="mt-4 w-full text-white bg-[#099AA7] hover:bg-[#099AA7]/80 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      function formatCurrency(inputId, hiddenId) {
        let inputField = document.getElementById(inputId);
        let hiddenField = document.getElementById(hiddenId);

        inputField.addEventListener("input", function (e) {
          let value = e.target.value.replace(/\D/g, ""); // Hanya angka
          hiddenField.value = value; // Simpan angka asli tanpa format

          if (value) {
            e.target.value = "Rp. " + new Intl.NumberFormat("id-ID").format(value);
          } else {
            e.target.value = "";
          }
        });

        inputField.addEventListener("focus", function () {
          inputField.value = hiddenField.value; // Tampilkan angka asli saat fokus
        });

        inputField.addEventListener("blur", function () {
          let value = hiddenField.value;
          if (value) {
            inputField.value = "Rp. " + new Intl.NumberFormat("id-ID").format(value);
          }
        });
      }
  
      // Aktifkan format untuk semua input uang
      formatCurrency("manasik", "manasik_raw");
      formatCurrency("operasional", "operasional_raw");
      formatCurrency("dam", "dam_raw");
    });
  </script>

</x-layout>