<?php

namespace App\Http\Requests;

use App\Ticket;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreTicketRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('ticket_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'category_id' => [
                'required',
                'integer',
            ],
            'content' => 'nullable|string',
            'author_name' => 'nullable|string|max:255',
            'author_email' => 'nullable|string|email|max:255',
            'assigned_to_user_id' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            // 'ticket_id.unique' => 'The ticket ID must be unique. Please use a different ID.',
            // 'ticket_id.regex' => 'The ticket ID format is invalid. Use the format TICK-123456.',
        ];
    }
}
