<!-- Modal them mau moi start-->
<div class="modal fade" id="themNguoiDung" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header no-bd">
                <h4 class="modal-title">
                    <span class="fw-mediumbold">
                        Thêm người dùng mới</span>
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('xulynguoidung') }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <p class="small" style="font-size:14px !important;">Nhập thông tin theo mẫu bên dưới</p>
                    <div class="row">
                        <div class="col-md-6 pr-2">
                            <div class="form-group form-group-default">
                                <label style="font-size:12px !important;">Họ tên (*)</label>
                                <input class="form-control"
                                    title="(Gồm các ký tự là chữ thường hoặc in hoa, có dấu hoặc không dấu, tối đa 50 ký tự)"
                                    name="hoTen" value="{{ old('hoTen') }}" required
                                    pattern="[a-zỳọáầảấờễàạằệếýộậốũứĩõúữịỗìềểẩớặòùồợãụủíỹắẫựỉỏừỷởóéửỵẳẹèẽổẵẻỡơôưăêâđA-ZỲỌÁẦẢẤỜỄÀẠẰỆẾÝỘẬỐŨỨĨÕÚỮỊỖÌỀỂẨỚẶÒÙỒỢÃỤỦÍỸẮẪỰỈỎỪỶỞÓÉỬỴẲẸÈẼỔẴẺỠƠÔƯĂÊÂĐ ]{3,50}"
                                    type="text">
                                @error('hoTen')
                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 pl-2">
                            <div class="form-group form-group-default">
                                <label style="font-size:12px !important;">Số điện thoại (*)</label>
                                <input class="form-control" required
                                    title="(Gồm các ký tự là số, có bắt đầu là số 0, tối đa 9 chữ số - không bao gồm ký tự đầu là 0)"
                                    name="soDienThoai" value="{{ old('soDienThoai') }}" pattern="^[0]\d{9}$"
                                    type="text">
                                @error('soDienThoai')
                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 pr-2">
                            <div class="form-group form-group-default">
                                <label style="font-size:12px !important;">Địa chỉ (*)</label>
                                <input class="form-control" required
                                    title="(Gồm các ký tự là chữ thường, in hoa, số hoặc các ký tự như ,.-/ và tối đa 255 ký tự)"
                                    name="diaChi" value="{{ old('diaChi') }}"
                                    pattern="[a-zỳọáầảấờễàạằệếýộậốũứĩõúữịỗìềểẩớặòùồợãụủíỹắẫựỉỏừỷởóéửỵẳẹèẽổẵẻỡơôưăêâđA-ZỲỌÁẦẢẤỜỄÀẠẰỆẾÝỘẬỐŨỨĨÕÚỮỊỖÌỀỂẨỚẶÒÙỒỢÃỤỦÍỸẮẪỰỈỎỪỶỞÓÉỬỴẲẸÈẼỔẴẺỠƠÔƯĂÊÂĐ0-9 -/,.]{3,255}"
                                    type="text">
                                @error('diaChi')
                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 pl-2">
                            <div class="form-group form-group-default">
                                <label style="font-size:12px !important;">Loại người dùng (*)</label>
                                <select class="form-control" id="loaiNguoiDung" name="loaiNguoiDung" required>
                                    @if (old('loaiNguoiDung') == 0)
                                        <option value="{{ old('loaiNguoiDung') }}" selected hidden>
                                            Khách hàng</option>
                                    @elseif(old('loaiNguoiDung') == 1)
                                        <option value="{{ old('loaiNguoiDung') }}" selected hidden>
                                            Đối tác</option>
                                    @elseif(old('loaiNguoiDung') == 2)
                                        <option value="{{ old('loaiNguoiDung') }}" selected hidden>
                                            Nhân viên</option>
                                    @endif
                                    <option value="0" {{ request()->is('themphieuxuat') ? 'selected' : '' }}>Khách hàng</option>
                                    <option value="1" {{ request()->is('themphieunhap') ? 'selected' : '' }}>Đối tác</option>
                                    {!! request()->is('nguoidung') ? '<option value="2">Nhân viên</option><option value="" selected hidden>Chọn ...</option>' : '' !!}
                                </select>
                                @error('loaiNguoiDung')
                                    <span style="color: red;font-size:10px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row container m-0 p-0 {{ old('loaiNguoiDung') == 2 ? '' : 'displaynone' }}"
                            id="taiKhoanNhanVien">
                            <div class="col-md-12">
                                <div class="form-group form-group-default">
                                    <label style="font-size:12px !important;">Email (*)</label>
                                    <input class="form-control" name="email" id="email"
                                        value="{{ old('email') }}" pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                                        title="(Gồm các ký tự chữ thường hoặc số, có chứa @, có chứa dấu . sau ký tự @, tối đa 150 ký tự)"
                                        type="email">
                                    @error('email')
                                        <span style="color: red;font-size:10px">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 pr-2">
                                <div class="form-group form-group-default">
                                    <label style="font-size:12px !important;">Mật khẩu (*)</label>
                                    <input class="form-control" name="matKhau" id="matKhau"
                                        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,32}"
                                        title="(Gồm các ký tự chữ thường, in hoa hoặc số, có chứa tối thiểu 1 ký tự thường, 1 ký tự in hoa và 1 ký tự số, từ 8-32 ký tự)"
                                        type="password">
                                    @error('matKhau')
                                        <span style="color: red;font-size:10px">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 pl-2">
                                <div class="form-group form-group-default">
                                    <label style="font-size:12px !important;">Nhập lại mật khẩu (*)</label>
                                    <input class="form-control" name="nhapLaiMatKhau" id="nhapLaiMatKhau"
                                        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,32}"
                                        title="(Gồm các ký tự chữ thường, in hoa hoặc số, có chứa tối thiểu 1 ký tự thường, 1 ký tự in hoa và 1 ký tự số, từ 8-32 ký tự)"
                                        type="password">
                                    @error('nhapLaiMatKhau')
                                        <span style="color: red;font-size:10px">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer no-bd">
                    <button type="button" class="btn btn-focus" data-dismiss="modal">Đóng</button>
                    <button type="submit" name="thaoTac" value="thêm người dùng" id="btnThemNguoiDung"
                        class="btn btn-primary">Thêm</button>
                </div>
                @csrf
            </form>
        </div>
    </div>
</div>
<!-- Modal them mau moi end-->
