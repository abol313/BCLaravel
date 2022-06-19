<?php
namespace App\Http\Controllers;

use App\Http\Requests\MakeTodoRequest;
use Illuminate\Http\Request;
use App\Models\Todo;
use App\Models\User;
use App\Models\UserTodo;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller{

    public function listOne(Todo $todo){
        return view('todo.todo',['todo'=>$todo]);
    }

    public function listAll(Request $request){
        $todos = Todo::all();
        return view('todo.list',compact('todos'));
    }

    public function makeView(){
        return view('todo.make');
    }

    public function makeAPI(MakeTodoRequest $request){

        $attributes = $request->validated();
        $todo = new Todo;

        $todo->fillIfPossible($attributes);

        $todo->save();

        $userTodo = new UserTodo;
        $userTodo->todo = $todo->id;

        // with unique_name maybe added in future....
        // $commander = Models\User::where('unique_name',str_replace('@','',$request->input('commander')))->first();
        
        $commander = User::where('email',$attributes['commander'])->first();
        $message = ['success'=>false,'message'=>"The commander not found :/",'attributes'=>$attributes];
        if(!$commander)
            return back()->withErrors([
                    'message'=>'Did not find the commander!',
                    'errors'=>[
                        'commander'=>'Did not find the commander!'
                    ]
            ]);
        
        $soldier = User::where('email',$attributes['soldier'])->first();
        $message = ['success'=>false,'message'=>"The soldier not found :/",'attributes'=>$attributes];
        if(!$soldier)
            return back()->withErrors([
                'message'=>'Did not find the soldier!',
                'errors'=>[
                    'soldier'=>'Did not find the soldier!'
                ]
            ]);

        $userTodo->commander = $commander->id;
        $userTodo->soldier = $soldier->id;
        $userTodo->save();

        $message = ['success'=>true,'message'=>"The todo successfully created ;)",'attributes'=>$attributes];
        
        $request->session()->flash('report',$message);
        return back();
    }

    public function delete(Request $request,Todo $todo){
        
        $usersTodos = UserTodo::where('todo',$todo->id)->get();
        if(!$usersTodos)
            return back()->withErrors("Did not found the todo :/");
        
        $commanders = [];
        $soldiers = [];
        foreach($usersTodos as $userTodo){
            $userTodo->delete();
            $commander = User::find($userTodo->commander);
            $soldier = User::find($userTodo->soldier);
            
            array_push($commanders,$commander->id);
            array_push($soldiers,$soldier->id);
        }
        $todo->delete();

        $request->session()->flash('report',['success'=>true,'message'=>'The todo deleted successfully!']);
        return back();
    }

    public function editView(Todo $todo){
        $userTodo = UserTodo::where('todo',$todo->id)->first();
        $commander = User::find($userTodo->commander)->email;
        $soldier = User::find($userTodo->soldier)->email;
        return view('todo.edit',['todo'=>$todo,'commander'=>$commander,'soldier'=>$soldier]);
    }

    public function editAPI(MakeTodoRequest $request,Todo $todo){
        //title, description, due, commander, soldier
        
    }
}