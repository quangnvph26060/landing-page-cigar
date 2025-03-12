@extends('backend.layouts.master')


@section('content')
    @include('backend.layouts.partials.breadcrumb', ['page' => 'Cấu Hình Section 6'])

    <form action="{{ route('admin.section.config.post', 6) }}" method="post" id="myForm">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="form-group mb-3 col-lg-9">
                        <label for="title" class="form-label">Tiêu đề</label>
                        <input type="text" name="title" value="{{ $six->title }}" class="form-control">
                    </div>
                    <div class="form-group mb-3 col-lg-3">
                        <label for="count_comments" class="form-label">Lượt bình luận</label>
                        <input type="text" placeholder="ví dụ: 100" name="count_comments"
                            value="{{ $six->count_comments }}" class="form-control">
                    </div>
                    <div class="form-group mb-3 col-lg-12">
                        <label for="content" class="form-label">Nội dung</label> <code>Nếu muốn xuống dòng thêm ký tự
                            (&lt;br&gt;)</code>
                        <textarea type="text" name="content" class="form-control" rows="5">{{ $six->content }}</textarea>
                    </div>

                    <div id="container-comment">

                        @forelse ($six->comments ?? [] as $key => $item)
                            <div class="row comment-row {{ !$loop->first ? 'mt-2' : '' }}">
                                <div class="col-lg-4">
                                    <input type="text" name="comments[{{ $key }}][name]"
                                        value="{{ $item['name'] }}" class="form-control" placeholder="Tên người bình luận">
                                </div>
                                <div class="col-lg-7">
                                    <input type="text" name="comments[{{ $key }}][content]"
                                        value="{{ $item['content'] }}" class="form-control"
                                        placeholder="Nội dung bình luận">
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
                            <div class="row comment-row mt-2">
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="comments[0][name]"
                                        placeholder="Tên người bình luận">
                                </div>
                                <div class="col-lg-7">
                                    <input type="text" class="form-control" name="comments[0][content]"
                                        placeholder="Nội dung bình luận">
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

            let index = $('.row.comment-row').length; // Bắt đầu từ 1 vì index 0 đã có sẵn

            // Thêm mới khi nhấn "+"
            $(document).on("click", ".add-btn", function() {
                let newRow = `
                    <div class="row comment-row mt-2">
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="comments[${index}][name]" placeholder="Tên người bình luận">
                        </div>
                        <div class="col-lg-7">
                            <input type="text" class="form-control" name="comments[${index}][content]" placeholder="Nội dung bình luận">
                        </div>
                        <div class="col-lg-1 p-0">
                            <button type="button" class="btn btn-danger remove-btn"><i class="fas fa-minus-square"></i></button>
                        </div>
                    </div>
                `;

                $("#container-comment").append(newRow);
                index++; // Tăng index để đảm bảo key không trùng
            });

            // Xóa khi nhấn "-"
            $(document).on("click", ".remove-btn", function() {
                $(this).closest(".comment-row").remove();
                updateIndexes(); // Cập nhật lại key
            });

            // Cập nhật lại index sau khi xóa
            function updateIndexes() {
                $(".comment-row").each(function(i) {
                    $(this).find("input[name^='comments']").each(function() {
                        let fieldName = $(this).attr("name");
                        let newName = fieldName.replace(/\[\d+\]/,
                            `[${i}]`); // Thay số index cũ thành index mới
                        $(this).attr("name", newName);
                    });
                });
            }
        });
    </script>
@endpush

@push('styles')
@endpush
