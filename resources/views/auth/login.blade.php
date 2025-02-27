@extends('layouts.app')

@section('content')
    <div class="min-vh-100 d-flex align-items-center justify-content-center py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 col-lg-5">
                    <div class="card auth-card shadow-sm">
                        <div class="card-body p-4 p-md-5">
                            <!-- Alert Message -->
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <div class="text-center mb-4">
                                <h2 class="fw-bold todo mb-4">To-Do-List</h2>
                                <p class="text-muted">Mulai membuat tugas tugas anda! dengan masuk</p>
                            </div>

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="bi bi-envelope-at"></i>
                                        </span>
                                        <input type="email" name="email"
                                            class="form-control border-start-0 @error('email') is-invalid @enderror"
                                            placeholder="Email Address" value="{{ old('email') }}" required
                                            autocomplete="email" autofocus>
                                    </div>
                                    @error('email')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="bi bi-key"></i>
                                        </span>
                                        <input type="password" name="password"
                                            class="form-control border-start-0 @error('password') is-invalid @enderror"
                                            placeholder="Password" required autocomplete="current-password">
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-purple w-100 mb-3 position-relative overflow-hidden">
                                    <span class="d-flex align-items-center justify-content-center">
                                        Masuk
                                        <i class="ms-2">➜</i>
                                    </span>
                                </button>

                                <div class="text-center">
                                    <a href="register" class="link-purple">
                                        Tidak Punya Akun? Buat Akun
                                    </a>
                                </div>

                                <div class="mt-4 pt-4 border-top">
                                    <div class="row g-4">
                                        <div class="col-6">
                                            <div class="d-flex align-items-center">
                                                <div class="feature-icon me-2"><i class="bi bi-check-circle"></i></div>
                                                <span class="small text-muted">Task Management</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="d-flex align-items-center">
                                                <div class="feature-icon me-2"><i class="bi bi-check-circle"></i></div>
                                                <span class="small text-muted">Progress Tracking</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="d-flex align-items-center">
                                                <div class="feature-icon me-2"><i class="bi bi-check-circle"></i></div>
                                                <span class="small text-muted">Team Collaboration</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="d-flex align-items-center">
                                                <div class="feature-icon me-2"><i class="bi bi-check-circle"></i></div>
                                                <span class="small text-muted">Priority Settings</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
