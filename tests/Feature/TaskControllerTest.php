<?php

namespace Tests;

use App\Models\User;
use App\Models\TaskStatus;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;



    public function test_index(): void
    {
        $response = $this->get('/task');
        $response->assertStatus(200);
    }


    public function test_create(): void
    {
        $response = $this->get('/task/create');
        $response->assertStatus(200);
    }

    public function test_store(): void
    {
        $user = User::create(['id' => 1, 'name' => 'testUserName1', 'email' => 'testUser1@mail.ru', 'password' => 'pass1']);
        $user->save();
        $taskData = ['id' => 1, 'name' => 'testTask', 'status_id' => 1, 'created_by_id' => $user->id];
        $response = $this->post('/task', $taskData);
        $response->assertRedirect(route('task.index'));
        $this->assertDatabaseHas('tasks', $taskData);
    }

    public function test_edit(): void
    {
        $user = User::create(['id' => 1, 'name' => 'testUserName1', 'email' => 'testUser1@mail.ru', 'password' => 'pass1']);
        $user->save();
        $status = TaskStatus::create(['name' => 'testStatindex']);
        $status->save();
        $taskData = ['name' => 'testTask', 'status_id' => $status->id, 'created_by_id' => $user->id];
        $task = Task::create($taskData);
        $task->save();
        $url = "/task/{$task->id}/edit";
        $response = $this->get($url);
        $response->assertStatus(200);
    }


    public function test_delete(): void
    {

        $user = User::create(['id' => 1, 'name' => 'testUserName1', 'email' => 'testUser1@mail.ru', 'password' => 'pass1']);
        $user->save();
        $status = TaskStatus::create(['name' => 'testStatindex']);
        $status->save();
        $taskData = ['name' => 'testTask', 'status_id' => $status->id, 'created_by_id' => $user->id];
        $task = Task::create($taskData);
        $task->save();
        $url = "/task/{$task->id}";
        $response = $this->delete($url);
        $response->assertRedirect(route('task.index'));
        $this->assertDatabaseMissing('tasks', $taskData);
    }

    public function test_assigned_status_not_delete(): void
    {
        $user = User::create(['id' => 1, 'name' => 'testUserName1', 'email' => 'testUser1@mail.ru', 'password' => 'pass1']);
        $user->save();
        $status = TaskStatus::create(['name' => 'testStatindex']);
        $status->save();
        $taskData = ['name' => 'testTask', 'status_id' => $status->id, 'created_by_id' => $user->id];
        $task = Task::create($taskData);
        $task->save();
        $url = "/task/{$task->id}";
        $response = $this->delete($url);
        $response->assertRedirect(route('task.index'));
        $this->assertDatabaseMissing('tasks', $taskData);
    }

    public function test_update(): void
    {
        $user = User::create(['id' => 1, 'name' => 'testUserName1', 'email' => 'testUser1@mail.ru', 'password' => 'pass1']);
        $user->save();
        $status = TaskStatus::create(['name' => 'testStatindex']);
        $status->save();
        $taskData = ['name' => 'testTask', 'status_id' => $status->id, 'created_by_id' => $user->id];
        $task = Task::create($taskData);
        $task->save();


        $taskNewData = ['name' => 'NewTestTask', 'status_id' => $status->id, 'created_by_id' => $user->id];
        $response = $this->patch('/task', $taskNewData);
        $response->assertRedirect(route('task.index'));
        $this->assertDatabaseHas('tasks', $taskNewData);

        $taskNewData = ['name' => 'NewTestTask', 'status_id' => null, 'created_by_id' => null];
        $response = $this->patch('/task', ['name' => '']);
        $this->assertDatabaseMissing('tasks', $taskNewData);
    }
}
