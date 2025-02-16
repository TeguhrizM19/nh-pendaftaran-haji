<x-layout>
    <div class="py-20 px-5 md:px-10 space-y-4">

        <x-page-header>{{ $header }}</x-page-header>

        <div class="w-full flex flex-col md:flex-row gap-4">
            {{ $slot }}
        </div>
    </div>
</x-layout>
