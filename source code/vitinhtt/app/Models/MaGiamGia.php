<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class MaGiamGia extends Model
{
    use HasFactory;
    public function layDanhSachMaGiamGia(){
        $danhSachMaGiamGia = DB::select('SELECT * FROM giamgia ORDER BY magiamgia DESC');
        return $danhSachMaGiamGia;
    }
    public function timMaGiamGiaTheoMa($magiamgia){
        $maGiamGia = DB::select('SELECT * FROM giamgia WHERE magiamgia = ?',[$magiamgia]);
        if(!empty($maGiamGia)){
            return $maGiamGia[0];
        }
        return $maGiamGia;
    }
    public function suaMaGiamGia($data,$magiamgia){
        $data = array_merge($data,[$magiamgia]);
        return DB::select('UPDATE giamgia SET
            mota = ?,
            ngaybatdau = ?,
            ngayketthuc = ?
            WHERE magiamgia = ?',$data);
    }
    public function xoaMaGiamGia($magiamgia){
        return DB::select('DELETE FROM giamgia WHERE magiamgia = ?',[$magiamgia]);
    }
    public function themMaGiamGia($data){
        return DB::insert('INSERT INTO giamgia (
            magiamgia,
            mota,
            sotiengiam,
            ngaybatdau,
            ngayketthuc) values (
            ?,
            ?,
            ?,
            ?,
            ?)', $data);
    }
}
