<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Sistem FRI Laboratorium</title>
    
    <!-- Google Fonts - Space Grotesk -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- Compiled CSS -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div class="login-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10 col-lg-11">
                    <div class="login-card">
                        
                        {{-- Logo Header --}}
                        <div class="login-header">
                            <img src="{{ asset('images/logo-fri.png') }}" alt="FRI Logo" class="img-fluid" style="max-height: 72px;">
                        </div>
                        
                        {{-- Login Form Body --}}
                        <div class="login-body">
                            
                            {{-- Welcome Text --}}
                            <div class="mb-4">
                                <h2 class="welcome-title">Selamat Datang</h2>
                                <p class="welcome-subtitle">
                                    Silakan masukkan data Anda untuk masuk ke Sistem FRI Laboratorium.
                                </p>
                            </div>
                            
                            {{-- Role Selection Tabs --}}
                            <div class="role-tabs mb-4">
                                <button type="button" class="role-tab active" data-role="aslab">
                                    Asisten Laboratorium
                                </button>
                                <button type="button" class="role-tab" data-role="admin">
                                    Admin
                                </button>
                            </div>
                            
                            {{-- Login Form --}}
                            <form method="POST" action="{{ route('login') }}" id="loginForm">
                                @csrf
                                
                                {{-- Hidden Role Input --}}
                                <input type="hidden" name="role" id="roleInput" value="aslab">
                                
                                {{-- Username/Code Field --}}
                                <div class="mb-3">
                                    <label for="username" class="form-label" id="usernameLabel">
                                        Kode Asisten Laboratorium
                                    </label>
                                    <div class="input-group">
                                        <input type="text" 
                                               class="form-control @error('username') is-invalid @enderror" 
                                               id="username" 
                                               name="username" 
                                               value="{{ old('username') }}" 
                                               placeholder="Masukkan kode asisten"
                                               required 
                                               autofocus>
                                        <span class="input-group-text bg-white border-white">
                                            <i class="bi bi-person"></i>
                                        </span>
                                    </div>
                                    @error('username')
                                        <div class="invalid-feedback d-block text-white">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                
                                {{-- Password Field --}}
                                <div class="mb-3">
                                    <label for="password" class="form-label">Kata Sandi</label>
                                    <div class="password-wrapper">
                                        <input type="password" 
                                               class="form-control @error('password') is-invalid @enderror" 
                                               id="password" 
                                               name="password" 
                                               placeholder="Masukkan kata sandi"
                                               required>
                                        <button type="button" class="toggle-password" onclick="togglePassword()">
                                            <i class="bi bi-eye" id="toggleIcon"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback d-block text-white">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                
                                {{-- Remember Me --}}
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                    <label class="form-check-label text-white" for="remember">
                                        Ingat Saya
                                    </label>
                                </div>
                                
                                {{-- Error Alert --}}
                                @if(session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <i class="bi bi-exclamation-triangle me-2"></i>
                                        {{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                @endif
                                
                                {{-- Login Button --}}
                                <button type="submit" class="btn btn-primary btn-login">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>
                                    Masuk
                                </button>
                                
                                {{-- Forgot Password Link --}}
                                <div class="text-center mt-3">
                                    <a href="{{ route('password.request') }}" class="text-white text-decoration-none">
                                        <small>Lupa Kata Sandi?</small>
                                    </a>
                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Role Tab Switching
        document.querySelectorAll('.role-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                // Remove active class from all tabs
                document.querySelectorAll('.role-tab').forEach(t => t.classList.remove('active'));
                
                // Add active class to clicked tab
                this.classList.add('active');
                
                // Update role input
                const role = this.getAttribute('data-role');
                document.getElementById('roleInput').value = role;
                
                // Update label text
                const label = document.getElementById('usernameLabel');
                const input = document.getElementById('username');
                
                if (role === 'admin') {
                    label.textContent = 'Username Admin';
                    input.placeholder = 'Masukkan username admin';
                } else {
                    label.textContent = 'Kode Asisten Laboratorium';
                    input.placeholder = 'Masukkan kode asisten';
                }
            });
        });
        
        // Toggle Password Visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('bi-eye');
                toggleIcon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('bi-eye-slash');
                toggleIcon.classList.add('bi-eye');
            }
        }
        
        // Form Validation Animation
        const form = document.getElementById('loginForm');
        form.addEventListener('submit', function(e) {
            const button = this.querySelector('button[type="submit"]');
            button.classList.add('loading');
            button.disabled = true;
        });
    </script>
</body>
</html>