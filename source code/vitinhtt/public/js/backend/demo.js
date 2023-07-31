function doiTrangThaiNguoiDung(hoTenNguoiDungKhoa, maNguoiDungKhoa, trangThaiNguoiDungKhoa) {
    if (trangThaiNguoiDungKhoa == 0) { //dang bi khoa
        document.getElementById('tieuDeKhoa').innerHTML = 'Bạn có thực sự muốn mở khóa?';
        document.getElementById('noiDungKhoa').innerHTML = 'Thao tác này sẽ mở khóa [' + hoTenNguoiDungKhoa +
            '], nên cân nhắc trước khi thực hiện';
        document.getElementById('thaoTac').innerHTML = 'Mở khóa';
        $('#thaoTac').removeClass('btn-warning');
        $('#thaoTac').addClass('btn-success');
    }
    if (trangThaiNguoiDungKhoa == 1) { //dang hoat dong
        document.getElementById('tieuDeKhoa').innerHTML = 'Bạn có thực sự muốn khóa?';
        document.getElementById('noiDungKhoa').innerHTML = 'Thao tác này sẽ khóa [' + hoTenNguoiDungKhoa +
            '], các PHIẾU XUẤT chưa GIAO HÀNG THÀNH CÔNG sẽ chuyển thành ĐÃ HỦY, nên cân nhắc trước khi thực hiện';
        document.getElementById('thaoTac').innerHTML = 'Khóa';
        $('#thaoTac').removeClass('btn-success');
        $('#thaoTac').addClass('btn-warning');
    }
    document.getElementById('maNguoiDungKhoa').value = maNguoiDungKhoa;
};

function suaMaGiamGia(maGiamGia, hetHanSuDung) {
    document.getElementById('maGiamGiaSua').value = maGiamGia.magiamgia;
    document.getElementById('maGiamGiaHien').innerHTML = maGiamGia.magiamgia;
    document.getElementById('soTienGiamSua').value = maGiamGia.sotiengiam;
    formatGia(document.getElementById('soTienGiamSua'));
    document.getElementById('soTienGiamHien').innerHTML = document.getElementById('soTienGiamSua').value;
    document.getElementById('ngayBatDauSua').min = maGiamGia.ngaybatdau;
    document.getElementById('ngayKetThucSua').min = maGiamGia.ngaybatdau;
    document.getElementById('ngayBatDauSua').value = maGiamGia.ngaybatdau;
    document.getElementById('ngayKetThucSua').value = maGiamGia.ngayketthuc;
    if (hetHanSuDung) {
        document.getElementById('hetHanCheck').checked = true;
        $('#divNgayBatDau').addClass('displaynone');
        $('#divNgayKetThuc').addClass('displaynone');
        document.getElementById('ngayBatDauSua').required = false;
        document.getElementById('ngayKetThucSua').required = false;
    } else {
        document.getElementById('hetHanCheck').checked = false;
        $('#divNgayBatDau').removeClass('displaynone');
        $('#divNgayKetThuc').removeClass('displaynone');
        document.getElementById('ngayBatDauSua').required = true;
        document.getElementById('ngayKetThucSua').required = true;
    }
    if (maGiamGia.mota != null) {
        document.getElementById('moTaSua').innerHTML = maGiamGia.mota;
    }
};

function xoaSanPham(tenSanPhamXoa, maSanPhamXoa) {
    document.getElementById('noiDungXoa').innerHTML = 'Thao tác này sẽ xóa sản phẩm [' + tenSanPhamXoa +
        '] vĩnh viễn và không thể khôi phục lại, nên cân nhắc trước khi xóa';
    document.getElementById('maSanPhamXoa').value = maSanPhamXoa;
};

