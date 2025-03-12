<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<!-- Thêm thư viện SweetAlert2 (nếu chưa có) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function startShake() {
        let btn = document.getElementById("animateBtn");

        // Thêm hiệu ứng
        btn.classList.add("animate__animated", "animate__shakeX");

        // Sau 1 giây thì xóa hiệu ứng
        setTimeout(() => {
            btn.classList.remove("animate__shakeX");
        }, 1000);
    }

    // Gọi hiệu ứng mỗi 2 giây
    setInterval(startShake, 2000);

    var thumbnailSlider = new Swiper(".thumbnail-slider", {
        spaceBetween: 10,
        slidesPerView: 4, // Hiển thị 4 ảnh phụ
        watchSlidesProgress: true,
        loop: true, // Cho phép chạy vòng tròn
        autoplay: {
            delay: 3000, // 3 giây tự động chuyển ảnh
            disableOnInteraction: false, // Tiếp tục chạy sau khi tương tác
        },
    });

    var mainSlider = new Swiper(".main-slider", {
        spaceBetween: 10,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        thumbs: {
            swiper: thumbnailSlider, // Điều khiển ảnh phụ bằng ảnh chính
        },
        loop: true, // Cho phép chạy vòng tròn
        autoplay: {
            delay: 3000, // 3 giây tự động chuyển ảnh
            disableOnInteraction: false, // Tiếp tục chạy sau khi tương tác
        },
    });

    // Khi click vào ảnh phụ => Chuyển ảnh chính (Nhưng kéo ảnh phụ không ảnh hưởng ảnh chính)
    thumbnailSlider.on("click", function(swiper) {
        const clickedIndex = swiper.clickedIndex;
        if (clickedIndex !== undefined) {
            mainSlider.slideToLoop(clickedIndex); // Dùng slideToLoop để tương thích với loop mode
        }
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        function fetchData(id, targetSelect, url) {
            if (id) {
                $.ajax({
                    url: url + '/' + id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        targetSelect.empty().append(
                            '<option value="" selected disabled>Chọn</option>');
                        $.each(data, function(key, value) {
                            targetSelect.append('<option value="' + value.id + '">' + value
                                .name + '</option>');
                        });
                    }
                });
            }
        }

        // Khi chọn tỉnh/thành phố
        $('select[name="province_id"]').change(function() {
            let province_id = $(this).val();
            fetchData(province_id, $('select[name="district_id"]'), '/get-districts');
            $('select[name="ward_id"]').empty().append(
                '<option value="" selected disabled>Chọn Phường/Xã</option>'); // Reset ward
        });

        // Khi chọn quận/huyện
        $('select[name="district_id"]').change(function() {
            let district_id = $(this).val();
            fetchData(district_id, $('select[name="ward_id"]'), '/get-wards');
        });

        $('#myForm').on('submit', function(e) {
            e.preventDefault();

            let form = $(this).serialize();

            $.ajax({
                url: 'submit-contact',
                data: form,
                method: 'POST',
                success: function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công!',
                        text: 'Đặt hàng thành công.',
                    });

                    $('#myForm')[0].reset();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {

                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: xhr.responseJSON.message,
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: xhr.responseJSON.message || 'Có lỗi xảy ra, vui lòng thử lại.',
                        });
                    }
                }
            });
        });


    });
</script>

@stack('scripts')
