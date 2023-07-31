<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// user
Route::get('/', [UserController::class, 'trangchu'])->name('/');
Route::get('/baohanh', [UserController::class, 'baohanh'])->name('baohanh');
Route::get('/tragop', [UserController::class, 'tragop'])->name('tragop');
Route::get('/chitietsp', [UserController::class, 'chitietsp'])->name('chitietsp');
Route::get('/danhsachsp', [UserController::class, 'danhsachsp'])->name('danhsachsp');
Route::get('/timkiem', [UserController::class, 'timkiem'])->name('timkiem');


Route::get('/giohang', [UserController::class, 'giohang'])->name('giohang');
Route::post('/xulygiohang', [UserController::class, 'xulygiohang'])->name('xulygiohang');

Route::get('/lienhe', [UserController::class, 'lienhe'])->name('lienhe');
Route::post('/xulylienhe', [UserController::class, 'xulylienhe'])->name('xulylienhe');


Route::get('/dangnhap', [UserController::class, 'dangnhap'])->name('dangnhap');
Route::get('/taikhoan', [UserController::class, 'taikhoan'])->name('taikhoan');
Route::post('/xulytaikhoan', [UserController::class, 'xulytaikhoan'])->name('xulytaikhoan');

Route::get('/thanhtoan', [UserController::class, 'thanhtoan'])->name('thanhtoan');
Route::post('/xulythanhtoan', [UserController::class, 'xulythanhtoan'])->name('xulythanhtoan');

Route::get('/yeuthich', [UserController::class, 'yeuthich'])->name('yeuthich');
Route::get('/xulyyeuthich', [UserController::class, 'xulyyeuthich'])->name('xulyyeuthich');

Route::get('/dangxuat', [UserController::class, 'dangxuat'])->name('dangxuat');

//admin
Route::get('/tongquan', [AdminController::class, 'tongquan'])->name('tongquan');

Route::post('/xulysanpham', [AdminController::class, 'xulysanpham'])->name('xulysanpham');

Route::get('/laptop', [AdminController::class, 'laptop'])->name('laptop');
Route::post('/xulylaptop', [AdminController::class, 'xulylaptop'])->name('xulylaptop');

Route::get('/phukien', [AdminController::class, 'phukien'])->name('phukien');
Route::post('/xulyphukien', [AdminController::class, 'xulyphukien'])->name('xulyphukien');

Route::get('/hangsanxuat', [AdminController::class, 'hangsanxuat'])->name('hangsanxuat');
Route::post('/xulyhangsanxuat', [AdminController::class, 'xulyhangsanxuat'])->name('xulyhangsanxuat');

Route::get('/phieuxuat', [AdminController::class, 'phieuxuat'])->name('phieuxuat');
Route::get('/inphieuxuat', [AdminController::class, 'inphieuxuat'])->name('inphieuxuat');
Route::get('/xemphieuxuat', [AdminController::class, 'xemphieuxuat'])->name('xemphieuxuat');

Route::post('/xulyphieuxuat', [AdminController::class, 'xulyphieuxuat'])->name('xulyphieuxuat');

Route::get('/themphieuxuat', [AdminController::class, 'themphieuxuat'])->name('themphieuxuat');
Route::get('/suaphieuxuat', [AdminController::class, 'suaphieuxuat'])->name('suaphieuxuat');

Route::get('/phieunhap', [AdminController::class, 'phieunhap'])->name('phieunhap');
Route::get('/inphieunhap', [AdminController::class, 'inphieunhap'])->name('inphieunhap');

Route::post('/xulyphieunhap', [AdminController::class, 'xulyphieunhap'])->name('xulyphieunhap');

Route::get('/themphieunhap', [AdminController::class, 'themphieunhap'])->name('themphieunhap');
Route::get('/suaphieunhap', [AdminController::class, 'suaphieunhap'])->name('suaphieunhap');


Route::get('/magiamgia', [AdminController::class, 'magiamgia'])->name('magiamgia');
Route::post('/xulymagiamgia', [AdminController::class, 'xulymagiamgia'])->name('xulymagiamgia');


Route::get('/nguoidung', [AdminController::class, 'nguoidung'])->name('nguoidung');
Route::post('/xulynguoidung', [AdminController::class, 'xulynguoidung'])->name('xulynguoidung');

Route::get('/clear', function() {
    Artisan::call('cache:clear');
    return back();
});
Route::get('/thongtinthanhtoan', function() {
    $thongTinThanhToanVNPAY = [
        'nganHang' => 'NCB',
        'soThe' => '9704198526191432198',
        'ngayPhatHanh' => '07/15',
        'tenChuThe' => 'NGUYEN VAN A',
        'matKhauOTP' => '123456'
    ];
    return dd($thongTinThanhToanVNPAY);
});
