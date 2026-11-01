@extends('layouts.auth')

@section('title', 'Sign In')

@section('content')
<h4 class="fw-bold text-dark mb-1">Sign In</h4>
<p class="text-muted small mb-4">Enter your credentials to access the Student Management System.</p>

<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="mb-3">
        <label for="email" class="form-label fw-semibold small text-secondary">Email Address</label>
        <div class="input-group">
            <span class="input-group-text bg-light text-muted"><i class="bi bi-envelope"></i></span>
            <input type="email" 
                   id="email" 
                   name="email" 
                   value="{{ old('email', 'admin@example.com') }}" 
                   class="form-control @error('email') is-invalid @enderror" 
                   placeholder="name@example.com" 
                   required 
                   autofocus>
        </div>
        @error('email')
            <div class="invalid-feedback d-block small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <div class="d-flex justify-content-between align-items-center mb-1">
            <label for="password" class="form-label fw-semibold small text-secondary mb-0">Password</label>
        </div>
        <div class="input-group">
            <span class="input-group-text bg-light text-muted"><i class="bi bi-lock"></i></span>
            <input type="password" 
                   id="password" 
                   name="password" 
                   value="password123"
                   class="form-control @error('password') is-invalid @enderror" 
                   placeholder="Enter your password" 
                   required>
        </div>
        @error('password')
            <div class="invalid-feedback d-block small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="remember" name="remember">
        <label class="form-check-label small text-muted" for="remember">Remember me</label>
    </div>

    <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold mb-3" style="background-color: #2563eb;">
        <i class="bi bi-box-arrow-in-right me-1"></i> Sign In
    </button>

    <div class="card bg-light border-0 p-3 mb-3 text-start small">
        <div class="fw-semibold text-secondary mb-1"><i class="bi bi-key-fill text-warning me-1"></i> Demo Seeded Accounts:</div>
        <div class="text-muted"><strong>Admin:</strong> admin@example.com / <code>password123</code></div>
        <div class="text-muted"><strong>Staff:</strong> officer@example.com / <code>password123</code></div>
    </div>

    <div class="text-center small text-muted">
        Don't have an account? 
        <a href="{{ route('register') }}" class="text-primary fw-semibold text-decoration-none">Create an account</a>
    </div>
</form>
@endsection
