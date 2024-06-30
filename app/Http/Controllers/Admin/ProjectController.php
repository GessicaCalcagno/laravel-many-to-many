<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //prelevo tutti i dati
        // $projects = Project::all();
        //guardo la debugbar
        //invece di fare all() con with( all'interno inserisco quello che ho messo nel model ) e così diminuiscono la quantità di query! ricorda di aggiugere ->get()
        $projects = Project::with('technologies', 'type')->get();
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $technologies = Technology::all();
        $types = Type::all();
        //in create facciamo vedere solo il form 
        //se non metto il compact di types o technologies non le salva!
        return view('admin.projects.create', compact('types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     * passa come parametro lo store-request
     */
    public function store(StoreProjectRequest $request)
    {
        //dd($request->all());
        $data = $request->validated();

        $project = new Project();
        $project->fill($data);
        //Inserisci use perchè non lo fa automaticamente
        $project->slug = Str::slug($request->title);
        $project->save();

        //____________________________________________________
        //dopo la creazione dei progetti dobbiamo controllare se ci sono le tecnologie da collegare
        if ($request->has('technologies')) {
            //salvo le tecnologie collegati nella tabella ponte
            //uso il metodo attach
            $project->technologies()->attach($request->technologies);
        }
        //____________________________
        return redirect()->route('admin.projects.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        //dd($project);
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.projects.edit', compact('project', 'types', 'technologies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        //
        $data = $request->validated();
        // $project->slug = Str::slug($request->title);
        //data è un array associativo ed aggiungiamo lo slug nella parentesi quadra
        //se lo scrivo cosi devo aggiungere slug nel fillable
        $data['slug'] = Str::slug($data['title']);
        $project->update($data);

        //per non usare attach e detach usiamo sync che fa queste 2 cose in automatico
        $project->technologies()->sync($request->technologies);

        return redirect()->route('admin.projects.show', ['project' => $project->slug])->with('message', 'Il progetto ' . $project->title . ' è stato modificato con successo!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        // Cancello tutti i record nella tabella ponte collegate al progetto, lo scrivo per essere più esplicita ma non servirebbe perchè ho usato cascadeOnDelete()
        $project->technologies()->detach();
        $project->delete();
        return redirect()->route('admin.projects.index')->with('message', 'Il progetto ' . $project->title . ' è stato cancellato con successo!');
    }
}
