<?php

namespace App\Imports;

use App\Models\SanPham;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class SanPhamImport implements WithHeadingRow, ToModel
{
    // Trường hợp file Excel không có tiêu đề
    /*
    public function model(array $row)
    {
        return new SanPham([
            'loaisanpham_id' => $row[0],
            'hangsanxuat_id' => $row[1],
            'tensanpham' => $row[2],
            'tensanpham_slug' => $row[3],
            'soluong' => $row[4],
            'dongia' => $row[5],
            'hinhanh' => $row[6],
        ]);
    }
    */

    /* 
    Trường hợp file Excel có tiêu đề có dấu
    \WithHeadingRow
    public function model(array $row)
    {
        return new SanPham([
            'loaisanpham_id' => $row['ma_loai'],
            'hangsanxuat_id' => $row['ma_hang_san_xuat'],
            'tensanpham' => $row['ten_san_pham'],
            'tensanpham_slug' => $row['ten_san_pham_khong_dau'],
            'soluong' => $row['so_luong'],
            'dongia' => $row['don_gia'],
            'hinhanh' => $row['hinh_anh'],
        ]);
    }
    */

    /* 
    Trường hợp file Excel có tiêu đề không dấu và trùng với các cột của CSDL
    \WithHeadingRow
    */
    public function model(array $row): Model|null
    {
        return new SanPham([
            'loaisanpham_id' => $row['loaisanpham_id'],
            'hangsanxuat_id' => $row['hangsanxuat_id'],
            'tensanpham' => $row['tensanpham'],
            'tensanpham_slug' => $row['tensanpham_slug'],
            'soluong' => $row['soluong'],
            'dongia' => $row['dongia'],
            'hinhanh' => $row['hinhanh'],
        ]);
    }


    /* 
   Trường hợp file Excel có tiêu đề không dấu và trùng với các cột của CSDL nhưng viết HOA
   \WithHeadingRowFormatter
    public function model(array $row)
    {
        return new SanPham([
            'loaisanpham_id' => $row['LoaiSanPham_ID'],
            'hangsanxuat_id' => $row['HangSanXuat_ID'],
            'tensanpham' => $row['TenSanPham'],
            'tensanpham_slug' => $row['TenSanPham_Slug'],
            'soluong' => $row['SoLuong'],
            'dongia' => $row['DonGia'],
            'hinhanh' => $row['HinhAnh'],
        ]);
    }
   */

    /* 
   Trường hợp file Excel không bắt đầu từ dòng đầu tiên
    \WithHeadingRow

    public function model(array $row)
    {
        return new SanPham([
            'loaisanpham_id' => $row['ma_loai'],
            'hangsanxuat_id' => $row['ma_hang_san_xuat'],
            'tensanpham' => $row['ten_san_pham'],
            'tensanpham_slug' => $row['ten_san_pham_khong_dau'],
            'soluong' => $row['so_luong'],
            'dongia' => $row['don_gia'],
            'hinhanh' => $row['hinh_anh'],
        ]);
    }
    public function headingRow(): int
    {
        return 6;
    }
   */

}