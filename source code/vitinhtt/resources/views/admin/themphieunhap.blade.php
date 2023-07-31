@extends('admin.layouts.client')
@section('title')
    Thêm phiếu nhập
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
                <h4 class="page-title">Lập Phiếu Nhập Hàng</h4>
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
                        <a href="{{ route('phieunhap') }}">Phiếu nhập</a>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Lập phiếu</a>
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
                                <button class="btn btn-primary btn-round mr-2" data-toggle="modal"
                                    data-target="#themHangSanXuat">
                                    <i class="fa fa-plus"></i>
                                    &nbsp;Thêm Hãng
                                </button>
                                <button class="btn btn-primary btn-round mr-2" data-toggle="modal"
                                    data-target="#themPhuKien">
                                    <i class="fa fa-plus"></i>
                                    &nbsp;Thêm Phụ Kiện
                                </button>
                                <button class="btn btn-primary btn-round mr-2"data-toggle="modal"
                                    data-target="#themLaptop">
                                    <i class="fa fa-plus"></i>
                                    &nbsp;Thêm Laptop
                                </button>
                                <button class="btn btn-primary btn-round" data-toggle="modal" data-target="#themNguoiDung">
                                    <i class="fa fa-plus"></i>
                                    &nbsp;Thêm Đối Tác
                                </button>
                            </div>
                        </div>
                        @include('admin.layouts.themhangsanxuat')
                        @include('admin.layouts.themphukien')
                        @include('admin.layouts.themlaptop')
                        @include('admin.layouts.themnguoidung')
                        <form action="{{ route('xulyphieunhap') }}" method="post">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-9" style="border-right: solid 1px #ccc">
                                        <div class="form-group">
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col" width="1%">STT</th>
                                                            <th scope="col">
                                                                Sản phẩm
                                                                @error('chiTietPhieuNhap')
                                                                    <p style="color: red;font-size:10px;margin:0px">{{ $message }}</p>
                                                                @enderror
                                                                @error('chiTietPhieuNhap.*')
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
                                                    <tbody id="tablePhieuNhap">
                                                        <script>
                                                            var stt = 1;
                                                        </script>
                                                        <tr style="display:none">
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
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
                                        <div class="form-group form-group-default">
                                            <label for="smallSelect">Nhà cung cấp (*)</label>
                                            <input list="nhaCungCap" name="thongTinNguoiDung" class="form-control" value="{{ old('thongTinNguoiDung') }}" required>
                                            <datalist id="nhaCungCap">
                                                @if (!empty($danhSachNhaCungCap))
                                                    @foreach ($danhSachNhaCungCap as $nhaCungCap)
                                                        <option
                                                            value="ND{{ $nhaCungCap->manguoidung }} | {{ $nhaCungCap->hoten }} | {{ $nhaCungCap->sodienthoai }}">
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </datalist>
                                            @error('thongTinNguoiDung')
                                                <span style="color: red;font-size:10px">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group form-group-default">
                                            <label for="smallSelect">Ghi chú</label>
                                            @if (old('ghiChu') != null)
                                                <textarea name="ghiChu" rows="5" class="form-control">{{ old('ghiChu') }}</textarea>
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
                                                <input type="number" min="0" hidden id="tongTien" name="tongTien" required>
                                            </div>
                                        </div>
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
                                                    value="0" min="0" required>
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
                                                    value="0" min="0" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-action canphai" style="padding:15px">
                                <button type="button" class="btn btn-focus mr-2" id="thoatPhieu">Thoát</button>
                                <button type="submit" name="thaoTac" value="thêm phiếu nhập"
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
        function themDong() {
            var tablePhieuNhap = document.getElementById("tablePhieuNhap");
            var dongChiTietPhieuNhap = tablePhieuNhap.insertRow(stt);
            var cotStt = dongChiTietPhieuNhap.insertCell(0); //stt
            var cotSanPham = dongChiTietPhieuNhap.insertCell(1); //ten san pham
            var cotSoLuong = dongChiTietPhieuNhap.insertCell(2); //so luong
            var cotDonGia = dongChiTietPhieuNhap.insertCell(3); //don gia
            var cotThanhTien = dongChiTietPhieuNhap.insertCell(4); //thanh tien
            cotStt.classList.add('cangiua');
            cotStt.innerHTML = "" + stt + "";
            cotSanPham.innerHTML = '<input list="chitietphieunhap'+stt+'" name="chiTietPhieuNhap[]" class="form-control" required> <datalist id="chitietphieunhap'+stt+'" >@if (!empty($danhSachSanPham)) @foreach ($danhSachSanPham as $sanPham)<option value = "SP{{ $sanPham->masanpham }} | {{ $sanPham->tensanpham }}"></option>  @endforeach @endif </datalist>';
            cotSoLuong.innerHTML = '<input class="form-control cangiua" style="padding-left:11px;padding-right:5px;" type="number" pattern="[0-9]*" step="1" id="soLuong'+stt+'" name="soLuong[]" value="0" min="0" onkeyup="tinhTongTien()" required>';
            cotDonGia.innerHTML = '<input class="form-control canphai" type="text" id="donGia'+stt+'" name="donGia[]" pattern="[0-9,]*" value="0" min="0" onkeyup="tinhTongTien()" required>';
            cotThanhTien.innerHTML = '<input class="form-control canphai" type="text" id="thanhTien'+stt+'" pattern="[0-9,]*" min="0" value="0" disabled required>';
            stt++;
            tinhTongTien();
        }

        function xoaDong() {
            var tablePhieuNhap = document.getElementById("tablePhieuNhap");
            if (tablePhieuNhap.rows.length > 0) {
                stt--;
                tablePhieuNhap.deleteRow(stt);
            }
            tinhTongTien();
        }

        function tinhTongTien() {
            var inputTongTien = document.getElementById('tongTienHien');
            var inputCongNo = document.getElementById('congNo');
            var inputDaThanhToan = document.getElementById('daThanhToan');

            var giaTriDaThanhToan = inputDaThanhToan.value.split(","); // format tien ,,, lai thanh so
            var temp = "";
            for (var i = 0; i < giaTriDaThanhToan.length; i++) {
                temp += giaTriDaThanhToan[i];
            }
            inputDaThanhToan.value = temp; // format tien ,,, lai thanh so

            inputTongTien.value = 0;
            inputCongNo.value = 0;

            var tablePhieuNhap = document.getElementById("tablePhieuNhap");
            var demDong = tablePhieuNhap.rows.length;
            for (var i = 1; i < demDong; i++) {
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
                if (isNaN(inputDonGia.value)) inputDonGia.value = 0;
                if (isNaN(inputSoLuong.value)) inputSoLuong.value = 0;
                if (isNaN(inputThanhTien.value)) inputThanhTien.value = 0;
                formatGia(inputDonGia);
                formatGia(inputThanhTien);
            }
            inputCongNo.value = parseFloat(inputDaThanhToan.value) - parseFloat(inputTongTien.value);
            tongTien.value = parseFloat(inputTongTien.value);
            if (isNaN(inputTongTien.value)) {
                inputTongTien.value = 0;
                tongTien.value = 0;
            }
            if (isNaN(inputDaThanhToan.value)) inputDaThanhToan.value = 0;
            if (isNaN(inputCongNo.value)) inputCongNo.value = 0;

            formatGia(inputTongTien);
            formatGia(inputDaThanhToan);
            formatGia(inputCongNo);
        };
        $(document).ready(function() {
            tinhTongTien();
            $('input').keyup(function() {
                tinhTongTien();
            });
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
                        window.location.replace("{{ route('phieunhap') }}");
                    } else {
                        swal.close();
                    }
                });
            });
        });
    </script>
@endsection
