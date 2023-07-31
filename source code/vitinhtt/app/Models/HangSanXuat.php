<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class HangSanXuat extends Model
{
    use HasFactory;
    public function layDanhSachHangSanXuat(){
        $danhSachHangSanXuat = DB::select('SELECT * FROM hangsanxuat ORDER BY mahang DESC');
        return $danhSachHangSanXuat;
    }
    public function timHangSanXuatTheoMa($mahang){
        $hangSanXuat = DB::select('SELECT * FROM hangsanxuat WHERE mahang = ?',[$mahang]);
        if(!empty($hangSanXuat)){
            return $hangSanXuat[0];
        }
        return $hangSanXuat;
    }
    public function timHangSanXuatTheoTen($tenhang){
        $hangSanXuat = DB::select('SELECT * FROM hangsanxuat WHERE tenhang = ?',[$tenhang]);
        if(!empty($hangSanXuat)){
            return $hangSanXuat[0];
        }
        return $hangSanXuat;
    }
    public function xoaHangSanXuat($mahang){
        return DB::select('DELETE FROM hangsanxuat WHERE mahang = ?',[$mahang]);
    }
    public function themHangSanXuat($data){
        return DB::insert('INSERT INTO hangsanxuat (
            mahang,
            tenhang,
            loaihang) values (
            ?,
            ?,
            ?)', $data);
    }
}
