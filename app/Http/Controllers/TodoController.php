<?php
namespace App\Http\Controllers;

use App\Http\Requests\MakeTodoRequest;
use Illuminate\Http\Request;
use App\Models\Todo;
use App\Models\User;
use App\Models\UserTodo;

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

        $redirectComeBack = $request->input('redirectComeBack',false);
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
        if(!$commander){
            if($redirectComeBack)
                return back()->withErrors([
                    'message'=>'Did not find the commander!',
                    'errors'=>[
                        'commander'=>'Did not find the commander!'
                    ]
                ]);
            else
                return response()->json($message,500);

        }
        $soldier = User::where('email',$attributes['soldier'])->first();
        $message = ['success'=>false,'message'=>"The soldier not found :/",'attributes'=>$attributes];
        if(!$soldier){
            if($redirectComeBack)
                return back()->withErrors([
                    'message'=>'Did not find the soldier!',
                    'errors'=>[
                        'soldier'=>'Did not find the soldier!'
                    ]
                ]);
            else
                return response()->json($message,500);
        }
        $userTodo->commander = $commander->id;
        $userTodo->soldier = $soldier->id;
        $userTodo->save();

        $message = ['success'=>true,'message'=>"The todo successfully created ;)",'attributes'=>$attributes];
        if($redirectComeBack){
            $request->session()->flash('report',$message);
            return back();
        }
        return response()->json($message);
    }

    public function delete(Request $request,Todo $todo){
        $redirectComeBack = $request->input('redirectComeBack');
        
        if(!$todo)
            return response()->json(['success'=>false,'message'=>'Did not found the todo :/','attributes'=>['id'=>$id]],500);

        $usersTodos = UserTodo::where('todo',$id)->get();
        if(!$usersTodos)
            return response()->json(['success'=>false,'message'=>'Did not found the todo :/','attributes'=>['id'=>$id]],500);
        
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

        if($redirectComeBack)
            return back();
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