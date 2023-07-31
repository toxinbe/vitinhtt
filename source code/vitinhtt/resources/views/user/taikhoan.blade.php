@extends('user.layouts.client')
@section('title')
    Tài khoản
@endsection
@section('head')
    {{-- thêm css --}}
    <style>
        /*-------- 27. My account style ---------*/
        .myaccount-tab-menu {
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -webkit-flex-direction: column;
            -ms-flex-direction: column;
            flex-direction: column;
        }

        .myaccount-tab-menu a {
            border: 1px solid #ccc;
            border-bottom: none;
            font-weight: 400;
            font-size: 13px;
            display: block;
            padding: 10px 15px;
            text-transform: uppercase;
        }

        .myaccount-tab-menu a:last-child {
            border-bottom: 1px solid #ccc;
        }

        .myaccount-tab-menu a:hover,
        .myaccount-tab-menu a.active {
            background-color: #007bff;
            border-color: #007bff;
            color: #ffffff;
        }

        .myaccount-tab-menu a i.fa {
            font-size: 14px;
            text-align: center;
            width: 25px;
        }

        @media only screen and (max-width: 767px) {
            #myaccountContent {
                margin-top: 30px;
            }
        }

        .myaccount-content {
            border: 1px solid #eeeeee;
            padding: 30px;
        }

        @media only screen and (max-width: 767px) {
            .myaccount-content {
                padding: 20px 15px;
            }
        }

        .myaccount-content form {
            margin-top: -20px;
        }

        .myaccount-content h3 {
            font-size: 20px;
            border-bottom: 1px dashed #ccc;
            padding-bottom: 10px;
            margin-bottom: 25px;
            font-weight: 400;
        }

        .myaccount-content .welcome a:hover {
            color: #007bff;
        }

        .myaccount-content .welcome strong {
            font-weight: 400;
            color: #007bff;
        }

        .myaccount-content fieldset {
            margin-top: 20px;
        }

        .myaccount-content fieldset legend {
            font-size: 16px;
            margin-bottom: 20px;
            font-weight: 400;
            padding-bottom: 10px;
            border-bottom: 1px solid #ccc;
        }

        .myaccount-content .account-details-form {
            margin-top: 50px;
        }

        .myaccount-content .account-details-form .single-input-item {
            margin-bottom: 20px;
        }

        .myaccount-content .account-details-form .single-input-item label {
            font-size: 15px;
            line-height: 29px;
            text-transform: initial;
            display: block;
            margin: 0px;
        }

        .myaccount-content .account-details-form .single-input-item input {
            border: 1px solid #e8e8e8;
            height: 50px;
            line-height: 50px;
            background-color: transparent;
            padding: 1px 2px 1px 20px;
            color: #626262;
            font-size: 14px;
        }

        .myaccount-content .account-details-form .single-input-item input:focus {
            border: 1px solid #343538;
        }

        .myaccount-table {
            white-space: nowrap;
            font-size: 14px;
        }

        .myaccount-table table th,
        .myaccount-table .table th {
            padding: 10px;
            font-weight: 400;
            background-color: #f8f8f8;
            border-color: #ccc;
            border-bottom: 0;
            color: #1f2226;
        }

        .myaccount-table table td,
        .myaccount-table .table td {
            padding: 10px;
            vertical-align: middle;
            border-color: #ccc;
        }

        .saved-message {
            background-color: #fff;
            border-top: 3px solid #007bff;
            font-size: 14px;
            padding: 20px 0;
            color: #333;
        }

        #nutXem {
            width: 75px;
            height: auto;
        }

        #nutXem:hover {
            color: #242424 !important;
        }

        .height0px {
            height: 0px !important;
        }

        .bovientable>tfoot>tr>td {
            border: none !important;
            padding: 0px 10px !important;
        }

        .bovientable>tfoot>tr:first-child>td {
            padding-top: 20px !important;
        }
    </style>
