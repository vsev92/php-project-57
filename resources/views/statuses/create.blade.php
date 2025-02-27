@extends('layouts.home')
@section('content')
<div class="grid max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
    <div class="grid col-span-full">
        <h1 class="mb-5">Создать статус</h1>

        <form class="w-50" method="POST" action="{{route('task_statuses.store')}}"><input type="hidden" name="_token" value="0Q9SUha7NixrDGNtzdy0sxm1gsPK5oJYFTsl30he">
            @csrf
            <div class="flex flex-col">
                <div>
                    <label for="name">Имя</label>
                </div>
                <div class="mt-2">
                    <input class="rounded border-gray-300 w-1/3" type="text" name="name" id="name">
                </div>
                <div class="mt-2">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">Создать</button>
                </div>
            </div>
        </form>
    </div>
    @endsection