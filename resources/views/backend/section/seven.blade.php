@extends('backend.layouts.master')


@section('content')
    @include('backend.layouts.partials.breadcrumb', ['page' => 'Cấu Hình Section 7'])

    <form action="{{ route('admin.section.config.post', 7) }}" method="post" id="myForm">
        <div class="card">
            <div class="card-body">
                <div class="container-support">

                    @php $index = 0; @endphp
                    @forelse ($seven ?? [] as $item)
                        <div class="row support-item {{ !$loop->first ? 'mt-2' : '' }}"
                            data-index="{{ $item['id'] ?? 'new_' . $index }}">
                            <div class="col-lg-3">
                                <input type="text" value="{{ $item['icon'] }}" class="form-control icon-picker"
                                    name="supports[{{ $item['id'] ?? 'new_' . $index }}][icon]" placeholder="Chọn icon" />
                            </div>
                            <div class="col-lg-4">
                                <input type="text" value="{{ $item['title'] }}" class="form-control"
                                    name="supports[{{ $item['id'] ?? 'new_' . $index }}][title]" placeholder="Tiêu đề" />
                            </div>
                            <div class="col-lg-4">
                                <input type="text" value="{{ $item['content'] }}" class="form-control"
                                    name="supports[{{ $item['id'] ?? 'new_' . $index }}][content]" placeholder="Nội dung" />
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
                        @php $index++; @endphp
                    @empty
                        <div class="row support-item" data-index="new_0">
                            <div class="col-lg-3">
                                <input type="text" class="form-control icon-picker" name="supports[new_0][icon]"
                                    placeholder="Chọn icon" />
                            </div>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="supports[new_0][title]"
                                    placeholder="Tiêu đề" />
                            </div>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" name="supports[new_0][content]"
                                    placeholder="Nội dung" />
                            </div>
                            <div class="col-lg-1 p-0">
                                <button type="button" class="btn btn-primary add-btn"><i
                                        class="fas fa-plus-square"></i></button>
                            </div>
                        </div>
                    @endforelse


                </div>
            </div>
            <div class="card-footer d-flex justify-content-end">
                @include('backend.includes.button-submit')
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fontawesome-iconpicker/3.2.0/js/fontawesome-iconpicker.min.js">
    </script>
    <script src="{{ asset('backend/assets/js/image-uploader.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(".icon-picker").iconpicker();

            submitForm('#myForm', function(response) {
                Toast.fire({
                    icon: "success",
                    title: response.message
                });
            });

            let container = $(".container-support");
            let index = 0;

            // Thêm dòng mới
            $(document).on("click", ".add-btn", function() {
                index++;
                let newRow = `
            <div class="row support-item mt-2" data-index="new_${index}">
                <div class="col-lg-3">
                    <input type="text" class="form-control icon-picker" name="supports[new_${index}][icon]" placeholder="Chọn icon" />
                </div>
                <div class="col-lg-4">
                    <input type="text" class="form-control" name="supports[new_${index}][title]" placeholder="Tiêu đề" />
                </div>
                <div class="col-lg-4">
                    <input type="text" class="form-control" name="supports[new_${index}][content]" placeholder="Nội dung" />
                </div>
                <div class="col-lg-1 p-0">
                    <button type="button" class="btn btn-danger remove-btn"><i class="fas fa-minus-square"></i></button>
                </div>
            </div>
        `;
                container.append(newRow);

                // Khởi tạo icon picker cho dòng mới
                container.find(".icon-picker").iconpicker();
            });

            // Xóa dòng
            $(document).on("click", ".remove-btn", function() {
                $(this).closest(".support-item").remove();
            });
        });
    </script>
@endpush

@push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fontawesome-iconpicker/3.2.0/css/fontawesome-iconpicker.min.css"
        rel="stylesheet" />

    <style>
        .iconpicker-popover.popover {
            z-index: 1000;
            width: 333px !important;
        }

        .fade:not(.show) {
            opacity: 1 !important;
        }
    </style>
@endpush
