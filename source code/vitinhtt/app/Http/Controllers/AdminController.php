<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SanPham;
use App\Models\ThuVienHinh;
use App\Models\Laptop;
use App\Models\PhuKien;
use App\Models\HangSanXuat;
use App\Models\QuaTang;
use App\Models\NguoiDung;
use App\Models\PhieuNhap;
use App\Models\ChiTietPhieuNhap;
use App\Models\PhieuXuat;
use App\Models\ChiTietPhieuXuat;
use App\Models\MaGiamGia;
use App\Models\LoiPhanHoi;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use PDF;
class AdminController extends Controller
{
    //
    private $sanPham;
    private $laptop;
    private $phuKien;
    private $thuVienHinh;
    private $hangSanXuat;
    private $quaTang;
    private $nguoiDung;
    private $phieuNhap;
    private $chiTietPhieuNhap;
    private $phieuXuat;
    private $chiTietPhieuXuat;
    private $maGiamGia;
    private $loiPhanHoi;

    public function __construct()
    {
        $this->sanPham = new SanPham();
        $this->laptop = new Laptop();
        $this->phuKien = new PhuKien();
        $this->thuVienHinh = new ThuVienHinh();
        $this->hangSanXuat = new HangSanXuat();
        $this->quaTang = new QuaTang();
        $this->nguoiDung = new NguoiDung();
        $this->phieuNhap = new PhieuNhap();
        $this->chiTietPhieuNhap = new ChiTietPhieuNhap();
        $this->phieuXuat = new PhieuXuat();
        $this->chiTietPhieuXuat = new ChiTietPhieuXuat();
        $this->maGiamGia = new MaGiamGia();
        $this->loiPhanHoi = new LoiPhanHoi();
    }
    public function tongquan(Request $request)
    {
        if (!Auth::check() || Auth::user()->loainguoidung != 2) {
            return redirect()->route('dangnhap');
        }
        $danhSachSanPham = $this->sanPham->layDanhSachSanPham();
        $soLuongLaptop = 0;
        $soLuongPhuKien = 0;
        foreach ($danhSachSanPham as $sanpham) {
            if ($sanpham->loaisanpham == 0) { // la laptop
                $soLuongLaptop += $sanpham->soluong;
            }
            if ($sanpham->loaisanpham == 1) { // la phu kien
                $soLuongPhuKien += $sanpham->soluong;
            }
        }
        $soLuongDonHang = count($this->phieuXuat->layDanhSachPhieuXuat());
        $soLuongNguoiDung = count($this->nguoiDung->layDanhSachNguoiDung());
        $danhSachPhieuXuatChoXacNhan = $this->phieuXuat->layDanhSachPhieuXuatTheoBoLoc([['phieuxuat.tinhtranggiaohang', '=', 1]]);
        $danhSachLoiPhanHoiChuaDoc = $this->loiPhanHoi->layDanhSachLoiPhanHoiTheoBoLoc([['loiphanhoi.trangthai', '=', 0]]);
        $danhSachLoiPhanHoi = $this->loiPhanHoi->layDanhSachLoiPhanHoiTheoBoLoc(NULL);
        $doanhThuTuanNay = $this->phieuXuat->doanhThuTuanNay();
        if (isset($request->thaotac)) {
            if ($request->thaotac == "doitrangthai") { // *******************************************************************************************doi trang thai loi phan hoi// loi nhan lien he
                $rules = [
                    'maloiphanhoi' => 'required|integer|exists:loiphanhoi,maloiphanhoi'
                ];
                $messages = [
                    'required' => ':attribute bắt buộc nhập',
                    'exists' => ':attribute không tồn tại',
                    'integer' => ':attribute nhập sai'
                ];
                $attributes = [
                    'maloiphanhoi' => 'Mã lời phản hồi'
                ];
                $request->validate($rules, $messages, $attributes);
                $thongTinLoiPhanHoi = $this->loiPhanHoi->timLoiPhanHoiTheoMa($request->maloiphanhoi);
                if ($thongTinLoiPhanHoi->trangthai == 0) {
                    $thongTinLoiPhanHoi->trangthai = 1;
                } elseif ($thongTinLoiPhanHoi->trangthai == 1) {
                    $thongTinLoiPhanHoi->trangthai = 0;
                }
                $dataLoiPhanHoi = [
                    $thongTinLoiPhanHoi->trangthai
                ];
                $this->loiPhanHoi->doiTrangThaiLoiPhanHoi($dataLoiPhanHoi, $thongTinLoiPhanHoi->maloiphanhoi);
                return redirect('tongquan#loiphanhoi');
            } elseif ($request->thaotac == "doitrangthaitatca" && !empty($danhSachLoiPhanHoi)) {
                $this->loiPhanHoi->doiTrangThaiLoiPhanHoiTatCa();
                return redirect('tongquan#loiphanhoi');
            }
            return back()->with(
                'tieudethongbao',
                'Thao tác thất bại'
            )->with(
                'thongbao',
                'Vui lòng thử lại!'
            )->with(
                'loaithongbao',
                'danger'
            );
        }
        return view('admin.tongquan', compact(
            'soLuongLaptop',
            'soLuongPhuKien',
            'soLuongDonHang',
            'danhSachPhieuXuatChoXacNhan',
            'danhSachLoiPhanHoiChuaDoc',
            'danhSachLoiPhanHoi',
            'doanhThuTuanNay',
            'soLuongNguoiDung'
        ));
    }
    public function xulysanpham(Request $request)
    {
        $request->validate(['thaoTac' => 'required|string']);
        if ($request->thaoTac == "cập nhật giá") { // *******************************************************************************************cap nhat gia san pham
            $rules = [
                'maSanPhamSuaGia' => 'required|integer|exists:sanpham,masanpham',
                'giaBan' => 'required|string|max:255|min:1'
            ];
            $messages = [
                'required' => ':attribute bắt buộc nhập',
                'exists' => ':attribute không tồn tại',
                'integer' => ':attribute nhập sai',
                'string' => ':attribute nhập sai',
                'min' => ':attribute tối thiểu :min ký tự',
                'max' => ':attribute tối đa :max ký tự'
            ];
            $attributes = [
                'maSanPhamSuaGia' => 'Mã sản phẩm',
                'giaBan' => 'Giá bán'
            ];
            $request->validate($rules, $messages, $attributes);
            $thongTinSanPham = $this->sanPham->timSanPhamTheoMa($request->maSanPhamSuaGia); //tim san pham
            $giaBan = explode(',', $request->giaBan);
            $temp = "";
            foreach ($giaBan as $gb) {
                $temp = $temp . $gb;
            }
            $giaBan = $temp;
            if (!is_numeric($giaBan) || $giaBan <= $thongTinSanPham->gianhap || $giaBan <= 0) { // gia ban nhap vao khong phai ky tu so hoac thap hon gia nhap, quay lai trang truoc va bao loi
                return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Giá bán nhập sai, vui lòng nhập lại!')->with('loaithongbao', 'danger');
            }
            $dataSanPham = [
                $giaBan,
                NULL //giakhuyenmai
            ];
            if (isset($request->giaKhuyenMaiCheck)) {
                if ($request->giaKhuyenMaiCheck == "on") {
                    $rules = [
                        'giaKhuyenMai' => 'required|string|max:255|min:1'
                    ];
                    $messages = [
                        'required' => ':attribute bắt buộc nhập',
                        'string' => ':attribute nhập sai',
                        'min' => ':attribute tối thiểu :min ký tự',
                        'max' => ':attribute tối đa :max ký tự'
                    ];
                    $attributes = [
                        'giaKhuyenMai' => 'Giá khuyến mãi'
                    ];
                    $request->validate($rules, $messages, $attributes);
                    $giaKhuyenMai = explode(',', $request->giaKhuyenMai);
                    $temp = "";
                    foreach ($giaKhuyenMai as $gkm) {
                        $temp = $temp . $gkm;
                    }
                    $giaKhuyenMai = $temp;
                    if (!is_numeric($giaKhuyenMai) || $giaKhuyenMai >= $giaBan || $giaKhuyenMai <= 0) { // gia khuyen mai nhap vao khong phai ky tu so hoac thap hon gia nhap hoac lon hon gia ban, quay lai trang truoc va bao loi
                        return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Giá khuyến mãi nhập sai, vui lòng nhập lại!')->with('loaithongbao', 'danger');
                    }
                    $dataSanPham = [
                        $giaBan,
                        $giaKhuyenMai //giakhuyenmai
                    ];
                } else {
                    return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Giá khuyến mãi nhập sai, vui lòng nhập lại!')->with('loaithongbao', 'danger');
                }
            }
            $this->sanPham->capNhatGia($dataSanPham, $thongTinSanPham->masanpham); //cap nhat gia san pham tren database
            return back()->with(
                'tieudethongbao',
                'Thao tác thành công'
            )->with(
                'thongbao',
                'Cập nhật giá sản phẩm thành công'
            )->with(
                'loaithongbao',
                'success'
            );
        }
        return back()->with(
            'tieudethongbao',
            'Thao tác thất bại'
        )->with(
            'thongbao',
            'Vui lòng thử lại!'
        )->with(
            'loaithongbao',
            'danger'
        );
    }
    public function laptop()
    {
        if (!Auth::check() || Auth::user()->loainguoidung != 2) {
            return redirect()->route('dangnhap');
        }
        $danhSachSanPham = $this->sanPham->layDanhSachSanPham();
        $danhSachLaptop = $this->laptop->layDanhSachLaptop();
        $danhSachThuVienHinh = $this->thuVienHinh->layDanhSachThuVienHinh();
        $danhSachHangSanXuat = $this->hangSanXuat->layDanhSachHangSanXuat();
        $danhSachQuaTang = $this->quaTang->layDanhSachQuaTang();
        $danhSachHangSanXuatLaptop = []; // loc lai danh sach theo loai hang san xuat laptop can xem
        foreach ($danhSachHangSanXuat as $hangSanXuat) {
            if ($hangSanXuat->loaihang == 0) {
                $danhSachHangSanXuatLaptop = array_merge($danhSachHangSanXuatLaptop, [$hangSanXuat]);
            }
        }
        $danhSachPhieuXuatChoXacNhan = $this->phieuXuat->layDanhSachPhieuXuatTheoBoLoc([['phieuxuat.tinhtranggiaohang', '=', 1]]);
        $danhSachLoiPhanHoiChuaDoc = $this->loiPhanHoi->layDanhSachLoiPhanHoiTheoBoLoc([['loiphanhoi.trangthai', '=', 0]]);
        return view('admin.laptop', compact(
            'danhSachSanPham',
            'danhSachLaptop',
            'danhSachThuVienHinh',
            'danhSachHangSanXuatLaptop',
            'danhSachPhieuXuatChoXacNhan',
            'danhSachLoiPhanHoiChuaDoc',
            'danhSachQuaTang'
        ));
    }
    public function xulylaptop(Request $request)
    {
        $request->validate(['thaoTac' => 'required|string']);
        if ($request->thaoTac == "xóa laptop") { // *******************************************************************************************xoa laptop
            $rules = [
                'maSanPhamXoa' => 'required|integer|exists:sanpham,masanpham'
            ];
            $messages = [
                'required' => ':attribute bắt buộc nhập',
                'exists' => ':attribute không tồn tại',
                'integer' => ':attribute nhập sai'
            ];
            $attributes = [
                'maSanPhamXoa' => 'Mã sản phẩm'
            ];
            $request->validate($rules, $messages, $attributes);
            $thongTinSanPham = $this->sanPham->timSanPhamTheoMa($request->maSanPhamXoa); //tim san pham
            $thongTinChiTietPhieuNhap = $this->chiTietPhieuNhap->timDanhSachChiTietPhieuNhapTheoMaSanPham($thongTinSanPham->masanpham);
            if (!empty($thongTinChiTietPhieuNhap)) {
                return back()->with(
                    'tieudethongbao',
                    'Thao tác thất bại'
                )->with(
                    'thongbao',
                    'Laptop đã tồn tại trong phiếu nhập [PN' . $thongTinChiTietPhieuNhap[0]->maphieunhap . '] nên không thể xóa'
                )->with(
                    'loaithongbao',
                    'danger'
                );
            }
            $thongTinChiTietPhieuXuat = $this->chiTietPhieuXuat->timDanhSachChiTietPhieuXuatTheoMaSanPham($thongTinSanPham->masanpham);
            if (!empty($thongTinChiTietPhieuXuat)) {
                return back()->with(
                    'tieudethongbao',
                    'Thao tác thất bại'
                )->with(
                    'thongbao',
                    'Laptop đã tồn tại trong phiếu xuất [PX' . $thongTinChiTietPhieuXuat[0]->maphieuxuat . '] nên không thể xóa'
                )->with(
                    'loaithongbao',
                    'danger'
                );
            }
            if (!empty($thongTinSanPham)) {
                $this->sanPham->xoaSanPham($thongTinSanPham->masanpham); //xoa san pham tren database
                if ($thongTinSanPham->loaisanpham == 0 && !empty($thongTinSanPham->malaptop)) {
                    $thongTinLaptop = $this->laptop->timLaptopTheoMa($thongTinSanPham->malaptop); //tim laptop
                    if (!empty($thongTinLaptop)) {
                        $this->laptop->xoaLaptop($thongTinLaptop->malaptop); //xoa laptop tren database
                    }
                }
                $thongTinHinh = $this->thuVienHinh->timThuVienHinhTheoMa($thongTinSanPham->mathuvienhinh); //tim thu vien hinh
                if (!empty($thongTinHinh)) {
                    $this->thuVienHinh->xoaThuVienHinh($thongTinHinh->mathuvienhinh); //xoa thu vien hinh tren database
                    foreach ($thongTinHinh as $giaTri) {
                        if (!empty($giaTri)) {
                            $duongDanHinhCanXoa = 'img/sanpham/' . $giaTri;
                            if (File::exists($duongDanHinhCanXoa)) {
                                File::delete($duongDanHinhCanXoa); //xoa thu vien hinh tren host sever
                            }
                        }
                    }
                }
                $thongTinQuaTang = $this->quaTang->timQuaTangTheoMa($thongTinSanPham->maquatang); //tim qua tang
                if (!empty($thongTinQuaTang)) {
                    $this->quaTang->xoaQuaTang($thongTinQuaTang->maquatang); //xoa qua tang tren database
                }
                return back()->with(
                    'tieudethongbao',
                    'Thao tác thành công'
                )->with(
                    'thongbao',
                    'Xóa laptop thành công'
                )->with(
                    'loaithongbao',
                    'success'
                );
            }
            return back()->with(
                'tieudethongbao',
                'Thao tác thất bại'
            )->with(
                'thongbao',
                'Xóa laptop thất bại'
            )->with(
                'loaithongbao',
                'danger'
            );
        }
        if ($request->thaoTac == "sửa laptop") { // *******************************************************************************************sua laptop
            $rules = [
                'maSanPhamSua' => 'required|integer|exists:sanpham,masanpham',
                'tenSanPhamSua' => 'required|string|max:150|min:3',
                'baoHanhSua' => 'required|integer|between:1,48',
                'cpuSua' => 'required|string|max:50|min:3',
                'hangSanXuatSua' => 'required|integer|exists:hangsanxuat,mahang',
                'ramSua' => 'required|integer|between:4,32',
                'cardDoHoaSua' => 'required|integer|between:0,2',
                'oCungSua' => 'required|integer|between:128,512',
                'manHinhSua' => 'required|numeric|between:10,30',
                'nhuCauSua' => 'required|string|max:50|min:3',
                'tinhTrangSua' => 'required|boolean',
                'quaTangSua' => 'required|array|size:5',
                'hinhSanPhamSua' => 'array|between:1,5',
                'hinhSanPhamSua.*' => 'image|dimensions:min_width=500,min_height=450,max_width=500,max_height=450',
                'moTaSua' => 'max:255'
            ];
            $messages = [
                'required' => ':attribute bắt buộc nhập',
                'string' => ':attribute nhập sai',
                'min' => ':attribute tối thiểu :min ký tự',
                'max' => ':attribute tối thiểu :max ký tự',
                'between' => ':attribute vượt quá số lượng cho phép',
                'size' => ':attribute không đúng số lượng (:size)',
                'exists' => ':attribute không tồn tại',
                'numeric' => ':attribute phải là ký tự số',
                'integer' => ':attribute nhập sai',
                'boolean' => ':attribute nhập sai',
                'array' => ':attribute nhập sai',
                'hinhSanPhamSua.array' => 'Hình sản phẩm chọn sai',
                'hinhSanPhamSua.between' => 'Hình sản phẩm vượt quá số lượng cho phép',
                'hinhSanPhamSua.*.image' => 'Hình sản phẩm không đúng định dạng',
                'hinhSanPhamSua.*.dimensions' => 'Hình sản phẩm không đúng kích thước :min_width x :min_height'
            ];
            $attributes = [
                'tenSanPhamSua' => 'Tên sản phẩm',
                'baoHanhSua' => 'Bảo hành',
                'cpuSua' => 'Cpu',
                'hangSanXuatSua' => 'Hãng sản xuất',
                'ramSua' => 'Ram',
                'cardDoHoaSua' => 'Card đồ họa',
                'oCungSua' => 'Ổ cứng',
                'manHinhSua' => 'Màn hình',
                'nhuCauSua' => 'Nhu cầu',
                'tinhTrangSua' => 'Tình trạng',
                'quaTangSua' => 'Qua tặng',
                'moTaSua' => 'Mô tả'
            ];
            $request->validate($rules, $messages, $attributes);
            $thongTinSanPham = $this->sanPham->timSanPhamTheoMa($request->maSanPhamSua); //tim san pham

            // ***********Xu ly sua san pham
            if ($thongTinSanPham->tensanpham != $request->tenSanPhamSua) { //so sanh ten san pham
                $sanPhamTrungTenSapDoi = $this->sanPham->timSanPhamTheoTen($request->tenSanPhamSua);
                if (empty($sanPhamTrungTenSapDoi)) { //ten sap doi khong bi trung
                    $thongTinSanPham->tensanpham = $request->tenSanPhamSua;
                } else {
                    return back()->with(
                        'tieudethongbao',
                        'Thao tác thất bại'
                    )->with(
                        'thongbao',
                        'Sửa thông tin laptop thất bại, tên sản phẩm đã tồn tại'
                    )->with(
                        'loaithongbao',
                        'danger'
                    );
                }
            }
            if ($thongTinSanPham->baohanh != $request->baoHanhSua) { //so sanh bao hanh
                $thongTinSanPham->baohanh = $request->baoHanhSua;
            }
            if ($thongTinSanPham->mota != $request->moTaSua) { //so sanh mo ta
                $thongTinSanPham->mota = $request->moTaSua;
            }
            if ($thongTinSanPham->mahang != $request->hangSanXuatSua) { //so sanh hang san xuat
                $thongTinSanPham->mahang = $request->hangSanXuatSua;
            }
            $dataSanPham = [
                $thongTinSanPham->tensanpham,
                $thongTinSanPham->baohanh,
                $thongTinSanPham->mota,
                $thongTinSanPham->mahang
            ];
            $this->sanPham->suaSanPham($dataSanPham, $thongTinSanPham->masanpham); // sua thong tin san pham tren database
            // ***********Xu ly sua laptop
            if ($thongTinSanPham->loaisanpham == 0 && !empty($thongTinSanPham->malaptop)) { // la laptop
                $dataLaptop = [
                    $thongTinSanPham->tensanpham,
                    $request->cpuSua,
                    (int)$request->ramSua,
                    (int)$request->cardDoHoaSua,
                    (int)$request->oCungSua,
                    (float)$request->manHinhSua,
                    $request->nhuCauSua,
                    (int)$request->tinhTrangSua
                ];
                $this->laptop->suaLaptop($dataLaptop, $thongTinSanPham->malaptop); // sua thong tin laptop tren database
            }
            // ***********Xu ly them thu vien hinh (neu co)
            if (isset($request->hinhSanPhamSua)) {
                // ***********up hinh moi vao len host
                $tenHinh = [NULL, NULL, NULL, NULL, NULL];
                $dem = 0;
                if ($request->has('hinhSanPhamSua')) {
                    foreach ($request->hinhSanPhamSua as $hinh) {
                        $tenHinh[$dem] = $request->tenSanPhamSua . '-' . time() . '-' . $dem . '.' . $hinh->guessExtension();
                        $hinh->move(public_path('img/sanpham'), $tenHinh[$dem]);
                        $dem++;
                    }
                }
                // ***********xoa hinh cu tren host
                $thongTinHinh = $this->thuVienHinh->timThuVienHinhTheoMa($thongTinSanPham->mathuvienhinh); //tim thu vien hinh
                if (!empty($thongTinHinh)) {
                    foreach ($thongTinHinh as $giaTri) {
                        if (!empty($giaTri)) {
                            $duongDanHinhCanXoa = 'img/sanpham/' . $giaTri;
                            if (File::exists($duongDanHinhCanXoa)) {
                                File::delete($duongDanHinhCanXoa); //xoa thu vien hinh tren host sever
                            }
                        }
                    }
                }
                // ***********sua thong tin thu vien hinh tren database
                $dataHinh = [
                    $thongTinSanPham->tensanpham,
                    $tenHinh[0], //hinh 1
                    $tenHinh[1], //hinh 2
                    $tenHinh[2], //hinh 3
                    $tenHinh[3], //hinh 4
                    $tenHinh[4], //hinh 5
                ];
                $this->thuVienHinh->suaThuVienHinh($dataHinh, $thongTinSanPham->mathuvienhinh); //sua thong tin thu vien hinh tren database
            }
            // ***********Xu ly sua qua tang
            $dataQuaTang = [
                $thongTinSanPham->tensanpham, //ten san pham [0]
                NULL, //ma san pham 1 [1]
                NULL, //ma san pham 2 [2]
                NULL, //ma san pham 3 [3]
                NULL, //ma san pham 4 [4]
                NULL, //ma san pham 5 [5]
            ];
            $dem = 1;
            $quaTangSua = $request->quaTangSua;
            for ($i = 0; $i < count($quaTangSua); $i++) {
                if ($quaTangSua[$i] != NULL) {
                    for ($j = $i + 1; $j < count($quaTangSua); $j++) {
                        if ($quaTangSua[$i] == $quaTangSua[$j]) {
                            $quaTangSua[$j] = NULL;
                        }
                    }
                }
            }
            foreach ($quaTangSua as $maSanPhamQuaTang) {
                if (!empty($maSanPhamQuaTang)) {
                    $thongTinSanPhamTang = $this->sanPham->timSanPhamTheoMa($maSanPhamQuaTang);
                    if (!empty($thongTinSanPhamTang)) {
                        $dataQuaTang[$dem] = $thongTinSanPhamTang->masanpham;
                        $dem++;
                    }
                }
            }
            $this->quaTang->suaQuaTang($dataQuaTang, $thongTinSanPham->maquatang); // sua thong tin qua tang tren database
            return back()->with(
                'tieudethongbao',
                'Thao tác thành công'
            )->with(
                'thongbao',
                'Sửa thông tin laptop thành công'
            )->with(
                'loaithongbao',
                'success'
            );
        }
        if ($request->thaoTac == "thêm laptop") { // *******************************************************************************************them laptop
            $rules = [
                'tenSanPham' => 'required|string|max:150|min:3|unique:sanpham',
                'baoHanh' => 'required|integer|between:1,48',
                'cpu' => 'required|string|max:50|min:3',
                'hangSanXuat' => 'required|integer|exists:hangsanxuat,mahang',
                'ram' => 'required|integer|between:4,32',
                'cardDoHoa' => 'required|integer|between:0,2',
                'oCung' => 'required|integer|between:128,512',
                'manHinh' => 'required|numeric|between:10,30',
                'nhuCau' => 'required|string|max:50|min:3',
                'tinhTrang' => 'required|boolean',
                'quaTang' => 'required|array|size:5',
                'hinhSanPham' => 'required|array|between:1,5',
                'hinhSanPham.*' => 'image|dimensions:min_width=500,min_height=450,max_width=500,max_height=450',
                'moTa' => 'max:255'
            ];
            $messages = [
                'required' => ':attribute bắt buộc nhập',
                'string' => ':attribute nhập sai',
                'min' => ':attribute tối thiểu :min ký tự',
                'max' => ':attribute tối đa :max ký tự',
                'between' => ':attribute vượt quá số lượng cho phép',
                'size' => ':attribute không đúng số lượng (:size)',
                'unique' => ':attribute đã tồn tại',
                'exists' => ':attribute không tồn tại',
                'numeric' => ':attribute phải là ký tự số',
                'integer' => ':attribute nhập sai',
                'boolean' => ':attribute nhập sai',
                'array' => ':attribute nhập sai',
                'hinhSanPham.required' => 'Hình sản phẩm chọn sai',
                'hinhSanPham.array' => 'Hình sản phẩm chọn sai',
                'hinhSanPham.between' => 'Hình sản phẩm vượt quá số lượng cho phép',
                'hinhSanPham.*.image' => 'Hình sản phẩm không đúng định dạng',
                'hinhSanPham.*.dimensions' => 'Hình sản phẩm không đúng kích thước :min_width x :min_height'
            ];
            $attributes = [
                'tenSanPham' => 'Tên sản phẩm',
                'baoHanh' => 'Bảo hành',
                'cpu' => 'Cpu',
                'hangSanXuat' => 'Hãng sản xuất',
                'ram' => 'Ram',
                'cardDoHoa' => 'Card đồ họa',
                'oCung' => 'Ổ cứng',
                'manHinh' => 'Màn hình',
                'nhuCau' => 'Nhu cầu',
                'tinhTrang' => 'Tình trạng',
                'quaTang' => 'Qùa tặng',
                'moTa' => 'Mô tả'
            ];
            $request->validate($rules, $messages, $attributes);
            // ***********Xu ly them qua tang
            $dataQuaTang = [
                NULL, //ma qua tang [0]
                $request->tenSanPham, //ten san pham [1]
                NULL, //ma san pham 1 [2]
                NULL, //ma san pham 2 [4]
                NULL, //ma san pham 3 [5]
                NULL, //ma san pham 4 [6]
                NULL, //ma san pham 5 [7]
            ];
            $dem = 2;
            $quaTang = $request->quaTang;
            for ($i = 0; $i < count($quaTang); $i++) { // loc ma san pham tang bi trung
                if ($quaTang[$i] != NULL) {
                    for ($j = $i + 1; $j < count($quaTang); $j++) {
                        if ($quaTang[$i] == $quaTang[$j]) {
                            $quaTang[$j] = NULL;
                        }
                    }
                }
            }
            foreach ($quaTang as $maSanPhamQuaTang) {
                if (!empty($maSanPhamQuaTang)) {
                    $thongTinSanPhamTang = $this->sanPham->timSanPhamTheoMa($maSanPhamQuaTang);
                    if (!empty($thongTinSanPhamTang)) {
                        $dataQuaTang[$dem] = $thongTinSanPhamTang->masanpham;
                        $dem++;
                    }
                }
            }

            // ***********Xu ly them thu vien hinh
            $tenHinh = [NULL, NULL, NULL, NULL, NULL];
            $dem = 0;
            if ($request->has('hinhSanPham')) {
                foreach ($request->hinhSanPham as $hinh) {
                    $tenHinh[$dem] = $request->tenSanPham . '-' . time() . '-' . $dem . '.' . $hinh->guessExtension();
                    $hinh->move(public_path('img/sanpham'), $tenHinh[$dem]);
                    $dem++;
                }
            }
            $dataHinh = [
                NULL, //ma hinh
                $request->tenSanPham,
                $tenHinh[0], //hinh 1
                $tenHinh[1], //hinh 2
                $tenHinh[2], //hinh 3
                $tenHinh[3], //hinh 4
                $tenHinh[4], //hinh 5
            ];
            // ***********Xu ly them laptop
            $dataLaptop = [
                NULL, //ma laptop
                $request->tenSanPham,
                $request->cpu,
                $request->ram,
                $request->cardDoHoa,
                $request->oCung,
                $request->manHinh,
                $request->nhuCau,
                $request->tinhTrang
            ];

            $this->quaTang->themQuaTang($dataQuaTang); //them vao database
            $thongTinQuaTang = $this->quaTang->timQuaTangTheoTenSanPham($request->tenSanPham); //tim qua tang vua them

            $this->thuVienHinh->themThuVienHinh($dataHinh); //them vao database
            $thongTinHinh = $this->thuVienHinh->timThuVienHinhTheoTenSanPham($request->tenSanPham); //tim thu vien hinh vua them

            $this->laptop->themLaptop($dataLaptop); //them vao database
            $thongTinLaptop = $this->laptop->timLaptopTheoTenSanPham($request->tenSanPham); //tim laptop vua them

            // ***********Xu ly them sanpham
            $dataSanPham = [
                NULL, //ma san pham
                $request->tenSanPham,
                $request->baoHanh,
                $request->moTa,
                0, //so luong
                0, //gia nhap
                0, //gia ban
                NULL, //gia khuyen mai
                $thongTinHinh->mathuvienhinh, //ma thu vien hinh
                $request->hangSanXuat, //ma hang
                $thongTinQuaTang->maquatang, //ma qua tang
                $thongTinLaptop->malaptop, //ma lap top
                NULL, //ma phu kien
                0 //loai san pham
                //ngaytao tu dong
            ];
            $this->sanPham->themSanPham($dataSanPham);
            return back()->with(
                'tieudethongbao',
                'Thao tác thành công'
            )->with(
                'thongbao',
                'Thêm laptop mới thành công'
            )->with(
                'loaithongbao',
                'success'
            );
        }
        return back()->with(
            'tieudethongbao',
            'Thao tác thất bại'
        )->with(
            'thongbao',
            'Vui lòng thử lại!'
        )->with(
            'loaithongbao',
            'danger'
        );
    }
    public function phukien()
    {
        if (!Auth::check() || Auth::user()->loainguoidung != 2) {
            return redirect()->route('dangnhap');
        }
        $danhSachSanPham = $this->sanPham->layDanhSachSanPham();
        $danhSachPhuKien = $this->phuKien->layDanhSachPhuKien();
        $danhSachThuVienHinh = $this->thuVienHinh->layDanhSachThuVienHinh();
        $danhSachHangSanXuat = $this->hangSanXuat->layDanhSachHangSanXuat();
        $danhSachQuaTang = $this->quaTang->layDanhSachQuaTang();
        $danhSachHangSanXuatPhuKien = []; // loc lai danh sach theo loai hang san xuat phu kien can xem
        foreach ($danhSachHangSanXuat as $hangSanXuat) {
            if ($hangSanXuat->loaihang == 1) {
                $danhSachHangSanXuatPhuKien = array_merge($danhSachHangSanXuatPhuKien, [$hangSanXuat]);
            }
        }
        $danhSachPhieuXuatChoXacNhan = $this->phieuXuat->layDanhSachPhieuXuatTheoBoLoc([['phieuxuat.tinhtranggiaohang', '=', 1]]);
        $danhSachLoiPhanHoiChuaDoc = $this->loiPhanHoi->layDanhSachLoiPhanHoiTheoBoLoc([['loiphanhoi.trangthai', '=', 0]]);
        return view('admin.phukien', compact(
            'danhSachSanPham',
            'danhSachPhuKien',
            'danhSachThuVienHinh',
            'danhSachHangSanXuatPhuKien',
            'danhSachPhieuXuatChoXacNhan',
            'danhSachLoiPhanHoiChuaDoc',
            'danhSachQuaTang'
        ));
    }
    public function xulyphukien(Request $request)
    {
        $request->validate(['thaoTac' => 'required|string']);
        if ($request->thaoTac == "xóa phụ kiện") { // *******************************************************************************************xoa phu kien
            $rules = [
                'maSanPhamXoa' => 'required|integer|exists:sanpham,masanpham'
            ];
            $messages = [
                'required' => ':attribute bắt buộc nhập',
                'exists' => ':attribute không tồn tại',
                'integer' => ':attribute nhập sai'
            ];
            $attributes = [
                'maSanPhamXoa' => 'Mã sản phẩm'
            ];
            $request->validate($rules, $messages, $attributes);
            $thongTinSanPham = $this->sanPham->timSanPhamTheoMa($request->maSanPhamXoa); //tim san pham
            $thongTinChiTietPhieuNhap = $this->chiTietPhieuNhap->timDanhSachChiTietPhieuNhapTheoMaSanPham($thongTinSanPham->masanpham);
            if (!empty($thongTinChiTietPhieuNhap)) {
                return back()->with(
                    'tieudethongbao',
                    'Thao tác thất bại'
                )->with(
                    'thongbao',
                    'Phụ kiện đã tồn tại trong phiếu nhập [PN' . $thongTinChiTietPhieuNhap[0]->maphieunhap . '] nên không thể xóa'
                )->with(
                    'loaithongbao',
                    'danger'
                );
            }
            $thongTinChiTietPhieuXuat = $this->chiTietPhieuXuat->timDanhSachChiTietPhieuXuatTheoMaSanPham($thongTinSanPham->masanpham);
            if (!empty($thongTinChiTietPhieuXuat)) {
                return back()->with(
                    'tieudethongbao',
                    'Thao tác thất bại'
                )->with(
                    'thongbao',
                    'Phụ kiện đã tồn tại trong phiếu xuất [PX' . $thongTinChiTietPhieuXuat[0]->maphieuxuat . '] nên không thể xóa'
                )->with(
                    'loaithongbao',
                    'danger'
                );
            }
            if (!empty($thongTinSanPham)) {
                $this->sanPham->xoaSanPham($thongTinSanPham->masanpham); //xoa san pham tren database
                if ($thongTinSanPham->loaisanpham == 1 && !empty($thongTinSanPham->maphukien)) {
                    $thongTinPhuKien = $this->phuKien->timPhuKienTheoMa($thongTinSanPham->maphukien); //tim phu kien
                    if (!empty($thongTinPhuKien)) {
                        $this->phuKien->xoaPhuKien($thongTinPhuKien->maphukien); //xoa phu kien tren database
                    }
                }
                $thongTinHinh = $this->thuVienHinh->timThuVienHinhTheoMa($thongTinSanPham->mathuvienhinh); //tim thu vien hinh
                if (!empty($thongTinHinh)) {
                    $this->thuVienHinh->xoaThuVienHinh($thongTinHinh->mathuvienhinh); //xoa thu vien hinh tren database
                    foreach ($thongTinHinh as $giaTri) {
                        if (!empty($giaTri)) {
                            $duongDanHinhCanXoa = 'img/sanpham/' . $giaTri;
                            if (File::exists($duongDanHinhCanXoa)) {
                                File::delete($duongDanHinhCanXoa); //xoa thu vien hinh tren host sever
                            }
                        }
                    }
                }
                $thongTinQuaTang = $this->quaTang->timQuaTangTheoMa($thongTinSanPham->maquatang); //tim qua tang
                if (!empty($thongTinQuaTang)) {
                    $this->quaTang->xoaQuaTang($thongTinQuaTang->maquatang); //xoa qua tang tren database
                }
                return back()->with(
                    'tieudethongbao',
                    'Thao tác thành công'
                )->with(
                    'thongbao',
                    'Xóa phụ kiện thành công'
                )->with(
                    'loaithongbao',
                    'success'
                );
            }
            return back()->with(
                'tieudethongbao',
                'Thao tác thất bại'
            )->with(
                'thongbao',
                'Xóa phụ kiện thất bại'
            )->with(
                'loaithongbao',
                'danger'
            );
        }
        if ($request->thaoTac == "sửa phụ kiện") { // *******************************************************************************************sua phu kien
            $rules = [
                'maSanPhamSua' => 'required|integer|exists:sanpham,masanpham',
                'tenSanPhamSua' => 'required|string|max:150|min:3',
                'baoHanhSua' => 'required|integer|between:1,48',
                'hangSanXuatSua' => 'required|integer|exists:hangsanxuat,mahang',
                'tenLoaiPhuKienSua' => 'required|string|max:50|min:3',
                'quaTangSua' => 'required|array|size:5',
                'hinhSanPhamSua' => 'array|between:1,5',
                'hinhSanPhamSua.*' => 'image|dimensions:min_width=500,min_height=450,max_width=500,max_height=450',
                'moTaSua' => 'max:255'
            ];
            $messages = [
                'required' => ':attribute bắt buộc nhập',
                'string' => ':attribute nhập sai',
                'min' => ':attribute tối thiểu :min ký tự',
                'max' => ':attribute tối đa :max ký tự',
                'between' => ':attribute vượt quá số lượng cho phép',
                'size' => ':attribute không đúng số lượng (:size)',
                'exists' => ':attribute không tồn tại',
                'integer' => ':attribute nhập sai',
                'boolean' => ':attribute nhập sai',
                'array' => ':attribute nhập sai',
                'hinhSanPhamSua.array' => 'Hình sản phẩm chọn sai',
                'hinhSanPhamSua.between' => 'Hình sản phẩm vượt quá số lượng cho phép',
                'hinhSanPhamSua.*.image' => 'Hình sản phẩm không đúng định dạng',
                'hinhSanPhamSua.*.dimensions' => 'Hình sản phẩm không đúng kích thước :min_width x :min_height'
            ];
            $attributes = [
                'tenSanPhamSua' => 'Tên sản phẩm',
                'baoHanhSua' => 'Bảo hành',
                'hangSanXuatSua' => 'Hãng sản xuất',
                'tenLoaiPhuKienSua' => 'Tên loại phụ kiện',
                'quaTangSua' => 'Qua tặng',
                'moTaSua' => 'Mô tả'
            ];
            $request->validate($rules, $messages, $attributes);
            $thongTinSanPham = $this->sanPham->timSanPhamTheoMa($request->maSanPhamSua); //tim san pham
            // ***********Xu ly sua san pham
            if ($thongTinSanPham->tensanpham != $request->tenSanPhamSua) { //so sanh ten san pham
                $sanPhamTrungTenSapDoi = $this->sanPham->timSanPhamTheoTen($request->tenSanPhamSua);
                if (empty($sanPhamTrungTenSapDoi)) { //ten sap doi khong bi trung
                    $thongTinSanPham->tensanpham = $request->tenSanPhamSua;
                } else {
                    return back()->with(
                        'tieudethongbao',
                        'Thao tác thất bại'
                    )->with(
                        'thongbao',
                        'Sửa thông tin phụ kiện thất bại, tên sản phẩm đã tồn tại'
                    )->with(
                        'loaithongbao',
                        'danger'
                    );
                }
            }
            if ($thongTinSanPham->baohanh != $request->baoHanhSua) { //so sanh bao hanh
                $thongTinSanPham->baohanh = $request->baoHanhSua;
            }
            if ($thongTinSanPham->mota != $request->moTaSua) { //so sanh mo ta
                $thongTinSanPham->mota = $request->moTaSua;
            }
            if ($thongTinSanPham->mahang != $request->hangSanXuatSua) { //so sanh hang san xuat
                $thongTinSanPham->mahang = $request->hangSanXuatSua;
            }
            $dataSanPham = [
                $thongTinSanPham->tensanpham,
                $thongTinSanPham->baohanh,
                $thongTinSanPham->mota,
                $thongTinSanPham->mahang
            ];
            $this->sanPham->suaSanPham($dataSanPham, $thongTinSanPham->masanpham); // sua thong tin san pham tren database
            // ***********Xu ly sua phu kien
            if ($thongTinSanPham->loaisanpham == 1 && !empty($thongTinSanPham->maphukien)) { // la phu kien
                $dataPhuKien = [
                    $thongTinSanPham->tensanpham,
                    $request->tenLoaiPhuKienSua
                ];
                $this->phuKien->suaPhuKien($dataPhuKien, $thongTinSanPham->maphukien); // sua thong tin phu kien tren database
            }
            // ***********Xu ly them thu vien hinh (neu co)
            if (isset($request->hinhSanPhamSua)) {
                // ***********up hinh moi vao len host
                $tenHinh = [NULL, NULL, NULL, NULL, NULL];
                $dem = 0;
                if ($request->has('hinhSanPhamSua')) {
                    foreach ($request->hinhSanPhamSua as $hinh) {
                        $tenHinh[$dem] = $request->tenSanPhamSua . '-' . time() . '-' . $dem . '.' . $hinh->guessExtension();
                        $hinh->move(public_path('img/sanpham'), $tenHinh[$dem]);
                        $dem++;
                    }
                }
                // ***********xoa hinh cu tren host
                $thongTinHinh = $this->thuVienHinh->timThuVienHinhTheoMa($thongTinSanPham->mathuvienhinh); //tim thu vien hinh
                if (!empty($thongTinHinh)) {
                    foreach ($thongTinHinh as $giaTri) {
                        if (!empty($giaTri)) {
                            $duongDanHinhCanXoa = 'img/sanpham/' . $giaTri;
                            if (File::exists($duongDanHinhCanXoa)) {
                                File::delete($duongDanHinhCanXoa); //xoa thu vien hinh tren host sever
                            }
                        }
                    }
                }
                // ***********sua thong tin thu vien hinh tren database
                $dataHinh = [
                    $thongTinSanPham->tensanpham,
                    $tenHinh[0], //hinh 1
                    $tenHinh[1], //hinh 2
                    $tenHinh[2], //hinh 3
                    $tenHinh[3], //hinh 4
                    $tenHinh[4], //hinh 5
                ];
                $this->thuVienHinh->suaThuVienHinh($dataHinh, $thongTinSanPham->mathuvienhinh); //sua thong tin thu vien hinh tren database
            }
            // ***********Xu ly sua qua tang
            $dataQuaTang = [
                $thongTinSanPham->tensanpham, //ten san pham [0]
                NULL, //ma san pham 1 [1]
                NULL, //ma san pham 2 [2]
                NULL, //ma san pham 3 [3]
                NULL, //ma san pham 4 [4]
                NULL, //ma san pham 5 [5]
            ];
            $dem = 1;
            $quaTangSua = $request->quaTangSua;
            for ($i = 0; $i < count($quaTangSua); $i++) {
                if ($quaTangSua[$i] != NULL) {
                    for ($j = $i + 1; $j < count($quaTangSua); $j++) {
                        if ($quaTangSua[$i] == $quaTangSua[$j]) {
                            $quaTangSua[$j] = NULL;
                        }
                    }
                }
            }
            foreach ($quaTangSua as $maSanPhamQuaTang) {
                if (!empty($maSanPhamQuaTang)) {
                    $thongTinSanPhamTang = $this->sanPham->timSanPhamTheoMa($maSanPhamQuaTang);
                    if (!empty($thongTinSanPhamTang)) {
                        $dataQuaTang[$dem] = $thongTinSanPhamTang->masanpham;
                        $dem++;
                    }
                }
            }
            $this->quaTang->suaQuaTang($dataQuaTang, $thongTinSanPham->maquatang); // sua thong tin qua tang tren database
            return back()->with(
                'tieudethongbao',
                'Thao tác thành công'
            )->with(
                'thongbao',
                'Sửa thông tin phụ kiện thành công'
            )->with(
                'loaithongbao',
                'success'
            );
        }
        if ($request->thaoTac == "thêm phụ kiện") { // *******************************************************************************************them phu kien
            $rules = [
                'tenSanPham' => 'required|string|max:150|min:3|unique:sanpham',
                'baoHanh' => 'required|integer|between:1,48',
                'hangSanXuat' => 'required|integer|exists:hangsanxuat,mahang',
                'tenLoaiPhuKien' => 'required|string|max:50|min:3',
                'quaTang' => 'required|array|size:5',
                'hinhSanPham' => 'required|array|between:1,5',
                'hinhSanPham.*' => 'image|dimensions:min_width=500,min_height=450,max_width=500,max_height=450',
                'moTa' => 'max:255'
            ];
            $messages = [
                'required' => ':attribute bắt buộc nhập',
                'string' => ':attribute nhập sai',
                'min' => ':attribute tối thiểu :min ký tự',
                'max' => ':attribute tối thiểu :max ký tự',
                'between' => ':attribute vượt quá số lượng cho phép',
                'size' => ':attribute không đúng số lượng (:size)',
                'unique' => ':attribute đã tồn tại',
                'exists' => ':attribute không tồn tại',
                'integer' => ':attribute nhập sai',
                'array' => ':attribute nhập sai',
                'hinhSanPham.required' => 'Hình sản phẩm chọn sai',
                'hinhSanPham.array' => 'Hình sản phẩm chọn sai',
                'hinhSanPham.between' => 'Hình sản phẩm vượt quá số lượng cho phép',
                'hinhSanPham.*.image' => 'Hình sản phẩm không đúng định dạng',
                'hinhSanPham.*.dimensions' => 'Hình sản phẩm không đúng kích thước :min_width x :min_height'
            ];
            $attributes = [
                'tenSanPham' => 'Tên sản phẩm',
                'baoHanh' => 'Bảo hành',
                'hangSanXuat' => 'Hãng sản xuất',
                'tenLoaiPhuKien' => 'Tên loại phụ kiện',
                'quaTang' => 'Qùa tặng',
                'moTa' => 'Mô tả'
            ];
            $request->validate($rules, $messages, $attributes);
            // ***********Xu ly them qua tang
            $dataQuaTang = [
                NULL, //ma qua tang [0]
                $request->tenSanPham, //ten san pham [1]
                NULL, //ma san pham 1 [2]
                NULL, //ma san pham 2 [4]
                NULL, //ma san pham 3 [5]
                NULL, //ma san pham 4 [6]
                NULL, //ma san pham 5 [7]
            ];
            $dem = 2;
            $quaTang = $request->quaTang;
            for ($i = 0; $i < count($quaTang); $i++) { // loc ma san pham tang bi trung
                if ($quaTang[$i] != NULL) {
                    for ($j = $i + 1; $j < count($quaTang); $j++) {
                        if ($quaTang[$i] == $quaTang[$j]) {
                            $quaTang[$j] = NULL;
                        }
                    }
                }
            }
            foreach ($quaTang as $maSanPhamQuaTang) {
                if (!empty($maSanPhamQuaTang)) {
                    $thongTinSanPhamTang = $this->sanPham->timSanPhamTheoMa($maSanPhamQuaTang);
                    if (!empty($thongTinSanPhamTang)) {
                        $dataQuaTang[$dem] = $thongTinSanPhamTang->masanpham;
                        $dem++;
                    }
                }
            }

            // ***********Xu ly them thu vien hinh
            $tenHinh = [NULL, NULL, NULL, NULL, NULL];
            $dem = 0;
            if ($request->has('hinhSanPham')) {
                foreach ($request->hinhSanPham as $hinh) {
                    $tenHinh[$dem] = $request->tenSanPham . '-' . time() . '-' . $dem . '.' . $hinh->guessExtension();
                    $hinh->move(public_path('img/sanpham'), $tenHinh[$dem]);
                    $dem++;
                }
            }
            $dataHinh = [
                NULL, //ma hinh
                $request->tenSanPham,
                $tenHinh[0], //hinh 1
                $tenHinh[1], //hinh 2
                $tenHinh[2], //hinh 3
                $tenHinh[3], //hinh 4
                $tenHinh[4], //hinh 5
            ];
            // ***********Xu ly them phu kien
            $dataPhuKien = [
                NULL, //ma phu kien
                $request->tenSanPham,
                $request->tenLoaiPhuKien
            ];

            $this->quaTang->themQuaTang($dataQuaTang); //them vao database
            $thongTinQuaTang = $this->quaTang->timQuaTangTheoTenSanPham($request->tenSanPham); //tim qua tang vua them

            $this->thuVienHinh->themThuVienHinh($dataHinh); //them vao database
            $thongTinHinh = $this->thuVienHinh->timThuVienHinhTheoTenSanPham($request->tenSanPham); //tim thu vien hinh vua them

            $this->phuKien->themPhuKien($dataPhuKien); //them vao database
            $thongTinPhuKien = $this->phuKien->timPhuKienTheoTenSanPham($request->tenSanPham); //tim phu kien vua them

            // ***********Xu ly them sanpham
            $dataSanPham = [
                NULL, //ma san pham
                $request->tenSanPham,
                $request->baoHanh,
                $request->moTa,
                0, //so luong
                0, //gia nhap
                0, //gia ban
                NULL, //gia khuyen mai
                $thongTinHinh->mathuvienhinh, //ma thu vien hinh
                $request->hangSanXuat, //ma hang
                $thongTinQuaTang->maquatang, //ma qua tang
                NULL, //ma lap top
                $thongTinPhuKien->maphukien, //ma phu kien
                1 //loai san pham
                //ngaytao tu dong
            ];
            $this->sanPham->themSanPham($dataSanPham);
            return back()->with(
                'tieudethongbao',
                'Thao tác thành công'
            )->with(
                'thongbao',
                'Thêm phụ kiện mới thành công'
            )->with(
                'loaithongbao',
                'success'
            );
        }
        return back()->with(
            'tieudethongbao',
            'Thao tác thất bại'
        )->with(
            'thongbao',
            'Vui lòng thử lại!'
        )->with(
            'loaithongbao',
            'danger'
        );
    }
    public function hangsanxuat()
    {
        if (!Auth::check() || Auth::user()->loainguoidung != 2) {
            return redirect()->route('dangnhap');
        }
        $danhSachSanPham = $this->sanPham->layDanhSachSanPham();
        $danhSachHangSanXuat = $this->hangSanXuat->layDanhSachHangSanXuat();
        $danhSachPhieuXuatChoXacNhan = $this->phieuXuat->layDanhSachPhieuXuatTheoBoLoc([['phieuxuat.tinhtranggiaohang', '=', 1]]);
        $danhSachLoiPhanHoiChuaDoc = $this->loiPhanHoi->layDanhSachLoiPhanHoiTheoBoLoc([['loiphanhoi.trangthai', '=', 0]]);
        return view('admin.hangsanxuat', compact(
            'danhSachSanPham',
            'danhSachPhieuXuatChoXacNhan',
            'danhSachLoiPhanHoiChuaDoc',
            'danhSachHangSanXuat'
        ));
    }
    public function xulyhangsanxuat(Request $request)
    {
        $request->validate(['thaoTac' => 'required|string']);
        if ($request->thaoTac == "thêm hãng sản xuất") { // *******************************************************************************************them hang san xuat
            $rules = [
                'tenHang' => 'required|string|max:50|min:1',
                'loaiHang' => 'required|integer|between:0,1'
            ];
            $messages = [
                'required' => ':attribute bắt buộc nhập',
                'string' => ':attribute nhập sai',
                'min' => ':attribute tối thiểu :min ký tự',
                'max' => ':attribute tối đa :max ký tự',
                'between' => ':attribute vượt quá số lượng cho phép',
                'integer' => ':attribute nhập sai',
                'array' => ':attribute nhập sai'
            ];
            $attributes = [
                'tenHang' => 'Tên hãng',
                'loaiHang' => 'Loại hãng'
            ];
            $request->validate($rules, $messages, $attributes);
            $tenHang = mb_strtoupper($request->tenHang, 'UTF-8');
            $thongTinHang = $this->hangSanXuat->timHangSanXuatTheoTen($tenHang);
            if (!empty($thongTinHang)) {
                if ($thongTinHang->loaihang == $request->loaiHang) {
                    return back()->with(
                        'tieudethongbao',
                        'Thao tác thất bại'
                    )->with(
                        'thongbao',
                        'Tên hãng sản xuất đã tồn tại, vui lòng nhập lại!'
                    )->with(
                        'loaithongbao',
                        'danger'
                    );
                }
            }
            $dataHangSanXuat = [
                NULL, //mahang tu dong
                $tenHang,
                $request->loaiHang
            ];
            $this->hangSanXuat->themHangSanXuat($dataHangSanXuat); //them hang san xuat vao database
            return back()->with(
                'tieudethongbao',
                'Thao tác thành công'
            )->with(
                'thongbao',
                'Thêm hãng sản xuất thành công'
            )->with(
                'loaithongbao',
                'success'
            );
        }
        if ($request->thaoTac == "xóa hãng sản xuất") { // *******************************************************************************************xoa hang san xuat
            $rules = [
                'maHangXoa' => 'required|integer|exists:hangsanxuat,mahang|unique:sanpham,mahang'
            ];
            $messages = [
                'required' => ':attribute bắt buộc nhập',
                'exists' => ':attribute không tồn tại',
                'unique' => 'Tồn tại sản phẩm thuộc :attribute này nên không thể xóa',
                'integer' => ':attribute đã nhập sai'
            ];
            $attributes = [
                'maHangXoa' => 'Hãng sản xuất'
            ];
            $request->validate($rules, $messages, $attributes);
            $this->hangSanXuat->xoaHangSanXuat($request->maHangXoa); //xoa hang san xuat tren database
            return back()->with(
                'tieudethongbao',
                'Thao tác thành công'
            )->with(
                'thongbao',
                'Thêm hãng sản xuất thành công'
            )->with(
                'loaithongbao',
                'success'
            );
        }
        return back()->with(
            'tieudethongbao',
            'Thao tác thất bại'
        )->with(
            'thongbao',
            'Vui lòng thử lại!'
        )->with(
            'loaithongbao',
            'danger'
        );
    }
    public function xemphieuxuat(Request $request)
    {
        if (!Auth::check() || Auth::user()->loainguoidung != 2) {
            return redirect()->route('dangnhap');
        }
        $rules = [
            'mapx' => 'required|integer|exists:phieuxuat,maphieuxuat'
        ];
        $messages = [
            'required' => ':attribute bắt buộc nhập',
            'exists' => ':attribute không tồn tại',
            'integer' => ':attribute nhập sai'
        ];
        $attributes = [
            'mapx' => 'Mã phiếu xuất'
        ];
        $request->validate($rules, $messages, $attributes);
        $phieuXuatCanXem = $this->phieuXuat->timPhieuXuatTheoMa($request->mapx);
        $nguoiDungCanXem = $this->nguoiDung->timNguoiDungTheoMa($phieuXuatCanXem->manguoidung);
        $maGiamGiaCanXem = $this->maGiamGia->timMaGiamGiaTheoMa($phieuXuatCanXem->magiamgia);
        $danhSachChiTietPhieuXuatCanXem = $this->chiTietPhieuXuat->timDanhSachChiTietPhieuXuatTheoMaPhieuXuat($phieuXuatCanXem->maphieuxuat);
        $danhSachSanPham = $this->sanPham->layDanhSachSanPham();
        return view('admin.pdf.phieuxuat', compact(
            'phieuXuatCanXem',
            'nguoiDungCanXem',
            'maGiamGiaCanXem',
            'danhSachChiTietPhieuXuatCanXem',
            'danhSachSanPham'
        ));
    }
    public function inphieuxuat(Request $request)
    {
        if (!Auth::check() || Auth::user()->loainguoidung != 2) {
            return redirect()->route('dangnhap');
        }
        $rules = [
            'mapx' => 'required|integer|exists:phieuxuat,maphieuxuat'
        ];
        $messages = [
            'required' => ':attribute bắt buộc nhập',
            'exists' => ':attribute không tồn tại',
            'integer' => ':attribute nhập sai'
        ];
        $attributes = [
            'mapx' => 'Mã phiếu xuất'
        ];
        $request->validate($rules, $messages, $attributes);
        $phieuXuatCanXem = $this->phieuXuat->timPhieuXuatTheoMa($request->mapx);
        $nguoiDungCanXem = $this->nguoiDung->timNguoiDungTheoMa($phieuXuatCanXem->manguoidung);
        $maGiamGiaCanXem = $this->maGiamGia->timMaGiamGiaTheoMa($phieuXuatCanXem->magiamgia);
        $danhSachChiTietPhieuXuatCanXem = $this->chiTietPhieuXuat->timDanhSachChiTietPhieuXuatTheoMaPhieuXuat($phieuXuatCanXem->maphieuxuat);
        $danhSachSanPham = $this->sanPham->layDanhSachSanPham();
    	$pdf = PDF::loadView('admin.pdf.phieuxuat',compact(
            'phieuXuatCanXem',
            'nguoiDungCanXem',
            'maGiamGiaCanXem',
            'danhSachChiTietPhieuXuatCanXem',
            'danhSachSanPham'
        ));
    	return $pdf->stream('PX'.$phieuXuatCanXem->maphieuxuat.'.pdf');
    }
    public function phieuxuat()
    {
        if (!Auth::check() || Auth::user()->loainguoidung != 2) {
            return redirect()->route('dangnhap');
        }
        $danhSachPhieuXuat = $this->phieuXuat->layDanhSachPhieuXuat();
        $danhSachPhieuXuatChoXacNhan = $this->phieuXuat->layDanhSachPhieuXuatTheoBoLoc([['phieuxuat.tinhtranggiaohang', '=', 1]]);
        $danhSachLoiPhanHoiChuaDoc = $this->loiPhanHoi->layDanhSachLoiPhanHoiTheoBoLoc([['loiphanhoi.trangthai', '=', 0]]);
        $danhSachNguoiDung = $this->nguoiDung->layDanhSachNguoiDung();
        $danhSachMaGiamGia = $this->maGiamGia->layDanhSachMaGiamGia();
        return view('admin.phieuxuat', compact(
            'danhSachPhieuXuat',
            'danhSachPhieuXuatChoXacNhan',
            'danhSachLoiPhanHoiChuaDoc',
            'danhSachNguoiDung',
            'danhSachMaGiamGia'
        ));
    }
    public function xulyphieuxuat(Request $request)
    {
        $request->validate(['thaoTac' => 'required|string']);
        if ($request->thaoTac == "đổi tình trạng giao hàng") { // *******************************************************************************************doi tinh trang giao hang phieu xuat
            $rules = [
                'maPhieuXuatDoi' => 'required|integer|exists:phieuxuat,maphieuxuat'
            ];
            $messages = [
                'required' => ':attribute bắt buộc nhập',
                'exists' => ':attribute không tồn tại',
                'integer' => ':attribute đã nhập sai'
            ];
            $attributes = [
                'maPhieuXuatDoi' => 'Mã phiếu xuất'
            ];
            $request->validate($rules, $messages, $attributes);
            $thongTinPhieuXuat = $this->phieuXuat->timPhieuXuatTheoMa($request->maPhieuXuatDoi); //tim phieu xuat can doi
            if (!empty($thongTinPhieuXuat)) {
                $thongTinNguoiDung = $this->nguoiDung->timNguoiDungTheoMa($thongTinPhieuXuat->manguoidung);
                if ($thongTinNguoiDung->trangthai == 0) { // thong tin nguoi dung dang bi khoa
                    return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Trạng thái người dùng đang bị khóa, không thể thao tác!')->with('loaithongbao', 'danger');
                }
                if ($thongTinPhieuXuat->tinhtranggiaohang >= 4) $thongTinPhieuXuat->tinhtranggiaohang = 0;
                else $thongTinPhieuXuat->tinhtranggiaohang++;
                $dataPhieuXuat = [
                    $thongTinPhieuXuat->tinhtranggiaohang
                ];
                $this->phieuXuat->doiTinhTrangGiaoHangPhieuXuat($dataPhieuXuat, $thongTinPhieuXuat->maphieuxuat); //doi tinh trang giao hang phieu xuat tren database
                $danhSachChiTietPhieuXuat = $this->chiTietPhieuXuat->timDanhSachChiTietPhieuXuatTheoMaPhieuXuat($thongTinPhieuXuat->maphieuxuat); //chinh ton kho
                if (!empty($danhSachChiTietPhieuXuat)) {
                    foreach ($danhSachChiTietPhieuXuat as $ctpx) {
                        $thongTinSanPham = $this->sanPham->timSanPhamTheoMa($ctpx->masanpham); //tim san pham can chinh so luong
                        if (!empty($thongTinSanPham) && $thongTinPhieuXuat->tinhtranggiaohang == 0) {
                            $dataSanPham = [
                                $thongTinSanPham->soluong + $ctpx->soluong
                            ];
                            $this->sanPham->suaSoLuong($dataSanPham, $thongTinSanPham->masanpham); //chinh so luong ton kho san pham tren database
                        }
                        if (!empty($thongTinSanPham) && $thongTinPhieuXuat->tinhtranggiaohang == 4) {
                            $dataSanPham = [
                                $thongTinSanPham->soluong - $ctpx->soluong
                            ];
                            $this->sanPham->suaSoLuong($dataSanPham, $thongTinSanPham->masanpham); //chinh so luong ton kho san pham tren database
                        }
                    }
                }
                return back()->with(
                    'tieudethongbao',
                    'Thao tác thành công'
                )->with(
                    'thongbao',
                    'Đổi tình trạng giao hàng phiếu xuất thành công'
                )->with(
                    'loaithongbao',
                    'success'
                );
            }
            return back()->with(
                'tieudethongbao',
                'Thao tác thất bại'
            )->with(
                'thongbao',
                'Đổi tình trạng giao hàng phiếu xuất thất bại'
            )->with(
                'loaithongbao',
                'danger'
            );
        }
        if ($request->thaoTac == "xóa phiếu xuất") { // *******************************************************************************************xoa phieu xuat
            $rules = [
                'maPhieuXuatXoa' => 'required|integer|exists:phieuxuat,maphieuxuat'
            ];
            $messages = [
                'required' => ':attribute bắt buộc nhập',
                'exists' => ':attribute không tồn tại',
                'integer' => ':attribute đã nhập sai'
            ];
            $attributes = [
                'maPhieuXuatXoa' => 'Mã phiếu xuất'
            ];
            $request->validate($rules, $messages, $attributes);
            $thongTinPhieuXuat = $this->phieuXuat->timPhieuXuatTheoMa($request->maPhieuXuatXoa); //tim phieu xuat can xoa
            if (!empty($thongTinPhieuXuat)) {
                $danhSachChiTietPhieuXuat = $this->chiTietPhieuXuat->timDanhSachChiTietPhieuXuatTheoMaPhieuXuat($thongTinPhieuXuat->maphieuxuat); //tim chi tiet phieu xuat can xoa
                if (!empty($danhSachChiTietPhieuXuat)) {
                    foreach ($danhSachChiTietPhieuXuat as $ctpx) {
                        $thongTinSanPham = $this->sanPham->timSanPhamTheoMa($ctpx->masanpham); //tim san pham can chinh so luong
                        if (!empty($thongTinSanPham) && $thongTinPhieuXuat->tinhtranggiaohang == 4) {
                            $dataSanPham = [
                                $thongTinSanPham->soluong + $ctpx->soluong
                            ];
                            $this->sanPham->suaSoLuong($dataSanPham, $thongTinSanPham->masanpham); //chinh so luong ton kho san pham tren database
                        }
                        $this->chiTietPhieuXuat->xoaChiTietPhieuXuat($ctpx->machitietphieuxuat); //xoa chi tiet phieu xuat tren database
                    }
                }
                $this->phieuXuat->xoaPhieuXuat($thongTinPhieuXuat->maphieuxuat); //xoa phieu xuat tren database
                return back()->with(
                    'tieudethongbao',
                    'Thao tác thành công'
                )->with(
                    'thongbao',
                    'Xóa phiếu xuất thành công'
                )->with(
                    'loaithongbao',
                    'success'
                );
            }
            return back()->with(
                'tieudethongbao',
                'Thao tác thất bại'
            )->with(
                'thongbao',
                'Xóa phiếu xuất thất bại'
            )->with(
                'loaithongbao',
                'danger'
            );
        }
        if ($request->thaoTac == "sửa phiếu xuất") { // *******************************************************************************************sua phieu xuat
            $rules = [
                'maPhieuXuatSua' => 'required|integer|exists:phieuxuat,maphieuxuat',
                'chiTietPhieuXuat' => 'required|array',
                'chiTietPhieuXuat.*' => 'required|string|max:255|min:3',
                'soLuong' => 'required|array',
                'soLuong.*' => 'required|integer',
                'baoHanh' => 'required|array',
                'baoHanh.*' => 'required|integer',
                'donGia' => 'required|array',
                'donGia.*' => 'required|string|max:255|min:1',
                'thongTinNguoiDung' => 'required|string|max:255|min:3',
                'tongTien' => 'required|numeric',
                'daThanhToan' => 'required|string|max:255|min:1',
                'hinhThucThanhToan' => 'required|integer|between:0,2',
                'tinhTrangGiaoHang' => 'required|integer|between:0,4',
                'ghiChu' => 'max:255'
            ];
            $messages = [
                'required' => ':attribute bắt buộc nhập',
                'string' => ':attribute đã nhập sai',
                'integer' => ':attribute đã nhập sai',
                'numeric' => ':attribute đã nhập sai',
                'between' => ':attribute vượt quá số lượng cho phép',
                'min' => ':attribute tối thiểu :min ký tự',
                'max' => ':attribute tối đa :max ký tự',
                'digits' => ':attribute không đúng :digits ký tự'
            ];
            $attributes = [
                'maPhieuXuatSua' => 'Mã phiếu xuất',
                'chiTietPhieuXuat' => 'Chi tiết phiếu xuất',
                'chiTietPhieuXuat.*' => 'Chi tiết phiếu xuất *',
                'soLuong' => 'Số lượng',
                'soLuong.*' => 'Số lượng *',
                'baoHanh' => 'Bảo hành',
                'baoHanh.*' => 'Bảo hành *',
                'donGia' => 'Đơn giá',
                'donGia.*' => 'Đơn giá *',
                'thongTinNguoiDung' => 'Thông tin người dùng',
                'tongTien' => 'Tổng tiền',
                'daThanhToan' => 'Đã thanh toán',
                'hinhThucThanhToan' => 'Hình thức thanh toán',
                'tinhTrangGiaoHang' => 'Tình trạng giao hàng',
                'ghiChu' => 'Ghi chú'
            ];
            $request->validate($rules, $messages, $attributes);
            $thongTinPhieuXuat = $this->phieuXuat->timPhieuXuatTheoMa($request->maPhieuXuatSua); //tim phieu xuat
            // ***********Xu ly phieu xuat
            $thongTinNguoiDung = explode(' | ', $request->thongTinNguoiDung);
            if (empty($thongTinNguoiDung[0]) || empty($thongTinNguoiDung[1]) || empty($thongTinNguoiDung[2])) { // thong tin nguoi dung nhap vao sai cu phap quay lai trang truoc va bao loi
                return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Không thể chỉnh sửa thông tin khách hàng, vui lòng nhập lại!')->with('loaithongbao', 'danger');
            }
            $maNguoiDung = explode('ND', $thongTinNguoiDung[0]);
            $maNguoiDung = $maNguoiDung[1];
            $hoTen = $thongTinNguoiDung[1];
            $soDienThoai = $thongTinNguoiDung[2];
            if (!is_numeric($maNguoiDung)) { // ma nguoi dung nhap vao khong phai ky tu so quay lai trang truoc va bao loi
                return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Không thể chỉnh sửa thông tin khách hàng, vui lòng nhập lại!')->with('loaithongbao', 'danger');
            }
            if ($thongTinPhieuXuat->manguoidung != $maNguoiDung) { // thong tin nguoi dung khong khop va bao loi
                return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Không thể chỉnh sửa thông tin khách hàng, vui lòng nhập lại!')->with('loaithongbao', 'danger');
            }
            $thongTinNguoiDung = $this->nguoiDung->timNguoiDungTheoMa($maNguoiDung);
            if (empty($thongTinNguoiDung)) { // khong tim thay nguoi dung tren database quay lai trang truoc va bao loi
                return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Không thể chỉnh sửa thông tin khách hàng, vui lòng nhập lại!')->with('loaithongbao', 'danger');
            }
            if ($hoTen != $thongTinNguoiDung->hoten || $soDienThoai != $thongTinNguoiDung->sodienthoai) { // thong tin nguoi dung khong khop va bao loi
                return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Không thể chỉnh sửa thông tin khách hàng, vui lòng nhập lại!')->with('loaithongbao', 'danger');
            }
            if ($thongTinNguoiDung->trangthai == 0) { // thong tin nguoi dung dang bi khoa
                return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Trạng thái người dùng đang bị khóa, không thể thao tác!')->with('loaithongbao', 'danger');
            }
            $soTienDaThanhToan = explode(',', $request->daThanhToan);
            $temp = "";
            foreach ($soTienDaThanhToan as $stdtt) {
                $temp = $temp . $stdtt;
            }
            $soTienDaThanhToan = $temp;
            if (!is_numeric($soTienDaThanhToan)) { // so tien da thanh toan nhap vao khong phai ky tu so quay lai trang truoc va bao loi
                return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Số tiền đã thanh toán nhập sai, vui lòng nhập lại!')->with('loaithongbao', 'danger');
            }
            if (($soTienDaThanhToan == 0 && $request->tongTien == 0) || $soTienDaThanhToan > $request->tongTien) { // phieu khong co gi nen khong lap va quay lai trang truoc va bao loi
                return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Số tiền đã thanh toán nhập sai, vui lòng nhập lại!')->with('loaithongbao', 'danger');
            }
            $hoTenNguoiNhan = $thongTinPhieuXuat->hotennguoinhan;
            $soDienThoaiNguoiNhan = $thongTinPhieuXuat->sodienthoainguoinhan;
            $diaChiNguoiNhan = $thongTinPhieuXuat->diachinguoinhan;
            $ghiChu = $thongTinPhieuXuat->ghichu;
            $tongTien = $thongTinPhieuXuat->tongtien;
            $tinhTrangGiaoHang = $thongTinPhieuXuat->tinhtranggiaohang;
            $hinhThucThanhToan = $thongTinPhieuXuat->hinhthucthanhtoan;
            $congNo = $thongTinPhieuXuat->congno;
            $congNoSua = $soTienDaThanhToan - $request->tongTien;
            if(!empty($thongTinPhieuXuat->magiamgia)){
                $thongTinMaGiamGia = $this->maGiamGia->timMaGiamGiaTheoMa($thongTinPhieuXuat->magiamgia); //tim ma giam gia
                if (!empty($thongTinMaGiamGia)) {
                    $congNoSua += $thongTinMaGiamGia->sotiengiam;
                } else {
                    return back()->with('thongbao', 'Mã giảm giá không tồn tại!');
                }
            }
            if (isset($request->thongTinNguoiNhanKhac)) {
                if ($request->thongTinNguoiNhanKhac == "on") {
                    $rules = [
                        'hoTenNguoiNhan' => 'required|string|max:50|min:3',
                        'soDienThoaiNguoiNhan' => 'required|numeric|digits:10',
                        'diaChiNguoiNhan' => 'required|string|max:255|min:3',
                    ];
                    $messages = [
                        'required' => ':attribute bắt buộc nhập',
                        'string' => ':attribute đã nhập sai',
                        'numeric' => ':attribute đã nhập sai',
                        'min' => ':attribute tối thiểu :min ký tự',
                        'max' => ':attribute tối đa :max ký tự',
                        'digits' => ':attribute không đúng :digits ký tự'
                    ];
                    $attributes = [
                        'hoTenNguoiNhan' => 'Họ tên người nhận',
                        'soDienThoaiNguoiNhan' => 'Số điện thoại người nhận',
                        'diaChiNguoiNhan' => 'Địa chỉ người nhận',
                    ];
                    $request->validate($rules, $messages, $attributes);
                    if ($request->hoTenNguoiNhan != $hoTenNguoiNhan) { //ho ten nguoi nhan vua chinh sua khac voi ho ten nguoi nhan cu
                        $hoTenNguoiNhan = $request->hoTenNguoiNhan;
                    }
                    if ($request->soDienThoaiNguoiNhan != $soDienThoaiNguoiNhan) { //sdt nguoi nhan vua chinh sua khac voi sdt nguoi nhan cu
                        $soDienThoaiNguoiNhan = $request->soDienThoaiNguoiNhan;
                    }
                    if ($request->diaChiNguoiNhan != $diaChiNguoiNhan) { //dia chi nguoi nhan vua chinh sua khac voi dia chi nguoi nhan cu
                        $diaChiNguoiNhan = $request->diaChiNguoiNhan;
                    }
                } else {
                    return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Thông tin người nhận khác nhập sai, vui lòng nhập lại!')->with('loaithongbao', 'danger');
                }
            } else { //neu khong tich chon giao den noi khac
                $hoTenNguoiNhan = $thongTinNguoiDung->hoten;
                $soDienThoaiNguoiNhan = $thongTinNguoiDung->sodienthoai;
                $diaChiNguoiNhan = $thongTinNguoiDung->diachi;
                //lay thong tin nguoi dung dat hang lam thong tin giao hang
            }
            if ($request->ghiChu != $ghiChu) { //ghi chu vua chinh sua khac voi ghi chu cu
                $ghiChu = $request->ghiChu;
            }
            if ($request->tongTien != $tongTien) { //tong tien vua chinh sua khac voi tong tien cu
                $tongTien = $request->tongTien;
            }
            if ($request->tinhTrangGiaoHang != $tinhTrangGiaoHang) { //tinh trang giao hang vua chinh sua khac voi tinh trang giao hang cu
                $tinhTrangGiaoHang = $request->tinhTrangGiaoHang;
            }
            if ($request->hinhThucThanhToan != $hinhThucThanhToan) { //hinh thuc thanh toan vua chinh sua khac voi hinh thuc thanh toan cu
                $hinhThucThanhToan = $request->hinhThucThanhToan;
            }
            if ($congNoSua != $congNo) { //ghi chu vua chinh sua khac voi ghi chu cu
                $congNo = $congNoSua;
            }
            $dataPhieuXuat = [
                $hoTenNguoiNhan,
                $soDienThoaiNguoiNhan,
                $diaChiNguoiNhan,
                $ghiChu,
                $tongTien,
                $tinhTrangGiaoHang,
                $hinhThucThanhToan,
                $congNo
            ];
            $this->phieuXuat->suaPhieuXuat($dataPhieuXuat, $thongTinPhieuXuat->maphieuxuat); //sua phieu xuat tren database
            $danhSachChiTietPhieuXuat = $this->chiTietPhieuXuat->timDanhSachChiTietPhieuXuatTheoMaPhieuXuat($thongTinPhieuXuat->maphieuxuat); //tim danh sach chi tiet phieu xuat
            // ***********Xu ly them chi tiet phieu xuat
            if (!empty($request->chiTietPhieuXuat)) {
                for ($i = 0; $i < count($request->chiTietPhieuXuat); $i++) {
                    if (!empty($request->chiTietPhieuXuat[$i]) && $request->soLuong[$i] > 0 && $request->donGia[$i] >= 0 && $request->baoHanh[$i] >= 0) {
                        $thongTinSanPham = explode(' | ', $request->chiTietPhieuXuat[$i]);
                        if (empty($thongTinSanPham[0]) || empty($thongTinSanPham[1])) { // thong tin san pham xuat  sai cu phap quay lai trang truoc va bao loi
                            return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Thông tin sản phẩm không tồn tại, vui lòng nhập lại!')->with('loaithongbao', 'danger');
                        }
                        $maSanPham = explode('SP', $thongTinSanPham[0]);
                        $maSanPham = $maSanPham[1];
                        $tenSanPham = $thongTinSanPham[1];
                        if (!is_numeric($maSanPham)) { // ma san pham xuat  khong phai ky tu so quay lai trang truoc va bao loi
                            return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Thông tin sản phẩm không tồn tại, vui lòng nhập lại!')->with('loaithongbao', 'danger');
                        }
                        $thongTinSanPham = $this->sanPham->timSanPhamTheoMa($maSanPham);
                        if (empty($thongTinSanPham)) { // khong tim thay san pham tren database quay lai trang truoc va bao loi
                            return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Thông tin sản phẩm không tồn tại, vui lòng nhập lại!')->with('loaithongbao', 'danger');
                        }
                        if ($tenSanPham != $thongTinSanPham->tensanpham) { // thong tin san pham khong khop va bao loi
                            return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Thông tin sản phẩm không tồn tại, vui lòng nhập lại!')->with('loaithongbao', 'danger');
                        }
                        $soLuongXuat = $request->soLuong[$i];
                        $baoHanhXuat = $request->baoHanh[$i];
                        $donGiaXuat = explode(',', $request->donGia[$i]);
                        $temp = "";
                        foreach ($donGiaXuat as $dgx) {
                            $temp = $temp . $dgx;
                        }
                        $donGiaXuat = $temp;
                        if (!is_numeric($donGiaXuat)) { // so tien don gia xuat  khong phai ky tu so quay lai trang truoc va bao loi
                            return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Số tiền đơn giá nhập sai, vui lòng nhập lại!')->with('loaithongbao', 'danger');
                        }
                        $dataChiTietPhieuXuat = [
                            NULL, //machitietphieuxuat tu dong
                            $thongTinPhieuXuat->maphieuxuat,
                            $thongTinSanPham->masanpham,
                            $baoHanhXuat,
                            $soLuongXuat,
                            $donGiaXuat
                        ];
                        $this->chiTietPhieuXuat->themChiTietPhieuXuat($dataChiTietPhieuXuat); //them chi tiet phieu xuat vao database
                        // Xu ly so luong san pham
                        if ($request->tinhTrangGiaoHang == 4) { //phieu xuat da giao hang moi tru vao ton kho
                            $dataSanPham = [
                                $thongTinSanPham->soluong - $soLuongXuat, //tru so luong vua xuat vao ton kho
                            ];
                            $this->sanPham->suaSoLuong($dataSanPham, $thongTinSanPham->masanpham); //them so luong ton kho va chinh gia database
                        }
                    }
                }
                if (!empty($danhSachChiTietPhieuXuat)) {
                    foreach ($danhSachChiTietPhieuXuat as $ctpx) {
                        $thongTinSanPham = $this->sanPham->timSanPhamTheoMa($ctpx->masanpham); //tim san pham can chinh so luong
                        if (!empty($thongTinSanPham) && $thongTinPhieuXuat->tinhtranggiaohang == 4) {
                            $dataSanPham = [
                                $thongTinSanPham->soluong + $ctpx->soluong
                            ];
                            $this->sanPham->suaSoLuong($dataSanPham, $thongTinSanPham->masanpham); //chinh so luong ton kho san pham tren database
                        }
                        $this->chiTietPhieuXuat->xoaChiTietPhieuXuat($ctpx->machitietphieuxuat); //xoa chi tiet phieu xuat tren database
                    }
                }
                return redirect()->route('phieuxuat')->with('tieudethongbao', 'Thao tác thành công')->with('thongbao', 'Sửa thông tin phiếu xuất thành công')->with('loaithongbao', 'success');
            }
            return redirect()->route('phieuxuat')->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Sửa thông tin phiếu xuất thất bại')->with('loaithongbao', 'danger');
        }
        if ($request->thaoTac == "thêm phiếu xuất") { // *******************************************************************************************them phieu xuat
            $rules = [
                'chiTietPhieuXuat' => 'required|array',
                'chiTietPhieuXuat.*' => 'required|string|max:255|min:3',
                'soLuong' => 'required|array',
                'soLuong.*' => 'required|integer',
                'baoHanh' => 'required|array',
                'baoHanh.*' => 'required|integer',
                'donGia' => 'required|array',
                'donGia.*' => 'required|string|max:255|min:1',
                'thongTinNguoiDung' => 'required|string|max:255|min:3',
                'tongTien' => 'required|numeric',
                'daThanhToan' => 'required|string|max:255|min:1',
                'hinhThucThanhToan' => 'required|integer|between:0,2',
                'tinhTrangGiaoHang' => 'required|integer|between:0,4',
                'ghiChu' => 'max:255'
            ];
            $messages = [
                'required' => ':attribute bắt buộc nhập',
                'string' => ':attribute đã nhập sai',
                'integer' => ':attribute đã nhập sai',
                'numeric' => ':attribute đã nhập sai',
                'between' => ':attribute vượt quá số lượng cho phép',
                'min' => ':attribute tối thiểu :min ký tự',
                'max' => ':attribute tối đa :max ký tự',
                'digits' => ':attribute không đúng :digits ký tự'
            ];
            $attributes = [
                'chiTietPhieuXuat' => 'Chi tiết phiếu xuất',
                'chiTietPhieuXuat.*' => 'Chi tiết phiếu xuất *',
                'soLuong' => 'Số lượng',
                'soLuong.*' => 'Số lượng *',
                'baoHanh' => 'Bảo hành',
                'baoHanh.*' => 'Bảo hành *',
                'donGia' => 'Đơn giá',
                'donGia.*' => 'Đơn giá *',
                'thongTinNguoiDung' => 'Thông tin người dùng',
                'tongTien' => 'Tổng tiền',
                'daThanhToan' => 'Đã thanh toán',
                'hinhThucThanhToan' => 'Hình thức thanh toán',
                'tinhTrangGiaoHang' => 'Tình trạng giao hàng',
                'ghiChu' => 'Ghi chú'
            ];
            $request->validate($rules, $messages, $attributes);
            // ***********Xu ly them phieu xuat
            $thongTinNguoiDung = explode(' | ', $request->thongTinNguoiDung);
            if (empty($thongTinNguoiDung[0]) || empty($thongTinNguoiDung[1]) || empty($thongTinNguoiDung[2])) { // thong tin nguoi dung nhap vao sai cu phap quay lai trang truoc va bao loi
                return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Thông tin người dùng không tồn tại, vui lòng nhập lại!')->with('loaithongbao', 'danger');
            }
            $maNguoiDung = explode('ND', $thongTinNguoiDung[0]);
            $maNguoiDung = $maNguoiDung[1];
            $hoTen = $thongTinNguoiDung[1];
            $soDienThoai = $thongTinNguoiDung[2];
            if (!is_numeric($maNguoiDung)) { // ma nguoi dung nhap vao khong phai ky tu so quay lai trang truoc va bao loi
                return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Thông tin người dùng không tồn tại, vui lòng nhập lại!')->with('loaithongbao', 'danger');
            }
            $thongTinNguoiDung = $this->nguoiDung->timNguoiDungTheoMa($maNguoiDung);
            if (empty($thongTinNguoiDung)) { // khong tim thay nguoi dung tren database quay lai trang truoc va bao loi
                return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Thông tin người dùng không tồn tại, vui lòng nhập lại!')->with('loaithongbao', 'danger');
            }
            if ($hoTen != $thongTinNguoiDung->hoten || $soDienThoai != $thongTinNguoiDung->sodienthoai) { // thong tin nguoi dung khong khop va bao loi
                return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Thông tin người dùng không tồn tại, vui lòng nhập lại!')->with('loaithongbao', 'danger');
            }
            if ($thongTinNguoiDung->trangthai == 0) { // thong tin nguoi dung dang bi khoa
                return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Trạng thái người dùng đang bị khóa, không thể thao tác!')->with('loaithongbao', 'danger');
            }
            $soTienDaThanhToan = explode(',', $request->daThanhToan);
            $temp = "";
            foreach ($soTienDaThanhToan as $stdtt) {
                $temp = $temp . $stdtt;
            }
            $soTienDaThanhToan = $temp;
            if (!is_numeric($soTienDaThanhToan)) { // so tien da thanh toan nhap vao khong phai ky tu so quay lai trang truoc va bao loi
                return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Số tiền đã thanh toán nhập sai, vui lòng nhập lại!')->with('loaithongbao', 'danger');
            }
            if (($soTienDaThanhToan == 0 && $request->tongTien == 0) || $soTienDaThanhToan > $request->tongTien) { // phieu khong co gi nen khong lap va quay lai trang truoc va bao loi
                return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Số tiền đã thanh toán nhập sai, vui lòng nhập lại!')->with('loaithongbao', 'danger');
            }
            $congNo = $soTienDaThanhToan - $request->tongTien;
            $ngayTao = date("Y-m-d H:i:s");
            $dataPhieuXuat = [
                NULL, //maphieuxuat tu dong
                $thongTinNguoiDung->hoten,    // hotennguoinhan,
                $thongTinNguoiDung->sodienthoai,    // sodienthoainguoinhan,
                $thongTinNguoiDung->diachi,    // diachinguoinhan,
                $thongTinNguoiDung->manguoidung,
                NULL,    // magiamgia,
                $request->ghiChu,
                $request->tongTien,
                $request->tinhTrangGiaoHang,    // tinhtranggiaohang,  	0 là đã hủy, 1 là chờ xác nhận, 2 là đang chuẩn bị hàng, 3 là đang giao, 4 là đã giao thành công
                $request->hinhThucThanhToan,    // hinhthucthanhtoan,   0 là tiền mặt, 1 là chuyển khoản, 2 là atm qua vpn
                $congNo,    // congno, 0 là đã thanh toán, !=0 là công nợ
                $ngayTao    // ngaytao
            ];
            if (isset($request->thongTinNguoiNhanKhac)) {
                if ($request->thongTinNguoiNhanKhac == "on") {
                    $rules = [
                        'hoTenNguoiNhan' => 'required|string|max:50|min:3',
                        'soDienThoaiNguoiNhan' => 'required|numeric|digits:10',
                        'diaChiNguoiNhan' => 'required|string|max:255|min:3',
                    ];
                    $messages = [
                        'required' => ':attribute bắt buộc nhập',
                        'string' => ':attribute đã nhập sai',
                        'numeric' => ':attribute đã nhập sai',
                        'min' => ':attribute tối thiểu :min ký tự',
                        'max' => ':attribute tối đa :max ký tự',
                        'digits' => ':attribute không đúng :digits ký tự'
                    ];
                    $attributes = [
                        'hoTenNguoiNhan' => 'Họ tên người nhận',
                        'soDienThoaiNguoiNhan' => 'Số điện thoại người nhận',
                        'diaChiNguoiNhan' => 'Địa chỉ người nhận',
                    ];
                    $request->validate($rules, $messages, $attributes);
                    $dataPhieuXuat = [
                        NULL, //maphieuxuat tu dong
                        $request->hoTenNguoiNhan,    // hotennguoinhan,
                        $request->soDienThoaiNguoiNhan,    // sodienthoainguoinhan,
                        $request->diaChiNguoiNhan,    // diachinguoinhan,
                        $thongTinNguoiDung->manguoidung,
                        NULL,    // magiamgia,
                        $request->ghiChu,
                        $request->tongTien,
                        $request->tinhTrangGiaoHang,    // tinhtranggiaohang,  	0 là đã hủy, 1 là chờ xác nhận, 2 là đang chuẩn bị hàng, 3 là đang giao, 4 là đã giao thành công
                        $request->hinhThucThanhToan,    // hinhthucthanhtoan,   0 là tiền mặt, 1 là chuyển khoản, 2 là atm qua vpn
                        $congNo,    // congno, 0 là đã thanh toán, !=0 là công nợ
                        $ngayTao    // ngaytao
                    ];
                } else {
                    return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Thông tin người nhận khác nhập sai, vui lòng nhập lại!')->with('loaithongbao', 'danger');
                }
            }
            $this->phieuXuat->themPhieuXuat($dataPhieuXuat); //them phieu xuat vao database
            $thongTinPhieuXuat = $this->phieuXuat->timPhieuXuatTheoNgayTao($ngayTao); //tim phieu xuat vua them
            // ***********Xu ly them chi tiet phieu xuat
            if (!empty($request->chiTietPhieuXuat)) {
                for ($i = 0; $i < count($request->chiTietPhieuXuat); $i++) {
                    if (!empty($request->chiTietPhieuXuat[$i]) && $request->soLuong[$i] > 0 && $request->donGia[$i] >= 0 && $request->baoHanh[$i] >= 0) {
                        $thongTinSanPham = explode(' | ', $request->chiTietPhieuXuat[$i]);
                        if (empty($thongTinSanPham[0]) || empty($thongTinSanPham[1])) { // thong tin san pham xuat  sai cu phap quay lai trang truoc va bao loi
                            return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Thông tin sản phẩm không tồn tại, vui lòng nhập lại!')->with('loaithongbao', 'danger');
                        }
                        $maSanPham = explode('SP', $thongTinSanPham[0]);
                        $maSanPham = $maSanPham[1];
                        $tenSanPham = $thongTinSanPham[1];
                        if (!is_numeric($maSanPham)) { // ma san pham xuat  khong phai ky tu so quay lai trang truoc va bao loi
                            return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Thông tin sản phẩm không tồn tại, vui lòng nhập lại!')->with('loaithongbao', 'danger');
                        }
                        $thongTinSanPham = $this->sanPham->timSanPhamTheoMa($maSanPham);
                        if (empty($thongTinSanPham)) { // khong tim thay san pham tren database quay lai trang truoc va bao loi
                            return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Thông tin sản phẩm không tồn tại, vui lòng nhập lại!')->with('loaithongbao', 'danger');
                        }
                        if ($tenSanPham != $thongTinSanPham->tensanpham) { // thong tin san pham khong khop va bao loi
                            return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Thông tin sản phẩm không tồn tại, vui lòng nhập lại!')->with('loaithongbao', 'danger');
                        }
                        $soLuongXuat = $request->soLuong[$i];
                        $baoHanhXuat = $request->baoHanh[$i];
                        $donGiaXuat = explode(',', $request->donGia[$i]);
                        $temp = "";
                        foreach ($donGiaXuat as $dgx) {
                            $temp = $temp . $dgx;
                        }
                        $donGiaXuat = $temp;
                        if (!is_numeric($donGiaXuat)) { // so tien don gia xuat  khong phai ky tu so quay lai trang truoc va bao loi
                            return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Số tiền đơn giá nhập sai, vui lòng nhập lại!')->with('loaithongbao', 'danger');
                        }
                        $dataChiTietPhieuXuat = [
                            NULL, //machitietphieuxuat tu dong
                            $thongTinPhieuXuat->maphieuxuat,
                            $thongTinSanPham->masanpham,
                            $baoHanhXuat,
                            $soLuongXuat,
                            $donGiaXuat
                        ];
                        $this->chiTietPhieuXuat->themChiTietPhieuXuat($dataChiTietPhieuXuat); //them chi tiet phieu xuat vao database
                        // Xu ly so luong san pham
                        if ($request->tinhTrangGiaoHang == 4) { //phieu xuat da giao hang moi tru vao ton kho
                            $dataSanPham = [
                                $thongTinSanPham->soluong - $soLuongXuat, //tru so luong vua xuat vao ton kho
                            ];
                            $this->sanPham->suaSoLuong($dataSanPham, $thongTinSanPham->masanpham); //them so luong ton kho va chinh gia database
                        }
                    }
                }
            }
            return redirect()->route('phieuxuat')->with('tieudethongbao', 'Thao tác thành công')->with('thongbao', 'Lập phiếu xuất thành công')->with('loaithongbao', 'success');
        }
        return back()->with(
            'tieudethongbao',
            'Thao tác thất bại'
        )->with(
            'thongbao',
            'Vui lòng thử lại!'
        )->with(
            'loaithongbao',
            'danger'
        );
    }
    public function themphieuxuat(Request $request)
    {
        if (!Auth::check() || Auth::user()->loainguoidung != 2) {
            return redirect()->route('dangnhap');
        }
        $danhSachSanPham = $this->sanPham->layDanhSachSanPhamChoPhieu();
        $danhSachHangSanXuat = $this->hangSanXuat->layDanhSachHangSanXuat();
        $danhSachHangSanXuatLaptop = []; // loc lai danh sach theo loai hang san xuat laptop can xem
        $danhSachHangSanXuatPhuKien = [];
        foreach ($danhSachHangSanXuat as $hangSanXuat) {
            if ($hangSanXuat->loaihang == 0) {
                $danhSachHangSanXuatLaptop = array_merge($danhSachHangSanXuatLaptop, [$hangSanXuat]);
            }
            if ($hangSanXuat->loaihang == 1) {
                $danhSachHangSanXuatPhuKien = array_merge($danhSachHangSanXuatPhuKien, [$hangSanXuat]);
            }
        }

        $danhSachNguoiDung = $this->nguoiDung->layDanhSachNguoiDung();
        $danhSachKhachHang = []; // loc lai danh sach thong tin nha cung cap gom nguoi dung la khach hang hoac doi tac va co trang thai dang hoat dong
        foreach ($danhSachNguoiDung as $nguoiDung) {
            if (($nguoiDung->loainguoidung == 0 || $nguoiDung->loainguoidung == 1) && $nguoiDung->trangthai == 1) {
                $danhSachKhachHang = array_merge($danhSachKhachHang, [$nguoiDung]);
            }
        }
        $danhSachPhieuXuatChoXacNhan = $this->phieuXuat->layDanhSachPhieuXuatTheoBoLoc([['phieuxuat.tinhtranggiaohang', '=', 1]]);
        $danhSachLoiPhanHoiChuaDoc = $this->loiPhanHoi->layDanhSachLoiPhanHoiTheoBoLoc([['loiphanhoi.trangthai', '=', 0]]);
        return view('admin.themphieuxuat', compact(
            'danhSachSanPham',
            'danhSachHangSanXuatLaptop',
            'danhSachHangSanXuatPhuKien',
            'danhSachPhieuXuatChoXacNhan',
            'danhSachLoiPhanHoiChuaDoc',
            'danhSachKhachHang'
        ));
    }
    public function suaphieuxuat(Request $request)
    {
        if (!Auth::check() || Auth::user()->loainguoidung != 2) {
            return redirect()->route('dangnhap');
        }
        $rules = [
            'id' => 'required|integer|exists:phieuxuat,maphieuxuat'
        ];
        $messages = [
            'required' => ':attribute bắt buộc nhập',
            'exists' => ':attribute không tồn tại',
            'integer' => ':attribute nhập sai'
        ];
        $attributes = [
            'id' => 'Mã phiếu xuất'
        ];
        $request->validate($rules, $messages, $attributes);
        $danhSachSanPham = $this->sanPham->layDanhSachSanPhamChoPhieu();
        $danhSachHangSanXuat = $this->hangSanXuat->layDanhSachHangSanXuat();
        $danhSachHangSanXuatLaptop = []; // loc lai danh sach theo loai hang san xuat laptop can xem
        $danhSachHangSanXuatPhuKien = [];
        foreach ($danhSachHangSanXuat as $hangSanXuat) {
            if ($hangSanXuat->loaihang == 0) {
                $danhSachHangSanXuatLaptop = array_merge($danhSachHangSanXuatLaptop, [$hangSanXuat]);
            }
            if ($hangSanXuat->loaihang == 1) {
                $danhSachHangSanXuatPhuKien = array_merge($danhSachHangSanXuatPhuKien, [$hangSanXuat]);
            }
        }
        $danhSachNguoiDung = $this->nguoiDung->layDanhSachNguoiDung();
        $danhSachKhachHang = []; // loc lai danh sach thong tin nha cung cap gom nguoi dung la khach hang hoac doi tac va co trang thai la dang hoat dong
        foreach ($danhSachNguoiDung as $nguoiDung) {
            if (($nguoiDung->loainguoidung == 0 || $nguoiDung->loainguoidung == 1) && $nguoiDung->trangthai == 1) {
                $danhSachKhachHang = array_merge($danhSachKhachHang, [$nguoiDung]);
            }
        }
        $phieuXuatCanXem = $this->phieuXuat->timPhieuXuatTheoMa($request->id);
        $nguoiDungCanXem = $this->nguoiDung->timNguoiDungTheoMa($phieuXuatCanXem->manguoidung);
        $maGiamGiaCanXem = $this->maGiamGia->timMaGiamGiaTheoMa($phieuXuatCanXem->magiamgia);
        $danhSachChiTietPhieuXuatCanXem = $this->chiTietPhieuXuat->timDanhSachChiTietPhieuXuatTheoMaPhieuXuat($request->id);
        $danhSachPhieuXuatChoXacNhan = $this->phieuXuat->layDanhSachPhieuXuatTheoBoLoc([['phieuxuat.tinhtranggiaohang', '=', 1]]);
        $danhSachLoiPhanHoiChuaDoc = $this->loiPhanHoi->layDanhSachLoiPhanHoiTheoBoLoc([['loiphanhoi.trangthai', '=', 0]]);
        return view('admin.suaphieuxuat', compact(
            'phieuXuatCanXem',
            'nguoiDungCanXem',
            'maGiamGiaCanXem',
            'danhSachChiTietPhieuXuatCanXem',
            'danhSachSanPham',
            'danhSachHangSanXuatLaptop',
            'danhSachHangSanXuatPhuKien',
            'danhSachPhieuXuatChoXacNhan',
            'danhSachLoiPhanHoiChuaDoc',
            'danhSachKhachHang'
        ));
    }
    public function inphieunhap(Request $request)
    {
        if (!Auth::check() || Auth::user()->loainguoidung != 2) {
            return redirect()->route('dangnhap');
        }
        $rules = [
            'mapn' => 'required|integer|exists:phieunhap,maphieunhap'
        ];
        $messages = [
            'required' => ':attribute bắt buộc nhập',
            'exists' => ':attribute không tồn tại',
            'integer' => ':attribute nhập sai'
        ];
        $attributes = [
            'mapn' => 'Mã phiếu nhập'
        ];
        $request->validate($rules, $messages, $attributes);
        $danhSachSanPham = $this->sanPham->layDanhSachSanPham();
        $phieuNhapCanXem = $this->phieuNhap->timPhieuNhapTheoMa($request->mapn);
        $nguoiDungCanXem = $this->nguoiDung->timNguoiDungTheoMa($phieuNhapCanXem->manguoidung);
        $danhSachChiTietPhieuNhapCanXem = $this->chiTietPhieuNhap->timDanhSachChiTietPhieuNhapTheoMaPhieuNhap($phieuNhapCanXem->maphieunhap);
    	$pdf = PDF::loadView('admin.pdf.phieunhap',compact(
            'phieuNhapCanXem',
            'nguoiDungCanXem',
            'danhSachChiTietPhieuNhapCanXem',
            'danhSachSanPham'
        ));
    	return $pdf->stream('PN'.$phieuNhapCanXem->maphieunhap.'.pdf');
    }
    public function phieunhap()
    {
        if (!Auth::check() || Auth::user()->loainguoidung != 2) {
            return redirect()->route('dangnhap');
        }
        $danhSachPhieuNhap = $this->phieuNhap->layDanhSachPhieuNhap();
        $danhSachNguoiDung = $this->nguoiDung->layDanhSachNguoiDung();
        $danhSachPhieuXuatChoXacNhan = $this->phieuXuat->layDanhSachPhieuXuatTheoBoLoc([['phieuxuat.tinhtranggiaohang', '=', 1]]);
        $danhSachLoiPhanHoiChuaDoc = $this->loiPhanHoi->layDanhSachLoiPhanHoiTheoBoLoc([['loiphanhoi.trangthai', '=', 0]]);
        return view('admin.phieunhap', compact(
            'danhSachPhieuNhap',
            'danhSachPhieuXuatChoXacNhan',
            'danhSachLoiPhanHoiChuaDoc',
            'danhSachNguoiDung'
        ));
    }
    public function xulyphieunhap(Request $request)
    {
        $request->validate(['thaoTac' => 'required|string']);
        if ($request->thaoTac == "xóa phiếu nhập") { // *******************************************************************************************xoa phieu nhap
            $rules = [
                'maPhieuNhapXoa' => 'required|integer|exists:phieunhap,maphieunhap'
            ];
            $messages = [
                'required' => ':attribute bắt buộc nhập',
                'exists' => ':attribute không tồn tại',
                'integer' => ':attribute đã nhập sai'
            ];
            $attributes = [
                'maPhieuNhapXoa' => 'Mã phiếu nhập'
            ];
            $request->validate($rules, $messages, $attributes);
            $thongTinPhieuNhap = $this->phieuNhap->timPhieuNhapTheoMa($request->maPhieuNhapXoa); //tim phieu nhap can xoa
            if (!empty($thongTinPhieuNhap)) {
                $danhSachChiTietPhieuNhap = $this->chiTietPhieuNhap->timDanhSachChiTietPhieuNhapTheoMaPhieuNhap($thongTinPhieuNhap->maphieunhap); //tim chi tiet phieu nhap can xoa
                if (!empty($danhSachChiTietPhieuNhap)) {
                    foreach ($danhSachChiTietPhieuNhap as $ctpn) {
                        $thongTinSanPham = $this->sanPham->timSanPhamTheoMa($ctpn->masanpham); //tim san pham can chinh so luong
                        if (!empty($thongTinSanPham)) {
                            $dataSanPham = [
                                $thongTinSanPham->soluong - $ctpn->soluong
                            ];
                            $this->sanPham->suaSoLuong($dataSanPham, $thongTinSanPham->masanpham); //chinh so luong ton kho san pham tren database
                            $this->chiTietPhieuNhap->xoaChiTietPhieuNhap($ctpn->machitietphieunhap); //xoa chi tiet phieu nhap tren database
                        }
                    }
                }
                $this->phieuNhap->xoaPhieuNhap($thongTinPhieuNhap->maphieunhap); //xoa phieu nhap tren database
                return back()->with(
                    'tieudethongbao',
                    'Thao tác thành công'
                )->with(
                    'thongbao',
                    'Xóa phiếu nhập thành công'
                )->with(
                    'loaithongbao',
                    'success'
                );
            }
            return back()->with(
                'tieudethongbao',
                'Thao tác thất bại'
            )->with(
                'thongbao',
                'Xóa phiếu nhập thất bại'
            )->with(
                'loaithongbao',
                'danger'
            );
        }
        if ($request->thaoTac == "sửa phiếu nhập") { // *******************************************************************************************sua phieu nhap
            $rules = [
                'maPhieuNhapSua' => 'required|integer|exists:phieunhap,maphieunhap',
                'chiTietPhieuNhap' => 'array',
                'chiTietPhieuNhap.*' => 'required|string|max:255|min:3',
                'soLuong' => 'array',
                'soLuong.*' => 'required|integer',
                'donGia' => 'array',
                'donGia.*' => 'required|string|max:255|min:1',
                'thongTinNguoiDung' => 'required|string|max:255|min:3',
                'ghiChu' => 'max:255',
                'tongTien' => 'required|numeric',
                'daThanhToan' => 'required|string|max:255|min:1'
            ];
            $messages = [
                'required' => ':attribute bắt buộc nhập',
                'string' => ':attribute nhập sai',
                'min' => ':attribute tối thiểu :min ký tự',
                'max' => ':attribute tối thiểu :max ký tự',
                'integer' => ':attribute nhập sai',
                'numeric' => ':attribute nhập sai',
                'array' => ':attribute nhập sai'
            ];
            $attributes = [
                'chiTietPhieuNhap' => 'Chi tiết phiếu nhập',
                'chiTietPhieuNhap.*' => 'Chi tiết phiếu nhập *',
                'soLuong' => 'Số lượng',
                'soLuong.*' => 'Số lượng *',
                'donGia' => 'Đơn giá',
                'donGia.*' => 'Đơn giá *',
                'thongTinNguoiDung' => 'Thông tin người dùng',
                'ghiChu' => 'Ghi chú',
                'tongTien' => 'Tổng tiền',
                'daThanhToan' => 'Đã thanh toán'
            ];
            $request->validate($rules, $messages, $attributes);
            $thongTinPhieuNhap = $this->phieuNhap->timPhieuNhapTheoMa($request->maPhieuNhapSua); //tim phieu nhap
            // ***********Xu ly phieu nhap
            $thongTinNguoiDung = explode(' | ', $request->thongTinNguoiDung);
            if (empty($thongTinNguoiDung[0]) || empty($thongTinNguoiDung[1]) || empty($thongTinNguoiDung[2])) { // thong tin nguoi dung nhap vao sai cu phap quay lai trang truoc va bao loi
                return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Không thể chỉnh sửa nhà cung cấp, vui lòng nhập lại!')->with('loaithongbao', 'danger');
            }
            $maNguoiDung = explode('ND', $thongTinNguoiDung[0]);
            $maNguoiDung = $maNguoiDung[1];
            $hoTen = $thongTinNguoiDung[1];
            $soDienThoai = $thongTinNguoiDung[2];

            if (!is_numeric($maNguoiDung)) { // ma nguoi dung nhap vao khong phai ky tu so quay lai trang truoc va bao loi
                return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Không thể chỉnh sửa nhà cung cấp, vui lòng nhập lại!')->with('loaithongbao', 'danger');
            }
            if ($thongTinPhieuNhap->manguoidung != $maNguoiDung) { // thong tin nguoi dung khong khop va bao loi
                return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Không thể chỉnh sửa nhà cung cấp, vui lòng nhập lại!')->with('loaithongbao', 'danger');
            }
            $thongTinNguoiDung = $this->nguoiDung->timNguoiDungTheoMa($maNguoiDung);
            if (empty($thongTinNguoiDung)) { // khong tim thay nguoi dung tren database quay lai trang truoc va bao loi
                return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Không thể chỉnh sửa nhà cung cấp, vui lòng nhập lại!')->with('loaithongbao', 'danger');
            }
            if ($hoTen != $thongTinNguoiDung->hoten || $soDienThoai != $thongTinNguoiDung->sodienthoai) { // thong tin nguoi dung khong khop va bao loi
                return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Không thể chỉnh sửa nhà cung cấp, vui lòng nhập lại!')->with('loaithongbao', 'danger');
            }
            if ($thongTinNguoiDung->trangthai == 0) { // thong tin nguoi dung dang bi khoa
                return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Trạng thái người dùng đang bị khóa, không thể thao tác!')->with('loaithongbao', 'danger');
            }
            $soTienDaThanhToan = explode(',', $request->daThanhToan);
            $temp = "";
            foreach ($soTienDaThanhToan as $stdtt) {
                $temp = $temp . $stdtt;
            }
            $soTienDaThanhToan = $temp;
            if (!is_numeric($soTienDaThanhToan)) { // so tien da thanh toan nhap vao khong phai ky tu so quay lai trang truoc va bao loi
                return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Số tiền đã thanh toán nhập sai, vui lòng nhập lại!')->with('loaithongbao', 'danger');
            }
            $ghiChu = $thongTinPhieuNhap->ghichu;
            $tongTien = $thongTinPhieuNhap->tongtien;
            $congNo = $thongTinPhieuNhap->congno;
            $congNoSua = $soTienDaThanhToan - $request->tongTien;
            if ($request->ghiChu != $ghiChu) { //ghi chu vua chinh sua khac voi ghi chu cu
                $ghiChu = $request->ghiChu;
            }
            if ($request->tongTien != $tongTien) { //tong tien vua chinh sua khac voi tong tien cu
                $tongTien = $request->tongTien;
            }
            if ($congNoSua != $congNo) { //ghi chu vua chinh sua khac voi ghi chu cu
                $congNo = $congNoSua;
            }
            $dataPhieuNhap = [
                $ghiChu,
                $tongTien,
                $congNo
            ];
            $this->phieuNhap->suaPhieuNhap($dataPhieuNhap, $thongTinPhieuNhap->maphieunhap); //sua phieu nhap tren database
            $danhSachChiTietPhieuNhap = $this->chiTietPhieuNhap->timDanhSachChiTietPhieuNhapTheoMaPhieuNhap($thongTinPhieuNhap->maphieunhap); //tim danh sach chi tiet phieu nhap
            // ***********Xu ly chi tiet phieu nhap
            if (!empty($request->chiTietPhieuNhap)) {
                for ($i = 0; $i < count($request->chiTietPhieuNhap); $i++) {
                    if (!empty($request->chiTietPhieuNhap[$i]) && !empty($request->soLuong[$i]) && $request->donGia[$i] >= 0) {
                        $thongTinSanPham = explode(' | ', $request->chiTietPhieuNhap[$i]);
                        if (empty($thongTinSanPham[0]) || empty($thongTinSanPham[1])) { // thong tin san pham nhap vao sai cu phap quay lai trang truoc va bao loi
                            return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Thông tin sản phẩm không tồn tại, vui lòng nhập lại!')->with('loaithongbao', 'danger');
                        }
                        $maSanPham = explode('SP', $thongTinSanPham[0]);
                        $maSanPham = $maSanPham[1];
                        $tenSanPham = $thongTinSanPham[1];
                        if (!is_numeric($maSanPham)) { // ma san pham nhap vao khong phai ky tu so quay lai trang truoc va bao loi
                            return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Thông tin sản phẩm không tồn tại, vui lòng nhập lại!')->with('loaithongbao', 'danger');
                        }
                        $thongTinSanPham = $this->sanPham->timSanPhamTheoMa($maSanPham);
                        if (empty($thongTinSanPham)) { // khong tim thay san pham tren database quay lai trang truoc va bao loi
                            return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Thông tin sản phẩm không tồn tại, vui lòng nhập lại!')->with('loaithongbao', 'danger');
                        }
                        if ($tenSanPham != $thongTinSanPham->tensanpham) { // thong tin san pham khong khop va bao loi
                            return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Thông tin sản phẩm không tồn tại, vui lòng nhập lại!')->with('loaithongbao', 'danger');
                        }
                        $soLuongNhap = $request->soLuong[$i];
                        $donGiaNhap = explode(',', $request->donGia[$i]);
                        $temp = "";
                        foreach ($donGiaNhap as $dgn) {
                            $temp = $temp . $dgn;
                        }
                        $donGiaNhap = $temp;
                        if (!is_numeric($donGiaNhap)) { // so tien don gia nhap vao khong phai ky tu so quay lai trang truoc va bao loi
                            return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Số tiền đơn giá nhập sai, vui lòng nhập lại!')->with('loaithongbao', 'danger');
                        }

                        $dataChiTietPhieuNhap = [
                            NULL, //machitietphieunhap tu dong
                            $thongTinPhieuNhap->maphieunhap,
                            $thongTinSanPham->masanpham,
                            $soLuongNhap,
                            $donGiaNhap
                        ];
                        $this->chiTietPhieuNhap->themChiTietPhieuNhap($dataChiTietPhieuNhap); //them chi tiet phieu nhap vao database
                        // Xu ly so luong va gia san pham
                        $giaNhap = 0;
                        if ($thongTinSanPham->gianhap > $donGiaNhap) { //gia nhap moi cu hon gia nhap moi thi lay gia nhap cu
                            $giaNhap = $thongTinSanPham->gianhap;
                        } else {
                            $giaNhap = $donGiaNhap;
                        }

                        $giaBan = 0;
                        if ($giaNhap >= $thongTinSanPham->giaban) { //gia nhap lon hon gia ban cu sua lai gia ban moi bang gia nhap + them loi 30% tren gia nhap
                            $giaBan = $giaNhap * (1 + 30 / 100);
                        } else {
                            $giaBan = $thongTinSanPham->giaban;
                        }

                        $giaKhuyenMai = NULL;
                        if (!empty($thongTinSanPham->giakhuyenmai)) {
                            if ($giaNhap >= $thongTinSanPham->giakhuyenmai) { //gia nhap lon hon gia khuyen mai cu sua lai bo luon gia khuyen mai
                                $giaKhuyenMai = NULL;
                            } else {
                                $giaKhuyenMai = $thongTinSanPham->giakhuyenmai;
                            }
                        }
                        $dataSanPham = [
                            $thongTinSanPham->soluong + $soLuongNhap, //them so luong vua nhap vao ton kho
                            $giaNhap,
                            $giaBan,
                            $giaKhuyenMai
                        ];
                        $this->sanPham->nhapHang($dataSanPham, $thongTinSanPham->masanpham); //them so luong ton kho va chinh gia database
                    }
                }
            }
            if (!empty($danhSachChiTietPhieuNhap)) {
                foreach ($danhSachChiTietPhieuNhap as $ctpn) {
                    $thongTinSanPham = $this->sanPham->timSanPhamTheoMa($ctpn->masanpham); //tim san pham can chinh so luong
                    if (!empty($thongTinSanPham)) {
                        $dataSanPham = [
                            $thongTinSanPham->soluong - $ctpn->soluong
                        ];
                        $this->sanPham->suaSoLuong($dataSanPham, $thongTinSanPham->masanpham); //chinh so luong ton kho san pham tren database
                        $this->chiTietPhieuNhap->xoaChiTietPhieuNhap($ctpn->machitietphieunhap); //xoa chi tiet phieu nhap tren database
                    }
                }
            }
            return redirect()->route('phieunhap')->with('tieudethongbao', 'Thao tác thành công')->with('thongbao', 'Sửa thông tin phiếu nhập thành công')->with('loaithongbao', 'success');
        }
        if ($request->thaoTac == "thêm phiếu nhập") { // *******************************************************************************************them phieu nhap
            $rules = [
                'chiTietPhieuNhap' => 'array',
                'chiTietPhieuNhap.*' => 'required|string|max:255|min:3',
                'soLuong' => 'array',
                'soLuong.*' => 'required|integer',
                'donGia' => 'array',
                'donGia.*' => 'required|string|max:255|min:1',
                'thongTinNguoiDung' => 'required|string|max:255|min:3',
                'ghiChu' => 'max:255',
                'tongTien' => 'required|numeric',
                'daThanhToan' => 'required|string|max:255|min:1'
            ];
            $messages = [
                'required' => ':attribute bắt buộc nhập',
                'string' => ':attribute nhập sai',
                'min' => ':attribute tối thiểu :min ký tự',
                'max' => ':attribute tối thiểu :max ký tự',
                'integer' => ':attribute nhập sai',
                'numeric' => ':attribute nhập sai',
                'array' => ':attribute nhập sai'
            ];
            $attributes = [
                'chiTietPhieuNhap' => 'Chi tiết phiếu nhập',
                'chiTietPhieuNhap.*' => 'Chi tiết phiếu nhập *',
                'soLuong' => 'Số lượng',
                'soLuong.*' => 'Số lượng *',
                'donGia' => 'Đơn giá',
                'donGia.*' => 'Đơn giá *',
                'thongTinNguoiDung' => 'Thông tin người dùng',
                'ghiChu' => 'Ghi chú',
                'tongTien' => 'Tổng tiền',
                'daThanhToan' => 'Đã thanh toán'
            ];
            $request->validate($rules, $messages, $attributes);
            // ***********Xu ly them phieu nhap
            $thongTinNguoiDung = explode(' | ', $request->thongTinNguoiDung);
            if (empty($thongTinNguoiDung[0]) || empty($thongTinNguoiDung[1]) || empty($thongTinNguoiDung[2])) { // thong tin nguoi dung nhap vao sai cu phap quay lai trang truoc va bao loi
                return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Thông tin người dùng không tồn tại, vui lòng nhập lại!')->with('loaithongbao', 'danger');
            }
            $maNguoiDung = explode('ND', $thongTinNguoiDung[0]);
            $maNguoiDung = $maNguoiDung[1];
            $hoTen = $thongTinNguoiDung[1];
            $soDienThoai = $thongTinNguoiDung[2];

            if (!is_numeric($maNguoiDung)) { // ma nguoi dung nhap vao khong phai ky tu so quay lai trang truoc va bao loi
                return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Thông tin người dùng không tồn tại, vui lòng nhập lại!')->with('loaithongbao', 'danger');
            }
            $thongTinNguoiDung = $this->nguoiDung->timNguoiDungTheoMa($maNguoiDung);
            if (empty($thongTinNguoiDung)) { // khong tim thay nguoi dung tren database quay lai trang truoc va bao loi
                return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Thông tin người dùng không tồn tại, vui lòng nhập lại!')->with('loaithongbao', 'danger');
            }
            if ($hoTen != $thongTinNguoiDung->hoten || $soDienThoai != $thongTinNguoiDung->sodienthoai) { // thong tin nguoi dung khong khop va bao loi
                return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Thông tin người dùng không tồn tại, vui lòng nhập lại!')->with('loaithongbao', 'danger');
            }
            if ($thongTinNguoiDung->trangthai == 0) { // thong tin nguoi dung dang bi khoa
                return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Trạng thái người dùng đang bị khóa, không thể thao tác!')->with('loaithongbao', 'danger');
            }
            $soTienDaThanhToan = explode(',', $request->daThanhToan);
            $temp = "";
            foreach ($soTienDaThanhToan as $stdtt) {
                $temp = $temp . $stdtt;
            }
            $soTienDaThanhToan = $temp;
            if (!is_numeric($soTienDaThanhToan)) { // so tien da thanh toan nhap vao khong phai ky tu so quay lai trang truoc va bao loi
                return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Số tiền đã thanh toán nhập sai, vui lòng nhập lại!')->with('loaithongbao', 'danger');
            }
            if ($soTienDaThanhToan == 0 && $request->tongTien == 0) { // phieu khong co gi nen khong lap va quay lai trang truoc va bao loi
                return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Số tiền đã thanh toán nhập sai, vui lòng nhập lại!')->with('loaithongbao', 'danger');
            }
            $congNo = $soTienDaThanhToan - $request->tongTien;
            $ngayTao = date("Y-m-d H:i:s");

            $dataPhieuNhap = [
                NULL, //maphieunhap tu dong
                $thongTinNguoiDung->manguoidung,
                $request->ghiChu,
                $request->tongTien,
                $congNo,
                $ngayTao
            ];
            $this->phieuNhap->themPhieuNhap($dataPhieuNhap); //them phieu nhap vao database
            $thongTinPhieuNhap = $this->phieuNhap->timPhieuNhapTheoNgayTao($ngayTao); //tim qua tang vua them
            // ***********Xu ly them chi tiet phieu nhap
            if (!empty($request->chiTietPhieuNhap)) {
                for ($i = 0; $i < count($request->chiTietPhieuNhap); $i++) {
                    if (!empty($request->chiTietPhieuNhap[$i]) && !empty($request->soLuong[$i]) && $request->donGia[$i] >= 0) {
                        $thongTinSanPham = explode(' | ', $request->chiTietPhieuNhap[$i]);
                        if (empty($thongTinSanPham[0]) || empty($thongTinSanPham[1])) { // thong tin san pham nhap vao sai cu phap quay lai trang truoc va bao loi
                            return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Thông tin sản phẩm không tồn tại, vui lòng nhập lại!')->with('loaithongbao', 'danger');
                        }
                        $maSanPham = explode('SP', $thongTinSanPham[0]);
                        $maSanPham = $maSanPham[1];
                        $tenSanPham = $thongTinSanPham[1];
                        if (!is_numeric($maSanPham)) { // ma san pham nhap vao khong phai ky tu so quay lai trang truoc va bao loi
                            return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Thông tin sản phẩm không tồn tại, vui lòng nhập lại!')->with('loaithongbao', 'danger');
                        }
                        $thongTinSanPham = $this->sanPham->timSanPhamTheoMa($maSanPham);
                        if (empty($thongTinSanPham)) { // khong tim thay san pham tren database quay lai trang truoc va bao loi
                            return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Thông tin sản phẩm không tồn tại, vui lòng nhập lại!')->with('loaithongbao', 'danger');
                        }
                        if ($tenSanPham != $thongTinSanPham->tensanpham) { // thong tin san pham khong khop va bao loi
                            return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Thông tin sản phẩm không tồn tại, vui lòng nhập lại!')->with('loaithongbao', 'danger');
                        }
                        $soLuongNhap = $request->soLuong[$i];
                        $donGiaNhap = explode(',', $request->donGia[$i]);
                        $temp = "";
                        foreach ($donGiaNhap as $dgn) {
                            $temp = $temp . $dgn;
                        }
                        $donGiaNhap = $temp;
                        if (!is_numeric($donGiaNhap)) { // so tien don gia nhap vao khong phai ky tu so quay lai trang truoc va bao loi
                            return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Số tiền đơn giá nhập sai, vui lòng nhập lại!')->with('loaithongbao', 'danger');
                        }
                        $dataChiTietPhieuNhap = [
                            NULL, //machitietphieunhap tu dong
                            $thongTinPhieuNhap->maphieunhap,
                            $thongTinSanPham->masanpham,
                            $soLuongNhap,
                            $donGiaNhap
                        ];
                        $this->chiTietPhieuNhap->themChiTietPhieuNhap($dataChiTietPhieuNhap); //them chi tiet phieu nhap vao database
                        // Xu ly so luong va gia san pham
                        $giaNhap = 0;
                        if ($thongTinSanPham->gianhap > $donGiaNhap) { //gia nhap moi cu hon gia nhap moi thi lay gia nhap cu
                            $giaNhap = $thongTinSanPham->gianhap;
                        } else {
                            $giaNhap = $donGiaNhap;
                        }

                        $giaBan = 0;
                        if ($giaNhap >= $thongTinSanPham->giaban) { //gia nhap lon hon gia ban cu sua lai gia ban moi bang gia nhap + them loi 30% tren gia nhap
                            $giaBan = $giaNhap * (1 + 30 / 100);
                        } else {
                            $giaBan = $thongTinSanPham->giaban;
                        }

                        $giaKhuyenMai = NULL;
                        if (!empty($thongTinSanPham->giakhuyenmai)) {
                            if ($giaNhap >= $thongTinSanPham->giakhuyenmai) { //gia nhap lon hon gia khuyen mai cu sua lai bo luon gia khuyen mai
                                $giaKhuyenMai = NULL;
                            } else {
                                $giaKhuyenMai = $thongTinSanPham->giakhuyenmai;
                            }
                        }
                        $dataSanPham = [
                            $thongTinSanPham->soluong + $soLuongNhap, //them so luong vua nhap vao ton kho
                            $giaNhap,
                            $giaBan,
                            $giaKhuyenMai
                        ];
                        $this->sanPham->nhapHang($dataSanPham, $thongTinSanPham->masanpham); //them so luong ton kho va chinh gia database
                    }
                }
            }
            return redirect()->route('phieunhap')->with('tieudethongbao', 'Thao tác thành công')->with('thongbao', 'Lập phiếu nhập thành công')->with('loaithongbao', 'success');
        }
        return back()->with(
            'tieudethongbao',
            'Thao tác thất bại'
        )->with(
            'thongbao',
            'Vui lòng thử lại!'
        )->with(
            'loaithongbao',
            'danger'
        );
    }
    public function themphieunhap()
    {
        if (!Auth::check() || Auth::user()->loainguoidung != 2) {
            return redirect()->route('dangnhap');
        }
        $danhSachSanPham = $this->sanPham->layDanhSachSanPham();
        $danhSachHangSanXuat = $this->hangSanXuat->layDanhSachHangSanXuat();
        $danhSachHangSanXuatLaptop = []; // loc lai danh sach theo loai hang san xuat laptop can xem
        $danhSachHangSanXuatPhuKien = [];
        foreach ($danhSachHangSanXuat as $hangSanXuat) {
            if ($hangSanXuat->loaihang == 0) {
                $danhSachHangSanXuatLaptop = array_merge($danhSachHangSanXuatLaptop, [$hangSanXuat]);
            }
            if ($hangSanXuat->loaihang == 1) {
                $danhSachHangSanXuatPhuKien = array_merge($danhSachHangSanXuatPhuKien, [$hangSanXuat]);
            }
        }

        $danhSachNguoiDung = $this->nguoiDung->layDanhSachNguoiDung();
        $danhSachNhaCungCap = []; // loc lai danh sach thong tin nha cung cap gom nguoi dung la khach hang hoac doi tac va co trang thai la dang hoat dong
        foreach ($danhSachNguoiDung as $nguoiDung) {
            if (($nguoiDung->loainguoidung == 0 || $nguoiDung->loainguoidung == 1) && $nguoiDung->trangthai == 1) {
                $danhSachNhaCungCap = array_merge($danhSachNhaCungCap, [$nguoiDung]);
            }
        }
        $danhSachPhieuXuatChoXacNhan = $this->phieuXuat->layDanhSachPhieuXuatTheoBoLoc([['phieuxuat.tinhtranggiaohang', '=', 1]]);
        $danhSachLoiPhanHoiChuaDoc = $this->loiPhanHoi->layDanhSachLoiPhanHoiTheoBoLoc([['loiphanhoi.trangthai', '=', 0]]);
        return view('admin.themphieunhap', compact(
            'danhSachSanPham',
            'danhSachHangSanXuatLaptop',
            'danhSachHangSanXuatPhuKien',
            'danhSachPhieuXuatChoXacNhan',
            'danhSachLoiPhanHoiChuaDoc',
            'danhSachNhaCungCap'
        ));
    }
    public function suaphieunhap(Request $request)
    {
        if (!Auth::check() || Auth::user()->loainguoidung != 2) {
            return redirect()->route('dangnhap');
        }
        $rules = [
            'id' => 'required|integer|exists:phieunhap,maphieunhap'
        ];
        $messages = [
            'required' => ':attribute bắt buộc nhập',
            'exists' => ':attribute không tồn tại',
            'integer' => ':attribute nhập sai'
        ];
        $attributes = [
            'id' => 'Mã phiếu nhập'
        ];
        $request->validate($rules, $messages, $attributes);
        $danhSachSanPham = $this->sanPham->layDanhSachSanPham();
        $danhSachHangSanXuat = $this->hangSanXuat->layDanhSachHangSanXuat();
        $danhSachHangSanXuatLaptop = []; // loc lai danh sach theo loai hang san xuat laptop can xem
        $danhSachHangSanXuatPhuKien = [];
        foreach ($danhSachHangSanXuat as $hangSanXuat) {
            if ($hangSanXuat->loaihang == 0) {
                $danhSachHangSanXuatLaptop = array_merge($danhSachHangSanXuatLaptop, [$hangSanXuat]);
            }
            if ($hangSanXuat->loaihang == 1) {
                $danhSachHangSanXuatPhuKien = array_merge($danhSachHangSanXuatPhuKien, [$hangSanXuat]);
            }
        }
        $danhSachNguoiDung = $this->nguoiDung->layDanhSachNguoiDung();
        $danhSachNhaCungCap = []; // loc lai danh sach thong tin nha cung cap gom nguoi dung la khach hang hoac doi tac va co trang thai la dang hoat dong
        foreach ($danhSachNguoiDung as $nguoiDung) {
            if (($nguoiDung->loainguoidung == 0 || $nguoiDung->loainguoidung == 1) && $nguoiDung->trangthai == 1) {
                $danhSachNhaCungCap = array_merge($danhSachNhaCungCap, [$nguoiDung]);
            }
        }
        $phieuNhapCanXem = $this->phieuNhap->timPhieuNhapTheoMa($request->id);
        $nguoiDungCanXem = $this->nguoiDung->timNguoiDungTheoMa($phieuNhapCanXem->manguoidung);
        $danhSachChiTietPhieuNhapCanXem = $this->chiTietPhieuNhap->timDanhSachChiTietPhieuNhapTheoMaPhieuNhap($request->id);
        $danhSachPhieuXuatChoXacNhan = $this->phieuXuat->layDanhSachPhieuXuatTheoBoLoc([['phieuxuat.tinhtranggiaohang', '=', 1]]);
        $danhSachLoiPhanHoiChuaDoc = $this->loiPhanHoi->layDanhSachLoiPhanHoiTheoBoLoc([['loiphanhoi.trangthai', '=', 0]]);
        return view('admin.suaphieunhap', compact(
            'phieuNhapCanXem',
            'nguoiDungCanXem',
            'danhSachChiTietPhieuNhapCanXem',
            'danhSachSanPham',
            'danhSachHangSanXuatLaptop',
            'danhSachHangSanXuatPhuKien',
            'danhSachPhieuXuatChoXacNhan',
            'danhSachLoiPhanHoiChuaDoc',
            'danhSachNhaCungCap'
        ));
    }
    public function magiamgia()
    {
        if (!Auth::check() || Auth::user()->loainguoidung != 2) {
            return redirect()->route('dangnhap');
        }
        $danhSachMaGiamGia = $this->maGiamGia->layDanhSachMaGiamGia();
        $danhSachPhieuXuat = $this->phieuXuat->layDanhSachPhieuXuat();
        $danhSachPhieuXuatChoXacNhan = $this->phieuXuat->layDanhSachPhieuXuatTheoBoLoc([['phieuxuat.tinhtranggiaohang', '=', 1]]);
        $danhSachLoiPhanHoiChuaDoc = $this->loiPhanHoi->layDanhSachLoiPhanHoiTheoBoLoc([['loiphanhoi.trangthai', '=', 0]]);
        return view('admin.magiamgia', compact(
            'danhSachMaGiamGia',
            'danhSachPhieuXuat',
            'danhSachPhieuXuatChoXacNhan',
            'danhSachLoiPhanHoiChuaDoc'
        ));
    }
    public function xulymagiamgia(Request $request)
    {
        $request->validate(['thaoTac' => 'required|string']);
        if ($request->thaoTac == "sửa mã giảm giá") { // *******************************************************************************************sua ma giam gia
            $rules = [
                'maGiamGiaSua' => 'required|string|max:50|min:3|exists:giamgia,magiamgia',
                'ngayBatDauSua' => 'required|date_format:Y-m-d',
                'ngayKetThucSua' => 'required|date_format:Y-m-d|after_or_equal:' . $request->ngayBatDauSua,
                'moTaSua' => 'max:255'
            ];
            $messages = [
                'required' => ':attribute bắt buộc nhập',
                'string' => ':attribute đã nhập sai',
                'exists' => ':attribute không tồn tại',
                'min' => ':attribute tối thiểu :min ký tự',
                'max' => ':attribute tối đa :max ký tự',
                'date_format' => ':attribute không đúng định dạng ngày/tháng/năm',
                'ngayKetThucSua.after_or_equal' => 'Ngày kết thúc phải sau ' . date("d/m/Y", strtotime($request->ngayBatDauSua))
            ];
            $attributes = [
                'maGiamGiaSua' => 'Mã giảm giá',
                'ngayBatDauSua' => 'Ngày bắt đầu',
                'ngayKetThucSua' => 'Ngày kết thúc',
                'moTaSua' => 'Mô tả'
            ];
            $request->validate($rules, $messages, $attributes);
            $thongTinMaGiamGia = $this->maGiamGia->timMaGiamGiaTheoMa($request->maGiamGiaSua); //tim ma giam gia
            if ($thongTinMaGiamGia->mota != $request->moTaSua) { //so sanh mo ta
                $thongTinMaGiamGia->mota = $request->moTaSua;
            }
            if ($thongTinMaGiamGia->ngaybatdau != $request->ngayBatDauSua) { //so sanh ngay bat dau
                $thongTinMaGiamGia->ngaybatdau = $request->ngayBatDauSua;
            }
            if ($thongTinMaGiamGia->ngayketthuc != $request->ngayKetThucSua) { //so sanh ngay ket thuc
                $thongTinMaGiamGia->ngayketthuc = $request->ngayKetThucSua;
            }
            $dataMaGiamGia = [
                $thongTinMaGiamGia->mota,
                $thongTinMaGiamGia->ngaybatdau,
                $thongTinMaGiamGia->ngayketthuc
            ];
            if (isset($request->hetHanCheck)) {
                if ($request->hetHanCheck == "on") {
                    $dataMaGiamGia = [
                        $thongTinMaGiamGia->mota,
                        date("Y-m-d", strtotime('-2 days')), //hom kia
                        date("Y-m-d", strtotime('-1 days')) //hom qua
                    ];
                } else {
                    return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Thời gian áp dụng mã nhập sai, vui lòng nhập lại!')->with('loaithongbao', 'danger');
                }
            }
            $this->maGiamGia->suaMaGiamGia($dataMaGiamGia, $thongTinMaGiamGia->magiamgia); //sua ma giam gia tren database
            return back()->with(
                'tieudethongbao',
                'Thao tác thành công'
            )->with(
                'thongbao',
                'Sửa mã giảm giá thành công'
            )->with(
                'loaithongbao',
                'success'
            );
        }
        if ($request->thaoTac == "xóa mã giảm giá") { // *******************************************************************************************xoa ma giam gia
            $rules = [
                'maGiamGiaXoa' => 'required|string|max:50|min:3|exists:giamgia,magiamgia|unique:phieuxuat,magiamgia'
            ];
            $messages = [
                'required' => ':attribute bắt buộc nhập',
                'exists' => ':attribute không tồn tại',
                'min' => ':attribute tối thiểu :min ký tự',
                'max' => ':attribute tối đa :max ký tự',
                'unique' => ':attribute đã được áp dụng cho phiếu xuất',
                'string' => ':attribute đã nhập sai'
            ];
            $attributes = [
                'maGiamGiaXoa' => 'Mã giảm giá'
            ];
            $request->validate($rules, $messages, $attributes);
            $this->maGiamGia->xoaMaGiamGia($request->maGiamGiaXoa); //xoa ma giam gia tren database
            return back()->with(
                'tieudethongbao',
                'Thao tác thành công'
            )->with(
                'thongbao',
                'Thêm mã giảm giá thành công'
            )->with(
                'loaithongbao',
                'success'
            );
        }
        if ($request->thaoTac == "thêm mã giảm giá") { // *******************************************************************************************them ma giam gia
            $rules = [
                'maGiamGia' => 'required|string|max:50|min:3|unique:giamgia,magiamgia',
                'soTienGiam' => 'required|string|max:255|min:1',
                'ngayBatDau' => 'required|date_format:Y-m-d|after_or_equal:' . date("Y-m-d"),
                'ngayKetThuc' => 'required|date_format:Y-m-d|after_or_equal:' . $request->ngayBatDau,
                'moTa' => 'max:255'
            ];
            $messages = [
                'required' => ':attribute bắt buộc nhập',
                'string' => ':attribute đã nhập sai',
                'unique' => ':attribute đã tồn tại',
                'min' => ':attribute tối thiểu :min ký tự',
                'max' => ':attribute tối đa :max ký tự',
                'date_format' => ':attribute không đúng định dạng ngày/tháng/năm',
                'ngayBatDau.after_or_equal' => 'Ngày bắt đầu phải sau ' . date("d/m/Y"),
                'ngayKetThuc.after_or_equal' => 'Ngày kết thúc phải sau ' . date("d/m/Y", strtotime($request->ngayBatDau))
            ];
            $attributes = [
                'maGiamGia' => 'Mã giảm giá',
                'soTienGiam' => 'Số tiền giảm',
                'ngayBatDau' => 'Ngày bắt đầu',
                'ngayKetThuc' => 'Ngày kết thúc',
                'moTa' => 'Mô tả'
            ];
            $request->validate($rules, $messages, $attributes);
            $soTienGiam = explode(',', $request->soTienGiam);
            $temp = "";
            foreach ($soTienGiam as $stg) {
                $temp = $temp . $stg;
            }
            $soTienGiam = $temp;
            if (!is_numeric($soTienGiam)) { // so tien giam nhap vao sai dinh dang, quay lai trang truoc va bao loi
                return back()->with('tieudethongbao', 'Thao tác thất bại')->with('thongbao', 'Số tiền giảm nhập sai, vui lòng nhập lại!')->with('loaithongbao', 'danger');
            }
            $dataMaGiamGia = [
                $request->maGiamGia, //magiamgia
                $request->moTa,
                $soTienGiam,
                $request->ngayBatDau,
                $request->ngayKetThuc
            ];
            $this->maGiamGia->themMaGiamGia($dataMaGiamGia); //them ma giam gia vao database
            return back()->with(
                'tieudethongbao',
                'Thao tác thành công'
            )->with(
                'thongbao',
                'Thêm mã giảm giá thành công'
            )->with(
                'loaithongbao',
                'success'
            );
        }
        return back()->with(
            'tieudethongbao',
            'Thao tác thất bại'
        )->with(
            'thongbao',
            'Vui lòng thử lại!'
        )->with(
            'loaithongbao',
            'danger'
        );
    }
    public function nguoidung()
    {
        if (!Auth::check() || Auth::user()->loainguoidung != 2) {
            return redirect()->route('dangnhap');
        }
        $danhSachNguoiDung = $this->nguoiDung->layDanhSachNguoiDung();
        $danhSachPhieuXuatChoXacNhan = $this->phieuXuat->layDanhSachPhieuXuatTheoBoLoc([['phieuxuat.tinhtranggiaohang', '=', 1]]);
        $danhSachLoiPhanHoiChuaDoc = $this->loiPhanHoi->layDanhSachLoiPhanHoiTheoBoLoc([['loiphanhoi.trangthai', '=', 0]]);
        return view('admin.nguoidung', compact(
            'danhSachNguoiDung',
            'danhSachPhieuXuatChoXacNhan',
            'danhSachLoiPhanHoiChuaDoc'

        ));
    }
    public function xulynguoidung(Request $request)
    {
        $request->validate(['thaoTac' => 'required|string']);
        if ($request->thaoTac == "thêm người dùng") { // *******************************************************************************************them nguoi dung
            $rules = [
                'hoTen' => 'required|string|max:50|min:3',
                'soDienThoai' => 'required|numeric|digits:10|unique:nguoidung,sodienthoai',
                'diaChi' => 'required|string|max:255|min:3',
                'loaiNguoiDung' => 'required|integer|between:0,2'
            ];
            $messages = [
                'required' => ':attribute bắt buộc nhập',
                'string' => ':attribute đã nhập sai',
                'integer' => ':attribute đã nhập sai',
                'numeric' => ':attribute đã nhập sai',
                'unique' => ':attribute đã tồn tại',
                'min' => ':attribute tối thiểu :min ký tự',
                'max' => ':attribute tối đa :max ký tự',
                'between' => ':attribute vượt quá số lượng cho phép',
                'digits' => ':attribute không đúng :digits ký tự'
            ];
            $attributes = [
                'hoTen' => 'Họ tên',
                'soDienThoai' => 'Số điện thoại',
                'diaChi' => 'Địa chỉ',
                'loaiNguoiDung' => 'Loại người dùng'
            ];
            $request->validate($rules, $messages, $attributes);
            $ngayTao = date("Y-m-d H:i:s");
            $dataNguoiDung = [
                NULL, //manguoidung tu tang
                $request->hoTen,
                $request->soDienThoai,
                $request->diaChi,
                1, //trangthai 0 la bi khoa, 1 la dang hoat dong
                $request->loaiNguoiDung, //loainguoidung 0 là khách hàng, 1 là đối tác, 2 là nhân viên
                NULL, //email
                NULL, //matkhau
                $ngayTao
            ];
            if ($request->loaiNguoiDung == 2) {
                $rules = [
                    'email' => 'required|email|max:150|min:5|unique:nguoidung,email',
                    'matKhau' => 'required|string|max:32|min:8',
                    'nhapLaiMatKhau' => 'required|string|max:32|min:8|same:matKhau'
                ];
                $messages = [
                    'required' => ':attribute bắt buộc nhập',
                    'unique' => ':attribute đã tồn tại',
                    'string' => ':attribute đã nhập sai',
                    'email' => ':attribute không đúng định dạng email',
                    'min' => ':attribute tối thiểu :min ký tự',
                    'max' => ':attribute tối đa :max ký tự',
                    'same' => ':attribute không khớp với mật khẩu'
                ];
                $attributes = [
                    'email' => 'Email',
                    'matKhau' => 'Mật khẩu',
                    'nhapLaiMatKhau' => 'Nhập lại mật khẩu',
                ];
                $request->validate($rules, $messages, $attributes);
                $dataNguoiDung = [
                    NULL, //manguoidung tu tang
                    $request->hoTen,
                    $request->soDienThoai,
                    $request->diaChi,
                    1, //trangthai 0 la bi khoa, 1 la dang hoat dong
                    $request->loaiNguoiDung, //loainguoidung 0 là khách hàng, 1 là đối tác, 2 là nhân viên
                    $request->email,
                    bcrypt($request->matKhau),
                    $ngayTao
                ];
            }
            $this->nguoiDung->themNguoiDung($dataNguoiDung); //them nguoi dung vao database
            return back()->with(
                'tieudethongbao',
                'Thao tác thành công'
            )->with(
                'thongbao',
                'Thêm người dùng thành công'
            )->with(
                'loaithongbao',
                'success'
            );
        }
        if ($request->thaoTac == "đổi trạng thái người dùng") { // *******************************************************************************************doi trang thai nguoi dung
            $rules = [
                'maNguoiDungKhoa' => 'required|integer|exists:nguoidung,manguoidung',
            ];
            $messages = [
                'required' => ':attribute bắt buộc nhập',
                'exists' => ':attribute không tồn tại',
                'integer' => ':attribute nhập sai'
            ];
            $attributes = [
                'maNguoiDungKhoa' => 'Mã người dùng'
            ];
            $request->validate($rules, $messages, $attributes);
            $thongTinNguoiDung = $this->nguoiDung->timNguoiDungTheoMa($request->maNguoiDungKhoa); // tim người dùng
            // ***********Xu ly khoa nguoi dung
            if ($thongTinNguoiDung->trangthai == 0) { // so sánh trạng thái 0: bị khóa || 1: hoạt động
                $thongTinNguoiDung->trangthai = 1;
            } else if ($thongTinNguoiDung->trangthai == 1) {
                $danhSachPhieuXuat = $this->phieuXuat->layDanhSachPhieuXuatTheoBoLoc([['phieuxuat.manguoidung', '=', $thongTinNguoiDung->manguoidung]]);
                foreach ($danhSachPhieuXuat as $px) {
                    if ($px->tinhtranggiaohang > 0 && $px->tinhtranggiaohang < 4) { // 1 la cho xac nhan //2 la dang chuan bi hang //3 la dang giao hang
                        $dataPhieuXuat = [
                            0 //chuyen het lai thanh da huy
                        ];
                        $this->phieuXuat->doiTinhTrangGiaoHangPhieuXuat($dataPhieuXuat, $px->maphieuxuat); //doi tinh trang giao hang phieu xuat tren database
                    }
                }
                $thongTinNguoiDung->trangthai = 0;
            }
            $dataNguoiDung = [
                $thongTinNguoiDung->trangthai
            ];
            $this->nguoiDung->doiTrangThaiNguoiDung($dataNguoiDung, $thongTinNguoiDung->manguoidung);
            return back()->with(
                'tieudethongbao',
                'Thao tác thành công'
            )->with(
                'thongbao',
                'Đổi trạng thái người dùng thành công'
            )->with(
                'loaithongbao',
                'success'
            );
        }
        return back()->with(
            'tieudethongbao',
            'Thao tác thất bại'
        )->with(
            'thongbao',
            'Vui lòng thử lại!'
        )->with(
            'loaithongbao',
            'danger'
        );
    }
}
