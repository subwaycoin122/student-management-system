@extends('layouts.app')

@section('title', 'Enroll New Student')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <a href="{{ route('students.index') }}" class="text-decoration-none text-muted small">
                    <i class="bi bi-arrow-left"></i> Back to Students
                </a>
                <h3 class="fw-bold text-dark mt-1 mb-0">Student Enrollment Form</h3>
                <p class="text-muted small mb-0">Submit new student data linked with academic department.</p>
            </div>
        </div>

        <div class="card card-custom p-4">
            <form method="POST" action="{{ route('students.store') }}">
                @csrf

                <div class="row g-3 mb-3">
                    <!-- Student Full Name -->
                    <div class="col-md-7">
                        <label for="student_name" class="form-label fw-semibold text-dark">
                            Student Full Name <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted"><i class="bi bi-person"></i></span>
                            <input type="text" 
                                   id="student_name" 
                                   name="student_name" 
                                   value="{{ old('student_name') }}" 
                                   class="form-control @error('student_name') is-invalid @enderror" 
                                   placeholder="e.g. Johnathan Smith" 
                                   required 
                                   autofocus>
                        </div>
                        @error('student_name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Gender Selection -->
                    <div class="col-md-5">
                        <label for="gender" class="form-label fw-semibold text-dark">
                            Gender <span class="text-danger">*</span>
                        </label>
                        <select id="gender" name="gender" class="form-select @error('gender') is-invalid @enderror" required>
                            <option value="">-- Select Gender --</option>
                            <option value="Male" {{ old('gender') === 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender') === 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender') === 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <!-- Date of Birth -->
                    <div class="col-md-6">
                        <label for="dob" class="form-label fw-semibold text-dark">
                            Date of Birth (DOB) <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted"><i class="bi bi-calendar-event"></i></span>
                            <input type="date" 
                                   id="dob" 
                                   name="dob" 
                                   value="{{ old('dob') }}" 
                                   class="form-control @error('dob') is-invalid @enderror" 
                                   required>
                        </div>
                        @error('dob')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Department Selection (Relation with Departments table) -->
                    <div class="col-md-6">
                        <label for="dept_id" class="form-label fw-semibold text-dark">
                            Department (<span class="text-primary">Dept_Name</span>) <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted"><i class="bi bi-building"></i></span>
                            <select id="dept_id" name="dept_id" class="form-select @error('dept_id') is-invalid @enderror" required>
                                <option value="">-- Choose Academic Department --</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->dept_id }}" {{ old('dept_id', request('dept_id')) == $dept->dept_id ? 'selected' : '' }}>
                                        {{ $dept->dept_name }} (ID: #{{ $dept->dept_id }}{{ $dept->location_id ? ' - ' . $dept->location_id : '' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-text small">Foreign key relationship connected to table `departments`.</div>
                        @error('dept_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <!-- Enrollment ID / Code -->
                    <div class="col-md-6">
                        <label for="enrollment" class="form-label fw-semibold text-dark">
                            Enrollment Code / Number <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted"><i class="bi bi-hash"></i></span>
                            <input type="text" 
                                   id="enrollment" 
                                   name="enrollment" 
                                   value="{{ old('enrollment', 'ENR-' . date('Y') . '-' . rand(100, 999)) }}" 
                                   class="form-control @error('enrollment') is-invalid @enderror" 
                                   placeholder="e.g. ENR-2026-001" 
                                   required>
                        </div>
                        @error('enrollment')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Enrollment Date -->
                    <div class="col-md-6">
                        <label for="enrollment_date" class="form-label fw-semibold text-dark">
                            Enrollment Date <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted"><i class="bi bi-calendar-check"></i></span>
                            <input type="date" 
                                   id="enrollment_date" 
                                   name="enrollment_date" 
                                   value="{{ old('enrollment_date', date('Y-m-d')) }}" 
                                   class="form-control @error('enrollment_date') is-invalid @enderror" 
                                   required>
                        </div>
                        @error('enrollment_date')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Description / Remarks -->
                <div class="mb-4">
                    <label for="description" class="form-label fw-semibold text-dark">
                        Description / Student Notes
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="3" 
                              class="form-control @error('description') is-invalid @enderror" 
                              placeholder="Academic background, achievements, scholarship details, notes...">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-end gap-2 border-top pt-3">
                    <a href="{{ route('students.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary-custom px-4">
                        <i class="bi bi-check2-circle me-1"></i> Submit Student Record
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
