<div class="flex flex-col">
    <div>
        <label for="name">Имя</label>
    </div>
    <div class="mt-2">
        <input class="rounded border-gray-300 w-1/3" type="text" name="name" id="name" value="{{$task->id}}">
    </div>
    @if ($errors->has('name'))
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->get('name') as $error)
            <li class="text-rose-600">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="mt-2">
        <label for="description">Описание</label>
    </div>
    <div>
        <textarea class="rounded border-gray-300 w-1/3 h-32" name="description" id="description">{{$task->description}}</textarea>
    </div>
    <div class="mt-2">
        <label for="status_id">Статус</label>
    </div>
    <div>
        <select class="rounded border-gray-300 w-1/3" name="status_id" id="status_id">
            <option value=""></option>
            @foreach ($statuses as $taskStatus)
            <option value="{{$taskStatus->id}}"> {{$taskStatus->name}} </option>
            @endforeach
        </select>
    </div>
    @if ($errors->has('status_id'))
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->get('status_id') as $error)
            <li class="text-rose-600">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="mt-2">
        <label for="assigned_to_id">Исполнитель</label>
    </div>
    <div>
        <select class="rounded border-gray-300 w-1/3" name="assigned_to_id" id="assigned_to_id">
            <option value=""></option>
            @foreach ($users as $user)
            <option value="{{$user->id}}"> {{$user->name}} </option>
            @endforeach
        </select>
    </div>
    <div class="mt-2">
        <label for="labels[]">Метки</label>
    </div>
    <div>
        <select class="rounded border-gray-300 w-1/3 h-32" name="labels[]" id="labels[]" multiple>
            @foreach ($labels as $label)
            <option value="{{$label->id}}"> {{$label->name}} </option>
            @endforeach
        </select>
    </div>
</div>