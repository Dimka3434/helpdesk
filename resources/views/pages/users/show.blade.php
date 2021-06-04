@extends('layouts.app')

@section('content')
    <div class="card w-100 mt-3">
        <div class="card-header">
            Редактирование пользователя
        </div>
        <div class="card-body">
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method("PUT")
                <label class="mt-2" for="name">Введите имя пользователя</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Имя"
                       value="{{ $user->name }}"/>
                <label class="mt-2" for="email">Введите email-адрес</label>
                <input type="text" id="email" name="email" class="form-control" placeholder="Email"
                       value="{{ $user->email }}"/>
                <label class="mt-2" for="type">Выберите тип пользователя</label>
                <select name="type" id="type" class="form-control">
                    <option value="0" @if($user->type===0) selected @endif>Диспетчер</option>
                    <option value="1" @if($user->type===1) selected @endif>Исполнитель</option>
                    <option value="2" @if($user->type===2) selected @endif>Пользователь</option>
                </select>
                <label class="mt-2" for="password">Введите пароль пользователя</label>
                <input type="text" id="password" name="password" class="form-control" placeholder="Новый пароль"/>
                <button type="submit" class="btn btn-success text-white mt-2">Обновить пользователя</button>
            </form>
            <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                @csrf
                @method("DELETE")
                <button class="btn btn-danger text-white mt-2">Удалить пользователя</button>
            </form>
        </div>
    </div>
@endsection
