@extends('backend.layouts.master')

@section('content')
    @include('backend.layouts.partials.breadcrumb', ['page' => 'Cấu Hình Section 1'])

    <form action="{{ route('admin.section.config.post', 1) }}" method="post" id="myForm">
        <div class="row">
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group mb-3 col-lg-6">
                                <label for="price" class="form-label">Giá</label>
                                <input type="text" name="price" value="{{ $one->price }}" class="form-control">
                            </div>
                            <div class="form-group mb-3 col-lg-6">
                                <label for="title" class="form-label">Tiêu đề</label>
                                <input type="text" name="title" value="{{ $one->title }}" class="form-control">
                            </div>
                            <div class="form-group mb-3 col-lg-12">
                                <label for="commit" class="form-label">Cam kết</label>
                                <input type="text" name="commit" value="{{ $one->commit }}" class="form-control">
                            </div>
                            <div class="form-group mb-3 col-lg-12">
                                <label for="description" class="form-label">Nội dung</label>
                                <textarea rows="2" name="description" class="form-control">{{ $one->description }}</textarea>
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
                            src="{{ showImage($one->bg_image) }}" alt=""
                            onclick="document.getElementById('bg_image').click();">
                        <input type="file" name="bg_image" id="bg_image" class="form-control d-none" accept="image/*"
                            onchange="previewImage(event, 'show_bg_image')">
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        @include('backend.includes.button-submit')
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
        });
    </script>
@endpush
