<?php

namespace App\Http\Controllers;

use App\Models\projects;
use App\Models\tasks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TasksController extends Controller
{
    public function taskCreate(Request $request){
        $validator = Validator::make($request->all(), [
            'content' => 'min:5|max:100|required',
            'date_limite' => 'required',
            'project_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ]);
        }
        $user_id = Auth::user()->id;
        $task = tasks::create([
            'content' => $request->content,
            'user_id' => $user_id,
            'date_limite' => $request->date_limite,
            'project_id' => $request->project_id,
        ]); 
        return response()->json([
            'success' => true,
            'task' => $task,
        ]);
    }

    public function displayTasks($id){
        $user_id = Auth::user()->id;
        $tasks = tasks::where('user_id', $user_id)->where('project_id', $id)->get();
        return response()->json([
            'success' => true,
            'tasks' => $tasks,
        ]);
    }
    public function tasksByType($id, $type){
        $user_id = Auth::user()->id;
        $tasks = tasks::where('user_id', $user_id)->where('project_id', $id)->where('status', $type)->get();
        return response()->json([
            'success' => true,
            $type . 'tasks' => $tasks,
        ]);
    }
    public function updateTask(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'content' => 'min:5|max:100|required',
            'date_limite' => 'required',
            'project_id' => 'required',
            'status' => 'min:1',
        ]);
        if ($validator->fails()) {
            return response()->json([
               'success' => false,
                'errors' => $validator->errors(),
            ]);
        }
        $user_id = Auth::user()->id;
        $task = tasks::find($id);
        $task->update([
            'content' => $request->content,
            'user_id' => $user_id,
            'date_limite' => $request->date_limite,
            'project_id' => $request->project_id,
            'status' => $request->status,
        ]);
        $NewTask = tasks::find($id);

        return response()->json([
            'success' => true,
            'New task' => $NewTask,
        ]);
    }
    public function upadateTaskStatus(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'status' => 'min:1',
        ]);
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'error' => $validator->errors(),
            ]);
        }
        $task = tasks::find($id);
        $task->update(['status' => $request->status]);
        $updatedStatus = tasks::find($id);
        return response()->json([
            'success' => true,
            'message' => 'task status updated',
            'task' => $updatedStatus,
        ]);
    }
    public function deleteTasks($id){
        $task = tasks::find($id);
        $task->delete();
        return response()->json([
            'success' => true,
            'message' => 'project deleted successfully',
        ]);
    }
}
