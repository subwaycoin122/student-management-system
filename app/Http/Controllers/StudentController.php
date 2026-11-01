<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource with search and filters.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $deptFilter = $request->input('dept_id');
        $genderFilter = $request->input('gender');

        $query = Student::with('department');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('student_name', 'like', "%{$search}%")
                  ->orWhere('enrollment', 'like', "%{$search}%");
            });
        }

        if (!empty($deptFilter)) {
            $query->where('dept_id', $deptFilter);
        }

        if (!empty($genderFilter)) {
            $query->where('gender', $genderFilter);
        }

        $students = $query->orderBy('student_id', 'desc')->paginate(10)->withQueryString();
        $departments = Department::orderBy('dept_name')->get();

        return view('students.index', compact('students', 'departments', 'search', 'deptFilter', 'genderFilter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $departments = Department::orderBy('dept_name')->get();

        return view('students.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'student_name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', Rule::in(['Male', 'Female', 'Other'])],
            'dob' => ['required', 'date', 'before:today'],
            'enrollment' => ['required', 'string', 'max:50', 'unique:students,enrollment'],
            'enrollment_date' => ['required', 'date'],
            'description' => ['nullable', 'string'],
            'dept_id' => ['required', 'integer', 'exists:departments,dept_id'],
        ]);

        $student = Student::create($validated);

        return redirect()->route('students.index')
            ->with('success', "Student '{$student->student_name}' added successfully!");
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student): View
    {
        $student->load('department');

        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student): View
    {
        $departments = Department::orderBy('dept_name')->get();

        return view('students.edit', compact('student', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student): RedirectResponse
    {
        $validated = $request->validate([
            'student_name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', Rule::in(['Male', 'Female', 'Other'])],
            'dob' => ['required', 'date', 'before:today'],
            'enrollment' => [
                'required',
                'string',
                'max:50',
                Rule::unique('students', 'enrollment')->ignore($student->student_id, 'student_id'),
            ],
            'enrollment_date' => ['required', 'date'],
            'description' => ['nullable', 'string'],
            'dept_id' => ['required', 'integer', 'exists:departments,dept_id'],
        ]);

        $student->update($validated);

        return redirect()->route('students.index')
            ->with('success', "Student '{$student->student_name}' updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student): RedirectResponse
    {
        $name = $student->student_name;
        $student->delete();

        return redirect()->route('students.index')
            ->with('success', "Student '{$name}' deleted successfully!");
    }
}
