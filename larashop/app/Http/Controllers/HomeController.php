<?php

namespace App\Http\Controllers;

use App\Models\LoaiSanPham;
use App\Models\SanPham;
use App\Models\User;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use App\Models\ChuDe;
use App\Models\BaiViet;

class HomeController extends Controller
{
    // Lấy loại sản phẩm kèm 8 sản phẩm mới nhất hiển thị ra trang chủ
    public function getHome()
    {
        $loaisanpham = LoaiSanPham::with([
            'SanPham' => function ($query) {
                $query->latest()->take(8);
            }
        ])->get();

        return view('frontend.home', compact('loaisanpham'));
    }

    public function getSanPham($tenloai_slug = '')
    {
        return view('frontend.sanpham');
    }

    public function getSanPham_ChiTiet($tenloai_slug = '', $tensanpham_slug = '')
    {
        return view('frontend.sanpham_chitiet');
    }

    // Bước 11: Lấy danh sách bài viết (tất cả hoặc lọc theo chủ đề)
    public function getBaiViet($tenchude_slug = '')
    {
        if (empty($tenchude_slug)) {
            $title = 'Tất cả tin tức';
            $baiviet = BaiViet::where('kichhoat', 1)
                ->where('kiemduyet', 1)
                ->orderBy('created_at', 'desc')
                ->paginate(12);
        } else {
            $chude = ChuDe::where('tenchude_slug', $tenchude_slug)
                ->firstOrFail();
            $title = $chude->tenchude;
            $baiviet = BaiViet::where('kichhoat', 1)
                ->where('kiemduyet', 1)
                ->where('chude_id', $chude->id)
                ->orderBy('created_at', 'desc')
                ->paginate(12);
        }

        return view('frontend.baiviet', compact('title', 'baiviet'));
    }

    // Bước 11: Xem chi tiết bài viết, tăng lượt xem qua Session và lấy bài viết cùng chuyên mục
    public function getBaiViet_ChiTiet($tenchude_slug = '', $tieude_slug = '')
    {
        $tieude_id = explode('.', $tieude_slug);
        $tieude = explode('-', $tieude_id[0]);
        $baiviet_id = $tieude[count($tieude) - 1];

        $baiviet = BaiViet::where('kichhoat', 1)
            ->where('kiemduyet', 1)
            ->where('id', $baiviet_id)
            ->firstOrFail();

        if (!$baiviet) abort(404);

        // Cập nhật lượt xem
        $daxem = 'BV' . $baiviet_id;
        if (!session()->has($daxem)) {
            $orm = BaiViet::find($baiviet_id);
            $orm->luotxem = $baiviet->luotxem + 1;
            $orm->save();
            session()->put($daxem, 1);
        }

        $baivietcungchuyemuc = BaiViet::where('kichhoat', 1)
            ->where('kiemduyet', 1)
            ->where('chude_id', $baiviet->chude_id)
            ->where('id', '!=', $baiviet_id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('frontend.baiviet_chitiet', compact('baiviet', 'baivietcungchuyemuc'));
    }

    // Kiểm tra giỏ hàng, nếu rỗng trả về view giohangrong
    public function getGioHang()
    {
        if (Cart::count() > 0) {
            return view('frontend.giohang');
        } else {
            return view('frontend.giohangrong');
        }
    }

    // Thêm sản phẩm vào giỏ hàng
    public function getGioHang_Them($tensanpham_slug = '')
    {
        $sanpham = SanPham::where('tensanpham_slug', $tensanpham_slug)->first();

        Cart::add([
            'id'      => $sanpham->id,
            'name'    => $sanpham->tensanpham,
            'price'   => $sanpham->dongia,
            'qty'     => 1,
            'weight'  => 0,
            'options' => [
                'image' => $sanpham->hinhanh,
            ],
        ]);

        return redirect()->route('frontend.home');
    }

    // Xóa một sản phẩm khỏi giỏ hàng
    public function getGioHang_Xoa($row_id)
    {
        Cart::remove($row_id);
        return redirect()->route('frontend.giohang');
    }

    // Giảm số lượng sản phẩm (giới hạn tối thiểu là 1)
    public function getGioHang_Giam($row_id)
    {
        $row = Cart::get($row_id);
        if ($row->qty > 1) {
            Cart::update($row_id, $row->qty - 1);
        }
        return redirect()->route('frontend.giohang');
    }

    // Tăng số lượng sản phẩm (giới hạn tối đa là 10)
    public function getGioHang_Tang($row_id)
    {
        $row = Cart::get($row_id);
        if ($row->qty < 10) {
            Cart::update($row_id, $row->qty + 1);
        }
        return redirect()->route('frontend.giohang');
    }

    public function getTuyenDung()
    {
        return view('frontend.tuyendung');
    }

    public function getLienHe()
    {
        return view('frontend.lienhe');
    }

    public function getDangKy()
    {
        return view('user.dangky');
    }

    public function getDangNhap()
    {
        return view('user.dangnhap');
    }

    // Chuyển tới màn hình Đăng nhập bằng Google
    public function getGoogleLogin()
    {
        return Socialite::driver('google')->redirect();
    }

    // Xử lý phản hồi sau khi đăng nhập thành công ở Google
    public function getGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')
                ->setHttpClient(new \GuzzleHttp\Client(['verify' => false]))
                ->stateless()
                ->user();
        } catch (\Exception $e) {
            return redirect()->route('user.dangnhap')->with('warning', 'Lỗi xác thực. Xin vui lòng thử lại!');
        }

        $existingUser = User::where('email', $user->email)->first();
        if ($existingUser) {
            // Nếu người dùng đã tồn tại thì đăng nhập
            Auth::login($existingUser, true);
            return redirect()->route('user.home');
        } else {
            // Nếu chưa tồn tại người dùng thì thêm mới
            $newUser = User::create([
                'name'     => $user->name,
                'email'    => $user->email,
                'username' => Str::before($user->email, '@'),
                'password' => Hash::make('larashop@2025'), // Gán mật khẩu tự do
            ]);

            // Sau đó đăng nhập
            Auth::login($newUser, true);
            return redirect()->route('user.home');
        }
    }
}