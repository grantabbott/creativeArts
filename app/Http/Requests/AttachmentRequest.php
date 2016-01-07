<?php

namespace App\Http\Requests;
use App\Http\Requests\Request;
use Config;

class AttachmentRequest extends Request
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
            'belongs_to' => 'required',
            'unique_id' => 'required',
            'file_title'=>'required',
            'file'=> 'required|mimes:'.config('config.allowed_upload_file')
        ];
    }
}
