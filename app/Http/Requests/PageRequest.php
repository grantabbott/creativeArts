<?php

namespace App\Http\Requests;
use App\Http\Requests\Request;

class PageRequest extends Request
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
        $page = $this->route('page');
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
                    'page_title' => 'required|unique:pages'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'page_title' => 'required|unique:pages,page_title,'.$page->id.',id'
                ];
            }
            default:break;
        }
    }
}
