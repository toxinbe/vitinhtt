-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3306
-- Thời gian đã tạo: Th7 27, 2022 lúc 02:15 AM
-- Phiên bản máy phục vụ: 5.7.36
-- Phiên bản PHP: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `vitinhtt`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietphieunhap`
--

DROP TABLE IF EXISTS `chitietphieunhap`;
CREATE TABLE IF NOT EXISTS `chitietphieunhap` (
  `machitietphieunhap` int(11) NOT NULL AUTO_INCREMENT,
  `maphieunhap` int(11) NOT NULL,
  `masanpham` int(11) NOT NULL,
  `soluong` int(11) NOT NULL COMMENT '(cái)',
  `dongia` double NOT NULL COMMENT '(VND)',
  PRIMARY KEY (`machitietphieunhap`),
  KEY `maphieunhap` (`maphieunhap`,`masanpham`),
  KEY `masanpham` (`masanpham`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `chitietphieunhap`
--

INSERT INTO `chitietphieunhap` (`machitietphieunhap`, `maphieunhap`, `masanpham`, `soluong`, `dongia`) VALUES
(10, 2, 1, 20, 100000),
(11, 2, 2, 20, 100000),
(12, 2, 3, 20, 100000),
(13, 2, 4, 20, 100000),
(14, 2, 5, 20, 100000),
(23, 1, 6, 10, 10000000),
(24, 1, 7, 10, 10000000),
(25, 1, 8, 10, 10000000),
(26, 1, 9, 10, 10000000),
(27, 1, 10, 10, 10000000),
(28, 1, 11, 10, 10000000),
(29, 1, 12, 10, 10000000),
(30, 1, 13, 10, 10000000),
(31, 1, 14, 10, 10000000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietphieuxuat`
--

DROP TABLE IF EXISTS `chitietphieuxuat`;
CREATE TABLE IF NOT EXISTS `chitietphieuxuat` (
  `machitietphieuxuat` int(11) NOT NULL AUTO_INCREMENT,
  `maphieuxuat` int(11) NOT NULL,
  `masanpham` int(11) NOT NULL,
  `baohanh` tinyint(4) NOT NULL COMMENT '	3, 6, 12...(tháng)',
  `soluong` int(11) NOT NULL COMMENT '(cái)',
  `dongia` double NOT NULL COMMENT '(VND)',
  PRIMARY KEY (`machitietphieuxuat`),
  KEY `madonhang` (`maphieuxuat`,`masanpham`),
  KEY `masanpham` (`masanpham`)
) ENGINE=InnoDB AUTO_INCREMENT=225 DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `chitietphieuxuat`
--

