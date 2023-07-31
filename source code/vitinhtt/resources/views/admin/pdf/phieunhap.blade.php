@php
function convert_number_to_words($number)
{
    $hyphen = ' ';
    $conjunction = '  ';
    $separator = ' ';
    $negative = 'âm ';
    $decimal = ' phẩy ';
    $dictionary = [
        0 => 'Không',
        1 => 'Một',
        2 => 'Hai',
        3 => 'Ba',
        4 => 'Bốn',
        5 => 'Năm',
        6 => 'Sáu',
        7 => 'Bảy',
        8 => 'Tám',
        9 => 'Chín',
        10 => 'Mười',
        11 => 'Mười một',
        12 => 'Mười hai',
        13 => 'Mười ba',
        14 => 'Mười bốn',
        15 => 'Mười năm',
        16 => 'Mười sáu',
        17 => 'Mười bảy',
        18 => 'Mười tám',
        19 => 'Mười chín',
        20 => 'Hai mươi',
        30 => 'Ba mươi',
        40 => 'Bốn mươi',
        50 => 'Năm mươi',
        60 => 'Sáu mươi',
        70 => 'Bảy mươi',
        80 => 'Tám mươi',
        90 => 'Chín mươi',
        100 => 'trăm',
        1000 => 'nghìn',
        1000000 => 'triệu',
        1000000000 => 'tỷ',
        1000000000000 => 'nghìn tỷ',
        1000000000000000 => 'nghìn triệu triệu',
        1000000000000000000 => 'tỷ tỷ',
    ];

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error('convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX, E_USER_WARNING);
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        [$number, $fraction] = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens = ((int) ($number / 10)) * 10;
            $units = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = [];
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
}
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <title>[Admin] Vi tính T&T - In phiếu nhập</title>
    <style>
        * {
            margin: 0px;
            padding: 0px;
            font-family: DejaVu Sans !important;
            font-weight: 400;
            font-size: 12px;
            color: #242424;
        }

        table,
        #logo,
        #phan2 {
            width: 100%;
        }

        #phan1,
        #phan3 {
            margin-top: 30px;
        }

        #phan2,#phan5 {
            margin-top: 45px;
        }

        #phan4 {
            margin-top: 15px;
        }

        #phan3 tr td {
            vertical-align: text-top;
        }

        #logocongty,
        #thongtinnguoinhan {
            padding-left: 30px;
        }

        #thongtincongty {
            padding-left: 120px;
        }

        #tencongty {
            padding-left: 100px;
            font-size: 16px;
        }

        #phan2,
        #phan4 thead tr td,
        .cangiua,
        #phan5 tr td {
            text-align: center;
        }

        #tenphieu {
            font-weight: bold;
            font-size: 18px;
        }

        #phan4 {
            padding: 0px 30px;
            border-collapse: collapse;
            border-spacing: 0px;
        }

        #phan4 tr td {
            font-size: 11px;
            border: 1px solid #242424;
            padding: 5px 5px;
            vertical-align: text-top;
        }

        #phan4 thead tr td,
        .tinhtien {
            font-size: 12px;
            font-weight: bold;
        }
        #phan4 tfoot{
            margin-top:100px;
        }
        #phan4 tfoot tr td {
            padding: 2px 5px;
            border: none;
        }

        .tensanpham,
        .tinhtien,.sotienbangchu {
            text-align: justify;
            padding-left: 15px !important;
            padding-right: 15px !important;
        }

        .sotien {
            text-align: right;
            padding-left: 15px !important;
            padding-right: 15px !important;
        }
        .phantinhtien td{
            padding-top: 15px !important;
        }
        .tinhtien {
            padding-left: 45px !important;
        }
        #phan5{
            padding: 0px 30px !important;
        }
        .sotienbangchu p{
            font-weight: bold;
            color: #242424;
        }
        .sotienbangchu span{
            font-style: italic;
            text-transform: lowercase;
        }
    </style>
