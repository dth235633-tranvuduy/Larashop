<?php

namespace App\Http\Controllers;

use App\Models\SanPham;
use App\Models\LoaiSanPham;
use App\Models\HangSanXuat;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SanPhamImport;
use App\Exports\SanPhamExport;

class SanPhamController extends Controller
{
    public function getDanhSach()
    {
        $sanpham = SanPham::Paginate(10);
        return view('admin.sanpham.danhsach', compact('sanpham'));
    }

    public function getThem()
    {
        $loaisanpham = LoaiSanPham::all();
        $hangsanxuat = HangSanXuat::all();
        return view('admin.sanpham.them', compact('loaisanpham', 'hangsanxuat'));
    }

    public function postThem(Request $request)
    {
        // Kiểm tra hợp lệ dữ liệu
        $request->validate([
            'loaisanpham_id' => ['required'],
            'hangsanxuat_id' => ['required'],
            'tensanpham' => ['required', 'string', 'max:255', 'unique:sanpham'],
            'soluong' => ['required', 'numeric'],
            'dongia' => ['required', 'numeric'],
            'hinhanh' => ['nullable', 'image', 'max:2048'],
        ]);

        // Xử lý upload hình ảnh nếu có
        $path = null;
        if ($request->hasFile('hinhanh')) {
            // Xác định thư mục theo slug loại sản phẩm
            $loaisanpham = LoaiSanPham::find($request->loaisanpham_id);
            $directory = $loaisanpham->tenloai_slug;

            // Xác định tên tập tin theo slug tên sản phẩm
            $file = $request->file('hinhanh');
            $extension = $file->extension();
            $filename = Str::slug($request->tensanpham, '-') . '.' . $extension;

            // Upload vào thư mục và lưu đường dẫn
            $path = $file->storeAs($directory, $filename);
        }

        $orm = new SanPham();
        $orm->loaisanpham_id = $request->loaisanpham_id;
        $orm->hangsanxuat_id = $request->hangsanxuat_id;
        $orm->tensanpham = $request->tensanpham;
        $orm->tensanpham_slug = Str::slug($request->tensanpham, '-');
        $orm->soluong = $request->soluong;
        $orm->dongia = $request->dongia;
        $orm->hinhanh = $path ?? null;
        $orm->motasanpham = $request->motasanpham;
        $orm->save();

        // Sau khi thêm thành công thì tự động chuyển về trang danh sách
        return redirect()->route('admin.sanpham');
    }

    public function getSua($id)
    {
        $sanpham = SanPham::find($id);
        $loaisanpham = LoaiSanPham::all();
        $hangsanxuat = HangSanXuat::all();
        return view('admin.sanpham.sua', compact('sanpham', 'loaisanpham', 'hangsanxuat'));
    }

    public function postSua(Request $request, $id)
    {
        // Kiểm tra hợp lệ dữ liệu
        $request->validate([
            'loaisanpham_id' => ['required'],
            'hangsanxuat_id' => ['required'],
            'tensanpham' => ['required', 'string', 'max:255', 'unique:sanpham,tensanpham,' . $id],
            'soluong' => ['required', 'numeric'],
            'dongia' => ['required', 'numeric'],
            'hinhanh' => ['nullable', 'image', 'max:2048'],
        ]);

        $orm = SanPham::find($id);

        // Xử lý upload hình ảnh nếu có
        $path = null;
        if ($request->hasFile('hinhanh')) {
            // Xóa tập tin cũ nếu có
            if ($orm->hinhanh) {
                Storage::delete($orm->hinhanh);
            }

            // Xác định thư mục
            $loaisanpham = LoaiSanPham::find($request->loaisanpham_id);
            $directory = $loaisanpham->tenloai_slug;

            // Xác định tên tập tin theo slug tên sản phẩm
            $file = $request->file('hinhanh');
            $extension = $file->extension();
            $filename = Str::slug($request->tensanpham, '-') . '.' . $extension;

            // Upload vào thư mục và lưu đường dẫn
            $path = $file->storeAs($directory, $filename);
        }


        // Cập nhật CSDL
        $orm->loaisanpham_id = $request->loaisanpham_id;
        $orm->hangsanxuat_id = $request->hangsanxuat_id;
        $orm->tensanpham = $request->tensanpham;
        $orm->tensanpham_slug = Str::slug($request->tensanpham, '-');
        $orm->soluong = $request->soluong;
        $orm->dongia = $request->dongia;
        $orm->hinhanh = $path ?? $orm->hinhanh ?? null;
        $orm->motasanpham = $request->motasanpham;
        $orm->save();

        // Sau khi sửa thành công thì tự động chuyển về trang danh sách
        return redirect()->route('admin.sanpham');
    }

    public function getXoa($id)
    {
        $orm = SanPham::find($id);

        // Lấy đường dẫn ảnh trước khi xóa bản ghi
        $hinhanh = $orm->hinhanh;
        $orm->delete();

        // Xóa tập tin ảnh trên ổ đĩa
        if ($hinhanh) {
            Storage::delete($hinhanh);
        }

        return redirect()->route('admin.sanpham');
    }

    // Hàm Nhập từ Excel
    public function postNhap(Request $request)
    {
        $request->validate([
            'file_excel' => ['required', 'file', 'mimes:xlsx,xls', 'max:2048'],
        ]);

        $import = new SanPhamImport();
        Excel::import($import, $request->file('file_excel'));

        return redirect()->route('admin.sanpham');
    }

    // Hàm Xuất ra Excel
    public function getXuat()
    {
        $filename = 'san-pham.xlsx';
        return Excel::download(new SanPhamExport(), $filename);
    }
}