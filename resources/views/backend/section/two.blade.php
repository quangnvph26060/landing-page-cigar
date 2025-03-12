@extends('backend.layouts.master')


@section('content')
    @include('backend.layouts.partials.breadcrumb', ['page' => 'Cấu Hình Section 2'])

    <form action="{{ route('admin.section.config.post', 2) }}" method="post" id="myForm">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="form-group mb-3 col-lg-6">
                        <label for="title" class="form-label">Tiêu đề</label>
                        <input type="text" name="title" value="{{ $two->title }}" class="form-control">
                    </div>

                    <div class="form-group mb-3 col-lg-6">
                        <label for="video_path" class="form-label">Video</label>
                        <input type="file" name="video_path" id="videoInput" accept="video/*" class="form-control">

                        {{-- Video đã có sẵn trong database --}}
                        <div class="mt-3" id="videoPreviewContainer"
                            style="display: {{ !empty($two->video_path) ? 'block' : 'none' }}">
                            <video id="videoPreview" width="100%" controls>
                                <source src="{{ !empty($two->video_path) ? showImage($two->video_path) : '' }}"
                                    type="video/mp4">
                                Trình duyệt của bạn không hỗ trợ phát video.
                            </video>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end">
                @include('backend.includes.button-submit')
            </div>

        </div>
    </form>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            submitForm('#myForm', function(response) {
                Toast.fire({
                    icon: "success",
                    title: response.message
                });

            })
        });

        document.getElementById('videoInput').addEventListener('change', function(event) {
            let file = event.target.files[0]; // Lấy file video
            if (file) {
                let videoURL = URL.createObjectURL(file); // Tạo URL tạm thời
                let videoPreview = document.getElementById('videoPreview');
                let videoPreviewContainer = document.getElementById('videoPreviewContainer');

                videoPreview.src = videoURL; // Gán URL cho video
                videoPreviewContainer.style.display = 'block'; // Hiển thị video
                videoPreview.load(); // Load lại video
            }
        });
    </script>
@endpush
