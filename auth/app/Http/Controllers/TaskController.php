<?php

namespace App\Http\Controllers;

use App\Http\Requests\Book\AddBookRequest;
use App\Models\Task;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware(['jwt', 'refresh', 'role:user']);
    }

    public function add(AddBookRequest $request)
    {
        try {
            $body = $request->only('content');
            $task = new Task($body);
            $task->user = auth()->user()->id;
            $task->save();

            return response()->json(["msg" => "Create successfully", "success" => true, "data" => $task]);
        } catch (\Throwable $th) {
            return response()->json(["msg" => "Error to create", "success" => false, "data" => $th->getMessage()], 500);
        }
    }

    public function findAll(Request $request)
    {
        try {
            //code...
            $tasks = Task::where('user', auth()->id())->get();

            return response()->json(["msg" => "successfully", "data" => $tasks]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(["msg" => "error", "data" => $th->getMessage()]);
        }
    }

    public function findBy(string $UUID)
    {
        try {
            $task = Task::findOrFail($UUID);
            return response()->json(["msg" => $task]);
        } catch (\Throwable $th) {
            if ($th instanceof ModelNotFoundException) {
                return response()->json(["msg" => 'No existe este elemento']);
            }
        }
    }
    public function delBy(string $UUID)
    {
        try {
            $task = Task::findOrFail($UUID)->delete();
            return response()->json(["msg" => 'Remove successfully', "data" => []]);
        } catch (\Throwable $th) {
            if ($th instanceof ModelNotFoundException) {
                return response()->json(["msg" => 'No existe este elemento']);
            }
        }
    }


    public function updateBy(Request $request, $UUID)
    {
        $data = $request->all();
        $task = Task::where('id', $UUID)->update($data);
        return response()->json(["msg" => "Update successfully", "data" => $task]);
    }
}
