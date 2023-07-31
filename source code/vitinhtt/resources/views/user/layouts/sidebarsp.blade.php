@php
$dem = 0;
@endphp
@if (!empty($danhSachSanPhamHienThi))
    @foreach ($danhSachSanPhamHienThi as $sanPham)
        @php
            if($dem<3) $dem++;
            else break;
        @endphp
        <div class="row pt-5 pb-10 mb-5" style="border-bottom: 1px solid #ccc">
            <div class="col-12 group-featured-pro-wrapper">
                <div class="product-img p-0">
                    <a href="{{ url('chitietsp?masp=' . $sanPham->masanpham) }}">
                        @if (!empty($danhSachThuVienHinh))
                            @foreach ($danhSachThuVienHinh as $thuVienHinh)
                                @if ($thuVienHinh->mathuvienhinh == $sanPham->mathuvienhinh)
                                    <img width="100%" class="khung-banner"
                                        src="{{ asset('img/sanpham/' . $thuVienHinh->hinh1) }}">
                                @endif
                            @endforeach
                        @endif
                    </a>
                </div>
                <div class="featured-pro-content p-0 pt-5 pl-15">
                    <h4><a class="featured-product-name"
                            href="{{ url('chitietsp?masp=' . $sanPham->masanpham) }}">{{ $sanPham->tensanpham }}</a>
                    </h4>
                    <div class="featured-price-box">
                        @if (!empty($sanPham->giakhuyenmai))
                            <p class="new-price giakhuyenmai">
                                {{ number_format($sanPham->giakhuyenmai, 0, ',') }}đ</p>
                            <p class="new-price giaban">
                                {{ number_format($sanPham->giaban, 0, ',') }}đ</p>
                        @else
                            @if ($sanPham->giaban > 0)
                                <p class="new-price giakhuyenmai">
                                    {{ number_format($sanPham->giaban, 0, ',') }}đ</p>
                            @else
                                <p class="new-price giakhuyenmai">
                                    Liên hệ</p>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif
