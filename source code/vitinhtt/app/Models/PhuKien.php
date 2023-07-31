<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PhuKien extends Model
{
    use HasFactory;
    public function layDanhSachPhuKien(){
        $danhSachPhuKien = DB::select('SELECT * FROM phukien ORDER BY maphukien DESC');
        return $danhSachPhuKien;
    }
    public function timPhuKienTheoMa($maphukien){
        $phuKien = DB::select('SELECT * FROM phukien WHERE maphukien = ?',[$maphukien]);
        if(!empty($phuKien)){
            return $phuKien[0];
        }
        return $phuKien;
    }
    public function timPhuKienTheoTenSanPham($tenSanPham){
        $phuKien = DB::select('SELECT * FROM phukien WHERE tensanpham = ?',[$tenSanPham]);
        if(!empty($phuKien)){
            return $phuKien[0];
        }
        return $phuKien;
    }
    public function xoaPhuKien($maphukien){
        return DB::select('DELETE FROM phukien WHERE maphukien = ?',[$maphukien]);
    }
    public function suaPhuKien($data,$maphukien){
        $data = array_merge($data,[$maphukien]);
        return DB::select('UPDATE phukien SET
            tensanpham = ?,
            tenloaiphukien = ?
            WHERE maphukien = ?',$data);
    }
    public function themPhuKien($data){
        return DB::insert('INSERT INTO phukien (
            maphukien,
            tensanpham,
            tenloaiphukien) values (
            ?,
            ?,
            ?)', $data);
    }
}
