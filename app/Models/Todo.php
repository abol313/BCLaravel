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
}
