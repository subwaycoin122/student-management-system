@extends('layouts.app')

@section('title', 'Edit Department')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <a href="{{ route('departments.index') }}" class="text-decoration-none text-muted small">
                    <i class="bi bi-arrow-left"></i> Back to Departments
                </a>
                <h3 class="fw-bold text-dark mt-1 mb-0">Edit Department #{{ $department->dept_id }}</h3>
            </div>
        </div>

        <div class="card card-custom p-4">
            <form method="POST" action="{{ route('departments.update', $department) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="dept_name" class="form-label fw-semibold text-dark">
                        Department Name <span class="text-danger">*</span>
                    </label>
                    <input type="text" 
                           id="dept_name" 
                           name="dept_name" 
                           value="{{ old('dept_name', $department->dept_name) }}" 
                           class="form-control @error('dept_name') is-invalid @enderror" 
                           required 
                           autofocus>
                    @error('dept_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="manager_id" class="form-label fw-semibold text-dark">
                            Manager ID / Head of Dept
                        </label>
                        <input type="text" 
                               id="manager_id" 
                               name="manager_id" 
                               value="{{ old('manager_id', $department->manager_id) }}" 
                               class="form-control @error('manager_id') is-invalid @enderror">
                        @error('manager_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="location_id" class="form-label fw-semibold text-dark">
                            Location ID / Campus Building
                        </label>
                        <input type="text" 
                               id="location_id" 
                               name="location_id" 
                               value="{{ old('location_id', $department->location_id) }}" 
                               class="form-control @error('location_id') is-invalid @enderror">
                        @error('location_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 border-top pt-3">
                    <a href="{{ route('departments.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary-custom px-4">
                        <i class="bi bi-arrow-repeat me-1"></i> Update Department
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
