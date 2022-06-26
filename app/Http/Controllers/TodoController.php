<?php
namespace App\Http\Controllers;

use App\Http\Requests\EditTodoRequest;
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

    public function create(){
        return view('todo.make');
    }

    public function store(MakeTodoRequest $request){

        $attributes = $request->validated();

        Todo::makeTodo($attributes);

        $message = ['success'=>true,'message'=>__("todo.controller.todo.create"),'attributes'=>$attributes];

        $request->session()->flash('report',$message);
        return back();
    }

    public function delete(Request $request,Todo $todo){
        
        $usersTodos = UserTodo::where('todo',$todo->id)->get();
        if(!$usersTodos)
            return back()->withErrors(__("todo.no_user_todo"));
        
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

        $request->session()->flash('report',['success'=>true,'message'=>__("todo.controller.todo.delete")]);
        return back();
    }

    public function edit(Todo $todo){
        return view('todo.edit',['todo'=>$todo,'commander'=>($todo->getCommander()?->email),'soldier'=>($todo->getSoldier()?->email)]);
    }

    public function update(EditTodoRequest $request,Todo $todo){
        
        if(!$todo->hasRelationToUsers())
            return back()->withErrors(__("todo.no_user_todo"));

        Todo::editTodo($todo,$request->validated());
        
        $request->session()->flash('report',['success'=>true,'message'=>__("todo.controller.todo.edit")]);
        return back();

    }
}