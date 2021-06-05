@extends('layouts.app')

@section('header')
    Список проблем
@endsection

@section('content')
    <div class="row justify-content-center w-100">
        <div class="col-md-12">
            @foreach($problems as $problem)
                <div class="card w-100 mt-3">
                    <div class="card-body">
                        <ul>
                            <li>Пользователь: <a href="{{route('users.show', $problem->user->id)}}">{{ $problem->user->name }}</a></li>
                            <li>Категория: {{ $problem->subcategory->title }}</li>
                            <li>Местоположение: {{ $problem->place }}</li>
                            <li>Описание: {{ $problem->description }}</li>
                            <li>Статус заявки:
                                @switch($problem->status)
                                    @case(0)
                                    <span class="text-danger">Не в работе</span>
                                    @break
                                    @case(1)
                                    <span class="text-info">В работе</span>
                                    @break
                                    @case(2)
                                    <span class="text-warning">На проверке</span>
                                    @break
                                    @case(3)
                                    <span class="text-success">Выполнено</span>
                                    @break
                                    @case(3)
                                    <span class="">Отклонено</span>
                                    @break
                                @endswitch
                            </li>
                            @if($problem->status && $problem->performer)
                                Исполнитель {{ $problem->performer->name }}
                            @endif
                        </ul>
                    </div>
                    <div class="card-footer">
                        <div class="inline-form">
                            <form action="{{ route('problems.assign_performer', $problem->id) }}" method="POST">
                                @method("PUT")
                                @csrf
                                <input type="hidden" name="problem_id" value="{{$problem->id}}">
                                <select class="form-control d-inline w-25" name="performer_id">
                                    <option disabled selected>Не выбрано</option>
                                    @foreach($performers as $performer)
                                        <option @if($problem->performer_id == $performer->id) selected @endif value="{{$performer->id}}">{{$performer->name}}</option>
                                    @endforeach
                                </select>
                                <select class="form-control d-inline " style="width: 10%" name="priority">
                                    <option @if($problem->priority == 0) selected @endif value="0">Низкий</option>
                                    <option @if($problem->priority == 1) selected @endif value="1">Средний</option>
                                    <option @if($problem->priority == 2) selected @endif value="2">Высокий</option>
                                </select>
                                <button class="btn btn-success text-white">@if($problem->performer_id) Переназначить @else Назначить @endif</button>
                            </form>
                        </div>
                    </div>
                    @if(!$problem->performer_id)
                    <div class="card-footer">
                        <div class="inline-form">
                            <form action="{{ route('problems.close') }}" method="POST">
                                @method("PUT")
                                @csrf
                                <div class="input-group w-50">
                                    <textarea type="text" name="commentary" class="form-control" placeholder="Введите коментарий"></textarea>
                                    <button class="btn btn-danger text-white">Закрыть заявку</button>
                                </div>
                                <input type="hidden" name="problem_id" value="{{$problem->id}}">
                            </form>
                        </div>
                    </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endsection
