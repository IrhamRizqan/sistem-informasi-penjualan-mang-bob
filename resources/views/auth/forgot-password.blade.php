<x-guest-layout>
    <div class="login-container">
        <div class="login-card">
            <div class="login-brand">
                <div class="logo">
                    <i class="bi bi-key-fill"></i>
                </div>
                <h1>Lupa Password</h1>
                <p>Masukkan email untuk reset password</p>
            </div>

            @if(session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                           id="email" name="email" value="{{ old('email') }}"
                           required autofocus autocomplete="username" placeholder="Masukkan email">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-login">
                    <i class="bi bi-send me-2"></i> Kirim Link Reset
                </button>

                <div class="text-center mt-3">
                    <a href="{{ route('login') }}" class="text-decoration-none text-muted">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Login
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
