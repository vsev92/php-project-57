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

    private $user;
    private $status;
    private $task;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->status =  TaskStatus::factory()->create();
    }

    public function testIndex(): void
    {
        $response = $this->get('/task_statuses');
        $response->assertStatus(200);
    }


    public function testCreate(): void
    {
        $response = $this->get('/task_statuses/create');
        $response->assertStatus(200);
    }



    public function testStore(): void
    {
        $data = ['name' => 'testStatusName'];

        $response = $this->post('/task_statuses', $data);
        $this->assertDatabaseMissing('task_statuses', $data);

        $response = $this->actingAs($this->user)->post('/task_statuses', $data);
        $this->assertDatabaseHas('task_statuses', $data);

        $response->assertRedirect(route('task_statuses.index'));
    }



    public function testEdit(): void
    {
        $url = "/task_statuses/{$this->status->id}/edit";
        $response = $this->get($url);
        $response->assertStatus(200);
    }


    public function testDelete(): void
    {

        $id = $this->status->id;
        $url = "/task_statuses/{$id}";

        $response = $this->delete($url);
        $this->assertDatabaseHas('task_statuses', ['id' =>  $id]);

        $task = Task::factory()->create(['status_id' => $this->status->id]);
        $response = $this->actingAs($this->user)->delete($url);
        $this->assertDatabaseHas('task_statuses', ['id' =>  $id]);
        $task->delete();

        $response = $this->actingAs($this->user)->delete($url);
        $this->assertDatabaseMissing('task_statuses', ['id' =>  $id]);

        $response->assertRedirect(route('task_statuses.index'));
    }



    public function testUpdate(): void
    {
        $id = $this->status->id;
        $newData = ['name' => 'newName'];
        $url = "/task_statuses/{$id}";

        $response = $this->patch($url, $newData);
        $this->assertDatabaseMissing('task_statuses', $newData);

        $response = $this->actingAs($this->user)->patch($url, $newData);
        $this->assertDatabaseHas('task_statuses', $newData);

        $response->assertRedirect(route('task_statuses.index'));
    }
}
