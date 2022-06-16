<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models as Models;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class TodoController extends Controller{

    private $validInputs = [
        'title'=>'required',
        'description'=>'required',
        'commander'=>'required',
        'soldier'=>'required'
    ];
    private $allInputs = [
        'title',
        'description',
        'due',
        'commander',
        'soldier'
    ];

    public function listOne(Todo $todo){
        return view('todo.todo',['todo'=>$todo]);
    }

    public function listAll(Request $request){
        $todos = Todo::all();
        return view('todo.list',compact('todos'));
    }

    public function make(Request $request){
        if($request->filled(array_keys($this->validInputs))){
            $response = $this->makeAPI($request);
            return view('todo.make',$response->original);
        }
        

        return view('todo.make');
    }

    public function makeAPI(Request $request){

        $request->validate($this->validInputs);
        $attributes = $request->only($this->allInputs);

        $todo = new Models\Todo;
        $todo->title = $request->input('title');
        $todo->description = $request->input('description');
        $todo->due = $request->input('due');
        $todo->save();

        $userTodo = new Models\UserTodo;
        $userTodo->todo = $todo->id;

        // with unique_name maybe added in future....
        // $commander = Models\User::where('unique_name',str_replace('@','',$request->input('commander')))->first();
        
        $commander = Models\User::where('email',$request->input('commander'))->first();
        if(!$commander)return response()->json(['success'=>false,'message'=>"The commander not found :/",'attributes'=>$attributes],500);

        $soldier = Models\User::where('email',$request->input('soldier'))->first();
        if(!$soldier)return response()->json(['success'=>false,'message'=>"The soldier not found :/",'attributes'=>$attributes],500);

        $userTodo->commander = $commander->id;
        $userTodo->soldier = $soldier->id;
        $userTodo->save();

        return response()->json(['success'=>true,'message'=>"The todo successfully created ;)",'attributes'=>$attributes]);
    }

    public function delete(Request $request,$id){
        $redirect = $request->input('redirect');
        
        $todo = Models\Todo::find($id);
        if(!$todo)
            return response()->json(['success'=>false,'message'=>'Did not found the todo :/','attributes'=>['id'=>$id]],500);

        $usersTodos = Models\UserTodo::where('todo',$id)->get();
        if(!$usersTodos)
            return response()->json(['success'=>false,'message'=>'Did not found the todo :/','attributes'=>['id'=>$id]],500);
        
        $commanders = [];
        $soldiers = [];
        foreach($usersTodos as $userTodo){
            $userTodo->delete();
            $commander = Models\User::find($userTodo->commander);
            $soldier = Models\User::find($userTodo->soldier);
            
            array_push($commanders,$commander->id);
            array_push($soldiers,$soldier->id);
        }
        $todo->delete();

        if($redirect)
            return redirect($redirect);
        return response()->json(['success'=>true,'message'=>'Deleted successfully ;)'
            ,'attributes'=>array_merge(
                $todo->getAttributes(),
                [
                    'commanders'=>$commanders,
                    'soldiers'=>$soldiers
                ]
            )
        ],500);
        
    }
}