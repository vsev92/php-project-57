<?php

namespace Tests;

use App\Models\User;
use App\Models\TaskStatus;

use Tests\TestCase;

class TaskControllerTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testIndex(): void
    {
        $response = $this->get(route('tasks.index'));
        $response->assertOk();
    }


    public function testCreate(): void
    {
        $response = $this->get(route('tasks.create'));
        $response->assertForbidden();
        $response = $this->actingAs($this->user)->get(route('tasks.create'));
        $response->assertOk();
    }

    public function testStore(): void
    {
        $taskData = ['name' => 'taskName', 'status_id' => $this->status->id];
        $invalidTaskData = ['name' => '', 'status_id' => ''];

        $response = $this->post(route('tasks.store'), $taskData);
        $this->assertDatabaseMissing('tasks', $taskData);

        $response = $this->actingAs($this->user)->post(route('tasks.store'), $invalidTaskData);
        $response->assertInvalid(['name', 'status_id']);
        $response = $this->actingAs($this->user)->post(route('tasks.store'), $taskData);
        $response->assertValid();
        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', $taskData);
    }

    public function testEdit(): void
    {
        $id = $this->task->id;
        $response = $this->get(route('tasks.edit', $id));
        $response->assertForbidden();
        $response = $this->actingAs($this->user)->get(route('tasks.edit', $id));
        $response->assertOk();
    }


    public function testDelete(): void
    {
        $id = $this->task->id;
        $response = $this->delete(route('tasks.destroy', $id));
        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', ['id' => $id]);

        $otherUser = User::factory()->create();
        $this->assertDatabaseHas('tasks', ['id' => $id]);
        $response = $this->actingAs($otherUser)->delete(route('tasks.destroy', $id));

        $response = $this->actingAs($this->task->creator)->delete(route('tasks.destroy', $id));
        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseMissing('tasks', ['id' => $id]);
    }



    public function testUpdate(): void
    {
        $newStatus = TaskStatus::factory()->create();
        $taskData = ['name' => 'newName', 'status_id' => $newStatus->id];
        $invalidTaskData = ['name' => '', 'status_id' => ''];
        $id = $this->task->id;

        $response = $this->patch(route('tasks.update', $id), $taskData);
        $this->assertDatabaseMissing('tasks', $taskData);

        $response = $this->actingAs($this->user)->patch(route('tasks.update', $id), $invalidTaskData);
        $response->assertInvalid(['name', 'status_id']);
        $response = $this->actingAs($this->user)->patch(route('tasks.update', $id), $taskData);
        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', $taskData);
    }
}
