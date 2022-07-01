<?php
namespace App\Models;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\BroadcastsEvents;

class Todo extends Model {
    use BroadcastsEvents, HasFactory;
    protected $table = "todos";
    protected $fillable = [
        'title',
        'description',
        'due',
        'status'
    ];

    public function fillIfPossible(array $attributes){
        $columnNames = Schema::getColumnListing($this->table);
        $modelAttributes = Arr::only($attributes,$columnNames);
        if(empty($modelAttributes))return $this;
        $this->fill($modelAttributes);
        return $this;
    }

    /*
    title => string
    description => string
    due => integer (timestamp)
    status => string 
    commander => integer(id) | string(email)
    soldier => integer(id) | string(email)
    */
    public static function makeTodo($data){
        $data  = Arr::only($data,[
            'title',
            'description',
            'due',
            'status',
            'commander',
            'soldier'
        ]);


        $commander = $data['commander'];
        if(is_string($commander))
            $commander = User::where('email',$commander)->first()->id;

        $soldier = $data['soldier'];
        if(is_string($soldier))
            $soldier = User::where('email',$soldier)->first()->id;

        $todo = self::create(Arr::except($data,['commander','soldier']));

        $todo->makeRelationToUsers($commander,$soldier);

        return $todo;
    }
    public function hasRelationToUsers(){
        return UserTodo::where('todo',$this->id)->first()?:false;
    }
    public function getCommander(){
        $userTodo =  $this->hasRelationToUsers();
        return $userTodo ? User::where('id',$userTodo->commander)->first() : null; 
    }
    public function getSoldier(){
        $userTodo =  $this->hasRelationToUsers();
        return $userTodo ? User::where('id',$userTodo->soldier)->first() : null; 
    }
    
    public function makeRelationToUsers($commander,$soldier){
        $userTodo = $this->hasRelationToUsers() ?: new UserTodo;
        $userTodo->todo = $this->id;
        $userTodo->commander = $commander;
        $userTodo->soldier = $soldier;
        $userTodo->save();
        return $this;
    }

    /*
    $todo: integer(id)|Todo(model instance)
    $data:
        title => string
        description => string
        due => integer (timestamp)
        status => string 
        commander => integer(id) | string(email)
        soldier => integer(id) | string(email)
    */
    public static function editTodo($todo,$data){
        $data  = Arr::only($data,[
            'title',
            'description',
            'due',
            'status',
            'commander',
            'soldier'
        ]);

        $commander = $data['commander'];
        if(is_string($commander))
            $commander = User::where('email',$commander)->first()->id;

        $soldier = $data['soldier'];
        if(is_string($soldier))
            $soldier = User::where('email',$soldier)->first()->id;

        if(!$todo instanceof Model)
            $todo = Todo::query()->find($todo);

        foreach(Arr::except($data,['commander','soldier']) as $name => $value)
            $todo->setAttribute($name,$value);

        $todo->save();

        $todo->makeRelationToUsers($commander,$soldier);

        return $todo;
    }


    public function broadcastOn($event){

        return match($event){
            'created'=>new PrivateChannel('App.Models.Todo.x'),
            default=>[$this]
        };
    }
}

