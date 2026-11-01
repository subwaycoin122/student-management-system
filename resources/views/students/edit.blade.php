@extends('layouts.app')

@section('title', 'Edit Student - ' . $student->student_name)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <a href="{{ route('students.index') }}" class="text-decoration-none text-muted small">
                    <i class="bi bi-arrow-left"></i> Back to Students
                </a>
                <h3 class="fw-bold text-dark mt-1 mb-0">Edit Student Record #{{ $student->student_id }}</h3>
                <p class="text-muted small mb-0">Update student information and academic department relationship.</p>
            </div>
        </div>

        <div class="card card-custom p-4">
            <form method="POST" action="{{ route('students.update', $student) }}">
                @csrf
                @method('PUT')

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
                                   value="{{ old('student_name', $student->student_name) }}" 
                                   class="form-control @error('student_name') is-invalid @enderror" 
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
                            <option value="Male" {{ old('gender', $student->gender) === 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender', $student->gender) === 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender', $student->gender) === 'Other' ? 'selected' : '' }}>Other</option>
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
                                   value="{{ old('dob', $student->dob ? $student->dob->format('Y-m-d') : '') }}" 
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
                                    <option value="{{ $dept->dept_id }}" {{ old('dept_id', $student->dept_id) == $dept->dept_id ? 'selected' : '' }}>
                                        {{ $dept->dept_name }} (ID: #{{ $dept->dept_id }}{{ $dept->location_id ? ' - ' . $dept->location_id : '' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-text small">Connected to foreign key `dept_id` referencing table `departments`.</div>
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
                                   value="{{ old('enrollment', $student->enrollment) }}" 
                                   class="form-control @error('enrollment') is-invalid @enderror" 
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
                                   value="{{ old('enrollment_date', $student->enrollment_date ? $student->enrollment_date->format('Y-m-d') : '') }}" 
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
                              class="form-control @error('description') is-invalid @enderror">{{ old('description', $student->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-end gap-2 border-top pt-3">
                    <a href="{{ route('students.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary-custom px-4">
                        <i class="bi bi-arrow-repeat me-1"></i> Update Student Record
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
