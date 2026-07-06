<x-guest-layout>
    <div class="login-container">
        <div class="login-card">
            <div class="login-brand">
                <div class="logo">
                    <i class="bi bi-envelope-check-fill"></i>
                </div>
                <h1>Verifikasi Email</h1>
                <p>Periksa email Anda untuk link verifikasi</p>
            </div>

            @if(session('status') == 'verification-link-sent')
                <div class="alert alert-success">
                    Link verifikasi baru telah dikirim ke email Anda.
                </div>
            @endif

            <div class="text-center mb-4">
                <p class="text-muted">Kami telah mengirim link verifikasi ke email Anda. Klik link tersebut untuk mengaktifkan akun.</p>
            </div>

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <button type="submit" class="btn-login">
                    <i class="bi bi-arrow-repeat me-2"></i> Kirim Ulang
                </button>
            </form>

            <div class="text-center mt-3">
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-link text-decoration-none text-muted">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
