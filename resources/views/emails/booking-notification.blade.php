<h1>Thông báo đặt lịch mới</h1>
<p>Tên: {{ $bookingData['name'] }}</p>
<p>Số điện thoại: {{ $bookingData['phone'] }}</p>
<p>Ngày: {{ $bookingData['date'] }}</p>
<p>Giờ: {{ $bookingData['time'] }}</p>
<p>Địa điểm: {{ $bookingData['location'] }}</p>
<p>Ghi chú: {{ $bookingData['note'] }}</p>

<h4>Dịch vụ đã chọn:</h4>
@foreach ($bookingData['services'] as $service => $details)
    @if (!empty($details))
        <p>{{ $details }}</p>
    @endif
@endforeach
