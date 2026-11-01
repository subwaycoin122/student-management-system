@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row align-items-center mb-4">
    <div class="col-md-7">
        <h2 class="fw-bold mb-1 text-dark">Dashboard Overview</h2>
        <p class="text-muted mb-0">Welcome back, <strong>{{ Auth::user()->name }}</strong>. Here is the latest summary of your institution.</p>
    </div>
    <div class="col-md-5 text-md-end mt-3 mt-md-0 d-flex gap-2 justify-content-md-end">
        <a href="{{ route('students.create') }}" class="btn btn-primary-custom d-flex align-items-center gap-1 shadow-sm">
            <i class="bi bi-person-plus-fill"></i> Add Student
        </a>
        <a href="{{ route('departments.create') }}" class="btn btn-outline-primary d-flex align-items-center gap-1 bg-white shadow-sm">
            <i class="bi bi-building-add"></i> Add Department
        </a>
    </div>
</div>

<!-- Metric Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3">
        <div class="card card-custom h-100 p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-semibold text-uppercase">Total Students</div>
                    <div class="fs-2 fw-bold text-dark mt-1">{{ number_format($totalStudents) }}</div>
                </div>
                <div class="p-3 bg-primary-subtle text-primary rounded-circle">
                    <i class="bi bi-people-fill fs-3"></i>
                </div>
            </div>
            <div class="mt-2 text-muted small">
                <a href="{{ route('students.index') }}" class="text-decoration-none text-primary fw-semibold">View all students &rarr;</a>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card card-custom h-100 p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-semibold text-uppercase">Departments</div>
                    <div class="fs-2 fw-bold text-dark mt-1">{{ number_format($totalDepartments) }}</div>
                </div>
                <div class="p-3 bg-info-subtle text-info rounded-circle">
                    <i class="bi bi-building fs-3"></i>
                </div>
            </div>
            <div class="mt-2 text-muted small">
                <a href="{{ route('departments.index') }}" class="text-decoration-none text-info fw-semibold">Manage departments &rarr;</a>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card card-custom h-100 p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-semibold text-uppercase">Male Students</div>
                    <div class="fs-2 fw-bold text-primary mt-1">{{ number_format($maleStudents) }}</div>
                </div>
                <div class="p-3 bg-primary-subtle text-primary rounded-circle">
                    <i class="bi bi-gender-male fs-3"></i>
                </div>
            </div>
            <div class="mt-2 text-muted small">
                <span>{{ $totalStudents > 0 ? round(($maleStudents / $totalStudents) * 100, 1) : 0 }}% of student body</span>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card card-custom h-100 p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small fw-semibold text-uppercase">Female Students</div>
                    <div class="fs-2 fw-bold text-danger mt-1">{{ number_format($femaleStudents) }}</div>
                </div>
                <div class="p-3 bg-danger-subtle text-danger rounded-circle">
                    <i class="bi bi-gender-female fs-3"></i>
                </div>
            </div>
            <div class="mt-2 text-muted small">
                <span>{{ $totalStudents > 0 ? round(($femaleStudents / $totalStudents) * 100, 1) : 0 }}% of student body</span>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Enrolled Students -->
    <div class="col-lg-8">
        <div class="card card-custom h-100">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-person-lines-fill text-primary me-2"></i>Recently Enrolled Students</h5>
                <a href="{{ route('students.index') }}" class="btn btn-sm btn-outline-secondary">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-custom align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Student Name</th>
                            <th>Enrollment Code</th>
                            <th>Department</th>
                            <th>Gender</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentStudents as $student)
                            <tr>
                                <td class="fw-semibold text-muted">#{{ $student->student_id }}</td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $student->student_name }}</div>
                                    <div class="text-muted small">{{ $student->dob ? $student->dob->format('M d, Y') : '-' }}</div>
                                </td>
                                <td><span class="badge bg-light text-dark border">{{ $student->enrollment }}</span></td>
                                <td>
                                    <span class="badge badge-dept">{{ $student->department->dept_name ?? 'N/A' }}</span>
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
                                <td class="text-end">
                                    <a href="{{ route('students.show', $student) }}" class="btn btn-sm btn-light text-primary border" title="View Details">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-light text-secondary border" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">No students enrolled yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Department Distribution -->
    <div class="col-lg-4">
        <div class="card card-custom h-100">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-diagram-3-fill text-info me-2"></i>Department Overview</h5>
                <a href="{{ route('departments.index') }}" class="btn btn-sm btn-outline-secondary">View All</a>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($departmentsSummary as $dept)
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <div>
                                <a href="{{ route('departments.show', $dept) }}" class="fw-bold text-dark text-decoration-none">
                                    {{ $dept->dept_name }}
                                </a>
                                <div class="text-muted small">
                                    <i class="bi bi-geo-alt"></i> {{ $dept->location_id ?? 'No location set' }}
                                </div>
                            </div>
                            <span class="badge rounded-pill bg-primary fs-6 px-3">
                                {{ $dept->students_count }} {{ Str::plural('Student', $dept->students_count) }}
                            </span>
                        </li>
                    @empty
                        <li class="list-group-item text-center py-4 text-muted">No departments created yet.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
