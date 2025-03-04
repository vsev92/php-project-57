<?php

namespace App\Http\Controllers;

use App\Models\Label;
use App\Models\Task;
use App\Models\User;
use App\Models\TaskStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $statuses = TaskStatus::all();
        $users = User::all();


        $filtersCollection = collect($request->filter ?? []);
        $filters = $filtersCollection->filter(fn($value, $key) => isset($value))->keys()->all();
        $tasks = QueryBuilder::for(Task::class)->allowedFilters($filters);
        $tasks = $tasks->paginate(4);

        return view('tasks.index', compact('statuses', 'users', 'tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $statuses = TaskStatus::all();
        $users = User::all();
        $labels = Label::all();
        $task = new Task();
        return view('tasks.create', compact('task', 'statuses', 'users', 'labels'));
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
        $labels = $request->labels;
        $task->save();
        $task->labels()->attach($labels);
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
        $labels = Label::all();
        return view('tasks.edit', compact('task', 'statuses', 'users', 'labels'));
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
        $newTask->fill($data);
        $labels = $request->labels;
        $newTask->labels()->detach();
        $newTask->labels()->attach($labels);
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
