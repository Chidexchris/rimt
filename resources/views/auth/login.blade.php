<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | {{ config('app.name') }}</title>
    <link rel="icon" href="{{ asset('images/favicon.png') }}">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="bg-gradient-to-r from-blue-600 to-indigo-700 min-h-screen flex items-center justify-center">

<div class="w-full max-w-md mx-auto">
    <div class="flex justify-center mb-8">
        <img class="w-40" src="{{ asset('images/logo_dark.png') }}" alt="Logo">
    </div>

    @if(Session::has('account_deactivated'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
            {{ Session::get('account_deactivated') }}
        </div>
    @endif

    <div class="bg-white shadow-lg rounded-lg p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Welcome Back</h2>
        <p class="text-gray-500 mb-6">Sign in to your account</p>

        <form id="login" method="POST" action="{{ url('/login') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 mb-1" for="email">Email</label>
                <div class="flex items-center border rounded-lg overflow-hidden focus-within:ring-2 ring-blue-400">
                    <span class="px-3 text-gray-400"><i class="bi bi-person"></i></span>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                           placeholder="Enter your email"
                           class="w-full px-3 py-2 focus:outline-none @error('email') border-red-500 @enderror">
                </div>
                @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 mb-1" for="password">Password</label>
                <div class="flex items-center border rounded-lg overflow-hidden focus-within:ring-2 ring-blue-400">
                    <span class="px-3 text-gray-400"><i class="bi bi-lock"></i></span>
                    <input id="password" type="password" name="password"
                           placeholder="Enter your password"
                           class="w-full px-3 py-2 focus:outline-none @error('password') border-red-500 @enderror">
                </div>
                @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between mb-6">
                <button id="submit" type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded flex items-center">
                    Login
                    <div id="spinner" class="spinner-border text-white ml-2 hidden w-5 h-5 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                </button>
                <a href="{{ route('password.request') }}" class="text-blue-600 hover:underline text-sm">Forgot password?</a>
            </div>
        </form>

        <p class="text-center text-gray-500 text-sm mt-4">
            Developed by <a href="#" class="font-semibold text-blue-600">Deratech</a>
        </p>
    </div>
</div>

<script>
    let login = document.getElementById('login');
    let submit = document.getElementById('submit');
    let email = document.getElementById('email');
    let password = document.getElementById('password');
    let spinner = document.getElementById('spinner');

    login.addEventListener('submit', (e) => {
        submit.disabled = true;
        email.readOnly = true;
        password.readOnly = true;
        spinner.classList.remove('hidden');
    });

    setTimeout(() => {
        submit.disabled = false;
        email.readOnly = false;
        password.readOnly = false;
        spinner.classList.add('hidden');
    }, 3000);
</script>
</body>
</html>
