<?php

namespace App\Exports;

use App\Models\HangSanXuat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithMapping;

class HangSanXuatExport implements FromCollection, WithHeadings, WithCustomStartCell, WithMapping
{
    /**
     * Định nghĩa các tiêu đề cột trên file Excel
     */
    public function headings(): array
    {
        return [
            'tenhang',
            'tenhang_slug',
            'hinhanh',
        ];
    }

    /**
     * Định dạng/ánh xạ từng dòng dữ liệu lấy từ Model
     */
    public function map($row): array
    {
        return [
            $row->tenhang,
            $row->tenhang_slug,
            $row->hinhanh,
        ];
    }

    /**
     * Vị trí ô bắt đầu ghi dữ liệu
     */
    public function startCell(): string
    {
        return 'A1';
    }

    /**
     * Lấy toàn bộ danh sách Hãng sản xuất
     */
    public function collection()
    {
        return HangSanXuat::all();
    }
}