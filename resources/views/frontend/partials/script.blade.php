<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
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

@stack('scripts')
