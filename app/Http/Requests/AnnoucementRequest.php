<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AnnoucementRequest extends Request
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
        $annoucement = $this->route('annoucement');
        switch($this->method())
        {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
                return [
                    'annoucement_title' => 'required|unique:annoucements',
                    'start_date' => 'required|date|before_equal:end_date',
                    'end_date' => 'required|date',
                    'annoucement_description' => 'required'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'annoucement_title' => 'required|unique:annoucements,annoucement_title,'.$annoucement->id.',id',
                    'start_date' => 'required|date|before_equal:end_date',
                    'end_date' => 'required|date',
                    'annoucement_description' => 'required'
                ];
            }
            default:break;
        }
    }
}
