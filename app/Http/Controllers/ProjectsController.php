<?php

namespace App\Http\Controllers;

use App\Models\projects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProjectsController extends Controller
{
    public function createProject(Request $request){
        $validator = Validator::make($request->all(), [
            'titre' => 'required|max:50',
            'discription' => 'max:1000',
            'type' => 'max:100',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'seccess' => false,
                'errors' => $validator->errors(),
            ]);
        }
        $user_id = Auth::user()->id;
        $project = projects::create([
            'titre' => $request->titre,
            'discription' => $request->discription,
            'type' => $request->type,
            'user_id'=> $user_id,
        ]);
        return response()->json([
            'seccess' => true,
            'project' => $project,
        ]);
    }
    public function displayAllProjects(){
        $user_id = Auth::user()->id;
        $projects = projects::where('user_id', $user_id)->get();
        return response()->json([
            'seccess' => true,
            'all projects' => $projects,
        ]);
    }
    public function updateProject(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'titre' =>'required|max:50',
            'description' =>'max:1000',
            'type' =>'max:100',
        ]);
        $user_id = Auth::user()->id;
        $project = projects::find($id);
        $project->update([
            'titre' => $request->titre,
            'description' => $request->description,
            'type' => $request->type,
            'uesr_id' => $user_id,
        ]);
        $updatedProject = projects::find($id);
        return response()->json([
            'success' => true,
            'message' => 'project status updated',
            'updated project' => $updatedProject,
        ]);
    }
    public function deleteProject($id){
        $project = projects::find($id);
        $project->delete();
        return response()->json([
           'success' => true,
           'message' => 'project deleted',
        ]);
    }
}
