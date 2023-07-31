<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ChiTietPhieuNhap extends Model
{
    use HasFactory;
    public function layDanhSachChiTietPhieuNhap()
    {
        $danhSachChiTietPhieuNhap = DB::select('SELECT * FROM chitietphieunhap ORDER BY machitietphieunhap DESC');
        return $danhSachChiTietPhieuNhap;
    }
    public function timDanhSachChiTietPhieuNhapTheoMaPhieuNhap($maphieunhap)
    {
        $danhSachChiTietPhieuNhap = DB::select('SELECT * FROM chitietphieunhap WHERE maphieunhap = ?', [$maphieunhap]);
        return $danhSachChiTietPhieuNhap;
    }
    public function timDanhSachChiTietPhieuNhapTheoMaSanPham($masanpham)
    {
        $danhSachChiTietPhieuNhap = DB::select('SELECT * FROM chitietphieunhap WHERE masanpham = ?', [$masanpham]);
        return $danhSachChiTietPhieuNhap;
    }
    public function xoaChiTietPhieuNhap($machitietphieunhap){
        return DB::select('DELETE FROM chitietphieunhap WHERE machitietphieunhap = ?',[$machitietphieunhap]);
    }
    public function themChiTietPhieuNhap($data)
    {
        return DB::insert('INSERT INTO chitietphieunhap (
            machitietphieunhap,
            maphieunhap,
            masanpham,
            soluong,
            dongia) values (
            ?,
            ?,
            ?,
            ?,
            ?)', $data);
    }
}
