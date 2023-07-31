{{-- modal xoa start --}}
<div class="modal fade" id="chinhGia" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header no-bd">
                <h4 class="modal-title">
                    <span class="fw-mediumbold">
                        Cập nhật giá sản phẩm</span>
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('xulysanpham') }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <p class="small" id="noiDungSuaGia" style="font-size:14px !important;"></p>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group form-group-default">
                                <label style="font-size:12px !important;">Giá nhập</label>
                                <input id="giaNhap" type="text" class="form-control displaynone" pattern="[0-9,]*"
                                    disabled>
                                <p id="giaNhapHien" class="m-0 mt-1"></p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group form-group-default">
                                <div class="form-check p-0 mt-1 mb-2">
                                    <label class="form-check-label">
                                        <input class="form-check-input" onchange="hienThiGiaKhuyenMai()"
                                            name="giaKhuyenMaiCheck" id="giaKhuyenMaiCheck" type="checkbox">
                                        <span class="form-check-sign"
                                            style="color: #495057!important;padding-top:3px; font-size: 12px">Giá khuyến
                                            mãi<p id="noiDungGiaKhuyenMai" class="m-0" style="font-size:9px">(Giá
                                                bán > Giá khuyến
                                                mãi > Giá nhập)</p></span>
                                    </label>
                                </div>
                                <input id="giaKhuyenMai" name="giaKhuyenMai" type="text" class="form-control"
                                    onkeyup="dinhDangGia(this)" pattern="[0-9,]*">
                                @error('giaKhuyenMai')
                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group form-group-default">
                                <label style="font-size:12px !important;">Giá bán (*)<p class="m-0"
                                        style="font-size:9px">(Giá
                                        bán > Giá nhập)</p></label>
                                <input id="giaBan" name="giaBan" type="text" class="form-control"
                                    onkeyup="dinhDangGia(this)" pattern="[0-9,]*" required>
                                @error('giaBan')
                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <input id="maSanPhamSuaGia" name="maSanPhamSuaGia" type="number" hidden required>
                <div class="modal-footer no-bd">
                    <button type="button" class="btn btn-focus" data-dismiss="modal">Đóng</button>
                    <button type="submit" name="thaoTac" value="cập nhật giá" class="btn btn-primary">Lưu</button>
                </div>
                @csrf
            </form>
        </div>
    </div>
</div>
{{-- modal xoa end --}}
