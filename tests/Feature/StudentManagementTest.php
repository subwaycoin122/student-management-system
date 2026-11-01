<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'email' => 'admin@example.com',
            'name' => 'Admin User',
        ]);
    }

    /**
     * Test Guest is redirected to login.
     */
    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');

        $response = $this->get('/students');
        $response->assertRedirect('/login');

        $response = $this->get('/departments');
        $response->assertRedirect('/login');
    }

    /**
     * Test Login and Logout.
     */
    public function test_user_can_login_and_logout(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($this->user);

        $logoutResponse = $this->post('/logout');
        $logoutResponse->assertRedirect('/login');
        $this->assertGuest();
    }

    /**
     * Test User Registration.
     */
    public function test_user_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertDatabaseHas('users', ['email' => 'newuser@example.com']);
    }

    /**
     * Test Department CRUD operations (Insert, Read, Update, Delete).
     */
    public function test_department_crud_operations(): void
    {
        // 1. Create / Insert
        $createResponse = $this->actingAs($this->user)->post('/departments', [
            'dept_name' => 'Civil Engineering',
            'manager_id' => 'MGR-701',
            'location_id' => 'Engineering Hall - Room 101',
        ]);

        $createResponse->assertRedirect(route('departments.index'));
        $this->assertDatabaseHas('departments', [
            'dept_name' => 'Civil Engineering',
            'manager_id' => 'MGR-701',
        ]);

        $dept = Department::where('dept_name', 'Civil Engineering')->firstOrFail();

        // 2. Read / List & Search
        $listResponse = $this->actingAs($this->user)->get('/departments?search=Civil');
        $listResponse->assertStatus(200);
        $listResponse->assertSee('Civil Engineering');

        // 3. Update
        $updateResponse = $this->actingAs($this->user)->put("/departments/{$dept->dept_id}", [
            'dept_name' => 'Civil & Environmental Engineering',
            'manager_id' => 'MGR-702',
            'location_id' => 'Hall B - Room 202',
        ]);

        $updateResponse->assertRedirect(route('departments.index'));
        $this->assertDatabaseHas('departments', [
            'dept_id' => $dept->dept_id,
            'dept_name' => 'Civil & Environmental Engineering',
        ]);

        // 4. Delete
        $deleteResponse = $this->actingAs($this->user)->delete("/departments/{$dept->dept_id}");
        $deleteResponse->assertRedirect(route('departments.index'));
        $this->assertDatabaseMissing('departments', ['dept_id' => $dept->dept_id]);
    }

    /**
     * Test Student CRUD operations with Department relationship, Search, and Filters.
     */
    public function test_student_crud_operations(): void
    {
        // Setup Department
        $dept = Department::create([
            'dept_name' => 'Artificial Intelligence',
            'manager_id' => 'MGR-801',
            'location_id' => 'AI Lab',
        ]);

        // 1. Create / Insert Student with relation to Department
        $createResponse = $this->actingAs($this->user)->post('/students', [
            'student_name' => 'David Copperfield',
            'gender' => 'Male',
            'dob' => '2004-06-15',
            'enrollment' => 'ENR-2026-999',
            'enrollment_date' => '2026-09-01',
            'description' => 'Specializes in robotics and neural networks.',
            'dept_id' => $dept->dept_id,
        ]);

        $createResponse->assertRedirect(route('students.index'));
        $this->assertDatabaseHas('students', [
            'student_name' => 'David Copperfield',
            'enrollment' => 'ENR-2026-999',
            'dept_id' => $dept->dept_id,
        ]);

        $student = Student::where('enrollment', 'ENR-2026-999')->firstOrFail();
        $this->assertEquals('Artificial Intelligence', $student->department->dept_name);

        // 2. Search by Name
        $searchResponse = $this->actingAs($this->user)->get('/students?search=David');
        $searchResponse->assertStatus(200);
        $searchResponse->assertSee('David Copperfield');
        $searchResponse->assertSee('Artificial Intelligence');

        // 3. Filter by Department
        $filterDeptResponse = $this->actingAs($this->user)->get("/students?dept_id={$dept->dept_id}");
        $filterDeptResponse->assertStatus(200);
        $filterDeptResponse->assertSee('David Copperfield');

        // 4. Filter by Gender
        $filterGenderResponse = $this->actingAs($this->user)->get('/students?gender=Male');
        $filterGenderResponse->assertStatus(200);
        $filterGenderResponse->assertSee('David Copperfield');

        // 5. Update Student
        $updateResponse = $this->actingAs($this->user)->put("/students/{$student->student_id}", [
            'student_name' => 'David Copperfield Jr.',
            'gender' => 'Male',
            'dob' => '2004-06-15',
            'enrollment' => 'ENR-2026-999',
            'enrollment_date' => '2026-09-01',
            'description' => 'Updated thesis topic to deep reinforcement learning.',
            'dept_id' => $dept->dept_id,
        ]);

        $updateResponse->assertRedirect(route('students.index'));
        $this->assertDatabaseHas('students', [
            'student_id' => $student->student_id,
            'student_name' => 'David Copperfield Jr.',
        ]);

        // 6. Delete Student
        $deleteResponse = $this->actingAs($this->user)->delete("/students/{$student->student_id}");
        $deleteResponse->assertRedirect(route('students.index'));
        $this->assertDatabaseMissing('students', ['student_id' => $student->student_id]);
    }
}
