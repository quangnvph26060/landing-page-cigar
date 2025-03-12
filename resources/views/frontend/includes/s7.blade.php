<div id="section-7">
    <div class="s7-title">
        <h1>{{ $s6->title }}</h1>
    </div>
    <div class="s7-des">
        {!! $s6->content !!}
    </div>

    <div class="s7-comments">
        <div class="s7-header d-flex border-bottom mt-3">
            <p class="m-0">{{ $s6->count_comments }} Bình luận</p>
        </div>

        <div class="s7-body">


            @foreach ($s6->comments ?? [] as $c)
                <div class="d-flex align-items-start rounded text-start mt-3">
                    <!-- Ảnh đại diện -->
                    <img src="{{ asset('frontend/assets/image/istockphoto-1337144146-612x612.jpg') }}"
                        class="rounded-circle me-2" alt="User Avatar" width="60" height="60" />

                    <!-- Nội dung bình luận -->
                    <div>
                        <p class="mb-0 fw-bold text-danger">{{ $c['name'] }}</p>
                        <p class="mb-0">
                            {{ $c['content'] }}
                        </p>

                        <!-- Hành động -->
                        <div class="d-flex align-items-center">
                            <a href="#" class="text-primary text-decoration-none me-1">Thích</a>-
                            <a href="#" class="text-primary text-decoration-none ms-1 me-3">
                                Phản hồi</a>

                            <!-- Nút like -->
                            <div class="d-flex align-items-center">
                                <i class="fas fa-thumbs-up text-primary me-3"></i>
                                <span>
                                    {{ \Carbon\Carbon::now()->subDays(rand(1, 30))->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach


        </div>
    </div>
</div>
