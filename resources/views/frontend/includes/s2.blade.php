<div id="section-2">
    <div class="s2-title">
        <h3>{{ $s2->title }}</h3>
    </div>

    <div class="s2-video video-css">
        <div class="video-wrapper p-relative" style="height: 100%">
            <video preload="auto"
                poster="https://statics.pancake.vn/web-media/c7/7a/86/c5/e3e302400fa3beb39b4d11bad4bcf5c9623888bdaa35a196c7fb0e84.jpeg"
                autoplay muted playsinline webkit-playsinline controls src="{{ showImage($s2->video_path) }}"></video>
        </div>
    </div>

    <div class="btn-buy-now">
        <a href="#form-contact">
            <button>BẤM MUA NGAY</button>
        </a>
    </div>
</div>
