<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\TaskStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statuses = TaskStatus::all();
        $users = User::all();
        $tasks = Task::all();
        return view('tasks.index', compact('statuses', 'users', 'tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $statuses = TaskStatus::all();
        $users = User::all();
        $task = new Task();
        return view('tasks.create', compact('task', 'statuses', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $data = $request->validate([
            'name' => 'required',
            'status_id' => 'required',
            'assigned_to_id' => 'required'

        ]);
        $data['created_by_id'] =  Auth::id();
        $task = new Task();
        $task->fill($data);
        $task->save();
        return redirect()->route('task.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $statuses = TaskStatus::all();
        $users = User::all();
        return view('tasks.edit', compact('task', 'statuses', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {


        $newTask = Task::findOrFail($task->id);
        $data = $request->validate([

            'name' => 'required',
            'status_id' => 'required',
            'assigned_to_id' => 'required',
            'description' => 'max:1000'
        ]);
        // dd($data);
        $newTask->fill($data);
        $newTask->save();

        return redirect()->route('task.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('task.index');
    }
}
