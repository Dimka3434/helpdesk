@extends('layouts.app')

@section('header')
    Список проблем
@endsection

@section('content')
    <div class="row justify-content-center w-100">
        <div class="col-md-12">
            @if (!$problems->count())
                <div class="card w-100 mt-3">
                    <div class="card-body">
                        Заявок пока не поступало
                    </div>
                </div>
            @endif
            @foreach($problems as $problem)
                <div class="card w-100 mt-3">
                    <div class="card-body">
                        <ul>
                            <li><strong>Пользователь: </strong> {{ $problem->user->name }}</li>
                            <li><strong>Категория: </strong> {{ $problem->subcategory->title }}</li>
                            <li><strong>Местоположение: </strong> {{ $problem->place }}</li>
                            <li><strong>Описание: </strong> {{ $problem->description }}</li>
                            <li><strong>Статус заявки: </strong>
                                @switch($problem->status)
                                    @case(0)
                                    <span class="text-danger">Открыто</span>
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
                            @if($problem->status && $problem->performer)
                                <li><strong>Исполнитель: </strong> {{ $problem->performer->name }}</li>
                            @endif
                        </ul>
                    </div>
                    @if ($problem->status === 1)
                        <div class="card-footer">
                            <div class="inline-form">
                                <form action="{{ route('problems.underway', $problem->id) }}" method="POST">
                                    @csrf
                                    <div class="input-group w-50">
                                        <button class="btn btn-secondary text-white">Взять в работу</button>
                                    </div>
                                    <input type="hidden" name="problem_id" value="{{$problem->id}}">
                                </form>
                            </div>
                        </div>
                    @endif
                    @if ($problem->status === 4)
                    <div class="card-footer">
                        <div class="inline-form">
                            <form action="{{ route('problems.done', $problem->id) }}" method="POST">
                                @csrf
                                <div class="input-group w-50">
                                    <textarea type="text" name="commentary" class="form-control" placeholder="Введите коментарий"></textarea>
                                    <button class="btn btn-success text-white">Работа выполнена</button>
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
