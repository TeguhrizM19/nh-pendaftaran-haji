<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Login</title>
</head>
<body>
  <div class="min-h-screen bg-gray-100 py-6 flex flex-col justify-center sm:py-12">
    <div class="relative py-3 sm:max-w-xl sm:mx-auto">
      <div class="absolute inset-0 bg-gradient-to-r from-[#52e8f6] to-[#099AA7] shadow-lg transform -skew-y-6 sm:skew-y-0 sm:-rotate-6 sm:rounded-3xl">
      </div>
      <div class="relative px-4 py-10 bg-white shadow-lg sm:rounded-3xl sm:p-20">
        <div class="max-w-md mx-auto">
          <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Login</h1>
          @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
              <ul>
                @foreach ($errors->all() as $item)
                  <li>{{ $item }}</li>
                @endforeach
              </ul>
            </div>
          @endif
          <div class="divide-y divide-gray-200">
            <div class="py-8 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7">
              <form action="/" method="POST" class="space-y-6">
                @csrf
                <div class="relative">
                  <input autocomplete="off" id="username" name="username" type="text" class="peer placeholder-transparent h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-[#099AA7]" placeholder="Username" value="{{ old('username') }}" />
                  <label for="username" class="absolute left-0 -top-3.5 text-gray-600 text-sm peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 transition-all peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">Username</label>
                </div>
                <div class="relative">
                  <input autocomplete="off" id="password" name="password" type="password" class="peer placeholder-transparent h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-[#099AA7]" placeholder="Password" />
                  <label for="password" class="absolute left-0 -top-3.5 text-gray-600 text-sm peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 transition-all peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">Password</label>
                </div>
                <div class="relative">
                  <button type="submit" class="w-full bg-[#099AA7] text-white rounded-md px-4 py-2 font-semibold hover:bg-[#099AA7]/80 transition duration-300">Login</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
</body>
</html>