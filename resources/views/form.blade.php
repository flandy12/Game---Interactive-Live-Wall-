<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jakarta Music Festival 2025</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('/images/logo.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Luckiest+Guy&display=swap"
        rel="stylesheet">

    <!-- Tailwind -->
    @vite('resources/css/app.css')
      <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <style>
        .bg-master {
            background: url('/images/bg.png') center / cover no-repeat;
        }

        .luckiest-guy-regular {
            font-family: "Luckiest Guy", cursive;
        }

        .archivo-black-regular {
            font-family: "Archivo Black", sans-serif;
        }
    </style>
</head>

<body class="overflow-x-hidden bg-black">

    <!-- WRAPPER -->
    <div class="min-h-screen flex items-center justify-center bg-master px-4 sm:px-6 md:px-8 py-12">

        <!-- FORM -->
        <form method="POST" action="{{ route('form.submit') }}"
            class="w-full
                   max-w-sm sm:max-w-md md:max-w-lg lg:max-w-xl
                   p-5 sm:p-6 md:p-8
                   bg-white/90 backdrop-blur
                   rounded-2xl shadow-2xl space-y-4">

            @csrf

            <!-- TITLE -->
            <h1
                class="text-xl sm:text-2xl md:text-2xl
                       text-center font-bold
                       text-[#fb351b] archivo-black-regular">
                Ceritakan Keseruan Malam Tahun baru kamu di Jakarta Music Festival 2025
            </h1>

            <!-- NAME -->
            <div>
                <label class="block mb-1 text-sm sm:text-base archivo-black-regular text-[#fb351b]">
                    Nama
                </label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full border border-[#fb351b] rounded-lg
                           px-3 py-2 text-sm sm:text-base
                           focus:ring focus:ring-blue-200 focus:outline-none">
                @error('name')
                    <span class="text-red-500 text-xs sm:text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- EMAIL -->
            <div>
                <label class="block mb-1 text-sm sm:text-base archivo-black-regular text-[#fb351b]">
                    Email
                </label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full border border-[#fb351b] rounded-lg
                           px-3 py-2 text-sm sm:text-base
                           focus:ring focus:ring-blue-200 focus:outline-none">
                @error('email')
                    <span class="text-red-500 text-xs sm:text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- MESSAGE -->
            <div>
                <label class="block mb-1 text-sm sm:text-base archivo-black-regular text-[#fb351b]">
                    Pesan
                </label>
                <textarea name="message" rows="4"
                    class="w-full border border-[#fb351b] rounded-lg
                           px-3 py-2 text-sm sm:text-base
                           resize-none
                           focus:ring focus:ring-blue-200 focus:outline-none">{{ old('message') }}</textarea>
                @error('message')
                    <span class="text-red-500 text-xs sm:text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- BUTTON -->
            <button type="submit"
                onclick="this.disabled=true; this.innerText='Mengirim...'; this.form.submit();"
                class="w-full
                       text-lg sm:text-xl md:text-2xl
                       bg-[#fb351b] text-white
                       py-2.5 sm:py-3
                       rounded-xl
                       hover:opacity-90
                       transition">
                Kirim
            </button>

        </form>
    </div>

</body>

</html>
