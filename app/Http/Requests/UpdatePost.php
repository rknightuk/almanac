<?php

namespace Almanac\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
	    return [
	    	'id' => 'required|numeric',
		    'title' => 'required|min:1',
		    'path' => 'required|min:1',
	    ];
    }
}
