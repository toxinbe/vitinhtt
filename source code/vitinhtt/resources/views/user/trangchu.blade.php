@extends('user.layouts.client')
@section('title')
    Trang chủ
@endsection
@section('head')
    {{-- thêm css --}}
@endsection
@section('content')
    <!-- Begin Slider With Banner Area -->
    <div class="slider-with-banner  mt-25">
        <div class="container">
            <div class="row">
                <!-- Begin Slider Area -->
                <div class="col-lg-8 col-md-8">
                    <div class="slider-area pt-sm-30 pt-xs-30">
                        <div class="slider-active owl-carousel khung-banner">
                            <!-- Begin Single Slide Area -->
                            <div class="single-slide align-center-left animation-style-01 bg-3">
                                <div class="slider-progress"></div>
                                <div class="slider-content">
                                    <h5>Giảm <span>-20% </span> Tuần này</h5>
                                    <h2>Laptop Sinh Viên</h2>
                                    <h3>Chỉ từ <span>9.990.000đ</span></h3>
                                    <div class="default-btn slide-btn">
                                        <a class="links" href="{{ url('danhsachsp?loaisp=0') }}">Xem
                                            ngay</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Single Slide Area End Here -->
                            <!-- Begin Single Slide Area -->
                            <div class="single-slide align-center-left animation-style-01 bg-1">
                                <div class="slider-progress"></div>
                                <div class="slider-content">
                                    <h5><span>Deal Hot</span> Hôm Nay</h5>
                                    <h2>Laptop Đồ Họa</h2>
                                    <h3>Chỉ từ <span>14.990.000đ</span></h3>
                                    <div class="default-btn slide-btn">
                                        <a class="links" href="{{ url('danhsachsp?loaisp=0') }}">Xem
                                            ngay</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Single Slide Area End Here -->
                            <!-- Begin Single Slide Area -->
                            <div class="single-slide align-center-left animation-style-02 bg-2">
                                <div class="slider-progress"></div>
                                <div class="slider-content">
                                    <h5>Sale <span>Black Friday</span></h5>
                                    <h2>Laptop Gaming</h2>
                                    <h3>Chỉ từ <span>24.990.000đ</span></h3>
                                    <div class="default-btn slide-btn">
                                        <a class="links" href="{{ url('danhsachsp?loaisp=0') }}">Xem
                                            ngay</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Single Slide Area End Here -->
                        </div>
                    </div>
                </div>
                <!-- Slider Area End Here -->
                <!-- Begin Li Banner Area -->
                <div class="col-lg-4 col-md-4 text-center pt-sm-30 pt-xs-30">
                    <div class="li-banner khung-banner">
                        <a href="{{ route('tragop') }}">
                            <img src="{{ asset('img/banner/1_4.jpg') }}" alt="">
                        </a>
                    </div>
                    <div class="li-banner mt-15 mt-md-30 mt-xs-25 mb-xs-5 khung-banner">
                        <a href="{{ route('baohanh') }}">
                            <img src="{{ asset('img/banner/1_5.jpg') }}" alt="">
                        </a>
                    </div>
                </div>
                <!-- Li Banner Area End Here -->
            </div>
        </div>
    </div>
    <!-- Slider With Banner Area End Here -->
    <!-- product-area start -->
    <div class="product-area pt-55 pb-25 pt-xs-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="li-product-tab">
                        <ul class="nav li-product-menu">
                            <li><a class="active" data-toggle="tab" href="#li-new-product"><span>mới ra mắt</span></a></li>
                            <li><a data-toggle="tab" href="#li-bestseller-product"><span>bán chạy</span></a></li>
                            <li><a data-toggle="tab" href="#li-saleof-product"><span>ưu đãi</span></a></li>
                        </ul>
                    </div>
                    <!-- Begin Li's Tab Menu Content Area -->
                </div>
            </div>
            <div class="tab-content">
                <div id="li-new-product" class="tab-pane active show" role="tabpanel">
                    <div class="row">
                        <div class="product-active owl-carousel">
                            @php
                                $danhSachSanPhamHienThi = $danhSachSanPhamMoiRaMat;
                            @endphp
                            @include('user.layouts.slidesp')
                        </div>
                    </div>
                </div>
                <div id="li-bestseller-product" class="tab-pane" role="tabpanel">
                    <div class="row">
                        <div class="product-active owl-carousel">
                            @php
                                $danhSachSanPhamHienThi = $danhSachSanPhamBanChay;
                            @endphp
                            @include('user.layouts.slidesp')
                        </div>
                    </div>
                </div>
                <div id="li-saleof-product" class="tab-pane" role="tabpanel">
                    <div class="row">
                        <div class="product-active owl-carousel">
                            @php
                                $danhSachSanPhamHienThi = $danhSachSanPhamUuDai;
                            @endphp
                            @include('user.layouts.slidesp')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- product-area end -->
    <!-- Begin Li's Static Banner Area -->
    <div class="li-static-banner li-static-banner-4 text-center pt-20">
        <div class="container">
            <div class="row">
                <!-- Begin Single Banner Area -->
                <div class="col-lg-6">
                    <div class="single-banner pb-sm-30 pb-xs-30 khung-banner">
                        <a href="{{ url('danhsachsp?loaisp=0') }}">
                            <img src="{{ asset('img/banner/2_1.jpg') }}" alt="Li's Static Banner">
                        </a>
                    </div>
                </div>
                <!-- Single Banner Area End Here -->
                <!-- Begin Single Banner Area -->
                <div class="col-lg-6">
                    <div class="single-banner khung-banner">
                        <a href="{{ url('danhsachsp?loaisp=0') }}">
                            <img src="{{ asset('img/banner/2_2.jpg') }}" alt="Li's Static Banner">
                        </a>
                    </div>
                </div>
                <!-- Single Banner Area End Here -->
            </div>
        </div>
    </div>
    <!-- Li's Static Banner Area End Here -->
    <!-- Begin Li's Laptop Product Area -->
    <section class="product-area li-laptop-product pt-60 pb-45 pt-sm-50 pt-xs-60">
        <div class="container">
            <div class="row">
                <!-- Begin Li's Section Area -->
                <div class="col-lg-12">
                    <div class="li-section-title">
                        <h2>
                            <span>Laptop</span>
                        </h2>
                        <ul class="li-sub-category-list">
                            <li class="active"><a href="{{ url('danhsachsp?loaisp=0') }}">Xem ngay</a></li>
                        </ul>
                    </div>
                    <div class="row">
                        <div class="product-active owl-carousel">
                            @php
                                $danhSachSanPhamHienThi = $danhSachSanPhamLaLaptop;
                            @endphp
                            @include('user.layouts.slidesp')
                        </div>
                    </div>
                </div>
                <!-- Li's Section Area End Here -->
            </div>
        </div>
    </section>
    <!-- Li's Laptop Product Area End Here -->
    <!-- Begin Li's TV & Audio Product Area -->
    <section class="product-area li-laptop-product li-tv-audio-product pb-45">
        <div class="container">
            <div class="row">
                <!-- Begin Li's Section Area -->
                <div class="col-lg-12">
                    <div class="li-section-title">
                        <h2>
                            <span>Phụ Kiện</span>
                        </h2>
                        <ul class="li-sub-category-list">
                            <li class="active"><a href="{{ url('timkiem?boloc=-2') }}">Xem ngay</a></li>
                        </ul>
                    </div>
                    <div class="row">
                        <div class="product-active owl-carousel">
                            @php
                                $danhSachSanPhamHienThi = $danhSachSanPhamLaPhuKien;
                            @endphp
                            @include('user.layouts.slidesp')
                        </div>
                    </div>
                </div>
            </div>
            <!-- Li's Section Area End Here -->
        </div>
        </div>
    </section>
    <!-- Li's TV & Audio Product Area End Here -->
    <!-- Begin Li's Static Home Area -->
    <div class="li-static-home">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Begin Li's Static Home Image Area -->
                    <div class="li-static-home-image khung-banner"></div>
                    <!-- Li's Static Home Image Area End Here -->
                </div>
            </div>
        </div>
    </div>
    <!-- Li's Static Home Area End Here -->
    <!-- Begin Group Featured Product Area -->
    <div class="group-featured-product pt-60 pb-40 pb-xs-25">
        <div class="container">
            <div class="row">
                <!-- Begin Featured Product Area -->
                <div class="col-lg-4">
                    <div class="featured-product">
                        <div class="li-section-title">
                            <h2>
                                <span>Laptop Sinh Viên</span>
                            </h2>
                        </div>
                        <div class="featured-product-active-2 owl-carousel">
                            <div class="featured-product-bundle">
                                @php
                                    $danhSachSanPhamHienThi = $danhSachLaptopSinhVien;
                                @endphp
                                @include('user.layouts.sidebarsp')
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Featured Product Area End Here -->
                <!-- Begin Featured Product Area -->
                <div class="col-lg-4">
                    <div class="featured-product pt-sm-10 pt-xs-25">
                        <div class="li-section-title">
                            <h2>
                                <span>Laptop Đồ Họa</span>
                            </h2>
                        </div>
                        <div class="featured-product-active-2 owl-carousel">
                            <div class="featured-product-bundle">
                                @php
                                    $danhSachSanPhamHienThi = $danhSachLaptopDoHoa;
                                @endphp
                                @include('user.layouts.sidebarsp')
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Featured Product Area End Here -->
                <!-- Begin Featured Product Area -->
                <div class="col-lg-4">
                    <div class="featured-product pt-sm-10 pt-xs-25">
                        <div class="li-section-title">
                            <h2>
                                <span>Laptop Gaming</span>
                            </h2>
                        </div>
                        <div class="featured-product-active-2 owl-carousel">
                            <div class="featured-product-bundle">
                                @php
                                    $danhSachSanPhamHienThi = $danhSachLaptopGaming;
                                @endphp
                                @include('user.layouts.sidebarsp')
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Featured Product Area End Here -->
            </div>
        </div>
    </div>
    <!-- Group Featured Product Area End Here -->
@endsection
@section('js')
    {{-- thêm js --}}
@endsection
