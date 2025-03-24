@extends('layouts.home')
@section('content')
<section class="bg-white dark:bg-gray-900">
    <div class="grid max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
        @include('flash::message')
        <div class="grid col-span-full">
            <h1 class="mb-5">Статусы</h1>
            @can('store', App\Models\TaskStatus::class)
            <div>
                <a href="{{route('task_statuses.create')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Создать статус </a>
            </div>
            @endcan
            <table class="mt-4">
                <thead class="border-b-2 border-solid border-black text-left">
                    <tr>
                        <th>ID</th>
                        <th>Имя</th>
                        <th>Дата создания</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                @foreach ($statuses as $status)
                <tr class="border-b border-dashed text-left">
                    <td>{{$status->id}}</td>
                    <td>{{$status->name}}</td>
                    <td>{{$status->getFormattedUpdateTime()}}</td>
                    <td>
                        @can('delete', App\Models\TaskStatus::class)
                        <a
                            data-confirm="Вы уверены?"
                            data-method="delete"
                            class="text-red-600 hover:text-red-900"
                            rel="nofollow"
                            href="{{route('task_statuses.destroy', ['task_status'=>$status->id])}}">
                            Удалить
                        </a>
                        @endcan
                        @can('update', App\Models\TaskStatus::class)
                        <a
                            class="text-blue-600 hover:text-blue-900"
                            href="{{route('task_statuses.edit', ['task_status'=>$status->id])}}">
                            Изменить

                        </a>
                        @endcan

                    </td>
                </tr>
                @endforeach
            </table>

        </div>
    </div>
</section>
@endsection