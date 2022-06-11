<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models as Models;
use Illuminate\Database\Eloquent\Model;

class Todo extends Controller{

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

    public function listAll(Request $request){
        $hostName = $request->getHttpHost();
        return view('todo.list',['host'=>$hostName]);
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

        $commander = Models\User::where('unique_name',str_replace('@','',$request->input('commander')))->first();
        if(!$commander)return response()->json(['success'=>false,'message'=>"The commander not found :/",'attributes'=>$attributes],500);

        $soldier = Models\User::where('unique_name',str_replace('@','',$request->input('soldier')))->first();
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

        $usersTodoes = Models\UserTodo::where('todo',$id)->get();
        if(!$usersTodoes)
            return response()->json(['success'=>false,'message'=>'Did not found the todo :/','attributes'=>['id'=>$id]],500);
        
        $commanders = [];
        $soldiers = [];
        foreach($usersTodoes as $userTodo){
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