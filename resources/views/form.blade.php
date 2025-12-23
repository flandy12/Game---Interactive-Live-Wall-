<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Interaktif</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('/images/logo.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=BBH+Bartle&family=Dancing+Script:wght@400..700&family=Luckiest+Guy&display=swap"
        rel="stylesheet">

    <!-- Tailwind -->
    @vite('resources/css/app.css')

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

<body class="overflow-x-hidden">

    <!-- WRAPPER -->
    <div class="min-h-screen flex items-center justify-center bg-master px-4 sm:px-6">

        <!-- FORM -->
        <form method="POST" action="{{ route('form.submit') }}"
            class="w-full max-w-sm sm:max-w-md md:max-w-lg
                   p-4 sm:p-6 md:p-8
                   bg-white rounded-xl shadow-xl space-y-4">

            @csrf

            <!-- TITLE -->
            <h1
                class="text-2xl sm:text-3xl md:text-4xl
                       font-bold mb-4 text-center
                       text-[#5b32b2] luckiest-guy-regular">
                Ceritakan Liburan Kamu Disini ...
            </h1>

            <!-- NAME -->
            <div>
                <label class="block mb-1 text-sm sm:text-base archivo-black-regular text-[#5b32b2]">
                    Nama
                </label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full border border-[#5b32b2] rounded-lg
                           px-3 py-2 text-base sm:text-lg
                           focus:ring focus:ring-blue-200">
                @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- EMAIL -->
            <div>
                <label class="block mb-1 text-sm sm:text-base archivo-black-regular text-[#5b32b2]">
                    Email
                </label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full border border-[#5b32b2] rounded-lg
                           px-3 py-2 text-base sm:text-lg
                           focus:ring focus:ring-blue-200">
                @error('email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- MESSAGE -->
            <div>
                <label class="block mb-1 text-sm sm:text-base archivo-black-regular text-[#5b32b2]">
                    Pesan
                </label>
                <textarea name="message" rows="4"
                    class="w-full border border-[#5b32b2] rounded-lg
                           px-3 py-2 text-base sm:text-lg
                           focus:ring focus:ring-blue-200">{{ old('message') }}</textarea>
                @error('message')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- BUTTON -->
            <button type="submit"
                class="w-full text-xl sm:text-2xl md:text-3xl
                       bg-[#5b32b2] text-white
                       py-2 sm:py-3
                       rounded-lg hover:bg-[#8869d5]
                       transition luckiest-guy-regular">
                Kirim
            </button>

        </form>
    </div>

</body>

</html>
