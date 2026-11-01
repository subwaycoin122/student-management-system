<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'dept_name' => 'Computer Science',
                'manager_id' => 'MGR-101',
                'location_id' => 'Tech Wing - Floor 3',
            ],
            [
                'dept_name' => 'Information Technology',
                'manager_id' => 'MGR-102',
                'location_id' => 'Tech Wing - Floor 2',
            ],
            [
                'dept_name' => 'Software Engineering',
                'manager_id' => 'MGR-103',
                'location_id' => 'Innovation Lab - Floor 4',
            ],
            [
                'dept_name' => 'Business Administration',
                'manager_id' => 'MGR-104',
                'location_id' => 'Commerce Hall - Room 201',
            ],
            [
                'dept_name' => 'Electrical Engineering',
                'manager_id' => 'MGR-105',
                'location_id' => 'Science Complex - Lab B',
            ],
            [
                'dept_name' => 'Graphic Design & Digital Media',
                'manager_id' => 'MGR-106',
                'location_id' => 'Creative Arts Center - Studio 1',
            ],
        ];

        foreach ($departments as $dept) {
            Department::create($dept);
        }
    }
}
