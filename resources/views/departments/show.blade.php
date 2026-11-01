@extends('layouts.app')

@section('title', $department->dept_name)

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <a href="{{ route('departments.index') }}" class="text-decoration-none text-muted small">
            <i class="bi bi-arrow-left"></i> Back to Departments
        </a>
        <h2 class="fw-bold text-dark mt-1 mb-0">{{ $department->dept_name }}</h2>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('students.create', ['dept_id' => $department->dept_id]) }}" class="btn btn-primary-custom">
            <i class="bi bi-person-plus-fill me-1"></i> Add Student
        </a>
        <a href="{{ route('departments.edit', $department) }}" class="btn btn-outline-secondary">
            <i class="bi bi-pencil me-1"></i> Edit
        </a>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card card-custom p-4 h-100">
            <h5 class="fw-bold text-dark mb-3"><i class="bi bi-info-circle text-primary me-2"></i>Department Info</h5>
            
            <div class="mb-3">
                <div class="text-muted small">Department ID</div>
                <div class="fs-5 fw-bold text-primary">#{{ $department->dept_id }}</div>
            </div>

            <div class="mb-3">
                <div class="text-muted small">Department Name</div>
                <div class="fw-semibold text-dark">{{ $department->dept_name }}</div>
            </div>

            <div class="mb-3">
                <div class="text-muted small">Manager ID / Lead</div>
                <div class="fw-semibold text-secondary">{{ $department->manager_id ?? 'Not assigned' }}</div>
            </div>

            <div class="mb-3">
                <div class="text-muted small">Location / Campus</div>
                <div class="fw-semibold text-secondary">{{ $department->location_id ?? 'Not assigned' }}</div>
            </div>

            <div class="mb-0">
                <div class="text-muted small">Created Date</div>
                <div class="small text-muted">{{ $department->created_at ? $department->created_at->format('M d, Y h:i A') : '-' }}</div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card card-custom h-100">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark">
                    <i class="bi bi-people-fill text-primary me-2"></i>Enrolled Students ({{ $department->students->count() }})
                </h5>
            </div>
            <div class="table-responsive">
                <table class="table table-custom align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Enrollment</th>
                            <th>Gender</th>
                            <th>Date of Birth</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($department->students as $student)
                            <tr>
                                <td class="fw-bold text-muted">#{{ $student->student_id }}</td>
                                <td class="fw-semibold text-dark">{{ $student->student_name }}</td>
                                <td><span class="badge bg-light text-dark border">{{ $student->enrollment }}</span></td>
                                <td>
                                    @if($student->gender === 'Male')
                                        <span class="badge badge-gender-male"><i class="bi bi-gender-male"></i> Male</span>
                                    @elseif($student->gender === 'Female')
                                        <span class="badge badge-gender-female"><i class="bi bi-gender-female"></i> Female</span>
                                    @else
                                        <span class="badge badge-gender-other">{{ $student->gender }}</span>
                                    @endif
                                </td>
                                <td class="text-muted small">{{ $student->dob ? $student->dob->format('M d, Y') : '-' }}</td>
                                <td class="text-end">
                                    <a href="{{ route('students.show', $student) }}" class="btn btn-sm btn-light border text-primary" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    No students are enrolled in this department yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
