<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;

class Todo extends Model {
    use HasFactory;
    protected $table = "todos";
    protected $fillable = ['title','description','due','status'];

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

        $todo = new Todo;
        foreach(Arr::except($data,['commander','soldier']) as $name => $value)
            $todo->setAttribute($name,$value);

        $todo->save();

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
            $todo = Todo::find($todo);

        foreach(Arr::except($data,['commander','soldier']) as $name => $value)
            $todo->setAttribute($name,$value);

        $todo->save();

        $todo->makeRelationToUsers($commander,$soldier);

        return $todo;
    }

}

