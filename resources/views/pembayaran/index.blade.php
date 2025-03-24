<x-layout>
  <div>
    <x-page-title>Pembayaran</x-page-title>
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

  <div class="mt-4 flex sm:w-auto">
    <a href="/gabung-haji" class="flex items-center justify-center gap-x-2 rounded-md bg-white px-3 py-2 text-sm font-semibold text-[#099AA7] shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
      <svg class="w-6 h-6 text-gray-800 dark:text-[#099AA7]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4" />
      </svg>
      Kembali
    </a>
  </div>

  <div class="rounded-lg shadow-lg shadow-gray-400 mt-4 p-4">
    <div class="flow-root">
      <dl class="-my-3 divide-y divide-gray-200 text-sm *:even:bg-gray-50">
        <div class="grid grid-cols-1 gap-1 p-3 sm:grid-cols-6 sm:gap-4">
          <dt class="font-medium text-gray-900">Nama</dt>
    
          <dd class="text-gray-800 font-semibold sm:col-span-2">: {{ $gabungHaji->customer->nama }}</dd>
        </div>

        <div class="grid grid-cols-1 gap-1 p-3 sm:grid-cols-6 sm:gap-4">
          <dt class="font-medium text-gray-900">No Porsi Haji</dt>
    
          <dd class="text-gray-800 font-semibold sm:col-span-2">
            @if (!empty($gabungHaji->no_porsi))
              : {{ $gabungHaji->no_porsi ?? '-' }}
            @elseif (!empty($gabungHaji->daftarHaji) && !empty($gabungHaji->daftarHaji->no_porsi_haji))
              : {{ $gabungHaji->daftarHaji->no_porsi_haji ?? '-' }}
            @else
              : -
            @endif
          </dd>
        </div>
    
        <div class="grid grid-cols-1 gap-1 p-3 sm:grid-cols-6 sm:gap-4">
          <dt class="font-medium text-gray-900">Alamat</dt>
    
          <dd class="text-gray-800 font-semibold sm:col-span-5">: {{ $gabungHaji->customer->alamat_ktp }}</dd>
        </div>

        <div class="grid grid-cols-1 gap-1 p-3 sm:grid-cols-6 sm:gap-4">
          <dt class="font-medium text-gray-900">Tahun Keberangkatan</dt>
    
          <dd class="text-gray-800 font-semibold sm:col-span-5">: {{ $gabungHaji->keberangkatan->keberangkatan }}</dd>
        </div>

        <!-- Biaya -->
        <div class="overflow-x-auto">
          <table class="w-full flex flex-row flex-no-wrap sm:bg-white rounded-lg overflow-hidden sm:shadow-lg my-5">
            <thead class="text-white">
              <tr class="bg-[#099AA7] flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0">
                <th class="p-3 text-left sm:w-[180px] md:w-[200px] lg:w-[250px]">Biaya Manasik</th>
                <th class="p-3 text-left sm:w-[180px] md:w-[200px] lg:w-[250px]">Biaya Operasional</th>
                <th class="p-3 text-left sm:w-[180px] md:w-[200px] lg:w-[250px]">Biaya Dam</th>
                <th class="p-3 text-left sm:w-[180px] md:w-[200px] lg:w-[250px]">Total Biaya</th>
              </tr>
            </thead>
            <tbody class="flex-1 sm:flex-none">
              <tr class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0">
                <td class="border-grey-light border font-semibold hover:bg-gray-100 p-3" data-title="Biaya Manasik">
                  {{ $gabungHaji->keberangkatan->manasik ? 'Rp ' . number_format($gabungHaji->keberangkatan->manasik, 0, ',', '.') : '-' }}
                </td>
                <td class="border-grey-light border font-semibold hover:bg-gray-100 p-3" data-title="Biaya Operasional">
                  {{ $gabungHaji->keberangkatan->operasional ? 'Rp ' . number_format($gabungHaji->keberangkatan->operasional, 0, ',', '.') : '-' }}
                </td>
                <td class="border-grey-light border font-semibold hover:bg-gray-100 p-3" data-title="Biaya Dam">
                  {{ $gabungHaji->keberangkatan->dam ? 'Rp ' . number_format($gabungHaji->keberangkatan->dam, 0, ',', '.') : '-' }}
                </td>
                <td class="border-grey-light border font-semibold hover:bg-gray-100 p-3" data-title="Total Biaya">
                  {{ $totalBiaya > 0 ? 'Rp ' . number_format($totalBiaya, 0, ',', '.') : '-' }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Pembayaran -->
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y-2 divide-gray-200 w-full flex flex-row flex-no-wrap sm:bg-white rounded-lg overflow-hidden sm:shadow-lg my-5">
            <thead class="ltr:text-left rtl:text-right bg-[#099AA7] text-white">
              <tr class="flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0">
                <th class="p-3 text-left sm:w-[180px] md:w-[200px] lg:w-[250px]">Pembayaran Manasik</th>
                <th class="p-3 text-left sm:w-[180px] md:w-[200px] lg:w-[250px]">Pembayaran Operasional</th>
                <th class="p-3 text-left sm:w-[180px] md:w-[200px] lg:w-[250px]">Pembayaran Dam</th>
                <th class="p-3 text-left sm:w-[180px] md:w-[200px] lg:w-[250px]">Total Yang Sudah Dibayar</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 flex-1 sm:flex-none">
              <tr class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0">
                <td class="p-3 font-semibold" data-title="Pembayaran Manasik">
                  {{ $totalDibayarManasik ? 'Rp ' . number_format($totalDibayarManasik, 0, ',', '.') : '-' }}
                </td>
                <td class="p-3 font-semibold" data-title="Pembayaran Operasional">
                  {{ $totalDibayarOperasional ? 'Rp ' . number_format($totalDibayarOperasional, 0, ',', '.') : '-' }}
                </td>
                <td class="p-3 font-semibold" data-title="Pembayaran Dam">
                  {{ $totalDibayarDam ? 'Rp ' . number_format($totalDibayarDam, 0, ',', '.') : '-' }}
                </td>
                <td class="p-3 font-semibold" data-title="Total Yang Sudah Dibayar">
                  {{ $totalDibayar ? 'Rp ' . number_format($totalDibayar, 0, ',', '.') : '-' }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      
        <!-- Kekurangan -->
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y-2 divide-gray-200 w-full flex flex-row flex-no-wrap sm:bg-white rounded-lg overflow-hidden sm:shadow-lg my-5">
            <thead class="ltr:text-left rtl:text-right bg-[#099AA7] text-white">
              <tr class="flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0">
                <th class="p-3 text-left sm:w-[180px] md:w-[200px] lg:w-[250px]">Kekurangan Manasik</th>
                <th class="p-3 text-left sm:w-[180px] md:w-[200px] lg:w-[250px]">Kekurangan Operasional</th>
                <th class="p-3 text-left sm:w-[180px] md:w-[200px] lg:w-[250px]">Kekurangan Dam</th>
                <th class="p-3 text-left sm:w-[180px] md:w-[200px] lg:w-[250px]">Total Kekurangan</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 flex-1 sm:flex-none">
              <tr class="flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0">
                <td class="p-3 font-semibold" data-title="Kekurangan Manasik">
                  @if(isset($gabungHaji->keberangkatan->manasik) && $gabungHaji->keberangkatan->manasik > 0)
                    {{ $kurangManasik > 0 ? 'Rp ' . number_format($kurangManasik, 0, ',', '.') : 'Lunas' }}
                  @else
                    -
                  @endif
                </td>
                  <td class="p-3 font-semibold" data-title="Kekurangan Operasional">
                  @if(isset($gabungHaji->keberangkatan->operasional) && $gabungHaji->keberangkatan->operasional > 0)
                    {{ $kurangOperasional > 0 ? 'Rp ' . number_format($kurangOperasional, 0, ',', '.') : 'Lunas' }}
                  @else
                    -
                  @endif
                </td>
                <td class="p-3 font-semibold" data-title="Kekurangan Dam">
                  @if(isset($gabungHaji->keberangkatan->dam) && $gabungHaji->keberangkatan->dam > 0)
                    {{ $kurangDam > 0 ? 'Rp ' . number_format($kurangDam, 0, ',', '.') : 'Lunas' }}
                  @else
                    -
                  @endif
                </td>
                <td class="p-3 font-semibold" data-title="Total Kekurangan">
                  @if(is_null($totalKekurangan))
                    -
                  @elseif($totalKekurangan == 0)
                    Lunas
                  @else
                    Rp {{ number_format($totalKekurangan, 0, ',', '.') }}
                  @endif
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </dl>
    </div>
  </div>

  <!-- Tabel -->
  <div class="rounded-lg shadow-lg shadow-gray-400 mt-4 p-4">
    <div class="mt-4 flex sm:w-auto">
      <button data-modal-target="modal-pembayaran" data-modal-toggle="modal-pembayaran" 
      class="px-3 py-2 flex items-center justify-center gap-x-2 rounded-md bg-[#099AA7] text-sm font-semibold text-white shadow-sm hover:bg-[#099AA7]/80 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#099AA7]">
      <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5" />
      </svg>
      Tambah Pembayaran
    </button>
    </div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-5">
      <table class="table-auto w-full text-sm text-left rtl:text-right text-black bg-white border-collapse">
        <thead class="text-xs text-white uppercase bg-[#099AA7]">
          <tr>
            <th scope="col" class="px-2 py-3 text-center">Tanggal</th>
            <th scope="col" class="px-2 py-3">No Kwitansi</th>
            <th scope="col" class="px-4 py-3 w-[150px] sm:w-[180px] md:w-[200px] lg:w-[250px] break-words sm:break-normal overflow-hidden text-ellipsis">
              Keterangan
            </th>
            <th scope="col" class="px-2 py-3">Manasik</th>
            <th scope="col" class="px-2 py-3">Operasional</th>
            <th scope="col" class="px-2 py-3">Dam</th>
            <th scope="col" class="px-2 py-3">Admin</th>
            <th scope="col" class="px-2 py-3">Aksi</th>
          </tr>
        </thead>
        <tbody id="table-body">
          @forelse($pembayaran as $data)
            <tr>
              <th scope="row" class="px-6 py-4 font-medium text-center text-black whitespace-nowrap">
                {{ $data->tgl_bayar ? \Carbon\Carbon::parse($data->tgl_bayar)->translatedFormat('d-F-Y') : '-' }}
              </th>
              <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap">
                {{ $data->kwitansi ?? '-' }}
              </th>
              <th scope="col" class="px-6 py-4 font-medium w-[150px] sm:w-[180px] md:w-[200px] lg:w-[250px] break-words sm:break-normal overflow-hidden text-ellipsis">
                {{ $data->keterangan ?? '-' }}
              </th>
              <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap">
                {{ $data->manasik ? 'Rp. ' . number_format($data->manasik, 0, ',', '.') : '-'  }}
              </th>
              <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap">
                {{ $data->operasional ? 'Rp. ' . number_format($data->operasional, 0, ',', '.') : '-'  }}
              </th>
              <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap">
                {{ $data->dam ? 'Rp. ' . number_format($data->dam, 0, ',', '.') : '-'  }}
              </th>
              <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap">
                -
              </th>
              <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap">
                <form action="/pembayaran/{{ $data->id }}" method="POST" class="deleteForm inline-block">
                @method('DELETE')
                @csrf
                <button type="submit" class="font-medium text-blue-600 hover:underline bg-transparent border-none p-0 cursor-pointer" alt="Delete">
                  <svg class="w-6 h-6 text-red-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd"/>
                  </svg>
                </button>
                </form>
              </th>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center text-red-500 font-semibold py-4">Data Masih Kosong</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- Modal Pembayaran -->
  <div id="modal-pembayaran" tabindex="-1" aria-hidden="true" 
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-xl max-h-full">
      <!-- Modal content -->
      <div class="relative bg-white rounded-lg shadow-sm">
        <!-- Modal header -->
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
          <h3 class="text-xl font-semibold text-gray-900">
            Masukkan Pembayaran
          </h3>
          <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="modal-pembayaran">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
            <span class="sr-only">Close modal</span>
          </button>
        </div>
        <!-- Modal body -->
        <div class="p-4 md:p-5">
          <form action="/pembayaran/{{ $gabungHaji->id }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid gap-4 mb-4 grid-cols-2">
              <div class="col-span-2 sm:col-span-1">
                <label class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                  Tanggal Pembayaran <span class="text-red-500 text-lg">*</span>
                </label>
                <input type="date" name="tgl_bayar" value="{{ old('tgl_bayar') }}"
                class="bg-gray-100 border-2 border-gray-500 text-gray-900 text-sm rounded-lg focus:ring-[#099AA7] focus:border-[#099AA7] block w-full p-2.5" required />
              </div>
              <div class="col-span-2 sm:col-span-1">
                <label class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                  Metode Bayar <span class="text-red-500 text-lg">*</span>
                </label>
                <select name="metode_bayar" required
                  class="w-full text-gray-900 bg-gray-100 border-2 border-gray-500 rounded-lg  shadow-slate-400 text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                  <option value="">Pilih</option>
                  <option value="Tunai" {{ old('metode_bayar') == 'Tunai' ? 'selected' : '' }}>Tunai</option>
                  <option value="CIMB Niaga" {{ old('metode_bayar') == 'CIMB Niaga' ? 'selected' : '' }}>CIMB Niaga</option>
                  <option value="BCA" {{ old('metode_bayar') == 'BCA' ? 'selected' : '' }}>BCA</option>
                </select>   
              </div>
            </div>
            <div class="grid gap-4 mb-4 grid-cols-3">
              <div class="col-span-2 sm:col-span-1">
                <label class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                  Manasik
                </label>
                <input type="text" name="manasik" class="manasik bg-gray-100 border-2 border-gray-500 text-gray-900 text-sm rounded-lg focus:ring-[#099AA7] focus:border-[#099AA7] block w-full p-2.5" placeholder="Masukkan Nominal" />
                <input type="hidden" name="manasik_raw" class="manasik_raw">
              </div>
              
              <div class="col-span-2 sm:col-span-1">
                <label class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                  Operasional
                </label>
                <input type="text" name="operasional" class="operasional bg-gray-100 border-2 border-gray-500 text-gray-900 text-sm rounded-lg focus:ring-[#2d4a4d] focus:border-[#099AA7] block w-full p-2.5" placeholder="Masukkan Nominal" />
                <input type="hidden" name="operasional_raw" class="operasional_raw">
              </div>
              
              <div class="col-span-2 sm:col-span-1">
                <label class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                  Dam
                </label>
                <input type="text" name="dam" class="dam bg-gray-100 border-2 border-gray-500 text-gray-900 text-sm rounded-lg focus:ring-[#099AA7] focus:border-[#099AA7] block w-full p-2.5" placeholder="Masukkan Nominal" />
                <input type="hidden" name="dam_raw" class="dam_raw">
              </div>
            </div>

            <div class="grid gap-4 mb-4 grid-cols-3">
              <div class="col-span-2 sm:col-span-1">
                <label class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                  Kwitansi
                </label>
                <input type="text" name="kwitansi" value="Otomatis" readonly
                class="bg-gray-100 border-2 border-gray-500 text-gray-900 text-sm rounded-lg focus:ring-[#099AA7] focus:border-[#099AA7] block w-full p-2.5" placeholder="Masukkan Nominal" />
              </div>
              
              <div class="col-span-2 sm:col-span-1">
                <label class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                  Pada Akun
                </label>
                <input type="text" class="operasional bg-gray-100 border-2 border-gray-500 text-gray-900 text-sm rounded-lg focus:ring-[#2d4a4d] focus:border-[#099AA7] block w-full p-2.5" readonly placeholder="Akun Otomatis" />
              </div>
            </div>

            <div>
              <label class="block mt-3 mb-2 text-sm font-medium text-[#099AA7]">
                Keterangan <span class="text-red-500 text-lg">*</span>
              </label>
              <textarea rows="3" name="keterangan"
              class="mb-4 block p-2.5 w-full text-sm text-black bg-gray-100 border-2 border-gray-500 rounded-lg focus:ring-blue-500 focus:border-blue-500" 
              placeholder="Masukkan Keterangan..."></textarea>
            </div>
            <button type="submit" class="mt-4 w-full text-white bg-[#099AA7] hover:bg-[#099AA7]/80 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <style>
    @media (min-width: 640px) {
      table {
        display: inline-table !important;
      }

      thead tr:not(:first-child) {
        display: none;
      }
    }

    td:not(:last-child) {
      border-bottom: 0;
    }

    th:not(:last-child) {
      border-bottom: 2px solid rgba(0, 0, 0, .1);
    }

    @media (max-width: 640px) {
      td {
        padding-left: 1rem !important; /* Tambahkan padding kiri */
        position: relative;
      }

      td:before {
        content: none; /* Sembunyikan judul kolom */
      }
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

    // Format Currency
    document.addEventListener("DOMContentLoaded", function () {
      function formatCurrency(inputClass, hiddenClass) {
        let inputFields = document.querySelectorAll("." + inputClass);
        let hiddenFields = document.querySelectorAll("." + hiddenClass);

        inputFields.forEach((inputField, index) => {
          let hiddenField = hiddenFields[index];

          function updateHiddenField() {
            let rawValue = inputField.value.replace(/\D/g, ""); // Hanya angka
            hiddenField.value = rawValue;
          }

          inputField.addEventListener("input", function () {
            updateHiddenField();
            let value = inputField.value.replace(/\D/g, "");
            inputField.value = value ? "Rp. " + new Intl.NumberFormat("id-ID").format(value) : "";
          });

          inputField.addEventListener("focus", function () {
            inputField.value = hiddenField.value; // Tampilkan angka asli saat fokus
          });

          inputField.addEventListener("blur", function () {
            let value = hiddenField.value;
            inputField.value = value ? "Rp. " + new Intl.NumberFormat("id-ID").format(value) : "";
          });

          // Pastikan hidden input diperbarui sebelum submit
          document.querySelector("form").addEventListener("submit", function () {
            updateHiddenField();
          });
        });
      }

      formatCurrency("manasik", "manasik_raw");
      formatCurrency("operasional", "operasional_raw");
      formatCurrency("dam", "dam_raw");
    });
  </script>

</x-layout>