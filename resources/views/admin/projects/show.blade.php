@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>{{ $project->title }}</h1>
        @if ($project->type)
            <p class="text-primary">{{ $project->type->name }}</p>
        @endif

        <ul>
            {{-- 
SELECT 'techologies'.*, project_technology.project_id as pivot_project_id, project_technology.technology_id as pivot_technology_id
FROM 'technologies'
INNER JOIN 'project_technology'
ON 'technologies'.'id' = 'project_technology'. 'technology_id'
WHERE 'project_technology'.'project_id' = 2
--}}
            @forelse ($project->technologies as $technology)
                <li>
                    {{ $technology->name }}
                </li>
            @empty
                <li> Nessuna tecnologia presente</li>
            @endforelse
        </ul>

        <p>{{ $project->description }}</p>
    </div>
@endsection
