<form action="{{ $formAction }}" id="{{ $formId }}" method="POST" class="flex items-end gap-2">
    @method('GET')
    @csrf

    <div class="w-[200px]">
        <x-form.select-two inputName="barang" inputLabel="Tambah Barang">
            <option value=""></option>
            @foreach ($barangs as $barang)
                <option value="{{ $barang->id }}">{{ $barang->kode . ' - ' . $barang->item->nama }}</option>
            @endforeach
        </x-form.select-two>
    </div>


    <button class="p-1 rounded-full bg-[#099AA7] hover:bg-[#099AA7]">
        <svg class="w-7 h-7 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
            height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M5 12h14m-7 7V5" />
        </svg>
    </button>
</form>
