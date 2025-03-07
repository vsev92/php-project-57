<?php

namespace Tests;

use App\Models\User;
use App\Models\TaskStatus;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskStatusControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index(): void
    {
        $status = TaskStatus::create(['name' => 'testStatindex']);
        $status->save();

        $response = $this->get('/task_statuses');

        $response->assertStatus(200);
    }

    public function test_create(): void
    {

        $response = $this->get('/task_statuses/create');
        $response->assertStatus(200);
    }

    public function test_store(): void
    {
        $this->assertDatabaseMissing('task_statuses', ['name' => 'testStatusName']);
        $response = $this->post('/task_statuses', ['name' => 'testStatusName']);
        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseHas('task_statuses', ['name' => 'testStatusName']);
    }

    public function test_edit(): void
    {
        $status = TaskStatus::create(['name' => 'testStatindex']);
        $status->save();
        $url = "/task_statuses/{$status->id}/edit";
        $response = $this->get($url);
        $response->assertStatus(200);
    }


    public function test_delete(): void
    {

        $status = TaskStatus::create(['name' => 'testStatusName']);
        $status->save();
        $url = "/task_statuses/{$status->id}";
        $response = $this->delete($url);
        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseMissing('task_statuses', ['id' => $status->id, 'name' => 'testStatusName']);
    }

    public function test_assigned_status_not_delete(): void
    {
        $user1 = User::create(['id' => 1, 'name' => 'testUserName1', 'email' => 'testUser1@mail.ru', 'password' => 'pass1']);
        $user1->save();
        $user2 = User::create(['id' => 2, 'name' => 'testUserName2', 'email' => 'testUser2@mail.ru', 'password' => 'pass2']);
        $user2->save();

        $status = TaskStatus::create(['name' => 'testStatusName']);
        $status->save();
        $task = Task::create(['name' => 'testTask', 'status_id' => $status->id, 'created_by_id' => $user1->id, 'assigned_to_id' => $user2->id]);
        $task->save();

        $url = "/task_statuses/{$status->id}";
        $response = $this->delete($url);
        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseHas('task_statuses', ['id' => $status->id, 'name' => 'testStatusName']);
    }

    public function test_update(): void
    {
        $status = TaskStatus::create(['name' => 'testStatusName']);
        $status->save();
        $url = "/task_statuses/{$status->id}";
        $response = $this->patch($url, ['name' => 'newName']);
        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseHas('task_statuses', ['id' => $status->id, 'name' => 'newName']);
        $response = $this->patch($url, ['name' => '']);
        $this->assertDatabaseHas('task_statuses', ['id' => $status->id, 'name' => 'newName']);
    }
}
