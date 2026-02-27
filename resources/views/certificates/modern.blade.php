<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Certificate</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-br from-blue-900 to-blue-600 min-h-screen flex items-center justify-center">
    <div
        class="relative bg-white w-[1000px] h-[700px] rounded-2xl shadow-xl p-16 overflow-hidden flex flex-col justify-between">
        <!-- Decorative Circles -->
        <div class="absolute w-[400px] h-[400px] bg-blue-600 rounded-full opacity-10 top-[-100px] right-[-100px]"></div>
        <div class="absolute w-[300px] h-[300px] bg-blue-900 rounded-full opacity-10 bottom-[-100px] left-[-100px]">
        </div>

        <!-- Badge -->
        <div
            class="absolute top-16 right-16 bg-blue-600 text-white px-6 py-3 rounded-full font-semibold text-sm shadow-md">
            CERTIFIED</div>

        <!-- Header -->
        <div class="text-center">
            <h1 class="text-5xl font-bold text-blue-900 mb-2">Certificate of Completion</h1>
            <div class="text-lg text-gray-500 mb-8">This certificate is proudly presented to</div>
            <div class="text-4xl font-extrabold text-gray-900 my-10">{{ $name }}</div>
            <div class="text-2xl font-semibold text-blue-600 mb-10">For successfully completing "{{ $course }}"</div>
        </div>

        <!-- Footer -->
        <div class="flex justify-between mt-16">
            <div class="text-center">
                <span class="block text-lg font-medium text-gray-700">Instructor</span>
                <div class="w-48 border-t-2 border-gray-800 mx-auto mt-2"></div>
            </div>
            <div class="text-center">
                <span class="block text-lg font-medium text-gray-700">Director</span>
                <div class="w-48 border-t-2 border-gray-800 mx-auto mt-2"></div>
            </div>
        </div>

        <!-- Date -->
        <div class="text-center mt-10 text-gray-500 text-base">Issued on {{ $date }}</div>
    </div>
</body>

</html>
