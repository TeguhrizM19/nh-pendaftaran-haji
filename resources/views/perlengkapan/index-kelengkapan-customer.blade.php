<x-layout>
  <div>
    <x-page-title>Perlengkapan</x-page-title>
  </div>

  {{-- Pesan Data Berhasil Disimpan --}}
  @if(session('success'))
    <style>
      .swal-confirm-btn {
        background-color: #099AA7 !important;
        color: #fff !important;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
      }
    </style>

    <script>
      document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
          title: "Berhasil!",
          text: "Data berhasil disimpan!",
          icon: "success",
          confirmButtonText: "OK",
          customClass: {
            confirmButton: 'swal-confirm-btn'
          },
          buttonsStyling: false // penting: matikan styling default SweetAlert
        });
      });
    </script>
  @endif

  <div class="rounded-lg shadow-lg shadow-gray-400 mt-4 p-4">
    <div class="flow-root">
      <dl class="-my-3 mb-5 divide-y divide-gray-200 text-sm *:even:bg-gray-50">
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
    
          <dd class="text-gray-800 font-semibold sm:col-span-5">
            : {{ $gabungHaji->customer->alamat_ktp }}
          </dd>
        </div>

        <div class="grid grid-cols-1 gap-1 p-3 sm:grid-cols-6 sm:gap-4">
          <dt class="font-medium text-gray-900">Tahun Keberangkatan</dt>
    
          <dd class="text-gray-800 font-semibold sm:col-span-5">
            : {{ $gabungHaji->keberangkatan->keberangkatan ?? '-' }}
          </dd>
        </div>
      </dl>

      <form action="{{ route('kelengkapanCustomer.update', $gabungHaji->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="w-full grid grid-cols-1 md:grid-cols-3 gap-7">

          <!-- Kolom Perlengkapan -->
          <div class="mt-3">
            <span class="font-medium text-gray-900 block mb-2">
              Perlengkapan yang sudah dibagikan
            </span>
            <ul class="w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg">
              @foreach ($perlengkapanAktif as $data)
                <li class="w-full border-b border-gray-200 last:border-b-0">
                  <div class="flex items-center ps-3">
                    <input type="checkbox" name="perlengkapan[]" value="{{ $data->id }}"
                      class="w-4 h-4 text-blue-600 bg-gray-300 border-gray-300 focus:ring-blue-500 focus:ring-2"
                      {{ in_array((string) $data->id, (array) $selected_perlengkapan) ? 'checked' : '' }}>
                    <label class="w-full py-3 ms-2 text-sm font-medium text-gray-900">
                      {{ $data->perlengkapan }}
                    </label>
                  </div>
                </li>
              @endforeach
            </ul>
          </div>
        
          <!-- Kolom Dokumen -->
          <div class="mt-3">
            <span class="font-medium text-gray-900 block mb-2">Dokumen</span>
            <ul class="w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg">
              @foreach ($dokumenAktif as $dok)
                <li class="w-full border-b border-gray-200 last:border-b-0">
                  <div class="flex items-center ps-3">
                    <input type="checkbox" name="dokumen[]" value="{{ $dok->id }}"
                      class="w-4 h-4 text-blue-600 bg-gray-300 border-gray-300 focus:ring-blue-500 focus:ring-2"
                      {{ in_array((string) $dok->id, (array) $selected_documents) ? 'checked' : '' }}>
                    <label class="w-full py-3 ms-2 text-sm font-medium text-gray-900">
                      {{ $dok->dokumen }}
                    </label>
                  </div>
                </li>
              @endforeach
            </ul>
          </div>
        </div>

        <div class="w-full flex justify-center mt-6 gap-2">
          <a href="/gabung-haji" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
            Kembali
          </a>
          <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Simpan
          </button>
        </div>
      </form>
    </div>
  </div>

</x-layout>