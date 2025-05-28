<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\Queue\ShouldQueue;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Events\AfterSheet;

class ProductsExport implements FromCollection, WithHeadings, ShouldQueue, WithColumnFormatting, ShouldAutoSize, WithEvents
{
    /**
     * Summary of collection
     * @return Collection<int, array>|\Illuminate\Database\Eloquent\Collection<int, array>
     */
    public function collection(): Collection
    {
        return Product::with('category')->get()->map(function ($product) {
            return [
                $product->name,
                $product->barcode,
                $product->price,
                $product->category?->name,
            ];
        });
    }

    /**
     * Summary of headings
     * @return string[][]
     */
    public function headings(): array
    {
        return [
            ['Название товара', 'Штрихкод', 'Цена', 'Название категории'],
        ];
    }

    /**
     * Summary of columnFormats
     * @return array{B: string, C: string}
     */
    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_NUMBER,
            'C' => NumberFormat::FORMAT_NUMBER_00
        ];
    }

    /**
     * Важная примечания!
     * registerEvents стили не применяются с ShouldQueue
     * @return (callable(AfterSheet ):void)[]
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Вставить строку перед первой строкой
                $sheet->insertNewRowBefore(1, 1);
                $sheet->mergeCells('A1:D1');
                $sheet->setCellValue('A1', 'Отчёт по продуктам');

                // Стили для основного заголовка
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 14,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                // Стили для строки подзаголовков
                $sheet->getStyle('A2:D2')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                // Определим диапазон данных
                $lastColumn = $sheet->getHighestColumn();
                $lastRow = $sheet->getHighestRow();
                $range = 'A3:' . $lastColumn . $lastRow;

                // Применим стили к данным
                $sheet->getStyle($range)->applyFromArray([
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
            },
        ];
    }
}
