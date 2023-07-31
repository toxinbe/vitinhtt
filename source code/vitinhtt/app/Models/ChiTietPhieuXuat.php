<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ChiTietPhieuXuat extends Model
{
    use HasFactory;
    public function layDanhSachChiTietPhieuXuat()
    {
        $danhSachChiTietPhieuXuat = DB::select('SELECT * FROM chitietphieuxuat ORDER BY machitietphieuxuat DESC');
        return $danhSachChiTietPhieuXuat;
    }
    public function timDanhSachChiTietPhieuXuatTheoMaPhieuXuat($maphieuxuat)
    {
        $danhSachChiTietPhieuXuat = DB::select('SELECT * FROM chitietphieuxuat WHERE maphieuxuat = ?', [$maphieuxuat]);
        return $danhSachChiTietPhieuXuat;
    }
    public function timDanhSachChiTietPhieuXuatTheoMaSanPham($masanpham)
    {
        $danhSachChiTietPhieuXuat = DB::select('SELECT * FROM chitietphieuxuat WHERE masanpham = ?', [$masanpham]);
        return $danhSachChiTietPhieuXuat;
    }
    public function xoaChiTietPhieuXuat($machitietphieuxuat){
        return DB::select('DELETE FROM chitietphieuxuat WHERE machitietphieuxuat = ?',[$machitietphieuxuat]);
    }
    public function themChiTietPhieuXuat($data)
    {
        return DB::insert('INSERT INTO chitietphieuxuat (
            machitietphieuxuat,
            maphieuxuat,
            masanpham,
            baohanh,
            soluong,
            dongia) values (
            ?,
            ?,
            ?,
            ?,
            ?,
            ?)', $data);
    }
}
