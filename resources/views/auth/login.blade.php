<x-guest-layout>
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Masuk ke Akun</h2>
        <p class="text-gray-700 text-sm mt-2 font-medium">Masuk untuk mengikuti lelang dan mengelola akun Anda</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="Email" class="text-gray-900 font-semibold" />
            <x-text-input id="email" 
                class="block mt-2 w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent transition-all text-gray-900 font-medium" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                autofocus 
                autocomplete="username"
                placeholder="Masukkan email Anda" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" value="Password" class="text-gray-900 font-semibold" />
            <x-text-input id="password" 
                class="block mt-2 w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent transition-all text-gray-900 font-medium"
                type="password"
                name="password"
                required 
                autocomplete="current-password"
                placeholder="Masukkan password Anda" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" 
                class="rounded border-gray-400 text-accent shadow-sm focus:ring-accent" 
                name="remember">
            <label for="remember_me" class="ml-2 text-sm text-gray-800 font-medium">Ingat saya</label>
        </div>

        <div class="space-y-4">
            <button type="submit" class="w-full btn-accent py-3 text-lg font-medium">
                Masuk
            </button>

            @if (Route::has('password.request'))
                <div class="text-center">
                    <a class="text-sm text-gray-700 hover:text-accent transition-colors font-medium" 
                       href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                </div>
            @endif
        </div>
    </form>

    <div class="mt-6 pt-6 border-t border-gray-300 text-center">
        <p class="text-gray-800 text-sm font-medium">
            Belum punya akun? 
            <a href="{{ route('register') }}" class="text-accent hover:text-accent/80 font-semibold transition-colors">
                Daftar sekarang
            </a>
        </p>
    </div>
</x-guest-layout>
