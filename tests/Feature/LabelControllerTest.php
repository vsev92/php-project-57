<?php

namespace Tests;

use App\Models\User;
use App\Models\TaskStatus;
use App\Models\Task;
use App\Models\Label;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LabelControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private TaskStatus $status;
    private Task $task;
    private Label $label;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->status =  TaskStatus::factory()->create();
        $this->task = Task::factory()->create();
        $this->label = Label::factory()->create();
    }

    public function testIndex(): void
    {
        $response = $this->get('/labels');
        $response->assertStatus(200);
    }


    public function testCreate(): void
    {
        $response = $this->get('/labels/create');
        $response->assertStatus(200);
    }

    public function testStore(): void
    {
        $data = [
            'name' => 'testName'
        ];
        $response = $this->post('/labels', $data);
        $this->assertDatabaseMissing('labels', $data);

        $response = $this->actingAs($this->user)->post('/labels', $data);
        $this->assertDatabaseHas('labels', $data);

        $response->assertRedirect(route('labels.index'));
    }

    public function testEdit(): void
    {

        $url = "/labels/{$this->label->id}/edit";
        $response = $this->get($url);
        $response->assertStatus(200);
    }


    public function testDelete(): void
    {
        $id = $this->label->id;
        $url = "/labels/{$id}";

        $response = $this->delete($url);
        $this->assertDatabaseHas('labels', ['id' => $id]);

        $this->label->tasks()->attach([$this->task]);
        $response = $this->actingAs($this->user)->delete($url);
        $this->assertDatabaseHas('labels', ['id' => $id]);
        $this->label->tasks()->detach();

        $response = $this->actingAs($this->user)->delete($url);
        $this->assertDatabaseMissing('labels', ['id' => $id]);


        $response->assertRedirect(route('labels.index'));
    }



    public function testUpdate(): void
    {

        $id = $this->label->id;
        $newData = ['name' => 'newName'];
        $url = "/labels/{$id}";

        $response = $this->patch($url, $newData);
        $this->assertDatabaseMissing('labels', $newData);

        $response = $this->actingAs($this->user)->patch($url, $newData);
        $this->assertDatabaseHas('labels', $newData);

        $response->assertRedirect(route('labels.index'));
    }
}