@endsection
@section('content')
    <div class="breadcrumb-area">
        <div class="container">
            <div class="breadcrumb-content">
                <ul>
                    <li><a href="{{ route('/') }}">Trang chủ</a></li>
                    <li class="active"><a href="{{ route('taikhoan') }}">Tài khoản</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Begin Login Content Area -->
    @if (!empty($danhSachMaGiamGia) && auth()->check() && auth()->user()->loainguoidung != 2)
        @foreach ($danhSachMaGiamGia as $mgg)
            @if (rand(0, 3) == rand(0, 3) && strtotime($mgg->ngayketthuc) - strtotime(date('Y-m-d')) >= 0)
                <!-- Begin Static Top Area -->
                <div class="static-top-wrap">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="static-top-content mt-15 mt-sm-30" style="font-size:24px; line-height:0px">
                                    <i class="fa fa-gift"></i>
                                    Quà Tặng Đặt Biệt: Mã giảm giá - "<span>{{ $mgg->magiamgia }}</span>" - trị giá
                                    <span>{{ number_format($mgg->sotiengiam, 0, ',') }}đ</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Static Top Area End Here -->
            @break
        @endif
    @endforeach
@endif
<div class="page-section mt-10 mb-60">
    <div class="container">
        <div class="row mt-20">
            <div class="col-lg-12">
                <!-- My Account Page Start -->
                <div class="myaccount-page-wrapper">
                    <!-- My Account Tab Menu Start -->
                    <div class="row">
                        <div class="col-lg-3 col-md-4">
                            <div class="ml-20" style="color:#666">
                                <h5 class="mb-5">T&T Computer xin chào!</h5>
                                <h4 class="mb-20"><i class="fa fa-user-circle-o"></i>
                                    {{ auth()->check() ? auth()->user()->hoten : '' }}
                                </h4>
                            </div>
                            <div class="myaccount-tab-menu nav" role="tablist">
                                <a href="#orders" data-toggle="tab"
                                    class="{{ auth()->check() && auth()->user()->loainguoidung == 2 ? 'khonghienthi' : 'active' }}"><i
                                        class="fa fa-cart-arrow-down"></i>
                                    Đơn hàng</a>
                                <a href="#account-info"
                                    class="{{ auth()->check() && auth()->user()->loainguoidung == 2 ? 'active' : '' }}"
                                    data-toggle="tab"><i class="fa fa-user"></i>
                                    Tài khoản</a>
                                <a href="#address-edit" data-toggle="tab">{!! auth()->check() && auth()->user()->loainguoidung == 2
                                    ? '<i class="fa fa-address-card"></i> Nhân viên'
                                    : '<i class="fa fa-map-marker"></i> Địa chỉ' !!}</a>
                                <a href="{{ route('dangxuat') }}"><i class="fa fa-sign-out"></i> Đăng xuất</a>
                            </div>
                        </div>
                        <!-- My Account Tab Menu End -->
                        <!-- My Account Tab Content Start -->
                        <div class="col-lg-9 col-md-8" style="max-height: fit-content;">
                            <div class="tab-content" id="myaccountContent">
                                <!-- Single Tab Content Start -->
                                <div class="tab-pane fade {{ auth()->check() && auth()->user()->loainguoidung == 2 ? 'khonghienthi' : 'active show' }}"
                                    id="orders" role="tabpanel">
                                    <div class="myaccount-content">
                                        @if (!empty($danhSachPhieuXuat) && !empty($danhSachChiTietPhieuXuat) && !empty($danhSachThuVienHinh) && !empty($danhSachSanPham))
                                            @if (isset(request()->mapx))
                                                @foreach ($danhSachPhieuXuat as $phieuXuat)
                                                    @if (request()->mapx == $phieuXuat->maphieuxuat)
                                                        <a id="nutXem" class="register-button m-0 p-1 cangiua"
                                                            style="float:right; width: 92px!important;"
                                                            href="{{ url('taikhoan') }}">
                                                            <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;Quay lại</a>
                                                        <div id="donHangCanXem" style="margin-top:5px">
                                                            <h3>Thông tin PX{{ $phieuXuat->maphieuxuat }}</h3>
                                                            <div class="row mb-15">
                                                                <div class="col-6">
                                                                    <p class="mb-0">Họ tên:
                                                                        {{ $phieuXuat->hotennguoinhan }}</p>
                                                                    <p class="mb-0">Số điện thoại:
                                                                        {{ $phieuXuat->sodienthoainguoinhan }}</p>
                                                                    <p class="mb-0">Địa chỉ:
                                                                        {{ $phieuXuat->diachinguoinhan }}</p>
                                                                </div>
                                                                <div class="col-6">
                                                                    <p class="mb-0">Ngày đặt:
                                                                        {{ date('H:i d/m/Y', strtotime($phieuXuat->ngaytao)) }}
                                                                    </p>
                                                                    <p class="mb-0">Tình trạng giao hàng:
                                                                        @if ($phieuXuat->tinhtranggiaohang == 0)
                                                                            Đã hủy
                                                                        @elseif($phieuXuat->tinhtranggiaohang == 1)
                                                                            Chờ xác nhận
                                                                        @elseif($phieuXuat->tinhtranggiaohang == 2)
                                                                            Đang chuẩn bị hàng
                                                                        @elseif($phieuXuat->tinhtranggiaohang == 3)
                                                                            Đang giao hàng
                                                                        @elseif($phieuXuat->tinhtranggiaohang == 4)
                                                                            Đã giao thành công
                                                                        @endif
                                                                    </p>
                                                                    <p class="mb-0 pr-1 cantrai"
                                                                        style="line-height: 18px!important;">
                                                                        Ghi chú:
                                                                        <span>{{ $phieuXuat->ghichu }}</span>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="myaccount-table table-responsive text-center">
                                                                <table class="table table-bordered mb-0 bovientable"
                                                                    style="width: 100%;">
                                                                    <thead>
                                                                        <th width="1%">STT</th>
                                                                        <th width="1%">Bảo hành
                                                                        </th>
                                                                        <th width="1%">Hình ảnh
                                                                        </th>
                                                                        <th>Sản phẩm</th>
                                                                        <th width="1%">Số lượng
                                                                        </th>
                                                                        <th width="1%">Đơn giá</th>
                                                                        <th width="1%">Thành tiền
                                                                        </th>
                                                                    </thead>
                                                                    <tbody id="chiTietDonHangCanXem">
                                                                        @php
                                                                            $stt = 1;
                                                                        @endphp
                                                                        @foreach ($danhSachChiTietPhieuXuat as $chiTietPhieuXuat)
                                                                            @if ($chiTietPhieuXuat->maphieuxuat == $phieuXuat->maphieuxuat)
                                                                                <tr>
                                                                                    <td>{{ $stt++ }}
                                                                                    </td>
                                                                                    <td>{{ $chiTietPhieuXuat->baohanh < 10 ? '0' . $chiTietPhieuXuat->baohanh : $chiTietPhieuXuat->baohanh }}T
                                                                                    </td>
                                                                                    @foreach ($danhSachSanPham as $sanPham)
                                                                                        @if ($chiTietPhieuXuat->masanpham == $sanPham->masanpham)
                                                                                            @foreach ($danhSachThuVienHinh as $thuVienHinh)
                                                                                                @if ($sanPham->mathuvienhinh == $thuVienHinh->mathuvienhinh)
                                                                                                    <td><img style="width: 100%;"
                                                                                                            src="{{ asset('img/sanpham/' . $thuVienHinh->hinh1) }}">
                                                                                                    </td>
                                                                                                    {{-- @break --}}
                                                                                                @endif
                                                                                            @endforeach
                                                                                            <td class="cantrai pl-15">
                                                                                                <a class="mauchu-link"
                                                                                                    href="{{ url('chitietsp?masp=' . $sanPham->masanpham) }}">[SP{{ $sanPham->masanpham }}]
                                                                                                    -
                                                                                                    {{ $sanPham->tensanpham }}</a>
                                                                                            </td>
                                                                                            {{-- @break --}}
                                                                                        @endif
                                                                                    @endforeach
                                                                                    <td>{{ $chiTietPhieuXuat->soluong }}
                                                                                    </td>
                                                                                    <td class="canphai">
                                                                                        {{ number_format($chiTietPhieuXuat->dongia, 0, ',') }}
                                                                                    </td>
                                                                                    <td class="canphai">
                                                                                        {{ number_format($chiTietPhieuXuat->dongia * $chiTietPhieuXuat->soluong, 0, ',') }}
                                                                                    </td>
                                                                                </tr>
                                                                            @endif
                                                                        @endforeach
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <td colspan="4"></td>
                                                                            <td colspan="2" class="cantrai">Tổng
                                                                                cộng:
                                                                            </td>
                                                                            <td class="canphai">
                                                                                {{ number_format($phieuXuat->tongtien, 0, ',') }}
                                                                            </td>
                                                                        </tr>
                                                                        @if (!empty($danhSachMaGiamGia) && !empty($phieuXuat->magiamgia))
                                                                            @foreach ($danhSachMaGiamGia as $maGiamGia)
                                                                                @if ($maGiamGia->magiamgia == $phieuXuat->magiamgia)
                                                                                    <tr>
                                                                                        <td colspan="4"></td>
                                                                                        <td colspan="2"
                                                                                            class="cantrai">Giảm
                                                                                            ({{ $maGiamGia->magiamgia }})
                                                                                            :
                                                                                        </td>
                                                                                        <td class="canphai">
                                                                                            {{ number_format($maGiamGia->sotiengiam, 0, ',') }}
                                                                                        </td>
                                                                                    </tr>
                                                                                @break
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                    <tr>
                                                                        <td colspan="4"></td>
                                                                        <td colspan="2" class="cantrai">Đã thanh
                                                                            toán:
                                                                        </td>
                                                                        <td class="canphai">
                                                                            {{ number_format(!empty($maGiamGia->sotiengiam) ? $phieuXuat->tongtien+$phieuXuat->congno-$maGiamGia->sotiengiam : $phieuXuat->tongtien+$phieuXuat->congno, 0, ',') }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="4"></td>
                                                                        <td colspan="2" class="cantrai">Còn lại:
                                                                        </td>
                                                                        <td class="canphai">
                                                                            {{ number_format($phieuXuat->congno, 0, ',') }}
                                                                        </td>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    {{-- @break --}}
                                                @endif
                                            @endforeach
                                        @else
                                            <div id="danhSachDonHang">
                                                <h3>Danh sách đơn hàng</h3>
                                                <div class="myaccount-table table-responsive text-center">
                                                    <table class="table table-bordered mb-0">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th width="1%">Mã</th>
                                                                <th width="1%">Thời gian</th>
                                                                <th>Tên người nhận</th>
                                                                <th width="1%">Tình trạng giao hàng</th>
                                                                <th width="1%">Tổng tiền</th>
                                                                <th width="1%">Thao tác</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($danhSachPhieuXuat as $phieuXuat)
                                                                <tr>
                                                                    <td>PX{{ $phieuXuat->maphieuxuat }}</td>
                                                                    <td>{{ date('H:i d/m/Y', strtotime($phieuXuat->ngaytao)) }}
                                                                    </td>
                                                                    <td class="cantrai pl-15">
                                                                        {{ $phieuXuat->hotennguoinhan }}
                                                                    </td>
                                                                    <td>
                                                                        @if ($phieuXuat->tinhtranggiaohang == 0)
                                                                            Đã hủy
                                                                        @elseif($phieuXuat->tinhtranggiaohang == 1)
                                                                            Chờ xác nhận
                                                                        @elseif($phieuXuat->tinhtranggiaohang == 2)
                                                                            Đang chuẩn bị hàng
                                                                        @elseif($phieuXuat->tinhtranggiaohang == 3)
                                                                            Đang giao hàng
                                                                        @elseif($phieuXuat->tinhtranggiaohang == 4)
                                                                            Đã giao thành công
                                                                        @endif
                                                                    </td>
                                                                    <td class="canphai">
                                                                        @if (!empty($danhSachMaGiamGia) && !empty($phieuXuat->magiamgia))
                                                                            @foreach ($danhSachMaGiamGia as $maGiamGia)
                                                                                @if ($maGiamGia->magiamgia == $phieuXuat->magiamgia)
                                                                                    @php
                                                                                        $phieuXuat->tongtien -= $maGiamGia->sotiengiam;
                                                                                        break;
                                                                                    @endphp
                                                                                @endif
                                                                            @endforeach
                                                                        @endif
                                                                        {{ number_format($phieuXuat->tongtien, 0, ',') }}
                                                                    </td>
                                                                    <td>
                                                                        <a id="nutXem"
                                                                            class="register-button m-0 p-1"
                                                                            href="{{ url('taikhoan?mapx=' . $phieuXuat->maphieuxuat) }}">
                                                                            <i
                                                                                class="fa fa-eye"></i>&nbsp;&nbsp;Xem</a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <!-- Single Tab Content End -->
                            <!-- Single Tab Content Start -->
                            <div class="tab-pane fade {{ auth()->check() && auth()->user()->loainguoidung == 2 ? 'active show' : '' }}"
                                id="account-info" role="tabpanel">
                                <div class="myaccount-content">
                                    <h3>Thông tin Tài khoản</h3>
                                    <div class="account-details-form">
                                        <form action="{{ route('xulytaikhoan') }}" method="post">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="single-input-item">
                                                        <label>Email <span class="required">*</span>
                                                            @error('email')
                                                                <span
                                                                    style="color: red;font-size:10px">{{ $message }}</span>
                                                            @enderror
                                                        </label>
                                                        <input class="mb-0" name="email"
                                                            value="{{ auth()->check() ? auth()->user()->email : old('email') }}"
                                                            pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                                                            title="(Gồm các ký tự chữ thường hoặc số, có chứa @, có chứa dấu . sau ký tự @, tối đa 150 ký tự)"
                                                            type="email" required
                                                            {{ auth()->check() ? 'disabled' : '' }}>
                                                    </div>
                                                </div>
                                            </div>
                                            <fieldset>
                                                <legend>Đổi mật khẩu</legend>
                                                @if (!empty(session('loidoimatkhau')))
                                                    <div class="alert alert-danger">
                                                        <strong>Thất bại! </strong>
                                                        {{ session('loidoimatkhau') }}
                                                    </div>
                                                @endif
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="single-input-item">
                                                            <label>Mật khẩu cũ <span class="required">*</span>
                                                                @error('matKhauCu')
                                                                    <span
                                                                        style="color: red;font-size:10px">{{ $message }}</span>
                                                                @enderror
                                                            </label>
                                                            <input class="mb-0" name="matKhauCu" id="matKhauCu"
                                                                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,32}"
                                                                title="(Gồm các ký tự chữ thường, in hoa hoặc số, có chứa tối thiểu 1 ký tự thường, 1 ký tự in hoa và 1 ký tự số, từ 8-32 ký tự)"
                                                                type="password" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="single-input-item">
                                                            <label>Mật khẩu mới <span class="required">*</span>
                                                                @error('matKhauMoi')
                                                                    <span
                                                                        style="color: red;font-size:10px">{{ $message }}</span>
                                                                @enderror
                                                            </label>
                                                            <input class="mb-0" name="matKhauMoi"
                                                                id="matKhauMoi"
                                                                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,32}"
                                                                title="(Gồm các ký tự chữ thường, in hoa hoặc số, có chứa tối thiểu 1 ký tự thường, 1 ký tự in hoa và 1 ký tự số, từ 8-32 ký tự)"
                                                                type="password" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="single-input-item">
                                                            <label>Nhập lại mật khẩu mới <span
                                                                    class="required">*</span>
                                                                @error('nhapLaiMatKhauMoi')
                                                                    <span
                                                                        style="color: red;font-size:10px">{{ $message }}</span>
                                                                @enderror
                                                            </label>
                                                            <input class="mb-0" name="nhapLaiMatKhauMoi"
                                                                id="nhapLaiMatKhauMoi"
                                                                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,32}"
                                                                title="(Gồm các ký tự chữ thường, in hoa hoặc số, có chứa tối thiểu 1 ký tự thường, 1 ký tự in hoa và 1 ký tự số, từ 8-32 ký tự)"
                                                                type="password" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-10">
                                                    <div class="col-12">
                                                        <input class="mb-0" name="email"
                                                            value="{{ auth()->check() ? auth()->user()->email : old('email') }}"
                                                            pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                                                            title="(Gồm các ký tự chữ thường hoặc số, có chứa @, có chứa dấu . sau ký tự @, tối đa 150 ký tự)"
                                                            type="email" required hidden>
                                                        <div class="single-input-item">
                                                            <button type="submit" id="doiMatKhau" name="thaoTac"
                                                                value="đổi mật khẩu"
                                                                class="register-button mt-0">Thay
                                                                đổi</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Single Tab Content End -->
                            <!-- Single Tab Content Start -->
                            <div class="tab-pane fade" id="address-edit" role="tabpanel">
                                <div class="myaccount-content">
                                    <h3>Thông tin
                                        {{ auth()->check() && auth()->user()->loainguoidung == 2 ? 'Nhân viên' : 'Giao hàng' }}
                                    </h3>
                                    <div class="account-details-form">
                                        <form action="{{ route('xulytaikhoan') }}" method="post">
                                            @if (!empty(session('loidoithongtin')))
                                                <div class="alert alert-danger">
                                                    <strong>Thất bại! </strong>
                                                    {{ session('loidoithongtin') }}
                                                </div>
                                            @endif
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="single-input-item">
                                                        <label>Họ tên <span class="required">*</span>
                                                            @error('hoTen')
                                                                <span
                                                                    style="color: red;font-size:10px">{{ $message }}</span>
                                                            @enderror
                                                        </label>
                                                        <input class="mb-0"
                                                            title="(Gồm các ký tự là chữ thường hoặc in hoa, có dấu hoặc không dấu, tối đa 50 ký tự)"
                                                            name="hoTen"
                                                            value="{{ auth()->check() ? auth()->user()->hoten : old('hoTen') }}"
                                                            pattern="[a-zỳọáầảấờễàạằệếýộậốũứĩõúữịỗìềểẩớặòùồợãụủíỹắẫựỉỏừỷởóéửỵẳẹèẽổẵẻỡơôưăêâđA-ZỲỌÁẦẢẤỜỄÀẠẰỆẾÝỘẬỐŨỨĨÕÚỮỊỖÌỀỂẨỚẶÒÙỒỢÃỤỦÍỸẮẪỰỈỎỪỶỞÓÉỬỴẲẸÈẼỔẴẺỠƠÔƯĂÊÂĐ ]{3,50}"
                                                            type="text" required>
                                                    </div>
                                                </div>
                                                {{-- <div class="col-lg-6 pl-0 pt-1">
                                                            <button type="button" class="btn btn-focus mt-25 pt-2 pb-2" style="font-size:21.34px"><i class="fa fa-pencil-square-o"></i></button>
                                                        </div> --}}
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="single-input-item">
                                                        <label>Số điện thoại <span class="required">*</span>
                                                            @error('soDienThoai')
                                                                <span
                                                                    style="color: red;font-size:10px">{{ $message }}</span>
                                                            @enderror
                                                        </label>
                                                        <input class="mb-0"
                                                            value="{{ auth()->check() ? auth()->user()->sodienthoai : old('soDienThoai') }}"
                                                            title="(Gồm các ký tự là số, có bắt đầu là số 0, tối đa 9 chữ số - không bao gồm ký tự đầu là 0)"
                                                            name="soDienThoai" pattern="^[0]\d{9}$"
                                                            type="text" required>
                                                    </div>
                                                </div>
                                                {{-- <div class="col-lg-6 pl-0 pt-1">
                                                            <button type="button" class="btn btn-focus mt-25 pt-2 pb-2" style="font-size:21.34px"><i class="fa fa-pencil-square-o"></i></button>
                                                        </div> --}}
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="single-input-item">
                                                        <label>Địa chỉ <span class="required">*</span>
                                                            @error('diaChi')
                                                                <span
                                                                    style="color: red;font-size:10px">{{ $message }}</span>
                                                            @enderror
                                                        </label>
                                                        <input class="mb-0"
                                                            value="{{ auth()->check() ? auth()->user()->diachi : old('diaChi') }}"
                                                            title="(Gồm các ký tự là chữ thường, in hoa, số hoặc các ký tự như ,.-/ và tối đa 255 ký tự)"
                                                            name="diaChi"
                                                            pattern="[a-zỳọáầảấờễàạằệếýộậốũứĩõúữịỗìềểẩớặòùồợãụủíỹắẫựỉỏừỷởóéửỵẳẹèẽổẵẻỡơôưăêâđA-ZỲỌÁẦẢẤỜỄÀẠẰỆẾÝỘẬỐŨỨĨÕÚỮỊỖÌỀỂẨỚẶÒÙỒỢÃỤỦÍỸẮẪỰỈỎỪỶỞÓÉỬỴẲẸÈẼỔẴẺỠƠÔƯĂÊÂĐ0-9 -/,.]{3,255}"
                                                            type="text" required>
                                                    </div>
                                                </div>
                                                {{-- <div class="col-lg-6 pl-0 pt-1">
                                                            <button type="button" class="btn btn-focus mt-25 pt-2 pb-2" style="font-size:21.34px"><i class="fa fa-pencil-square-o"></i></button>
                                                        </div> --}}
                                            </div>
                                            <div class="row mt-10">
                                                <div class="col-12">
                                                    <input class="mb-0" name="email"
                                                        value="{{ auth()->check() ? auth()->user()->email : old('email') }}"
                                                        pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                                                        title="(Gồm các ký tự chữ thường hoặc số, có chứa @, có chứa dấu . sau ký tự @, tối đa 150 ký tự)"
                                                        type="email" required hidden>
                                                    <div class="single-input-item">
                                                        <button type="submit" id="doiThongTin" name="thaoTac"
                                                            value="đổi thông tin"
                                                            class="register-button mt-0">Thay
                                                            đổi</button>
                                                    </div>
                                                </div>
                                            </div>
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Single Tab Content End -->
                        </div>
                    </div> <!-- My Account Tab Content End -->
                </div>
            </div> <!-- My Account Page End -->
        </div>
    </div>
</div>
</div>
<!-- Login Content Area End Here -->
@endsection
@section('js')
{{-- thêm js --}}
<script>
    $('#doiMatKhau').click(function() {
        var matKhauCu = document.getElementById('matKhauCu');
        var matKhauMoi = document.getElementById('matKhauMoi');
        var nhapLaiMatKhauMoi = document.getElementById('nhapLaiMatKhauMoi');
        if (matKhauCu.value == matKhauMoi.value) {
            matKhauMoi.value = null;
            nhapLaiMatKhauMoi.value = null;
            alert("Mật khẩu cũ và mật khẩu mới trùng nhau!");
        }
        if (matKhauMoi.value != nhapLaiMatKhauMoi.value) {
            nhapLaiMatKhauMoi.value = null;
            alert("Mật khẩu mới và nhập lại mật khẩu mới không khớp nhau!");
        }
    });
</script>
@endsection
