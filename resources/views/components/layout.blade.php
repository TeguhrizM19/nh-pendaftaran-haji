<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="icon" href="{{ asset('images/nhlogo.png') }}" type="image/png">
  <title>Pendaftaran Haji</title>

  {{-- jquery cdn --}}
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  {{-- tailwind cdn --}}
  <script src="https://cdn.tailwindcss.com"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/4.3.0/apexcharts.min.js" integrity="sha512-QgLS4OmTNBq9TujITTSh0jrZxZ55CFjs4wjK8NXsBoZb04UYl8wWQJNaS8jRiLq6/c60bEfOj3cPsxadHICNfw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/4.3.0/apexcharts.min.css" integrity="sha512-P/8zp3yWsYKLYgykcnVdWono7iWa9VXcoNLFnUhC82oBjt/6z5BIHXTQsMKBgYJjp6K+JAkt4yrID1cxfoUq+g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  {{-- Flowbite CDN --}}
  <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />

  {{-- select2 cdn --}}
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

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

  @vite('resources/css/app.css', 'resources/js/app.js')
    
</head>
<body class="h-screen bg-slate-300">
  {{-- Sidebar --}}
  @include('components.sidebar')
  {{-- Navbar --}}
  @include('components.navbar')

  <main class="mt-20 mx-6 md:mx-10 pb-10">
    {{ $slot }}
  </main>

  <!-- SweetAlert CDN -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

  {{-- Flowbite CDN --}}
  <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>

  {{-- select2 cdn --}}
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</html>
