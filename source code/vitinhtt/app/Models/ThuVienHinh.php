<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ThuVienHinh extends Model
{
    use HasFactory;
    public function layDanhSachThuVienHinh(){
        $danhSachHinh = DB::select('SELECT * FROM thuvienhinh ORDER BY mathuvienhinh DESC');
        return $danhSachHinh;
    }
    public function timThuVienHinhTheoMa($mathuvienhinh){
        $thuVienHinh = DB::select('SELECT * FROM thuvienhinh WHERE mathuvienhinh = ?',[$mathuvienhinh]);
        if(!empty($thuVienHinh)){
            return $thuVienHinh[0];
        }
        return $thuVienHinh;
    }
    public function timThuVienHinhTheoTenSanPham($tenSanPham){
        $thuVienHinh = DB::select('SELECT * FROM thuvienhinh WHERE tensanpham = ?',[$tenSanPham]);
        if(!empty($thuVienHinh)){
            return $thuVienHinh[0];
        }
        return $thuVienHinh;
    }
    public function xoaThuVienHinh($mathuvienhinh){
        return DB::select('DELETE FROM thuvienhinh WHERE mathuvienhinh = ?',[$mathuvienhinh]);
    }
    public function suaThuVienHinh($data,$mathuvienhinh){
        $data = array_merge($data,[$mathuvienhinh]);

        return DB::select('UPDATE thuvienhinh SET
            tensanpham = ?,
            hinh1 = ?,
            hinh2 = ?,
            hinh3 = ?,
            hinh4 = ?,
            hinh5 = ?
            WHERE mathuvienhinh = ?',$data);
    }
    public function themThuVienHinh($data){
        return DB::insert('INSERT INTO thuvienhinh (
            mathuvienhinh,
            tensanpham,
            hinh1,
            hinh2,
            hinh3,
            hinh4,
            hinh5) values (
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?)', $data);
    }
}
