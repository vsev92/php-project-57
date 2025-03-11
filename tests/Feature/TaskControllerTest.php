<?php

namespace Tests;

use App\Models\User;
use App\Models\TaskStatus;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;


class TaskControllerTest extends TestCase
{
    use RefreshDatabase;
    private $user;
    private $status;
    private $task;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->status =  TaskStatus::factory()->create();
        $this->task = Task::factory()->create();
    }

    public function test_index(): void
    {
        $response = $this->get('/tasks');
        $response->assertStatus(200);
    }


    public function test_create(): void
    {
        $response = $this->get('/tasks/create');
        $response->assertStatus(200);
    }

    public function test_store(): void
    {



        $taskData = [
            'name' => 'taskName',
            'status_id' => $this->status->id,
        ];
        $response = $this->post('/tasks', $taskData);
        $this->assertDatabaseMissing('tasks', $taskData);

        $response = $this->actingAs($this->user)->post('/tasks', $taskData);
        $this->assertDatabaseHas('tasks', $taskData);

        $response->assertRedirect(route('tasks.index'));
    }

    public function test_edit(): void
    {

        $url = "/tasks/{$this->task->id}/edit";
        $response = $this->get($url);
        $response->assertStatus(200);
    }


    public function test_delete(): void
    {
        $id = $this->task->id;
        $url = "/tasks/{$id}";

        $response = $this->delete($url);
        $this->assertDatabaseHas('tasks', ['id' => $id]);
        $response->assertRedirect(route('tasks.index'));


        $otherUser = User::factory()->create();
        $this->assertDatabaseHas('tasks', ['id' => $id]);
        $response = $this->actingAs($otherUser)->delete($url);


        $response = $this->actingAs($this->task->created_by)->delete($url);
        $this->assertDatabaseMissing('tasks', ['id' => $id]);
        $response->assertRedirect(route('tasks.index'));
    }



    public function test_update(): void
    {

        $newStatus = TaskStatus::factory()->create();
        $newTaskData = ['name' => 'newName', 'status_id' => $newStatus->id];

        $url = "/tasks/{$this->task->id}";

        $response = $this->patch($url, $newTaskData);
        $this->assertDatabaseMissing('tasks', $newTaskData);



        $response = $this->actingAs($this->user)->patch($url, $newTaskData);
        $this->assertDatabaseHas('tasks', $newTaskData);
        $response->assertRedirect(route('tasks.index'));
    }
}
