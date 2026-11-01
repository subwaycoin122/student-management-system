<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = Department::all()->keyBy('dept_name');

        if ($departments->isEmpty()) {
            return;
        }

        $csId = $departments['Computer Science']->dept_id ?? 1;
        $itId = $departments['Information Technology']->dept_id ?? 1;
        $seId = $departments['Software Engineering']->dept_id ?? 1;
        $baId = $departments['Business Administration']->dept_id ?? 1;
        $eeId = $departments['Electrical Engineering']->dept_id ?? 1;
        $gdId = $departments['Graphic Design & Digital Media']->dept_id ?? 1;

        $students = [
            [
                'student_name' => 'Alice Johnson',
                'gender' => 'Female',
                'dob' => '2004-03-15',
                'enrollment' => 'ENR-2024-001',
                'enrollment_date' => '2024-09-01',
                'description' => 'Honors student in Algorithms and AI systems.',
                'dept_id' => $csId,
            ],
            [
                'student_name' => 'Brian Miller',
                'gender' => 'Male',
                'dob' => '2003-07-22',
                'enrollment' => 'ENR-2024-002',
                'enrollment_date' => '2024-09-01',
                'description' => 'Interested in Cloud computing and DevOps pipeline management.',
                'dept_id' => $itId,
            ],
            [
                'student_name' => 'Chloe Davis',
                'gender' => 'Female',
                'dob' => '2004-11-05',
                'enrollment' => 'ENR-2024-003',
                'enrollment_date' => '2024-09-01',
                'description' => 'President of the Open Source Development Club.',
                'dept_id' => $seId,
            ],
            [
                'student_name' => 'Daniel Garcia',
                'gender' => 'Male',
                'dob' => '2003-01-18',
                'enrollment' => 'ENR-2024-004',
                'enrollment_date' => '2024-09-01',
                'description' => 'Focusing on International Business and Financial Modeling.',
                'dept_id' => $baId,
            ],
            [
                'student_name' => 'Emily Watson',
                'gender' => 'Female',
                'dob' => '2004-08-30',
                'enrollment' => 'ENR-2024-005',
                'enrollment_date' => '2024-09-01',
                'description' => 'Researching embedded IoT sensors and smart grid power.',
                'dept_id' => $eeId,
            ],
            [
                'student_name' => 'Felix Martinez',
                'gender' => 'Male',
                'dob' => '2005-02-14',
                'enrollment' => 'ENR-2025-006',
                'enrollment_date' => '2025-02-15',
                'description' => 'Specializing in UI/UX typography and 3D visual effects.',
                'dept_id' => $gdId,
            ],
            [
                'student_name' => 'Grace Hopper',
                'gender' => 'Female',
                'dob' => '2003-12-09',
                'enrollment' => 'ENR-2024-007',
                'enrollment_date' => '2024-09-01',
                'description' => 'Top performing student in Compiler Construction & Machine Learning.',
                'dept_id' => $csId,
            ],
            [
                'student_name' => 'Henry Chen',
                'gender' => 'Male',
                'dob' => '2004-05-20',
                'enrollment' => 'ENR-2024-008',
                'enrollment_date' => '2024-09-01',
                'description' => 'Network security analyst trainee and cybersecurity enthusiast.',
                'dept_id' => $itId,
            ],
            [
                'student_name' => 'Isabella Taylor',
                'gender' => 'Female',
                'dob' => '2005-06-11',
                'enrollment' => 'ENR-2025-009',
                'enrollment_date' => '2025-02-15',
                'description' => 'Working on agile test-driven development methodologies.',
                'dept_id' => $seId,
            ],
            [
                'student_name' => 'James Wilson',
                'gender' => 'Male',
                'dob' => '2002-09-17',
                'enrollment' => 'ENR-2023-010',
                'enrollment_date' => '2023-09-01',
                'description' => 'Senior student completing capstone thesis on digital entrepreneurship.',
                'dept_id' => $baId,
            ],
        ];

        foreach ($students as $student) {
            Student::create($student);
        }
    }
}
