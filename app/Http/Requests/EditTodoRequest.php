<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditTodoRequest extends FormRequest
{

    private $editValidationRules = [
        'title'=>'required|string|between:5,100',
        'description'=>'nullable|string|max:65535',
        // 'status'=>'nullable',
        'due'=>'nullable|date|after:now',
        'commander'=>'required|email|exists:users,email',
        'soldier'=>'required|email|exists:users,email',
        'todo'=>'required|exists:users_todos,todo'
    ];


    protected $stopOnFirstFailure = false;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }


    public function prepareForValidation(){
        $this->merge(['todo'=>$this->route('todo')->id]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return $this->editValidationRules;
    }
}
