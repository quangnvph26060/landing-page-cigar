@extends('backend.layouts.master')


@section('content')
    @include('backend.layouts.partials.breadcrumb', ['page' => 'Cấu Hình Section 4'])

    <form action="{{ route('admin.section.config.post', 4) }}" method="post" id="myForm">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="form-group mb-3 col-lg-12">
                        <label for="title" class="form-label">Tiêu đề</label>
                        <input type="text" name="title" value="{{ $four->title }}" class="form-control">
                    </div>

                    <div class="form-group mb-3 col-lg-12">
                        <label for="title" class="form-label">Ảnh Slider</label>
                        <div class="input-images pb-3"></div>
                    </div>

                    <div class="form-group mb-3 col-lg-12">
                        <label for="description" class="form-label">Option giá</label>

                        <div class="container-options">
                            @forelse ($four->options ?? [] as $key => $option)
                                <div class="row input-group {{ !$loop->first ? 'mt-2' : '' }}">
                                    <div class="col-lg-3">
                                        <input type="text" name="options[{{ $key }}][title]"
                                            class="form-control" value="{{ $option['title'] }}"
                                            placeholder="ví dụ: Mua 5 điếu: 100.000đ">
                                    </div>
                                    <div class="col-lg-8">
                                        <input value="{{ $option['content'] }}" type="text"
                                            name="options[{{ $key }}][content]" class="form-control"
                                            placeholder="Nội dung">
                                    </div>
                                    <div class="col-lg-1 p-0">
                                        @if ($loop->first)
                                            <button type="button" class="btn btn-primary add-btn"><i
                                                    class="fas fa-plus-square"></i></button>
                                        @else
                                            <button type="button" class="btn btn-danger remove-btn"><i
                                                    class="fas fa-minus-square"></i></button>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="row input-group">
                                    <div class="col-lg-3">
                                        <input type="text" name="options[0][title]" class="form-control" value=""
                                            placeholder="ví dụ: Mua 5 điếu: 100.000đ">
                                    </div>
                                    <div class="col-lg-8">
                                        <input value="" type="text" name="options[0][content]" class="form-control"
                                            placeholder="Nội dung">
                                    </div>
                                    <div class="col-lg-1 p-0">
                                        <button type="button" class="btn btn-primary add-btn"><i
                                                class="fas fa-plus-square"></i></button>
                                    </div>
                                </div>
                            @endforelse
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
    <script src="{{ asset('backend/assets/js/image-uploader.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            submitForm('#myForm', function(response) {
                Toast.fire({
                    icon: "success",
                    title: response.message
                });
            })

            const preloaded = @json($images);

            $('.input-images').imageUploader({
                preloaded: preloaded,
                imagesInputName: 'images',
                preloadedInputName: 'old',
                maxSize: 2 * 1024 * 1024,
                maxFiles: 15,
            });

            $(".container-options").on("click", ".add-btn", function() {
                let index = $(".container-options .input-group").length; // Đếm số nhóm input hiện có
                let newInput = `
                    <div class="row input-group mt-2">
                        <div class="col-lg-3">
                            <input value="" type="text" name="options[${index}][title]" class="form-control" placeholder="ví dụ: Mua 5 điếu: 100.000đ">
                        </div>
                        <div class="col-lg-8">
                            <input value="" type="text" name="options[${index}][content]" class="form-control" placeholder="Nội dung">
                        </div>
                        <div class="col-lg-1 p-0">
                            <button type="button" class="btn btn-danger remove-btn"><i class="fas fa-minus-square"></i></button>
                        </div>
                    </div>
                `;
                $(".container-options").append(newInput);
            });

            // Xóa input khi bấm nút "-"
            $(".container-options").on("click", ".remove-btn", function() {
                if ($(".input-group").length > 1) {
                    $(this).closest(".input-group").remove();
                    updateIndexes(); // Cập nhật lại index sau khi xóa
                }
            });

            // Cập nhật lại index sau khi xóa một phần tử
            function updateIndexes() {
                $(".container-options .input-group").each(function(index) {
                    $(this).find("input[name^='options']").each(function() {
                        let name = $(this).attr("name");
                        let newName = name.replace(/\[\d+\]/, `[${index}]`);
                        $(this).attr("name", newName);
                    });
                });
            }

        });
    </script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/image-uploader.min.css') }}">
@endpush
