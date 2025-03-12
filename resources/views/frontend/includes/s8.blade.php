<div id="section-8">
    <div class="row">

        @foreach ($s7 as $i)
            <div class="col-12 d-flex align-items-center mb-4">
                <i class="{{ $i['icon'] }} fa-3x me-3"></i>
                <div class="text-start">
                    <h5 class="fw-bold mb-0">{{ $i['title'] }}</h5>
                    <p class="mb-0">{{ $i['content'] }}</p>
                </div>
            </div>
        @endforeach

    </div>
</div>
