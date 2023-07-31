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
use App\Models\PhieuXuat;
use App\Models\ChiTietPhieuXuat;
use App\Models\MaGiamGia;
use App\Models\LoiPhanHoi;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    private $sanPham;
    private $laptop;
    private $phuKien;
    private $thuVienHinh;
    private $hangSanXuat;
    private $quaTang;
    private $nguoiDung;
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
        $this->phieuXuat = new PhieuXuat();
        $this->chiTietPhieuXuat = new ChiTietPhieuXuat();
        $this->maGiamGia = new MaGiamGia();
        $this->loiPhanHoi = new LoiPhanHoi();
    }
    public function trangchu()
    {
        $danhSachSanPham = $this->sanPham->layDanhSachSanPham();
        $danhSachSanPhamMoiRaMat = $this->sanPham->layDanhSachSanPhamTheoBoLoc([], NULL, 'moinhat');
        $danhSachSanPhamBanChay = $this->sanPham->layDanhSachSanPhamTheoBoLoc([], NULL, 'banchaynhat');
        $danhSachSanPhamUuDai = $this->sanPham->layDanhSachSanPhamTheoBoLoc([], NULL, 'uudainhat');
        $danhSachThuVienHinh = $this->thuVienHinh->layDanhSachThuVienHinh();
        $danhSachHangSanXuat = $this->hangSanXuat->layDanhSachHangSanXuat();
        $danhSachLaptop = $this->laptop->layDanhSachLaptop();
        $danhSachSanPhamLaLaptop = [];
        $danhSachSanPhamLaPhuKien = [];
        $danhSachLaptopSinhVien = [];
        $danhSachLaptopDoHoa = [];
        $danhSachLaptopGaming = [];
        foreach ($danhSachSanPham as $sanpham) {
            if ($sanpham->loaisanpham == 1) { // la phu kien
                $danhSachSanPhamLaPhuKien = array_merge($danhSachSanPhamLaPhuKien, [$sanpham]);
            }
            if ($sanpham->loaisanpham == 0) { // la laptop
                $danhSachSanPhamLaLaptop = array_merge($danhSachSanPhamLaLaptop, [$sanpham]);
                $thongTinLaptop = $this->laptop->timLaptopTheoMa($sanpham->malaptop);
                if ($thongTinLaptop->nhucau == 'Sinh Viên') { // la laptop nhu cau la sinh vien
                    $danhSachLaptopSinhVien = array_merge($danhSachLaptopSinhVien, [$sanpham]);
                } elseif ($thongTinLaptop->nhucau == 'Đồ Họa') { // la laptop nhu cau la do hoa
                    $danhSachLaptopDoHoa = array_merge($danhSachLaptopDoHoa, [$sanpham]);
                } elseif ($thongTinLaptop->nhucau == 'Gaming') { // la laptop nhu cau la gaming
                    $danhSachLaptopGaming = array_merge($danhSachLaptopGaming, [$sanpham]);
                }
            }
        }
        return view('user.trangchu', compact(
            'danhSachSanPham',
            'danhSachSanPhamMoiRaMat',
            'danhSachSanPhamBanChay',
            'danhSachSanPhamUuDai',
            'danhSachThuVienHinh',
            'danhSachHangSanXuat',
            'danhSachLaptop',
            'danhSachLaptopSinhVien',
            'danhSachLaptopDoHoa',
            'danhSachLaptopGaming',
            'danhSachSanPhamLaLaptop',
            'danhSachSanPhamLaPhuKien'
        ));
    }
    public function chitietsp(Request $request)
    {
        $request->validate(['masp' => 'required|integer|exists:sanpham,masanpham']);
        $sanPhamXem = $this->sanPham->timSanPhamTheoMa($request->masp);
        $cauHinh = NULL;
        $thongTinPhuKien = NULL;
        if ($sanPhamXem->loaisanpham == 0 && !empty($sanPhamXem->malaptop)) { //la laptop
            $cauHinh = $this->laptop->timLaptopTheoMa($sanPhamXem->malaptop);
        } elseif ($sanPhamXem->loaisanpham == 1 && !empty($sanPhamXem->maphukien)) { //la phu kien
            $thongTinPhuKien = $this->phuKien->timPhuKienTheoMa($sanPhamXem->maphukien);
        }
        $thuVienHinhXem = $this->thuVienHinh->timThuVienHinhTheoMa($sanPhamXem->mathuvienhinh);
        $hangSanXuatXem = $this->hangSanXuat->timHangSanXuatTheoMa($sanPhamXem->mahang);
        $quaTangXem = $this->quaTang->timQuaTangTheoMa($sanPhamXem->maquatang);
        $danhSachSanPham = $this->sanPham->layDanhSachSanPham();
        $danhSachThuVienHinh = $this->thuVienHinh->layDanhSachThuVienHinh();
        $danhSachLaptop = $this->laptop->layDanhSachLaptop();
        $danhSachSanPhamTang = [];
        $flag = false;
        foreach ($quaTangXem as $giaTri) {
            if ($flag && !empty($giaTri)) {
                $sanPhamTang = $this->sanPham->timSanPhamTheoMa($giaTri);
                if (!empty($sanPhamTang)) {
                    $danhSachSanPhamTang = array_merge($danhSachSanPhamTang, [$sanPhamTang]);
                }
            }
            if (is_string($giaTri)) $flag = true;
        }
        $danhSachSanPhamTuongTu = [];
        $danhSachLaptopCu = [];
        foreach ($danhSachSanPham as $sanpham) {
            if ($sanpham->loaisanpham == $sanPhamXem->loaisanpham && $sanpham->masanpham != $sanPhamXem->masanpham) {
                $danhSachSanPhamTuongTu = array_merge($danhSachSanPhamTuongTu, [$sanpham]);
            }
            if ($sanpham->loaisanpham == 0 && $sanpham->masanpham != $sanPhamXem->masanpham) {
                $thongTinLaptop = $this->laptop->timLaptopTheoMa($sanpham->malaptop);
                if ($thongTinLaptop->tinhtrang == 1) { // la laptop cu
                    $danhSachLaptopCu = array_merge($danhSachLaptopCu, [$sanpham]);
                }
            }
        }
        $danhSachHangSanXuat = $this->hangSanXuat->layDanhSachHangSanXuat();
        return view('user.chitietsp', compact(
            'sanPhamXem',
            'cauHinh',
            'thongTinPhuKien',
            'thuVienHinhXem',
            'hangSanXuatXem',
            'danhSachHangSanXuat',
            'danhSachSanPhamTang',
            'danhSachSanPhamTuongTu',
            'danhSachThuVienHinh',
            'danhSachLaptopCu',
            'danhSachLaptop'
        ));
    }
    public function danhsachsp(Request $request)
    {
        $danhSachSanPham = $this->sanPham->layDanhSachSanPham();
        $danhSachLaptop = $this->laptop->layDanhSachLaptop();
        $danhSachThuVienHinh = $this->thuVienHinh->layDanhSachThuVienHinh();
        $danhSachHangSanXuat = $this->hangSanXuat->layDanhSachHangSanXuat();
        if (!empty($request->all())) {
            $boLoc = [];
            $Cpu = [];
            $Ram = [];
            $cardDoHoa = [];
            $oCung = [];
            $manHinh = [];
            $nhuCau = [];
            $tinhTrang = [];
            $mucGia = [];
            $tuKhoa = NULL;
            $sapXep = NULL;
            if (isset($request->loaisp) && $request->loaisp == 0) {
                $boLoc[] = ['sanpham.loaisanpham', '=', 0];
            }
            if (!empty($request->hangsx)) {
                $hangsx = explode(',', $request->hangsx);
                $boLoc[] = ['sanpham.mahang', $hangsx];
            }
            if (!empty($request->cpu)) {
                $cpu = explode(',', $request->cpu);
                if (in_array('intelcorei3', $cpu)) {
                    $Cpu[] = ['laptop.cpu', 'like', '%Intel Core i3%'];
                }
                if (in_array('intelcorei5', $cpu)) {
                    $Cpu[] = ['laptop.cpu', 'like', '%Intel Core i5%'];
                }
                if (in_array('intelcorei7', $cpu)) {
                    $Cpu[] = ['laptop.cpu', 'like', '%Intel Core i7%'];
                }
                if (in_array('amdryzen3', $cpu)) {
                    $Cpu[] = ['laptop.cpu', 'like', '%Amd Ryzen 3%'];
                }
                if (in_array('amdryzen5', $cpu)) {
                    $Cpu[] = ['laptop.cpu', 'like', '%Amd Ryzen 5%'];
                }
                if (in_array('amdryzen7', $cpu)) {
                    $Cpu[] = ['laptop.cpu', 'like', '%Amd Ryzen 7%'];
                }
            }
            if (!empty($request->ram)) {
                $ram = explode(',', $request->ram);
                if (in_array(4, $ram)) {
                    $Ram[] = ['laptop.ram', '=', 4];
                }
                if (in_array(8, $ram)) {
                    $Ram[] = ['laptop.ram', '=', 8];
                }
                if (in_array(16, $ram)) {
                    $Ram[] = ['laptop.ram', '=', 16];
                }
            }
            if (!empty($request->carddohoa)) {
                $carddohoa = explode(',', $request->carddohoa);
                if (in_array('onboard', $carddohoa)) {
                    $cardDoHoa[] = ['laptop.carddohoa', '=', 0];
                }
                if (in_array('nvidia', $carddohoa)) {
                    $cardDoHoa[] = ['laptop.carddohoa', '=', 1];
                }
                if (in_array('amd', $carddohoa)) {
                    $cardDoHoa[] = ['laptop.carddohoa', '=', 2];
                }
            }
            if (!empty($request->ocung)) {
                $ocung = explode(',', $request->ocung);
                if (in_array(128, $ocung)) {
                    $oCung[] = ['laptop.ocung', '=', 128];
                }
                if (in_array(256, $ocung)) {
                    $oCung[] = ['laptop.ocung', '=', 256];
                }
                if (in_array(512, $ocung)) {
                    $oCung[] = ['laptop.ocung', '=', 512];
                }
            }
            if (!empty($request->manhinh)) {
                $manhinh = explode(',', $request->manhinh);
                if (in_array(13, $manhinh)) {
                    $manHinh[] = [13, 13.9];
                }
                if (in_array(14, $manhinh)) {
                    $manHinh[] = [14, 14.9];
                }
                if (in_array(15, $manhinh)) {
                    $manHinh[] = [15, 16];
                }
            }
            if (!empty($request->nhucau)) {
                $nhucau = explode(',', $request->nhucau);
                if (in_array('sinhvien', $nhucau)) {
                    $nhuCau[] = ['laptop.nhucau', '=', 'Sinh Viên'];
                }
                if (in_array('dohoa', $nhucau)) {
                    $nhuCau[] = ['laptop.nhucau', '=', 'Đồ Họa'];
                }
                if (in_array('gaming', $nhucau)) {
                    $nhuCau[] = ['laptop.nhucau', '=', 'Gaming'];
                }
            }
            if (!empty($request->tinhtrang)) {
                $tinhtrang = explode(',', $request->tinhtrang);
                if (in_array('moi', $tinhtrang)) {
                    $tinhTrang[] = ['laptop.tinhtrang', '=', 0];
                }
                if (in_array('cu', $tinhtrang)) {
                    $tinhTrang[] = ['laptop.tinhtrang', '=', 1];
                }
            }
            if (!empty($request->mucgia)) {
                $mucgia = explode(',', $request->mucgia);
                if (in_array('duoi10', $mucgia)) {
                    $mucGia[] = [0, 10000000];
                }
                if (in_array('1015', $mucgia)) {
                    $mucGia[] = [10000000, 15000000];
                }
                if (in_array('1520', $mucgia)) {
                    $mucGia[] = [15000000, 20000000];
                }
                if (in_array('tren20', $mucgia)) {
                    $mucGia[] = [20000000, 2000000000];
                }
            }
            if (!empty($request->sapxep)) {
                $sapXep = $request->sapxep;
            }
            // $boLoc = [], $tuKhoa = NULL, $sapXep = NULL, $mucGia = [], $tinhTrang = [], $nhuCau = [], $manHinh = [], $oCung = [], $cardDoHoa = [], $Ram = [], $Cpu = []
            $danhSachSanPham = $this->sanPham->layDanhSachSanPhamTheoBoLoc($boLoc, $tuKhoa, $sapXep, $mucGia, $tinhTrang, $nhuCau, $manHinh, $oCung, $cardDoHoa, $Ram, $Cpu);
        }
        return view('user.danhsachsp', compact(
            'danhSachSanPham',
            'danhSachLaptop',
            'danhSachThuVienHinh',
            'danhSachHangSanXuat'
        ));
    }
    public function giohang()
    {
        if (empty(session('gioHang'))) return redirect()->route('/')->with('thongbao', 'Giỏ hàng chưa có sản phẩm!');
        $danhSachHangSanXuat = $this->hangSanXuat->layDanhSachHangSanXuat();
        return view('user.giohang', compact(
            'danhSachHangSanXuat'
        ));
    }
    public function xulygiohang(Request $request)
    {
        $request->validate(['thaoTac' => 'required|string']);
        if ($request->thaoTac == "áp dụng") { // *******************************************************************************************ap dung ma giam gia
            $rules = [
                'maGiamGia' => 'required|string|max:50|min:3|exists:giamgia,magiamgia'
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
                'maGiamGia' => 'Mã giảm giá'
            ];
            $request->validate($rules, $messages, $attributes);
            $thongTinMaGiamGia = $this->maGiamGia->timMaGiamGiaTheoMa($request->maGiamGia); //tim ma giam gia
            if (strtotime($thongTinMaGiamGia->ngayketthuc) - strtotime(date('Y-m-d')) >= 0) { //neu con han su dung
                session(['maGiamGia' => $thongTinMaGiamGia]);
                return back()->with('thongbao', 'Áp dụng mã giảm giá thành công!');
            } else {
                return back()->with('thongbao', 'Mã giảm giá đã hết hạn sử dụng');
            }
            return back()->with('thongbao', 'Áp dụng mã giảm giá thất bại!');
        }
        if ($request->thaoTac == "xóa giỏ hàng") { // *******************************************************************************************xoa gio hang
            $rules = [
                'maSanPhamMuaXoa' => 'required|integer|exists:sanpham,masanpham'
            ];
            $messages = [
                'required' => ':attribute bắt buộc nhập',
                'integer' => ':attribute đã nhập sai',
                'exists' => ':attribute không tồn tại'
            ];
            $attributes = [
                'maSanPhamMuaXoa' => 'Mã sản phẩm cần xóa'
            ];
            $request->validate($rules, $messages, $attributes);
            $gioHang = [];
            if (!empty(session('gioHang'))) {
                foreach (session('gioHang') as $ctgh) { // duyet qua gio hang cu
                    if ($request->maSanPhamMuaXoa != $ctgh['masanpham']) { // neu chi tiet gio hang khac voi san pham can xoa trong gio hang
                        $gioHang = array_merge($gioHang, [$ctgh]); // thi them chi tiet gio hang do vao gio
                    } // con neu chi tiet gio hang co ma san pham trung voi san pham can xoa trong gio hang thi khong dc them vao gio hang moi
                }
            }
            session(['gioHang' => $gioHang]); //thay gio hang cu bang gio hang moi
            if (empty(session('gioHang'))) {
                session()->forget('maGiamGia');
                session()->forget('gioHang');
            }
            return back()->with('thongbao', 'Xóa sản phẩm SP' . $request->maSanPhamMuaXoa . ' khỏi giỏ hàng thành công!');
        }
        if ($request->thaoTac == "cập nhật") { // *******************************************************************************************sua gio hang
            $rules = [
                'soLuongMuaSua' => 'required|array',
                'soLuongMuaSua.*' => 'required|integer'
            ];
            $messages = [
                'required' => ':attribute bắt buộc nhập',
                'integer' => ':attribute đã nhập sai',
                'array' => ':attribute nhập sai'
            ];
            $attributes = [
                'soLuongMuaSua' => 'Số lượng mua',
                'soLuongMuaSua.*' => 'Số lượng mua'
            ];
            $request->validate($rules, $messages, $attributes);
            $gioHang = [];
            if (!empty(session('gioHang'))) {
                foreach (session('gioHang') as $ctgh) {
                    $soLuongMuaMoi = $request->soLuongMuaSua[$ctgh['masanpham']];
                    if ($soLuongMuaMoi > 0) {
                        $ctgh['soluongmua'] = $soLuongMuaMoi;
                        $gioHang = array_merge($gioHang, [$ctgh]); // neu so luong chinh sua gio hang lon hon 0 thi so luong mua trong gio hang thay bang so luong mua moi vua sua
                    }
                }
            }
            session(['gioHang' => $gioHang]);
            if (empty(session('gioHang'))) {
                session()->forget('maGiamGia');
                session()->forget('gioHang');
            }
            return back()->with('thongbao', 'Cập nhật giỏ hàng thành công!');
        }
        if ($request->thaoTac == "thêm giỏ hàng") { // *******************************************************************************************them gio hang
            $rules = [
                'maSanPhamMua' => 'required|integer|exists:sanpham,masanpham',
                'soLuongMua' => 'required|integer'
            ];
            $messages = [
                'required' => ':attribute bắt buộc nhập',
                'exists' => ':attribute không tồn tại',
                'integer' => ':attribute đã nhập sai'
            ];
            $attributes = [
                'maSanPhamMua' => 'Mã sản phẩm',
                'soLuongMua' => 'Số lượng mua'
            ];
            $request->validate($rules, $messages, $attributes);
            $soLuongMua = $request->soLuongMua;
            $thongTinSanPhamMua = $this->sanPham->timSanPhamTheoMa($request->maSanPhamMua); //tim san pham da them vao gio hang
            if (!empty($thongTinSanPhamMua)) { //neu tim thay
                if (($thongTinSanPhamMua->giaban <= 0)) { //san pham chua nhap
                    return back()->with('thongbao', 'Liên hệ 090.xxx.xnxx (Mr.Tiến) để nhận được giá cụ thể nhất!');
                }
            }
            $thongTinHinh = $this->thuVienHinh->timThuVienHinhTheoMa($thongTinSanPhamMua->mathuvienhinh); //tim hinh san pham da them vao gio hang
            $thongTinQuaTang = $this->quaTang->timQuaTangTheoMa($thongTinSanPhamMua->maquatang); //tim qua tang cua san pham da them vao gio hang
            $danhSachSanPhamTang = [];
            $flag = false;
            foreach ($thongTinQuaTang as $giaTri) {
                if ($flag && !empty($giaTri)) {
                    $sanPhamTang = $this->sanPham->timSanPhamTheoMa($giaTri);
                    if (!empty($sanPhamTang)) {
                        $danhSachSanPhamTang = array_merge($danhSachSanPhamTang, [$sanPhamTang]);
                    }
                }
                if (is_string($giaTri)) $flag = true;
            }
            if (!empty($thongTinSanPhamMua) && !empty($thongTinHinh)) {
                $chiTietGioHang = [
                    'masanpham' => $thongTinSanPhamMua->masanpham,
                    'tensanpham' => $thongTinSanPhamMua->tensanpham,
                    'baohanh' => $thongTinSanPhamMua->baohanh,
                    'giaban' => $thongTinSanPhamMua->giaban,
                    'giakhuyenmai' => $thongTinSanPhamMua->giakhuyenmai,
                    'hinh' => $thongTinHinh->hinh1,
                    'quatang' => $danhSachSanPhamTang,
                    'soluongmua' => $soLuongMua
                ];
                $gioHang = [];
                $flag = false;
                if (!empty(session('gioHang'))) {
                    foreach (session('gioHang') as $ctgh) {
                        if ($ctgh['masanpham'] == $chiTietGioHang['masanpham']) { // tim xem chi tiet gio hang vua them co san trong gio hang chua
                            $ctgh['soluongmua'] += $chiTietGioHang['soluongmua']; // neu co thi tang so luong mua
                            $flag = true; // chi tiet gio hang nay da dc them vao gio hang bien co se duoc bat len de khoi phai them vao lan nua
                        }
                        $gioHang = array_merge($gioHang, [$ctgh]);
                    }
                }
                if (!$flag) { // bien co chua bat thi la san pham nay chua co trong gio hang va them vao thanh chi tiet gio hang moi
                    $gioHang = array_merge($gioHang, [$chiTietGioHang]);
                }
                session(['gioHang' => $gioHang]);
                return back()->with('thongbao', 'Thêm giỏ hàng thành công!');
            }
        }
        return redirect()->route('/')->with('thongbao', 'Thao tác thất bại vui lòng thử lại!');
    }
    public function baohanh()
    {
        $danhSachHangSanXuat = $this->hangSanXuat->layDanhSachHangSanXuat();
        return view('user.baohanh', compact(
            'danhSachHangSanXuat'
        ));
    }
    public function tragop(Request $request)
    {
        session()->flush();
        return back();
    }
    public function lienhe()
    {
        $danhSachHangSanXuat = $this->hangSanXuat->layDanhSachHangSanXuat();
        return view('user.lienhe', compact(
            'danhSachHangSanXuat'
        ));
    }
    public function xulylienhe(Request $request)
    {
        $request->validate(['thaoTac' => 'required|string']);
        if ($request->thaoTac == "gửi lời nhắn") { // *******************************************************************************************gui loi nhan
            $rules = [
                'hoTen' => 'required|string|max:50|min:3',
                'soDienThoai' => 'required|numeric|digits:10',
                'diaChi' => 'required|string|max:255|min:3',
                'noiDung' => 'required|string|max:255|min:3'
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
                'hoTen' => 'Họ tên',
                'soDienThoai' => 'Số điện thoại',
                'diaChi' => 'Địa chỉ',
                'noiDung' => 'Nội dung'
            ];
            $request->validate($rules, $messages, $attributes);
            $ngayTao = date("Y-m-d H:i:s");
            $thongTinNguoiDung = $this->nguoiDung->timNguoiDungTheoSoDienThoai($request->soDienThoai); //tim nguoi dung da ton tai hay chua
            if (!empty($thongTinNguoiDung)) { //neu tim thay
                if ($thongTinNguoiDung->trangthai == 0) { //neu nguoi dung dang bi khoa
                    return back()->with('thongbao', 'Thông tin người dùng hiện đang bị tạm khóa do hủy quá nhiều đơn!');
                }
                $dataNguoiDung = [
                    $request->hoTen,
                    $thongTinNguoiDung->sodienthoai,
                    $request->diaChi,
                    $thongTinNguoiDung->loainguoidung, //loainguoidung 0 là khách hàng, 1 là đối tác, 2 là nhân viên
                    $thongTinNguoiDung->email,
                    $thongTinNguoiDung->password
                ];
                $this->nguoiDung->suaNguoiDung($dataNguoiDung, $thongTinNguoiDung->manguoidung); //sua lai thong tin nguoi dung
            } else {
                $dataNguoiDung = [
                    NULL, //manguoidung tu tang
                    $request->hoTen,
                    $request->soDienThoai,
                    $request->diaChi,
                    1, //trangthai 0 la bi khoa, 1 la dang hoat dong
                    0, //loainguoidung 0 là khách hàng, 1 là đối tác, 2 là nhân viên
                    NULL, //email
                    NULL, //matkhau
                    $ngayTao
                ];
                $this->nguoiDung->themNguoiDung($dataNguoiDung); //them nguoi dung vao database
                $thongTinNguoiDung = $this->nguoiDung->timNguoiDungTheoNgayTao($ngayTao); //tim nguoi dung vua them
            }
            $dataLoiPhanHoi = [
                $request->noiDung, //noidung,
                0, //trangthai, 0 la chua doc // 1 la da doc
                $thongTinNguoiDung->manguoidung, //manguoidung,
                $ngayTao //ngaytao
            ];
            $this->loiPhanHoi->themLoiPhanHoi($dataLoiPhanHoi); //them loi phan hoi vao database
            return redirect()->route('/')->with('thongbao', 'Gửi lời nhắn thành công, sẽ có nhân viên liên hệ bạn sớm nhất có thể!');
        }
        return redirect()->route('/')->with('thongbao', 'Thao tác thất bại vui lòng thử lại!');
    }
    public function dangnhap()
    {
        if (Auth::check()) {
            if (Auth::user()->loainguoidung == 2) {
                return redirect()->route('tongquan');
            }
            return redirect()->route('taikhoan');
        }
        $danhSachHangSanXuat = $this->hangSanXuat->layDanhSachHangSanXuat();
        return view('user.dangnhap', compact(
            'danhSachHangSanXuat'
        ));
    }
    public function taikhoan()
    {
        if (!Auth::check()) {
            return redirect()->route('dangnhap');
        }
        $danhSachPhieuXuat = $this->phieuXuat->layDanhSachPhieuXuatTheoBoLoc([['manguoidung', '=', Auth::user()->manguoidung]]);
        $danhSachSanPham = $this->sanPham->layDanhSachSanPham();
        $danhSachMaGiamGia = $this->maGiamGia->layDanhSachMaGiamGia();
        $danhSachThuVienHinh = $this->thuVienHinh->layDanhSachThuVienHinh();
        $danhSachChiTietPhieuXuat = $this->chiTietPhieuXuat->layDanhSachChiTietPhieuXuat();
        $danhSachHangSanXuat = $this->hangSanXuat->layDanhSachHangSanXuat();
        return view('user.taikhoan', compact(
            'danhSachPhieuXuat',
            'danhSachSanPham',
            'danhSachMaGiamGia',
            'danhSachThuVienHinh',
            'danhSachHangSanXuat',
            'danhSachChiTietPhieuXuat'
        ));
    }
    public function dangxuat()
    {
        if (Auth::check()) {
            Auth::logout();
        }
        return back();
    }
    public function xulytaikhoan(Request $request)
    {
        $request->validate(['thaoTac' => 'required|string']);
        if ($request->thaoTac == "đổi thông tin") { // *******************************************************************************************doi thong tin giao hang
            $rules = [
                'email' => 'required|email|max:150|min:5|exists:nguoidung,email',
                'hoTen' => 'required|string|max:50|min:3',
                'soDienThoai' => 'required|numeric|digits:10',
                'diaChi' => 'required|string|max:255|min:3'
            ];
            $messages = [
                'required' => ':attribute bắt buộc nhập',
                'string' => ':attribute đã nhập sai',
                'min' => ':attribute tối thiểu :min ký tự',
                'max' => ':attribute tối đa :max ký tự',
                'exists' => ':attribute không tồn tại',
                'digits' => ':attribute không đúng :digits ký tự',
                'email' => ':attribute không đúng định dạng email'
            ];
            $attributes = [
                'email' => 'Email',
                'hoTen' => 'Họ tên',
                'soDienThoai' => 'Số điện thoại',
                'diaChi' => 'Địa chỉ'
            ];
            $request->validate($rules, $messages, $attributes);
            $thongTinNguoiDung = $this->nguoiDung->timNguoiDungTheoSoDienThoai($request->soDienThoai); //tim so dien thoai da ton tai hay chua
            if (!empty($thongTinNguoiDung) && $thongTinNguoiDung->email != $request->email) {
                return back()->with('loidoithongtin', 'Số điện thoại đã tồn tại.')->with('thongbao', 'Đổi thông tin thất bại.');
            }
            if (Auth::check()) {
                if ($request->email == Auth::user()->email) { //email dung voi tai khoan tren database
                    $dataNguoiDung = [
                        $request->hoTen,
                        $request->soDienThoai,
                        $request->diaChi,
                        Auth::user()->loainguoidung, //loainguoidung 0 là khách hàng, 1 là đối tác, 2 là nhân viên
                        Auth::user()->email,
                        Auth::user()->password
                    ];
                    $this->nguoiDung->suaNguoiDung($dataNguoiDung, Auth::user()->manguoidung); //sua lai thong tin nguoi dung
                    return back()->with('thongbao', 'Đổi thông tin thành công.');
                }
                return back()->with('loidoithongtin', 'Email không chính xác.')->with('thongbao', 'Đổi thông tin thất bại.');
            }
            return back()->with('loidoithongtin', 'Thông tin đăng nhập không hợp lệ.')->with('thongbao', 'Đổi thông tin thất bại.');
        }
        if ($request->thaoTac == "đổi mật khẩu") { // *******************************************************************************************doi mat khau
            $rules = [
                'email' => 'required|email|max:150|min:5|exists:nguoidung,email',
                'matKhauCu' => 'required|string|max:32|min:8',
                'matKhauMoi' => 'required|string|max:32|min:8',
                'nhapLaiMatKhauMoi' => 'required|string|max:32|min:8|same:matKhauMoi'
            ];
            $messages = [
                'required' => ':attribute bắt buộc nhập',
                'string' => ':attribute đã nhập sai',
                'min' => ':attribute tối thiểu :min ký tự',
                'max' => ':attribute tối đa :max ký tự',
                'exists' => ':attribute không tồn tại',
                'email' => ':attribute không đúng định dạng email',
                'same' => ':attribute không khớp với mật khẩu'
            ];
            $attributes = [
                'email' => 'Email',
                'matKhauCu' => 'Mật khẩu cũ',
                'matKhauMoi' => 'Mật khẩu mới',
                'nhapLaiMatKhauMoi' => 'Nhập lại mật khẩu mới'
            ];
            $request->validate($rules, $messages, $attributes);
            if ($request->matKhauCu == $request->matKhauMoi) {
                return back()->with('loidoimatkhau', 'Mật khẩu cũ và mật khẩu mới trùng nhau.')->with('thongbao', 'Đổi mật khẩu thất bại.');
            }
            if (Auth::check()) {
                if ($request->email == Auth::user()->email && Hash::check($request->matKhauCu, Auth::user()->password)) { //email va mat khau cu dung voi tai khoan tren database
                    $dataNguoiDung = [
                        Auth::user()->hoten,
                        Auth::user()->sodienthoai,
                        Auth::user()->diachi,
                        Auth::user()->loainguoidung, //loainguoidung 0 là khách hàng, 1 là đối tác, 2 là nhân viên
                        Auth::user()->email,
                        bcrypt($request->matKhauMoi)
                    ];
                    $this->nguoiDung->suaNguoiDung($dataNguoiDung, Auth::user()->manguoidung); //sua lai thong tin nguoi dung
                    return back()->with('thongbao', 'Đổi mật khẩu thành công.');
                }
                return back()->with('loidoimatkhau', 'Mật khẩu cũ không chính xác.')->with('thongbao', 'Đổi mật khẩu thất bại.');
            }
            return back()->with('loidoimatkhau', 'Thông tin đăng nhập không hợp lệ.')->with('thongbao', 'Đổi mật khẩu thất bại.');
        }
        if ($request->thaoTac == "đăng nhập") { // *******************************************************************************************dang nhap
            $rules = [
                'email' => 'required|email|max:150|min:5|exists:nguoidung,email',
                'matKhau' => 'required|string|max:32|min:8'
            ];
            $messages = [
                'required' => ':attribute bắt buộc nhập',
                'string' => ':attribute đã nhập sai',
                'min' => ':attribute tối thiểu :min ký tự',
                'max' => ':attribute tối đa :max ký tự',
                'exists' => ':attribute không tồn tại',
                'email' => ':attribute không đúng định dạng email',
            ];
            $attributes = [
                'email' => 'Email',
                'matKhau' => 'Mật khẩu'
            ];
            $request->validate($rules, $messages, $attributes);
            $dataNguoiDung = [
                'email' => $request->email,
                'password' => $request->matKhau
            ];
            if (Auth::attempt($dataNguoiDung)) {
                if (Auth::user()->trangthai == 0) { //neu tai khoan dang bi khoa
                    Auth::logout();
                    return back()->with('loidangnhap', 'Tài khoản hiện đang bị khóa.');
                }
                if (Auth::user()->loainguoidung == 2) { //neu tai khoan la nhan vien
                    return redirect()->route('tongquan')->with('hoTenNhanVien', Auth::user()->hoten);
                }
                return redirect()->back();
            }
            return back()->with('loidangnhap', 'Thông tin đăng nhập không hợp lệ.');
        }
        if ($request->thaoTac == "đăng ký") {  // *******************************************************************************************dang ky
            $rules = [
                'emailDangKy' => 'required|email|max:150|min:5|unique:nguoidung,email',
                'matKhauDangKy' => 'required|string|max:32|min:8',
                'nhapLaiMatKhauDangKy' => 'required|string|max:32|min:8|same:matKhauDangKy',
                'hoTen' => 'required|string|max:50|min:3',
                'soDienThoai' => 'required|numeric|digits:10',
                'diaChi' => 'required|string|max:255|min:3'
            ];
            $messages = [
                'required' => ':attribute bắt buộc nhập',
                'string' => ':attribute đã nhập sai',
                'numeric' => ':attribute đã nhập sai',
                'min' => ':attribute tối thiểu :min ký tự',
                'max' => ':attribute tối đa :max ký tự',
                'digits' => ':attribute không đúng :digits ký tự',
                'unique' => ':attribute đã tồn tại',
                'email' => ':attribute không đúng định dạng email',
                'same' => ':attribute không khớp với mật khẩu'
            ];
            $attributes = [
                'emailDangKy' => 'Email',
                'matKhauDangKy' => 'Mật khẩu',
                'nhapLaiMatKhauDangKy' => 'Nhập lại mật khẩu',
                'hoTen' => 'Họ tên',
                'soDienThoai' => 'Số điện thoại',
                'diaChi' => 'Địa chỉ'
            ];
            $request->validate($rules, $messages, $attributes);
            $thongTinNguoiDung = $this->nguoiDung->timNguoiDungTheoSoDienThoai($request->soDienThoai); //tim nguoi dung da ton tai hay chua
            if (!empty($thongTinNguoiDung)) { //neu tim thay
                if ($thongTinNguoiDung->trangthai == 0) { //neu nguoi dung dang bi khoa
                    return back()->with('loidangky', 'Số điện thoại hiện đang bị khóa.');
                }
                if (!empty($thongTinNguoiDung->email)) { //da co tai khoan nen khong the tao tai khoan moi
                    return back()->with('loidangky', 'Số điện thoại đã tồn tại.');
                } else { //chua co tai khoan thi tao tai khoan
                    $dataNguoiDung = [
                        $request->emailDangKy,
                        bcrypt($request->matKhauDangKy)
                    ];
                    $this->nguoiDung->taoTaiKhoanNguoiDung($dataNguoiDung, $thongTinNguoiDung->manguoidung); //tao tai khoan cho nguoi dung
                }
                $dataNguoiDung = [
                    $request->hoTen,
                    $thongTinNguoiDung->sodienthoai,
                    $request->diaChi,
                    $thongTinNguoiDung->loainguoidung, //loainguoidung 0 là khách hàng, 1 là đối tác, 2 là nhân viên
                    $thongTinNguoiDung->email,
                    $thongTinNguoiDung->password

                ];
                $this->nguoiDung->suaNguoiDung($dataNguoiDung, $thongTinNguoiDung->manguoidung); //sua lai thong tin nguoi dung
            } else {
                $ngayTao = date("Y-m-d H:i:s");
                $dataNguoiDung = [
                    NULL, //manguoidung tu tang
                    $request->hoTen,
                    $request->soDienThoai,
                    $request->diaChi,
                    1, //trangthai 0 la bi khoa, 1 la dang hoat dong
                    0, //loainguoidung 0 là khách hàng, 1 là đối tác, 2 là nhân viên
                    $request->emailDangKy,
                    bcrypt($request->matKhauDangKy),
                    $ngayTao
                ];
                $this->nguoiDung->themNguoiDung($dataNguoiDung); //them nguoi dung vao database
            }
            $dataNguoiDung = [
                'email' => $request->emailDangKy,
                'password' => $request->matKhauDangKy
            ];
            if (Auth::attempt($dataNguoiDung)) {
                return redirect()->route('taikhoan');
            }
        }
        return redirect()->route('/')->with('thongbao', 'Thao tác thất bại vui lòng thử lại!');
    }
    public function thanhtoan(Request $request)
    {
        if (empty(session('gioHang'))) return redirect()->route('giohang');
        if (isset($request->vnp_ResponseCode) && isset($request->vnp_TransactionStatus)) {// sau khi thanh toan vnpay thanh cong
            if ($request->vnp_ResponseCode == "00" && $request->vnp_TransactionStatus == "00") {
                $dataPhieuXuat = json_decode($request->vnp_OrderInfo);
                $dataPhieuXuat[10] += ($request->vnp_Amount / 100); // cong no
                // if (!empty($dataPhieuXuat[5])) {// ma giam gia dc ap dung
                //     $thongTinMaGiamGia = $this->maGiamGia->timMaGiamGiaTheoMa($dataPhieuXuat[5]); //tim ma giam gia
                //     if (!empty($thongTinMaGiamGia)) {
                //         if (strtotime($thongTinMaGiamGia->ngayketthuc) - strtotime(date('Y-m-d')) >= 0) { //neu con han su dung
                //             $dataPhieuXuat[10] -= $thongTinMaGiamGia->sotiengiam;
                //         } else {
                //             return back()->with('thongbao', 'Mã giảm giá đã hết hạn sử dụng!');
                //         }
                //     } else {
                //         return back()->with('thongbao', 'Mã giảm giá không tồn tại!');
                //     }
                // }
                // dd($dataPhieuXuat);
                $this->phieuXuat->themPhieuXuat($dataPhieuXuat); //them phieu xuat vao database
                $thongTinPhieuXuat = $this->phieuXuat->timPhieuXuatTheoNgayTao($dataPhieuXuat[11]); //tim phieu xuat vua them
                foreach (session('gioHang') as $ctgh) {
                    $donGia = $ctgh['giaban'];
                    if (!empty($ctgh['giakhuyenmai'])) {
                        $donGia = $ctgh['giakhuyenmai'];
                    }
                    if (!empty($ctgh['quatang'])) { // xem chi tiet gio hang san pham do co qua tang khong neu co qua tang xuat them chi tiet phieu xuat 0 dong
                        foreach ($ctgh['quatang'] as $thongTinSanPham) {
                            $dataChiTietPhieuXuat = [
                                NULL, //machitietphieuxuat  tu dong
                                $thongTinPhieuXuat->maphieuxuat,
                                $thongTinSanPham->masanpham,
                                $thongTinSanPham->baohanh,
                                $ctgh['soluongmua'], //so luong qua tang theo so luong mua cua san pham
                                0 //don gia qua tang la 0 dong
                            ];
                            $this->chiTietPhieuXuat->themChiTietPhieuXuat($dataChiTietPhieuXuat); //them chi tiet phieu xuat vao database
                        }
                    }
                    $dataChiTietPhieuXuat = [
                        NULL, //machitietphieuxuat  tu dong
                        $thongTinPhieuXuat->maphieuxuat,
                        $ctgh['masanpham'],
                        $ctgh['baohanh'],
                        $ctgh['soluongmua'],
                        $donGia
                    ];
                    $this->chiTietPhieuXuat->themChiTietPhieuXuat($dataChiTietPhieuXuat); //them chi tiet phieu xuat vao database
                }
                session()->forget('gioHang');
                return redirect()->route('/')->with('thongbao', 'Đặt hàng thành công, sẽ có nhân viên giao hàng cho bạn trong 24h tới!');
            }
            return redirect()->route('/')->with('thongbao', 'Thao tác thất bại vui lòng thử lại!');
        }
        $danhSachHangSanXuat = $this->hangSanXuat->layDanhSachHangSanXuat();
        return view('user.thanhtoan', compact(
            'danhSachHangSanXuat'
        ));
    }
    public function xulythanhtoan(Request $request)
    {
        if (empty(session('gioHang'))) return redirect()->route('giohang');
        $request->validate(['thaoTac' => 'required|string']);
        if ($request->thaoTac == "đặt hàng") { // *******************************************************************************************dat hang // thanh toan
            $rules = [
                'hoTen' => 'required|string|max:50|min:3',
                'soDienThoai' => 'required|numeric|digits:10',
                'diaChi' => 'required|string|max:255|min:3',
                'tongTien' => 'required|numeric',
                'hinhThucThanhToan' => 'required|integer|between:0,2',
                'ghiChu' => 'max:255'
            ];
            $messages = [
                'required' => ':attribute bắt buộc nhập',
                'string' => ':attribute đã nhập sai',
                'integer' => ':attribute đã nhập sai',
                'numeric' => ':attribute đã nhập sai',
                'min' => ':attribute tối thiểu :min ký tự',
                'max' => ':attribute tối đa :max ký tự',
                'between' => ':attribute vượt quá số lượng cho phép',
                'digits' => ':attribute không đúng :digits ký tự'
            ];
            $attributes = [
                'hoTen' => 'Họ tên',
                'soDienThoai' => 'Số điện thoại',
                'diaChi' => 'Địa chỉ',
                'tongTien' => 'Tổng tiền',
                'hinhThucThanhToan' => 'Hình thức thanh toán',
                'ghiChu' => 'Ghi chú'
            ];
            $request->validate($rules, $messages, $attributes);
            if (isset($request->taoTaiKhoan)) {
                if ($request->taoTaiKhoan == "on") {
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
                } else {
                    return back()->with('thongbao', 'Đặt hàng thất bại!');
                }
            }
            if (isset($request->thongTinNguoiNhanKhac)) {
                if ($request->thongTinNguoiNhanKhac == "on") {
                    $rules = [
                        'hoTen' => 'required|string|max:50|min:3',
                        'soDienThoai' => 'required|numeric|digits:10',
                        'diaChi' => 'required|string|max:255|min:3',
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
                        'hoTenNguoiNhan' => 'required|string|max:50|min:3',
                        'soDienThoaiNguoiNhan' => 'required|numeric|digits:10',
                        'diaChiNguoiNhan' => 'required|string|max:255|min:3',
                    ];
                    $request->validate($rules, $messages, $attributes);
                } else {
                    return back()->with('thongbao', 'Đặt hàng thất bại!');
                }
            }
            $ngayTao = date("Y-m-d H:i:s");
            $thongTinNguoiDung = $this->nguoiDung->timNguoiDungTheoSoDienThoai($request->soDienThoai); //tim nguoi dung da ton tai hay chua
            if (!empty($thongTinNguoiDung)) { //neu tim thay
                if ($thongTinNguoiDung->trangthai == 0) { //neu nguoi dung dang bi khoa
                    return back()->with('thongbao', 'Thông tin người đặt hiện đang bị tạm khóa do hủy quá nhiều đơn!');
                }
                if (isset($request->taoTaiKhoan)) {
                    if ($request->taoTaiKhoan == "on") {
                        if (!empty($thongTinNguoiDung->email)) { //da co tai khoan nen khong the tao tai khoan moi
                            return back()->with('thongbao', 'Thông tin người đặt đã có tài khoản nên không thể tạo tài khoản!');
                        } else { //chua co tai khoan thi tao tai khoan
                            $dataNguoiDung = [
                                $request->email,
                                bcrypt($request->matKhau)
                            ];
                            $this->nguoiDung->taoTaiKhoanNguoiDung($dataNguoiDung, $thongTinNguoiDung->manguoidung); //tao tai khoan cho nguoi dung
                            $thongTinNguoiDung = $this->nguoiDung->timNguoiDungTheoMa($thongTinNguoiDung->manguoidung);// cap nhat lai thong tin nguoi dung
                        }
                    }
                }
                $dataNguoiDung = [
                    $request->hoTen,
                    $thongTinNguoiDung->sodienthoai,
                    $request->diaChi,
                    $thongTinNguoiDung->loainguoidung, //loainguoidung 0 là khách hàng, 1 là đối tác, 2 là nhân viên
                    $thongTinNguoiDung->email,
                    $thongTinNguoiDung->password
                ];
                $this->nguoiDung->suaNguoiDung($dataNguoiDung, $thongTinNguoiDung->manguoidung); //sua lai thong tin nguoi dung
                $thongTinNguoiDung = $this->nguoiDung->timNguoiDungTheoMa($thongTinNguoiDung->manguoidung);// cap nhat lai thong tin nguoi dung
            } else {
                $dataNguoiDung = [
                    NULL, //manguoidung tu tang
                    $request->hoTen,
                    $request->soDienThoai,
                    $request->diaChi,
                    1, //trangthai 0 la bi khoa, 1 la dang hoat dong
                    0, //loainguoidung 0 là khách hàng, 1 là đối tác, 2 là nhân viên
                    NULL, //email
                    NULL, //matkhau
                    $ngayTao
                ];
                if (isset($request->taoTaiKhoan)) {
                    if ($request->taoTaiKhoan == "on") {
                        $dataNguoiDung = [
                            NULL, //manguoidung tu tang
                            $request->hoTen,
                            $request->soDienThoai,
                            $request->diaChi,
                            1, //trangthai 0 la bi khoa, 1 la dang hoat dong
                            0, //loainguoidung 0 là khách hàng, 1 là đối tác, 2 là nhân viên
                            $request->email,
                            bcrypt($request->matKhau),
                            $ngayTao
                        ];
                    }
                }
                $this->nguoiDung->themNguoiDung($dataNguoiDung); //them nguoi dung vao database
                $thongTinNguoiDung = $this->nguoiDung->timNguoiDungTheoNgayTao($ngayTao); //tim nguoi dung vua them
            }
            $congNo = - $request->tongTien;
            $maGiamGiaDuocApDung = NULL;
            if (!empty(session('maGiamGia'))) {
                $thongTinMaGiamGia = $this->maGiamGia->timMaGiamGiaTheoMa(session('maGiamGia')->magiamgia); //tim ma giam gia
                if (!empty($thongTinMaGiamGia)) {
                    if (strtotime($thongTinMaGiamGia->ngayketthuc) - strtotime(date('Y-m-d')) >= 0) { //neu con han su dung
                        $maGiamGiaDuocApDung = $thongTinMaGiamGia->magiamgia;
                        $congNo += $thongTinMaGiamGia->sotiengiam;
                        if ($congNo > 0) $congNo = 0;
                        session()->forget('maGiamGia');
                    } else {
                        return back()->with('thongbao', 'Mã giảm giá đã hết hạn sử dụng!');
                    }
                } else {
                    return back()->with('thongbao', 'Mã giảm giá không tồn tại!');
                }
            }
            $dataPhieuXuat = [
                NULL, //maphieuxuat tu dong
                $thongTinNguoiDung->hoten,    // hotennguoinhan,
                $thongTinNguoiDung->sodienthoai,    // sodienthoainguoinhan,
                $thongTinNguoiDung->diachi,    // diachinguoinhan,
                $thongTinNguoiDung->manguoidung,
                $maGiamGiaDuocApDung,    // magiamgia,
                $request->ghiChu,
                $request->tongTien,
                1,    // tinhtranggiaohang,  	0 là đã hủy, 1 là chờ xác nhận, 2 là đang chuẩn bị hàng, 3 là đang giao, 4 là đã giao thành công
                $request->hinhThucThanhToan,    // hinhthucthanhtoan,   0 là tiền mặt, 1 là chuyển khoản, 2 là atm qua vpn
                $congNo,    // congno, 0 là đã thanh toán, !=0 là công nợ
                $ngayTao    // ngaytao
            ];
            if (isset($request->thongTinNguoiNhanKhac)) {
                if ($request->thongTinNguoiNhanKhac == "on") {
                    $dataPhieuXuat = [
                        NULL, //maphieuxuat tu dong
                        $request->hoTenNguoiNhan,    // hotennguoinhan,
                        $request->soDienThoaiNguoiNhan,    // sodienthoainguoinhan,
                        $request->diaChiNguoiNhan,    // diachinguoinhan,
                        $thongTinNguoiDung->manguoidung,
                        $maGiamGiaDuocApDung,    // magiamgia,
                        $request->ghiChu,
                        $request->tongTien,
                        1,    // tinhtranggiaohang,  	0 là đã hủy, 1 là chờ xác nhận, 2 là đang chuẩn bị hàng, 3 là đang giao, 4 là đã giao thành công
                        $request->hinhThucThanhToan,    // hinhthucthanhtoan,   0 là tiền mặt, 1 là chuyển khoản, 2 là atm qua vpn
                        $congNo,    // congno, 0 là đã thanh toán, !=0 là công nợ
                        $ngayTao    // ngaytao
                    ];
                }
            }
            if ($request->hinhThucThanhToan == 2) {
                $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
                $vnp_Returnurl = url('thanhtoan') . "";
                $vnp_TmnCode = "HHZDYEDW"; //Mã website tại VNPAY
                $vnp_HashSecret = "XJICDMDJSFFIPHQFLAUQTGXVNBXJQATE"; //Chuỗi bí mật
                $vnp_TxnRef = time() . ""; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
                $vnp_OrderInfo = json_encode($dataPhieuXuat) . "";
                $vnp_OrderType = 'billpayment';
                $vnp_Amount = (- $congNo) * 100;
                $vnp_Locale = 'vn';
                $vnp_BankCode = 'NCB';
                $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
                $inputData = array(
                    "vnp_Version" => "2.1.0",
                    "vnp_TmnCode" => $vnp_TmnCode,
                    "vnp_Amount" => $vnp_Amount,
                    "vnp_Command" => "pay",
                    "vnp_CreateDate" => date('YmdHis'),
                    "vnp_CurrCode" => "VND",
                    "vnp_IpAddr" => $vnp_IpAddr,
                    "vnp_Locale" => $vnp_Locale,
                    "vnp_OrderInfo" => $vnp_OrderInfo,
                    "vnp_OrderType" => $vnp_OrderType,
                    "vnp_ReturnUrl" => $vnp_Returnurl,
                    "vnp_TxnRef" => $vnp_TxnRef
                );
                if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                    $inputData['vnp_BankCode'] = $vnp_BankCode;
                }
                if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
                    $inputData['vnp_Bill_State'] = $vnp_Bill_State;
                }
                ksort($inputData);
                $query = "";
                $i = 0;
                $hashdata = "";
                foreach ($inputData as $key => $value) {
                    if ($i == 1) {
                        $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                    } else {
                        $hashdata .= urlencode($key) . "=" . urlencode($value);
                        $i = 1;
                    }
                    $query .= urlencode($key) . "=" . urlencode($value) . '&';
                }
                $vnp_Url = $vnp_Url . "?" . $query;
                if (isset($vnp_HashSecret)) {
                    $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //
                    $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
                }
                $returnData = array(
                    'code' => '00', 'message' => 'success', 'data' => $vnp_Url
                );
                if ($request->thaoTac == "đặt hàng") {
                    return redirect()->to($vnp_Url);
                } else {
                    echo json_encode($returnData);
                }
            }
            $this->phieuXuat->themPhieuXuat($dataPhieuXuat); //them phieu xuat vao database
            $thongTinPhieuXuat = $this->phieuXuat->timPhieuXuatTheoNgayTao($ngayTao); //tim phieu xuat vua them
            foreach (session('gioHang') as $ctgh) {
                $donGia = $ctgh['giaban'];
                if (!empty($ctgh['giakhuyenmai'])) {
                    $donGia = $ctgh['giakhuyenmai'];
                }
                if (!empty($ctgh['quatang'])) { // xem chi tiet gio hang san pham do co qua tang khong neu co qua tang xuat them chi tiet phieu xuat 0 dong
                    foreach ($ctgh['quatang'] as $thongTinSanPham) {
                        $dataChiTietPhieuXuat = [
                            NULL, //machitietphieuxuat  tu dong
                            $thongTinPhieuXuat->maphieuxuat,
                            $thongTinSanPham->masanpham,
                            $thongTinSanPham->baohanh,
                            $ctgh['soluongmua'], //so luong qua tang theo so luong mua cua san pham
                            0 //don gia qua tang la 0 dong
                        ];
                        $this->chiTietPhieuXuat->themChiTietPhieuXuat($dataChiTietPhieuXuat); //them chi tiet phieu xuat vao database
                    }
                }
                $dataChiTietPhieuXuat = [
                    NULL, //machitietphieuxuat  tu dong
                    $thongTinPhieuXuat->maphieuxuat,
                    $ctgh['masanpham'],
                    $ctgh['baohanh'],
                    $ctgh['soluongmua'],
                    $donGia
                ];
                $this->chiTietPhieuXuat->themChiTietPhieuXuat($dataChiTietPhieuXuat); //them chi tiet phieu xuat vao database
            }
            session()->forget('gioHang');
            return redirect()->route('/')->with('thongbao', 'Đặt hàng thành công, sẽ có nhân viên liên hệ bạn để xác nhận trong 24h tới!');
        }
        return redirect()->route('/')->with('thongbao', 'Thao tác thất bại vui lòng thử lại!');
    }
    public function yeuthich()
    {
        if (empty(session('yeuThich'))) return redirect()->route('/')->with('thongbao', 'Danh sách yêu thích chưa có sản phẩm!');
        $danhSachHangSanXuat = $this->hangSanXuat->layDanhSachHangSanXuat();
        return view('user.yeuthich', compact(
            'danhSachHangSanXuat'
        ));
    }
    public function xulyyeuthich(Request $request)
    {
        $request->validate(['thaotac' => 'required|string']);
        if ($request->thaotac == "boyeuthich") { // *******************************************************************************************bo yeu thich
            $rules = [
                'masp' => 'required|integer|exists:sanpham,masanpham'
            ];
            $messages = [
                'required' => ':attribute bắt buộc nhập',
                'exists' => ':attribute không tồn tại',
                'integer' => ':attribute đã nhập sai'
            ];
            $attributes = [
                'masp' => 'Mã sản phẩm'
            ];
            $request->validate($rules, $messages, $attributes);
            $yeuThich = [];
            $flag = false;
            if (!empty(session('yeuThich'))) {
                foreach (session('yeuThich') as $ctyt) { // duyet qua gio hang cu
                    if ($request->masp == $ctyt['masanpham']) { //neu chi tiet gio hang co ma san pham trung voi san pham can xoa trong gio hang thi khong dc them vao gio hang moi
                        $flag = true;
                    } else {  //con neu chi tiet gio hang khac voi san pham can xoa trong gio hang
                        $yeuThich = array_merge($yeuThich, [$ctyt]); // thi them chi tiet gio hang do vao gio
                    }
                }
                if ($flag) {
                    session(['yeuThich' => $yeuThich]); //thay gio hang cu bang gio hang moi
                    return back()->with('thongbao', 'Bỏ yêu thích SP' . $request->masp . ' thành công!');
                }
            }
            if (empty(session('yeuThich'))) {
                session()->forget('yeuThich');
            }
            return back()->with('thongbao', 'Bỏ yêu thích SP' . $request->masp . ' thất bại!');
        }
        if ($request->thaotac == "yeuthich") { // *******************************************************************************************yeu thich
            $rules = [
                'masp' => 'required|integer|exists:sanpham,masanpham'
            ];
            $messages = [
                'required' => ':attribute bắt buộc nhập',
                'exists' => ':attribute không tồn tại',
                'integer' => ':attribute đã nhập sai'
            ];
            $attributes = [
                'masp' => 'Mã sản phẩm'
            ];
            $request->validate($rules, $messages, $attributes);
            $thongTinSanPham = $this->sanPham->timSanPhamTheoMa($request->masp); //tim san pham da them vao yeu thich
            $thongTinHinh = $this->thuVienHinh->timThuVienHinhTheoMa($thongTinSanPham->mathuvienhinh); //tim hinh san pham da them vao yeu thich
            if (!empty($thongTinSanPham) && !empty($thongTinHinh)) {
                $chiTietYeuThich = [
                    'masanpham' => $thongTinSanPham->masanpham,
                    'tensanpham' => $thongTinSanPham->tensanpham,
                    'giaban' => $thongTinSanPham->giaban,
                    'giakhuyenmai' => $thongTinSanPham->giakhuyenmai,
                    'soluongtonkho' => $thongTinSanPham->soluong,
                    'hinh' => $thongTinHinh->hinh1
                ];
                $yeuThich = [];
                if (!empty(session('yeuThich'))) {
                    foreach (session('yeuThich') as $ctyt) {
                        if ($ctyt['masanpham'] == $chiTietYeuThich['masanpham']) { // tim xem chi tiet gio hang vua them co san trong gio hang chua
                            return back()->with('thongbao', 'SP' . $request->masp . ' đã có trong danh sách yêu thích!');
                        }
                        $yeuThich = array_merge($yeuThich, [$ctyt]);
                    }
                }
                $yeuThich = array_merge($yeuThich, [$chiTietYeuThich]);
                session(['yeuThich' => $yeuThich]);
                return back()->with('thongbao', 'Yêu thích SP' . $request->masp . ' thành công!');
            }
        }
        return redirect()->route('/')->with('thongbao', 'Thao tác thất bại vui lòng thử lại!');
    }
    public function timkiem(Request $request)
    {
        $boLoc = [];
        $tuKhoa = NULL;
        $sapXep = NULL;
        if (!empty($request->boloc)) {
            if ($request->boloc == -1) { //laptop
                $boLoc[] = ['sanpham.loaisanpham', '=', 0];
            } else if ($request->boloc == -2) { //phukien
                $boLoc[] = ['sanpham.loaisanpham', '=', 1];
            } else if ($request->boloc != 0) { //mahang
                $boLoc[] = ['sanpham.mahang', '=', $request->boloc];
            }
        }
        if (!empty($request->tukhoa)) {
            $tuKhoa = $request->tukhoa;
        }
        if (!empty($request->sapxep)) {
            $sapXep = $request->sapxep;
        }
        $danhSachSanPham = $this->sanPham->layDanhSachSanPhamTheoBoLoc($boLoc, $tuKhoa, $sapXep);
        $danhSachLaptop = $this->laptop->layDanhSachLaptop();
        $danhSachThuVienHinh = $this->thuVienHinh->layDanhSachThuVienHinh();
        $danhSachHangSanXuat = $this->hangSanXuat->layDanhSachHangSanXuat();
        return view('user.timkiem', compact(
            'danhSachSanPham',
            'danhSachLaptop',
            'danhSachThuVienHinh',
            'danhSachHangSanXuat'
        ));
    }
}
