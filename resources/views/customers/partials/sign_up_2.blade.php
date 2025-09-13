@push('styles')
<style>
   :root {
      --lux-dark: #0b1c2c;
      --lux-dark-2: #081420;
      --lux-gold: #C9B037;
      --lux-gold-light: #e4c465;
      --lux-gold-dark: #b2972b;
      --lux-text-dark: #0b1c2c;
      --lux-text-light: #f5f2e7;
   }

   /* Container với nền gradient */
   .voucher-container {
      border: 2px solid var(--lux-dark-2);
      border-radius: 30px !important;
      background: linear-gradient(135deg, var(--lux-gold-light) 0%, var(--lux-gold) 50%, var(--lux-gold-dark) 100%);
      padding: 1.5rem;
   }

   /* Form */
   .voucher-form {
      color: var(--lux-text-dark);
   }
   .voucher-form .form-control,
   .voucher-form textarea {
      background-color: transparent;
      border: 1px solid var(--lux-dark-2);
      color: var(--lux-text-dark);
   }
   .voucher-form .form-control::placeholder {
      color: var(--lux-dark);
   }
   .voucher-form .btn.btn-submit {
      background-color: #0c2b3a !important;
      border-color: #0c2b3a !important;
      color: var(--lux-text-dark) !important;
      font-weight: bold;
   }
   .voucher-form .btn.btn-submit:hover,
   .voucher-form .btn.btn-submit:focus,
   .voucher-form .btn.btn-submit:active {
      background-color: #0c2b3a !important;
      border-color: #0c2b3a !important;
      color: var(--lux-text-dark) !important;
      box-shadow: 0 0 0 0.2rem rgba(12, 43, 58, 0.25);
      filter: brightness(1.05);
   }
   .voucher-form p,
   .voucher-form strong {
      color: var(--lux-text-dark);
   }

   /* Card Preview */
   .voucher-card-preview {
      background-color: transparent;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem;
   }
   .voucher-card {
      overflow: hidden;
      border-radius: 20px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.5);
      max-width: 500px;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
   }
   .voucher-card img {
      width: 100%;
      height: auto;
      display: block;
      object-fit: cover;
   }
   .voucher-card:hover {
      transform: scale(1.03);
      box-shadow: 0 12px 30px rgba(201,176,55,0.4);
   }

   /* Overlay */
   .thank-you-overlay,
   .error-signup-overlay {
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.7);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 9999;
   }
   .thank-you-popup,
   .error-popup {
      background: #fff;
      padding: 2rem;
      border-radius: 15px;
      text-align: center;
      max-width: 400px;
      width: 90%;
   }

   /* Responsive Fix */
   @media (max-width: 767.98px) {
      .voucher-container {
         border-radius: 20px !important;
      }
      .voucher-card-preview {
         padding: 1rem;
      }
      .voucher-card {
         max-width: 100%;
      }
      .voucher-form {
         padding-top: 1rem;
      }
   }
</style>
@endpush

