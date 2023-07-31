@extends('user.layouts.client')
@section('title')
    Danh sách sản phẩm
@endsection
@section('head')
    {{-- thêm css --}}
@endsection
@section('content')
    <div class="breadcrumb-area">
        <div class="container">
            <div class="breadcrumb-content">
                <ul>
                    <li><a href="{{ route('/') }}">Trang chủ</a></li>
                    <li class="active"><a
                            href="{{ isset(request()->loaisp) ? url('danhsachsp?loaisp=' . request()->loaisp) : route('danhsachsp') }}">Danh
                            sách sản phẩm</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="content-wraper pb-60 pt-sm-30">
        <div class="container">
            <div class="row mb-30">
                <div class="col-lg-12">
                    <!-- Begin Li's Banner Area -->
                    <div class="single-banner shop-page-banner">
                        <a href="#">
                            <img src="{{ asset('img/banner/dssp.jpg') }}" alt="Li's Static Banner">
                        </a>
                    </div>
                    <!-- Li's Banner Area End Here -->
                </div>
            </div>
            <div class="row">
                <div class="col-lg-9 order-1 order-lg-2">
                    <!-- shop-top-bar start -->
                    <div class="shop-top-bar">
                        <div class="shop-bar-inner">
                            <div class="product-view-mode">
                                <!-- shop-item-filter-list start -->
                                <ul class="nav shop-item-filter-list" role="tablist">
                                    <li class="active" role="presentation"><a aria-selected="true" class="active show"
                                            data-toggle="tab" role="tab" aria-controls="grid-view" href="#grid-view"><i
                                                class="fa fa-th"></i></a></li>
                                    <li role="presentation"><a data-toggle="tab" role="tab" aria-controls="list-view"
                                            href="#list-view"><i class="fa fa-th-list"></i></a></li>
                                </ul>
                                <!-- shop-item-filter-list end -->
                            </div>
                            <div class="toolbar-amount">
                                <span>Tổng sản phẩm ({{ count($danhSachSanPham) }})</span>
                            </div>
                        </div>
                        <!-- product-select-box start -->
                        <div class="product-select-box">
                            <div class="product-short">
                                <p>Sắp xếp:</p>
                                <form>
                                    <select id="sapxep" class="nice-select">
                                        <option {{ request()->sapxep == 'moinhat' ? 'selected' : '' }} value="moinhat">
                                            Mới nhất</option>
                                        <option {{ request()->sapxep == 'banchaynhat' ? 'selected' : '' }}
                                            value="banchaynhat">
                                            Bán chạy nhất</option>
                                        <option {{ request()->sapxep == 'uudainhat' ? 'selected' : '' }}
                                            value="uudainhat">
                                            Ưu đãi nhất</option>
                                        <option {{ request()->sapxep == 'giatangdan' ? 'selected' : '' }}
                                            value="giatangdan">
                                            Giá tăng dần</option>
                                        <option {{ request()->sapxep == 'giagiamdan' ? 'selected' : '' }}
                                            value="giagiamdan">
                                            Giá giảm dần</option>
                                    </select>
                                    @csrf
                                </form>
                            </div>
                        </div>
                        <!-- product-select-box end -->
                    </div>
                    <!-- shop-top-bar end -->
                    <!-- shop-products-wrapper start -->
                    <div class="shop-products-wrapper">
                        <div class="tab-content">
                            <div id="grid-view" class="tab-pane fade active show" role="tabpanel">
                                <div class="product-area shop-product-area">
                                    <div class="row">
                                        @if (!empty($danhSachSanPham))
                                            @foreach ($danhSachSanPham as $sanPham)
                                                <!-- single-product-wrap start -->
                                                <div class="col-lg-4 col-md-4 col-sm-6 mt-40">
                                                    <div class="single-product-wrap">
                                                        <div class="product-image">
                                                            <a class="pr-15 pl-15"
                                                                href="{{ url('chitietsp?masp=' . $sanPham->masanpham) }}">
                                                                @if (!empty($danhSachThuVienHinh))
                                                                    @foreach ($danhSachThuVienHinh as $thuVienHinh)
                                                                        @if ($thuVienHinh->mathuvienhinh == $sanPham->mathuvienhinh)
                                                                            <img src="{{ asset('img/sanpham/' . $thuVienHinh->hinh1) }}"
                                                                                alt="Li's Product Image">
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            </a>
                                                            @if (!empty($danhSachLaptop))
                                                                @foreach ($danhSachLaptop as $laptop)
                                                                    @if ($laptop->malaptop == $sanPham->malaptop)
                                                                        @if ($laptop->tinhtrang == 0)
                                                                            <span class="sticker">Mới</span>
                                                                        @else
                                                                            <span class="sticker tinhtrangcu">Cũ</span>
                                                                        @endif
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                        <div class="product_desc">
                                                            <div class="product_desc_info">
                                                                <div class="product-review">
                                                                    <h5 class="manufacturer">
                                                                        <a class="mauchu-link"
                                                                            href="{{ url('danhsachsp?loaisp=' . $sanPham->loaisanpham) }}">
                                                                            @if ($sanPham->loaisanpham == 0)
                                                                                Laptop
                                                                            @else
                                                                                Phụ Kiện
                                                                            @endif
                                                                        </a>
                                                                    </h5>
                                                                </div>
                                                                <h4><a class="product_name tensanpham"
                                                                        href="{{ url('chitietsp?masp=' . $sanPham->masanpham) }}">{{ $sanPham->tensanpham }}</a>
                                                                </h4>
                                                                <h5 class="manufacturer">SP{{ $sanPham->masanpham }}</h5>
                                                                <div class="price-box">
                                                                    @if (!empty($sanPham->giakhuyenmai))
                                                                        <p class="new-price giakhuyenmai">
                                                                            {{ number_format($sanPham->giakhuyenmai, 0, ',') }}đ
                                                                        </p>
                                                                        <p class="new-price giaban">
                                                                            {{ number_format($sanPham->giaban, 0, ',') }}đ
                                                                        </p>
                                                                    @else
                                                                        @if ($sanPham->giaban > 0)
                                                                            <p class="new-price giakhuyenmai">
                                                                                {{ number_format($sanPham->giaban, 0, ',') }}đ
                                                                            </p>
                                                                        @else
                                                                            <p class="new-price giakhuyenmai">
                                                                                Liên hệ</p>
                                                                        @endif
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="add-actions">
                                                                <ul class="ulthemgiohang pt-0 mt-0">
                                                                    <li>
                                                                        <form action="{{ route('xulygiohang') }}"
                                                                            method="post">
                                                                            <button
                                                                                class="btn btn-focus p-1 pr-10 pl-10 fontsize15"
                                                                                type="submit" name="thaoTac"
                                                                                value="thêm giỏ hàng">thêm giỏ hàng</button>
                                                                            <input hidden value="1" type="number"
                                                                                min="1" max="1"
                                                                                name="soLuongMua" required>
                                                                            <input hidden
                                                                                value="{{ $sanPham->masanpham }}"
                                                                                type="number" name="maSanPhamMua" required>
                                                                            @error('maSanPhamMua')
                                                                                <div
                                                                                    style="color: red;font-size:10px;display:inline-block;width:100%">
                                                                                    {{ $message }}</div>
                                                                            @enderror
                                                                            @error('soLuongMua')
                                                                                <div
                                                                                    style="color: red;font-size:10px;display:inline-block;width:100%">
                                                                                    {{ $message }}</div>
                                                                            @enderror
                                                                            @csrf
                                                                        </form>
                                                                    </li>
                                                                    {{-- <li><a href="{{ url('chitietsp?masp=' . $sanPham->masanpham) }}" title="quick view"
                                                                                                            class="quick-view-btn" data-toggle="modal"
                                                                                                            data-target="#exampleModalCenter"><i
                                                                                                                class="fa fa-eye"></i></a></li> --}}
                                                                    <li class="ml-2">
                                                                        @php
                                                                            $flag = false;
                                                                            if (!empty(session('yeuThich'))) {
                                                                                foreach (session('yeuThich') as $ctyt) {
                                                                                    if ($ctyt['masanpham'] == $sanPham->masanpham) {
                                                                                        $flag = true;
                                                                                        break;
                                                                                    }
                                                                                }
                                                                            }
                                                                        @endphp
                                                                        @if ($flag)
                                                                            <a class="links-details btn btn-focus p-1 pr-10 pl-10 fontsize15"
                                                                                href="{{ url('xulyyeuthich?thaotac=boyeuthich&masp=' . $sanPham->masanpham) }}"><i
                                                                                    class="fa fa-heart"></i></a>
                                                                        @else
                                                                            <a class="links-details btn btn-focus p-1 pr-10 pl-10 fontsize15"
                                                                                href="{{ url('xulyyeuthich?thaotac=yeuthich&masp=' . $sanPham->masanpham) }}"><i
                                                                                    class="fa fa-heart-o"></i></a>
                                                                        @endif
                                                                    </li>
                                                                    <li class="ml-2"><a
                                                                            class="links-details btn btn-focus p-1 pr-10 pl-10 fontsize15"
                                                                            href="{{ url('chitietsp?masp=' . $sanPham->masanpham) }}"><i
                                                                                class="fa fa-eye"></i></a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- single-product-wrap end -->
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div id="list-view" class="tab-pane fade product-list-view" role="tabpanel">
                                <div class="row">
                                    <div class="col">
                                        @if (!empty($danhSachSanPham))
                                            @foreach ($danhSachSanPham as $sanPham)
                                                <!-- single-product-wrap start -->
                                                <div class="row product-layout-list">
                                                    <div class="col-lg-3 col-md-5 ">
                                                        <div class="product-image">
                                                            <a
                                                                href="{{ url('chitietsp?masp=' . $sanPham->masanpham) }}">
                                                                @if (!empty($danhSachThuVienHinh))
                                                                    @foreach ($danhSachThuVienHinh as $thuVienHinh)
                                                                        @if ($thuVienHinh->mathuvienhinh == $sanPham->mathuvienhinh)
                                                                            <img src="{{ asset('img/sanpham/' . $thuVienHinh->hinh1) }}"
                                                                                alt="Li's Product Image">
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            </a>
                                                            @if (!empty($danhSachLaptop))
                                                                @foreach ($danhSachLaptop as $laptop)
                                                                    @if ($laptop->malaptop == $sanPham->malaptop)
                                                                        @if ($laptop->tinhtrang == 0)
                                                                            <span class="sticker tinhtrang">Mới</span>
                                                                        @else
                                                                            <span
                                                                                class="sticker tinhtrang tinhtrangcu">Cũ</span>
                                                                        @endif
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-7">
                                                        <div class="product_desc">
                                                            <div class="product_desc_info">
                                                                <div class="product-review">
                                                                    <h5 class="manufacturer">
                                                                        <a class="mauchu-link"
                                                                            href="{{ url('danhsachsp?loaisp=' . $sanPham->loaisanpham) }}">
                                                                            @if ($sanPham->loaisanpham == 0)
                                                                                Laptop
                                                                            @else
                                                                                Phụ Kiện
                                                                            @endif
                                                                        </a>
                                                                    </h5>
                                                                </div>
                                                                <h4><a class="product_name tensanpham"
                                                                        href="{{ url('chitietsp?masp=' . $sanPham->masanpham) }}">{{ $sanPham->tensanpham }}</a>
                                                                </h4>
                                                                <h5 class="manufacturer">SP{{ $sanPham->masanpham }}
                                                                </h5>
                                                                <div class="price-box mt-10 mb-15">
                                                                    @if (!empty($sanPham->giakhuyenmai))
                                                                        <p class="new-price giakhuyenmai">
                                                                            {{ number_format($sanPham->giakhuyenmai, 0, ',') }}đ
                                                                        </p>
                                                                        <p class="new-price giaban">
                                                                            {{ number_format($sanPham->giaban, 0, ',') }}đ
                                                                        </p>
                                                                    @else
                                                                        @if ($sanPham->giaban > 0)
                                                                            <p class="new-price giakhuyenmai">
                                                                                {{ number_format($sanPham->giaban, 0, ',') }}đ
                                                                            </p>
                                                                        @else
                                                                            <p class="new-price giakhuyenmai">
                                                                                Liên hệ</p>
                                                                        @endif
                                                                    @endif
                                                                </div>
                                                                <p class="cantrai">{{ $sanPham->mota }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="shop-add-action mb-xs-30 p-4">
                                                            <ul class="ulthemgiohang m-0 p-0">
                                                                <li class="m-0 mb-1">
                                                                    <form action="{{ route('xulygiohang') }}"
                                                                        method="post">
                                                                        <button class="btn btn-focus p-2 pr-15 pl-15"
                                                                            type="submit" name="thaoTac"
                                                                            value="thêm giỏ hàng">thêm giỏ hàng</button>
                                                                        <input hidden value="1" type="number"
                                                                            min="1" max="1"
                                                                            name="soLuongMua" required>
                                                                        <input hidden value="{{ $sanPham->masanpham }}"
                                                                            type="number" name="maSanPhamMua" required>
                                                                        @error('maSanPhamMua')
                                                                            <div
                                                                                style="color: red;font-size:10px;display:inline-block;width:100%">
                                                                                {{ $message }}</div>
                                                                        @enderror
                                                                        @error('soLuongMua')
                                                                            <div
                                                                                style="color: red;font-size:10px;display:inline-block;width:100%">
                                                                                {{ $message }}</div>
                                                                        @enderror
                                                                        @csrf
                                                                    </form>
                                                                </li>
                                                                <li class="wishlist m-0 mt-4"
                                                                    style="height:22px;line-height:22px">
                                                                    @php
                                                                        $flag = false;
                                                                        if (!empty(session('yeuThich'))) {
                                                                            foreach (session('yeuThich') as $ctyt) {
                                                                                if ($ctyt['masanpham'] == $sanPham->masanpham) {
                                                                                    $flag = true;
                                                                                    break;
                                                                                }
                                                                            }
                                                                        }
                                                                    @endphp
                                                                    @if ($flag)
                                                                        <a class="bgtrongsuot viethoachudautien"
                                                                            href="{{ url('xulyyeuthich?thaotac=boyeuthich&masp=' . $sanPham->masanpham) }}"><i
                                                                                class="fa fa-heart"></i>Bỏ yêu thích</a>
                                                                    @else
                                                                        <a class="bgtrongsuot viethoachudautien"
                                                                            href="{{ url('xulyyeuthich?thaotac=yeuthich&masp=' . $sanPham->masanpham) }}"><i
                                                                                class="fa fa-heart-o"></i>Yêu thích</a>
                                                                    @endif
                                                                </li>
                                                                <li class="wishlist m-0"
                                                                    style="height:22px;line-height:22px"><a
                                                                        class="bgtrongsuot viethoachudautien"
                                                                        href="{{ url('chitietsp?masp=' . $sanPham->masanpham) }}"><i
                                                                            class="fa fa-eye"></i>Xem chi tiết</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- single-product-wrap end -->
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- shop-products-wrapper end -->
                </div>
                <div class="col-lg-3 order-2 order-lg-1">
                    <!--sidebar-categores-box start  -->
                    <div class="sidebar-categores-box">
                        <form action="#">
                            <div class="sidebar-title">
                                <h2>Bộ lọc</h2>
                            </div>
                            <!-- btn-clear-all start -->
                            <a href="{{ url('danhsachsp') . '?loaisp=' . request()->loaisp }}"
                                class="fontsize15 nutxanh mb-sm-30 mb-xs-30" style="">Xóa tất cả</a>
                            <!-- btn-clear-all end -->
                            <!-- filter-sub-area start -->
                            <div class="filter-sub-area">
                                <h5 class="filter-sub-titel">Hãng sản xuất</h5>
                                <div class="categori-checkbox">
                                    <ul>
                                        @php

                                            $hangsx = [];
                                            $mahang = [];
                                            if (isset(request()->hangsx)) {
                                                $mahang = request()->hangsx;
                                            } else {
                                                $mahang='';
                                            }
                                            $hangsx = explode(',', $mahang);
                                        @endphp
                                        @if (!empty($danhSachHangSanXuat))
                                            @foreach ($danhSachHangSanXuat as $hangSanXuat)
                                                @if ($hangSanXuat->loaihang == 0)
                                                    <li class="mt-1 mb-1"><label
                                                            class="mb-0 chumauden label-checkbox"><input
                                                                class="mr-2 boloc-hangsx"
                                                                {{ in_array($hangSanXuat->mahang, $hangsx) ? 'checked' : '' }}
                                                                type="checkbox" data-filter="hangsx" name="hangsx"
                                                                value="{{ $hangSanXuat->mahang }}"><span>{{ $hangSanXuat->tenhang }}</span></label>
                                                    </li>
                                                @endif
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <!-- filter-sub-area end -->
                            <!-- filter-sub-area start -->
                            <div class="filter-sub-area">
                                <h5 class="filter-sub-titel">Cpu</h5>
                                <div class="categori-checkbox">
                                    <ul>
                                        @php
                                            $cpu = [];
                                            $temp = [];
                                            if (isset(request()->cpu)) {
                                                $temp = request()->cpu;
                                            } else {
                                                $temp='';
                                            }
                                            $cpu = explode(',', $temp);
                                        @endphp
                                        <li class="mt-1 mb-1"><label class="mb-0 chumauden label-checkbox"><input
                                                    class="mr-2 boloc-cpu"
                                                    {{ in_array('intelcorei3', $cpu) ? 'checked' : '' }} type="checkbox"
                                                    data-filter="cpu" name="cpu" value="intelcorei3"><span>Intel Core
                                                    i3</span></label>
                                        </li>
                                        <li class="mt-1 mb-1"><label class="mb-0 chumauden label-checkbox"><input
                                                    class="mr-2 boloc-cpu"
                                                    {{ in_array('intelcorei5', $cpu) ? 'checked' : '' }} type="checkbox"
                                                    data-filter="cpu" name="cpu" value="intelcorei5"><span>Intel Core
                                                    i5</span></label>
                                        </li>
                                        <li class="mt-1 mb-1"><label class="mb-0 chumauden label-checkbox"><input
                                                    class="mr-2 boloc-cpu"
                                                    {{ in_array('intelcorei7', $cpu) ? 'checked' : '' }} type="checkbox"
                                                    data-filter="cpu" name="cpu" value="intelcorei7"><span>Intel Core
                                                    i7</span></label>
                                        </li>
                                        <li class="mt-1 mb-1"><label class="mb-0 chumauden label-checkbox"><input
                                                    class="mr-2 boloc-cpu"
                                                    {{ in_array('amdryzen3', $cpu) ? 'checked' : '' }} type="checkbox"
                                                    data-filter="cpu" name="cpu" value="amdryzen3"><span>Amd Ryzen
                                                    3</span></label>
                                        </li>
                                        <li class="mt-1 mb-1"><label class="mb-0 chumauden label-checkbox"><input
                                                    class="mr-2 boloc-cpu"
                                                    {{ in_array('amdryzen5', $cpu) ? 'checked' : '' }} type="checkbox"
                                                    data-filter="cpu" name="cpu" value="amdryzen5"><span>Amd Ryzen
                                                    5</span></label>
                                        </li>
                                        <li class="mt-1 mb-1"><label class="mb-0 chumauden label-checkbox"><input
                                                    class="mr-2 boloc-cpu"
                                                    {{ in_array('amdryzen7', $cpu) ? 'checked' : '' }} type="checkbox"
                                                    data-filter="cpu" name="cpu" value="amdryzen7"><span>Amd Ryzen
                                                    7</span></label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- filter-sub-area end -->
                            <!-- filter-sub-area start -->
                            <div class="filter-sub-area pt-sm-10 pt-xs-10">
                                <h5 class="filter-sub-titel">Ram</h5>
                                <div class="categori-checkbox">
                                    <ul>
                                        @php
                                            $ram = [];
                                            $temp = [];
                                            if (isset(request()->ram)) {
                                                $temp = request()->ram;
                                            } else {
                                                $temp='';
                                            }
                                            $ram = explode(',', $temp);
                                        @endphp
                                        <li class="mt-1 mb-1"><label class="mb-0 chumauden label-checkbox"><input
                                                    class="mr-2 boloc-ram" {{ in_array('4', $ram) ? 'checked' : '' }}
                                                    type="checkbox" data-filter="ram" name="ram"
                                                    value="4"><span>4 GB</span></label>
                                        </li>
                                        <li class="mt-1 mb-1"><label class="mb-0 chumauden label-checkbox"><input
                                                    class="mr-2 boloc-ram" {{ in_array('8', $ram) ? 'checked' : '' }}
                                                    type="checkbox" data-filter="ram" name="ram"
                                                    value="8"><span>8 GB</span></label>
                                        </li>
                                        <li class="mt-1 mb-1"><label class="mb-0 chumauden label-checkbox"><input
                                                    class="mr-2 boloc-ram" {{ in_array('16', $ram) ? 'checked' : '' }}
                                                    type="checkbox" data-filter="ram" name="ram"
                                                    value="16"><span>16 GB</span></label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- filter-sub-area end -->
                            <!-- filter-sub-area start -->
                            <div class="filter-sub-area pt-sm-10 pt-xs-10">
                                <h5 class="filter-sub-titel">Card đồ họa</h5>
                                <div class="size-checkbox">
                                    <ul>
                                        @php
                                            $carddohoa = [];
                                            $temp = [];
                                            if (isset(request()->carddohoa)) {
                                                $temp = request()->carddohoa;
                                            } else {
                                                $temp='';
                                            }
                                            $carddohoa = explode(',', $temp);
                                        @endphp
                                        <li class="mt-1 mb-1"><label class="mb-0 chumauden label-checkbox"><input
                                                    class="mr-2 boloc-carddohoa"
                                                    {{ in_array('onboard', $carddohoa) ? 'checked' : '' }}
                                                    type="checkbox" data-filter="carddohoa" name="carddohoa"
                                                    value="onboard"><span>Onboard</span></label>
                                        </li>
                                        <li class="mt-1 mb-1"><label class="mb-0 chumauden label-checkbox"><input
                                                    class="mr-2 boloc-carddohoa"
                                                    {{ in_array('nvidia', $carddohoa) ? 'checked' : '' }}
                                                    type="checkbox" data-filter="carddohoa" name="carddohoa"
                                                    value="nvidia"><span>Nvidia</span></label>
                                        </li>
                                        <li class="mt-1 mb-1"><label class="mb-0 chumauden label-checkbox"><input
                                                    class="mr-2 boloc-carddohoa"
                                                    {{ in_array('amd', $carddohoa) ? 'checked' : '' }} type="checkbox"
                                                    data-filter="carddohoa" name="carddohoa"
                                                    value="amd"><span>Amd</span></label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- filter-sub-area end -->
                            <!-- filter-sub-area start -->
                            <div class="filter-sub-area pt-sm-10 pt-xs-10">
                                <h5 class="filter-sub-titel">Ổ cứng</h5>
                                <div class="size-checkbox">
                                    <ul>
                                        @php
                                            $ocung = [];
                                            $temp = [];
                                            if (isset(request()->ocung)) {
                                                $temp = request()->ocung;
                                            } else {
                                                $temp='';
                                            }
                                            $ocung = explode(',', $temp);
                                        @endphp
                                        <li class="mt-1 mb-1"><label class="mb-0 chumauden label-checkbox"><input
                                                    class="mr-2 boloc-ocung"
                                                    {{ in_array('128', $ocung) ? 'checked' : '' }} type="checkbox"
                                                    data-filter="ocung" name="ocung" value="128"><span>SSD 128
                                                    GB</span></label>
                                        </li>
                                        <li class="mt-1 mb-1"><label class="mb-0 chumauden label-checkbox"><input
                                                    class="mr-2 boloc-ocung"
                                                    {{ in_array('256', $ocung) ? 'checked' : '' }} type="checkbox"
                                                    data-filter="ocung" name="ocung" value="256"><span>SSD 256
                                                    GB</span></label>
                                        </li>
                                        <li class="mt-1 mb-1"><label class="mb-0 chumauden label-checkbox"><input
                                                    class="mr-2 boloc-ocung"
                                                    {{ in_array('512', $ocung) ? 'checked' : '' }} type="checkbox"
                                                    data-filter="ocung" name="ocung" value="512"><span>SSD 512
                                                    GB</span></label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- filter-sub-area end -->
                            <!-- filter-sub-area start -->
                            <div class="filter-sub-area pt-sm-10 pt-xs-10">
                                <h5 class="filter-sub-titel">Màn hình</h5>
                                <div class="size-checkbox">
                                    <ul>
                                        @php
                                            $manhinh = [];
                                            $temp = [];
                                            if (isset(request()->manhinh)) {
                                                $temp = request()->manhinh;
                                            } else {
                                                $temp='';
                                            }
                                            $manhinh = explode(',', $temp);
                                        @endphp
                                        <li class="mt-1 mb-1"><label class="mb-0 chumauden label-checkbox"><input
                                                    class="mr-2 boloc-manhinh"
                                                    {{ in_array('13', $manhinh) ? 'checked' : '' }} type="checkbox"
                                                    data-filter="manhinh" name="manhinh" value="13"><span>Khoảng 13
                                                    inch</span></label>
                                        </li>
                                        <li class="mt-1 mb-1"><label class="mb-0 chumauden label-checkbox"><input
                                                    class="mr-2 boloc-manhinh"
                                                    {{ in_array('14', $manhinh) ? 'checked' : '' }} type="checkbox"
                                                    data-filter="manhinh" name="manhinh" value="14"><span>Khoảng 14
                                                    inch</span></label>
                                        </li>
                                        <li class="mt-1 mb-1"><label class="mb-0 chumauden label-checkbox"><input
                                                    class="mr-2 boloc-manhinh"
                                                    {{ in_array('15', $manhinh) ? 'checked' : '' }} type="checkbox"
                                                    data-filter="manhinh" name="manhinh" value="15"><span>Trên 15
                                                    inch</span></label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- filter-sub-area end -->
                            <!-- filter-sub-area start -->
                            <div class="filter-sub-area pt-sm-10 pt-xs-10">
                                <h5 class="filter-sub-titel">Nhu cầu</h5>
                                <div class="size-checkbox">
                                    <ul>
                                        @php
                                            $nhucau = [];
                                            $temp = [];
                                            if (isset(request()->nhucau)) {
                                                $temp = request()->nhucau;
                                            } else {
                                                $temp='';
                                            }
                                            $nhucau = explode(',', $temp);
                                        @endphp
                                        <li class="mt-1 mb-1"><label class="mb-0 chumauden label-checkbox"><input
                                                    class="mr-2 boloc-nhucau"
                                                    {{ in_array('sinhvien', $nhucau) ? 'checked' : '' }} type="checkbox"
                                                    data-filter="nhucau" name="nhucau" value="sinhvien"><span>Sinh
                                                    Viên</span></label>
                                        </li>
                                        <li class="mt-1 mb-1"><label class="mb-0 chumauden label-checkbox"><input
                                                    class="mr-2 boloc-nhucau"
                                                    {{ in_array('dohoa', $nhucau) ? 'checked' : '' }} type="checkbox"
                                                    data-filter="nhucau" name="nhucau" value="dohoa"><span>Đồ
                                                    Họa</span></label>
                                        </li>
                                        <li class="mt-1 mb-1"><label class="mb-0 chumauden label-checkbox"><input
                                                    class="mr-2 boloc-nhucau"
                                                    {{ in_array('gaming', $nhucau) ? 'checked' : '' }} type="checkbox"
                                                    data-filter="nhucau" name="nhucau"
                                                    value="gaming"><span>Gaming</span></label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- filter-sub-area end -->
                            <!-- filter-sub-area start -->
                            <div class="filter-sub-area pt-sm-10 pt-xs-10">
                                <h5 class="filter-sub-titel">Tình trạng</h5>
                                <div class="size-checkbox">
                                    <ul>
                                        @php
                                            $tinhtrang = [];
                                            $temp = [];
                                            if (isset(request()->tinhtrang)) {
                                                $temp = request()->tinhtrang;
                                            } else {
                                                $temp='';
                                            }
                                            $tinhtrang = explode(',', $temp);
                                        @endphp
                                        <li class="mt-1 mb-1"><label class="mb-0 chumauden label-checkbox"><input
                                                    class="mr-2 boloc-tinhtrang"
                                                    {{ in_array('moi', $tinhtrang) ? 'checked' : '' }} type="checkbox"
                                                    data-filter="tinhtrang" name="tinhtrang"
                                                    value="moi"><span>Mới</span></label>
                                        </li>
                                        <li class="mt-1 mb-1"><label class="mb-0 chumauden label-checkbox"><input
                                                    class="mr-2 boloc-tinhtrang"
                                                    {{ in_array('cu', $tinhtrang) ? 'checked' : '' }} type="checkbox"
                                                    data-filter="tinhtrang" name="tinhtrang"
                                                    value="cu"><span>Cũ</span></label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- filter-sub-area end -->
                            <!-- filter-sub-area start -->
                            <div class="filter-sub-area pt-sm-10 pt-xs-10">
                                <h5 class="filter-sub-titel">Mức giá</h5>
                                <div class="size-checkbox">
                                    <ul>
                                        @php
                                            $mucgia = [];
                                            $gia = [];
                                            if (isset(request()->mucgia)) {
                                                $gia = request()->mucgia;
                                            } else {
                                                $gia='';
                                            }
                                            $mucgia = explode(',', $gia);
                                        @endphp
                                        <li class="mt-1 mb-1"><label class="mb-0 chumauden label-checkbox"><input
                                                    class="mr-2 boloc-mucgia"
                                                    {{ in_array('duoi10', $mucgia) ? 'checked' : '' }} type="checkbox"
                                                    data-filter="mucgia" name="mucgia" value="duoi10"><span>Dưới 10
                                                    triệu</span></label>
                                        </li>
                                        <li class="mt-1 mb-1"><label class="mb-0 chumauden label-checkbox"><input
                                                    class="mr-2 boloc-mucgia"
                                                    {{ in_array('1015', $mucgia) ? 'checked' : '' }} type="checkbox"
                                                    data-filter="mucgia" name="mucgia" value="1015"><span>10-15
                                                    triệu</span></label>
                                        </li>
                                        <li class="mt-1 mb-1"><label class="mb-0 chumauden label-checkbox"><input
                                                    class="mr-2 boloc-mucgia"
                                                    {{ in_array('1520', $mucgia) ? 'checked' : '' }} type="checkbox"
                                                    data-filter="mucgia" name="mucgia" value="1520"><span>15-20
                                                    triệu</span></label>
                                        </li>
                                        <li class="mt-1 mb-1"><label class="mb-0 chumauden label-checkbox"><input
                                                    class="mr-2 boloc-mucgia"
                                                    {{ in_array('tren20', $mucgia) ? 'checked' : '' }} type="checkbox"
                                                    data-filter="mucgia" name="mucgia" value="tren20"><span>Trên 20
                                                    triệu</span></label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- filter-sub-area end -->
                            @csrf
                        </form>

                    </div>
                    <!--sidebar-categores-box end  -->
                    <!-- category-sub-menu start -->
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    {{-- thêm js --}}
    <script>
        $(document).ready(function() {
            $('.boloc-hangsx').click(function() {
                var hangsx = [],
                    temp = [];
                $.each($("[data-filter='hangsx']:checked"), function() {
                    temp.push($(this).val());
                });
                if (temp.length !== 0) {
                    hangsx += '?hangsx=' + temp.toString() +
                        '&loaisp={{ request()->loaisp }}&mucgia={{ request()->mucgia }}&nhucau={{ request()->nhucau }}' +
                        '&manhinh={{ request()->manhinh }}&ocung={{ request()->ocung }}&carddohoa={{ request()->carddohoa }}' +
                        '&ram={{ request()->ram }}&cpu={{ request()->cpu }}&tinhtrang={{ request()->tinhtrang }}';
                } else {
                    var url = '{!! url()->full() !!}';
                    url = url.replace("&hangsx={{ request()->hangsx }}", "");
                    window.location.href = url.replace("hangsx={{ request()->hangsx }}&", "");
                    return false;
                }
                window.location.href = hangsx;
            });
            $('.boloc-tinhtrang').click(function() {
                var tinhtrang = [],
                    temp = [];
                $.each($("[data-filter='tinhtrang']:checked"), function() {
                    temp.push($(this).val());
                });
                if (temp.length !== 0) {
                    tinhtrang += '?tinhtrang=' + temp.toString() +
                        '&loaisp={{ request()->loaisp }}&hangsx={{ request()->hangsx }}&mucgia={{ request()->mucgia }}' +
                        '&nhucau={{ request()->nhucau }}&manhinh={{ request()->manhinh }}&ocung={{ request()->ocung }}' +
                        '&carddohoa={{ request()->carddohoa }}&ram={{ request()->ram }}&cpu={{ request()->cpu }}';
                } else {
                    url = '{!! url()->full() !!}';
                    url = url.replace("&tinhtrang={{ request()->tinhtrang }}", "");
                    window.location.href = url.replace("tinhtrang={{ request()->tinhtrang }}&", "");
                    return false;
                }
                window.location.href = tinhtrang;
            });
            $('.boloc-cpu').click(function() {
                var cpu = [],
                    temp = [];
                $.each($("[data-filter='cpu']:checked"), function() {
                    temp.push($(this).val());
                });
                if (temp.length !== 0) {
                    cpu += '?cpu=' + temp.toString() +
                        '&loaisp={{ request()->loaisp }}&hangsx={{ request()->hangsx }}&mucgia={{ request()->mucgia }}' +
                        '&nhucau={{ request()->nhucau }}&manhinh={{ request()->manhinh }}&ocung={{ request()->ocung }}' +
                        '&carddohoa={{ request()->carddohoa }}&ram={{ request()->ram }}&tinhtrang={{ request()->tinhtrang }}';
                } else {
                    url = '{!! url()->full() !!}';
                    url = url.replace("&cpu={{ request()->cpu }}", "");
                    window.location.href = url.replace("cpu={{ request()->cpu }}&", "");
                    return false;
                }
                window.location.href = cpu;
            });
            $('.boloc-ram').click(function() {
                var ram = [],
                    temp = [];
                $.each($("[data-filter='ram']:checked"), function() {
                    temp.push($(this).val());
                });
                if (temp.length !== 0) {
                    ram += '?ram=' + temp.toString() +
                        '&loaisp={{ request()->loaisp }}&hangsx={{ request()->hangsx }}&mucgia={{ request()->mucgia }}' +
                        '&nhucau={{ request()->nhucau }}&manhinh={{ request()->manhinh }}&ocung={{ request()->ocung }}' +
                        '&carddohoa={{ request()->carddohoa }}&cpu={{ request()->cpu }}&tinhtrang={{ request()->tinhtrang }}';
                } else {
                    url = '{!! url()->full() !!}';
                    url = url.replace("&ram={{ request()->ram }}", "");
                    window.location.href = url.replace("ram={{ request()->ram }}&", "");
                    return false;
                }
                window.location.href = ram;
            });
            $('.boloc-carddohoa').click(function() {
                var carddohoa = [],
                    temp = [];
                $.each($("[data-filter='carddohoa']:checked"), function() {
                    temp.push($(this).val());
                });
                if (temp.length !== 0) {
                    carddohoa += '?carddohoa=' + temp.toString() +
                        '&loaisp={{ request()->loaisp }}&hangsx={{ request()->hangsx }}&mucgia={{ request()->mucgia }}' +
                        '&nhucau={{ request()->nhucau }}&manhinh={{ request()->manhinh }}&ocung={{ request()->ocung }}' +
                        '&ram={{ request()->ram }}&cpu={{ request()->cpu }}&tinhtrang={{ request()->tinhtrang }}';
                } else {
                    url = '{!! url()->full() !!}';
                    url = url.replace("&carddohoa={{ request()->carddohoa }}", "");
                    window.location.href = url.replace("carddohoa={{ request()->carddohoa }}&", "");
                    return false;
                }
                window.location.href = carddohoa;
            });
            $('.boloc-ocung').click(function() {
                var ocung = [],
                    temp = [];
                $.each($("[data-filter='ocung']:checked"), function() {
                    temp.push($(this).val());
                });
                if (temp.length !== 0) {
                    ocung += '?ocung=' + temp.toString() +
                        '&loaisp={{ request()->loaisp }}&hangsx={{ request()->hangsx }}&mucgia={{ request()->mucgia }}' +
                        '&nhucau={{ request()->nhucau }}&manhinh={{ request()->manhinh }}&carddohoa={{ request()->carddohoa }}' +
                        '&ram={{ request()->ram }}&cpu={{ request()->cpu }}&tinhtrang={{ request()->tinhtrang }}';
                } else {
                    url = '{!! url()->full() !!}';
                    url = url.replace("&ocung={{ request()->ocung }}", "");
                    window.location.href = url.replace("ocung={{ request()->ocung }}&", "");
                    return false;
                }
                window.location.href = ocung;
            });
            $('.boloc-manhinh').click(function() {
                var manhinh = [],
                    temp = [];
                $.each($("[data-filter='manhinh']:checked"), function() {
                    temp.push($(this).val());
                });
                if (temp.length !== 0) {
                    manhinh += '?manhinh=' + temp.toString() +
                        '&loaisp={{ request()->loaisp }}&hangsx={{ request()->hangsx }}&mucgia={{ request()->mucgia }}' +
                        '&nhucau={{ request()->nhucau }}&ocung={{ request()->ocung }}&carddohoa={{ request()->carddohoa }}' +
                        '&ram={{ request()->ram }}&cpu={{ request()->cpu }}&tinhtrang={{ request()->tinhtrang }}';
                } else {
                    url = '{!! url()->full() !!}';
                    url = url.replace("&manhinh={{ request()->manhinh }}", "");
                    window.location.href = url.replace("manhinh={{ request()->manhinh }}&", "");
                    return false;
                }
                window.location.href = manhinh;
            });
            $('.boloc-nhucau').click(function() {
                var nhucau = [],
                    temp = [];
                $.each($("[data-filter='nhucau']:checked"), function() {
                    temp.push($(this).val());
                });
                if (temp.length !== 0) {
                    nhucau += '?nhucau=' + temp.toString() +
                        '&loaisp={{ request()->loaisp }}&hangsx={{ request()->hangsx }}&mucgia={{ request()->mucgia }}' +
                        '&manhinh={{ request()->manhinh }}&ocung={{ request()->ocung }}&carddohoa={{ request()->carddohoa }}' +
                        '&ram={{ request()->ram }}&cpu={{ request()->cpu }}&tinhtrang={{ request()->tinhtrang }}';
                } else {
                    url = '{!! url()->full() !!}';
                    url = url.replace("&nhucau={{ request()->nhucau }}", "");
                    window.location.href = url.replace("nhucau={{ request()->nhucau }}&", "");
                    return false;
                }
                window.location.href = nhucau;
            });
            $('.boloc-mucgia').click(function() {
                var mucgia = [],
                    temp = [];
                $.each($("[data-filter='mucgia']:checked"), function() {
                    temp.push($(this).val());
                });
                if (temp.length !== 0) {
                    mucgia += '?mucgia=' + temp.toString() +
                        '&loaisp={{ request()->loaisp }}&hangsx={{ request()->hangsx }}&nhucau={{ request()->nhucau }}' +
                        '&manhinh={{ request()->manhinh }}&ocung={{ request()->ocung }}&carddohoa={{ request()->carddohoa }}' +
                        '&ram={{ request()->ram }}&cpu={{ request()->cpu }}&tinhtrang={{ request()->tinhtrang }}';
                } else {
                    url = '{!! url()->full() !!}';
                    url = url.replace("&mucgia={{ request()->mucgia }}", "");
                    window.location.href = url.replace("mucgia={{ request()->mucgia }}&", "");
                    return false;
                }
                window.location.href = mucgia;
            });
            $('#sapxep').change(function() {
                var urlcu = '{!! url()->full() !!}';
                var url = urlcu.replace("&sapxep={{ request()->sapxep }}", "") + "&sapxep=" + $(this)
                    .val();
                if (url) {
                    window.location = url;
                }
                return false;
            });
        });
    </script>
@endsection
