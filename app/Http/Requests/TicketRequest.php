<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class TicketRequest extends Request
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
            'department_id' => 'sometimes|required',
            'ticket_type_id' => 'sometimes|required',
            'ticket_subject' => 'sometimes|required',
            'ticket_priority' => 'sometimes|required'
        ];
    }
}
