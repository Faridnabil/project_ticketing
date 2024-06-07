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
            'title'       => [
                'required',
            ],
            'category_id' => [
                'required',
                'integer',
            ],
            'ticket_id' =>
            'required|string|unique:tickets,ticket_id|max:255|regex:/^TICK-\d{6}$/',
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'author_name' => 'nullable|string|max:255',
            'author_email' => 'nullable|string|email|max:255',
            'ticket_id' => 'required|string|unique:tickets,ticket_id|max:255|regex:/^TICK-\d{6}$/',
            // 'status_id' => 'required|integer',
            // 'priority_id' => 'required|integer',
            'category_id' => 'required|integer',
            'assigned_to_user_id' => 'required|integer',

        ];
    }
    public function messages()
    {
        return [
            'ticket_id.unique' => 'The ticket ID must be unique. Please use a different ID.',
            'ticket_id.regex' => 'The ticket ID format is invalid. Use the format TICK-123456.',
        ];
    }
}
