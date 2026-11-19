<?php

namespace App\Http\Controllers;

use App\Models\HangSanXuat;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\HangSanXuatImport;
use App\Exports\HangSanXuatExport;

class HangSanXuatController extends Controller
{
    public function getDanhSach()
    {
        $hangsanxuat = HangSanXuat::Paginate(10);
        return view('admin.hangsanxuat.danhsach', compact('hangsanxuat'));
    }

    public function getThem()
    {
        return view('admin.hangsanxuat.them');
    }

    public function postThem(Request $request)
    {
        $request->validate([
            'tenhang' => ['required', 'string', 'max:255', 'unique:hangsanxuat'],
            'hinhanh' => ['nullable', 'image', 'max:1024']
        ]);

        // Xử lý upload hình ảnh nếu có
        $path = null;
        if ($request->hasFile('hinhanh')) {
            $file = $request->file('hinhanh');
            $extension = $file->extension();
            $filename = Str::slug($request->tenhang, '-') . '.' . $extension;

            // Upload vào thư mục 'hang-san-xuat'
            $path = $file->storeAs('hang-san-xuat', $filename);
        }

        $orm = new HangSanXuat();
        $orm->tenhang = $request->tenhang;
        $orm->tenhang_slug = Str::slug($request->tenhang, '-');
        $orm->hinhanh = $path ?? null;
        $orm->save();

        return redirect()->route('admin.hangsanxuat');
    }

    public function getSua($id)
    {
        $hangsanxuat = HangSanXuat::find($id);
        return view('admin.hangsanxuat.sua', compact('hangsanxuat'));
    }

    public function postSua(Request $request, $id)
    {
        $request->validate([
            'tenhang' => ['required', 'string', 'max:255', 'unique:hangsanxuat,tenhang,' . $id],
            'hinhanh' => ['nullable', 'image', 'max:1024']
        ]);

        $orm = HangSanXuat::find($id);

        // Kiểm tra nếu có chọn tập tin ảnh mới
        $path = null;
        if ($request->hasFile('hinhanh')) {
            // Xóa tập tin cũ nếu có
            if ($orm->hinhanh) {
                Storage::delete($orm->hinhanh);
            }

            // Upload tập tin mới
            $file = $request->file('hinhanh');
            $extension = $file->extension();
            $filename = Str::slug($request->tenhang, '-') . '.' . $extension;
            $path = $file->storeAs('hang-san-xuat', $filename);
        }

        $orm->tenhang = $request->tenhang;
        $orm->tenhang_slug = Str::slug($request->tenhang, '-');
        $orm->hinhanh = $path ?? $orm->hinhanh ?? null;
        $orm->save();

        return redirect()->route('admin.hangsanxuat');
    }

    public function getXoa($id)
    {
        $orm = HangSanXuat::find($id);

        // Lấy đường dẫn ảnh trước khi xóa bản ghi
        $hinhanh = $orm->hinhanh;
        $orm->delete();

        // Xóa tập tin ảnh trên ổ đĩa
        if ($hinhanh) {
            Storage::delete($hinhanh);
        }

        return redirect()->route('admin.hangsanxuat');
    }

    // Hàm Nhập từ Excel
    public function postNhap(Request $request)
    {
        $request->validate([
            'file_excel' => ['required', 'file', 'mimes:xlsx,xls', 'max:2048'],
        ]);

        $import = new HangSanXuatImport();
        Excel::import($import, $request->file('file_excel'));

        return redirect()->route('admin.hangsanxuat');
    }

    // Xuất ra Excel
    public function getXuat()
    {
        $filename = 'hang-san-xuat.xlsx';
        return Excel::download(new HangSanXuatExport(), $filename);
    }
}