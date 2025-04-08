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

  <div class="mt-4 flex sm:w-auto gap-4">
    <a href="/gabung-haji" class="flex items-center justify-center gap-x-2 rounded-md bg-white px-3 py-2 text-sm font-semibold text-[#099AA7] shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
      <svg class="w-6 h-6 text-gray-800 dark:text-[#099AA7]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4" />
      </svg>
      Kembali
    </a>

    <button data-modal-target="modal-pembayaran" data-modal-toggle="modal-pembayaran" 
      class="px-3 py-2 flex items-center justify-center gap-x-2 rounded-md bg-[#099AA7] text-sm font-semibold text-white shadow-sm hover:bg-[#099AA7]/80 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#099AA7]">
      <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5" />
      </svg>
      Tambah Pembayaran
    </button>
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
    
          <dd class="text-gray-800 font-semibold sm:col-span-5">: {{ $gabungHaji->keberangkatan->keberangkatan ?? '-' }}</dd>
        </div>
      
        <div class="grid grid-cols-1 gap-1 p-3 sm:grid-cols-6 sm:gap-4">
          <dt class="font-medium text-gray-900">Biaya Operasional</dt>
      
          <dd class="text-gray-800 font-semibold sm:col-span-5">: 
            {{ isset($gabungHaji->keberangkatan->operasional) && $gabungHaji->keberangkatan->operasional > 0 
              ? 'Rp ' . number_format($gabungHaji->keberangkatan->operasional, 0, ',', '.') 
              : '-' }}
            <span>|</span>
            @if(isset($gabungHaji->keberangkatan->operasional) && $gabungHaji->keberangkatan->operasional > 0)
              @if($kurangOperasional > 0)
                Kekurangan : Rp {{ number_format($kurangOperasional, 0, ',', '.') }}
              @elseif($lebihOperasional > 0)
                Kelebihan : Rp {{ number_format($lebihOperasional, 0, ',', '.') }}
              @else
                LUNAS
              @endif
            @else
              -
            @endif
          </dd>
        </div>

        <div class="grid grid-cols-1 gap-1 p-3 sm:grid-cols-6 sm:gap-4"> 
          <dt class="font-medium text-gray-900">Biaya Manasik</dt>
      
          <dd class="text-gray-800 font-semibold sm:col-span-5">: 
            {{ isset($gabungHaji->keberangkatan->manasik) && $gabungHaji->keberangkatan->manasik > 0 
              ? 'Rp ' . number_format($gabungHaji->keberangkatan->manasik, 0, ',', '.') 
              : '-' }} 
            <span>|</span>
            @if(isset($gabungHaji->keberangkatan->manasik) && $gabungHaji->keberangkatan->manasik > 0)
              @if($kurangManasik > 0)
                Kekurangan : Rp {{ number_format($kurangManasik, 0, ',', '.') }}
              @elseif($lebihManasik > 0)
                Kelebihan : Rp {{ number_format($lebihManasik, 0, ',', '.') }}
              @else
                LUNAS
              @endif
            @else
              -
            @endif
          </dd>
        </div>
      
        <div class="grid grid-cols-1 gap-1 p-3 sm:grid-cols-6 sm:gap-4">
          <dt class="font-medium text-gray-900">Biaya Dam</dt>
      
          <dd class="text-gray-800 font-semibold sm:col-span-5">: 
            {{ isset($gabungHaji->keberangkatan->dam) && $gabungHaji->keberangkatan->dam > 0 
              ? 'Rp ' . number_format($gabungHaji->keberangkatan->dam, 0, ',', '.') 
              : '-' }}
            <span>|</span>
            @if(isset($gabungHaji->keberangkatan->dam) && $gabungHaji->keberangkatan->dam > 0)
              @if($kurangDam > 0)
                Kekurangan : Rp {{ number_format($kurangDam, 0, ',', '.') }}
              @elseif($lebihDam > 0)
                Kelebihan : Rp {{ number_format($lebihDam, 0, ',', '.') }}
              @else
                LUNAS
              @endif
            @else
              -
            @endif
          </dd>
        </div>
      
        <div class="grid grid-cols-1 gap-1 p-3 sm:grid-cols-6 sm:gap-4">
          <dt class="font-medium text-gray-900">Total Biaya</dt>
      
          <dd class="text-gray-800 font-semibold sm:col-span-5">: 
            {{ isset($totalBiaya) && $totalBiaya > 0 
              ? 'Rp ' . number_format($totalBiaya, 0, ',', '.') 
              : '-' }}
            <span>|</span>
            @if(isset($totalBiaya) && $totalBiaya > 0)
              @if($totalKekurangan > 0)
                Total Kekurangan : Rp {{ number_format($totalKekurangan, 0, ',', '.') }}
              @elseif($totalLebih > 0)
                Total Kelebihan : Rp {{ number_format($totalLebih, 0, ',', '.') }}
              @else
                LUNAS
              @endif
            @else
              -
            @endif
          </dd>
        </div>      
      </dl>
    </div>
  </div>

  <!-- Tabel -->
  <div class="rounded-lg shadow-lg shadow-gray-400 mt-4 p-4"> 
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-5">
      <table class="table-auto w-full text-sm text-left rtl:text-right text-black bg-white border-collapse">
        <thead class="text-xs text-white uppercase bg-[#099AA7]">
          <tr>
            <th scope="col" class="px-2 py-3 text-center">Tanggal</th>
            <th scope="col" class="px-2 py-3">No Kwitansi</th>
            <th scope="col" class="px-4 py-3 w-[300px] sm:w-[360px] md:w-[400px] lg:w-[500px] break-words sm:break-normal overflow-hidden text-ellipsis">Keterangan</th>
            <th scope="col" class="px-2 py-3">Nominal</th>
            <th scope="col" class="px-2 py-3">Admin</th>
            <th scope="col" class="px-2 py-3 text-center">Aksi</th>
          </tr>
        </thead>
        <tbody id="table-body">
          @forelse($pembayaran as $data)
            <tr>
              <td class="px-6 py-4 text-center">{{ \Carbon\Carbon::parse($data->tgl_bayar)->translatedFormat('d-F-Y') }}</td>
              <td class="px-6 py-4">{{ $data->cabang->kode_cab ?? 100 }}{{ $data->kwitansi ?? '-' }}</td>
              <td class="px-6 py-4">{{ $data->keterangan ?? '-' }} {{ $metodeList[$data->metode_bayar] ?? $data->metode_bayar }}</td>
              <td class="px-6 py-4 font-medium text-black whitespace-nowrap"> 
                {{ $data->nominal ? 'Rp. ' . number_format($data->nominal, 0, ',', '.') : '-' }}
              </td>
              <td class="px-6 py-4">{{ $data->create_user }}</td>
              <td class="px-6 py-4 text-center">
                <div class="inline-flex items-center space-x-2">
                  <!-- <button class="font-medium text-blue-600 hover:underline"
                    data-modal-target="modal-edit-{{ $data->id }}" z
                    data-modal-toggle="modal-edit-{{ $data->id }}">
                    <svg class="w-6 h-6 text-green-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                      <path fill-rule="evenodd" d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z" clip-rule="evenodd"/>
                      <path fill-rule="evenodd" d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z" clip-rule="evenodd"/>
                    </svg>
                  </button>
                  <span>|</span> -->
                  <form action="/pembayaran/{{ $data->id }}" method="POST" class="deleteForm inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="deleteButton font-medium text-blue-600 hover:underline bg-transparent border-none p-0 cursor-pointer">
                      <svg class="w-6 h-6 text-red-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd"/>
                      </svg>
                    </button>
                  </form>
                </div>
              </td>
            </tr>

            <!-- Modal Edit Pembayaran -->
            {{-- <div id="modal-edit-{{ $data->id }}" tabindex="-1" aria-hidden="true"
              class="hidden fixed inset-0 z-50 flex justify-center items-center w-full h-full bg-gray-900 bg-opacity-50">
              <div class="relative p-4 w-full max-w-xl max-h-full">
                <div class="relative bg-white rounded-lg shadow-sm">
                  <!-- Modal header -->
                  <div class="flex items-center justify-between p-4 border-b rounded-t border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900">Edit Pembayaran</h3>
                    <button type="button"
                      class="text-gray-400 hover:text-gray-900 bg-transparent hover:bg-gray-200 rounded-lg text-sm w-8 h-8 flex justify-center items-center"
                      data-modal-hide="modal-edit-{{ $data->id }}">
                      <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7L1 13" />
                      </svg>
                      <span class="sr-only">Close modal</span>
                    </button>
                  </div>
                  <!-- Modal body -->
                  <div class="p-4 md:p-5">
                    <form action="{{ route('pembayaran.update', $data->id) }}" method="POST" class="space-y-4">
                      @csrf
                      @method('PUT')
                      <input type="hidden" name="id" value="{{ $data->id }}">

                      <div class="grid gap-4 mb-4 grid-cols-2">
                        <!-- Tanggal Bayar -->
                        <div class="col-span-2 sm:col-span-1">
                          <label class="mb-2 block text-sm font-medium text-[#099AA7]">Tanggal Pembayaran
                            <span class="text-red-500 text-lg">*</span></label>
                          <input type="date" name="tgl_bayar" value="{{ old('tgl_bayar', $data->tgl_bayar) }}"
                            class="bg-gray-100 border-2 border-gray-500 text-gray-900 text-sm rounded-lg focus:ring-[#099AA7] focus:border-[#099AA7] block w-full p-2.5"
                            required />
                        </div>

                        <!-- Metode Bayar -->
                        <div class="col-span-2 sm:col-span-1">
                          <label class="mb-2 block text-sm font-medium text-[#099AA7]">Metode Bayar
                            <span class="text-red-500 text-lg">*</span>
                          </label>
                            <select name="metode_bayar" id="metodeBayar-{{ $data->id }}" data-selected="{{ $data->metode_bayar }}" required
                              class="w-full text-gray-900 bg-gray-100 border-2 border-gray-500 rounded-lg text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                            </select>                    
                        </div>
                      </div>

                      <!-- Nominal -->
                      <div>
                        <label class="mb-2 block text-sm font-medium text-[#099AA7]">Nominal Pembayaran
                          <span class="text-red-500 text-lg">*</span></label>
                        <input type="text" name="nominal" id="nominal-{{ $data->id }}" value="{{ old('nominal', $data->nominal) }}" min="0"
                          class="bg-gray-100 border-2 border-gray-500 text-gray-900 text-sm rounded-lg focus:ring-[#099AA7] focus:border-[#099AA7] block w-full p-2.5"
                          required />
                      </div>

                      <!-- Keterangan -->
                      <div>
                        <label class="mb-2 block text-sm font-medium text-[#099AA7]">Keterangan
                          <span class="text-red-500 text-lg">*</span></label>
                        <textarea rows="3" name="keterangan" id="keterangan-{{ $data->id }}"
                          class="block p-2.5 w-full text-sm text-black bg-gray-100 border-2 border-gray-500 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                          placeholder="Masukkan Keterangan...">{{ old('keterangan', $data->keterangan) }}</textarea>
                      </div>

                      <button type="submit"
                        class="mt-4 w-full text-white bg-[#099AA7] hover:bg-[#099AA7]/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        Simpan Perubahan
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            </div> --}}

            @empty
            <tr>
              <td colspan="6" class="text-center text-red-500 font-semibold py-4">Data Masih Kosong</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- Modal Tambah Pembayaran -->
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
                <input type="date" name="tgl_bayar" value="{{ old('tgl_bayar', date('Y-m-d')) }}" 
                  class="bg-gray-100 border-2 border-gray-500 text-gray-900 text-sm rounded-lg focus:ring-[#099AA7] focus:border-[#099AA7] block w-full p-2.5" 
                  required />
              </div>
              <div class="col-span-2 sm:col-span-1">
                <label class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                  Metode Bayar <span class="text-red-500 text-lg">*</span>
                </label>
                <select name="metode_bayar" id="metodeBayar" required
                  class="w-full text-gray-900 bg-gray-100 border-2 border-gray-500 rounded-lg  shadow-slate-400 text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                </select>
              </div>
            </div>

            <div class="grid grid-cols-1 gap-4 lg:grid-cols-4 lg:gap-2 items-end"> 
              <!-- Dropdown Pilih Biaya -->
              <div class="lg:col-span-3"> 
                <label class="mb-2 block text-sm font-medium leading-6 text-[#099AA7]">
                  Pilih Biaya <span class="text-red-500 text-lg">*</span>
                </label>
                <select id="pilihBiaya" required
                  class="w-full text-gray-900 bg-gray-100 border-2 border-gray-500 rounded-lg shadow-slate-400 text-sm px-3 py-2 focus:ring-blue-300 focus:border-blue-500">
                </select>
              </div>
          
              <!-- Button Tambah -->
              <div>
                <button type="button" id="tambahBtn"
                  class="w-full sm:min-w-[120px] flex items-center justify-center gap-x-2 rounded-md bg-[#099AA7] px-3 py-3 text-sm font-semibold text-white shadow-sm hover:bg-[#099AA7]/80 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#099AA7]">
                  Tambah
                </button>
              </div>
            </div>
          
            <!-- Container untuk menyimpan form nominal yang akan diduplikasi -->
            <div id="formContainer" class="w-full"></div>
          
            <div>
              <label class="block mt-3 mb-2 text-sm font-medium text-[#099AA7]">
                Keterangan <span class="text-red-500 text-lg">*</span>
              </label>
              <textarea rows="3" name="keterangan" id="keterangan" placeholder="Masukkan Keterangan..."
              class="mb-4 block p-2.5 w-full text-sm text-black bg-gray-100 border-2 border-gray-500 rounded-lg focus:ring-blue-500 focus:border-blue-500"></textarea>
              <input type="hidden" name="keterangan" id="hiddenKeterangan">
            </div>
          
            <button type="submit" id="simpanBtn"
            class="mt-4 w-full text-white bg-[#099AA7] hover:bg-[#099AA7]/80 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan</button>
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
    document.querySelectorAll('.deleteButton').forEach(button => {
      button.addEventListener('click', function () {
        // console.log("Tombol hapus diklik!"); // Debug
        Swal.fire({
          title: "Yakin ingin menghapus?",
          text: "Data yang dihapus tidak dapat dikembalikan!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#d33",
          cancelButtonColor: "#3085d6",
          confirmButtonText: "Ya, hapus!",
          cancelButtonText: "Batal"
        }).then((result) => {
        if (result.isConfirmed) {
            console.log("Mengirim form..."); // Debug
            this.closest("form").submit();
          }
        });
      });
    });

    // API Metode Bayar Tambah Pembayaran
    document.addEventListener("DOMContentLoaded", function () {
      let metodeSelect = document.getElementById("metodeBayar");
      let keteranganInput = document.getElementById("keterangan");
      let hiddenKeterangan = document.getElementById("hiddenKeterangan");
      let simpanBtn = document.getElementById("simpanBtn");

      // Fetch data metode bayar dari API
      fetch("https://dana.itnh.systems/api/akunhaji.php")
        .then((response) => response.json())
        .then((data) => {
          let tempDiv = document.createElement("div");
          tempDiv.innerHTML = data.metodeOptions;

          let options = tempDiv.querySelectorAll("option");
          options.forEach((option) => {
            let value = option.value;
            let text = option.textContent.trim(); // Ambil teks option saja

            let newOption = document.createElement("option");
            newOption.value = value;
            newOption.textContent = text;

            metodeSelect.appendChild(newOption);
          });
        })
        .catch((error) => console.error("Error fetching data:", error));

      // Event listener saat tombol simpan diklik
      simpanBtn.addEventListener("click", function () {
        let keteranganValue = keteranganInput.value.trim();

        // Set nilai textarea ke input hidden tanpa tambahan metode bayar
        hiddenKeterangan.value = keteranganValue;
      });
    });

    // Pilihan Biaya
    document.addEventListener("DOMContentLoaded", function () { 
      fetch("https://dana.itnh.systems/api/akunhaji.php")
      .then(response => response.json())
      .then(data => {
        let biayaSelect = document.getElementById("pilihBiaya");
        let tambahBtn = document.getElementById("tambahBtn");
        let formContainer = document.getElementById("formContainer"); // Tempat menyimpan form yang diduplikasi

        // Buat elemen div untuk menyimpan sementara opsi dari API
        let tempDiv = document.createElement("div");
        tempDiv.innerHTML = data.biayaOptions;

        // Ambil semua elemen <option> dari tempDiv dan tambahkan ke <select>
        let options = tempDiv.querySelectorAll("option");
        options.forEach(option => {
          biayaSelect.appendChild(option);
        });

        // Event listener untuk tombol tambah
        tambahBtn.addEventListener("click", function () {
          let selectedOptionText = biayaSelect.options[biayaSelect.selectedIndex].text;
          let selectedOptionValue = biayaSelect.value; // Ambil value, bukan text

          if (selectedOptionValue !== "") {
            // Buat elemen div baru untuk form nominal yang diduplikasi
            let newNominalForm = document.createElement("div");
            newNominalForm.className = "col-span-2 sm:col-span-1 flex items-center gap-2";
            newNominalForm.innerHTML = `
              <div class="grid grid-cols-1 gap-4 lg:grid-cols-9 lg:gap-2 items-end">
                <div class="lg:col-span-8"> 
                  <label class="relative flex-grow">
                    Nominal <span class="text-[#099AA7] font-semibold">(${selectedOptionText})</span>

                    <div class="relative">
                      <input type="text" name="formatted_nominal[]" placeholder="Masukkan nominal" required 
                      class="my-2 w-full border-gray-300 pe-8 bg-gray-100 border-2 border-gray-500 rounded-lg shadow-sm sm:text-sm format-rupiah" />

                      <input type="hidden" name="nominal[]" class="nominal-hidden">
                      <input type="hidden" name="pilihan_biaya[]" value="${selectedOptionValue}">
                    </div>
                  </label>
                </div>

                <div>
                    <button type="button" class="hapus-btn my-2 w-12 h-9 flex items-center justify-center rounded-md bg-red-500 text-white shadow-sm hover:bg-red-600">
                      Hapus
                    </button>
                </div>
              </div>
            `;

            // Tambahkan form yang baru dibuat ke dalam container
            formContainer.appendChild(newNominalForm);

            // Tambahkan event listener untuk tombol hapus di dalam form yang baru
            newNominalForm.querySelector(".hapus-btn").addEventListener("click", function () {
              newNominalForm.remove(); // Hapus form nominal yang diklik
            });

            // Ambil input dan formatkan angka
            let inputFormatted = newNominalForm.querySelector(".format-rupiah");
            let inputHidden = newNominalForm.querySelector(".nominal-hidden");

            inputFormatted.addEventListener("input", function (e) {
              let value = e.target.value.replace(/\D/g, ""); // Hanya angka
              let formatted = new Intl.NumberFormat("id-ID").format(value);

              inputFormatted.value = `Rp. ${formatted}`;
              inputHidden.value = value; // Simpan angka asli tanpa format
            });
          } else {
            alert("Silakan pilih biaya terlebih dahulu!");
          }
        });
      })
      .catch(error => console.error("Error fetching data:", error));
    });

    // // API Metode Bayar Edit Pembayaran
    // document.addEventListener("DOMContentLoaded", function () {
    //   fetch("https://dana.itnh.systems/api/akunhaji.php")
    //     .then((response) => response.json())
    //     .then((data) => {
    //       let tempDiv = document.createElement("div");
    //       tempDiv.innerHTML = data.metodeOptions;
    //       let options = tempDiv.querySelectorAll("option");

    //       const allMetodeSelects = document.querySelectorAll('[id^="metodeBayar-"]');

    //       allMetodeSelects.forEach(select => {
    //         const selectedValue = select.dataset.selected;

    //         options.forEach(option => {
    //           const exists = Array.from(select.options).some(
    //             o => o.value === option.value
    //           );

    //           if (!exists) {
    //             const newOption = document.createElement("option");
    //             newOption.value = option.value;
    //             newOption.textContent = option.textContent.trim();

    //             if (option.value === selectedValue) {
    //               newOption.selected = true;
    //             }

    //             select.appendChild(newOption);
    //           }
    //         });

    //         // Pasang event listener untuk update keterangan secara otomatis
    //         const id = select.id.split("-")[1];
    //         const textarea = document.getElementById(`keterangan-${id}`);
    //         const simpanBtn = document.getElementById(`simpanEditBtn-${id}`);

    //         if (textarea && simpanBtn) {
    //           select.addEventListener("change", function () {
    //             let metodeBayarText = select.options[select.selectedIndex].text;
    //             let currentText = textarea.value.trim();

    //             options.forEach(opt => {
    //               const optText = opt.textContent.trim();
    //               const regex = new RegExp(`\\s*${optText}$`);
    //               currentText = currentText.replace(regex, "");
    //             });

    //             let updatedText = currentText ? `${currentText} ${metodeBayarText}` : metodeBayarText;
    //             textarea.value = updatedText;
    //           });

    //           simpanBtn.addEventListener("click", function () {
    //             let metodeBayarText = select.options[select.selectedIndex].text;
    //             let currentText = textarea.value.trim();

    //             options.forEach(opt => {
    //               const optText = opt.textContent.trim();
    //               const regex = new RegExp(`\\s*${optText}$`);
    //               currentText = currentText.replace(regex, "");
    //             });

    //             let finalText = currentText ? `${currentText} ${metodeBayarText}` : metodeBayarText;
    //             textarea.value = finalText;
    //           });
    //         }
    //       });

    //       // === FORMAT RUPIAH UNTUK INPUT NOMINAL ===

    //       // Fungsi format ke Rupiah
    //       function formatRupiah(angka, prefix = "Rp. ") {
    //         let number_string = angka.replace(/[^,\d]/g, "").toString();
    //         let split = number_string.split(",");
    //         let sisa = split[0].length % 3;
    //         let rupiah = split[0].substr(0, sisa);
    //         let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    //         if (ribuan) {
    //           let separator = sisa ? "." : "";
    //           rupiah += separator + ribuan.join(".");
    //         }

    //         rupiah = split[1] !== undefined ? rupiah + "," + split[1] : rupiah;
    //         return prefix + rupiah;
    //       }

    //       // Terapkan format rupiah ke semua input nominal
    //       document.querySelectorAll('[id^="nominal-"]').forEach((input) => {
    //         input.addEventListener("keyup", function () {
    //           input.value = formatRupiah(this.value);
    //         });

    //         // Format isi awal
    //         input.value = formatRupiah(input.value);
    //       });
    //       // === END RUPIAH FORMAT ===

    //     })
    //     .catch(error => console.error("Error fetching metode bayar:", error));
    // });



       
  </script>

</x-layout>