<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PhieuNhap extends Model
{
    use HasFactory;
    public function layDanhSachPhieuNhap(){
        $danhSachPhieuNhap = DB::select('SELECT * FROM phieunhap ORDER BY maphieunhap DESC');
        return $danhSachPhieuNhap;
    }
    public function timPhieuNhapTheoMa($maphieunhap){
        $phieuNhap = DB::select('SELECT * FROM phieunhap WHERE maphieunhap = ?',[$maphieunhap]);
        if(!empty($phieuNhap)){
            return $phieuNhap[0];
        }
        return $phieuNhap;
    }
    public function timPhieuNhapTheoNgayTao($ngaytao){
        $phieuNhap = DB::select('SELECT * FROM phieunhap WHERE ngaytao = ?',[$ngaytao]);
        if(!empty($phieuNhap)){
            return $phieuNhap[0];
        }
        return $phieuNhap;
    }
    public function xoaPhieuNhap($maphieunhap){
        return DB::select('DELETE FROM phieunhap WHERE maphieunhap = ?',[$maphieunhap]);
    }
    public function suaPhieuNhap($data,$maphieunhap){
        $data = array_merge($data,[$maphieunhap]);
        return DB::select('UPDATE phieunhap SET
            ghichu = ?,
            tongtien = ?,
            congno = ?
            WHERE maphieunhap = ?',$data);
    }
    public function themPhieuNhap($data){
        return DB::insert('INSERT INTO phieunhap (
            maphieunhap,
            manguoidung,
            ghichu,
            tongtien,
            congno,
            ngaytao) values (
            ?,
            ?,
            ?,
            ?,
            ?,
            ?)', $data);
    }
}
