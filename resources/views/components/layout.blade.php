<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('images/nhlogo.png') }}" type="image/png">
    <title>Pendaftaran Haji</title>

    @vite('resources/css/app.css', 'resources/js/app.js')

    {{-- jquery cdn --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- <script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script> --}}

    {{-- Flowbite CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    {{-- <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" /> --}}

    {{-- select2 cdn --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    {{-- Data Table Style --}}
    <Style>
        /* === Styling Form Pencarian === */
        .dataTables_filter {
        display: flex;
        align-items: center;
        gap: 8px;
        }

        .dataTables_filter input {
        background-color: #f3f4f6 !important; /* Abu-abu muda (sama seperti dropdown) */
        color: #374151 !important; /* Abu-abu tua */
        border: 1px solid #6b7280 !important; /* Warna border abu-abu */
        padding: 8px 12px;
        border-radius: 6px;
        width: 200px; /* Ukuran input agar seimbang */
        }

        /* Placeholder pada input pencarian */
        .dataTables_filter input::placeholder {
        color: #6b7280 !important; /* Warna placeholder abu-abu */
        }

        /* Styling dropdown "Tampilkan" */
        .dataTables_length {
        position: relative;
        display: flex;
        align-items: center;
        }

        .dataTables_length select {
        background-color: #f3f4f6 !important; /* Abu-abu muda */
        color: #374151 !important; /* Abu-abu tua */
        border: 1px solid #6b7280 !important; /* Warna border abu-abu */
        padding: 8px 32px 8px 12px; /* Tambahkan padding kanan agar panah tidak menimpa teks */
        border-radius: 6px;
        appearance: none; /* Hilangkan tampilan default browser */
        cursor: pointer;
        width: auto;
        }

        /* Tambahkan panah dropdown custom */
        .dataTables_length::after {
        font-size: 14px;
        color: #374151; /* Warna panah */
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
        }

        /* Placeholder atau teks dalam dropdown */
        .dataTables_length select option {
        background-color: #f3f4f6 !important;
        color: #374151 !important;
        }
    </Style>

    {{-- select2 style --}}
    <style>
        .select2-container .select2-selection--single {
            height: 38px !important; /* Sesuaikan tinggi */
            border: 1px solid #d1d5db !important; /* Border agar sama dengan Tailwind */
            border-radius: 0.5rem !important; /* Border rounded */
            padding: 0.5rem !important; /* Padding */
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #374151 !important; /* Warna teks */
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 38px !important; /* Sesuaikan tinggi */
        }
    </style>

    {{-- custom scrollbar style --}}
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
            /* Width of the vertical scrollbar */
            height: 8px;
            /* Height of the horizontal scrollbar */
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #099AA7;
            /* Thumb color */
            border-radius: 10px;
            /* Rounded corners for the thumb */
            border: 2px solid #fff;
            /* Border around the thumb */
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            /* Track color */
            border-radius: 10px;
        }
    </style>
    
</head>
<body class="h-screen bg-white">
    {{-- Sidebar --}}
    @include('components.sidebar')
    {{-- Navbar --}}
    @include('components.navbar')

    <main class="mt-20 mx-6 md:mx-10 pb-10">
    {{ $slot }}
    </main>

    <!-- SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
</body>


    {{-- loading indicator modal trigger script --}}
    {{-- <script>
        function showLoadingModal() {
            document.getElementById('loading-modal').classList.remove('hidden');
        }
    </script> --}}



    {{-- select2 cdn --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{-- tailwind cdn --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Flowbite CDN --}}
    
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

    {{-- Data Table CDN --}}
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>

</html>
