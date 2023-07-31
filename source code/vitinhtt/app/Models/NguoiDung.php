<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class NguoiDung extends Model
{
    use HasFactory;
    public function layDanhSachNguoiDung()
    {
        $danhSachNguoiDung = DB::select('SELECT * FROM nguoidung ORDER BY manguoidung DESC');
        return $danhSachNguoiDung;
    }
    public function timNguoiDungTheoMa($manguoidung)
    {
        $nguoiDung = DB::select('SELECT * FROM nguoidung WHERE manguoidung = ?', [$manguoidung]);
        if (!empty($nguoiDung)) {
            return $nguoiDung[0];
        }
        return $nguoiDung;
    }
    public function timNguoiDungTheoSoDienThoai($sodienthoai)
    {
        $nguoiDung = DB::select('SELECT * FROM nguoidung WHERE sodienthoai = ?', [$sodienthoai]);
        if (!empty($nguoiDung)) {
            return $nguoiDung[0];
        }
        return $nguoiDung;
    }
    public function timNguoiDungTheoNgayTao($ngaytao)
    {
        $nguoiDung = DB::select('SELECT * FROM nguoidung WHERE ngaytao = ?', [$ngaytao]);
        if (!empty($nguoiDung)) {
            return $nguoiDung[0];
        }
        return $nguoiDung;
    }
    public function doiTrangThaiNguoiDung($data, $manguoidung)
    {
        $data = array_merge($data, [$manguoidung]);
        return DB::select('UPDATE nguoidung SET
        trangthai = ?
        WHERE manguoidung = ?', $data);
    }
    public function xoaNguoiDung($manguoidung)
    {
        return DB::select('DELETE FROM nguoidung WHERE manguoidung = ?', [$manguoidung]);
    }
    public function taoTaiKhoanNguoiDung($data, $manguoidung)
    {
        $data = array_merge($data, [$manguoidung]);
        return DB::select('UPDATE nguoidung SET
            email = ?,
            password = ?
            WHERE manguoidung = ?', $data);
    }
    public function suaNguoiDung($data, $manguoidung)
    {
        $data = array_merge($data, [$manguoidung]);
        return DB::select('UPDATE nguoidung SET
            hoten = ?,
            sodienthoai = ?,
            diachi = ?,
            loainguoidung = ?,
            email = ?,
            password = ?
            WHERE manguoidung = ?', $data);
    }
    public function themNguoiDung($data)
    {
        return DB::insert('INSERT INTO nguoidung (
            manguoidung,
            hoten,
            sodienthoai,
            diachi,
            trangthai,
            loainguoidung,
            email,
            password,
            ngaytao) values (
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
