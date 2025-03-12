@extends('backend.layouts.master')


@section('content')
    @include('backend.layouts.partials.breadcrumb', ['page' => 'Cấu Hình Section 5'])

    <form action="{{ route('admin.section.config.post', 5) }}" method="post" id="myForm">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="form-group mb-3 col-lg-12">
                        <label for="title" class="form-label">Tiêu đề</label>
                        <input type="text" name="title" value="{{ $five->title }}" class="form-control">
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end">
                @include('backend.includes.button-submit')
            </div>
        </div>

        <div class="container-album" style="background-color: rgba(189, 189, 189, .5)">
            <div class="d-flex justify-content-end mb-2">
                <button type="button" class="btn btn-primary" id="addAlbum">Thêm album</button>
            </div>

            <div id="albumContainer" class="row px-3">
                @foreach ($five->albums ?? [] as $key => $item)
                    <div class="mb-3 col-lg-4 col-md-6 col-sm-12" id="imageBlock{{ $key }}">
                        <div class="card position-relative">
                            <img height="300" class="w-100 rounded-top" id="show_image{{ $key }}"
                                style="cursor: pointer" src="{{ showImage($item['image']) }}" alt=""
                                onclick="document.getElementById('image{{ $key }}').click();">
                            <input type="file" name="albums[{{ $key }}][image]" id="image{{ $key }}"
                                class="form-control d-none" accept="image/*"
                                onchange="previewImage(event, 'show_image{{ $key }}')">

                            <!-- Nút X -->
                            <button class="btn-close position-absolute" style="top: 10px; right: 10px;"
                                onclick="removeImageBlock({{ $key }})">
                                <i class="fa-solid fa-trash"></i>
                            </button>

                            <div class="card-body">
                                <input type="text" class="form-control" name="albums[{{ $key }}][title]"
                                    placeholder="Tiêu đề hình ảnh" value="{{ $item['title'] }}">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <input type="hidden" id="deletedImages" name="deletedImages" value="">
        </div>
    </form>
@endsection

@push('scripts')
    <script src="{{ asset('backend/assets/js/image-uploader.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            submitForm('#myForm', function(response) {
                Toast.fire({
                    icon: "success",
                    title: response.message
                });
            })
        });

        let index = $('.card.position-relative').length - 1;
        let deletedImages = [];

        function addImageBlock() {
            index++;

            const imageBlock = `
            <div class="mb-3 col-lg-4 col-md-6 col-sm-12" id="imageBlock${index}">
                <div class="card position-relative">
                    <img height="300" class="w-100 rounded-top" id="show_image${index}" style="cursor: pointer"
                        src="{{ showImage('') }}" alt="" onclick="document.getElementById('image${index}').click();">
                    <input type="file" name="albums[${index}][image]" id="image${index}" class="form-control d-none" accept="image/*"
                        onchange="previewImage(event, 'show_image${index}')">

                    <!-- Nút X -->
                    <button class="btn-close position-absolute" style="top: 10px; right: 10px;" onclick="removeImageBlock(${index})">
                        <i class="fa-solid fa-trash"></i>
                    </button>

                    <div class="card-body">
                        <input type="text" class="form-control" name="albums[${index}][title]" placeholder="Tiêu đề hình ảnh">
                    </div>
                </div>
            </div>
        `;

            $('#albumContainer').append(imageBlock); // Thêm khối hình ảnh vào container
        }

        function removeImageBlock(index) {

            deletedImages.push(index);

            // Cập nhật giá trị của input ẩn
            $('#deletedImages').val(deletedImages.join(','));

            // Xóa khối hình ảnh
            $(`#imageBlock${index}`).remove();
        }

        $(document).ready(function() {
            $('#addAlbum').click(addImageBlock); // Gắn sự kiện click cho nút "Thêm album"
        });
    </script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/image-uploader.min.css') }}">

    <style>
        .btn-close {
            background: red;
            /* Màu nền cho nút X */
            border: none;
            color: white;
            /* Màu chữ cho nút X */
            width: 30px;
            height: 30px;
            border-radius: 50%;
            /* Để tạo hình tròn cho nút */
            font-size: 16px;
            /* Kích thước chữ */
        }
    </style>
@endpush
