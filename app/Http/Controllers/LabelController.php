<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreLabelRequest;

class LabelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $labels = Label::paginate();
        return view('labels.index', compact('labels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Gate::allows('create-label')) {
            abort(403);
        } else {
            $label = new Label();
            return view('labels.create', compact('label'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLabelRequest $request)
    {
        if (Gate::allows('store-label')) {
            $data = $request->validated();
            $label = new Label();
            $label->fill($data);
            $label->description = $request->description;
            $label->save();
            flash('Метка успешно создана')->success();
        }
        return redirect()->route('labels.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Label $label)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Label $label)
    {
        if (!Gate::allows('edit-label')) {
            abort(403);
        } else {
            return view('labels.edit', compact('label'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Label $label)
    {
        if (Gate::allows('update-label')) {
            $label = Label::findOrFail($label->id);
            $data = $request->validate([
                'name' => "required",
            ]);
            $label->description = $request->description;
            $label->fill($data);
            $label->save();
            flash('Метка успешно изменена')->success();
        }
        return redirect()->route('labels.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Label $label, Request $request)
    {
        if (!Gate::allows('delete-label')  || ($label->tasks->all()) !== []) {
            $request->session()->flash('error', 'Не удалось удалить метку');
        } else {
            $label->delete();
            flash('Метка успешно удалена')->success();
        }
        return redirect()->route('labels.index');
    }
}
