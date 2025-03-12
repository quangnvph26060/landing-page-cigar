@extends('backend.layouts.master')


@section('content')
    @include('backend.layouts.partials.breadcrumb', ['page' => 'Cấu Hình Chung'])

    <form action="{{ route('admin.section.config.post', 8) }}" method="post" id="myForm">
        <div class="row">
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group mb-3 col-lg-12">
                                <label for="title" class="form-label">Tiêu đề</label>
                                <input type="text" name="title" value="{{ $config->title }}" class="form-control">
                            </div>

                            <div class="form-group mb-3 col-lg-12">
                                <label for="description" class="form-label">Nội dung</label>
                                <input type="text" name="description" value="{{ $config->description }}" class="form-control">
                            </div>

                            <div class="form-group mb-3 col-lg-6">
                                <label for="hotline" class="form-label">Hotline</label>
                                <input type="text" name="hotline" value="{{ $config->hotline }}" class="form-control">
                            </div>

                            <div class="form-group mb-3 col-lg-6">
                                <label for="address" class="form-label">Địa chỉ</label>
                                <input type="text" name="address" value="{{ $config->address }}" class="form-control">
                            </div>

                            <div class="form-group mb-3 col-lg-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" name="email" value="{{ $config->email }}" class="form-control">
                            </div>

                            <div class="form-group mb-3 col-lg-6">
                                <label for="website" class="form-label">Website</label>
                                <input type="text" name="website" value="{{ $config->website }}" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title fw-bold">SEO</h5>
                    </div>

                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="seo_title" class="form-label">Tiêu đề seo</label>
                            <input type="text" name="seo_title" class="form-control" value="{{ $config->seo_title }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="seo_description" class="form-label">Mô tả seo</label>
                            <textarea rows="4" name="seo_description" class="form-control">{{ $config->seo_description }}</textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="seo_keywords" class="form-label">Từ khóa seo</label>
                            <input type="text" name="seo_keywords" id="seo_keywords" class="form-control"
                                value="{{ $config->seo_keywords }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <label for="logo" class="form-label">Logo</label>
                        <img class="img-fluid img-thumbnail w-100" id="show_logo" style="cursor: pointer"
                            src="{{ showImage($config->logo) }}" alt="" onclick="document.getElementById('logo').click();">
                        <input type="file" name="logo" id="logo" class="form-control d-none" accept="image/*"
                            onchange="previewImage(event, 'show_logo')">
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <label for="icon" class="form-label">Icon</label>
                        <img class="img-fluid img-thumbnail w-100" id="show_icon" style="cursor: pointer"
                            src="{{ showImage($config->icon) }}" alt="" onclick="document.getElementById('icon').click();">
                        <input type="file" name="icon" id="icon" class="form-control d-none"
                            accept="image/*" onchange="previewImage(event, 'show_icon')">
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
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <script>
        $(document).ready(function() {
            submitForm('#myForm', function(response) {
                Toast.fire({
                    icon: "success",
                    title: response.message
                });
            })

            const input = document.querySelector('#seo_keywords');

            const tagify = new Tagify(input, {
                dropdown: {
                    maxItems: 10,
                    classname: "tags-look",
                    enabled: 0,
                    closeOnSelect: false
                }
            });

            tagify.on('add', () => {
                adjustTagifyHeight(tagify.DOM.scope);
            });
        });
    </script>
@endpush

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" />

    <style>
        .tagify {
            height: auto !important;
        }
    </style>
@endpush
