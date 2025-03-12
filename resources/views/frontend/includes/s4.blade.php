<div id="section-4">
    <div class="s4-title">{{ $s4->title }}</div>

    <div class="s4-slider">
        <!-- Swiper chính (Ảnh lớn) -->
        <div class="swiper main-slider">
            <div class="swiper-wrapper">
                @foreach ($s4->album_slider ?? [] as $key => $asm)
                    <div class="swiper-slide">
                        <img src="{{ showImage($asm) }}" alt="Image {{ $key }}" />
                    </div>
                @endforeach
            </div>
            <!-- Nút điều hướng -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>

        <!-- Swiper phụ (Ảnh nhỏ) -->
        <div class="swiper thumbnail-slider">
            <div class="swiper-wrapper">

                @foreach ($s4->album_slider ?? [] as $k => $ast)
                    <div class="swiper-slide">
                        <img src="{{ showImage($ast) }}" alt="Thumb {{ $k }}" />
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