function suaSanPham(sanPhamSua, cauHinhSua, hangSanXuatSua, thuVienHinhSua, quaTangSua) {
    var inputMaSanPhamSua = document.getElementById('maSanPhamSua');
    var inputTenSanPhamSua = document.getElementById('tenSanPhamSua');
    var inputBaoHanhSua = document.getElementById('baoHanhSua');
    var inputHangSanXuatSua = document.getElementById('hangSanXuatSua');
    inputMaSanPhamSua.value = sanPhamSua.masanpham;
    inputTenSanPhamSua.value = sanPhamSua.tensanpham;
    inputBaoHanhSua.value = sanPhamSua.baohanh;
    inputBaoHanhSua.innerHTML = sanPhamSua.baohanh + ' tháng';
    inputHangSanXuatSua.value = hangSanXuatSua.mahang;
    inputHangSanXuatSua.innerHTML = hangSanXuatSua.tenhang;
    if (sanPhamSua.loaisanpham == 0) { //la laptop
        var inputCpuSua = document.getElementById('cpuSua');
        var inputRamSua = document.getElementById('ramSua');
        var inputCardDoHoaSua = document.getElementById('cardDoHoaSua');
        var inputOCungSua = document.getElementById('oCungSua');
        var inputManHinhSua = document.getElementById('manHinhSua');
        var inputNhuCauSua = document.getElementById('nhuCauSua');
        var inputTinhTrangSua = document.getElementById('tinhTrangSua');
        inputCpuSua.value = cauHinhSua.cpu;
        inputRamSua.value = cauHinhSua.ram;
        inputRamSua.innerHTML = cauHinhSua.ram + ' GB';
        inputCardDoHoaSua.value = cauHinhSua.carddohoa;
        if (cauHinhSua.carddohoa == 0) {
            inputCardDoHoaSua.innerHTML = 'Onboard';
        } else if (cauHinhSua.carddohoa == 1) {
            inputCardDoHoaSua.innerHTML = 'Nvidia';
        } else if (cauHinhSua.carddohoa == 2) {
            inputCardDoHoaSua.innerHTML = 'Amd';
        }
        inputOCungSua.value = cauHinhSua.ocung;
        inputOCungSua.innerHTML = cauHinhSua.ocung + ' GB';
        inputManHinhSua.value = cauHinhSua.manhinh;
        inputNhuCauSua.value = cauHinhSua.nhucau;
        inputNhuCauSua.innerHTML = cauHinhSua.nhucau;
        inputTinhTrangSua.value = cauHinhSua.tinhtrang;
        if (cauHinhSua.tinhtrang == 0) {
            inputTinhTrangSua.innerHTML = 'Mới';
        } else if (cauHinhSua.tinhtrang == 1) {
            inputTinhTrangSua.innerHTML = 'Cũ';
        }
    } else if (sanPhamSua.loaisanpham == 1) { //la phu kien
        var inputTenLoaiPhuKienSua = document.getElementById('tenLoaiPhuKienSua');
        inputTenLoaiPhuKienSua.innerHTML = cauHinhSua.tenloaiphukien;
    }
    if (thuVienHinhSua.hinh1 != null) {
        document.getElementById('hinh1').innerHTML = '<img class="thongtinhinhsua" src="img/sanpham/' +
            thuVienHinhSua.hinh1 + '">';
    } else {
        document.getElementById('hinh1').innerHTML = '';
    }
    if (thuVienHinhSua.hinh2 != null) {
        document.getElementById('hinh2').innerHTML = '<img class="thongtinhinhsua" src="img/sanpham/' +
            thuVienHinhSua.hinh2 + '">';
    } else {
        document.getElementById('hinh2').innerHTML = '';
    }
    if (thuVienHinhSua.hinh3 != null) {
        document.getElementById('hinh3').innerHTML = '<img class="thongtinhinhsua" src="img/sanpham/' +
            thuVienHinhSua.hinh3 + '">';
    } else {
        document.getElementById('hinh3').innerHTML = '';
    }
    if (thuVienHinhSua.hinh4 != null) {
        document.getElementById('hinh4').innerHTML = '<img class="thongtinhinhsua" src="img/sanpham/' +
            thuVienHinhSua.hinh4 + '">';

    } else {
        document.getElementById('hinh4').innerHTML = '';
    }
    if (thuVienHinhSua.hinh5 != null) {
        document.getElementById('hinh5').innerHTML = '<img class="thongtinhinhsua" src="img/sanpham/' +
            thuVienHinhSua.hinh5 + '">';
    } else {
        document.getElementById('hinh5').innerHTML = '';
    }
    for (var i = 0; i < 5; i++) {
        var inputQuaTangSua = document.getElementById('quaTangSua' + i);
        if (quaTangSua[i] != null) {
            inputQuaTangSua.selected = "true";
            inputQuaTangSua.value = quaTangSua[i].masanpham;
            inputQuaTangSua.innerHTML = '[SP' + quaTangSua[i].masanpham + '] - ' + quaTangSua[i].tensanpham;
        } else if (quaTangSua[i] === undefined) {
            inputQuaTangSua.selected = "true";
            inputQuaTangSua.value = null;
            inputQuaTangSua.innerHTML = 'Bỏ chọn sản phẩm ' + (i + 1);
        }
    }
    if (sanPhamSua.mota != null) {
        document.getElementById('moTaSua').innerHTML = sanPhamSua.mota;
    }
};

