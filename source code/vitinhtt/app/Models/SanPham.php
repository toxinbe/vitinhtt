<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SanPham extends Model
{
    use HasFactory;
    protected $table = 'sanpham';
    public function layDanhSachSanPham()
    {
        $danhSachSanPham = DB::select('SELECT * FROM sanpham ORDER BY masanpham DESC');
        return $danhSachSanPham;
    }
    public function layDanhSachSanPhamTheoBoLoc($boLoc = [], $tuKhoa = NULL, $sapXep = NULL, $mucGia = [], $tinhTrang = [], $nhuCau = [], $manHinh = [], $oCung = [], $cardDoHoa = [], $Ram = [], $Cpu = [])
    {
        $danhSachSanPham = DB::table($this->table);
        if (!empty($boLoc)) {
            foreach ($boLoc as $bl) {
                if (count($bl) == 2) {
                    $danhSachSanPham = $danhSachSanPham->whereIn($bl[0], $bl[1]);
                } else if (count($bl) == 3) {
                    $danhSachSanPham = $danhSachSanPham->where([$bl]);
                }
            }
        }
        if (!empty($tinhTrang) || !empty($nhuCau) || !empty($manHinh) || !empty($oCung) || !empty($cardDoHoa) || !empty($Ram) || !empty($Cpu)) {
            $danhSachSanPham = $danhSachSanPham->select(DB::raw($this->table . '.* , laptop.*'))
                ->leftJoin('laptop', $this->table . '.malaptop', '=', 'laptop.malaptop');
            if (count($Cpu) > 0) {
                $danhSachSanPham = $danhSachSanPham->where(function ($query) use ($Cpu) {
                    foreach ($Cpu as $cpu) {
                        $query->orWhere([$cpu]);
                    }
                });
            }
            if (count($Ram) > 0) {
                $danhSachSanPham = $danhSachSanPham->where(function ($query) use ($Ram) {
                    foreach ($Ram as $ram) {
                        $query->orWhere([$ram]);
                    }
                });
            }
            if (count($cardDoHoa) > 0) {
                $danhSachSanPham = $danhSachSanPham->where(function ($query) use ($cardDoHoa) {
                    foreach ($cardDoHoa as $cdh) {
                        $query->orWhere([$cdh]);
                    }
                });
            }
            if (count($oCung) > 0) {
                $danhSachSanPham = $danhSachSanPham->where(function ($query) use ($oCung) {
                    foreach ($oCung as $oc) {
                        $query->orWhere([$oc]);
                    }
                });
            }
            if (count($manHinh) > 0) {
                $danhSachSanPham = $danhSachSanPham->where(function ($query) use ($manHinh) {
                    foreach ($manHinh as $mh) {
                        $query->orWhere(function ($query1) use ($mh) {
                            $query1->whereBetween('laptop.manhinh', [$mh]);
                        });
                    }
                });
            }
            if (count($nhuCau) > 0) {
                $danhSachSanPham = $danhSachSanPham->where(function ($query) use ($nhuCau) {
                    foreach ($nhuCau as $nc) {
                        $query->orWhere([$nc]);
                    }
                });
            }
            if (count($tinhTrang) > 0) {
                $danhSachSanPham = $danhSachSanPham->where(function ($query) use ($tinhTrang) {
                    foreach ($tinhTrang as $tt) {
                        $query->orWhere([$tt]);
                    }
                });
            }
        }
        if (!empty($mucGia)) {
            $danhSachSanPham = $danhSachSanPham->where(function ($query) use ($mucGia) {
                for ($i = 0; $i < count($mucGia); $i++) {
                    $query->orWhere(function ($query1) use ($mucGia, $i) {
                        $query1->whereBetween(
                            DB::raw('IF(' . $this->table . '.giakhuyenmai>0, ' . $this->table . '.giakhuyenmai, ' . $this->table . '.giaban) '),
                            [$mucGia[$i][0], $mucGia[$i][1]]
                        );
                    });
                }
            });
        }
        if (!empty($tuKhoa)) {
            if (strpos(' ' . $tuKhoa, 'SP') > 0 || strpos(' ' . $tuKhoa, 'sp') > 0) {
                $tuKhoa = str_replace('SP', '', $tuKhoa);
                $tuKhoa = str_replace('sp', '', $tuKhoa);
                $danhSachSanPham = $danhSachSanPham->where(function ($query) use ($tuKhoa) {
                    $query->orWhere($this->table . '.masanpham', 'like', '%' . $tuKhoa . '%');
                });
                $danhSachSanPham = $danhSachSanPham->orderBy($this->table . '.masanpham', 'ASC');
            } else {
                $danhSachSanPham = $danhSachSanPham->where(function ($query) use ($tuKhoa) {
                    $query->orWhere($this->table . '.tensanpham', 'like', '%' . $tuKhoa . '%');
                    $query->orWhere($this->table . '.mota', 'like', '%' . $tuKhoa . '%');
                    $query->orWhere($this->table . '.giaban', 'like', '%' . $tuKhoa . '%');
                    $query->orWhere($this->table . '.giakhuyenmai', 'like', '%' . $tuKhoa . '%');
                });
            }
        }
        if (!empty($sapXep)) {
            if ($sapXep == 'moinhat') {
                $danhSachSanPham = $danhSachSanPham->orderBy($this->table . '.ngaytao', 'DESC');
            } else if ($sapXep == 'banchaynhat') {
                $danhSachSanPham = $danhSachSanPham->select(DB::raw($this->table . '.* , SUM(chitietphieuxuat.soluong) AS tongsoluongdaban'))
                    ->leftJoin('chitietphieuxuat', $this->table . '.masanpham', '=', 'chitietphieuxuat.masanpham')
                    ->where('chitietphieuxuat.dongia', '>', 0)
                    ->groupBy('chitietphieuxuat.masanpham')
                    ->orderBy('tongsoluongdaban', 'DESC');
            } else if ($sapXep == 'uudainhat') {
                $danhSachSanPham = $danhSachSanPham->select(DB::raw('*,(' . $this->table . '.giaban-' . $this->table . '.giakhuyenmai) AS sotiendagiam'))
                    ->where($this->table . '.giakhuyenmai', '>', 0)
                    ->orderBy('sotiendagiam', 'DESC');
            } else if ($sapXep == 'giatangdan') {
                $danhSachSanPham = $danhSachSanPham->select(DB::raw($this->table . '.* , IF(' . $this->table . '.giakhuyenmai>0, '
                    . $this->table . '.giakhuyenmai, ' . $this->table . '.giaban) AS gia'));
                $danhSachSanPham = $danhSachSanPham->orderBy('gia', 'ASC');
            } else if ($sapXep == 'giagiamdan') {
                $danhSachSanPham = $danhSachSanPham->select(DB::raw($this->table . '.* , IF(' . $this->table . '.giakhuyenmai>0, '
                    . $this->table . '.giakhuyenmai, ' . $this->table . '.giaban) AS gia'));
                $danhSachSanPham = $danhSachSanPham->orderBy('gia', 'DESC');
            }
        } else {
            $danhSachSanPham = $danhSachSanPham->orderBy($this->table . '.ngaytao', 'DESC');
        }
        $danhSachSanPham = $danhSachSanPham->get()->all();
        return $danhSachSanPham;
    }
    public function layDanhSachSanPhamChoPhieu()
    {
        $danhSachSanPham = DB::select('SELECT sanpham.*,  sum(IF(phieuxuat.tinhtranggiaohang = 2 OR phieuxuat.tinhtranggiaohang = 3,chitietphieuxuat.soluong,0)) AS khachdat
        FROM `sanpham` LEFT JOIN chitietphieuxuat ON sanpham.masanpham = chitietphieuxuat.masanpham LEFT JOIN phieuxuat ON chitietphieuxuat.maphieuxuat = phieuxuat.maphieuxuat
        GROUP BY sanpham.masanpham ORDER BY sanpham.masanpham DESC');
        return $danhSachSanPham;
    }
    public function timSanPhamTheoMa($masanpham)
    {
        $sanPham = DB::select('SELECT * FROM sanpham WHERE masanpham = ?', [$masanpham]);
        if (!empty($sanPham)) {
            return $sanPham[0];
        }
        return $sanPham;
    }
    public function timSanPhamTheoTen($tensanpham)
    {
        $sanPham = DB::select('SELECT * FROM sanpham WHERE tensanpham = ?', [$tensanpham]);
        if (!empty($sanPham)) {
            return $sanPham[0];
        }
        return $sanPham;
    }
    public function xoaSanPham($masanpham)
    {
        return DB::select('DELETE FROM sanpham WHERE masanpham = ?', [$masanpham]);
    }
    public function suaSanPham($data, $masanpham)
    {
        $data = array_merge($data, [$masanpham]);

        return DB::select('UPDATE sanpham SET
            tensanpham = ?,
            baohanh = ?,
            mota = ?,
            mahang = ?
            WHERE masanpham = ?', $data);
    }
    public function capNhatGia($data, $masanpham)
    {
        $data = array_merge($data, [$masanpham]);
        return DB::select('UPDATE sanpham SET
            giaban = ?,
            giakhuyenmai = ?
            WHERE masanpham = ?', $data);
    }
    public function nhapHang($data, $masanpham)
    {
        $data = array_merge($data, [$masanpham]);
        return DB::select('UPDATE sanpham SET
            soluong = ?,
            gianhap = ?,
            giaban = ?,
            giakhuyenmai = ?
            WHERE masanpham = ?', $data);
    }
    public function suaSoLuong($data, $masanpham)
    {
        $data = array_merge($data, [$masanpham]);
        return DB::select('UPDATE sanpham SET
            soluong = ?
            WHERE masanpham = ?', $data);
    }
    public function themSanPham($data)
    {
        return DB::insert('INSERT INTO sanpham (
            masanpham ,
            tensanpham,
            baohanh,
            mota,
            soluong,
            gianhap,
            giaban,
            giakhuyenmai,
            mathuvienhinh ,
            mahang ,
            maquatang ,
            malaptop ,
            maphukien ,
            loaisanpham,
            ngaytao) values (
            ? ,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            ? ,
            ? ,
            ? ,
            ? ,
            ? ,
            ?,
            CURRENT_TIMESTAMP)', $data);
    }
}
