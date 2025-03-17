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

    private User $user;
    private TaskStatus $status;
    private Task $task;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->status =  TaskStatus::factory()->create();
        $this->task = Task::factory()->create();
    }

    public function testIndex(): void
    {
        $response = $this->get('/tasks');
        $response->assertStatus(200);
    }


    public function testCreate(): void
    {
        $response = $this->get('/tasks/create');
        $response->assertStatus(200);
    }

    public function testStore(): void
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

    public function testEdit(): void
    {

        $url = "/tasks/{$this->task->id}/edit";
        $response = $this->get($url);
        $response->assertStatus(200);
    }


    public function testDelete(): void
    {
        $id = $this->task->id;
        $url = "/tasks/{$id}";

        $response = $this->delete($url);
        $this->assertDatabaseHas('tasks', ['id' => $id]);
        $response->assertRedirect(route('tasks.index'));


        $otherUser = User::factory()->create();
        $this->assertDatabaseHas('tasks', ['id' => $id]);
        $response = $this->actingAs($otherUser)->delete($url);


        $response = $this->actingAs($this->task->creator)->delete($url);
        $this->assertDatabaseMissing('tasks', ['id' => $id]);
        $response->assertRedirect(route('tasks.index'));
    }



    public function testUpdate(): void
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
