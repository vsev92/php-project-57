<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statuses = TaskStatus::paginate();

        return view('statuses.index', compact('statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $taskStatus = new TaskStatus();
        return view('statuses.create', compact('taskStatus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',

        ]);
        $status = new TaskStatus();
        $status->fill($data);
        $status->save();
        return redirect()->route('task_statuses.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(TaskStatus $taskStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TaskStatus $taskStatus)
    {
        return view('statuses.edit', compact('taskStatus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TaskStatus $taskStatus)
    {

        $stat = TaskStatus::findOrFail($taskStatus->id);
        $data = $request->validate([

            'name' => "required"
        ]);

        $stat->fill($data);
        $stat->save();
        return redirect()->route('task_statuses.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskStatus $taskStatus, Request $request)
    {

        if (Task::where('status_id', $taskStatus->id)->count() > 0) {
            $request->session()->flash('error', 'Не удалось удалить статус');
        } else {
            $taskStatus->delete();
        }
        return redirect()->route('task_statuses.index');
    }
}
