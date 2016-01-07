<?php

namespace App\Http\Requests;
use App\Http\Requests\Request;

class BusinessHourRequest extends Request
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
        $business_hour = $this->route('business_hour');
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
                    'start' => 'required',
                    'end' => 'required',
                    'day' => 'required|unique:business_hours,day'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'start' => 'required',
                    'end' => 'required',
                    'day' => 'required|unique:business_hours,day,'.$business_hour->id
                ];
            }
            default:break;
        }
    }
}
