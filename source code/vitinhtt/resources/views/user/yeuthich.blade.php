@extends('user.layouts.client')
@section('title')
    Yêu thích
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
                    <li class="active"><a href="{{ route('yeuthich') }}">Yêu thích</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!--Wishlist Area Strat-->
    <div class="wishlist-area pt-60 pb-60">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <form action="#">
                        <div class="table-content table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="li-product-remove">xóa</th>
                                        <th class="li-product-thumbnail">hình ảnh</th>
                                        <th class="cart-product-name">sản phẩm</th>
                                        <th class="li-product-price">giá bán</th>
                                        <th class="li-product-add-cart"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty(session('yeuThich')))
                                        <form action="{{ route('xulygiohang') }}" method="post"></form>
                                        @foreach (session('yeuThich') as $ctyt)
                                            <tr>
                                                <td class="li-product-remove">
                                                    <button
                                                        onclick="window.location.href='{{ url('xulyyeuthich?thaotac=boyeuthich&masp=' . $ctyt['masanpham']) }}';"
                                                        type="button" class="btn btn-focus p-0 pr-1 pl-1" title="Xóa"
                                                        style='color:#555'><i class='fa fa-times'></i></button>
                                                </td>
                                                <td class="li-product-thumbnail hinh-giohang p-2"><a
                                                        href="{{ url('chitietsp?masp=' . $ctyt['masanpham']) }}"><img
                                                            src="{{ asset('img/sanpham/' . $ctyt['hinh']) }}"
                                                            alt="Li's Product Image"></a></td>
                                                <td class="li-product-name cantrai p-0 pl-25"><a class="mauchu-link"
                                                        href="{{ url('chitietsp?masp=' . $ctyt['masanpham']) }}">[SP{{ $ctyt['masanpham'] }}]
                                                        - {{ $ctyt['tensanpham'] }}</a>
                                                </td>
                                                <td class="li-product-price canphai p-0 pr-25">
                                                    @if (!empty($ctyt['giakhuyenmai']))
                                                        <span
                                                            class="amount">{{ number_format($ctyt['giakhuyenmai'], 0, ',') }}đ</span>
                                                    @else
                                                        <span
                                                            class="amount">{{ $ctyt['giaban'] > 0 ? number_format($ctyt['giaban'], 0, ',') . 'đ' : 'Liên hệ' }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <form action="{{ route('xulygiohang') }}" method="post">
                                                        <div class="single-add-to-cart">
                                                            <div class="cart-quantity mt-0">
                                                                <input hidden value="1" type="number" min="1"
                                                                max="1" name="soLuongMua" required>
                                                            <input hidden value="{{ $ctyt['masanpham'] }}" type="number"
                                                                name="maSanPhamMua" required>
                                                            <button class="add-to-cart nutthemgiohang" type="submit" name="thaoTac"
                                                                value="thêm giỏ hàng">Thêm Giỏ Hàng</button>
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
                                                            </div>
                                                        </div>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--Wishlist Area End-->
@endsection
@section('js')
    {{-- thêm js --}}
@endsection
