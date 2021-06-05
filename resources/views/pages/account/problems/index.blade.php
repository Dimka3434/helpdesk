@extends('layouts.app')

@section('header')
    Список проблем
@endsection

@section('content')
    <div class="row justify-content-center w-100">
        <div class="col-md-12">
            <div class="card w-100 mt-3">
                <div class="card-body">
                    <a href="{{route('account.problems.create')}}" class="btn btn-success text-white">Создать новую проблему</a>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            @foreach($problems as $problem)
                <div class="card w-100 mt-3">
                    <div class="card-body">
                        <ul>
                            <li><strong>Категория: </strong>{{ $problem->subcategory->title }}</li>
                            <li><strong>Местоположение: </strong>{{ $problem->place }}</li>
                            <li><strong>Описание: </strong>{{ $problem->description }}</li>
                            <li><strong>Статус заявки: </strong>
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
                                @endswitch
                            </li>
                            @if($problem->status && $problem->performer)
                                <li><strong>Исполнитель: </strong> {{ $problem->performer->name }}</li>
                            @endif
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
