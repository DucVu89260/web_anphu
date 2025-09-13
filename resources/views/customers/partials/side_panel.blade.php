<div class="anphu-side-panel desktop-only">
   <div class="side-buttons">
      <a href="{{ route('customers.voucher') }}" class="panel-btn" aria-label="Gọi điện">
         <i class="fas fa-gift"></i>
      </a>
      <a href="{{ company()->social_links['facebook']['url'] ?? '#' }}" class="panel-btn" target="_blank" aria-label="Facebook">
         <i class="fab fa-facebook-f"></i>
      </a>
      <a href="{{ company()->social_links['youtube']['url'] ?? '#' }}" class="panel-btn" target="_blank" aria-label="YouTube">
         <i class="fab fa-youtube"></i>
      </a>
      <a href="{{ company()->social_links['tiktok']['url'] ?? '#' }}" class="panel-btn" target="_blank" aria-label="Messenger">
         <i class="fa-brands fa-tiktok"></i>
      </a>
      <a href="{{ company()->company_phone_1 ?? ''}}" class="panel-btn" target="_blank" aria-label="Zalo">
         <img src="{{ asset('assets/img/logo/logo_zalo.png') }}" alt="Zalo" class="icon-img">
      </a>
   </div>
   <div class="toggle-btn" id="toggleSidePanel">
      <span class="toggle-icon">></span>
   </div>
</div>

<div class="anphu-side-panel-mobile mobile-only">
   <div class="side-buttons">
      <a href="{{ company()->social_links['tiktok']['url'] ?? '#' }}" class="panel-btn" aria-label="Zalo">
         <i class="fa-brands fa-tiktok"></i>
         <span>Tiktok</span>
      </a>
      <a href="https://zalo.me/{{ company()->company_phone_1 ?? '' }}" class="panel-btn" aria-label="Zalo">
         <i class="fas fa-comment-dots"></i>
         <span>Zalo</span>
      </a>
      
      <a href="tel:{{ company()->company_phone_2 ?? '' }}" class="panel-btn" aria-label="Gọi điện">
         <i class="fas fa-phone-alt"></i>
         <span>Hotline</span>
      </a>
      <a href="#" class="panel-btn" aria-label="Gọi điện" id="callback-btn">
         <i class="fas fa-headset"></i>
         <span>Y/c Gọi lại</span>
      </a>
      <a href="{{ route('customers.voucher') }}" class="panel-btn" aria-label="Gọi điện">
         <i class="fas fa-gift"></i>
         <span>Ưu đãi</span>
      </a>
   </div>
</div>

<!-- Callback popup -->
<div id="callback-popup-overlay" class="popup-overlay" style="display:none;">
    <div id="callback-popup" class="popup-form">
        <h4>Để lại số điện thoại để được gọi lại:</h4>
        <form id="callbackForm" method="POST" action="{{ route('consulting_requests.callback') }}">
            <input type="text" name="name" placeholder="Nhập tên" required>
            <input type="text" name="phone" placeholder="Nhập số điện thoại" required>
            <button type="submit">Gửi yêu cầu</button>
            <button type="button" id="callback-back-btn" class="back-btn">Quay lại</button>
        </form>
    </div>

    <!-- Thank you popup -->
    <div id="thank-you-popup" class="thank-you-popup" style="display:none;">
        <div class="checkmark-wrapper mb-3">
            <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                <circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none"/>
                <path class="checkmark-check" fill="none" d="M14 27l7 7 16-16"/>
            </svg>
        </div>
        <h5 class="text-success">Đã gửi thành công!</h5>
        <p class="text-muted mb-3">Cảm ơn bạn đã để lại thông tin, chúng tôi sẽ liên hệ sớm nhất.</p>
        <button id="thank-you-back-button" class="btn btn-back">← Xem tiếp</button>
    </div>

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const callbackBtn = document.querySelector('#callback-btn');
    const overlay = document.querySelector('#callback-popup-overlay');
    const callbackPopup = document.querySelector('#callback-popup');
    const thankYouPopup = document.querySelector('#thank-you-popup');
    const callbackForm = document.querySelector('#callbackForm');
    const callbackBackBtn = document.querySelector('#callback-back-btn');
    const thankYouBackBtn = document.querySelector('#thank-you-back-button');

    // Mở popup
    callbackBtn.addEventListener('click', function(e){
        e.preventDefault();
        overlay.style.display = 'flex';
        callbackPopup.style.display = 'block';
        thankYouPopup.style.display = 'none';
    });

    // Nút quay lại form popup
    callbackBackBtn.addEventListener('click', function(){
      overlay.style.display = 'none';
      callbackPopup.style.display = 'none';
      thankYouPopup.style.display = 'none';
      callbackForm.reset();
    });

   // Submit form
   callbackForm.addEventListener('submit', function(e){
      e.preventDefault();

      const formData = new FormData(this);

      fetch(this.action, {
         method: 'POST',
         body: formData,
         headers: {
               'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
               'Accept': 'application/json'
         }
      })
      .then(async res => {
         const data = await res.json();
         if (!res.ok) throw data; // ném data nếu status không 2xx
         return data;
      })
      .then(res => {
         // Ẩn form popup, hiện thank-you popup
         callbackPopup.style.display = 'none';
         thankYouPopup.style.display = 'block';
         callbackForm.reset();
      })
      .catch(err => {
         console.error(err);
         if(err.errors){
               alert(Object.values(err.errors).flat().join('\n'));
         } else {
               alert('Có lỗi xảy ra, vui lòng thử lại.');
         }
      });
   });

   thankYouBackBtn.addEventListener('click', function(){
      thankYouPopup.style.display = 'none';
      callbackPopup.style.display = 'none';
      overlay.style.display = 'none';
      callbackForm.reset();
   });

});

</script>
@endpush