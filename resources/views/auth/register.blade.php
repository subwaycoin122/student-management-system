@extends('layouts.auth')

@section('title', 'Create Account')

@section('content')
<h4 class="fw-bold text-dark mb-1">Create Account</h4>
<p class="text-muted small mb-4">Register a new administrator account.</p>

<form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="mb-3">
        <label for="name" class="form-label fw-semibold small text-secondary">Full Name</label>
        <div class="input-group">
            <span class="input-group-text bg-light text-muted"><i class="bi bi-person"></i></span>
            <input type="text" 
                   id="name" 
                   name="name" 
                   value="{{ old('name') }}" 
                   class="form-control @error('name') is-invalid @enderror" 
                   placeholder="e.g. John Doe" 
                   required 
                   autofocus>
        </div>
        @error('name')
            <div class="invalid-feedback d-block small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label fw-semibold small text-secondary">Email Address</label>
        <div class="input-group">
            <span class="input-group-text bg-light text-muted"><i class="bi bi-envelope"></i></span>
            <input type="email" 
                   id="email" 
                   name="email" 
                   value="{{ old('email') }}" 
                   class="form-control @error('email') is-invalid @enderror" 
                   placeholder="name@example.com" 
                   required>
        </div>
        @error('email')
            <div class="invalid-feedback d-block small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password" class="form-label fw-semibold small text-secondary">Password</label>
        <div class="input-group">
            <span class="input-group-text bg-light text-muted"><i class="bi bi-lock"></i></span>
            <input type="password" 
                   id="password" 
                   name="password" 
                   class="form-control @error('password') is-invalid @enderror" 
                   placeholder="Minimum 8 characters" 
                   required>
        </div>
        @error('password')
            <div class="invalid-feedback d-block small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-4">
        <label for="password_confirmation" class="form-label fw-semibold small text-secondary">Confirm Password</label>
        <div class="input-group">
            <span class="input-group-text bg-light text-muted"><i class="bi bi-shield-check"></i></span>
            <input type="password" 
                   id="password_confirmation" 
                   name="password_confirmation" 
                   class="form-control" 
                   placeholder="Repeat password" 
                   required>
        </div>
    </div>

    <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold mb-3" style="background-color: #2563eb;">
        <i class="bi bi-person-check-fill me-1"></i> Register Account
    </button>

    <div class="text-center small text-muted">
        Already have an account? 
        <a href="{{ route('login') }}" class="text-primary fw-semibold text-decoration-none">Sign In</a>
    </div>
</form>
@endsection
