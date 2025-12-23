<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monash University</title>
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('/images/logo.png') }}">
    <script src="https://cdn.tiny.cloud/1/kzj5cg1ned34o821ht6p81wlszqmnvx6domizaiswl0xup70/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet" />
    @vite('resources/css/app.css')
</head>

<body>
    <div class="h-screen flex items-center bg-pink-300">
        <form method="POST" action="{{ route('form.submit') }}"
            class="w-full max-w-mde mx-auto p-6 bg-white rounded-xl shadow space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1">Nama</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">

                @error('name')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">

                @error('email')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Pesan</label>
                <textarea name="message" rows="4" value="{{ old('message') }}"
                    class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200"></textarea>
                @error('message')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                Kirim
            </button>
        </form>
    </div>
</body>
