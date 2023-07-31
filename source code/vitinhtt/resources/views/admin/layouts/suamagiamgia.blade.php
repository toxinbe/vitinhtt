{{-- modal xoa start --}}
<div class="modal fade" id="suaMaGiamGia" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header no-bd">
                <h4 class="modal-title">
                    <span class="fw-mediumbold">Sửa thời gian áp dụng mã</span>
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('xulymagiamgia') }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <p class="small" style="font-size:14px !important;">Nhập thông tin theo mẫu bên dưới</p>
                    <div class="row">
                        <div class="col-md-6 pr-2">
                            <div class="form-group form-group-default">
                                <label style="font-size:12px !important;">Mã giảm giá (*)</label>
                                <p id="maGiamGiaHien" class="m-0 mt-1"></p>
                            </div>
                        </div>
                        <div class="col-md-6 pl-2">
                            <div class="form-group form-group-default">
                                <label style="font-size:12px !important;">Số tiền giảm (*)</label>
                                <p id="soTienGiamHien" class="m-0 mt-1"></p>
                                <input id="soTienGiamSua" type="text" pattern="[0-9,]*" required hidden>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group form-group-default">
                                <div class="form-check p-0 mt-1 mb-2">
                                    <label class="form-check-label">
                                        <input class="form-check-input" name="hetHanCheck" id="hetHanCheck" type="checkbox">
                                        <span class="form-check-sign"
                                            style="color: #495057!important;padding-top:3px; font-size: 12px">Hết hạn</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 pr-2" id="divNgayBatDau">
                            <div class="form-group form-group-default">
                                <label style="font-size:12px !important;">Ngày bắt đầu (*)</label>
                                <input type="date" class="form-control" id="ngayBatDauSua" onblur="chinhNgay(this, 'ngayKetThucSua')"
                                name="ngayBatDauSua">
                                @error('ngayBatDauSua')
                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 pl-2" id="divNgayKetThuc">
                            <div class="form-group form-group-default">
                                <label style="font-size:12px !important;">Ngày kết thúc (*)</label>
                                <input type="date" class="form-control" id="ngayKetThucSua"
                                name="ngayKetThucSua">
                                @error('ngayKetThucSua')
                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group form-group-default">
                                <label style="font-size:12px !important;">Mô tả</label>
                                <textarea id="moTaSua" name="moTaSua" rows="5" class="form-control"></textarea>
                                @error('moTaSua')
                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <input id="maGiamGiaSua" name="maGiamGiaSua" pattern="[A-Za-z0-9]{3,50}" type="text" hidden required>
                <div class="modal-footer no-bd">
                    <button type="button" class="btn btn-focus" data-dismiss="modal">Đóng</button>
                    <button type="submit" id="thaoTac" name="thaoTac" value="sửa mã giảm giá"
                        class="btn btn-primary">Lưu</button>
                </div>
                @csrf
            </form>
        </div>
    </div>
</div>
{{-- modal xoa end --}}
