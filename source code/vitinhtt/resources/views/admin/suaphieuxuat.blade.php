@extends('admin.layouts.client')
@section('title')
    Sửa phiếu xuất
@endsection
@section('head')
    {{-- thêm css --}}
    <style>
        .form-control:disabled {
            color: #000 !important;
        }
        .table td, .table th{
            padding: 0 10px!important;
        }
    </style>
@endsection
@section('content')
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Sửa Phiếu Xuất Hàng</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('tongquan') }}">
                            <i class="flaticon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('phieuxuat') }}">Phiếu xuất</a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Sửa phiếu</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header row m-0" style="padding: 15px 0px 15px 5px">
                            <div class="col-4">
                                <div class="card-title">Thông tin phiếu</div>
                            </div>
                            <div class="col-8 canphai">
                                @if (!empty($phieuXuatCanXem))
                                    <button class="btn btn-primary btn-round ml-auto" onclick="window.open('{{url('inphieuxuat?mapx=' . $phieuXuatCanXem->maphieuxuat)}}');">
                                        <i class="fa fa-print"></i>&nbsp;&nbsp;In Phiếu Xuất
                                    </button>
                                @endif
                            </div>
                        </div>
                        <form action="{{ route('xulyphieuxuat') }}" method="post">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-9" style="border-right: solid 1px #ccc">
                                        <div class="form-group">
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col" width="1%">STT</th>
                                                            <th class="cangiua" scope="col" width="10%">Bảo hành
                                                                @error('baoHanh')
                                                                    <p style="color: red;font-size:10px;margin:0px">{{ $message }}</p>
                                                                @enderror
                                                                @error('baoHanh.*')
                                                                    <p style="color: red;font-size:10px;margin:0px">{{ $message }}</p>
                                                                @enderror
                                                            </th>
                                                            <th scope="col">
                                                                Sản phẩm
                                                                @error('chiTietPhieuXuat')
                                                                    <p style="color: red;font-size:10px;margin:0px">{{ $message }}</p>
                                                                @enderror
                                                                @error('chiTietPhieuXuat.*')
                                                                    <p style="color: red;font-size:10px;margin:0px">{{ $message }}</p>
                                                                @enderror
                                                            </th>
                                                            <th class="cangiua" scope="col" width="10%">
                                                                Số lượng
                                                                @error('soLuong')
                                                                    <p style="color: red;font-size:10px;margin:0px">{{ $message }}</p>
                                                                @enderror
                                                                @error('soLuong.*')
                                                                    <p style="color: red;font-size:10px;margin:0px">{{ $message }}</p>
                                                                @enderror
                                                            </th>
                                                            <th class="cangiua" scope="col" width="18%">Đơn giá
                                                                @error('donGia')
                                                                    <p style="color: red;font-size:10px;margin:0px">{{ $message }}</p>
                                                                @enderror
                                                                @error('donGia.*')
                                                                    <p style="color: red;font-size:10px;margin:0px">{{ $message }}</p>
                                                                @enderror
                                                            </th>
                                                            <th class="cangiua" scope="col" width="18%">Thành tiền
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tablePhieuXuat">
                                                        <script>
                                                            var stt = 1;
                                                        </script>
                                                        <tr style="display:none">
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                        @if (!empty($danhSachChiTietPhieuXuatCanXem))
                                                            @php
                                                                $stt=1;
                                                            @endphp
                                                            @foreach ($danhSachChiTietPhieuXuatCanXem as $ctpx)
                                                                <tr>
                                                                    <td class="cangiua">{{$stt}}</td>
                                                                    <td>
                                                                        <input class="form-control cangiua" style="padding-left:11px;padding-right:5px;" type="number" pattern="[0-9]*" step="1" id="baoHanh{{$stt}}" name="baoHanh[]" value="{{$ctpx->baohanh}}" min="0" onkeyup="tinhTongTien()" required>
                                                                    </td>
                                                                    <td>
                                                                        @if (!empty($danhSachSanPham))
                                                                            @foreach ($danhSachSanPham as $sanPham1)
                                                                                @if ($sanPham1->masanpham==$ctpx->masanpham)
                                                                                    <input list="chitietphieuxuat{{$stt}}" name="chiTietPhieuXuat[]" class="form-control" value = "SP{{ $sanPham1->masanpham }} | {{ $sanPham1->tensanpham }}" required>
                                                                                    <datalist id="chitietphieuxuat{{$stt}}" >
                                                                                        @foreach ($danhSachSanPham as $sanPham)
                                                                                            <option value = "SP{{ $sanPham->masanpham }} | {{ $sanPham->tensanpham }}"></option>
                                                                                        @endforeach
                                                                                    </datalist>
                                                                                    @break
                                                                                @endif
                                                                            @endforeach
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <input class="form-control cangiua" style="padding-left:11px;padding-right:5px;" type="number" pattern="[0-9]*" step="1" id="soLuong{{$stt}}" name="soLuong[]" value="{{$ctpx->soluong}}" min="0" onkeyup="tinhTongTien()" required>
                                                                    </td>
                                                                    <td>
                                                                        <input class="form-control canphai" type="text" id="donGia{{$stt}}" name="donGia[]" pattern="[0-9,]*" value="{{$ctpx->dongia}}" min="0" onkeyup="tinhTongTien()" required>
                                                                    </td>
                                                                    <td>
                                                                        <input class="form-control canphai" type="text" id="thanhTien{{$stt}}" pattern="[0-9,]*" min="0" value="{{$ctpx->dongia*$ctpx->soluong}}" disabled required>
                                                                    </td>
                                                                </tr>
                                                                @php
                                                                    $stt++;
                                                                @endphp
                                                            @endforeach
                                                            <script>
                                                                var stt = {{$stt}};
                                                            </script>
                                                        @else
                                                            <script>
                                                                var stt = 1;
                                                            </script>
                                                        @endif
                                                    </tbody>
                                                </table>
                                                <button onclick="themDong()" type="button" class="btn btn-primary"
                                                    style="padding: 5px 20px">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                                <button onclick="xoaDong()" type="button" class="btn btn-focus ml-2"
                                                    style="padding: 5px 20px">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-3">
                                        @if (!empty($phieuXuatCanXem)&&!empty($nguoiDungCanXem))
                                        <div class="form-group form-group-default">
                                            <label for="smallSelect">Thông tin khách hàng (*)</label>
                                                        <input list="khachHang" name="thongTinNguoiDung" class="form-control" value="ND{{ $nguoiDungCanXem->manguoidung }} | {{ $nguoiDungCanXem->hoten }} | {{ $nguoiDungCanXem->sodienthoai }}" required>
                                                        <datalist id="khachHang">
                                                            @if (!empty($danhSachKhachHang))
                                                            @foreach ($danhSachKhachHang as $khachHang)
                                                                <option
                                                                    value="ND{{ $khachHang->manguoidung }} | {{ $khachHang->hoten }} | {{ $khachHang->sodienthoai }}">
                                                                </option>
                                                            @endforeach
                                                            @endif
                                                        </datalist>
                                            @error('thongTinNguoiDung')
                                                <span style="color: red;font-size:10px">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group form-group-default pt-2" id="divThongTinNguoiNhanKhac">
                                            <div class="form-check p-0 mt-1 mb-2">
												<label class="form-check-label">
													<input class="form-check-input"  name="thongTinNguoiNhanKhac" id="thongTinNguoiNhanKhac" {{ ($phieuXuatCanXem->hotennguoinhan!=$nguoiDungCanXem->hoten||$phieuXuatCanXem->sodienthoainguoinhan!=$nguoiDungCanXem->sodienthoai||$phieuXuatCanXem->diachinguoinhan!=$nguoiDungCanXem->diachi) ? 'checked' : ''}} type="checkbox" onchange="hienThiThongTinNguoiNhanKhac()">
													<span class="form-check-sign" style="color: #495057!important;padding-top:3px">Giao đến địa chỉ khác?</span>
												</label>
											</div>
                                            <div class="form-group form-group-default mt-2" id="divHoTenNguoiNhan">
                                                <label for="smallSelect">Họ tên người nhận (*)</label>
                                                <input class="form-control"
                                                title="(Gồm các ký tự là chữ thường hoặc in hoa, có dấu hoặc không dấu, tối đa 50 ký tự)"
                                                name="hoTenNguoiNhan" id="hoTenNguoiNhan"
                                                value="{{ $phieuXuatCanXem->hotennguoinhan }}"
                                                pattern="[a-zỳọáầảấờễàạằệếýộậốũứĩõúữịỗìềểẩớặòùồợãụủíỹắẫựỉỏừỷởóéửỵẳẹèẽổẵẻỡơôưăêâđA-ZỲỌÁẦẢẤỜỄÀẠẰỆẾÝỘẬỐŨỨĨÕÚỮỊỖÌỀỂẨỚẶÒÙỒỢÃỤỦÍỸẮẪỰỈỎỪỶỞÓÉỬỴẲẸÈẼỔẴẺỠƠÔƯĂÊÂĐ ]{3,50}"
                                                type="text">
                                                @error('hoTenNguoiNhan')
                                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                                @enderror
											</div>
                                            <div class="form-group form-group-default" id="divSoDienThoaiNguoiNhan">
                                                <label for="smallSelect">Số điện thoại người nhận (*)</label>
                                                <input class="form-control"
                                                title="(Gồm các ký tự là số, có bắt đầu là số 0, tối đa 9 chữ số - không bao gồm ký tự đầu là 0)"
                                                name="soDienThoaiNguoiNhan" id="soDienThoaiNguoiNhan"
                                                value="{{ $phieuXuatCanXem->sodienthoainguoinhan }}" pattern="^[0]\d{9}$"
                                                type="text">
                                                @error('soDienThoaiNguoiNhan')
                                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                                @enderror
											</div>
                                            <div class="form-group form-group-default" id="divDiaChiNguoiNhan">
                                                <label for="smallSelect">Địa chỉ người nhận (*)</label>
                                                <input class="form-control"
                                                title="(Gồm các ký tự là chữ thường, in hoa, số hoặc các ký tự như ,.-/ và tối đa 255 ký tự)"
                                                name="diaChiNguoiNhan" id="diaChiNguoiNhan"
                                                value="{{ $phieuXuatCanXem->diachinguoinhan }}"
                                                pattern="[a-zỳọáầảấờễàạằệếýộậốũứĩõúữịỗìềểẩớặòùồợãụủíỹắẫựỉỏừỷởóéửỵẳẹèẽổẵẻỡơôưăêâđA-ZỲỌÁẦẢẤỜỄÀẠẰỆẾÝỘẬỐŨỨĨÕÚỮỊỖÌỀỂẨỚẶÒÙỒỢÃỤỦÍỸẮẪỰỈỎỪỶỞÓÉỬỴẲẸÈẼỔẴẺỠƠÔƯĂÊÂĐ0-9 -/,.]{3,255}"
                                                type="text">
                                                @error('diaChiNguoiNhan')
                                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                                @enderror
											</div>
                                        </div>
                                        <div class="form-group form-group-default">
                                            <label for="smallSelect">Hình thức thanh toán (*)</label>
                                            <select class="form-control" name="hinhThucThanhToan" required>
                                                @if ($phieuXuatCanXem->hinhthucthanhtoan == 0)
                                                        <option value="{{ $phieuXuatCanXem->hinhthucthanhtoan }}" selected hidden>
                                                            Tiền mặt</option>
                                                    @elseif($phieuXuatCanXem->hinhthucthanhtoan == 1)
                                                        <option value="{{ $phieuXuatCanXem->hinhthucthanhtoan }}" selected hidden>
                                                            Chuyển khoản</option>
                                                    @elseif($phieuXuatCanXem->hinhthucthanhtoan == 2)
                                                        <option value="{{ $phieuXuatCanXem->hinhthucthanhtoan }}" selected hidden>
                                                            ATM qua VNPAY</option>
                                                    @endif
                                                <option value="0">Tiền mặt</option>
                                                <option value="1">Chuyển khoản</option>
                                                <option value="2">ATM qua VNPAY</option>
                                            </select>
                                            @error('hinhThucThanhToan')
                                                <span style="color: red;font-size:10px">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group form-group-default">
                                            <label for="smallSelect">Tình trạng giao hàng (*)</label>
                                            <select class="form-control" name="tinhTrangGiaoHang" required>
                                                @if ($phieuXuatCanXem->tinhtranggiaohang == 0)
                                                        <option value="{{ $phieuXuatCanXem->tinhtranggiaohang }}" selected hidden>
                                                            Đã hủy</option>
                                                @elseif ($phieuXuatCanXem->tinhtranggiaohang == 1)
                                                        <option value="{{ $phieuXuatCanXem->tinhtranggiaohang }}" selected hidden>
                                                            Chờ xác nhận</option>
                                                @elseif($phieuXuatCanXem->tinhtranggiaohang == 2)
                                                        <option value="{{ $phieuXuatCanXem->tinhtranggiaohang }}" selected hidden>
                                                            Đang chuẩn bị hàng</option>
                                                @elseif($phieuXuatCanXem->tinhtranggiaohang == 3)
                                                        <option value="{{ $phieuXuatCanXem->tinhtranggiaohang }}" selected hidden>
                                                            Đang giao hàng</option>
                                                @elseif($phieuXuatCanXem->tinhtranggiaohang == 4)
                                                        <option value="{{ $phieuXuatCanXem->tinhtranggiaohang }}" selected hidden>
                                                            Đã giao thành công</option>
                                                @endif
                                                <option value="0">Đã hủy</option>
                                                <option value="1">Chờ xác nhận</option>
                                                <option value="2">Đang chuẩn bị hàng</option>
                                                <option value="3">Đang giao hàng</option>
                                                <option value="4">Đã giao thành công</option>
                                            </select>
                                            @error('tinhTrangGiaoHang')
                                                <span style="color: red;font-size:10px">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group form-group-default">
                                            <label for="smallSelect">Ghi chú</label>
                                            @if ($phieuXuatCanXem->ghichu != null)
                                                <textarea name="ghiChu" rows="5" class="form-control">{{ $phieuXuatCanXem->ghichu }}</textarea>
                                            @else
                                                <textarea name="ghiChu" rows="5" class="form-control"></textarea>
                                            @endif
                                            @error('ghiChu')
                                                <span style="color: red;font-size:10px">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="row m-0 pt-0">
                                            <div class="form-group col-6 ml-auto canphai p-0"
                                                style="padding-right:12px!important">
                                                <h5 style="padding: 10px 0px">Tổng tiền:</h5>
                                                @error('tongTien')
                                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-6 canphai p-0">
                                                <input style="padding-left:15px" class="form-control canphai" type="text"
                                                    id="tongTienHien" pattern="[0-9,]*" value="0" min="0"
                                                    disabled="false">
                                                <input type="number" min="0" value="{{ $phieuXuatCanXem->tongtien }}" hidden id="tongTien" name="tongTien" required>
                                            </div>
                                        </div>
                                        @if (!empty($maGiamGiaCanXem) && !empty($phieuXuatCanXem->magiamgia))
                                            @if ($maGiamGiaCanXem->magiamgia == $phieuXuatCanXem->magiamgia)
                                                <div class="row m-0 pt-0">
                                                    <div class="form-group col-6 ml-auto canphai p-0"
                                                        style="padding-right:12px!important">
                                                        <h5 style="padding: 10px 0px">Giảm ({{$maGiamGiaCanXem->magiamgia}}):</h5>
                                                    </div>
                                                    <div class="form-group col-6 canphai p-0">
                                                        <input style="padding-left:15px" class="form-control canphai"
                                                            type="text" id="maGiamGia"name="maGiamGia" pattern="[0-9,]*"
                                                            value="{{ number_format($maGiamGiaCanXem->sotiengiam, 0, ',') }}" min="0" required disabled>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                        <div class="row m-0 pt-0">
                                            <div class="form-group col-6 ml-auto canphai p-0"
                                                style="padding-right:12px!important">
                                                <h5 style="padding: 10px 0px">Đã thanh toán:</h5>
                                                @error('daThanhToan')
                                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-6 canphai p-0">
                                                <input style="padding-left:15px" class="form-control canphai"
                                                    type="text" id="daThanhToan"name="daThanhToan" pattern="[0-9,]*"
                                                    value="{{ number_format(!empty($maGiamGiaCanXem->sotiengiam) ? $phieuXuatCanXem->tongtien+$phieuXuatCanXem->congno-$maGiamGiaCanXem->sotiengiam : $phieuXuatCanXem->tongtien+$phieuXuatCanXem->congno, 0, ',') }}" min="0" required>
                                            </div>
                                        </div>
                                        <div class="row m-0 pt-0">
                                            <div class="form-group col-6 ml-auto canphai p-0"
                                                style="padding-right:12px!important">
                                                <h5 style="padding: 10px 0px">Tính vào công nợ:</h5>
                                            </div>
                                            <div class="form-group col-6 canphai p-0">
                                                <input style="padding-left:15px" class="form-control canphai"
                                                    type="text" id="congNo"name="congNo" pattern="[0-9,]*"
                                                    value="0" min="0" required disabled>
                                            </div>
                                        </div>
                                        <input name="maPhieuXuatSua" type="number" hidden value="{{$phieuXuatCanXem->maphieuxuat }}" required>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-action canphai" style="padding:15px">
                                <button type="button" class="btn btn-focus mr-2" id="thoatPhieu">Thoát</button>
                                <button type="submit" name="thaoTac" value="sửa phiếu xuất"
                                    class="btn btn-primary">Lưu</button>
                            </div>
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    {{-- thêm js --}}
    <script>
        var maSanPham=null;
        var soThuTuCanDoDuLieu=null;
        var flag = false;
        var danhSachSanPham = null;
        function themDong() {
            var tablePhieuXuat = document.getElementById("tablePhieuXuat");
            var dongChiTietPhieuXuat = tablePhieuXuat.insertRow(stt);
            var cotStt = dongChiTietPhieuXuat.insertCell(0); //stt
            var cotBaoHanh = dongChiTietPhieuXuat.insertCell(1); //Bảo hành
            var cotSanPham = dongChiTietPhieuXuat.insertCell(2); //ten san pham
            var cotSoLuong = dongChiTietPhieuXuat.insertCell(3); //so luong
            var cotDonGia = dongChiTietPhieuXuat.insertCell(4); //don gia
            var cotThanhTien = dongChiTietPhieuXuat.insertCell(5); //thanh tien
            cotStt.classList.add('cangiua');
            cotBaoHanh.classList.add('cangiua');
            cotStt.innerHTML = "" + stt + "";
            cotBaoHanh.innerHTML = '<input class="form-control cangiua" style="padding-left:11px;padding-right:5px;" type="number" pattern="[0-9]*" step="1" id="baoHanh'+stt+'" name="baoHanh[]" value="0" min="0" onkeyup="tinhTongTien()" required>';
            cotSanPham.innerHTML = '<input id="inputSanPham'+stt+'" onblur="doDuLieuSanPham('+stt+')" list="chitietphieuxuat'+stt+'" name="chiTietPhieuXuat[]" class="form-control" required> <datalist id="chitietphieuxuat'+stt+'" >@if (!empty($danhSachSanPham)) @foreach ($danhSachSanPham as $sanPham)<option value = "SP{{ $sanPham->masanpham }} | {{ $sanPham->tensanpham }}">Tồn kho: {{ $sanPham->soluong }} | Khách đặt: {{ $sanPham->khachdat }}</option>  @endforeach @endif </datalist>';
            cotSoLuong.innerHTML = '<input class="form-control cangiua" style="padding-left:11px;padding-right:5px;" type="number" pattern="[0-9]*" step="1" id="soLuong'+stt+'" name="soLuong[]" value="0" min="0" onkeyup="tinhTongTien()" required>';
            cotDonGia.innerHTML = '<input class="form-control canphai" type="text" id="donGia'+stt+'" name="donGia[]" pattern="[0-9,]*" value="0" min="0" onkeyup="tinhTongTien()" required>';
            cotThanhTien.innerHTML = '<input class="form-control canphai" type="text" id="thanhTien'+stt+'" pattern="[0-9,]*" min="0" value="0" disabled required>';
            stt++;
            tinhTongTien();
        }
        function doDuLieuSanPham(soThuTu) {
            soThuTuCanDoDuLieu=soThuTu;
            danhSachSanPham = {!! json_encode($danhSachSanPham) !!};
            var inputSanPham = document.getElementById("inputSanPham"+soThuTu);
            maSanPham=inputSanPham.value.split(" | ")[0].split("SP")[1];
            danhSachSanPham.forEach(timThongTinSanPham);
        }
        function timThongTinSanPham(thongTinSanPham) {
            if (thongTinSanPham['masanpham']==maSanPham){
                document.getElementById('baoHanh'+soThuTuCanDoDuLieu).value=thongTinSanPham['baohanh'];
                document.getElementById('soLuong'+soThuTuCanDoDuLieu).value=1;
                document.getElementById('donGia'+soThuTuCanDoDuLieu).value=thongTinSanPham['giaban'];
                if(thongTinSanPham['giakhuyenmai']!=null){
                    document.getElementById('donGia'+soThuTuCanDoDuLieu).value=thongTinSanPham['giakhuyenmai'];
                }
                tinhTongTien();
            }
        }
        function xoaDong() {
            var tablePhieuXuat = document.getElementById("tablePhieuXuat");
            if (tablePhieuXuat.rows.length > 0) {
                stt--;
                tablePhieuXuat.deleteRow(stt);
            }
            tinhTongTien();
        }


        function tinhTongTien() {
            var inputTongTien = document.getElementById('tongTienHien');
            var inputCongNo = document.getElementById('congNo');
            var inputDaThanhToan = document.getElementById('daThanhToan');
            var soTienGiam = '{{!empty($maGiamGiaCanXem) ? $maGiamGiaCanXem->sotiengiam : 0}}';
            var giaTriDaThanhToan = inputDaThanhToan.value.split(","); // format tien ,,, lai thanh so
            var temp = "";
            for (var i = 0; i < giaTriDaThanhToan.length; i++) {
                temp += giaTriDaThanhToan[i];
            }
            inputDaThanhToan.value = temp; // format tien ,,, lai thanh so
            inputTongTien.value = 0;
            inputCongNo.value = 0;
            var tablePhieuXuat = document.getElementById("tablePhieuXuat");
            var demDong = tablePhieuXuat.rows.length;
            for (var i = 1; i < demDong; i++) {
                var inputBaoHanh = document.getElementById('baoHanh' + i);
                var inputSoLuong = document.getElementById('soLuong' + i);
                var inputDonGia = document.getElementById('donGia' + i);
                var giaTriDonGia = inputDonGia.value.split(","); // format tien ,,, lai thanh so
                temp = "";
                for (var j = 0; j < giaTriDonGia.length; j++) {
                    temp += giaTriDonGia[j];
                }
                inputDonGia.value = temp; // format tien ,,, lai thanh so

                var inputThanhTien = document.getElementById('thanhTien' + i);
                inputSoLuong.value = parseFloat(inputSoLuong.value);
                inputDonGia.value = parseFloat(inputDonGia.value);
                inputThanhTien.value = parseFloat(inputSoLuong.value * inputDonGia.value);
                inputTongTien.value = parseFloat(inputTongTien.value) + parseFloat(inputSoLuong.value *
                    inputDonGia.value);
                if (isNaN(inputBaoHanh.value) || inputBaoHanh.value == "") inputBaoHanh.value = 0;
                if (isNaN(inputSoLuong.value) || inputSoLuong.value == "") inputSoLuong.value = 0;
                if (isNaN(inputDonGia.value)) inputDonGia.value = 0;
                if (isNaN(inputThanhTien.value)) inputThanhTien.value = 0;
                formatGia(inputDonGia);
                formatGia(inputThanhTien);
            }
            if((tongTien.value!=inputTongTien.value) || (parseFloat(inputDaThanhToan.value)>=(parseFloat(inputTongTien.value)-parseFloat(soTienGiam)))){
                inputDaThanhToan.value = parseFloat(inputTongTien.value)-parseFloat(soTienGiam);
            }
            inputCongNo.value = parseFloat(soTienGiam) + parseFloat(inputDaThanhToan.value) - parseFloat(inputTongTien.value);
            tongTien.value = parseFloat(inputTongTien.value);
            if (isNaN(inputTongTien.value)) {
                inputTongTien.value = 0;
                tongTien.value = 0;
            }
            if (isNaN(inputDaThanhToan.value) || inputDaThanhToan.value == "") inputDaThanhToan.value = 0;
            if (isNaN(inputCongNo.value)) inputCongNo.value = 0;
            formatGia(inputTongTien);
            formatGia(inputDaThanhToan);
            formatGia(inputCongNo);
        };
        function hienThiThongTinNguoiNhanKhac() {
            var thongTinNguoiNhanKhac = document.getElementById('thongTinNguoiNhanKhac');
            var hoTenNguoiNhan = document.getElementById('hoTenNguoiNhan');
            var soDienThoaiNguoiNhan = document.getElementById('soDienThoaiNguoiNhan');
            var diaChiNguoiNhan = document.getElementById('diaChiNguoiNhan');
                if (thongTinNguoiNhanKhac.checked) {
                    $('#divThongTinNguoiNhanKhac').removeClass("pb-1");
                    $('#divThongTinNguoiNhanKhac').css('background-color','buttonface');
                    $('#divHoTenNguoiNhan').removeClass("displaynone");
                    $('#divSoDienThoaiNguoiNhan').removeClass("displaynone");
                    $('#divDiaChiNguoiNhan').removeClass("displaynone");
                    $('#divThongTinNguoiNhanKhac').addClass("pb-0");
                } else {
                    $('#divThongTinNguoiNhanKhac').removeClass("pb-0");
                    $('#divHoTenNguoiNhan').addClass("displaynone");
                    $('#divSoDienThoaiNguoiNhan').addClass("displaynone");
                    $('#divThongTinNguoiNhanKhac').css('background-color','#fff');
                    $('#divDiaChiNguoiNhan').addClass("displaynone");
                    $('#divThongTinNguoiNhanKhac').addClass("pb-1");
                }
                hoTenNguoiNhan.required = thongTinNguoiNhanKhac.checked;
                soDienThoaiNguoiNhan.required = thongTinNguoiNhanKhac.checked;
                diaChiNguoiNhan.required = thongTinNguoiNhanKhac.checked;
            };
        $(document).ready(function() {
            tinhTongTien();
            $('input').keyup(function() {
                tinhTongTien();
            });
            hienThiThongTinNguoiNhanKhac();
            $('#thoatPhieu').click(function(e) {
                swal({
                    title: 'Bạn chắc chứ?',
                    text: "Mọi thứ bạn điền trên phiếu sẽ không được lưu!",
                    type: 'warning',
                    buttons: {
                        cancel: {
                            text: 'Ở lại',
                            visible: true,
                            className: 'btn btn-focus'
                        },
                        confirm: {
                            text: 'Rời đi',
                            className: 'btn btn-danger'
                        }
                    }
                }).then((DongY) => {
                    if (DongY) {
                        window.location.replace("{{ route('phieuxuat') }}");
                    } else {
                        swal.close();
                    }
                });
            });
        });
    </script>
@endsection
