@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <h3>Заявка №{{ $problem->id }}</h3>

                <label for="initiator_full_name">ФИО инициатора</label>
                <input disabled id="initiator_full_name" type="text" class="form-control" name="initiator_full_name"  value="{{ $problem->initiator_full_name }}"/>

                <label class="mt-2" for="subcategory_id">Категорияю проблемы</label>
                <select disabled id="subcategory_id" name="subcategory_id" class="form-control">
                    @foreach($categories as $category)
                        <optgroup label="{{ $category->title  }}">
                            @foreach($category->subcategories as $subcategory)
                                <option
                                    {{ old('subcategory_id') == $subcategory->id ? "selected" : "" }}  value="{{ $subcategory->id }}">{{ $subcategory->title }}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>

                <label class="mt-2" for="place">Месторасположение проблемы</label>
                <input disabled id="place" type="text" class="form-control" value="{{ $problem->place }}" name="place" placeholder="Месторасположение проблемы"/>

                <label class="mt-2" for="description">Описание проблемы</label>
                <textarea disabled id="description" class="form-control" name="description" cols="30" rows="10" >{{ $problem->description }}</textarea>

                <label class="mt-2" for="commentary">Дополнительный комментарий</label>
                <input disabled id="commentary" type="text" class="form-control" value="{{ $problem->commentary }}" name="commentary"/>

                <p>Статус:
                @if($problem->status)
                    <span class="text-danger">Еще не обработана</span>
{{--                    @elseif--}}
                    @else
                        <span class="text-danger">Еще не обработана</span>
                    @endif
                </p>

                @if($problem->performer)
                <p>Исполнитель: {{ $problem->performer->full_name }}</p>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <a href="{{ route('complains.create') }}" class="btn btn-secondary text-white">Назад</a>
@endsection
