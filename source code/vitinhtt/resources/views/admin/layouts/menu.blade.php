<!-- Sidebar -->
<div class="sidebar sidebar-style-2">

    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-primary">
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Quản lý</h4>
                </li>
                <li class="nav-item {{ request()->is('tongquan') ? 'active' : '' }}">
                    <a href="{{ route('tongquan') }}">
                        <i class="fas fa-chart-line"></i>
                        <p>Tổng Quan</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('laptop') || request()->is('phukien') || request()->is('hangsanxuat') ? 'active' : '' }}">
                    <a data-toggle="collapse" href="#sanpham">
                        <i class="fas fa-store-alt"></i>
                        <p>Sản Phẩm</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="sanpham">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ route('laptop') }}">
                                    <span class="sub-item">Laptop</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('phukien') }}">
                                    <span class="sub-item">Phụ Kiện</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('hangsanxuat') }}">
                                    <span class="sub-item">Hãng Sản Xuất</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item {{ request()->is('phieuxuat')||request()->is('phieunhap')||request()->is('themphieunhap')||request()->is('suaphieunhap')||request()->is('themphieuxuat')||request()->is('suaphieuxuat') ? 'active' : '' }}">
                    <a data-toggle="collapse" href="#giaodich">
                        <i class="fas fa-exchange-alt"></i>
                        <p>Giao Dịch</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="giaodich">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ route('phieuxuat') }}">
                                    <span class="sub-item">Phiếu Xuất</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('phieunhap') }}">
                                    <span class="sub-item">Phiếu Nhập</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item {{ request()->is('magiamgia') ? 'active' : '' }}">
                    <a href="{{ route('magiamgia') }}">
                        <i class="fas fa-gift"></i>
                        <p>Mã Giảm Giá</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('nguoidung') ? 'active' : '' }}">
                    <a href="{{ route('nguoidung') }}">
                        <i class="fas fa-user"></i>
                        <p>Người Dùng</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
