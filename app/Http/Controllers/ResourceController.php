<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resource; // On utilise uniquement le Model pour plus de cohérence

class ResourceController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $resources = Resource::query()
            ->when($search, function ($query, $search) {
                return $query->where(function($q) use ($search) {
                     $q->where('name', 'like', "%{$search}%")
                       ->orWhere('type', 'like', "%{$search}%")
                       ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->get();

        return view('ressources.catalogue', compact('resources'));
    }

    // --- CORRIGÉ : On utilise findOrFail pour que le JSON soit décodé automatiquement ---
    public function show($id) {
        $resource = Resource::findOrFail($id); 
        return view('show', compact('resource'));
    }

    public function store(Request $request)
    {
        // Eloquent gère le json_encode automatiquement grâce au $casts dans le Model
        Resource::create([
            'name'           => $request->name,
            'type'           => $request->type,
            'status'         => $request->status,
            'specifications' => [
                'cpu' => $request->cpu,
                'ram' => $request->ram,
                'os'  => $request->os ?? 'Linux Ubuntu 22.04'
            ],
            'location'       => $request->location,
            'description'    => $request->description,
        ]);

        return redirect()->route('resources.index')->with('success', 'Ressource ajoutée !');
    }

    public function edit($id) {
        $resource = Resource::findOrFail($id);
        return view('edit', compact('resource'));
    }

    public function update(Request $request, $id) {
        $resource = Resource::findOrFail($id);
        
        $resource->update([
            'name'     => $request->name, 
            'type'     => $request->type,
            'status'   => $request->status, 
            'location' => $request->location,
            'description' => $request->description,
        ]);

        return redirect()->route('resources.index')->with('success', 'Mise à jour réussie !');
    }

    public function destroy($id) {
        Resource::destroy($id);
        return redirect()->route('resources.index')->with('success', 'Ressource supprimée !');
    }
}