@extends('layouts.app')

@section('title', 'Departments')

@section('content')
<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold mb-1 text-dark">Departments</h2>
        <p class="text-muted mb-0">Manage academic departments, department heads, and locations.</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <a href="{{ route('departments.create') }}" class="btn btn-primary-custom shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Add New Department
        </a>
    </div>
</div>

<!-- Search & Filter Bar -->
<div class="card card-custom p-3 mb-4">
    <form method="GET" action="{{ route('departments.index') }}" class="row g-2 align-items-center">
        <div class="col-md-9">
            <div class="input-group">
                <span class="input-group-text bg-light text-muted"><i class="bi bi-search"></i></span>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       class="form-control" 
                       placeholder="Search by department name, manager ID, or location...">
            </div>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-primary flex-fill">
                <i class="bi bi-funnel"></i> Search
            </button>
            @if(request('search'))
                <a href="{{ route('departments.index') }}" class="btn btn-outline-secondary" title="Clear filter">
                    <i class="bi bi-x-circle"></i>
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Departments HTML Table -->
<div class="card card-custom overflow-hidden">
    <div class="table-responsive">
        <table class="table table-custom align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 100px;">Dept ID</th>
                    <th>Department Name</th>
                    <th>Manager ID</th>
                    <th>Location</th>
                    <th>Enrolled Students</th>
                    <th>Created Date</th>
                    <th class="text-end" style="width: 160px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($departments as $dept)
                    <tr>
                        <td class="fw-bold text-primary">#{{ $dept->dept_id }}</td>
                        <td>
                            <a href="{{ route('departments.show', $dept) }}" class="fw-bold text-dark text-decoration-none">
                                {{ $dept->dept_name }}
                            </a>
                        </td>
                        <td>
                            @if($dept->manager_id)
                                <span class="badge bg-light text-dark border"><i class="bi bi-person-badge me-1"></i>{{ $dept->manager_id }}</span>
                            @else
                                <span class="text-muted small">Not assigned</span>
                            @endif
                        </td>
                        <td>
                            @if($dept->location_id)
                                <span class="text-secondary small"><i class="bi bi-geo-alt text-danger me-1"></i>{{ $dept->location_id }}</span>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('students.index', ['dept_id' => $dept->dept_id]) }}" class="badge rounded-pill bg-primary-subtle text-primary border border-primary-subtle text-decoration-none px-3 py-1">
                                <i class="bi bi-people me-1"></i> {{ $dept->students_count }} {{ Str::plural('student', $dept->students_count) }}
                            </a>
                        </td>
                        <td class="text-muted small">
                            {{ $dept->created_at ? $dept->created_at->format('M d, Y') : '-' }}
                        </td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('departments.show', $dept) }}" class="btn btn-sm btn-light border text-primary" title="View Details">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('departments.edit', $dept) }}" class="btn btn-sm btn-light border text-secondary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('departments.destroy', $dept) }}" onsubmit="return confirm('Are you sure you want to delete this department? All associated students will also be removed!');" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light border text-danger" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="bi bi-building-exclamation fs-1 text-muted d-block mb-2"></i>
                            <h5 class="text-muted fw-bold">No Departments Found</h5>
                            <p class="text-muted small mb-3">No departments match your current search criteria.</p>
                            <a href="{{ route('departments.create') }}" class="btn btn-sm btn-primary">Add First Department</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($departments->hasPages())
        <div class="card-footer bg-white py-3 border-top d-flex justify-content-end">
            {{ $departments->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
