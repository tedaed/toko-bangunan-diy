@extends('layouts.customer')

@section('title', 'Register')

@section('content')

<div class="max-w-md mx-auto px-6 py-12">

    <div class="bg-white rounded-xl shadow p-6">

        <h1 class="text-3xl font-bold mb-2">Register</h1>
        <p class="text-gray-600 mb-6">
            Buat akun customer untuk melakukan checkout dan melihat status pesanan.
        </p>

        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('register.process') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block font-semibold mb-1">
                    Nama <span class="text-red-600">*</span>
                </label>

                <input type="text"
                       name="name"
                       value="{{ old('name') }}"
                       class="w-full border rounded p-2"
                       placeholder="Masukkan nama lengkap">
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">
                    Email <span class="text-red-600">*</span>
                </label>

                <input type="email"
                       name="email"
                       value="{{ old('email') }}"
                       class="w-full border rounded p-2"
                       placeholder="contoh@email.com">
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">
                    Password <span class="text-red-600">*</span>
                </label>

                <input type="password"
                       name="password"
                       class="w-full border rounded p-2"
                       placeholder="Minimal 6 karakter">
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">
                    Konfirmasi Password <span class="text-red-600">*</span>
                </label>

                <input type="password"
                       name="password_confirmation"
                       class="w-full border rounded p-2"
                       placeholder="Ulangi password">
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 text-white py-3 rounded font-bold hover:bg-blue-700">
                Daftar
            </button>
        </form>

        <p class="text-center text-sm text-gray-600 mt-6">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-blue-600 font-semibold">
                Login di sini
            </a>
        </p>

    </div>

</div>

@endsection