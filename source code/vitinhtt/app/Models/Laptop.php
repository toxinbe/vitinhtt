<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Laptop extends Model
{
    use HasFactory;
    public function layDanhSachLaptop(){
        $danhSachLaptop = DB::select('SELECT * FROM laptop ORDER BY malaptop DESC');
        return $danhSachLaptop;
    }
    public function timLaptopTheoMa($malaptop){
        $laptop = DB::select('SELECT * FROM laptop WHERE malaptop = ?',[$malaptop]);
        if(!empty($laptop)){
            return $laptop[0];
        }
        return $laptop;
    }
    public function timLaptopTheoTenSanPham($tenSanPham){
        $laptop = DB::select('SELECT * FROM laptop WHERE tensanpham = ?',[$tenSanPham]);
        if(!empty($laptop)){
            return $laptop[0];
        }
        return $laptop;
    }
    public function xoaLaptop($malaptop){
        return DB::select('DELETE FROM laptop WHERE malaptop = ?',[$malaptop]);
    }
    public function suaLaptop($data,$malaptop){
        $data = array_merge($data,[$malaptop]);
        return DB::select('UPDATE laptop SET
            tensanpham = ?,
            cpu = ?,
            ram = ?,
            carddohoa = ?,
            ocung = ?,
            manhinh = ?,
            nhucau = ?,
            tinhtrang = ?
            WHERE malaptop = ?',$data);
    }
    public function themLaptop($data){
        return DB::insert('INSERT INTO laptop (
            malaptop,
            tensanpham,
            cpu,
            ram,
            carddohoa,
            ocung,
            manhinh,
            nhucau,
            tinhtrang) values (
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?)', $data);
    }
}
