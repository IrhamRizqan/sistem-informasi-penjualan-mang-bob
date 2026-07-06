<x-guest-layout>
    <div class="login-container">
        <div class="login-card">
            <div class="login-brand">
                <div class="logo">
                    <i class="bi bi-shield-lock-fill"></i>
                </div>
                <h1>Konfirmasi Password</h1>
                <p>Masukkan password untuk melanjutkan</p>
            </div>

            @if($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                           id="password" name="password" required autocomplete="current-password"
                           placeholder="Masukkan password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-login">
                    <i class="bi bi-check-lg me-2"></i> Konfirmasi
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
