<!-- Register Form -->
        <div id="register-form" style="display: none;">
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" name="name" id="name" class="form-control" placeholder="Masukkan Nama" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan Email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan Password" required>
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="input-group mb-4">
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Konfirmasi Password" required>
                </div>
                <button type="submit" class="btn btn-submit">Registrasi</button>
            </form>
        </div>
    </div>