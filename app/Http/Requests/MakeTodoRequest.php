<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MakeTodoRequest extends FormRequest
{

    private $makeValidationRules = [
        'title'=>'required|between:5,100',
        'description'=>'nullable|max:65535',
        // 'status'=>'nullable',
        'due'=>'nullable|date|after:now',
        'commander'=>'required|email|exists:users,email',
        'soldier'=>'required|email|exists:users,email'
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


    public function withValidator($validator){
        // dump($this->all());
        // $validator->errors()->add('err2','eeerrr :/');

        // $validator->after(function($validator){
        //     $validator->errors()->add('err','eeerrr :/');
        //     $validator->errors()->add('err2','eeerrr :/');
        //     dump("after");
        // });
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return $this->makeValidationRules;
    }
}
