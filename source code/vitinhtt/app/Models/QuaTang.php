<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class QuaTang extends Model
{
    use HasFactory;
    public function layDanhSachQuaTang(){
        $danhSachQuaTang = DB::select('SELECT * FROM quatang ORDER BY maquatang DESC');
        return $danhSachQuaTang;
    }
    public function timQuaTangTheoMa($maquatang){
        $quaTang = DB::select('SELECT * FROM quatang WHERE maquatang = ?',[$maquatang]);
        if(!empty($quaTang)){
            return $quaTang[0];
        }
        return $quaTang;
    }
    public function timQuaTangTheoTenSanPham($tensanpham){
        $quaTang = DB::select('SELECT * FROM quatang WHERE tensanpham = ?',[$tensanpham]);
        if(!empty($quaTang)){
            return $quaTang[0];
        }
        return $quaTang;
    }
    public function xoaQuaTang($maquatang){
        return DB::select('DELETE FROM quatang WHERE maquatang = ?',[$maquatang]);
    }
    public function suaQuaTang($data,$maquatang){
        $data = array_merge($data,[$maquatang]);
        return DB::select('UPDATE quatang SET
            tensanpham = ?,
            masanpham1 = ?,
            masanpham2 = ?,
            masanpham3 = ?,
            masanpham4 = ?,
            masanpham5 = ?
            WHERE maquatang = ?',$data);
    }
    public function themQuaTang($data){
        return DB::insert('INSERT INTO quatang (
            maquatang,
            tensanpham,
            masanpham1,
            masanpham2,
            masanpham3,
            masanpham4,
            masanpham5) values (
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?)', $data);
    }
}
