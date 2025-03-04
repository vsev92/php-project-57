@extends('layouts.home')
@section('content')
@vite(['resources/css/app.css', 'resources/js/app.js'])

<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="csrf-param" content="_token">

<section class="bg-white dark:bg-gray-900">
    <div class="grid max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
        <div class="grid col-span-full">
            <h1 class="mb-5">Задачи</h1>

            <div class="w-full flex items-center">
                <div>
                    <form method="GET" action="{{route('task.index')}}">
                        <div class="flex">
                            <select class="rounded border-gray-300" name="filter[status_id]" id="filter[status_id]">
                                <option value selected="selected">Статус</option>
                                @foreach($statuses as $status)
                                <option value="{{$status->id}}"> {{$status->name}} </option>
                                @endforeach
                            </select>
                            <select class="rounded border-gray-300" name="filter[created_by_id]" id="filter[created_by_id]">
                                <option value selected="selected">Автор</option>
                                @foreach($users as $user)
                                <option value="{{$user->id}}"> {{$user->name}} </option>
                                @endforeach
                            </select>
                            <select class="rounded border-gray-300" name="filter[assigned_to_id]" id="filter[assigned_to_id]">
                                <option value selected="selected">Исполнитель</option>
                                @foreach($users as $user)
                                <option value="{{$user->id}}"> {{$user->name}} </option>
                                @endforeach
                            </select>
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2" type="submit">Применить</button>
                    </form>
                </div>
            </div>

            <div class="ml-auto">
                <a href="{{route('task.create')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2">
                    Создать задачу </a>
            </div>
        </div>

        <table class="mt-4">
            <thead class="border-b-2 border-solid border-black text-left">
                <tr>
                    <th>ID</th>
                    <th>Статус</th>
                    <th>Имя</th>
                    <th>Автор</th>
                    <th>Исполнитель</th>
                    <th>Дата создания</th>
                    <th>Действия</th>
                </tr>
            </thead>

            @foreach($tasks as $task)
            <tr class="border-b border-dashed text-left">
                <td>{{$task->id}}</td>
                <td>{{$task->status->name}}</td>
                <td>
                    <a class="text-blue-600 hover:text-blue-900" href="{{route('task.show', $task->id)}}">
                        {{$task->name}}
                    </a>
                </td>
                <td>{{$task->created_by->name}}</td>
                <td>{{$task->assigned_to->name}}</td>
                <td>{{$task->updated_at}}</td>

                <td>
                    <a href="{{route('task.edit', $task->id)}}" class="text-blue-600 hover:text-blue-900">
                        Изменить </a>
                </td>
            </tr>
            @endforeach
        </table>

        <div class="mt-4">
            {{ $tasks->links() }}

        </div>
    </div>
    </div>
</section>
@endsection