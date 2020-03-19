<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*
        $tasks = Task::all();

        return view('tasks.index', [
            'tasks' => $tasks,
        ]);
        */
        
        $data = [];
        if (\Auth::check()) {
            $user = \Auth::user();
            $tasklists = $user->tasklists()->orderBy('created_at', 'desc')->paginate(10);
            
            $data = [
                'user' => $user,
                'tasks' => $tasklists,
            ];
            
            //dd($data);
            
            //return view('welcome', $data);
            //return view('tasks.index', $data);
            
/*        } else {
            $data = [];
            
            return view('welcome', $data);
*/
        }
        
        //dd($data);
        
        return view('welcome', $data);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $task = new Task;

        return view('tasks.create', [
            'tasks' => $task,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'status' => 'required|max:10',
            'content' => 'required|max:191',
        ]);
        
        $request->user()->tasklists()->create([
            'status'  => $request->status,
            'content' => $request->content,
        ]);

        return redirect('/');
        
        /*
        $user = \Auth::user();
        $tasklists = $user->tasklists()->orderBy('created_at', 'desc')->paginate(10);
            
        $data = [
            'user' => $user,
            'tasks' => $tasklists,
        ];

        //dd($data);

        return view('welcome',$data);
        */
        
        /*
        $task = new Task;
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();

        return redirect('/');
        */
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::find($id);
        
        //dd($task);

        if (\Auth::id() === $task->user_id) {
            return view('tasks.show', [
                'task' => $task,
            ]);
        }
        
        return redirect('/');
        
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::find($id);
        
        return view('tasks.edit', [
            'task' => $task,
        ]);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|max:10',
            'content' => 'required|max:191',
        ]);
        
        $task = Task::find($id);
        
        if (\Auth::id() === $task->user_id) {
            $task->status = $request->status;
            $task->content = $request->content;
            $task->save();
        }
        
        return redirect('/');
        
        /*
        $request->user()->tasklists()->save([
            'status'  => $request->status,
            'content' => $request->content,
        ]);
        
        $user = \Auth::user();
        $tasklists = $user->tasklists()->orderBy('created_at', 'desc')->paginate(10);
        
        $data = [
            'user' => $user,
            'tasks' => $tasklists,
        ];
        
        //dd($data);
        
        return view('welcome',$data);
        */
        
        /*
        $task = Task::find($id);
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();
        
        return redirect('/');
        */
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        
        if (\Auth::id() === $task->user_id) {
            $task->delete();
        }
        
        return redirect('/');
        
        /*
        $user = \Auth::user();
        $tasklists = $user->tasklists()->orderBy('created_at', 'desc')->paginate(10);
        
        $data = [
            'user' => $user,
            'tasks' => $tasklists,
        ];
        
        //dd($data);
        
        return view('welcome',$data);
        */
        
        //$task->delete();
        
        //return redirect('/');
    }
}
