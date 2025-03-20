<?php

namespace App\Http\Controllers;

use App\Models\Label;
use App\Models\Task;
use App\Models\User;
use App\Models\TaskStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $statuses = TaskStatus::all();
        $users = User::all();

        $tasks = QueryBuilder::for(Task::class)
            ->allowedFilters([
                AllowedFilter::exact('status_id'),
                AllowedFilter::exact('created_by_id'),
                AllowedFilter::exact('assigned_to_id')
            ])
            ->paginate(15);

        return view('tasks.index', compact('statuses', 'users', 'tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Gate::allows('create-task')) {
            abort(403);
        } else {
            $statuses = TaskStatus::all();
            $users = User::all();
            $labels = Label::all();
            $task = new Task();
            return view('tasks.create', compact('task', 'statuses', 'users', 'labels'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Gate::allows('store-task')) {
            $data = $request->validate([
                'name' => 'required',
                'status_id' => 'required',

            ]);
            $data['created_by_id'] =  Auth::id();
            $data['assigned_to_id'] =  $request->assigned_to_id;
            $task = new Task();
            $task->fill($data);
            $task->description = $request->description;
            $labels = $request->labels;
            $task->save();
            $task->labels()->attach($labels);
            $task->save();
            flash('Задача успешно создана')->success();
        }
        return redirect()->route('tasks.index');
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
        if (!Gate::allows('edit-task')) {
            abort(403);
        } else {
            $statuses = TaskStatus::all();
            $users = User::all();
            $labels = Label::all();
            return view('tasks.edit', compact('task', 'statuses', 'users', 'labels'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        if (Gate::allows('update-task')) {
            $newTask = Task::findOrFail($task->id);
            $data = $request->validate([

                'name' => 'required',
                'status_id' => 'required',
            ]);
            $newTask->fill($data);
            $newTask->description = $request->description;
            $newTask->assigned_to_id = $request->assigned_to_id;
            $labels = $request->labels;
            $newTask->labels()->detach();
            $newTask->labels()->attach($labels);
            $newTask->save();
            flash('Задача успешно изменена')->success();
        }
        return redirect()->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        if (Gate::allows('delete-task', $task)) {
            $task->delete();
            flash('Задача успешно удалена')->success();
        }
        return redirect()->route('tasks.index');
    }
}
