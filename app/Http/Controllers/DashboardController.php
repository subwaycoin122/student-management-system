<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Student;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index(): View
    {
        $totalStudents = Student::count();
        $totalDepartments = Department::count();
        $maleStudents = Student::where('gender', 'Male')->count();
        $femaleStudents = Student::where('gender', 'Female')->count();
        $otherStudents = Student::where('gender', 'Other')->count();

        $recentStudents = Student::with('department')
            ->orderBy('student_id', 'desc')
            ->take(5)
            ->get();

        $departmentsSummary = Department::withCount('students')
            ->orderBy('students_count', 'desc')
            ->take(6)
            ->get();

        return view('dashboard', compact(
            'totalStudents',
            'totalDepartments',
            'maleStudents',
            'femaleStudents',
            'otherStudents',
            'recentStudents',
            'departmentsSummary'
        ));
    }
}
