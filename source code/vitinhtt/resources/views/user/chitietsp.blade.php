@extends('user.layouts.client')
@section('title')
    Chi tiết sản phẩm
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
                    <li><a
                            href="{{ $sanPhamXem->loaisanpham == 0 ? url('danhsachsp?loaisp=0') : url('timkiem?boloc=-2') }}">{{ $sanPhamXem->loaisanpham == 0 ? 'Laptop' : 'Phụ kiện' }}</a>
                    </li>
                    <li class="active"><a
                            href="{{ url('chitietsp?masp=' . $sanPhamXem->masanpham) }}">{{ $sanPhamXem->tensanpham }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- content-wraper start -->
    <div class="content-wraper">
        <div class="container">
            <div class="row single-product-area">
                <div class="col-lg-5 col-md-6">
                    <!-- Product Details Left -->
                    <div class="product-details-left">
                        <div class="product-details-images slider-navigation-1">
                            <div class="lg-image">
                                <a class="popup-img venobox vbox-item"
                                    href="{{ asset('img/sanpham/' . $thuVienHinhXem->hinh1) }}" data-gall="myGallery">
                                    <img src="{{ asset('img/sanpham/' . $thuVienHinhXem->hinh1) }}" alt="product image">
                                </a>
                            </div>
                            @if (!empty($thuVienHinhXem->hinh2))
                                <div class="lg-image">
                                    <a class="popup-img venobox vbox-item"
                                        href="{{ asset('img/sanpham/' . $thuVienHinhXem->hinh2) }}" data-gall="myGallery">
                                        <img src="{{ asset('img/sanpham/' . $thuVienHinhXem->hinh2) }}"
                                            alt="product image">
                                    </a>
                                </div>
                            @endif
                            @if (!empty($thuVienHinhXem->hinh3))
                                <div class="lg-image">
                                    <a class="popup-img venobox vbox-item"
                                        href="{{ asset('img/sanpham/' . $thuVienHinhXem->hinh3) }}" data-gall="myGallery">
                                        <img src="{{ asset('img/sanpham/' . $thuVienHinhXem->hinh3) }}"
                                            alt="product image">
                                    </a>
                                </div>
                            @endif
                            @if (!empty($thuVienHinhXem->hinh4))
                                <div class="lg-image">
                                    <a class="popup-img venobox vbox-item"
                                        href="{{ asset('img/sanpham/' . $thuVienHinhXem->hinh4) }}"
                                        data-gall="myGallery">
                                        <img src="{{ asset('img/sanpham/' . $thuVienHinhXem->hinh4) }}"
                                            alt="product image">
                                    </a>
                                </div>
                            @endif
                            @if (!empty($thuVienHinhXem->hinh5))
                                <div class="lg-image">
                                    <a class="popup-img venobox vbox-item"
                                        href="{{ asset('img/sanpham/' . $thuVienHinhXem->hinh5) }}"
                                        data-gall="myGallery">
                                        <img src="{{ asset('img/sanpham/' . $thuVienHinhXem->hinh5) }}"
                                            alt="product image">
                                    </a>
                                </div>
                            @endif
                        </div>
                        <div class="product-details-thumbs slider-thumbs-1 mt-5">
                            @if (!empty($thuVienHinhXem->hinh2) ||
                                !empty($thuVienHinhXem->hinh3) ||
                                !empty($thuVienHinhXem->hinh4) ||
                                !empty($thuVienHinhXem->hinh5))
                                <div class="sm-image"><img src="{{ asset('img/sanpham/' . $thuVienHinhXem->hinh1) }}"
                                        alt="product image thumb"></div>
                            @endif
                            @if (!empty($thuVienHinhXem->hinh2))
                                <div class="sm-image"><img src="{{ asset('img/sanpham/' . $thuVienHinhXem->hinh2) }}"
                                        alt="product image thumb"></div>
                            @endif
                            @if (!empty($thuVienHinhXem->hinh3))
                                <div class="sm-image"><img src="{{ asset('img/sanpham/' . $thuVienHinhXem->hinh3) }}"
                                        alt="product image thumb"></div>
                            @endif
                            @if (!empty($thuVienHinhXem->hinh4))
                                <div class="sm-image"><img src="{{ asset('img/sanpham/' . $thuVienHinhXem->hinh4) }}"
                                        alt="product image thumb"></div>
                            @endif
                            @if (!empty($thuVienHinhXem->hinh5))
                                <div class="sm-image"><img src="{{ asset('img/sanpham/' . $thuVienHinhXem->hinh5) }}"
                                        alt="product image thumb"></div>
                            @endif
                            <div class="sm-image"></div>
                            {{-- <div class="sm-image"><img src="{{ asset('img/sanpham/' . $thuVienHinhXem->hinh1) }}"
                                    alt="product image thumb"></div>
                            <div class="sm-image"><img src="{{ asset('img/sanpham/' . $thuVienHinhXem->hinh1) }}"
                                    alt="product image thumb"></div>
                            <div class="sm-image"><img src="{{ asset('img/sanpham/' . $thuVienHinhXem->hinh1) }}"
                                    alt="product image thumb"></div>
                            <div class="sm-image"><img src="{{ asset('img/sanpham/' . $thuVienHinhXem->hinh1) }}"
                                    alt="product image thumb"></div> --}}
                        </div>
                    </div>
                    <!--// Product Details Left -->
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="product-details-view-content sp-sale-content pt-60">
                        <div class="product-info">
                            <h2 class="mb-25 tensanpham-chitiet">{{ $sanPhamXem->tensanpham }}</h2>
                            <p class="product-details-ref mb-0">Mã sản phẩm: SP{{ $sanPhamXem->masanpham }}</p>
                            @if ($sanPhamXem->loaisanpham == 0)
                                <p class="product-details-ref mb-0">Loại: Laptop</p>
                                <p class="product-details-ref mb-0">Hãng: {{ $hangSanXuatXem->tenhang }}</p>
                                @if ($cauHinh->tinhtrang == 0)
                                    <p class="product-details-ref mb-0">Tình trạng: Mới</p>
                                @else
                                    <p class="product-details-ref mb-0">Tình trạng: Cũ</p>
                                @endif
                            @else
                                <p class="product-details-ref mb-0">Loại: Phụ kiện</p>
                                <p class="product-details-ref mb-0">Hãng: {{ $hangSanXuatXem->tenhang }}</p>
                            @endif
                            <p class="product-details-ref mb-35">Bảo hành: {{ $sanPhamXem->baohanh }} Tháng</p>
                            <div class="price-box pt-20">
                                @if (!empty($sanPhamXem->giakhuyenmai) && $sanPhamXem->soluong > 0)
                                    <span
                                        class="new-price new-price-2">{{ number_format($sanPhamXem->giakhuyenmai, 0, ',') }}
                                        đ</span>
                                    <span
                                        class="new-price new-price-2 giaban ml-20 giaban-chitiet">{{ number_format($sanPhamXem->giaban, 0, ',') }}
                                        đ</span>
                                @else
                                    @if ($sanPhamXem->giaban > 0 && $sanPhamXem->soluong > 0)
                                        <span
                                            class="new-price new-price-2">{{ number_format($sanPhamXem->giaban, 0, ',') }}
                                            đ</span>
                                    @else
                                        <span class="new-price new-price-2">Liên hệ</span>
                                    @endif
                                @endif
                            </div>
                            {{-- khung giờ khuyến mãi còn lại --}}
                            {{-- <div class="countersection">
                                <div class="li-countdown product-sale-countdown"></div>
                            </div> --}}
                            <div class="product-desc mt-20 pb-15">
                                <h6 class="m-0 mb-5"><i class="fa fa-gift"></i> Quà tặng</h6>
                                @foreach ($danhSachSanPhamTang as $sanPham)
                                    <div class="row container">
                                        <div class="col-12">
                                            <a href="{{ url('chitietsp?masp=' . $sanPham->masanpham) }}"
                                                target="_blank">[SP{{ $sanPham->masanpham }}] -
                                                {{ $sanPham->tensanpham }}</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            {{-- <div class="product-variants">
                                <div class="produt-variants-size">
                                    <label>Dimension</label>
                                    <select class="nice-select">
                                        <option value="1" title="S" selected="selected">40x60cm</option>
                                        <option value="2" title="M">60x90cm</option>
                                        <option value="3" title="L">80x120cm</option>
                                    </select>
                                </div>
                            </div> --}}
                            <div class="single-add-to-cart">
                                <div class="cart-quantity">
                                    <form action="{{ route('xulygiohang') }}" method="post">
                                        <div class="quantity">
                                            <label>Số lượng</label>
                                            <div class="cart-plus-minus">
                                                <input class="cart-plus-minus-box" value="1" type="text"
                                                    pattern="[0-9]*" title="(Gồm các ký tự là số)" name="soLuongMua"
                                                    required>
                                                <div class="dec qtybutton"><i class="fa fa-angle-down"></i></div>
                                                <div class="inc qtybutton"><i class="fa fa-angle-up"></i></div>
                                            </div>
                                        </div>
                                        <input hidden value="{{ $sanPhamXem->masanpham }}" type="text"
                                            pattern="[0-9]*" name="maSanPhamMua" required>
                                        <button class="add-to-cart nutthemgiohang" type="submit" name="thaoTac"
                                            value="thêm giỏ hàng">Thêm
                                            Giỏ Hàng</button>
                                        @error('maSanPhamMua')
                                            <div style="color: red;font-size:10px;display:inline-block;width:100%">
                                                {{ $message }}</div>
                                        @enderror
                                        @error('soLuongMua')
                                            <div style="color: red;font-size:10px;display:inline-block;width:100%">
                                                {{ $message }}</div>
                                        @enderror
                                        @csrf
                                    </form>
                                </div>
                            </div>
                            <div class="product-additional-info pt-25">
                                @php
                                    $flag = false;
                                    if (!empty(session('yeuThich'))) {
                                        foreach (session('yeuThich') as $ctyt) {
                                            if ($ctyt['masanpham'] == $sanPhamXem->masanpham) {
                                                $flag = true;
                                                break;
                                            }
                                        }
                                    }
                                @endphp
                                @if ($flag)
                                    <a class="wishlist-btn"
                                        href="{{ url('xulyyeuthich?thaotac=boyeuthich&masp=' . $sanPhamXem->masanpham) }}"><i
                                            class="fa fa-heart"></i>Bỏ yêu thích</a>
                                @else
                                    <a class="wishlist-btn"
                                        href="{{ url('xulyyeuthich?thaotac=yeuthich&masp=' . $sanPhamXem->masanpham) }}"><i
                                            class="fa fa-heart-o"></i>Yêu thích</a>
                                @endif
                            </div>
                            <div class="block-reassurance">
                                <ul>
                                    <li>
                                        <div class="reassurance-item">
                                            <div class="reassurance-icon"> <i class="fa fa-credit-card-alt"></i> </div>
                                            <p> Thanh toán đơn giản</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="reassurance-item">
                                            <div class="reassurance-icon"> <i class="fa fa-truck"></i> </div>
                                            <p> Giao hàng miễn phí</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="reassurance-item">
                                            <div class="reassurance-icon"> <i class="fa fa-exchange"></i> </div>
                                            <p> Bảo hành 1 đổi 1</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="featured-product pt-60">
                        <div class="li-section-title">
                            <h2>
                                <span>Laptop cũ giá rẻ</span>
                            </h2>
                        </div>
                        <div class="featured-product-active-2 owl-carousel">
                            <div class="featured-product-bundle">
                                @php
                                    $danhSachSanPhamHienThi = $danhSachLaptopCu;
                                @endphp
                                @include('user.layouts.sidebarsp')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content-wraper end -->
    <!-- Begin Product Area -->
    <div class="product-area pt-35">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="li-product-tab">
                        <ul class="nav li-product-menu">
                            <li><a class="active" data-toggle="tab" href="#description"><span>Thông tin</span></a>
                            </li>
                            <li><a data-toggle="tab" href="#reviews"><span>Bình luận</span></a>
                            </li>

                        </ul>
                    </div>
                    <!-- Begin Li's Tab Menu Content Area -->
                </div>
            </div>
            <div class="tab-content">
                <div id="description" class="tab-pane active show" role="tabpanel">
                    <div class="product-description">
                        <div class="product-details-manufacturer col-lg-6">
                            <table class="table table-bordered table-hover mb-0 table-cauhinh">
                                <tbody>
                                    <tr>
                                        <th style="width:30%">HÃNG</th>
                                        <td>{{ $hangSanXuatXem->tenhang }}</td>
                                    </tr>

                                    @if ($sanPhamXem->loaisanpham == 0)
                                        <tr>
                                            <th>CPU</th>
                                            <td>{{ $cauHinh->cpu }}</td>
                                        </tr>
                                        <tr>
                                            <th>RAM</th>
                                            <td>{{ $cauHinh->ram }} GB</td>
                                        </tr>
                                        <tr>
                                            <th>CARD ĐỒ HỌA</th>
                                            <td>
                                                @if ($cauHinh->carddohoa == 0)
                                                    Onboard
                                                @elseif($cauHinh->carddohoa == 1)
                                                    Nvidia
                                                @else
                                                    Amd
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Ổ CỨNG</th>
                                            <td>SSD {{ $cauHinh->ocung }} GB</td>
                                        </tr>
                                        <tr>
                                            <th>MÀN HÌNH</th>
                                            <td>{{ $cauHinh->manhinh }} inch</td>
                                        </tr>
                                        <tr>
                                            <th>NHU CẦU</th>
                                            <td class="viethoachudau">{{ $cauHinh->nhucau }}</td>
                                        </tr>
                                        <tr>
                                            <th>TÌNH TRẠNG</th>
                                            @if ($cauHinh->tinhtrang == 0)
                                                <td>Mới</td>
                                            @else
                                                <td>Cũ</td>
                                            @endif
                                        </tr>
                                        <tr>
                                        @elseif($sanPhamXem->loaisanpham == 1)
                                        <tr>
                                            <th>TÊN LOẠI</th>
                                            <td class="viethoachudau">{{ $thongTinPhuKien->tenloaiphukien }}</td>
                                        </tr>
                                    @endif
                                    <th>BẢO HÀNH</th>
                                    <td>{{ $sanPhamXem->baohanh }} Tháng</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <span>{{ $sanPhamXem->mota }}</span>
                    </div>
                </div>
                <div id="reviews" class="tab-pane" role="tabpanel">
                    <div class="product-reviews">
                        <div class="product-details-comment-block">
                            <div class="fb-comments"
                                data-href="https://www.facebook.com/zuck/posts/10102735452532991?comment_id=1070233703036185"
                                data-width="600" data-numposts="3"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Product Area End Here -->
    <!-- Begin Li's Laptop Product Area -->
    <section class="product-area li-laptop-product pt-30 pb-50">
        <div class="container">
            <div class="row">
                <!-- Begin Li's Section Area -->
                <div class="col-lg-12">
                    <div class="li-section-title">
                        <h2>
                            <span>Sản Phẩm Tương Tự</span>
                        </h2>
                    </div>
                    <div class="row">
                        <div class="product-active owl-carousel">
                            @php
                                $danhSachSanPhamHienThi = $danhSachSanPhamTuongTu;
                            @endphp
                            @include('user.layouts.slidesp')
                        </div>
                    </div>
                </div>
                <!-- Li's Section Area End Here -->
            </div>
    </section>
    <!-- Li's Laptop Product Area End Here -->
@endsection
@section('js')
    {{-- thêm js --}}
    <!-- Load Facebook SDK for JavaScript -->
    <div id="fb-root"></div>
    <script script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v12.0"
        nonce="B3LInnqr"></script>
@endsection
