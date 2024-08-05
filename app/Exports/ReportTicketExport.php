<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class ReportTicketExport implements FromCollection
{
    protected $tickets;

    public function __construct($tickets)
    {
        $this->tickets = $tickets;
    }

    public function collection()
    {
        return $this->tickets;
    }
}
