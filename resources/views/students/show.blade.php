@extends('layouts.app')

@section('title', 'Student Details - ' . $student->student_name)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <a href="{{ route('students.index') }}" class="text-decoration-none text-muted small">
                    <i class="bi bi-arrow-left"></i> Back to Students
                </a>
                <h3 class="fw-bold text-dark mt-1 mb-0">{{ $student->student_name }}</h3>
                <span class="badge bg-light text-dark border">Enrollment: {{ $student->enrollment }}</span>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('students.edit', $student) }}" class="btn btn-outline-secondary">
                    <i class="bi bi-pencil me-1"></i> Edit
                </a>
                <form method="POST" action="{{ route('students.destroy', $student) }}" onsubmit="return confirm('Are you sure you want to delete this student?');" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger">
                        <i class="bi bi-trash me-1"></i> Delete
                    </button>
                </form>
            </div>
        </div>

        <div class="card card-custom p-4 mb-4">
            <div class="d-flex align-items-center gap-3 pb-3 border-bottom mb-4">
                <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold shadow-sm" style="width: 64px; height: 64px; font-size: 1.5rem; background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);">
                    {{ strtoupper(substr($student->student_name, 0, 1)) }}
                </div>
                <div>
                    <h4 class="fw-bold mb-1 text-dark">{{ $student->student_name }}</h4>
                    <div class="d-flex align-items-center gap-2">
                        @if($student->gender === 'Male')
                            <span class="badge badge-gender-male"><i class="bi bi-gender-male"></i> Male</span>
                        @elseif($student->gender === 'Female')
                            <span class="badge badge-gender-female"><i class="bi bi-gender-female"></i> Female</span>
                        @else
                            <span class="badge badge-gender-other">{{ $student->gender }}</span>
                        @endif
                        <span class="text-muted small">&bull;</span>
                        <span class="text-muted small">Student ID: #{{ $student->student_id }}</span>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-sm-6">
                    <div class="text-muted small fw-semibold text-uppercase">Academic Department</div>
                    <div class="mt-1">
                        @if($student->department)
                            <a href="{{ route('departments.show', $student->department) }}" class="fs-5 fw-bold text-primary text-decoration-none">
                                <i class="bi bi-building me-1"></i> {{ $student->department->dept_name }}
                            </a>
                            <div class="text-muted small mt-1">
                                Dept ID: #{{ $student->department->dept_id }} &middot; {{ $student->department->location_id ?? 'No location' }}
                            </div>
                        @else
                            <span class="text-muted">Unassigned</span>
                        @endif
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="text-muted small fw-semibold text-uppercase">Enrollment Code</div>
                    <div class="mt-1 fs-5 fw-bold text-dark">
                        {{ $student->enrollment }}
                    </div>
                    <div class="text-muted small mt-1">
                        Enrolled on: {{ $student->enrollment_date ? $student->enrollment_date->format('M d, Y') : '-' }}
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="text-muted small fw-semibold text-uppercase">Date of Birth</div>
                    <div class="mt-1 fs-6 fw-semibold text-dark">
                        {{ $student->dob ? $student->dob->format('F d, Y') : '-' }}
                    </div>
                    <div class="text-muted small">
                        {{ $student->dob ? $student->dob->age . ' years old' : '' }}
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="text-muted small fw-semibold text-uppercase">System Timestamps</div>
                    <div class="text-muted small mt-1">
                        Created: {{ $student->created_at ? $student->created_at->format('M d, Y h:i A') : '-' }}
                    </div>
                    <div class="text-muted small">
                        Updated: {{ $student->updated_at ? $student->updated_at->format('M d, Y h:i A') : '-' }}
                    </div>
                </div>
            </div>

            <div class="border-top pt-3">
                <div class="text-muted small fw-semibold text-uppercase mb-2">Description / Notes</div>
                <div class="bg-light p-3 rounded-2 text-dark">
                    {{ $student->description ?: 'No notes or description recorded for this student.' }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
