<x-guest-layout>
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Daftar Akun Baru</h2>
        <p class="text-gray-700 text-sm mt-2 font-medium">Bergabunglah dengan platform lelang online terpercaya</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" value="Nama Lengkap" class="text-gray-900 font-semibold" />
            <x-text-input id="name" 
                class="block mt-2 w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent transition-all text-gray-900 font-medium" 
                type="text" 
                name="name" 
                :value="old('name')" 
                required 
                autofocus 
                autocomplete="name"
                placeholder="Masukkan nama lengkap Anda" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="Email" class="text-gray-900 font-semibold" />
            <x-text-input id="email" 
                class="block mt-2 w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent transition-all text-gray-900 font-medium" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
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
                autocomplete="new-password"
                placeholder="Masukkan password Anda" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" value="Konfirmasi Password" class="text-gray-900 font-semibold" />
            <x-text-input id="password_confirmation" 
                class="block mt-2 w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent transition-all text-gray-900 font-medium"
                type="password"
                name="password_confirmation" 
                required 
                autocomplete="new-password"
                placeholder="Ulangi password Anda" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="space-y-4">
            <button type="submit" class="w-full btn-accent py-3 text-lg font-medium">
                Daftar Sekarang
            </button>
        </div>
    </form>

    <div class="mt-6 pt-6 border-t border-gray-300 text-center">
        <p class="text-gray-800 text-sm font-medium">
            Sudah punya akun? 
            <a href="{{ route('login') }}" class="text-accent hover:text-accent/80 font-semibold transition-colors">
                Masuk di sini
            </a>
        </p>
    </div>
</x-guest-layout>
