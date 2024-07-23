<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Booking Spa</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="{{ asset('css/booking.css') }}" rel="stylesheet">
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css"
        integrity="sha512-dPXYcDub/aeb08c63jRq/k6GaKccl256JQy/AnOq7CAnEZ9FzSL9wSbcZkMp4R26vBsMLFYH4kQ67/bbV8XaCQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <nav class="navbar-expand-lg navbar-light bg-light fixed-top py-0">
        <div class="container-fluid">
            <div>
                <h4 class="font-weight-bold mb-0">Chi nhánh trung tâm</h4>
                <p>Liên hệ:</p>
            </div>
        </div>
        <div class="booking-header">
            <h3 class="text-center booking-title">Đặt Lịch Hẹn</h3>
            <h3 class="text-center confirm-title d-none">Xác nhận đặt lịch</h3>
            <button type="button" class="btn-reset-form" id="reset-form">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    </nav>
    <div class="container-fluid custom-bg">
        <div class="row justify-content-center">
            <div class="bg-light p-0 booking-container">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="booking-body">
                    <form class="needs-validation" action="{{ route('submit.booking') }}" method="POST" novalidate>
                        @csrf
                        <div id="booking">
                            <div class="mb-3">
                                <label for="locationSpa" class="form-label fw-bold text-color-primary">Chi nhánh</label>
                                <input type="text" id="locationSpa" class="form-control" name="location" readonly
                                    value="Sol Beauty Clinic, Quận 7, Hồ Chí Minh" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold text-color-primary">Dịch vụ</label>
                                <div id="selectedServices"></div>
                                <button type="button" id="showServiceBtnAdd" class="form-select" data-bs-toggle="modal"
                                    data-bs-target="#serviceModal">
                                    <span>Chọn dịch vụ</span>
                                </button>
                            </div>
                            <div id="select-datetime" class="mb-3">
                                <label class="form-label fw-bold text-color-primary">Chọn ngày</label>
                                <input type="hidden" id="dateInput" class="form-control" name="date">
                                <input type="hidden" id="timeInput" class="form-control" name="time">
                                <div class="btn-group w-100" role="group" aria-label="Chọn ngày">
                                    <input type="radio" class="btn-check" name="btnradio" id="todayButton"
                                        autocomplete="off">
                                    <label class="btn btn-outline-secondary" for="todayButton">Hôm nay</label>

                                    <input type="radio" class="btn-check" name="btnradio" id="tomorrowButton"
                                        autocomplete="off">
                                    <label class="btn btn-outline-secondary tomorrowButton" for="tomorrowButton">Ngày
                                        mai</label>

                                    <input type="radio" class="btn-check" name="btnradio" id="chooseDateButton"
                                        autocomplete="off">
                                    <label
                                        class="btn btn-outline-secondary d-flex align-items-center justify-content-center"
                                        for="chooseDateButton" id="datepickerBtn">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-calendar me-1" viewBox="0 0 16 16">
                                            <path
                                                d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                                        </svg>
                                        <span id="selectedDateText">Ngày khác</span>
                                    </label>
                                </div>

                                <div id="timeRangeContainer" class="time-range-selector mt-3"></div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-end">
                                    <button type="button" class="btn booking-btn" id="booking-next-btn">Tiếp
                                        tục</button>
                                </div>
                            </div>
                        </div>
                        <div class="confirm-booking" id="confirmBooking">
                            <div class="mb-3 d-flex">
                                <div class="col-1 d-flex align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                                        <path
                                            d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A32 32 0 0 1 8 14.58a32 32 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10" />
                                        <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4m0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                    </svg>
                                </div>
                                <div class="col-11 d-flex align-items-center">
                                    <h5 class="m-0" id="confirmLocation"></h5>
                                </div>
                            </div>
                            <div class="mb-3 d-flex">
                                <div class="col-1 d-flex align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        fill="currentColor" class="bi bi-calendar3" viewBox="0 0 16 16">
                                        <path
                                            d="M14 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2M1 3.857C1 3.384 1.448 3 2 3h12c.552 0 1 .384 1 .857v10.286c0 .473-.448.857-1 .857H2c-.552 0-1-.384-1-.857z" />
                                        <path
                                            d="M6.5 7a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
                                    </svg>
                                </div>
                                <div class="col-11 d-flex align-items-center">
                                    <h5 class="m-0">
                                        <span class="date" id="confirmDate"></span>
                                        <span class="time time-box ms-4" id="confirmTime"></span>
                                    </h5>
                                </div>
                            </div>
                            <div class="mb-3 d-flex">
                                <div class="col-1 d-flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        fill="currentColor" class="bi bi-tag" viewBox="0 0 16 16">
                                        <path
                                            d="M6 4.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m-1 0a.5.5 0 1 0-1 0 .5.5 0 0 0 1 0" />
                                        <path
                                            d="M2 1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 1 6.586V2a1 1 0 0 1 1-1m0 5.586 7 7L13.586 9l-7-7H2z" />
                                    </svg>
                                </div>
                                <div class="col-11 d-flex align-items-center">
                                    <h5 class="m-0" id="confirmServiceList"></h5>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold text-color-primary">Thông tin liên hệ</label>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="name"
                                        placeholder="Họ và tên" name="name" required>
                                    <label for="name">Họ và tên</label>
                                    <div class="invalid-feedback">Vui lòng nhập họ và tên</div>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="phone" class="form-control" id="phone" name="phone"
                                        placeholder="Số điện thoại" required>
                                    <label for="phone">Số điện thoại</label>
                                    <div class="invalid-feedback">Vui lòng nhập số điện thoại</div>
                                </div>
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Ghi chú" id="note" name="note" id="" cols="30"
                                        rows="10"></textarea>
                                    <label for="note">Ghi chú</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-end">
                                    <button type="button" class="btn btn-secondary me-1" id="booking-back-btn">Quay
                                        lại</button>
                                    <button type="submit" class="btn booking-btn">Xác nhận</button>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Service -->
                        <div class="modal fade" id="serviceModal" tabindex="-1" aria-labelledby="serviceModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="serviceModalLabel">Chọn dịch vụ</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-header row">
                                        <div class="col-12">
                                            <label class="input-group mb-0">
                                                <input type="text" class="form-control" id="searchService"
                                                    placeholder="Tìm dịch vụ" autocomplete="off">
                                            </label>
                                        </div>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row mt-2">
                                            <div class="col-12">
                                                <div class="container-fluid">
                                                    <div id="serviceList">
                                                        <div class="eyelash">
                                                            <div class="form-label">
                                                                <label><span>[A] Eyelash</span></label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="eyelash1" type="checkbox" name="eyelash[]"
                                                                    data-category="eyelash" value="Nối Mi Thiết Kế">
                                                                <label class="form-check-label label-container"
                                                                    for="eyelash1">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/eyelash.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Nối Mi Thiết Kế</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="eyelash2" type="checkbox" name="eyelash[]"
                                                                    data-category="eyelash" value="Nối Mi Classic">
                                                                <label class="form-check-label label-container"
                                                                    for="eyelash2">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/eyelash.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Nối Mi Classic</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="eyelash3" type="checkbox" name="eyelash[]"
                                                                    data-category="eyelash" value="Nối Mi Volume">
                                                                <label class="form-check-label label-container"
                                                                    for="eyelash3">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/eyelash.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Nối Mi Volume</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="eyelash4" type="checkbox" name="eyelash[]"
                                                                    data-category="eyelash" value="Nối Mi Dưới">
                                                                <label class="form-check-label label-container"
                                                                    for="eyelash4">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/eyelash.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Nối Mi Dưới</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="eyelash5" type="checkbox" name="eyelash[]"
                                                                    data-category="eyelash" value="Tháo Mi">
                                                                <label class="form-check-label label-container"
                                                                    for="eyelash5">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/eyelash.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Tháo Mi</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="eyelash6" type="checkbox" name="eyelash[]"
                                                                    data-category="eyelash" value="Uốn Mi Collagen">
                                                                <label class="form-check-label label-container"
                                                                    for="eyelash6">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/eyelash.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Uốn Mi Collagen</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="eyelash7" type="checkbox" name="eyelash[]"
                                                                    data-category="eyelash" value="Đường Mi">
                                                                <label class="form-check-label label-container"
                                                                    for="eyelash7">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/eyelash.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Đường Mi</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="eyelash8" type="checkbox" name="eyelash[]"
                                                                    data-category="eyelash" value="Phủ mi đen">
                                                                <label class="form-check-label label-container"
                                                                    for="eyelash8">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/eyelash.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Phủ mi đen</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="eyelash9" type="checkbox" name="eyelash[]"
                                                                    data-category="eyelash" value="Mix Mi màu">
                                                                <label class="form-check-label label-container"
                                                                    for="eyelash9">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/eyelash.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Mix Mi màu</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="eyelash10" type="checkbox" name="eyelash[]"
                                                                    data-category="eyelash" value="Trộn Mi màu">
                                                                <label class="form-check-label label-container"
                                                                    for="eyelash10">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/eyelash.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Trộn Mi màu</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="eyelash11" type="checkbox" name="eyelash[]"
                                                                    data-category="eyelash" value="Dặm Mi">
                                                                <label class="form-check-label label-container"
                                                                    for="eyelash11">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/eyelash.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Dặm Mi</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="eyelash12" type="checkbox" name="eyelash[]"
                                                                    data-category="eyelash"
                                                                    value="Định Hình Chân Mày">
                                                                <label class="form-check-label label-container"
                                                                    for="eyelash12">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/eyelash.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Định Hình Chân Mày</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="eyelash13" type="checkbox" name="eyelash[]"
                                                                    data-category="eyelash"
                                                                    value="Mi Thiết Kế ( Lông Thỏ )">
                                                                <label class="form-check-label label-container"
                                                                    for="eyelash13">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/eyelash.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Mi Thiết Kế ( Lông Thỏ )</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="fillter-botox">
                                                            <div class="form-label">
                                                                <label><span>[B] Filler / Botox</span></label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="filler-botox1" type="checkbox"
                                                                    name="filler-botox[]" data-category="filler-botox"
                                                                    value="Filler Pháp">
                                                                <label class="form-check-label label-container"
                                                                    for="filler-botox1">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/filler-botox.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Filler Pháp</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="filler-botox2" type="checkbox"
                                                                    name="filler-botox[]" data-category="filler-botox"
                                                                    value="Filler Hàn Quốc">
                                                                <label class="form-check-label label-container"
                                                                    for="filler-botox2">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/filler-botox.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Filler Hàn Quốc</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="filler-botox3" type="checkbox"
                                                                    name="filler-botox[]" data-category="filler-botox"
                                                                    value="Tiêm trị thâm mắt">
                                                                <label class="form-check-label label-container"
                                                                    for="filler-botox3">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/filler-botox.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Tiêm trị thâm mắt</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="filler-botox4" type="checkbox"
                                                                    name="filler-botox[]" data-category="filler-botox"
                                                                    value="Tiêm tan filler">
                                                                <label class="form-check-label label-container"
                                                                    for="filler-botox4">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/filler-botox.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Tiêm tan filler</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="filler-botox5" type="checkbox"
                                                                    name="filler-botox[]" data-category="filler-botox"
                                                                    value="Tiêm sẹo lồi">
                                                                <label class="form-check-label label-container"
                                                                    for="filler-botox5">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/filler-botox.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Tiêm sẹo lồi</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="filler-botox6" type="checkbox"
                                                                    name="filler-botox[]" data-category="filler-botox"
                                                                    value="Botox Thon gọn hàm">
                                                                <label class="form-check-label label-container"
                                                                    for="filler-botox6">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/filler-botox.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Botox Thon gọn hàm</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="filler-botox7" type="checkbox"
                                                                    name="filler-botox[]" data-category="filler-botox"
                                                                    value="Botox Xóa nhăn">
                                                                <label class="form-check-label label-container"
                                                                    for="filler-botox7">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/filler-botox.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Botox Xóa nhăn</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="filler-botox8" type="checkbox"
                                                                    name="filler-botox[]" data-category="filler-botox"
                                                                    value="Botox Khử mùi hôi vùng nách">
                                                                <label class="form-check-label label-container"
                                                                    for="filler-botox8">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/filler-botox.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Botox Khử mùi hôi vùng nách</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="filler-botox9" type="checkbox"
                                                                    name="filler-botox[]" data-category="filler-botox"
                                                                    value="Botox Hạ cơ vai thô">
                                                                <label class="form-check-label label-container"
                                                                    for="filler-botox9">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/filler-botox.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Botox Hạ cơ vai thô</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="filler-botox10" type="checkbox"
                                                                    name="filler-botox[]" data-category="filler-botox"
                                                                    value="Botox Giảm cơ bắp tay">
                                                                <label class="form-check-label label-container"
                                                                    for="filler-botox10">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/filler-botox.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Botox Giảm cơ bắp tay</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="mesotherapy">
                                                            <div class="form-label">
                                                                <label><span>[C] Mesotherapy</span></label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="mesotherapy1" type="checkbox"
                                                                    name="mesotherapy[]" data-category="mesotherapy"
                                                                    value="Mesotherapy Mulgwang">
                                                                <label class="form-check-label label-container"
                                                                    for="mesotherapy1">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/mesotherapy.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Mesotherapy Mulgwang</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="mesotherapy2" type="checkbox"
                                                                    name="mesotherapy[]" data-category="mesotherapy"
                                                                    value="Mesotherapy thường">
                                                                <label class="form-check-label label-container"
                                                                    for="mesotherapy2">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/mesotherapy.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Mesotherapy thường</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="mesotherapy3" type="checkbox"
                                                                    name="mesotherapy[]" data-category="mesotherapy"
                                                                    value="Mesotherapy Exosome">
                                                                <label class="form-check-label label-container"
                                                                    for="mesotherapy3">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/mesotherapy.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Mesotherapy Exosome</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="mesotherapy4" type="checkbox"
                                                                    name="mesotherapy[]" data-category="mesotherapy"
                                                                    value="Mesotherapy Hair">
                                                                <label class="form-check-label label-container"
                                                                    for="mesotherapy4">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/mesotherapy.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Mesotherapy Hair</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="mesotherapy5" type="checkbox"
                                                                    name="mesotherapy[]" data-category="mesotherapy"
                                                                    value="Tiêm B.A.P Jalupro">
                                                                <label class="form-check-label label-container"
                                                                    for="mesotherapy5">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/mesotherapy.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Tiêm B.A.P Jalupro</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="mesotherapy6" type="checkbox"
                                                                    name="mesotherapy[]" data-category="mesotherapy"
                                                                    value="Tiêm B.A.P Profhilo">
                                                                <label class="form-check-label label-container"
                                                                    for="mesotherapy6">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/mesotherapy.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Tiêm B.A.P Profhilo</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="fat-dissolve">
                                                            <div class="form-label">
                                                                <label><span>[D] Tiêm tan mỡ</span></label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="fat-dissolve1" type="checkbox"
                                                                    name="fat-dissolve[]" data-category="fat-dissolve"
                                                                    value="Tiêm tan mỡ tay">
                                                                <label class="form-check-label label-container"
                                                                    for="fat-dissolve1">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/fat-dissolve.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Tiêm tan mỡ tay</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="fat-dissolve2" type="checkbox"
                                                                    name="fat-dissolve[]" data-category="fat-dissolve"
                                                                    value="Tiêm tan mỡ nách">
                                                                <label class="form-check-label label-container"
                                                                    for="fat-dissolve2">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/fat-dissolve.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Tiêm tan mỡ nách</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="fat-dissolve3" type="checkbox"
                                                                    name="fat-dissolve[]" data-category="fat-dissolve"
                                                                    value="Tiêm tan mỡ nọng cằm">
                                                                <label class="form-check-label label-container"
                                                                    for="fat-dissolve3">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/fat-dissolve.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Tiêm tan mỡ nọng cằm</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="fat-dissolve4" type="checkbox"
                                                                    name="fat-dissolve[]" data-category="fat-dissolve"
                                                                    value="Tiêm tan mỡ bụng">
                                                                <label class="form-check-label label-container"
                                                                    for="fat-dissolve4">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/fat-dissolve.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Tiêm tan mỡ bụng</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="fat-dissolve5" type="checkbox"
                                                                    name="fat-dissolve[]" data-category="fat-dissolve"
                                                                    value="Tiêm tan mỡ bắp chân">
                                                                <label class="form-check-label label-container"
                                                                    for="fat-dissolve5">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/fat-dissolve.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Tiêm tan mỡ bắp chân</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="fat-dissolve6" type="checkbox"
                                                                    name="fat-dissolve[]" data-category="fat-dissolve"
                                                                    value="Tiêm tan mỡ đùi">
                                                                <label class="form-check-label label-container"
                                                                    for="fat-dissolve6">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/fat-dissolve.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Tiêm tan mỡ đùi</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="cosmetic-surgery">
                                                            <div class="form-label">
                                                                <label><span>[D] PTTM</span></label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="cosmetic-surgery1" type="checkbox"
                                                                    name="cosmetic-surgery[]"
                                                                    data-category="cosmetic-surgery"
                                                                    value="Căng chỉ nâng cơ">
                                                                <label class="form-check-label label-container"
                                                                    for="cosmetic-surgery1">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/cosmetic-surgery.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Căng chỉ nâng cơ</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="cosmetic-surgery2" type="checkbox"
                                                                    name="cosmetic-surgery[]"
                                                                    data-category="cosmetic-surgery" value="Cắt Mí">
                                                                <label class="form-check-label label-container"
                                                                    for="cosmetic-surgery2">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/cosmetic-surgery.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Cắt Mí</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="cosmetic-surgery3" type="checkbox"
                                                                    name="cosmetic-surgery[]"
                                                                    data-category="cosmetic-surgery"
                                                                    value="Cấy Mỡ Mí">
                                                                <label class="form-check-label label-container"
                                                                    for="cosmetic-surgery3">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/cosmetic-surgery.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Cấy Mỡ Mí</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="cosmetic-surgery4" type="checkbox"
                                                                    name="cosmetic-surgery[]"
                                                                    data-category="cosmetic-surgery"
                                                                    value="Treo cung chân mày">
                                                                <label class="form-check-label label-container"
                                                                    for="cosmetic-surgery4">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/cosmetic-surgery.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Treo cung chân mày</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="cosmetic-surgery5" type="checkbox"
                                                                    name="cosmetic-surgery[]"
                                                                    data-category="cosmetic-surgery"
                                                                    value="Thu bọng mắt dưới">
                                                                <label class="form-check-label label-container"
                                                                    for="cosmetic-surgery5">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/cosmetic-surgery.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Thu bọng mắt dưới</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="cosmetic-surgery6" type="checkbox"
                                                                    name="cosmetic-surgery[]"
                                                                    data-category="cosmetic-surgery" value="Nhấn mí">
                                                                <label class="form-check-label label-container"
                                                                    for="cosmetic-surgery6">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/cosmetic-surgery.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Nhấn mí</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="cosmetic-surgery7" type="checkbox"
                                                                    name="cosmetic-surgery[]"
                                                                    data-category="cosmetic-surgery"
                                                                    value="Nâng mũi chỉ">
                                                                <label class="form-check-label label-container"
                                                                    for="cosmetic-surgery7">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/cosmetic-surgery.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Nâng mũi chỉ</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="hair-spa">
                                                            <div class="form-label">
                                                                <label><span>[F] Gội Đầu Dưỡng Sinh</span></label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="hair-spa1" type="checkbox" name="hair-spa[]"
                                                                    data-category="hair-spa" value="Gội cơ bản - 90k">
                                                                <label class="form-check-label label-container"
                                                                    for="hair-spa1">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/hair-spa.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Gội cơ bản - 90k</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="hair-spa2" type="checkbox" name="hair-spa[]"
                                                                    data-category="hair-spa"
                                                                    value="Gội cao cấp - 159k">
                                                                <label class="form-check-label label-container"
                                                                    for="hair-spa2">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/hair-spa.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Gội cao cấp - 159k</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="hair-spa3" type="checkbox" name="hair-spa[]"
                                                                    data-category="hair-spa" value="Gội Gold - 220k">
                                                                <label class="form-check-label label-container"
                                                                    for="hair-spa3">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/hair-spa.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Gội Gold - 220k</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="hair-spa4" type="checkbox" name="hair-spa[]"
                                                                    data-category="hair-spa"
                                                                    value="Tẩy da chết da đầu">
                                                                <label class="form-check-label label-container"
                                                                    for="hair-spa4">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/hair-spa.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Tẩy da chết da đầu</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="hair-spa5" type="checkbox" name="hair-spa[]"
                                                                    data-category="hair-spa"
                                                                    value="Mặt nạ Mắt thư giãn">
                                                                <label class="form-check-label label-container"
                                                                    for="hair-spa5">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/hair-spa.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Mặt nạ Mắt thư giãn</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="hair-spa6" type="checkbox" name="hair-spa[]"
                                                                    data-category="hair-spa" value="Mặt nạ đá lạnh">
                                                                <label class="form-check-label label-container"
                                                                    for="hair-spa6">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/hair-spa.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Mặt nạ đá lạnh</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="skin-care">
                                                            <div class="form-label">
                                                                <label><span>[H] Chăm Sóc Da</span></label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="skin-care1" type="checkbox"
                                                                    name="skin-care[]" data-category="skin-care"
                                                                    value="Cấy Nano skin">
                                                                <label class="form-check-label label-container"
                                                                    for="skin-care1">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/skin-care.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Cấy Nano skin</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="skin-care2" type="checkbox"
                                                                    name="skin-care[]" data-category="skin-care"
                                                                    value="Cấy tảo xoắn">
                                                                <label class="form-check-label label-container"
                                                                    for="skin-care2">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/skin-care.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Cấy tảo xoắn</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="skin-care3" type="checkbox"
                                                                    name="skin-care[]" data-category="skin-care"
                                                                    value="Cấy tế bào gốc trẻ hóa">
                                                                <label class="form-check-label label-container"
                                                                    for="skin-care3">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/skin-care.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Cấy tế bào gốc trẻ hóa</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="skin-care4" type="checkbox"
                                                                    name="skin-care[]" data-category="skin-care"
                                                                    value="Chạy Vitamin C">
                                                                <label class="form-check-label label-container"
                                                                    for="skin-care4">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/skin-care.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Chạy Vitamin C</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="skin-care5" type="checkbox"
                                                                    name="skin-care[]" data-category="skin-care"
                                                                    value="Thải độc CO2">
                                                                <label class="form-check-label label-container"
                                                                    for="skin-care5">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/skin-care.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Thải độc CO2</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="skin-care6" type="checkbox"
                                                                    name="skin-care[]" data-category="skin-care"
                                                                    value="Chăm sóc da cơ bản">
                                                                <label class="form-check-label label-container"
                                                                    for="skin-care6">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/skin-care.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Chăm sóc da cơ bản</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="skin-care7" type="checkbox"
                                                                    name="skin-care[]" data-category="skin-care"
                                                                    value="Chemical Peel Thường">
                                                                <label class="form-check-label label-container"
                                                                    for="skin-care7">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/skin-care.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Chemical Peel Thường</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="skin-care8" type="checkbox"
                                                                    name="skin-care[]" data-category="skin-care"
                                                                    value="Chemical Peel VIP">
                                                                <label class="form-check-label label-container"
                                                                    for="skin-care8">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/skin-care.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Chemical Peel VIP</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="skin-care9" type="checkbox"
                                                                    name="skin-care[]" data-category="skin-care"
                                                                    value="Herbal Deep Care + Glow skin">
                                                                <label class="form-check-label label-container"
                                                                    for="skin-care9">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/skin-care.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Herbal Deep Care + Glow skin</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="skin-care10" type="checkbox"
                                                                    name="skin-care[]" data-category="skin-care"
                                                                    value="Vi kim Kim Cương">
                                                                <label class="form-check-label label-container"
                                                                    for="skin-care10">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/skin-care.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Vi kim Kim Cương</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="pinky-bikini">
                                                            <div class="form-label">
                                                                <label><span>[I] Pinky Bikini</span></label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="pinky-bikini1" type="checkbox"
                                                                    name="pinky-bikini[]" data-category="pinky-bikini"
                                                                    value="Làm hồng bikini">
                                                                <label class="form-check-label label-container"
                                                                    for="pinky-bikini1">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/pinky-bikini.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Làm hồng bikini</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="pinky-bikini2" type="checkbox"
                                                                    name="pinky-bikini[]" data-category="pinky-bikini"
                                                                    value="Làm hồng nhũ hoa">
                                                                <label class="form-check-label label-container"
                                                                    for="pinky-bikini2">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/pinky-bikini.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Làm hồng nhũ hoa</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="pinky-bikini3" type="checkbox"
                                                                    name="pinky-bikini[]" data-category="pinky-bikini"
                                                                    value="Làm hồng nách">
                                                                <label class="form-check-label label-container"
                                                                    for="pinky-bikini3">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/pinky-bikini.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Làm hồng nách</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="pinky-bikini4" type="checkbox"
                                                                    name="pinky-bikini[]" data-category="pinky-bikini"
                                                                    value="Làm hồng mông">
                                                                <label class="form-check-label label-container"
                                                                    for="pinky-bikini4">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/pinky-bikini.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Làm hồng mông</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check input-container mb-2">
                                                                <input class="form-check-input service-input"
                                                                    id="pinky-bikini5" type="checkbox"
                                                                    name="pinky-bikini[]" data-category="pinky-bikini"
                                                                    value="Làm hồng vùng bẹn">
                                                                <label class="form-check-label label-container"
                                                                    for="pinky-bikini5">
                                                                    <div class="label-image">
                                                                        <image
                                                                            src="{{ asset('images/pinky-bikini.png') }}" />
                                                                    </div>
                                                                    <span class="label-content">Làm hồng vùng bẹn</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                            id="modal-back-btn">Quay lại</button>
                                        <button type="button" class="btn btn-primary" id="saveChanges">Xong</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script>
        var serviceModal = document.getElementById('serviceModal')
        var serviceModalBtn = document.getElementById('showServiceBtnAdd')

        serviceModal.addEventListener('shown.bs.modal', function() {
            // serviceModal.focus()
        })

        $(document).ready(function() {
            $('#select-datetime').hide();
            $('#confirmBooking').hide();

            $('#searchService').on('input', function() {
                var searchValue = $(this).val().toLowerCase();

                $('#serviceList .form-check').each(function() {
                    var label = $(this).find('label').text().toLowerCase();
                    if (label.includes(searchValue)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });

                $('#serviceList > div').each(function() {
                    var hasVisibleService = $(this).find('.form-check').filter(function() {
                        return $(this).css('display') !== 'none';
                    }).length > 0;

                    if (hasVisibleService) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

            $('#saveChanges').on('click', function() {
                const selectedServices = [];
                $('.modal-body .form-check-input').each(function() {
                    if ($(this).is(':checked')) {
                        selectedServices.push({
                            value: $(this).val(),
                            id: $(this).attr('id'),
                            category: $(this).data('category')
                        });
                    }
                });

                $('#selectedServices').empty();
                selectedServices.forEach(function(service) {
                    const serviceItem = `
                        <div class="service-item">
                            <div class="d-flex">
                                <div class="col-10 d-flex shadow p-2 mb-2 bg-body rounded">
                                    <div class="item-image">
                                        <img src="/images/${service.category}.png" alt="">
                                    </div>
                                    <div class="d-flex align-items-center">${service.value}</div>
                                </div>
                                <div class="col-2 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-x-lg remove-service" data-service-id="${service.id}"></i>
                                </div>
                            </div>
                        </div>
                    `;
                    $('#selectedServices').append(serviceItem);
                });

                $('#serviceModal').modal('hide');
            });

            $('#selectedServices').on('click', '.remove-service', function(event) {
                const serviceId = $(this).data('service-id');
                $('#' + serviceId).prop('checked', false);
                $(this).closest('.service-item').remove();
                if ($('.service-input:checked').length == 0) {
                    $('#select-datetime').hide();
                }
            });

            const timeRanges = [
                "09:00", "09:30", "10:00", "10:30", "11:00",
                "11:30", "12:00", "12:30", "13:00", "13:30",
                "14:00", "14:30", "15:00", "15:30", "16:00",
                "16:30", "17:00", "17:30", "18:00", "18:30",
                "19:00", "19:30", "20:00"
            ];

            const bookingData = JSON.parse(@json($bookingData));

            function displayTimeRanges(startIndex = 0) {
                const selectedTimeRanges = timeRanges.slice(startIndex);
                var inputDate = $('#dateInput').val();
                $('.time-range-selector').empty();

                const bookedTimes = new Set(bookingData[inputDate] || []);

                selectedTimeRanges.forEach(function(time) {
                    const timeButton = $('<button>')
                        .addClass('btn btn-select-time')
                        .attr('type', 'button')
                        .text(time)
                        .on('click', function() {
                            $('.btn-select-time').removeClass('active');
                            $(this).addClass('active');
                            $('#timeInput').val(time);
                        });

                    if (bookedTimes.has(time)) {
                        timeButton.attr('disabled', true);
                    }

                    $('.time-range-selector').append(timeButton);
                });
            }

            function updateDateInput(selectedDate) {
                $('#dateInput').val(selectedDate);
            }

            $('#todayButton').on('click', function() {
                const now = new Date();
                const currentHour = now.getHours();
                let startIndex = 0;

                for (let i = 0; i < timeRanges.length; i++) {
                    const [hour, minute] = timeRanges[i].split(':').map(Number);
                    if (currentHour > 20) {
                        startIndex = timeRanges.length;
                        break;
                    }
                    if (hour > currentHour || (hour === currentHour && minute > now.getMinutes())) {
                        startIndex = i;
                        break;
                    }
                }

                const today = formatDate(now);
                updateDateInput(today);
                displayTimeRanges(startIndex);
            });

            function formatDate(date) {
                const day = String(date.getDate()).padStart(2, '0');
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const year = date.getFullYear();
                return `${day}/${month}/${year}`;
            }

            function getDayOfWeek(dateString) {
                var parts = dateString.split('/');
                var day = parseInt(parts[0], 10);
                var month = parseInt(parts[1], 10);
                var year = parseInt(parts[2], 10);

                var specificDate = new Date(year, month - 1, day);

                var weekdays = ["Chủ nhật", "Thứ hai", "Thứ ba", "Thứ tư", "Thứ năm", "Thứ sáu", "Thứ bảy"];

                return weekdays[specificDate.getDay()];
            }

            $('#tomorrowButton').on('click', function() {
                const tomorrow = new Date();
                tomorrow.setDate(tomorrow.getDate() + 1);
                const tomorrowFormatted = formatDate(tomorrow);
                updateDateInput(tomorrowFormatted);
                displayTimeRanges();
            });

            // Initialize with today's date and time ranges from now onwards
            const initialDate = formatDate(new Date());
            updateDateInput(initialDate);

            $('#datepickerBtn').datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true,
                todayHighlight: true
            }).on('changeDate', function(e) {
                $('#chooseDateButton').prop('checked', true);
                $('#selectedDateText').text(e.format('dd/mm/yyyy'));
                $('#timeInput').val('');
                $('#dateInput').val(e.format('dd/mm/yyyy'));

                displayTimeRanges();
            });

            $('#datepickerBtn').click(function(e) {
                e.preventDefault();
                $(this).datepicker('show');
            });

            $('#tomorrowButton, #todayButton').change(function() {
                $('#timeInput').val('');
                $('#selectedDateText').text('Ngày khác');
            });

            $('.service-input').change(function() {
                if ($('.service-input:checked').length > 0) {
                    $('#select-datetime').show();
                } else {
                    $('#select-datetime').hide();
                }
            });

            $('#booking-back-btn').on('click', function() {
                $('#confirmBooking').hide();
                $('#booking').show();
            });

            $('#modal-back-btn').on('click', function() {
                $('.modal-body .service-input').each(function() {
                    $(this).prop('checked', false);
                });
                $('#select-datetime').hide();
            });

            $('#booking-next-btn').on('click', function() {
                if ($('.service-input:checked').length == 0 || $('#timeInput').val() == '' || $(
                        '#dateInput').val() == '') {
                    return;
                }
                $('#confirmBooking').show();
                $('#booking').hide();
                $('.confirm-title').removeClass('d-none');
                $('.booking-title').addClass('d-none');
                $('#confirmServiceList').empty();
                $('.modal-body .service-input').each(function() {
                    if ($(this).is(':checked')) {
                        const serviceItem = `
                            <span class="me-1 mb-1 d-inline-block border border-dark rounded pt-1 py-1 ps-2 pe-2">
                                ${$(this).val()}
                            </span>
                        `;
                        $('#confirmServiceList').append(serviceItem);
                    }
                });
                $('#confirmLocation').empty();
                $('#confirmLocation').append($('#locationSpa').val());
                $('#confirmTime').empty();
                $('#confirmTime').append($('#timeInput').val());
                $('#confirmDate').empty();
                $('#confirmDate').append(getDayOfWeek($('#dateInput').val()) + ", " + $('#dateInput')
                    .val());
            })
        });

        $('#reset-form').on('click', function() {
            let text = "Bạn có chắc chắn muốn hủy lịch hẹn này?";
            if (confirm(text) == true) {
                location.reload();
            }

            return;
        });

        $('.service-input').on('change', function() {
            var $container = $(this).closest('.input-container');
            if ($(this).is(':checked')) {
            $container.css('background-color', 'color-mix(in srgb, #DCBCB8 ,#fff 90%)');
            } else {
            $container.css('background-color', '');
            }
        });

        (function() {
            'use strict'
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>
</body>

</html>
