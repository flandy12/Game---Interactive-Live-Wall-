<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#006DAE] flex items-center justify-center h-screen">
    <div class="text-center p-6 bg-white rounded-xl shadow-lg max-w-md mx-auto">
      
        <!-- Heading -->
        <h1 class="text-3xl font-bold text-[#006DAE] mb-4 mt-10">Thank You!</h1>

        <!-- Subheading / Message -->
        <p class="text-gray-700 mb-6">
            Your submission has been received successfully. We will get back to you shortly.
        </p>

        <!-- Button to go back -->
        <a href="{{route('form')}}" class="bg-blue-600 hovhoer:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg inline-block">
            Go Back
        </a>
    </div>
</body>

</html>
