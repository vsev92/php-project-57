@if ($errors->any())
<div>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div>
    <label for="name">Имя</label>
</div>
<div class="mt-2">
    <input class="rounded border-gray-300 w-1/3" type="text" name="name" id="name" value="{{$label->name}}">
</div>
<div class="mt-2">
    <label for="description">Описание</label>
</div>
<div class="mt-2">
    <textarea class="rounded border-gray-300 w-1/3 h-32" name="description" id="description" value="{{$label->description}}"></textarea>
</div>