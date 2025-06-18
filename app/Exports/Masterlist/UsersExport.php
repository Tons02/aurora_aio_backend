<?php

namespace App\Exports\Masterlist;

use App\Models\UserManagement\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\RichText\RichText;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithEvents, WithTitle
{
    protected $status;

    public function __construct($status)
    {
        $this->status = $status;
    }

    public function collection()
    {

        return User::with([
            'one_charging',
            'role'
        ])->when($this->status === "inactive", function ($query) {
            $query->onlyTrashed();
        })->get();
    }

    public function title(): string
    {
        return 'Aurora Users';
    }

    public function headings(): array
    {
        return [
            ["{$this->status} Aurora Users"],
            [
                'ID',
                'ID PREFIX',
                'ID NO',
                'First Name',
                'Last Name',
                'Mobile Number',
                'Gender',
                'Company',
                'Business Unit',
                'Department',
                'Unit',
                'Sub Unit',
                'Location',
                'Username',
                'Role',
                'Created At',
                'Status'
            ]
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $statusText = ucfirst($this->status) . " Aurora Users";
                $columnCount = 17;
                $mergeRange = 'A1:' . chr(65 + $columnCount - 1) . '1';
                $event->sheet->mergeCells($mergeRange);
                $event->sheet->setCellValue('A1', $statusText);

                $event->sheet->getDelegate()->getStyle($mergeRange)->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => 'F37925', // Background color
                        ],
                    ],
                    'font' => [
                        'color' => [
                            'rgb' => '1F1E1E', // Font color
                        ],
                        'bold' => true, // Optional: make the text bold
                    ],
                ]);

                // Apply bold and large font to the title
                $richText = new RichText();
                $firstLetter = $richText->createTextRun(substr($statusText, 0, 1));
                $firstLetter->getFont()->setSize(20)->setBold(true);

                $remainingText = $richText->createTextRun(substr($statusText, 1));
                $remainingText->getFont()->setSize(14)->setBold(true);

                $event->sheet->getDelegate()->getCell('A1')->setValue($richText);
                $event->sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

                // 🔥 **Bold and Set Font Size to 15 for Headings**
                $event->sheet->getStyle('A2:Q2')->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => 'FFF9EE',
                        ],
                    ],
                    'font' => [
                        'bold' => true,
                        'size' => 15
                    ],
                    'alignment' => [
                        'horizontal' => 'center',
                        'vertical' => 'center'
                    ]
                ]);

                // **Set Font Size for User Rows (WITHOUT BOLD)**
                $rowCount = User::count() + 2;
                for ($row = 3; $row <= $rowCount; $row++) {
                    $fillColor = ($row % 2 == 0) ? 'D3D3D3' : 'DFF5E1'; // Grey : Light Green

                    $event->sheet->getStyle("A{$row}:Q{$row}")->applyFromArray([
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => [
                                'rgb' => $fillColor,
                            ],
                        ],
                        'font' => [
                            'size' => 12,
                            'name' => 'Arial',
                        ],
                        'alignment' => [
                            'horizontal' => 'center',
                            'vertical' => 'center',
                        ],
                    ]);
                }
            },
        ];
    }


    public function map($user): array
    {
        return [
            $user->id,
            $user->id_prefix,
            $user->id_no,
            $user->first_name,
            $user->last_name,
            " " . $user->mobile_number,
            $user->gender,
            $user->one_charging->company_name,
            $user->one_charging->business_unit_name,
            $user->one_charging->department_name,
            $user->one_charging->unit_name,
            $user->one_charging->sub_unit_name,
            $user->one_charging->location_name,
            $user->username,
            $user->role->name,
            $user->created_at->format('Y-m-d H:i A'),
            $user->deleted_at ? 'Inactive' : 'Active',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]], // Make headings bold
        ];
    }
}
