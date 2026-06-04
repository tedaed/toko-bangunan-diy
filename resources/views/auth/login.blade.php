@extends('layouts.customer')

@section('title', 'Login')

@section('content')

    <div class="max-w-md mx-auto px-6 py-12">

        <div class="bg-white rounded-xl shadow p-6">

            <h1 class="text-3xl font-bold mb-2">Login</h1>
            <p class="text-gray-600 mb-6">
                Masuk sebagai admin atau customer.
            </p>

            @if (session('error'))
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('login.process') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block font-semibold mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded p-2"
                        placeholder="Contoh: admin@tokobangunan.test">

                    @error('email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-semibold mb-1">Password</label>
                    <input type="password" name="password" class="w-full border rounded p-2"
                        placeholder="Masukkan password">

                    @error('password')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded font-bold hover:bg-blue-700">
                    Login
                </button>
            </form>
            <p class="text-center text-sm text-gray-600 mt-6">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-blue-600 font-semibold">
                    Register di sini
                </a>
            </p>

            <div class="mt-6 bg-gray-100 rounded p-4 text-sm text-gray-700">
                <p class="font-bold mb-1">Akun Demo:</p>
                <p>Admin: admin@tokobangunan.test / password123</p>
                <p>Customer: customer@tokobangunan.test / password123</p>
            </div>

        </div>

    </div>

@endsection
