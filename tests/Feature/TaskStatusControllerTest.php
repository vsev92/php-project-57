<?php

namespace Tests;

use App\Models\Task;
use Tests\TestCase;

class TaskStatusControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testIndex(): void
    {
        $response = $this->get(route('task_statuses.index'));
        $response->assertOk();
    }


    public function testCreate(): void
    {
        $response = $this->get(route('task_statuses.create'));
        $response->assertStatus(403);
        $response = $this->actingAs($this->user)->get(route('task_statuses.create'));
        $response->assertOk();
    }



    public function testStore(): void
    {
        $data = ['name' => 'testStatusName'];
        $invalidData = ['name' => ''];

        $response = $this->post(route('task_statuses.store'), $data);
        $this->assertDatabaseMissing('task_statuses', $data);

        $response = $this->actingAs($this->user)->post(route('task_statuses.store'), $invalidData);
        $response->assertInvalid(['name']);
        $response = $this->actingAs($this->user)->post(route('task_statuses.store'), $data);
        $response->assertValid();
        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseHas('task_statuses', $data);
        $response = $this->actingAs($this->user)->post(route('task_statuses.store'), $data);
        $response->assertInvalid(['name']);
    }



    public function testEdit(): void
    {
        $id = $this->status->id;
        $response = $this->get(route('task_statuses.edit', $id));
        $response->assertStatus(403);
        $response = $this->actingAs($this->user)->get(route('task_statuses.edit', $id));
        $response->assertOk();
    }


    public function testDelete(): void
    {
        $id = $this->status->id;

        $response = $this->delete(route('task_statuses.destroy', $id));
        $this->assertDatabaseHas('task_statuses', ['id' =>  $id]);

        $task = Task::factory()->create(['status_id' => $this->status->id]);
        $response = $this->actingAs($this->user)->delete(route('task_statuses.destroy', $id));
        $this->assertDatabaseHas('task_statuses', ['id' =>  $id]);
        $task->delete();

        $response = $this->actingAs($this->user)->delete(route('task_statuses.destroy', $id));
        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseMissing('task_statuses', ['id' =>  $id]);
    }



    public function testUpdate(): void
    {
        $id = $this->status->id;
        $newData = ['name' => 'newName'];
        $invalidData = ['name' => ''];

        $response = $this->patch(route('task_statuses.update', $id), $newData);
        $this->assertDatabaseMissing('task_statuses', $newData);
        $response = $this->actingAs($this->user)->patch(route('task_statuses.update', $id), $invalidData);
        $response->assertInvalid(['name']);
        $response = $this->actingAs($this->user)->patch(route('task_statuses.update', $id), $newData);
        $response->assertValid();
        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseHas('task_statuses', $newData);
    }
}
