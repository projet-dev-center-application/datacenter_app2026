<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResourceController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $resources = DB::table('resources')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhere('type', 'like', "%{$search}%");
            })
            ->get();

        return view('catalogue', compact('resources'));
    }

    // --- زدت هاد الـ Function باش يخدم زر Voir ---
    public function show($id) {
        $resource = DB::table('resources')->where('id', $id)->first();
        return view('show', compact('resource'));
    }

    public function store(Request $request)
    {
        $specifications = json_encode([
            'cpu' => $request->cpu,
            'ram' => $request->ram
        ]);

        DB::table('resources')->insert([
            'name'           => $request->name,
            'type'           => $request->type,
            'status'         => $request->status,
            'specifications' => $specifications,
            'location'       => $request->location,
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        return redirect('/catalogue')->with('success', 'Ressource ajoutée !');
    }

    public function edit($id) {
        $resource = DB::table('resources')->where('id', $id)->first();
        return view('edit', compact('resource'));
    }

    public function update(Request $request, $id) {
        DB::table('resources')->where('id', $id)->update([
            'name'     => $request->name, 
            'type'     => $request->type,
            'status'   => $request->status, 
            'location' => $request->location, 
            'updated_at' => now(),
        ]);
        return redirect('/catalogue')->with('success', 'Mise à jour réussie !');
    }

    public function destroy($id) {
        DB::table('resources')->where('id', $id)->delete();
        return redirect('/catalogue')->with('success', 'Ressource supprimée !');
    }
}
