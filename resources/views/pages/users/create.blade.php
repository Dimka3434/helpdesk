@extends('layouts.app')

@section('content')
    <div class="card w-100 mt-3">
        <div class="card-header">
            Создание пользователя
        </div>
        <div class="card-body">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <label class="mt-2" for="name">Введите имя пользователя</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Имя"/>
                <label class="mt-2" for="email">Введите email-адрес</label>
                <input type="text" id="email" name="email" class="form-control" placeholder="Email"/>
                <label class="mt-2" for="type">Выберите тип пользователя</label>
                <select name="type" id="type" class="form-control">
                    <option value="0">Диспетчер</option>
                    <option value="1">Исполнитель</option>
                    <option value="2">Пользователь</option>
                </select>
                <label class="mt-2" for="password">Введите пароль пользователя</label>
                <input type="text" id="password" name="password" class="form-control" placeholder="Пароль"/>
                <button type="submit" class="btn btn-success text-white mt-2">Создать пользователя</button>
            </form>
        </div>
    </div>
@endsection
