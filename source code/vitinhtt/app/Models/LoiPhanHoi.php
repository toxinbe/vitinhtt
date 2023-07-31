<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LoiPhanHoi extends Model
{
    use HasFactory;
    protected $table = 'loiphanhoi';
    public function layDanhSachLoiPhanHoiTheoBoLoc($boLoc = [])
    {
        $danhSachLoiPhanHoi = DB::table($this->table);
        $danhSachLoiPhanHoi = $danhSachLoiPhanHoi->select(DB::raw($this->table . '.* , nguoidung.hoten,nguoidung.sodienthoai,nguoidung.diachi'))
        ->leftJoin('nguoidung', $this->table . '.manguoidung', '=', 'nguoidung.manguoidung');
        if (!empty($boLoc)) {
            foreach ($boLoc as $bl) {
                if (count($bl) == 2) {
                    $danhSachLoiPhanHoi = $danhSachLoiPhanHoi->whereIn($bl[0], $bl[1]);
                } else if (count($bl) == 3) {
                    $danhSachLoiPhanHoi = $danhSachLoiPhanHoi->where([$bl]);
                }
            }
        }
        $danhSachLoiPhanHoi = $danhSachLoiPhanHoi->orderBy($this->table . '.trangthai', 'ASC');
        $danhSachLoiPhanHoi = $danhSachLoiPhanHoi->orderBy($this->table . '.ngaytao', 'DESC');
        $danhSachLoiPhanHoi = $danhSachLoiPhanHoi->get()->all();
        return $danhSachLoiPhanHoi;
    }
    public function timLoiPhanHoiTheoMa($maloiphanhoi){
        $loiPhanHoi = DB::select('SELECT * FROM loiphanhoi WHERE maloiphanhoi = ?',[$maloiphanhoi]);
        if(!empty($loiPhanHoi)){
            return $loiPhanHoi[0];
        }
        return $loiPhanHoi;
    }
    public function doiTrangThaiLoiPhanHoi($data,$maloiphanhoi){
        $data = array_merge($data,[$maloiphanhoi]);
        return DB::select('UPDATE loiphanhoi SET
            trangthai = ?
            WHERE maloiphanhoi = ?',$data);
    }
    public function doiTrangThaiLoiPhanHoiTatCa(){
        return DB::select('UPDATE loiphanhoi SET
            trangthai = 1
            WHERE trangthai = 0');
    }
    public function themLoiPhanHoi($data){
        return DB::insert('INSERT INTO loiphanhoi (
            noidung,
            trangthai,
            manguoidung,
            ngaytao) values (
            ?,
            ?,
            ?,
            ?)', $data);
    }
}
