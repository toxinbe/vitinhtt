<div class="main-header">
    <!-- Logo Header -->
    <div class="logo-header" data-background-color="blue">
        <div class="reset">
            <a href="{{ route('tongquan') }}" class="logo">
                <img src="{{ asset('img/logo/adminfull.png') }}" alt="navbar brand" class="navbar-brand">
            </a>
        </div>
        <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse"
            data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
                <i class="icon-menu"></i>
            </span>
        </button>
        <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
        <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar">
                <i class="icon-menu"></i>
            </button>
        </div>
    </div>
    <!-- End Logo Header -->

    <!-- Navbar Header -->
    <nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue">

        <div class="container-fluid">
            {{-- <div class="collapse" id="search-nav">
                <form class="navbar-left navbar-form nav-search mr-md-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <button type="submit" class="btn btn-search pr-1">
                                <i class="fa fa-search search-icon"></i>
                            </button>
                        </div>
                        <input type="text" placeholder="Tìm kiếm ..." class="form-control">
                    </div>
                </form>
            </div> --}}
            <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                @if (!empty($danhSachLoiPhanHoiChuaDoc))
                    <li class="nav-item dropdown hidden-caret">
                        <a class="nav-link dropdown-toggle" href="#" id="messageDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-envelope"></i>
                            <span class="notification"
                                style="letter-spacing:0px">{{ count($danhSachLoiPhanHoiChuaDoc) }}</span>
                        </a>
                        <ul class="dropdown-menu messages-notif-box animated fadeIn" aria-labelledby="messageDropdown">
                            <li>
                                <div class="dropdown-title d-flex justify-content-between align-items-center">
                                    Lời nhắn liên hệ
                                    <a href="{{url('tongquan?thaotac=doitrangthaitatca')}}" class="small"><i class="fa fa-check"></i> Đã đọc tất cả</a>
                                </div>
                            </li>
                            <li>
                                <div class="message-notif-scroll scrollbar-outer">
                                    @foreach ($danhSachLoiPhanHoiChuaDoc as $loiPhanHoi)
                                        <div class="row container p-0 m-0 notif-center" style="display:block">
                                            <a href="{{url('tongquan?thaotac=doitrangthai&maloiphanhoi='.$loiPhanHoi->maloiphanhoi)}}" class="thongbao pt-1 pb-1">
                                                <div class="col-3 icon-thongbao" style="max-width: 20%">
                                                    <i class="fas fa-envelope"></i>
                                                </div>
                                                <div class="col-9" style="padding:7px 12px 7px 0px;">
                                                    <p class="p-0 m-0 tieude-thongbao" style="font-weight: bold">
                                                        {{ $loiPhanHoi->hoten }}</p>
                                                    <p class="p-0 m-0 mt-1 thoigian-thongbao noidung-thongbao">
                                                        @php
                                                            $noiDung = $loiPhanHoi->noidung;
                                                            if(empty($noiDung)){
                                                                $noiDung = 'Tôi cần tư vấn qua SĐT: ' . $loiPhanHoi->sodienthoai;
                                                            }
                                                            $soLuongKyTu = strlen($noiDung);
                                                            $tam = '';
                                                            $demTu = 0;
                                                            for ($j = 0; $j < $soLuongKyTu; $j++) {
                                                                if ($noiDung[$j] == ' ' && $demTu < 7) {
                                                                    $demTu++;
                                                                } elseif ($demTu == 7) {
                                                                    $tam[$j] = '.';
                                                                    $tam[$j + 1] = '.';
                                                                    $tam[$j + 2] = '.';
                                                                    break;
                                                                }
                                                                $tam[$j] = $noiDung[$j];
                                                            }
                                                            $noiDung = $tam;
                                                        @endphp
                                                        {{ $noiDung }}
                                                    </p>
                                                    <p class="p-0 m-0 mt-1 thoigian-thongbao">Lúc
                                                        {{ date('H:i d/m/Y', strtotime($loiPhanHoi->ngaytao)) }}</p>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </li>
                            <li>
                                <a class="see-all" href="{{url('tongquan#loiphanhoi')}}">Xem tất cả<i class="fa fa-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item dropdown hidden-caret">
                        <a class="nav-link dropdown-toggle" href="#" id="messageDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-envelope"></i>
                        </a>
                        <ul class="dropdown-menu messages-notif-box animated fadeIn" aria-labelledby="messageDropdown">
                            <li>
                                <div class="dropdown-title d-flex justify-content-between align-items-center">
                                    Chưa có lời nhắn liên hệ mới
                                </div>
                            </li>
                            <li>
                                <a class="see-all" href="{{url('tongquan#loiphanhoi')}}">Xem tất cả<i class="fa fa-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if (!empty($danhSachPhieuXuatChoXacNhan))
                    <li class="nav-item dropdown hidden-caret">
                        <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bell"></i>
                            <span class="notification"
                                style="letter-spacing:0px">{{ count($danhSachPhieuXuatChoXacNhan) }}</span>
                        </a>
                        <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                            <li>
                                <div class="dropdown-title">Có {{ count($danhSachPhieuXuatChoXacNhan) }} đơn hàng
                                    chờ
                                    xác nhận
                                </div>
                            </li>
                            <li>
                                @foreach ($danhSachPhieuXuatChoXacNhan as $phieuXuat)
                                    <div class="row container p-0 m-0 notif-center">
                                        <a href="{{ url('suaphieuxuat?id=') . $phieuXuat->maphieuxuat }}"
                                            class="thongbao pt-1 pb-1">
                                            <div class="col-2 icon-thongbao">
                                                <i class="fas fa-file-invoice-dollar"></i>
                                            </div>
                                            <div class="col-10" style="padding:7px 12px 7px 0px;">
                                                <p class="p-0 m-0 tieude-thongbao">
                                                    {{ $phieuXuat->hotennguoinhan }} vừa đặt đơn hàng mới
                                                </p>
                                                <p class="p-0 m-0 mt-1 thoigian-thongbao">Lúc
                                                    {{ date('H:i d/m/Y', strtotime($phieuXuat->ngaytao)) }}</p>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </li>
                            <li>
                                <a class="see-all" href="{{ url('phieuxuat?ttgh=1') }}">Xem tất cả<i
                                        class="fa fa-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item dropdown hidden-caret">
                        <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bell"></i>
                        </a>
                        <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                            <li>
                                <div class="dropdown-title">Chưa có đơn hàng mới</div>
                            </li>
                            <li>
                                <a class="see-all" href="{{ url('phieuxuat') }}">Xem tất cả đơn hàng<i
                                        class="fa fa-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                <li class="nav-item dropdown hidden-caret">
                    <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fas fa-layer-group"></i>
                    </a>
                    <div class="dropdown-menu quick-actions quick-actions-info animated fadeIn">
                        <div class="quick-actions-header">
                            <span class="title mb-1">Thao Tác Nhanh</span>
                            <span class="subtitle op-8">Lối tắt</span>
                        </div>
                        <div class="quick-actions-scroll scrollbar-outer">
                            <div class="quick-actions-items">
                                <div class="row m-0">
                                    <a class="col-6 col-md-6 p-0" href="{{ route('themphieunhap') }}">
                                        <div class="quick-actions-item">
                                            <i class="fas fa-truck-loading"></i>
                                            <span class="text">Nhập Hàng</span>
                                        </div>
                                    </a>
                                    <a class="col-6 col-md-6 p-0" href="{{ route('themphieuxuat') }}">
                                        <div class="quick-actions-item">
                                            <i class="fas fa-store-alt"></i>
                                            <span class="text">Xuất Hàng</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown hidden-caret">
                    <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"
                        aria-expanded="false">
                        <div class="avatar-sm">
                            <img src="{{ asset('img/logo/adminmini.png') }}" alt="..."
                                class="avatar-img rounded-circle">
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                        <div class="dropdown-user-scroll scrollbar-outer">
                            <li>
                                <div class="user-box">
                                    <div class="avatar-lg"><img src="{{ asset('img/logo/adminmini.png') }}"
                                            alt="image profile" class="avatar-img rounded"></div>
                                    <div class="u-text pl-3">
                                        <h4>{{ auth()->check() && auth()->user()->loainguoidung == 2 ? auth()->user()->hoten : 'Admin' }}
                                        </h4>
                                        <p class="text-muted">
                                            {{ auth()->check() && auth()->user()->loainguoidung == 2 ? auth()->user()->email : 'admin@vitinhtt.com' }}
                                        </p>
                                        <a href="{{ route('taikhoan') }}"
                                            class="btn btn-xs btn-secondary btn-sm nenxanh">Tài khoản</a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item cangiua" href="{{ route('dangxuat') }}">Đăng xuất</a>
                            </li>
                        </div>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <!-- End Navbar -->
</div>
