<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="flex flex-col items-center w-full max-w-md">
        <!-- Logo -->
        <img src="{{ asset('assets/logonew.png') }}"
            alt="Logo SD Abu Aziz"
            class="w-32 h-32 mb-4">


        <!-- Nama Sekolah -->
        <div class="text-center mb-6">
            <h3 class="text-xl font-bold">SD ABU AZIZ</h3>
            <p class="text-gray-700">Selamat Datang di Sistem Informasi SD Abu Aziz</p>
        </div>

        <!-- Card Login -->
        <div class="bg-white shadow-lg rounded-xl p-6 w-full">
            @if ($errors->any())
            <div class="bg-red-100 text-red-600 p-2 rounded mb-4">
                {{ $errors->first() }}
            </div>
            @endif

            <form method="POST" action="{{ url('/login') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium">Username</label>
                    <input type="text" name="username" value="{{ old('username') }}"
                        class="w-full border rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium">Password</label>
                    <input type="password" name="password"
                        class="w-full border rounded p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
                    Login
                </button>
            </form>
        </div>
    </div>

</body>

</html>