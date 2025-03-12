<div class="section-1">
    <span class="text-block-css">{{ $s1->price }}</span>
    <a href="#form-contact" class="btn btn-danger btn-buy" id="animateBtn">BẤM MUA NGAY</a>
</div>
<div class="banner position-relative">
    <img class="position-absolute z-3" src="{{ showImage($config->logo) }}" alt="" />
    <img src="{{ showImage($s1->bg_image) }}" alt="" />
    <div class="banner-text position-absolute top-0 bottom-0 end-0 start-0 d-flex flex-column justify-content-between">
        <div class="b-title">{{ $s1->title }}</div>
        <div class="b-description">
            {{ $s1->description }}
        </div>
        <div class="b-commit">{{ $s1->commit }}</div>
    </div>
</div>
