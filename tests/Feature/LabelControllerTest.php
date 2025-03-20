<?php

namespace Tests;

use Tests\TestCase;

class LabelControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testIndex(): void
    {
        $response = $this->get(route('labels.index'));
        $response->assertOk();
    }


    public function testCreate(): void
    {
        $response = $this->get(route('labels.create'));
        $response->assertForbidden();
        $response = $this->actingAs($this->user)->get(route('labels.create'));
        $response->assertOk();
    }

    public function testStore(): void
    {
        $data = ['name' => 'testName'];
        $invalidData = ['name' => ''];

        $response = $this->post(route('labels.store', $data));
        $this->assertDatabaseMissing('labels', $data);

        $response = $this->actingAs($this->user)->post(route('labels.store', $invalidData));
        $response->assertInvalid(['name']);
        $response = $this->actingAs($this->user)->post(route('labels.store', $data));
        $response->assertValid();
        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseHas('labels', $data);
        $response = $this->actingAs($this->user)->post(route('labels.store', $data));
        $response->assertInvalid(['name']);
    }

    public function testEdit(): void
    {
        $id = $this->label->id;
        $response = $this->get(route('labels.edit', $id));
        $response->assertForbidden();
        $response = $this->actingAs($this->user)->get(route('labels.edit', $id));
        $response->assertOk();
    }


    public function testDelete(): void
    {
        $id = $this->label->id;

        $response = $this->delete(route('labels.destroy', $id));
        $this->assertDatabaseHas('labels', ['id' => $id]);

        $this->label->tasks()->attach([$this->task]);
        $response = $this->actingAs($this->user)->delete(route('labels.destroy', $id));
        $this->assertDatabaseHas('labels', ['id' => $id]);
        $this->label->tasks()->detach();

        $response = $this->actingAs($this->user)->delete(route('labels.destroy', $id));
        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseMissing('labels', ['id' => $id]);
    }



    public function testUpdate(): void
    {
        $id = $this->label->id;
        $newData = ['name' => 'newName'];
        $invalidData = ['name' => ''];

        $response = $this->patch(route('labels.update', $id), $newData);
        $this->assertDatabaseMissing('labels', $newData);

        $response = $this->actingAs($this->user)->patch(route('labels.update', $id), $invalidData);
        $response->assertInvalid(['name']);
        $response = $this->actingAs($this->user)->patch(route('labels.update', $id), $newData);
        $response->assertValid();
        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseHas('labels', $newData);
    }
}
