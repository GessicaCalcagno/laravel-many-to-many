@extends('layouts.admin')
@section('content')
    <div class="container">
        <h1>Modifica:</h1>
        <h3>{{ $project->title }}</h3>
        <form action="{{ route('admin.projects.update', ['project' => $project->slug]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group mb-3">
                <label for="title">Titolo</label>
                <input type="text" name="title" class="form-control" id="title"
                    value="{{ old('title', $project->title) }}">
            </div>
            {{-- TYPE --}}
            <div class="form-group mb-3">
                <label for="type_id">Type</label>
                <select id="type_id" name="type_id" class="form-control">
                    <option value="">Select a type</option>
                    {{-- Questa è una query --}}
                    @foreach ($types as $type)
                        <option @selected(old('type_id', $project->type?->id === $type->id)) value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- TECHNOLOGIES --}}
            <div class="form-group mb-3">
                <span>Tecnologie</span>
                <ul class="list-group">
                    @foreach ($technologies as $technology)
                        <li class="list-group-item">
                            @if (old('technologies') === null)
                                {{-- USO IL METODO CONTAINS DI LARAVEL - il dato: è una collections --}}
                                <input @checked($project->technologies->contains($technology)) name="technologies[]" class="form-check-input me-1"
                                    type="checkbox" value="{{ $technology->id }}" id="technology-{{ $technology->id }}">
                            @else
                                <input @checked(in_array($technology->id, old('technologies'))) name="technologies[]" class="form-check-input me-1"
                                    type="checkbox" value="{{ $technology->id }}" id="technology-{{ $technology->id }}">
                            @endif
                            <label class="form-check-label" for="technology-{{ $technology->id }}">{{ $technology->name }}
                            </label>
                            {{-- LA LOGICA - MA USIAMO CHECKED CHE LASCIA SELEZIONATO IL CHECKED --}}
                            {{-- <label class="form-check-label" for="technology-{{ $technology->id }}">{{ $technology->name }}
                                <br>
                                {{ $project->technologies->contains($technology) ? 'Selezionato' : 'NON selezionato' }}
                            </label> --}}
                        </li>
                    @endforeach
                </ul>
            </div>
            {{-- __________________________- --}}

            <div class="form-group">
                <label for="description">Descrizione</label>
                <textarea name="description" class="form-control" id="description">{{ old('description', $project->description) }}</textarea>
            </div>
            <div class="my-3">
                <button type="submit" class="btn btn-success">Modifica</button>
            </div>
        </form>
    </div>
@endsection
