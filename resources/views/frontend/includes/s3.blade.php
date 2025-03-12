<div id="section-3">
    <div class="s3-background"
        style="
                background: url({{ showImage($s3->bg_image) }}) center center / cover
                    no-repeat;
            ">
    </div>
    <img style="width: 70px; height: auto" class="position-absolute z-3 logo" src="{{ showImage($config->logo) }}"
        alt="" />

    <div class="s3-rectangle">
        <img src="{{ asset('frontend/assets/image/pngtree-golden-premium-star-with-5-red-stars-on-photo-png-image_14411796-removebg-preview.png') }}"
            alt="" />
    </div>

    <div class="s3-count-order">{{ $s3->orders }}</div>
    <div class="s3-count-commet">{{ $s3->reviews }}</div>

    @php
        $endDate = $s3->end_date->format('Y-m-d H:i:s');
    @endphp

    <div class="s3-date-time">
        <div class="countdown">
            <div class="time-unit">
                <div class="label">Ngày</div>
                <div class="value" id="days">00</div>
            </div>
            <div class="time-unit">
                <div class="label">Giờ</div>
                <div class="value" id="hours">00</div>
            </div>
            <div class="time-unit">
                <div class="label">Phút</div>
                <div class="value" id="minutes">00</div>
            </div>
            <div class="time-unit">
                <div class="label">Giây</div>
                <div class="value" id="seconds">00</div>
            </div>
        </div>
    </div>

    <script>
        var endDate = new Date("{{ $endDate }}").getTime();

        function updateCountdown() {
            var now = new Date().getTime();
            var timeDiff = endDate - now;

            if (timeDiff > 0) {
                var days = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
                var hours = Math.floor((timeDiff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((timeDiff % (1000 * 60)) / 1000);
            } else {
                var days = 0,
                    hours = 0,
                    minutes = 0,
                    seconds = 0;
            }

            document.getElementById("days").innerText = String(days).padStart(2, '0');
            document.getElementById("hours").innerText = String(hours).padStart(2, '0');
            document.getElementById("minutes").innerText = String(minutes).padStart(2, '0');
            document.getElementById("seconds").innerText = String(seconds).padStart(2, '0');
        }


        setInterval(updateCountdown, 1000);
        updateCountdown();
    </script>


    <div class="s3-btn-buy-now">
        <a href="#form-contact">
            <button id="animateBtnBuyNow" class="animate__animated animate__pulse animate__infinite">
                BẤM MUA NGAY
            </button>
        </a>

    </div>
    <div class="s3-info">
        @foreach ($s3->content ?? [] as $c)
            <p>💥 {!! preg_replace('/^(.*?):\s/', '<b>$1:</b> ', $c) !!}</p>
        @endforeach
    </div>
</div>
