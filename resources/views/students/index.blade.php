@extends('layouts.app')

@section('title', 'Students')

@section('content')
<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold mb-1 text-dark">Students Directory</h2>
        <p class="text-muted mb-0">Browse, filter, and manage student enrollments and academic records.</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <a href="{{ route('students.create') }}" class="btn btn-primary-custom shadow-sm">
            <i class="bi bi-person-plus-fill me-1"></i> Add New Student
        </a>
    </div>
</div>

<!-- Search & Multi-Filter Form -->
<div class="card card-custom p-3 mb-4">
    <form method="GET" action="{{ route('students.index') }}" class="row g-2 align-items-center">
        <!-- Search Name / Enrollment -->
        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-text bg-light text-muted"><i class="bi bi-search"></i></span>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       class="form-control" 
                       placeholder="Search by student name or enrollment #...">
            </div>
        </div>

        <!-- Filter by Department (Dept_Name) -->
        <div class="col-md-3">
            <select name="dept_id" class="form-select">
                <option value="">-- All Departments --</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->dept_id }}" {{ request('dept_id') == $dept->dept_id ? 'selected' : '' }}>
                        {{ $dept->dept_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Filter by Gender -->
        <div class="col-md-3">
            <select name="gender" class="form-select">
                <option value="">-- All Genders --</option>
                <option value="Male" {{ request('gender') === 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ request('gender') === 'Female' ? 'selected' : '' }}>Female</option>
                <option value="Other" {{ request('gender') === 'Other' ? 'selected' : '' }}>Other</option>
            </select>
        </div>

        <!-- Action Buttons -->
        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-primary flex-fill">
                <i class="bi bi-funnel"></i> Filter
            </button>
            @if(request('search') || request('dept_id') || request('gender'))
                <a href="{{ route('students.index') }}" class="btn btn-outline-secondary" title="Reset all filters">
                    <i class="bi bi-x-circle"></i>
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Students HTML Table -->
<div class="card card-custom overflow-hidden">
    <div class="table-responsive">
        <table class="table table-custom align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 80px;">ID</th>
                    <th>Student Name</th>
                    <th>Department</th>
                    <th>Gender</th>
                    <th>Date of Birth</th>
                    <th>Enrollment #</th>
                    <th>Enrollment Date</th>
                    <th>Description</th>
                    <th class="text-end" style="width: 150px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                    <tr>
                        <td class="fw-bold text-muted">#{{ $student->student_id }}</td>
                        <td>
                            <a href="{{ route('students.show', $student) }}" class="fw-bold text-dark text-decoration-none">
                                {{ $student->student_name }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('students.index', ['dept_id' => $student->dept_id]) }}" class="badge badge-dept text-decoration-none py-1 px-2">
                                <i class="bi bi-building me-1"></i>{{ $student->department->dept_name ?? 'Unassigned' }}
                            </a>
                        </td>
                        <td>
                            @if($student->gender === 'Male')
                                <span class="badge badge-gender-male"><i class="bi bi-gender-male"></i> Male</span>
                            @elseif($student->gender === 'Female')
                                <span class="badge badge-gender-female"><i class="bi bi-gender-female"></i> Female</span>
                            @else
                                <span class="badge badge-gender-other">{{ $student->gender }}</span>
                            @endif
                        </td>
                        <td class="text-secondary small">
                            {{ $student->dob ? $student->dob->format('M d, Y') : '-' }}
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ $student->enrollment }}</span>
                        </td>
                        <td class="text-secondary small">
                            {{ $student->enrollment_date ? $student->enrollment_date->format('M d, Y') : '-' }}
                        </td>
                        <td class="text-muted small" style="max-width: 200px;">
                            <span class="text-truncate d-inline-block" style="max-width: 180px;" title="{{ $student->description }}">
                                {{ $student->description ?? '-' }}
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('students.show', $student) }}" class="btn btn-sm btn-light border text-primary" title="View Student">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-light border text-secondary" title="Edit Student">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('students.destroy', $student) }}" onsubmit="return confirm('Are you sure you want to delete student {{ $student->student_name }}?');" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light border text-danger" title="Delete Student">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-5">
                            <i class="bi bi-people fs-1 text-muted d-block mb-2"></i>
                            <h5 class="text-muted fw-bold">No Students Found</h5>
                            <p class="text-muted small mb-3">No student records matched your search query or filters.</p>
                            <a href="{{ route('students.create') }}" class="btn btn-sm btn-primary">Add New Student</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($students->hasPages())
        <div class="card-footer bg-white py-3 border-top d-flex justify-content-end">
            {{ $students->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
