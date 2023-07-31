<!-- Modal them mau moi start-->
<div class="modal fade" id="themMaGiamGia" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header no-bd">
                <h4 class="modal-title">
                    <span class="fw-mediumbold">
                        Thêm mã giảm giá mới</span>
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
                                <input name="maGiamGia" pattern="[A-Za-z0-9]{3,50}" type="text" class="form-control"
                                title="(Gồm các ký tự là chữ thường, in hoa hoặc số, không dấu và không khoảng cách, tối đa 50 ký tự)"
                                    value="{{ old('maGiamGia') }}" required>
                                @error('maGiamGia')
                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 pl-2">
                            <div class="form-group form-group-default">
                                <label style="font-size:12px !important;">Số tiền giảm (*)</label>
                                <input id="soTienGiam" name="soTienGiam" type="text" class="form-control"
                                    onkeyup="dinhDangGia(this)" pattern="[0-9,]*" required>
                                @error('soTienGiam')
                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 pr-2">
                            <div class="form-group form-group-default">
                                <label style="font-size:12px !important;">Ngày bắt đầu (*)</label>
                                <input type="date" class="form-control" id="ngayBatDau" onblur="chinhNgay(this, 'ngayKetThuc')"
                                name="ngayBatDau" value="{{ !empty(old('ngayBatDau')) ? old('ngayBatDau') : date("Y-m-d")}}"
                                min="{{date("Y-m-d")}}" required>
                                @error('ngayBatDau')
                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 pl-2">
                            <div class="form-group form-group-default">
                                <label style="font-size:12px !important;">Ngày kết thúc (*)</label>
                                <input type="date" class="form-control" id="ngayKetThuc"
                                name="ngayKetThuc" value="{{ !empty(old('ngayKetThuc')) ? old('ngayKetThuc') : date("Y-m-d")}}"
                                min="{{date("Y-m-d")}}" required>
                                @error('ngayKetThuc')
                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group form-group-default">
                                <label style="font-size:12px !important;">Mô tả</label>
                                @if (old('moTa') != null)
                                    <textarea name="moTa" rows="5" class="form-control">{{ old('moTa') }}</textarea>
                                @else
                                    <textarea name="moTa" rows="5" class="form-control"></textarea>
                                @endif
                                @error('moTa')
                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer no-bd">
                    <button type="button" class="btn btn-focus" data-dismiss="modal">Đóng</button>
                    <button type="submit" name="thaoTac" value="thêm mã giảm giá" class="btn btn-primary">Thêm</button>
                </div>
                @csrf
            </form>
        </div>
    </div>
</div>
<!-- Modal them mau moi end-->
