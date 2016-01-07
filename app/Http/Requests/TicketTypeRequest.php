<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class TicketTypeRequest extends Request
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
        $ticket = $this->route('ticket');
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
                    'ticket_type_name' => 'required|unique:ticket_types,ticket_type_name'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'ticket_type_name' => 'required|unique:ticket_types,ticket_type_name,'.$ticket->id
                ];
            }
            default:break;
        }
    }
}
