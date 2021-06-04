@extends('layouts.app')

@section('header')
    Список проблем
@endsection

@section('content')
    <div class="row justify-content-center w-100">
        <div class="col-md-12">
            @foreach($categories as $category)
            <div class="card w-100 mt-3">
                <div class="card-body">
                    {{ $category->title }}
                    <form class="d-inline" action="{{ route('categories.destroy', $category->id) }}" method="POST">
                        @csrf
                        @method("DELETE")
                        <button class="btn-close text-danger"></button>
                    </form>
                    <ul>
                        @foreach($category->subcategories as $subcategory)
                        <li>
                            {{ $subcategory->title }}
                            <form class="d-inline" action="{{ route('subcategories.destroy', [$category->id, $subcategory->id]) }}" method="POST">
                                @csrf
                                @method("DELETE")
                                <button class="btn-close text-danger"></button>
                            </form>
                        </li>
                        @endforeach
                    </ul>
                    <form action="{{ route('subcategories.store', $category->id) }}" method="POST">
                        @csrf
                        <div class="input-group w-25">
                            <input type="title" name="title" class="form-control" placeholder="Добавить подкатегорию" />
                            <button class="btn btn-success text-white">Добавить</button>
                        </div>
                    </form>
                </div>
            </div>
            @endforeach
            <div class="card w-100 mt-3">
                <div class="card-body">
                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf
                        <div class="input-group w-25">
                            <input type="text" name="title" class="form-control" placeholder="Добавить категорию" />
                            <button class="btn btn-success text-white">Добавить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
