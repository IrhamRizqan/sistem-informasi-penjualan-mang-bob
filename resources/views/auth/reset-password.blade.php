<x-guest-layout>
    <div class="login-container">
        <div class="login-card">
            <div class="login-brand">
                <div class="logo">
                    <i class="bi bi-key-fill"></i>
                </div>
                <h1>Reset Password</h1>
                <p>Masukkan password baru Anda</p>
            </div>

            @if($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                           id="email" name="email" value="{{ old('email', $request->email) }}"
                           required autofocus autocomplete="username" placeholder="Masukkan email">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password Baru</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                           id="password" name="password" required autocomplete="new-password"
                           placeholder="Masukkan password baru">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control"
                           id="password_confirmation" name="password_confirmation" required
                           autocomplete="new-password" placeholder="Ulangi password baru">
                </div>

                <button type="submit" class="btn-login">
                    <i class="bi bi-check-lg me-2"></i> Reset Password
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