function xoaHangSanXuat(tenHangXoa, maHangXoa, loaiHangXoa, soSanPhamThuocHangXoa) {
    if (soSanPhamThuocHangXoa > 0) {
        if (loaiHangXoa == 0) {
            loaiHangXoa = 'LAPTOP';
        } else {
            loaiHangXoa = 'PHỤ KIỆN';
        }
        document.getElementById('noiDungXoa').innerHTML = 'Hãng sản xuất ' + tenHangXoa +
            ' có ' + soSanPhamThuocHangXoa +
            ' MẪU ' + loaiHangXoa + ' thuộc hãng này nên không thể tiến hành thao tác xóa';
        $('#nutXoa').addClass("displaynone");
    } else {
        document.getElementById('noiDungXoa').innerHTML = 'Thao tác này sẽ xóa hãng sản xuất ' + tenHangXoa +
            ' vĩnh viễn và không thể khôi phục lại, nên cân nhắc trước khi xóa';
        document.getElementById('maHangXoa').value = maHangXoa;
        $('#nutXoa').removeClass("displaynone");
    }
};

function xoaMaGiamGia(maGiamGiaXoa, soDonDaApDung) {
    if (soDonDaApDung > 0) {
        document.getElementById('noiDungXoa').innerHTML = 'Mã giảm giá' + maGiamGiaXoa +
            ' đã được áp dụng cho ' + soDonDaApDung +
            ' PHIẾU XUẤT nên không thể tiến hành thao tác xóa';
        $('#nutXoa').addClass("displaynone");
    } else {
        document.getElementById('noiDungXoa').innerHTML = 'Thao tác này sẽ xóa mã giảm giá ' + maGiamGiaXoa +
            ' vĩnh viễn và không thể khôi phục lại, nên cân nhắc trước khi xóa';
        document.getElementById('maGiamGiaXoa').value = maGiamGiaXoa;
        $('#nutXoa').removeClass("displaynone");
    }
};

function formatGia(input) {
    input.value = parseFloat(input.value.replace(/,/g,
            ""))
        .toFixed(0)
        .toString()
        .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
};

function capNhatGia(tenSanPhamXoa, maSanPhamXoa, giaNhapSua, giaBanSua, giaKhuyenMaiSua) {
    document.getElementById('noiDungSuaGia').innerHTML = 'Nhập giá của [' + tenSanPhamXoa +
        '] theo mẫu bên dưới';
    document.getElementById('maSanPhamSuaGia').value = maSanPhamXoa;
    document.getElementById('giaNhap').value = giaNhapSua;
    formatGia(document.getElementById('giaNhap'));
    document.getElementById('giaNhapHien').innerHTML = document.getElementById('giaNhap').value;
    document.getElementById('giaBan').value = giaBanSua;
    formatGia(document.getElementById('giaBan'));
    if (giaKhuyenMaiSua > 0) {
        document.getElementById('giaKhuyenMaiCheck').checked = true;
        document.getElementById('giaKhuyenMai').required = true;
        document.getElementById('giaKhuyenMai').value = giaKhuyenMaiSua;
        formatGia(document.getElementById('giaKhuyenMai'));
        $('#noiDungGiaKhuyenMai').removeClass("displaynone");
        $('#giaKhuyenMai').removeClass("displaynone");
    } else {
        document.getElementById('giaKhuyenMaiCheck').checked = false;
        document.getElementById('giaKhuyenMai').required = false;
        document.getElementById('giaKhuyenMai').value = giaBanSua * 99 / 100;
        formatGia(document.getElementById('giaKhuyenMai'));
        $('#noiDungGiaKhuyenMai').addClass("displaynone");
        $('#giaKhuyenMai').addClass("displaynone");
    }
};

function hienThiGiaKhuyenMai() {
    var giaKhuyenMaiCheck = document.getElementById('giaKhuyenMaiCheck');
    var giaKhuyenMai = document.getElementById('giaKhuyenMai');
    if (giaKhuyenMaiCheck.checked) {
        $('#noiDungGiaKhuyenMai').removeClass("displaynone");
        $('#giaKhuyenMai').removeClass("displaynone");
    } else {
        $('#noiDungGiaKhuyenMai').addClass("displaynone");
        $('#giaKhuyenMai').addClass("displaynone");
    }
    giaKhuyenMai.required = giaKhuyenMaiCheck.checked;
};

function dinhDangGia(input) {
    var giaTri = input.value.split(","); // format tien ,,, lai thanh so
    var temp = "";
    for (var i = 0; i < giaTri.length; i++) {
        temp += giaTri[i];
    }
    input.value = parseFloat(temp);
    if (isNaN(input.value)) {
        input.value = 0;
    } else {
        formatGia(input);
    }
};

function doiTen(tenHang) {
    tenHang.value = tenHang.value.toUpperCase();
};

function chinhNgay(inputNgayBatDau, idNgayKetThuc) {
    var inputNgayKetThuc = document.getElementById(idNgayKetThuc);
    inputNgayKetThuc.value = inputNgayBatDau.value;
    inputNgayKetThuc.min = inputNgayBatDau.value;
};
$(document).ready(function() {
    // Add Row
    $('#add-row').DataTable({
        "pageLength": 10,
    });
});