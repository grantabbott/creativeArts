<?php

namespace App\Http\Requests;
use App\Http\Requests\Request;

class ServiceTimeRequest extends Request
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
        $service_time = $this->route('service_time');
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
                    'response_time' => 'required|numeric',
                    'response_unit' => 'required',
                    'resolution_time' => 'required|numeric',
                    'resolution_unit' => 'required',
                    'priority' => 'required|unique:service_times,priority'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'response_time' => 'required|numeric',
                    'response_unit' => 'required',
                    'resolution_time' => 'required|numeric',
                    'resolution_unit' => 'required',
                    'priority' => 'required|unique:service_times,priority,'.$service_time->id
                ];
            }
            default:break;
        }
    }
}
