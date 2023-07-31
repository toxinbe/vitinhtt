<!-- Begin Header Area -->
<header>
    <!-- Begin Header Top Area -->
    <div class="header-top">
        <div class="container">
            <div class="row">
                <!-- Begin Header Top Left Area -->
                <div class="col-lg-9">
                    <div class="header-top-left">
                        <ul class="phone-wrap">
                            <li><a href="tel: 0901234567">SĐT: 090.xxx.xnxx (Mr. Tiến)</a></li>
                            <li><a href="{{route('lienhe')}}">Địa chỉ: 180 Cao Lỗ, Phường 4, Quận 8, TP.HCM</a></li>
                        </ul>
                    </div>
                </div>
                <!-- Header Top Left Area End Here -->
                <!-- Begin Header Top Right Area -->
                <div class="col-lg-3">
                    <div class="header-top-right">
                        <ul class="ht-menu">
                            <!-- Begin Setting Area -->
                            <li>
                                <div class="ht-setting-trigger"><a
                                        href="{{ auth()->check() ? '#' : route('dangnhap') }}"><i
                                            class="fa fa-user"></i>&nbsp;{{ auth()->check() ? auth()->user()->hoten : 'Đăng nhập / Đăng ký' }}</a>
                                </div>
                                <div class="setting ht-setting pb-0"
                                    {{ auth()->check() ? 'id=chucNangTaiKhoan' : '' }}>
                                    <ul class="ht-setting-list">
                                        {!! auth()->check() && auth()->user()->loainguoidung != 2
                                            ? ''
                                            : '<li><a href="' . route('tongquan') . '">Quản lý</a></li>' !!}
                                        <li><a href="{{ route('taikhoan') }}">Tài khoản</a></li>
                                        <li><a href="{{ route('dangxuat') }}">Đăng xuất</a></li>
                                    </ul>
                                </div>
                            </li>
                            <!-- Setting Area End Here -->
                            <!-- Begin Currency Area -->
                        </ul>
                    </div>
                </div>
                <!-- Header Top Right Area End Here -->
            </div>
        </div>
    </div>
    <!-- Header Top Area End Here -->
    <!-- Begin Header Middle Area -->
    <div class="header-middle pl-sm-0 pr-sm-0 pl-xs-0 pr-xs-0">
        <div class="container">
            <div class="row">
                <!-- Begin Header Logo Area -->
                <div class="col-lg-3">
                    <div class="logo pb-sm-30 pb-xs-30">
                        <a href="{{ route('/') }}">
                            <img width="85%" src="{{ asset('img/logo/full.png') }}" alt="">
                        </a>
                    </div>
                </div>
                <!-- Header Logo Area End Here -->
                <!-- Begin Header Middle Right Area -->
                <div class="col-lg-9 pl-0 ml-sm-15 ml-xs-15">
                    <!-- Begin Header Middle Searchbox Area -->
                    <form action="{{ route('timkiem') }}" method="get" class="hm-searchbox">
                        @if (!empty($danhSachHangSanXuat))
                            <select name="boloc" class="nice-select select-search-category">
                                <option value="0">Tất cả</option>
                                <option value="-1">Laptop</option>
                                @foreach ($danhSachHangSanXuat as $hangSanXuat)
                                    @if ($hangSanXuat->loaihang == 0)
                                        <option value="{{ $hangSanXuat->mahang }}">--{{ $hangSanXuat->tenhang }}
                                        </option>
                                    @endif
                                @endforeach
                                <option value="-2">Phụ kiện</option>
                                @foreach ($danhSachHangSanXuat as $hangSanXuat)
                                    @if ($hangSanXuat->loaihang == 1)
                                        <option value="{{ $hangSanXuat->mahang }}">--{{ $hangSanXuat->tenhang }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        @endif
                        <input type="text" name="tukhoa"
                            value="{{ !empty(request()->tukhoa) ? request()->tukhoa : '' }}"
                            placeholder="Tìm kiếm sản phẩm ...">
                        <button class="li-btn" type="submit"><i class="fa fa-search"></i></button>
                    </form>
                    <!-- Header Middle Searchbox Area End Here -->
                    <!-- Begin Header Middle Right Area -->
                    <div class="header-middle-right">
                        <ul class="hm-menu">
                            <!-- Begin Header Middle Wishlist Area -->
                            <li class="hm-wishlist">
                                <a href="{{ route('yeuthich') }}">
                                    <span class="cart-item-count wishlist-item-count">{{ !empty(session('yeuThich')) ? count(session('yeuThich')) : '' }}</span>
                                    <i class="fa fa-heart-o"></i>
                                </a>
                            </li>
                            <!-- Header Middle Wishlist Area End Here -->
                            <!-- Begin Header Mini Cart Area -->
                            <li class="hm-minicart">
                                <div class="hm-minicart-trigger">
                                    <span class="item-text tensanpham chumauden"><i
                                            class="fa fa-shopping-cart"></i>&nbsp;&nbsp;Giỏ Hàng
                                        <span
                                            class="cart-item-count">{{ !empty(session('gioHang')) ? count(session('gioHang')) : '' }}</span>
                                    </span>
                                </div>
                                @if (!empty(session('gioHang')))
                                    <span></span>
                                    <div class="minicart">
                                        <ul class="minicart-product-list">
                                            @php
                                                $tongTienGioHang = 0;
                                            @endphp
                                            @foreach (session('gioHang') as $ctgh)
                                                <li>
                                                    <a href="{{ url('chitietsp?masp=' . $ctgh['masanpham']) }}" class="minicart-product-image">
                                                        <img src="{{ asset('img/sanpham/' . $ctgh['hinh']) }}"
                                                            alt="cart products">
                                                    </a>
                                                    <div class="minicart-product-details">
                                                        <h6><a
                                                                href="{{ url('chitietsp?masp=' . $ctgh['masanpham']) }}">[SP{{ $ctgh['masanpham'] }}]
                                                                - {{ $ctgh['tensanpham'] }}</a>
                                                        </h6>
                                                        @if (!empty($ctgh['giakhuyenmai']))
                                                            <span>{{ $ctgh['soluongmua'] }} x
                                                                {{ number_format($ctgh['giakhuyenmai'], 0, ',') }}đ</span>
                                                            @php
                                                                $tongTienGioHang += $ctgh['soluongmua'] * $ctgh['giakhuyenmai'];
                                                            @endphp
                                                        @else
                                                            <span>{{ $ctgh['soluongmua'] }} x
                                                                {{ number_format($ctgh['giaban'], 0, ',') }}đ</span>
                                                            @php
                                                                $tongTienGioHang += $ctgh['soluongmua'] * $ctgh['giaban'];
                                                            @endphp
                                                        @endif
                                                    </div>
                                                    <form action="{{ route('xulygiohang') }}" method="post">
                                                        <input hidden value="{{ $ctgh['masanpham'] }}" type="number"
                                                            name="maSanPhamMuaXoa" required>
                                                        <button type="submit" name="thaoTac" value="xóa giỏ hàng"
                                                            class="close" title="Xóa">
                                                            <i class="fa fa-close"></i>
                                                        </button>
                                                        @csrf
                                                    </form>
                                                </li>
                                            @endforeach
                                            {{-- <li>
                                                <div class="minicart-product-details pl-10">
                                                    <h6 style="display: inline-block; width: fit-content">TỔNG:</h6>
                                                    <span style="display:flex;float:right">{{ number_format($tongTienGioHang, 0, ',') }}đ</span>
                                                </div>
                                            </li>
                                            @if (!empty(session('maGiamGia')))
                                                @php
                                                    $tongTienGioHang -= session('maGiamGia')->sotiengiam;
                                                @endphp
                                                <li>
                                                    <div class="minicart-product-details pl-10">
                                                        <h6 style="display: inline-block; width: fit-content">Giảm ({{session('maGiamGia')->magiamgia}}):</h6>
                                                        <span style="display:flex;float:right">{{ number_format(session('maGiamGia')->sotiengiam, 0, ',') }}đ</span>
                                                    </div>
                                                </li>
                                            @endif --}}
                                        </ul>
                                        <p class="minicart-total">TỔNG:
                                            <span
                                                class="vietthuong">{{ number_format($tongTienGioHang, 0, ',') }}đ</span>
                                        </p>
                                        <div class="minicart-button">
                                            <a href="{{ route('giohang') }}"
                                                class="li-button li-button-fullwidth li-button-dark">
                                                <span>Chi tiết</span>
                                            </a>
                                            <a href="{{ route('thanhtoan') }}" class="li-button li-button-fullwidth">
                                                <span>Thanh toán</span>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </li>
                            <!-- Header Mini Cart Area End Here -->
                        </ul>
                    </div>
                    <!-- Header Middle Right Area End Here -->
                </div>
                <!-- Header Middle Right Area End Here -->
            </div>
        </div>
    </div>
    <!-- Header Middle Area End Here -->
    <!-- Begin Header Bottom Area -->
    <div class="header-bottom header-sticky d-none d-lg-block d-xl-block mb-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Begin Header Bottom Menu Area -->
                    <div class="hb-menu">
                        <nav>
                            <ul>
                                <li class="dropdown-holder {{ request()->is('/') ? 'menu-active' : '' }} pl-0 pr-0">
                                    <a class="pl-20 pr-20" href="{{ route('/') }}">Trang chủ</a>
                                </li>
                                <li
                                    class="megamenu-holder pl-0 pr-0 {{ request()->is('danhsachsp') && request()->loaisp == 0 && request()->loaisp != null ? 'menu-active' : '' }}">
                                    <a class="pl-20 pr-20" href="{{ url('danhsachsp?loaisp=0') }}">Laptop</a>
                                    <ul class="megamenu hb-megamenu">
                                        <li>HÃNG SẢN XUẤT
                                            <ul>
                                                @if (!empty($danhSachHangSanXuat))
                                                    @foreach ($danhSachHangSanXuat as $hangSanXuat)
                                                        @if ($hangSanXuat->loaihang == 0)
                                                            <li><a
                                                                    href="{{ url('danhsachsp') . '?loaisp=0&hangsx=' . $hangSanXuat->mahang }}">{{ $hangSanXuat->tenhang }}</a>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </li>
                                        <li>MỨC GIÁ
                                            <ul>
                                                <li><a href="{{ url('danhsachsp') . '?loaisp=0&mucgia=duoi10' }}">Dưới
                                                        10 triệu</a></li>
                                                <li><a href="{{ url('danhsachsp') . '?loaisp=0&mucgia=1015' }}">10-15
                                                        triệu</a></li>
                                                <li><a href="{{ url('danhsachsp') . '?loaisp=0&mucgia=1520' }}">15-20
                                                        triệu</a></li>
                                                <li><a href="{{ url('danhsachsp') . '?loaisp=0&mucgia=tren20' }}">Trên
                                                        20 triệu</a></li>
                                            </ul>
                                        </li>
                                        <li>NHU CẦU SỬ DỤNG
                                            <ul>
                                                <li><a href="{{ url('danhsachsp') . '?loaisp=0&nhucau=sinhvien' }}">Laptop
                                                        Sinh Viên</a></li>
                                                <li><a href="{{ url('danhsachsp') . '?loaisp=0&nhucau=dohoa' }}">Laptop
                                                        Đồ Họa</a></li>
                                                <li><a href="{{ url('danhsachsp') . '?loaisp=0&nhucau=gaming' }}">Laptop
                                                        Gaming</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li
                                    class="pl-0 pr-0 {{ request()->is('danhsachsp') && request()->loaisp == 1 ? 'menu-active' : '' }}">
                                    <a class="pl-20 pr-20" href="{{ url('timkiem?boloc=-2') }}">Phụ kiện</a>
                                </li>
                                {{-- <li class="{{ (request()->is('tragop')) ? 'menu-active' : '' }}"><a href="{{ route('tragop') }}">Trả góp</a></li> --}}
                                <li class="pl-0 pr-0 {{ request()->is('baohanh') ? 'menu-active' : '' }}"><a
                                        class="pl-20 pr-20" href="{{ route('baohanh') }}">Bảo hành</a></li>
                                <li class="pl-0 pr-0 {{ request()->is('lienhe') ? 'menu-active' : '' }}"><a
                                        class="pl-20 pr-20" href="{{ route('lienhe') }}">Liên hệ</a></li>
                            </ul>
                        </nav>
                    </div>
                    <!-- Header Bottom Menu Area End Here -->
                </div>
            </div>
        </div>
    </div>
    <!-- Header Bottom Area End Here -->
    <!-- Begin Mobile Menu Area -->
    <div class="mobile-menu-area d-lg-none d-xl-none col-12">
        <div class="container">
            <div class="row">
                <div class="mobile-menu">
                </div>
            </div>
        </div>
    </div>
    <!-- Mobile Menu Area End Here -->
</header>