INSERT INTO `chitietphieuxuat` (`machitietphieuxuat`, `maphieuxuat`, `masanpham`, `baohanh`, `soluong`, `dongia`) VALUES
(218, 27, 4, 3, 1, 240000),
(219, 27, 1, 3, 2, 0),
(220, 27, 14, 3, 2, 18000000),
(221, 28, 1, 3, 10, 0),
(222, 28, 3, 6, 10, 0),
(223, 28, 5, 1, 10, 0),
(224, 28, 12, 12, 10, 23000000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giamgia`
--

DROP TABLE IF EXISTS `giamgia`;
CREATE TABLE IF NOT EXISTS `giamgia` (
  `magiamgia` varchar(50) NOT NULL COMMENT 'giam100k, giam200k, giam300k ',
  `mota` varchar(255) DEFAULT NULL,
  `sotiengiam` double NOT NULL,
  `ngaybatdau` date NOT NULL,
  `ngayketthuc` date NOT NULL,
  PRIMARY KEY (`magiamgia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `giamgia`
--

INSERT INTO `giamgia` (`magiamgia`, `mota`, `sotiengiam`, `ngaybatdau`, `ngayketthuc`) VALUES
('giam100k', 'giảm 100.000đ', 100000, '2022-07-22', '2022-07-23'),
('giam150k', 'giảm 150.000đ', 150000, '2022-07-11', '2022-12-24'),
('giam50k', 'giảm 50.000đ', 50000, '2022-07-10', '2022-12-31'),
('giam70k', 'giảm 70.000đ', 70000, '2022-07-13', '2022-08-07');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hangsanxuat`
--

DROP TABLE IF EXISTS `hangsanxuat`;
CREATE TABLE IF NOT EXISTS `hangsanxuat` (
  `mahang` int(11) NOT NULL AUTO_INCREMENT,
  `tenhang` varchar(50) NOT NULL COMMENT 'asus, acer, dell...',
  `loaihang` tinyint(4) NOT NULL COMMENT '0 là hãng của laptop, 1 là hãng của phụ kiện',
  PRIMARY KEY (`mahang`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `hangsanxuat`
--

INSERT INTO `hangsanxuat` (`mahang`, `tenhang`, `loaihang`) VALUES
(1, 'ASUS', 0),
(2, 'ACER', 0),
(3, 'DELL', 0),
(4, 'HP', 0),
(5, 'MSI', 0),
(6, 'LOGITECH', 1),
(7, 'FUHLEN', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `laptop`
--

DROP TABLE IF EXISTS `laptop`;
CREATE TABLE IF NOT EXISTS `laptop` (
  `malaptop` int(11) NOT NULL AUTO_INCREMENT,
  `tensanpham` varchar(150) NOT NULL,
  `cpu` varchar(50) NOT NULL COMMENT 'core i3, core i5, core i7...',
  `ram` tinyint(4) NOT NULL COMMENT '4, 8, 16...(GB)',
  `carddohoa` tinyint(4) NOT NULL COMMENT '0 là onboard, 1 là nvidia, 2 là amd',
  `ocung` smallint(6) NOT NULL COMMENT '128, 256, 512...(GB)',
  `manhinh` float NOT NULL COMMENT '13.3, 14.0, 15.6...(inch)',
  `nhucau` varchar(50) NOT NULL COMMENT 'sinh viên, đồ họa, gaming',
  `tinhtrang` tinyint(4) NOT NULL COMMENT '0 là mới, 1 là cũ',
  PRIMARY KEY (`malaptop`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `laptop`
--

INSERT INTO `laptop` (`malaptop`, `tensanpham`, `cpu`, `ram`, `carddohoa`, `ocung`, `manhinh`, `nhucau`, `tinhtrang`) VALUES
(1, 'Laptop Acer Aspire 3', 'Intel Core i3-1005G1', 4, 0, 128, 15.6, 'Sinh Viên', 0),
(2, 'Laptop Acer Swift 4', 'Intel Core i5-1135G7', 8, 0, 256, 15.6, 'Sinh Viên', 0),
(3, 'Laptop Asus VivoBook 14', 'Intel Core i5-1240P', 8, 1, 256, 14, 'Đồ Họa', 1),
(4, 'Laptop Asus Vivobook Pro', 'Amd Ryzen 7-5800H', 8, 2, 512, 14, 'Đồ Họa', 0),
(5, 'Laptop Dell G15', 'Amd Ryzen 7-5800H', 8, 1, 512, 15.6, 'Gaming', 0),
(6, 'Laptop HP Pavilion 15', 'Amd Ryzen 5-5600H', 8, 2, 512, 15.6, 'Đồ Họa', 1),
(7, 'Laptop Msi Alpha 15', 'Amd Ryzen 7-5800H', 16, 2, 512, 15.6, 'Gaming', 0),
(8, 'Laptop HP ProBook 450', 'Intel Core i5-1135G7', 8, 0, 256, 13.4, 'Sinh Viên', 1),
(9, 'Laptop Msi Bravo 15', 'Amd Ryzen 5-5600H', 16, 2, 512, 15.6, 'Gaming', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loiphanhoi`
--

DROP TABLE IF EXISTS `loiphanhoi`;
CREATE TABLE IF NOT EXISTS `loiphanhoi` (
  `maloiphanhoi` int(11) NOT NULL AUTO_INCREMENT,
  `noidung` varchar(255) NOT NULL,
  `trangthai` tinyint(4) NOT NULL COMMENT '0 là chưa đọc, 1 là đã đọc',
  `manguoidung` int(11) NOT NULL,
  `ngaytao` datetime NOT NULL,
  PRIMARY KEY (`maloiphanhoi`),
  KEY `manguoidung` (`manguoidung`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `loiphanhoi`
--

INSERT INTO `loiphanhoi` (`maloiphanhoi`, `noidung`, `trangthai`, `manguoidung`, `ngaytao`) VALUES
(11, 'tôi cần tư vấn laptop làm đồ án tốt nghiệp', 1, 35, '2022-07-24 20:46:29'),
(12, 'shop chất lượng, uy tín', 0, 35, '2022-07-24 20:47:52');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoidung`
--

DROP TABLE IF EXISTS `nguoidung`;
CREATE TABLE IF NOT EXISTS `nguoidung` (
  `manguoidung` int(11) NOT NULL AUTO_INCREMENT,
  `hoten` varchar(50) NOT NULL,
  `sodienthoai` varchar(10) NOT NULL COMMENT '10 ký tự, có số 0 ở ký tự đầu',
  `diachi` varchar(255) NOT NULL,
  `trangthai` tinyint(4) NOT NULL COMMENT '0 là bị khóa, 1 là đang hoạt động',
  `loainguoidung` tinyint(4) NOT NULL COMMENT '0 là khách hàng, 1 là đối tác, 2 là nhân viên',
  `email` varchar(150) DEFAULT NULL COMMENT 'phải chứa @',
  `password` varchar(60) DEFAULT NULL COMMENT '8-32 ký tự, gồm chữ thường, chữ hoa và số (mã hóa kiểu bcrypt)',
  `ngaytao` datetime NOT NULL,
  PRIMARY KEY (`manguoidung`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `nguoidung`
--

INSERT INTO `nguoidung` (`manguoidung`, `hoten`, `sodienthoai`, `diachi`, `trangthai`, `loainguoidung`, `email`, `password`, `ngaytao`) VALUES
(1, 'Nguyễn Hoàng Tiến', '0706805780', '717 Tạ Quang Bửu, P4, Q8, HCM', 0, 2, 'toxinbe@gmail.com', '$2y$10$TWFK7qUaXBf4BZaW34och.AavNh5Ybllrzj6eIg8N4S4sFby0xUm.', '2022-06-22 09:12:34'),
(2, 'Trương Ngọc Tòn', '0706123456', '717 tạ quang bửu', 1, 0, 'truongngocton123@gmail.com', '$2y$10$hQ2abA087vW2gxGUqaqDpuMA8bYyBFBIIFEE8YpDMAB6TJ5Dal0hC', '2022-06-22 09:13:09'),
(3, 'Vi Tính H&H', '0909123456', '93 đường số 3 cư xá Lữ Gia, P15, Q11, HCM', 1, 1, NULL, NULL, '2022-06-22 15:50:53'),
(4, 'Trường Đại Học STU', '0880123456', '180 Cao Lỗ, P4, Q8, HCM', 1, 0, NULL, NULL, '2022-06-22 15:51:37'),
(20, 'Admin Vi Tính TT', '0123123123', '717 tạ quang bửu', 1, 2, 'admin@gmail.com', '$2y$10$bYUnHAGch.tOj.lCY6IjMO8f8hvaCMETE5Fcy8pyT.EJrrulvmH9i', '2022-07-04 03:07:37'),
(22, 'Khách Hàng Online', '0123321123', '123 dsadsa', 1, 0, 'khachhang@gmail.com', '$2y$10$w1nkBAhh4.wlXeoVJkSPAecDcwLMmRGF9vgse/0jlV8dLGU.ab3M6', '2022-07-07 17:26:38'),
(35, 'Nguyễn Hoàng Tiến', '0951753456', '717 tạ quang bửu', 1, 0, NULL, NULL, '2022-07-24 20:37:51'),
(36, 'Trương Ngọc Toàn', '0969463863', '717 ta quang buu', 1, 0, 'toan@gmail.com', '$2y$10$mWSdKbYVHvQkv/PTd01z3eksDgUxK5HWcl0KoAA4tGBxvsSQJhXEC', '2022-07-25 09:40:14');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieunhap`
--

DROP TABLE IF EXISTS `phieunhap`;
CREATE TABLE IF NOT EXISTS `phieunhap` (
  `maphieunhap` int(11) NOT NULL AUTO_INCREMENT,
  `manguoidung` int(11) NOT NULL,
  `ghichu` varchar(255) DEFAULT NULL,
  `tongtien` double NOT NULL COMMENT '(VND)',
  `congno` double NOT NULL COMMENT '0 là đã thanh toán, !=0 là công nợ',
  `ngaytao` datetime NOT NULL,
  PRIMARY KEY (`maphieunhap`),
  KEY `manguoidung` (`manguoidung`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `phieunhap`
--

INSERT INTO `phieunhap` (`maphieunhap`, `manguoidung`, `ghichu`, `tongtien`, `congno`, `ngaytao`) VALUES
(1, 3, 'nhập laptop', 900000000, 0, '2022-07-07 17:19:38'),
(2, 3, 'nhap phu kien', 10000000, -1000000, '2022-07-07 17:24:18');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieuxuat`
--

DROP TABLE IF EXISTS `phieuxuat`;
CREATE TABLE IF NOT EXISTS `phieuxuat` (
  `maphieuxuat` int(11) NOT NULL AUTO_INCREMENT,
  `hotennguoinhan` varchar(50) NOT NULL,
  `sodienthoainguoinhan` varchar(10) NOT NULL COMMENT 'chỉ chứa ký tự là số, 10 ký tự, ký tự đầu là 0',
  `diachinguoinhan` varchar(255) NOT NULL,
  `manguoidung` int(11) NOT NULL,
  `magiamgia` varchar(50) DEFAULT NULL,
  `ghichu` varchar(255) DEFAULT NULL,
  `tongtien` double NOT NULL COMMENT '(VND)',
  `tinhtranggiaohang` tinyint(4) NOT NULL COMMENT '0 là đã hủy, 1 là chờ xác nhận,\r\n2 là đang chuẩn bị hàng, 3 là đang giao, 4 là đã giao thành công',
  `hinhthucthanhtoan` tinyint(4) NOT NULL COMMENT '0 là tiền mặt, 1 là chuyển khoản, 2 là momo',
  `congno` double NOT NULL COMMENT '0 là đã thanh toán, !=0 là công nợ',
  `ngaytao` datetime NOT NULL,
  PRIMARY KEY (`maphieuxuat`),
  KEY `manguoidung` (`manguoidung`,`magiamgia`),
  KEY `makhuyenmai` (`magiamgia`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `phieuxuat`
--

INSERT INTO `phieuxuat` (`maphieuxuat`, `hotennguoinhan`, `sodienthoainguoinhan`, `diachinguoinhan`, `manguoidung`, `magiamgia`, `ghichu`, `tongtien`, `tinhtranggiaohang`, `hinhthucthanhtoan`, `congno`, `ngaytao`) VALUES
(27, 'Trương Ngọc Toàn', '0969463863', '717 ta quang buu', 36, 'giam50k', NULL, 36240000, 1, 2, 0, '2022-07-25 09:42:08'),
(28, 'Trương Ngọc Toàn', '0969463863', '717 ta quang buu', 36, NULL, NULL, 230000000, 1, 0, -230000000, '2022-07-25 09:56:54');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phukien`
--

DROP TABLE IF EXISTS `phukien`;
CREATE TABLE IF NOT EXISTS `phukien` (
  `maphukien` int(11) NOT NULL AUTO_INCREMENT,
  `tensanpham` varchar(150) NOT NULL,
  `tenloaiphukien` varchar(50) NOT NULL COMMENT 'phím, chuột, usb...',
  PRIMARY KEY (`maphukien`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `phukien`
--

INSERT INTO `phukien` (`maphukien`, `tensanpham`, `tenloaiphukien`) VALUES
(1, 'Chuột Fuhlen G3', 'Chuột'),
(2, 'Chuột Logitech B175', 'Chuột'),
(3, 'Phím Fuhlen Destroyer', 'Phím'),
(4, 'Phím Logitech K270', 'Phím'),
(5, 'Tai Nghe Logitech H111', 'Tai nghe');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `quatang`
--

DROP TABLE IF EXISTS `quatang`;
CREATE TABLE IF NOT EXISTS `quatang` (
  `maquatang` int(11) NOT NULL AUTO_INCREMENT,
  `tensanpham` varchar(150) NOT NULL,
  `masanpham1` int(11) DEFAULT NULL,
  `masanpham2` int(11) DEFAULT NULL,
  `masanpham3` int(11) DEFAULT NULL,
  `masanpham4` int(11) DEFAULT NULL,
  `masanpham5` int(11) DEFAULT NULL,
  PRIMARY KEY (`maquatang`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `quatang`
--

INSERT INTO `quatang` (`maquatang`, `tensanpham`, `masanpham1`, `masanpham2`, `masanpham3`, `masanpham4`, `masanpham5`) VALUES
(1, 'Chuột Fuhlen G3', NULL, NULL, NULL, NULL, NULL),
(2, 'Chuột Logitech B175', NULL, NULL, NULL, NULL, NULL),
(3, 'Phím Fuhlen Destroyer', NULL, NULL, NULL, NULL, NULL),
(4, 'Phím Logitech K270', NULL, NULL, NULL, NULL, NULL),
(5, 'Tai Nghe Logitech H111', NULL, NULL, NULL, NULL, NULL),
(6, 'Laptop Acer Aspire 3', 2, NULL, NULL, NULL, NULL),
(7, 'Laptop Acer Swift 4', 2, 5, NULL, NULL, NULL),
(8, 'Laptop Asus VivoBook 14', 2, 4, 5, NULL, NULL),
(9, 'Laptop Asus Vivobook Pro', 2, 4, 5, NULL, NULL),
(10, 'Laptop Dell G15', 1, 3, NULL, NULL, NULL),
(11, 'Laptop HP Pavilion 15', 2, NULL, NULL, NULL, NULL),
(12, 'Laptop Msi Alpha 15', 1, 3, 5, NULL, NULL),
(13, 'Laptop HP ProBook 450', 2, 4, 5, NULL, NULL),
(14, 'Laptop Msi Bravo 15', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

DROP TABLE IF EXISTS `sanpham`;
CREATE TABLE IF NOT EXISTS `sanpham` (
  `masanpham` int(11) NOT NULL AUTO_INCREMENT,
  `tensanpham` varchar(150) NOT NULL COMMENT 'vivobook, swift, thinkpad...',
  `baohanh` tinyint(4) NOT NULL COMMENT '3, 6, 12...(tháng)',
  `mota` varchar(255) DEFAULT NULL,
  `soluong` int(11) NOT NULL COMMENT '12, 35, 0...(cái)',
  `gianhap` double NOT NULL COMMENT 'giá nhập hàng (VND)',
  `giaban` double NOT NULL COMMENT 'giá bán cho khách (VND)',
  `giakhuyenmai` double DEFAULT NULL COMMENT 'giá khuyến mãi nếu có sản phẩm sẽ dc bán theo giá này (VND)',
  `mathuvienhinh` int(11) DEFAULT NULL,
  `mahang` int(11) DEFAULT NULL,
  `maquatang` int(11) DEFAULT NULL,
  `malaptop` int(11) DEFAULT NULL,
  `maphukien` int(11) DEFAULT NULL,
  `loaisanpham` tinyint(4) NOT NULL COMMENT '0 là laptop, 1 là phụ kiện',
  `ngaytao` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`masanpham`),
  KEY `mahang` (`mahang`),
  KEY `maquatang` (`maquatang`),
  KEY `mahinh` (`mathuvienhinh`),
  KEY `malaptop` (`malaptop`),
  KEY `maphukien` (`maphukien`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `sanpham`
--

INSERT INTO `sanpham` (`masanpham`, `tensanpham`, `baohanh`, `mota`, `soluong`, `gianhap`, `giaban`, `giakhuyenmai`, `mathuvienhinh`, `mahang`, `maquatang`, `malaptop`, `maphukien`, `loaisanpham`, `ngaytao`) VALUES
(1, 'Chuột Fuhlen G3', 3, 'Chuột gaming dành cho game thủ', 20, 100000, 350000, 320000, 1, 7, 1, NULL, 1, 1, '2022-06-18 16:10:26'),
(2, 'Chuột Logitech B175', 3, 'chuột văn phòng không dây', 20, 100000, 130000, NULL, 2, 6, 2, NULL, 2, 1, '2022-06-18 16:11:52'),
(3, 'Phím Fuhlen Destroyer', 6, 'phím cơ gaming dành cho game thủ', 20, 100000, 850000, NULL, 3, 7, 3, NULL, 3, 1, '2022-06-18 16:13:19'),
(4, 'Phím Logitech K270', 3, 'phím văn phòng không dây', 20, 100000, 240000, NULL, 4, 6, 4, NULL, 4, 1, '2022-06-18 16:14:25'),
(5, 'Tai Nghe Logitech H111', 1, 'tai nghe thích hợp cho việc học online có mic đàm thoại', 20, 100000, 130000, 113000, 5, 6, 5, NULL, 5, 1, '2022-06-18 16:16:13'),
(6, 'Laptop Acer Aspire 3', 12, 'Trang bị bộ vi xử lý Intel thế hệ thứ 10 Ice Lake mới nhất, ổ cứng SSD siêu tốc và màn hình Full HD tuyệt đẹp, Acer Aspire 3 A315 56 37DV là chiếc laptop đáp ứng tốt công việc và giải trí của bạn trong tầm giá hấp dẫn.', 10, 10000000, 12000000, 10500000, 6, 2, 6, 1, NULL, 0, '2022-06-19 20:51:45'),
(7, 'Laptop Acer Swift 4', 12, 'Nổi tiếng trong dòng laptop văn phòng với thiết kế mỏng nhẹ đi cùng giá thành hợp lý, Acer Aspire 3 luôn là lựa chọn hàng đầu dành cho người dùng. A315 58 53S6 sở hữu chip Intel Gen 11 mới nhất hiện nay cùng nhiều tính năng vượt trội.', 10, 10000000, 16000000, 15150000, 7, 2, 7, 2, NULL, 0, '2022-06-19 21:01:20'),
(8, 'Laptop Asus VivoBook 14', 3, 'Một trong những sản phẩm laptop cho sinh viên được đánh giá cao là Asus VivoBook X1402ZA EK084W. Thiết kế nhỏ gọn, cấu hình mạnh đáp ứng mọi yêu cầu từ học tập đến làm việc hay giải trí.', 10, 10000000, 15000000, 13900000, 8, 1, 8, 3, NULL, 0, '2022-06-19 21:03:21'),
(9, 'Laptop Asus Vivobook Pro', 12, 'Laptop Asus Vivobook Pro M3401QA KM040W là chiếc laptop văn phòng thiết kế mỏng nhẹ nhưng lại sở hữu cấu hình cực mạng và đạt hiệu suất làm việc cao. Màn hình OLED được thiết kế sinh động mang đến những trải nghiệm tốt nhất cho người dùng.', 10, 10000000, 13000000, 12500000, 9, 1, 9, 4, NULL, 0, '2022-06-19 21:05:04'),
(10, 'Laptop Dell G15', 24, 'Dell G15 5515 P105F004 70266674 nằm trong phân khúc laptop gaming 20 đến 25 triệu. Thiết kế kiểu dáng đẹp mắt với những tính năng vượt trội đây sẽ là một lựa chọn hoàn hảo dành riêng cho các game thủ.', 10, 10000000, 22500000, 21790000, 10, 3, 10, 5, NULL, 0, '2022-06-19 21:07:06'),
(11, 'Laptop HP Pavilion 15', 3, 'Laptop HP Pavilion 15 EG0513TU 46M12PA là mẫu laptop cho sinh viên, nhân viên văn phòng tầm trung rất được chú ý bởi thiết kế và hiệu năng mạnh mẽ của mình.', 10, 10000000, 13000000, NULL, 11, 4, 11, 6, NULL, 0, '2022-06-19 21:09:55'),
(12, 'Laptop Msi Alpha 15', 12, 'Laptop MSI Alpha 15 B5EEK 205VN là dòng laptop gaming luôn được các game thủ tin tưởng và yêu thích bởi sức mạnh không ngừng được cải thiện và thông số kỹ thuật tuyệt vời. MSI Alpha 15 là sự lựa chọn hợp lý cho các game thủ chuyên nghiệp.', 10, 10000000, 23000000, NULL, 12, 5, 12, 7, NULL, 0, '2022-06-19 21:11:42'),
(13, 'Laptop HP ProBook 450', 3, 'Laptop có kiểu dáng bắt mắt với thân máy siêu mỏng, hoàn thiện từ vỏ nhôm nguyên khối sang trọng. Phiên bản màu bạc thời trang, logo HP nổi bật bóng bẩy cùng viền màn hình mỏng hai cạnh thể hiện sự hiện đại và thời thượng.', 10, 10000000, 13000000, NULL, 13, 4, 13, 8, NULL, 0, '2022-06-19 21:13:37'),
(14, 'Laptop Msi Bravo 15', 3, 'Phục kích ở nơi hiểm yếu, quan sát kĩ càng kẻ địch trước khi xuất trận mạnh mẽ, MSI Bravo 15 B5DD 276VN đã sẵn sàng cho chiến trường game rực lửa. Kết hợp hoàn hảo giữa vi xử lí AMD Ryzen 5 5600H và card đồ họa AMD Radeon RX 5500M.', 10, 10000000, 18000000, NULL, 14, 5, 14, 9, NULL, 0, '2022-06-19 21:14:58');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thuvienhinh`
--

DROP TABLE IF EXISTS `thuvienhinh`;
CREATE TABLE IF NOT EXISTS `thuvienhinh` (
  `mathuvienhinh` int(11) NOT NULL AUTO_INCREMENT,
  `tensanpham` varchar(150) NOT NULL,
  `hinh1` varchar(255) NOT NULL COMMENT 'laptop.jpg, phim.png, chuot.jpeg...',
  `hinh2` varchar(255) DEFAULT NULL,
  `hinh3` varchar(255) DEFAULT NULL,
  `hinh4` varchar(255) DEFAULT NULL,
  `hinh5` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`mathuvienhinh`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `thuvienhinh`
--

INSERT INTO `thuvienhinh` (`mathuvienhinh`, `tensanpham`, `hinh1`, `hinh2`, `hinh3`, `hinh4`, `hinh5`) VALUES
(1, 'Fuhlen G3 RGB Gaming', 'Fuhlen G3 RGB Gaming-1655543426-0.jpg', 'Fuhlen G3 RGB Gaming-1655543426-1.jpg', 'Fuhlen G3 RGB Gaming-1655543426-2.jpg', 'Fuhlen G3 RGB Gaming-1655543426-3.jpg', 'Fuhlen G3 RGB Gaming-1655543426-4.jpg'),
(2, 'Logitech B175 Optical Wireless', 'Logitech B175 Optical Wireless-1655543512-0.jpg', 'Logitech B175 Optical Wireless-1655543512-1.jpg', 'Logitech B175 Optical Wireless-1655543512-2.jpg', 'Logitech B175 Optical Wireless-1655543512-3.jpg', NULL),
(3, 'Fuhlen Destroyer RGB Gaming', 'Fuhlen Destroyer RGB Gaming-1655543599-0.jpg', 'Fuhlen Destroyer RGB Gaming-1655543599-1.jpg', 'Fuhlen Destroyer RGB Gaming-1655543599-2.jpg', 'Fuhlen Destroyer RGB Gaming-1655543599-3.jpg', 'Fuhlen Destroyer RGB Gaming-1655543599-4.jpg'),
(4, 'Logitech K270 Optical Wireless', 'Logitech K270 Optical Wireless-1655543665-0.jpg', 'Logitech K270 Optical Wireless-1655543665-1.jpg', 'Logitech K270 Optical Wireless-1655543665-2.jpg', 'Logitech K270 Optical Wireless-1655543665-3.jpg', NULL),
(5, 'Logitech H111 Stereo Headset', 'Logitech H111 Stereo Headset-1655543814-0.jpg', 'Logitech H111 Stereo Headset-1655543814-1.jpg', 'Logitech H111 Stereo Headset-1655543814-2.jpg', 'Logitech H111 Stereo Headset-1655543814-3.jpg', 'Logitech H111 Stereo Headset-1655543814-4.jpg'),
(6, 'Laptop Acer Aspire 3 A315 56 37DV', 'Laptop Acer Aspire 3 A315 56 37DV-1655646705-0.jpg', 'Laptop Acer Aspire 3 A315 56 37DV-1655646705-1.jpg', 'Laptop Acer Aspire 3 A315 56 37DV-1655646705-2.jpg', 'Laptop Acer Aspire 3 A315 56 37DV-1655646705-3.jpg', NULL),
(7, 'Laptop Acer Aspire 3 A315 58 53S6', 'Laptop Acer Aspire 3 A315 58 53S6-1655647280-0.png', 'Laptop Acer Aspire 3 A315 58 53S6-1655647280-1.png', 'Laptop Acer Aspire 3 A315 58 53S6-1655647280-2.png', 'Laptop Acer Aspire 3 A315 58 53S6-1655647280-3.png', 'Laptop Acer Aspire 3 A315 58 53S6-1655647280-4.png'),
(8, 'Laptop Asus VivoBook 14 X1402ZA EK084W', 'Laptop Asus VivoBook 14 X1402ZA EK084W-1655647401-0.png', 'Laptop Asus VivoBook 14 X1402ZA EK084W-1655647401-1.png', 'Laptop Asus VivoBook 14 X1402ZA EK084W-1655647401-2.png', 'Laptop Asus VivoBook 14 X1402ZA EK084W-1655647401-3.png', 'Laptop Asus VivoBook 14 X1402ZA EK084W-1655647401-4.png'),
(9, 'Laptop Asus Vivobook Pro M3401QA KM040W', 'Laptop Asus Vivobook Pro M3401QA KM040W-1655647504-0.jpg', 'Laptop Asus Vivobook Pro M3401QA KM040W-1655647504-1.jpg', 'Laptop Asus Vivobook Pro M3401QA KM040W-1655647504-2.jpg', 'Laptop Asus Vivobook Pro M3401QA KM040W-1655647504-3.jpg', 'Laptop Asus Vivobook Pro M3401QA KM040W-1655647504-4.jpg'),
(10, 'Laptop Dell G15 5515 P105F004 70266674', 'Laptop Dell G15 5515 P105F004 70266674-1655647638-0.png', 'Laptop Dell G15 5515 P105F004 70266674-1655647638-1.png', 'Laptop Dell G15 5515 P105F004 70266674-1655647638-2.png', 'Laptop Dell G15 5515 P105F004 70266674-1655647638-3.png', 'Laptop Dell G15 5515 P105F004 70266674-1655647638-4.png'),
(11, 'Laptop HP Pavilion 15 EG0513TU 46M12PA', 'Laptop HP Pavilion 15 EG0513TU 46M12PA-1655647795-0.jpg', 'Laptop HP Pavilion 15 EG0513TU 46M12PA-1655647795-1.jpg', 'Laptop HP Pavilion 15 EG0513TU 46M12PA-1655647795-2.jpg', 'Laptop HP Pavilion 15 EG0513TU 46M12PA-1655647795-3.jpg', 'Laptop HP Pavilion 15 EG0513TU 46M12PA-1655647795-4.jpg'),
(12, 'Laptop Msi Alpha 15 B5EEK 205VN', 'Laptop Msi Alpha 15 B5EEK 205VN-1655647902-0.png', 'Laptop Msi Alpha 15 B5EEK 205VN-1655647902-1.png', 'Laptop Msi Alpha 15 B5EEK 205VN-1655647902-2.png', 'Laptop Msi Alpha 15 B5EEK 205VN-1655647902-3.png', 'Laptop Msi Alpha 15 B5EEK 205VN-1655647902-4.png'),
(13, 'Laptop HP ProBook 450 G8 614K3PA', 'Laptop HP ProBook 450 G8 614K3PA-1655648017-0.jpg', 'Laptop HP ProBook 450 G8 614K3PA-1655648017-1.jpg', 'Laptop HP ProBook 450 G8 614K3PA-1655648017-2.jpg', 'Laptop HP ProBook 450 G8 614K3PA-1655648017-3.jpg', NULL),
(14, 'Laptop Msi Bravo 15 B5DD 276VN', 'Laptop Msi Bravo 15 B5DD 276VN-1655648098-0.jpg', 'Laptop Msi Bravo 15 B5DD 276VN-1655648098-1.jpg', 'Laptop Msi Bravo 15 B5DD 276VN-1655648098-2.jpg', 'Laptop Msi Bravo 15 B5DD 276VN-1655648098-3.jpg', 'Laptop Msi Bravo 15 B5DD 276VN-1655648098-4.jpg');

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `chitietphieunhap`
--
ALTER TABLE `chitietphieunhap`
  ADD CONSTRAINT `chitietphieunhap_ibfk_1` FOREIGN KEY (`maphieunhap`) REFERENCES `phieunhap` (`maphieunhap`),
  ADD CONSTRAINT `chitietphieunhap_ibfk_2` FOREIGN KEY (`masanpham`) REFERENCES `sanpham` (`masanpham`);

--
-- Các ràng buộc cho bảng `chitietphieuxuat`
--
ALTER TABLE `chitietphieuxuat`
  ADD CONSTRAINT `chitietphieuxuat_ibfk_1` FOREIGN KEY (`maphieuxuat`) REFERENCES `phieuxuat` (`maphieuxuat`),
  ADD CONSTRAINT `chitietphieuxuat_ibfk_2` FOREIGN KEY (`masanpham`) REFERENCES `sanpham` (`masanpham`);

--
-- Các ràng buộc cho bảng `loiphanhoi`
--
ALTER TABLE `loiphanhoi`
  ADD CONSTRAINT `loiphanhoi_ibfk_1` FOREIGN KEY (`manguoidung`) REFERENCES `nguoidung` (`manguoidung`);

--
-- Các ràng buộc cho bảng `phieunhap`
--
ALTER TABLE `phieunhap`
  ADD CONSTRAINT `phieunhap_ibfk_1` FOREIGN KEY (`manguoidung`) REFERENCES `nguoidung` (`manguoidung`);

--
-- Các ràng buộc cho bảng `phieuxuat`
--
ALTER TABLE `phieuxuat`
  ADD CONSTRAINT `phieuxuat_ibfk_1` FOREIGN KEY (`manguoidung`) REFERENCES `nguoidung` (`manguoidung`),
  ADD CONSTRAINT `phieuxuat_ibfk_2` FOREIGN KEY (`magiamgia`) REFERENCES `giamgia` (`magiamgia`);

--
-- Các ràng buộc cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `sanpham_ibfk_1` FOREIGN KEY (`mahang`) REFERENCES `hangsanxuat` (`mahang`),
  ADD CONSTRAINT `sanpham_ibfk_3` FOREIGN KEY (`maquatang`) REFERENCES `quatang` (`maquatang`),
  ADD CONSTRAINT `sanpham_ibfk_4` FOREIGN KEY (`mathuvienhinh`) REFERENCES `thuvienhinh` (`mathuvienhinh`),
  ADD CONSTRAINT `sanpham_ibfk_5` FOREIGN KEY (`malaptop`) REFERENCES `laptop` (`malaptop`),
  ADD CONSTRAINT `sanpham_ibfk_6` FOREIGN KEY (`maphukien`) REFERENCES `phukien` (`maphukien`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
