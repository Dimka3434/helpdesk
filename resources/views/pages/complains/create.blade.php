@extends('layouts.app')

@section('header')
Создание заявки
@endsection
@section('content')
    @if(session()->get('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif
    @if(session()->get('error'))
        <div class="alert alert-danger">
            {{ session()->get('error') }}
        </div>
    @endif
    <form action="{{ route('complains.store') }}" method="POST">
        @csrf
        <label class="mt-2" for="subcategory_id">Выберите категорияю проблемы</label>
        <select id="subcategory_id" name="subcategory_id" class="form-control">
            @foreach($categories as $category)
                <optgroup label="{{ $category->title  }}">
                    @foreach($category->subcategories as $subcategory)
                        <option {{ old('subcategory_id') == $subcategory->id ? "selected" : "" }}  value="{{ $subcategory->id }}">{{ $subcategory->title }}</option>
                    @endforeach
                </optgroup>
            @endforeach
        </select>
        @error('subcategory_id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror

        <label class="mt-2" for="place">Введите месторасположение проблемы</label>
        <input id="place" type="text" class="form-control @error('place') is-invalid @enderror" value="{{ old('place') }}" name="place" placeholder="Месторасположение проблемы" />
        @error('place')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror

        <label class="mt-2" for="description">Опишите подробнее Вашу проблемы</label>
        <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" cols="30" rows="10" placeholder="Описание проблемы">{{ old('description') }}</textarea>
        @error('description')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror

        <button type="submit" class="btn btn-success text-white mt-2">Создать проблему</button>
    </form>
@endsection
