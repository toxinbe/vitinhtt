<footer class="footer">
    <div class="container-fluid">
        <nav class="pull-left">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('/') }}">
                        Trang chủ
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('danhsachsp?loaisp=0') }}">
                        Laptop
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('timkiem?boloc=-2') }}">
                        Phụ kiện
                    </a>
                </li>
            </ul>
        </nav>
        <div class="copyright ml-auto">
            &copy;2022 Trương Ngọc Toàn & Nguyễn Hoàng Tiến
        </div>
    </div>
</footer>

<!--   Core JS Files   -->
<script src="{{ asset('js/backend/core/jquery.3.2.1.min.js') }}"></script>
<script src="{{ asset('js/backend/core/popper.min.js') }}"></script>
<script src="{{ asset('js/backend/core/bootstrap.min.js') }}"></script>

<!-- jQuery UI -->
<script src="{{ asset('js/backend/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
<script src="{{ asset('js/backend/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') }}"></script>

<!-- jQuery Scrollbar -->
<script src="{{ asset('js/backend/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>


<!-- Chart JS -->
<script src="{{ asset('js/backend/plugin/chart.js/chart.min.js') }}"></script>

<!-- jQuery Sparkline -->
<script src="{{ asset('js/backend/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

<!-- Chart Circle -->
<script src="{{ asset('js/backend/plugin/chart-circle/circles.min.js') }}"></script>

<!-- Datatables -->
<script src="{{ asset('js/backend/plugin/datatables/datatables.min.js') }}"></script>

<!-- Bootstrap Notify -->
<script src="{{ asset('js/backend/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

<!-- jQuery Vector Maps -->
<script src="{{ asset('js/backend/plugin/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('js/backend/plugin/jqvmap/maps/jquery.vmap.world.js') }}"></script>

<!-- Sweet Alert -->
<script src="{{ asset('js/backend/plugin/sweetalert/sweetalert.min.js') }}"></script>

<!-- Atlantis JS -->
<script src="{{ asset('js/backend/atlantis.min.js') }}"></script>

<!-- Atlantis DEMO methods, don't include it in your project! -->
{{-- <script src="{{ asset('js/backend/setting-demo.js') }}"></script> --}}
{{-- <script src="{{ asset('js/backend/setting-demo2.js') }}"></script> --}}
<script src="{{ asset('js/backend/demo.js') }}"></script>
@if ($errors->any())
    <script>
        $(document).ready(function() {
            //Notify
            $.notify({
                icon: 'flaticon-alarm-1',
                title: 'Thao tác thất bại',
                message: 'Dữ liệu nhập vào không hợp lệ. Vui lòng nhập lại',
            }, {
                type: 'danger',
                placement: {
                    from: "bottom",
                    align: "right"
                },
                time: 600,
            });
        });
    </script>
@endif
@if (session('thongbao'))
    <script>
        $(document).ready(function() {
            //Notify
            $.notify({
                icon: 'flaticon-alarm-1',
                title: "{{ session('tieudethongbao') }}",
                message: "{{ session('thongbao') }}",
            }, {
                type: "{{ session('loaithongbao') }}",
                placement: {
                    from: "bottom",
                    align: "right"
                },
                time: 600,
            });
        });
    </script>
@endif
