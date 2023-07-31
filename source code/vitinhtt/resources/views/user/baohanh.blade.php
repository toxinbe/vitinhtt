@extends('user.layouts.client')
@section('title')
Bảo hành
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
                    <li class="active"><a href="{{ route('baohanh') }}">Bảo hành</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="banner-lienhe mb-50">
                    <img src="{{ asset('img/banner/lienhe.jpg') }}" alt="" style="width: 100%;">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 quydinh-baohanh">
                <h2 style="text-align: center;"><span style="color: #5a88ca!important;"><strong>QUY ĐỊNH VỀ CHÍNH SÁCH BẢO
                            HÀNH</strong></span></h2>
                <h3><strong><u>I. Địa điểm bảo hành: </u></strong></h3>
                <p>Tất cả hàng hóa T&T Computer bán ra đều được bảo hành tại:</p>
                <p>* <strong>Địa chỉ</strong>: 180 Cao Lỗ, Phường 4, Quận 8, TP.HCM</p>
                <p>* <strong>SĐT</strong>: 090.xxx.xnxx (Mr. Tiến)</p>
                <p>* <strong>Giờ làm việc</strong>: 10h00 - 15h00 (T2-T6)</p>
                <h3><strong><u>II. Điều kiện bảo hành:</u></strong></h3>
                <div class="content-baohanh">
                    <p>1. Sản phẩm đang trong thời hạn bảo hành, có tem bảo hành của nhà phân phối và có tem T&T Computer.
                        Hư
                        hỏng được xác định do lỗi kỹ thuật hoặc do lỗi của nhà sản xuất.</p>
                    <p>2. Tem bảo hành và mã vạch của công ty, của nhà cung cấp phải nguyên vẹn, không rách rời, vỡ nát,
                        biến
                        dạng; không bị tẩy xoá&#8230;</p>
                    <p>3. Sản phẩm phải còn nguyên vẹn, không cong, vênh, rạn nứt, trầy xước, sứt mẻ, nứt khe cắm, vỡ&#8230;
                    </p>
                    <p>4. Dùng đúng nguồn điện, không bị mối mọt, côn trùng xâm nhập; không cháy nổ, phồng tụ; không bị ô xy
                        hoá do đặt trong môi trường ẩm ướt&#8230;</p>
                    <p>5. Chưa can thiệp vào phần cứng (tự ý tháo dỡ, sửa chữa&#8230;).</p>
                    <p>6. Các điều kiện bảo hành của T&T Computer đều tuân theo tiêu chuẩn bảo hành của hãng sản xuất hoặc
                        nhà
                        phân phối tại Việt Nam.</p>
                    <p>7. Với mặt hàng CPU tray socket 1155, 1150, 1151, AMD &#8230;, T&T Computer ngoài dán tem còn ghi
                        serial trên phiếu bán hàng. Quý khách hàng nhớ kiểm tra serial khi mua hàng để dễ dàng bảo hành sau
                        này. Vì khi quý khách hàng bảo hành CPU, nếu trên phần mềm T&T Computer không có serial, T&T
                        Computer có quyền từ chối bảo hành, kể cả khi có tem T&T Computer ở CPU đó.</p>
                    <p>8. Quý khách hàng lưu trữ phiếu xuất kho bán hàng để tiện bảo hành, hoặc đổi trả trong 07 ngày. Quý
                        khách hàng có thể trưng bản chụp hình phiếu bán hàng, để tiện cho T&T Computer tra cứu phần mềm.
                    </p>
                    <p>9. Với hàng cũ, khi đến bảo hành, quý khách hàng nên mang đầy đủ phụ kiện giống lúc mua, để trong
                        trương hợp hết hàng đổi, T&T Computer sẽ hoàn tiền lại quý khách. Tránh tình trạng phải trừ tiền phụ
                        kiện. VD: không có chắn lưng main trừ 30.000 đ / cái.</p>
                    <p></p>
                    <p></p>
                    <p></p>
                    <p></p>
                </div><br>
                <h3><strong><u>III. Điều kiện không bảo hành:</u></strong></h3>
                <div class="content-baohanh">
                    <p>1. Sản phẩm hết thời hạn bảo hành. Thiết bị không do T&T Computer bán ra.</p>
                    <p>2. Tem bảo hành, mã vạch, chỉ số dung lượng, số serial number bị rách, mờ có dấu hiệu cạo sửa hay
                        đánh
                        tráo.</p>
                    <p>3. Thiết bị do va chạm hoặc đã bị rơi rớt, bể mẻ, móp méo, biến dạng, trầy xước, rỉ xét, xì hoặc phù
                        tụ
                        …</p>
                    <p>4. Thiết bị có dấu hiệu cháy nổ, chuột bọ, côn trùng xâm nhập hoặc đặt trong môi trường ẩm ướt.</p>
                    <p>5. Hư hỏng do thiên tai hoả hoạn, sử dụng nguồn điện không ổn định hoặc do vận chuyển không đúng quy
                        cách.</p>
                    <p>6. Không bảo hành các lỗi do phần mềm gây ra, các phụ kiện tiêu hao đi kèm như: quạt, mực, dây
                        cáp&#8230; riêng apdater của các thiết bị Modem, Access Point, LCD&#8230; vẫn bảo hành 1 tháng</li>
                        <li>T&T Computer không chịu trách nhiệm với dữ liệu trong ổ cứng, SSD hư &#8230;
                    </p>
                </div><br>
                <h3><strong><u>IV. Thời gian giữ bảo hành:</u></strong></h3>
                <div class="content-baohanh">
                    <p>1. Nếu hàng thuộc diện bảo hành 1 đổi 1 của T&T Computer: khách HCM trong 02 giờ làm việc trừ trường
                        hợp hết hàng; khách tỉnh trong 7 ngày làm việc (không tính chủ nhật) tính từ lúc nhận hàng tại công
                        ty hoặc căn cứ theo ngày T&T Computer nhận hàng công bố trên Website.</p>
                    <p>2. Nếu phải mang đi bảo hành chính hãng: Trong vòng 10 ngày làm việc (không tính thứ 7 và chủ nhật)
                        tính từ lúc nhận hàng.</p>
                    <p>3. Thời gian bảo hành có thể sớm hơn hoặc chậm hơn tùy trường hợp. Khi quá thời hạn bên trên, chúng
                        tôi
                        sẽ thông báo lý do chính đáng đến khách hàng. Thời gian tối đa cho một trường hợp bảo hành game là
                        30 ngày và coin là 45 ngày. Với vài trường hợp không đủ điều kiện bảo hành, T&T Computer nhận thấy
                        có thể hãng hỗ trợ, T&T Computer vẫn tạm nhận đi bảo hành hãng, nhưng thời gian trả hàng phụ thuộc
                        vào hãng (thường 2-6 tháng vì đi nước ngoài).</p>
                    <p></p>
                </div><br>
                <p><em><strong><span>Quý khách lưu ý</span> </strong></em>: Xin quý khách giữ biên nhận bảo hành cẩn thận để
                    mang biên nhận đến nhận hàng bảo hành xong. Nếu mất biên nhận QUÝ KHÁCH VUI LÒNG ĐỢI TRONG VÒNG 30 NGÀY,
                    SAU ĐÓ CUNG CẤP GIẤY TỜ TÙY THÂN, HOẶC GIẤY GIỚI THIỆU NẾU LÀ CÔNG TY (KHÔNG GIẢI QUYẾT CÁC TRƯỜNG HỢP
                    NGOẠI LỆ). NẾU QUÁ 40 NGÀY, T&T Computer SẼ TỪ CHỐI XỬ LÝ.</p>
                <h3><strong><u>V. Các chế độ bảo hành đặc biệt:</u></strong></h3>
                <div class="content-baohanh">
                    <p>1. Tất cả các sản phẩm bán ra có chế độ bảo hành 1 đổi 1 đều được T&T Computer ghi trên phiếu xuất
                        kho
                        bán hàng, và đồng thời công bố trên web <a href="{{ route('/') }}">ViTinhTT.tk</a></p>
                    <p>2. T&T Computer thực hiện chính sách bảo hành và đổi trả sản phẩm theo quy định của hãng và nhà phân
                        phối.</p>
                    <p>3. SSD bảo hành theo 2 điều kiện là 3 năm và tổng dung lượng đọc ghi tối đa của ổ cứng (TBW) không
                        vượt
                        quá niêm yết của nhà sản xuất cho Model đó.</p>
                </div><br><br><br>
                <p>Mọi thắc mắc, khiếu nại về thái độ phục vụ của nhân viên. Quý khách vui lòng liên hệ:<br />
                    &#8211; SDT: <strong><em><span>090.xxx.xnxx (Mr. Tòn) &#8211; CSKH</span></em></strong><br />
                    &#8211; Email: <em><span><strong>dh51805788@student.stu.edu.vn</strong></span></em></p>
                <p>Quý khách có thể gửi phản ảnh vào Email để T&T Computer phục vụ quý khách tốt hơn.</p>
                <p>Chân thành cám ơn quý khách đã tin tưởng và ủng hộ T&T Computer&#8211; Rất hân hạnh và sẵn sàng phục vụ
                    quý khách.</p>
            </div>
        </div>
    </div>
@endsection
@section('js')
    {{-- thêm js --}}
@endsection
