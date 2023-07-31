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
                    <li class="active"><a href="{{ route('timkiem') }}">Danh sách sản phẩm</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="content-wraper pb-60 pt-sm-30">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="single-banner shop-page-banner mb-30">
                        <a href="#">
                            <img src="{{ asset('img/banner/dssp.jpg') }}" alt="Li's Static Banner">
                        </a>
                    </div>
                    @if (!empty(request()->tukhoa))
                        <h5>Tìm kiếm theo từ khóa "{{ request()->tukhoa }}"</h5>
                    @endif
                    <!-- shop-top-bar start -->
                    <div class="shop-top-bar mt-15">
                        <div class="shop-bar-inner">
                            <div class="toolbar-amount ml-0">
                                <span>Tổng sản phẩm
                                    ({{ !empty($danhSachSanPham) ? count($danhSachSanPham) : '0' }})</span>
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
                                                <div class="col-lg-3 col-md-4 col-sm-6 mt-40">
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
                            {{-- <div class="paginatoin-area">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 pt-xs-15">
                                        <p>Hiển thị 1-9 của tổng 9 sản phẩm</p>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <ul class="pagination-box pt-xs-20 pb-xs-15">
                                            <li><a href="#" class="Previous"><i class="fa fa-chevron-left"></i> Trước</a>
                                            </li>
                                            <li class="active"><a href="#">1</a></li>
                                            <li><a href="#">2</a></li>
                                            <li><a href="#">3</a></li>
                                            <li>
                                                <a href="#" class="Next">Sau <i
                                                        class="fa fa-chevron-right"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    <!-- shop-products-wrapper end -->
                </div>

            </div>
        </div>
    </div>
@endsection
@section('js')
    {{-- thêm js --}}
    <script>
        $(document).ready(function() {
            $('#sapxep').change(function() {
                var url = "{!! url('timkiem') . '?boloc=' . request()->boloc . '&tukhoa=' . request()->tukhoa . '&sapxep=' !!}" + $(this).val();
                if (url) {
                    window.location = url;
                }
                return false;
            });
        });
    </script>
@endsection
