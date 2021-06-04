@extends('layouts.app')

@section('header')
    Список проблем
@endsection

@section('content')
    <div class="row justify-content-center w-100">
        <div class="col-md-12">
            @foreach($users as $user)
            <div class="card w-100 mt-3">
                <div class="card-body">
                    <ul>
                        <li>Email: {{ $user->email }}</li>
                        <li>Имя: {{ $user->name }}</li>
                        <li>Тип пользователя:
                        @switch($user->type)
                            @case(0)
                            Диспетчер
                            @break
                            @case(1)
                            Исполнитель
                            @break
                            @case(2)
                            Пользователь
                            @break
                        @endswitch
                        </li>
                    </ul>
                    <a href="{{ route('users.show', $user->id) }}">Редактировать пользователя</a>
                </div>
            </div>
            @endforeach
            <div class="card w-100 mt-3">
                <div class="card-body">
                    <a class="btn btn-success text-white" href="{{ route('users.create') }}">Создать пользователя</a>
                </div>
            </div>
        </div>
    </div>
@endsection