<div class="row no-gutters shadow rounded overflow-hidden voucher-container">
   <!-- Cột ảnh bên trái -->
   <div class="col-md-6 voucher-card-preview">
      <div class="voucher-card">
         <img src="{{ asset('assets/img/gallery/anphu_card.jpg') }}" alt="Ưu đãi">
      </div>
   </div>

   <!-- Cột form bên phải -->
   <div class="col-md-6 p-4 d-flex flex-column justify-content-center voucher-form">
      <form class="consulting-form" method="POST" action="{{ route('consulting_requests.store') }}">
         @csrf
         <div class="form-row">
            <div class="form-group col-md-4">
               <input type="text" name="name" class="form-control" placeholder="Họ và tên*" required>
            </div>
            <div class="form-group col-md-4">
               <input type="text" name="phone" class="form-control" placeholder="Số điện thoại*" required>
            </div>
            <div class="form-group col-md-4">
               <input type="text" name="email" class="form-control" placeholder="Email">
            </div>
         </div>

         <div class="form-group">
            <textarea class="form-control" name="note" rows="3" placeholder="Mô tả chi tiết yêu cầu của quý khách..."></textarea>
         </div>

         <div class="form-group text-center">
            <button
               type="submit"
               class="btn btn-submit btn-block"
            >GỬI YÊU CẦU</button>
         </div>

         <p class="small mb-1">
            Sau khi nhận được yêu cầu của Quý khách, tư vấn viên của chúng tôi sẽ liên hệ trong thời gian sớm nhất
         </p>
         <p class="small mb-0">
            <strong>Hotline:</strong>
            <a href="tel:{{ company()->company_phone_2 }}">
               <span class="font-weight-bold">{{ company()->company_phone_2 }}</span>
            </a>
            <br>
            <strong>Email:</strong>
            <a href="mailto:{{ company()->email }}">
               <span class="font-weight-bold">{{ company()->email }}</span>
            </a>
         </p>
      </form>
   </div>
</div>

{{-- Overlay thank you & error --}}
<div id="thank-you-overlay" class="thank-you-overlay d-none">
   <div class="thank-you-popup">
      <div class="checkmark-wrapper mb-3">
         <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
            <circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none"/>
            <path class="checkmark-check" fill="none" d="M14 27l7 7 16-16"/>
         </svg>
      </div>
      <h5 class="text-success">Đã gửi thành công!</h5>
      <p class="text-muted mb-3">Cảm ơn bạn đã để lại thông tin, chúng tôi sẽ liên hệ sớm nhất.</p>
      <button id="back-button" class="btn btn-back">← Xem tiếp</button>
   </div>
</div>

<div id="error-signup-overlay" class="error-signup-overlay d-none">
   <div class="error-popup">
      <div class="checkmark-wrapper mb-3">
         <svg class="checkmark error" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
            <circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none"/>
            <path class="checkmark-x" fill="none" d="M16 16 36 36 M36 16 16 36"/>
         </svg>
      </div>
      <h5 class="text-danger font-weight-bold">Bạn đã đăng ký hôm nay!</h5>
      <p class="text-muted mb-3">Chúng tôi đã nhận được thông tin của bạn hôm nay. Vui lòng quay lại sau.</p>
      <button class="btn btn-back btn-outline-danger mt-2" onclick="document.getElementById('error-signup-overlay').classList.add('d-none')">← Quay lại</button>
   </div>
</div>

@once
@push('scripts')
<script>
document.querySelectorAll('.consulting-form').forEach(form => {
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) throw response;
            return response.json();
        })
        .then(data => {
            form.reset();
            document.getElementById('thank-you-overlay').classList.remove('d-none');
        })
        
        .catch(async error => {
            let errorText = 'Đã có lỗi xảy ra. Vui lòng thử lại!';

            // (429) Too Many Requests
            if (error.status === 429) {
                document.getElementById('error-signup-overlay').classList.remove('d-none');
                return;
            }

            // Validation
            if (error.json) {
                const err = await error.json();
                if (err.errors) {
                    // kiểm tra riêng lỗi phone
                    if (err.errors.phone && err.errors.phone.some(msg => msg.includes('taken'))) {
                        document.getElementById('error-signup-overlay').classList.remove('d-none');
                        return;
                    }

                    // nếu không phải phone thì hiện ra alert mặc định
                    errorText = Object.values(err.errors).flat().join('<br>');
                }
            }

            // Fallback alert
            alert(errorText);
        });

    });
});

document.getElementById('back-button').addEventListener('click', function () {
    document.getElementById('thank-you-overlay').classList.add('d-none');
});

const errorSignupOverlay = document.getElementById('error-overlay');
if (errorSignupOverlay) {
    errorSignupOverlay.querySelector('.btn-back')?.addEventListener('click', () => {
        errorSignupOverlay.classList.add('d-none');
    });
}
</script>
@endpush
@endonce
