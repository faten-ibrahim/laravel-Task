<?php

namespace App\Exports;

use App\User;
use App\Visitor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class VisitorsExport implements  FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $visitors = Visitor::where('users.is_visitor', '=', 1)
            ->Join('cities', 'users.city_id', '=', 'cities.id')
            ->Join('countries', 'users.country_id', '=', 'countries.id')
            ->select( 'users.id', 'users.first_name', 'users.last_name', 'users.email', 'users.phone', 'users.gender','cities.name','countries.full_name')->get();
        return $visitors;
    }
    public function headings(): array
    {
        return [
            '#',
            'first name',
            'last name',
            'email',
            'phone',
            'gender',
            'city',
            'country',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                // All headers - set font size to 14
                $cellRange = 'A1:W1';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                $event->sheet->getDelegate()->getStyle('B2:G8');
                // Set first row to height 20
                $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(20);
                // Set A1:D4 range to wrap text in cells
                $event->sheet->getDelegate()->getStyle('A1:D4')
                    ->getAlignment()->setWrapText(true);
            },
        ];
    }
}
