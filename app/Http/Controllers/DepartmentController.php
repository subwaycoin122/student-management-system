<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource with search.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $query = Department::withCount('students');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('dept_name', 'like', "%{$search}%")
                  ->orWhere('manager_id', 'like', "%{$search}%")
                  ->orWhere('location_id', 'like', "%{$search}%");
            });
        }

        $departments = $query->orderBy('dept_name')->paginate(10)->withQueryString();

        return view('departments.index', compact('departments', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('departments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'dept_name' => ['required', 'string', 'max:255', 'unique:departments,dept_name'],
            'manager_id' => ['nullable', 'string', 'max:100'],
            'location_id' => ['nullable', 'string', 'max:100'],
        ]);

        $department = Department::create($validated);

        return redirect()->route('departments.index')
            ->with('success', "Department '{$department->dept_name}' created successfully!");
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department): View
    {
        $department->load(['students' => function ($query) {
            $query->orderBy('student_name');
        }]);

        return view('departments.show', compact('department'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department): View
    {
        return view('departments.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department): RedirectResponse
    {
        $validated = $request->validate([
            'dept_name' => ['required', 'string', 'max:255', 'unique:departments,dept_name,' . $department->dept_id . ',dept_id'],
            'manager_id' => ['nullable', 'string', 'max:100'],
            'location_id' => ['nullable', 'string', 'max:100'],
        ]);

        $department->update($validated);

        return redirect()->route('departments.index')
            ->with('success', "Department '{$department->dept_name}' updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department): RedirectResponse
    {
        $name = $department->dept_name;
        $department->delete();

        return redirect()->route('departments.index')
            ->with('success', "Department '{$name}' and associated records deleted successfully!");
    }
}
