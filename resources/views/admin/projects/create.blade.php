@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Crea un nuovo Progetto</h1>
        <form action="{{ route('admin.projects.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Titolo</label>
                <input type="text" name="title" class="form-control" id="title" required>
            </div>
            {{-- TYPE --}}
            <div class="form-group mb-3">
                <label for="type_id">Type</label>
                <select id="type_id" name="type_id" class="form-control" required>
                    <option value="">Select a type</option>
                    @foreach ($types as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- TECHNOLOGIES --}}
            <div class="form-group mb-3">
                <span>Tecnologie</span>
                <ul class="list-group">
                    @foreach ($technologies as $technology)
                        <li class="list-group-item">
                            {{-- APPLICO L'ARRAY VUOTO COME SECONDO PARAMETRO --}}
                            <input @checked(in_array($technology->id, old('technologies', []))) name="technologies[]" class="form-check-input me-1"
                                type="checkbox" value="{{ $technology->id }}" id="technology-{{ $technology->id }}" autocomplete="off">
                            <label class="form-check-label"
                                for="technology-{{ $technology->id }}">{{ $technology->name }}</label>
                        </li>
                    @endforeach
                </ul>
            </div>
            {{-- __________________________- --}}

            <div class="form-group">
                <label for="description">Descrizione</label>
                <textarea name="description" class="form-control" id="description" required></textarea>
            </div>
            <div class="my-3">
                <button type="submit" class="btn btn-success">Crea</button>
            </div>
        </form>
    </div>
@endsection
