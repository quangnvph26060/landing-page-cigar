<div id="section-6"
    style="
					background-image: url({{ asset('frontend/assets/image/2eb21992f56eed4bf7bc3fd526b386b5b3d7983cef22a3cfca3adead.jpeg') }});
				">
    <div class="s6-title">
        <h2 class="">ĐẶT HÀNG NGAY ĐỂ NHẬN ƯU ĐÃI</h2>
    </div>

    <form action="" method="post" id="myForm">
        @csrf
        <div class="d-flex justify-content-between align-content-center" style="margin-bottom: 10px">
            <div class="input-form">
                <input type="text" name="name" class="form-control" placeholder="Tên của bạn" />
            </div>
            <div class="input-form">
                <input type="text" name="phone" class="form-control" placeholder="Số điện thoại nhận hàng" />
            </div>
        </div>

        <div class="input-form" style="margin-bottom: 10px">
            <input type="text" name="address" class="form-control"
                placeholder="Địa chỉ  chi tiết để giao hàng đến tận tay bạn" />
        </div>
        <div class="row" style="margin-bottom: 10px; padding: 0 12px">
            <div class="select-form col-4 px-0 rounded-start">
                <select name="province_id" id="" class="form-select">
                    <option value="" selected disabled>Tỉnh/Thành phố</option>
                    @foreach ($provinces as $province_id => $name)
                        <option value="{{ $province_id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="select-form col-4 px-0">
                <select name="district_id" class="form-select">
                    <option value="" selected disabled>Quận/Huyện</option>
                </select>
            </div>
            <div class="select-form col-4 px-0 rounded-end">
                <select name="ward_id" class="form-select">
                    <option value="" selected disabled>Phường/Xã</option>
                </select>
            </div>

        </div>
        <div class="textarea-form" style="margin-bottom: 10px">
            <textarea name="message" id="" rows="2" class="form-control mt-2"
                placeholder="Bạn để lại lời nhắn tại đây nhân viên tư vấn sẽ gọi xác nhận ạ!"></textarea>
        </div>

        <div class="s6-btn-submit mt-2">
            <button>ĐẶT HÀNG</button>
        </div>
    </form>
</div>
