<?php
namespace App\Http\Controllers;

use App\Http\Requests\EditTodoRequest;
use App\Http\Requests\MakeTodoRequest;
use Illuminate\Http\Request;
use App\Models\Todo;
use App\Models\User;
use App\Models\UserTodo;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller{

    public function listOne(Todo $todo){
        Log::info("View todo{{$todo->id}}");
        return view('todo.todo',['todo'=>$todo]);
    }

    public function listAll(Request $request){
        Log::info("View todos");
        $todos = Todo::all();
        return view('todo.list',compact('todos'));
    }

    public function create(){
        Log::info("View todo create");
        return view('todo.make');
    }

    public function store(MakeTodoRequest $request){
        Log::notice("Try create todo...");

        $attributes = $request->validated();

        $todo = Todo::makeTodo($attributes);

        Log::notice("Create todo{{$todo->id}}!",$todo->getAttributes());

        $message = ['success'=>true,'message'=>__("todo.controller.todo.create"),'attributes'=>$attributes];

        $request->session()->flash('report',$message);
        return back();
    }

    public function delete(Request $request,Todo $todo){
        Log::alert("Try delete todo{{$todo->id}}...");
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
        Log::alert("Delete todo{{$todo->id}}!",$todo->getAttributes());

        $request->session()->flash('report',['success'=>true,'message'=>__("todo.controller.todo.delete")]);
        return back();
    }

    public function edit(Todo $todo){
        Log::info("View todo edit{{$todo->id}}");
        return view('todo.edit',['todo'=>$todo,'commander'=>($todo->getCommander()?->email),'soldier'=>($todo->getSoldier()?->email)]);
    }

    public function update(EditTodoRequest $request,Todo $todo){
        Log::warning("Try update todo{{$todo->id}}...");
        if(!$todo->hasRelationToUsers())
            return back()->withErrors(__("todo.no_user_todo"));

        $pastAttributes = $todo->getAttributes();
        Todo::editTodo($todo,$request->validated());
        $nowAttributes = $todo->getAttributes();
        
        Log::warning("Update todo{id:$todo->id}!",['past'=>$pastAttributes,'now'=>$nowAttributes]);
        $request->session()->flash('report',['success'=>true,'message'=>__("todo.controller.todo.edit")]);
        return back();

    }
}