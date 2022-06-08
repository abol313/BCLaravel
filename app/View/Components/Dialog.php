<?php
namespace App\View\Components;
use Illuminate\View\Component;

class Dialog extends Component {
    public $title;
    function __construct($title){
        $this->title=$title;
    }

    function render(){
        return view('components.dialog');
    }
}