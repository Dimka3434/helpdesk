@extends('layouts.app')

@section('header')
    Список проблем
@endsection

@section('content')
    <div class="row justify-content-center w-100">
        <div class="col-md-12">
            <form action="{{ route('problems.index') }}" method="GET">
                <select class="form-control d-inline w-25" name="type">
                    <option value="checking">Ожидающие принятие</option>
                    <option value="done">Выполненные</option>
                    <option type="all">Все</option>
                </select>
                <button class="btn btn-success text-white">Выбрать</button>
            </form>
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
                                    <span class="text-info">Ждет подтверждения</span>
                                    @break
                                    @case(2)
                                    <span class="text-warning">На проверке</span>
                                    @break
                                    @case(3)
                                    <span class="text-success">Выполнено</span>
                                    @break
                                    @case(4)
                                    <span class="">В работе</span>
                                    @break
                                @endswitch
                            </li>
                            @if($problem->commentary)
                                <li>Коментарий: {{ $problem->commentary }}</li>
                            @endif
                            @if($problem->status && $problem->performer)
                                <li>Исполнитель: <a href="{{route('users.show', $problem->performer->id)}}">{{ $problem->performer->name }}</a></li>
                            @endif
                            @if(isset($problem->time_spent))
                                <li>Затрачено времени: {{$problem->time_spent}} часов</li>
                            @endif
                            @if(isset($problem->priority))
                                <li>
                                    Приоритет:
                                    @if($problem->priority == 0)Низкий@endif
                                    @if($problem->priority == 1)Средний@endif
                                    @if($problem->priority == 2)Высокий@endif
                                </li>
                            @endif
                        </ul>
                    </div>
                    @if ($problem->status === 0 || $problem->status === 1)
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
                                <button class="btn btn-success text-white">@if($problem->status === 1) Переназначить @else Назначить @endif</button>
                            </form>
                        </div>
                    </div>
                    @endif
                    @if ($problem->status === 2)
                    <div class="card-footer">
                        <div class="inline-form">
                            <form action="{{ route('problems.close', $problem->id) }}" method="POST">
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