</head>
@if (!empty($phieuNhapCanXem) && !empty($nguoiDungCanXem))

    <body>
        <table id="phan1">
            <tr>
                <td id="logocongty" width="30%"><img id="logo" src="{{ asset('img/logo/full.png') }}"
                        alt="Footer Logo"></td>
                <td id="thongtincongty">
                    <p id="tencongty">Vi Tính T&T</p>
                    <p>SĐT: 090.xxx.xnxx (Mr. Tiến) - 090.xxx.xnxx (Mr. Tòn)</p>
                    <p>EMAIL: dh51805750@student.stu.edu.vn</p>
                    <p>ĐỊA CHỈ: 180 Cao Lỗ, Phường 4, Quận 8, TP.HCM</p>
                </td>
            </tr>
        </table>
        <div id="phan2">
            <p id="tenphieu">PHIẾU NHẬP HÀNG</p>
            <p>Mã phiếu: PN{{ $phieuNhapCanXem->maphieunhap }}</p>
            <p>
                {{ 'Ngày ' .
                    date('d', strtotime($phieuNhapCanXem->ngaytao)) .
                    ' tháng ' .
                    date('m', strtotime($phieuNhapCanXem->ngaytao)) .
                    ' năm ' .
                    date('Y', strtotime($phieuNhapCanXem->ngaytao)) }}
            </p>
        </div>
        <table id="phan3">
            <tr>
                <td id="thongtinnguoinhan" width="60%">
                    <p>Nhà cung cấp: {{ $nguoiDungCanXem->hoten }}</p>
                    <p>SĐT: {{ $nguoiDungCanXem->sodienthoai }}</p>
                    <p>Địa chỉ: {{ $nguoiDungCanXem->diachi }}</p>
                </td>
                <td>
                    <p>Mã NCC: ND{{ $nguoiDungCanXem->manguoidung }}</p>
                    <p>Ghi chú: {{ $phieuNhapCanXem->ghichu }}</p>
                </td>
            </tr>
        </table>
        <table id="phan4">
            <thead>
                <tr>
                    <td width="6%">STT</td>
                    <td>Sản phẩm</td>
                    <td width="11%">Số lượng</td>
                    <td width="15%">Đơn giá</td>
                    <td width="15%">Thành tiền</td>
                </tr>
            </thead>
            <tbody>
                @if (!empty($danhSachChiTietPhieuNhapCanXem) && !empty($danhSachSanPham))
                    @php
                        $stt = 1;
                    @endphp
                    @foreach ($danhSachChiTietPhieuNhapCanXem as $ctpn)
                        <tr>
                            <td class="cangiua">{{ $stt++ }}</td>
                            <td class="tensanpham">
                                @foreach ($danhSachSanPham as $sanPham)
                                    @if ($sanPham->masanpham == $ctpn->masanpham)
                                        SP{{ $sanPham->masanpham }} | {{ $sanPham->tensanpham }}
                                    @break
                                @endif
                            @endforeach
                        </td>
                        <td class="cangiua">{{ $ctpn->soluong }}</td>
                        <td class="sotien">{{ number_format($ctpn->dongia, 0, ',') }}</td>
                        <td class="sotien">{{ number_format($ctpn->dongia * $ctpn->soluong, 0, ',') }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
        <tfoot>
            <tr class="phantinhtien">
                <td colspan="2" class="sotienbangchu"><p>Bằng chữ: <span id="tienchu">{{ convert_number_to_words($phieuNhapCanXem->tongtien) }}</span></p></td>
                <td colspan="2" class="tinhtien">Tổng tiền:</td>
                <td class="sotien">{{ number_format($phieuNhapCanXem->tongtien, 0, ',') }}</td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td colspan="2" class="tinhtien">Đã thanh toán:</td>
                <td class="sotien">{{ number_format($phieuNhapCanXem->tongtien+$phieuNhapCanXem->congno, 0, ',') }}</td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td colspan="2" class="tinhtien">Công nợ:</td>
                <td class="sotien">{{ number_format($phieuNhapCanXem->congno, 0, ',') }}</td>
            </tr>
        </tfoot>
    </table>
    <table id="phan5">
        <tr>
            <td>
                <p>{{'Ngày '.date('d').' tháng '.date('m').' năm '.date('Y')}}</p>
                <p>Người giao hàng</p>
            </td>
            <td>
                <p>{{'Ngày '.date('d').' tháng '.date('m').' năm '.date('Y')}}</p>
                <p>Người nhận hàng</p>
            </td>
        </tr>
    </table>
</body>
@endif

</html>
