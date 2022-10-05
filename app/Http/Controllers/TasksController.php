<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Tasks;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TasksController extends Controller
{
    public function index()
    {
        $tasks = Tasks::all()->sortByDesc('completed')->sortBy('priority')->sortByDesc('task_date');
        $clients = Client::query()->where('disabled', '=', 0)->get();


        return view('tasks.index', ['tasks' => $tasks, 'clients' => $clients]);
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $requestDate = DateTime::createFromFormat('d/m/Y', $request->task_date);

        $date = $requestDate->format('Y-m-d');
       // dd($date);
        DB::table('tasks')->insert(
            array(
                'client_id' => $request->taskClient,
                'taskName' => $request->task_title,
                'description' => $request->description,
                'priority' => $request->priority,
                'task_date' => $date,
                'created_at' => now()
            )
        );
        return redirect()->route('dashboard');
    }

    public function setState(Tasks $task, Request $request)
    {
        if(isset($request->taskstatus) && $request->taskstatus == 'on') {
            $task->update(['completed' => 1]);
        } else {
            $task->update(['completed' => 0]);
        }
        return back();
    }

    public function destroy(Tasks $task)
    {
        $task->delete();

        return back();

    }
}
