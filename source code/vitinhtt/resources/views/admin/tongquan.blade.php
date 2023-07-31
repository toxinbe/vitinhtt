@extends('admin.layouts.client')
@section('title')
    Tổng quan
@endsection
@section('head')
    {{-- thêm css --}}
    <style>
        .avatar-online::before {
            background-color: #EB3E32 !important;
            top: 0 !important;
        }

        .noidung-chuadoc {
            font-weight: 700 !important;
        }

        .tieude-chuadoc {
            font-weight: 900 !important;
        }

        .bg-daxem {
            background-color: #aaa !important;
        }
    </style>
@endsection
@section('content')
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="text-white pb-2 fw-bold">Tổng Quan</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-inner mt--5">
        <div class="row mt--2">
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-warning card-round">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="fas fa-laptop"></i>
                                </div>
                            </div>
                            <div class="col-7 col-stats">
                                <div class="numbers">
                                    <p class="card-category">Laptop</p>
                                    <h4 class="card-title">{{ !empty($soLuongLaptop) ? $soLuongLaptop : '0' }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-danger card-round">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="fas fa-keyboard"></i>
                                </div>
                            </div>
                            <div class="col-7 col-stats">
                                <div class="numbers">
                                    <p class="card-category">Phụ Kiện</p>
                                    <h4 class="card-title">{{ !empty($soLuongPhuKien) ? $soLuongPhuKien : '0' }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-success card-round">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                </div>
                            </div>
                            <div class="col-7 col-stats">
                                <div class="numbers">
                                    <p class="card-category">Đơn Hàng</p>
                                    <h4 class="card-title">{{ !empty($soLuongDonHang) ? $soLuongDonHang : '0' }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-secondary card-round">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="fas fa-user"></i>
                                </div>
                            </div>
                            <div class="col-7 col-stats">
                                <div class="numbers">
                                    <p class="card-category">Người Dùng</p>
                                    <h4 class="card-title">{{ !empty($soLuongNguoiDung) ? $soLuongNguoiDung : '0' }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            {{-- <div class="col-md-4">
                <div class="card">
                    <div class="card-body pb-0">
                        <div class="h1 fw-bold float-right text-success">+7%</div>
                        <h2 class="mb-2">213</h2>
                        <p class="text-muted">Đơn đặt hàng hôm nay</p>
                        <div class="pull-in sparkline-fix">
                            <div id="lineChart"></div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body pb-0">
                        <div class="h1 fw-bold float-right text-danger">-3%</div>
                        <h2 class="mb-2">128</h2>
                        <p class="text-muted">Người dùng đăng ký hôm nay</p>
                        <div class="pull-in sparkline-fix">
                            <div id="lineChart1"></div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
        <div class="row" id="loiphanhoi">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-head-row" style="height:2.65rem">
                            <div class="card-title">Doanh thu tuần này</div>
                        </div>
                    </div>
                    <div class="card-body" style="height: 21.25rem;">
                        <div class="chart-container">
                            <canvas id="barChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-head-row" style="height:2.65rem">
                            <div class="card-title">Lời nhắn liên hệ</div>
                            <div class="card-tools">
                                <ul class="nav nav-pills nav-primary nav-pills-no-bd nav-sm">
                                    <li class="nav-item submenu">
                                        <a class="nav-link {{ count($danhSachLoiPhanHoiChuaDoc) > 0 ? 'active show' : '' }}"
                                            href="{{ url('tongquan?thaotac=doitrangthaitatca') }}"><i
                                                class="fa fa-check"></i>&nbsp;&nbsp;&nbsp;Đã đọc tất cả</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="height: 21.25rem;overflow: auto">
                        @if (!empty($danhSachLoiPhanHoi))
                            @foreach ($danhSachLoiPhanHoi as $loiPhanHoi)
                                {!! $loiPhanHoi->trangthai == 0
                                    ? '<a href="' .
                                        url('tongquan?thaotac=doitrangthai&maloiphanhoi=' . $loiPhanHoi->maloiphanhoi) .
                                        '" class="donglienhe" style="color: #4d585f; background-color:#fff!important">'
                                    : '' !!}
                                <div class="d-flex">
                                    @if ($loiPhanHoi->trangthai == 0)
                                        <div class="avatar avatar-online">
                                            <span class="avatar-title rounded-circle border border-white bg-primary"><i
                                                    class="fas fa-envelope"></i></span>
                                        </div>
                                        <div class="flex-1 candeu ml-3 pt-1 pr-3">
                                            <h6 class="text-uppercase fw-bold mb-1 tieude-chuadoc">
                                                {{ $loiPhanHoi->hoten }} - {{ $loiPhanHoi->sodienthoai }}
                                            </h6>
                                            <span class="text-muted noidung-chuadoc">{{ $loiPhanHoi->noidung }}</span>
                                        </div>
                                    @else
                                        <div class="avatar">
                                            <span class="avatar-title rounded-circle border border-white bg-daxem"><i
                                                    class="fas fa-envelope"></i></span>
                                        </div>
                                        <div class="flex-1 candeu ml-3 pt-1 pr-3">
                                            <h6 class="text-uppercase fw-bold mb-1">{{ $loiPhanHoi->hoten }} -
                                                {{ $loiPhanHoi->sodienthoai }}
                                            </h6>
                                            <span class="text-muted">{{ $loiPhanHoi->noidung }}</span>
                                        </div>
                                    @endif
                                    <div class="float-right pt-1">
                                        <small class="text-muted">Lúc
                                            {{ date('H:i d/m/Y', strtotime($loiPhanHoi->ngaytao)) }}</small>
                                        {!! $loiPhanHoi->trangthai == 1
                                            ? '<small class="text-muted cangiua"><a class="text-muted viethoachudau" href="' .
                                                url('tongquan?thaotac=doitrangthai&maloiphanhoi=' . $loiPhanHoi->maloiphanhoi) .
                                                '" style="text-transform: none !important;display:block">Đánh dấu chưa đọc</a></small>'
                                            : '' !!}
                                    </div>
                                </div>
                                <div class="separator-dashed"></div>
                                {!! $loiPhanHoi->trangthai == 0 ? '</a>' : '' !!}
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    {{-- thêm js --}}
    @if (!empty(session('hoTenNhanVien')))
        <script>
            //Notify
            $.notify({
                icon: 'flaticon-alarm-1',
                title: 'Vi tính T&T',
                message: "Xin chào {{ session('hoTenNhanVien') }}",
            }, {
                type: 'info',
                placement: {
                    from: "bottom",
                    align: "right"
                },
                time: 600,
            });
        </script>
    @endif
    <script>
        var barChart = document.getElementById('barChart').getContext('2d');
        var doanhThuTuanNay = {!! json_encode($doanhThuTuanNay) !!};
        var myBarChart = new Chart(barChart, {
            type: 'bar',
            data: {
                labels: ["Thứ 2", "Thứ 3", "Thứ 4", "Thứ 5", "Thứ 6", "Thứ 7", "Chủ Nhật"],
                datasets: [{
                    label: "Doanh thu",
                    backgroundColor: 'rgb(23, 125, 255)',
                    borderColor: 'rgb(23, 125, 255)',
                    data: [doanhThuTuanNay[0].doanhthu, doanhThuTuanNay[1].doanhthu, doanhThuTuanNay[2]
                        .doanhthu, doanhThuTuanNay[3].doanhthu,
                        doanhThuTuanNay[4].doanhthu, doanhThuTuanNay[5].doanhthu, doanhThuTuanNay[6]
                        .doanhthu
                    ],
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            callback: function(label, index, labels) {
                                if (label < 1000000000000 && label >= 1000000000) return label /
                                    1000000000 + ' tỷ';
                                if (label < 1000000000 && label >= 1000000) return label / 1000000 +
                                    ' triệu';
                                if (label < 1000000 && label >= 1000) return label / 1000 + ' ngìn';
                                if (label <= 1 && label > 0) return label * 10;
                                return label;
                            }
                        }
                    }]
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem) {
                            var doanhThu = new Intl.NumberFormat('vi-VN', {
                                style: 'currency',
                                currency: 'VND'
                            }).format(Number(tooltipItem.yLabel));
                            return " " + doanhThu;
                        }
                    }
                },
            }
        });
    </script>
@endsection
