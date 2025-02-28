@if ($errors->any())
<div>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="flex flex-col">
    <div>
        <label for="name">Имя</label>
    </div>
    <div class="mt-2">
        <input class="rounded border-gray-300 w-1/3" type="text" name="name" id="name" value="{{$task->id}}">
    </div>
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
            <option value selected="selected"></option>
            @foreach ($statuses as $taskStatus)
            <option value="{{$taskStatus->id}}"> {{$taskStatus->name}} </option>
            @endforeach
        </select>
    </div>
    <div class="mt-2">
        <label for="status_id">Исполнитель</label>
    </div>
    <div>
        <select class="rounded border-gray-300 w-1/3" name="assigned_to_id" id="assigned_to_id">
            <option value selected="selected"></option>
            @foreach ($users as $user)
            <option value="{{$user->id}}"> {{$user->name}} </option>
            @endforeach
        </select>
    </div>
    <div class="mt-2">
        <label for="status_id">Метки</label>
    </div>
    <div>
        <select class="rounded border-gray-300 w-1/3 h-32" name="labels[]" id="labels[]" multiple>
            <option value="1">ошибка</option>
            <option value="2">документация</option>
            <option value="3">дубликат</option>
            <option value="4">доработка</option>
        </select>
    </div>
</div>