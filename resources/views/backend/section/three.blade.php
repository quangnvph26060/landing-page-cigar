@extends('backend.layouts.master')

@section('content')
    @include('backend.layouts.partials.breadcrumb', ['page' => 'Cấu Hình Section 3'])

    <form action="{{ route('admin.section.config.post', 3) }}" method="post" id="myForm">
        <div class="row">
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group mb-3 col-lg-6">
                                <label for="orders" class="form-label">Số lượng đơn hàng</label>
                                <input type="text" name="orders" value="{{ $three->orders }}" class="form-control">
                            </div>
                            <div class="form-group mb-3 col-lg-6">
                                <label for="reviews" class="form-label">Lượt đánh giá</label>
                                <input type="text" name="reviews" value="{{ $three->reviews }}" class="form-control">
                            </div>
                            <div class="form-group mb-3 col-lg-12">
                                <label for="end_date" class="form-label">Thời gian kết thúc</label>
                                <input type="date" name="end_date" value="{{ $three->end_date->format('Y-m-d') }}"
                                    class="form-control">
                            </div>
                            <div class="form-group mb-3 col-lg-12">
                                <label for="description" class="form-label">Nội dung</label>
                                <i class="far fa-question-circle" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Nhập tiêu đề với nội dung ngăn cách bằng dấu 2 chấm"></i>

                                <div class="container-content">
                                    @foreach ($three->content ?? [] as $item)
                                        <div class="row input-group {{ !$loop->first ? 'mt-2' : '' }}">
                                            <div class="col-lg-11">
                                                <input value="{{ $item }}" type="text" name="content[]"
                                                    class="form-control">
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
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <label for="bg_image" class="form-label">Ảnh nền</label>
                        <img class="img-fluid img-thumbnail w-100" id="show_bg_image" style="cursor: pointer"
                            src="{{ showImage($three->bg_image) }}" alt=""
                            onclick="document.getElementById('bg_image').click();">
                        <input type="file" name="bg_image" id="bg_image" class="form-control d-none" accept="image/*"
                            onchange="previewImage(event, 'show_bg_image')">
                    </div>
                    <div class="card-footer text-end">
                        <button class="btn btn-primary btn-sm">Lưu thay đổi</button>
                    </div>
                </div>
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


            $(".container-content").on("click", ".add-btn", function() {
                let newInput = `
                    <div class="row input-group mt-2">
                        <div class="col-lg-11">
                            <input type="text" name="content[]" class="form-control">
                        </div>
                        <div class="col-lg-1 p-0">
                            <button type="button" class="btn btn-danger remove-btn"><i class="fas fa-minus-square"></i></button>
                        </div>
                    </div>`;
                $(".container-content").append(newInput);
            });

            $(".container-content").on("click", ".remove-btn", function() {
                if ($(".input-group").length > 1) {
                    $(this).closest(".input-group").remove();
                }
            });
        });
    </script>
@endpush
