<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Registrasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: url('{{ asset('img/mb1.jpeg') }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-color: rgba(255, 255, 255, 0.5);
            background-blend-mode: overlay;
        }

        .container {
            background-color: white;
            padding: 3rem;
            border-radius: 8px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1s ease-out;
        }

        .form-control {
            padding: 0.8rem;
            margin-bottom: 1rem;
        }

        .btn-submit {
            background-color: #0508B4;
            border: none;
            width: 100%;
            padding: 0.8rem;
            font-size: 1.2rem;
            color: white;
            font-weight: bold;
        }

        .tab-nav {
            margin-bottom: 2rem;
        }

        .tab-nav button {
            width: 50%;
        }

        .active-tab {
            background-color: #0508B4;
            color: white;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Judul -->
        <h5 class="text-center mb-4" style="color: #0508B4;">
            Sistem Pendukung Keputusan <br> Dinas PU Bangka Barat
        </h5>

        <!-- Login Form -->
        <div id="login-form">
            {{-- Pesan gagal login --}}
            @if(session('error'))
                <div class="alert alert-danger text-center">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Pesan logout atau info lain --}}
            @if(session('status'))
                <div class="alert alert-info text-center">
                    {{ session('status') }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="input-group mb-3">
                    <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan Email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-group mb-4">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan Password" required>
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-submit">Login</button>
            </form>
        </div>
    </div>

</body>
</html>
