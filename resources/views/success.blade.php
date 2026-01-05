<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jakarta Music Festival 2025</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('/images/logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>

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

<body class="bg-master flex items-center justify-center h-screen">
    <div class="text-center p-6 bg-white rounded-xl shadow-lg max-w-md mx-auto">

        <!-- Heading -->
        <h1 class="text-3xl font-bold text-[#fb351b] mb-4 mt-10">Terima Kasih!</h1>

        <!-- Subheading / Message -->
        <p Yclass="text-gray-700 mb-10">
            Berhasil! Data Anda telah berhasil dikirim
        </p>

        <!-- Button to go back -->
        <a href="{{ route('form') }}"
            class="bg-[#fb351b]  text-white font-semibold px-6 py-2 rounded-lg inline-block mt-10">
            Kembali
        </a>
    </div>
</body>

</html>
