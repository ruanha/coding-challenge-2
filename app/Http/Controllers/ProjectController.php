<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct()
    {

    }

    public function show(int $projectID)
    {
        $project = Project::with('entries')->find($projectID);
        return view('projects.show', ['project' => $project]);
    }

    public function add(Request $request)
    {
        if ($this->nameExists($request->get('name'))) {
            return response()->json(['status' => 'success']);
        }
        Project::create([
            'name' => $request->get('name')
        ]);
        return response()->json(['status' => 'success']);
    }

    public function update(Request $request)
    {
        if ($this->nameExists($request->get('name'))) {
            return response()->json(['status' => 'success']);
        }
        $project = Project::find($request->get('id'));
        $project->name = $request->get('name');
        $project->save();
        return response()->json(['status' => 'success']);
    }

    protected function nameExists(string $name){
        return null !== Project::where('name', $name)->first();
    }

    public function delete(Request $request)
    {
        $project = Project::with('entries')->find($request->get('id'));
        $project->entries()->delete();
        $project->delete();
        return response()->json([
            'status' => 'success',
        ]);
    }
}
