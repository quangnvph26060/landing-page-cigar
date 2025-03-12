<div id="section-5" class="px-1">
    <div class="line-css">
        <div class="line-container"></div>
    </div>

    @foreach ($s4->options ?? [] as $o)
        <div class="s5-btn-option-price mt-3">
            <div class="s5-title">{{ $o['title'] }}</div>
            <div class="s5-content">{!! $o['content'] !!}</div>
        </div>
        <div class="line-css mt-2">
            <div class="line-container"></div>
        </div>
    @endforeach

    @foreach ($s5->albums ?? [] as $a)
        <div class="s5-image w-100 mt-3">
            <div class="s5-box">
                <div class="s5-title-image">{{ $a['title'] }}</div>
                <img src="{{ showImage($a['image']) }}" alt="" />
            </div>
        </div>
    @endforeach

    <div class="s5-des" id="form-contact">
        {{ $s5->title }}
    </div>
</div>
