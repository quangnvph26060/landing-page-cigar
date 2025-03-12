@extends('backend.layouts.master')

@section('content')
    @include('backend.layouts.partials.breadcrumb', ['page' => 'Danh Sách Yêu Cầu'])

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h5 class="card-title fw-bold mb-0">Danh Sách Yêu Cầu</h5>

            <form action="{{ route('admin.contact.changeEmail') }}" method="post" class="d-flex gap-2" id="myForm">
                <input name="email" value="{{ env('ADMIN_EMAIL') }}" type="text" placeholder="Email nhận thông báo"
                    class="form-control w-auto" style="width: 250px !important;">
                <button class="btn btn-primary">Thay đổi</button>
            </form>
        </div>

        <div class="card-body">
            <table id="myTable" class="display">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ</th>
                        <th>Ngày tạo</th>
                        {{-- <th>Hành động</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contacts as $contact)
                        <tr>
                            <td>{{ $contact->id }}</td>
                            <td>{{ $contact->name }}</td>
                            <td>{{ $contact->phone }}</td>
                            <td>{{ $contact->address . ', ' . $contact->ward->name . ', ' . $contact->district->name . ', ' . $contact->province->name }}
                            </td>
                            <td>{{ $contact->created_at->format('d/m/Y H:i') }}</td>
                            {{-- <td>
                                <button class="btn btn-danger btn-sm">Xóa</button>
                            </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection


@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endpush

@push('scripts')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                "paging": true, // Bật phân trang
                "searching": true, // Bật ô tìm kiếm
                "ordering": true, // Cho phép sắp xếp cột
                "info": true, // Hiển thị tổng số bản ghi
                "language": {
                    "lengthMenu": "Hiển thị _MENU_ bản ghi",
                    "zeroRecords": "Không tìm thấy dữ liệu",
                    "info": "Hiển thị _START_ đến _END_ của _TOTAL_ bản ghi",
                    "search": "🔍 Tìm kiếm:",
                    "paginate": {
                        "first": "Đầu",
                        "last": "Cuối",
                        "next": "▶",
                        "previous": "◀"
                    }
                },
                "columnDefs": [{
                        "orderable": false,
                        "targets": [4]
                    }, // Cột thứ 5 (index 4) không sắp xếp
                    {
                        "searchable": false,
                        "targets": [4]
                    } // Cột thứ 5 không tìm kiếm
                ]
            });


            submitForm('#myForm', function(response) {
                Toast.fire({
                    icon: "success",
                    title: response.message
                });

            })
        });
    </script>
@endpush
