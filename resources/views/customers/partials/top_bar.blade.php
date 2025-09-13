<!-- Top bar -->
<div class="top-bar py-2">
    <div class="container">
        <div class="row text-center text-md-left align-items-center justify-content-between">
            <!-- Logo -->
            <div class="col-12 col-md-4 d-flex flex-column align-items-center justify-content-center mb-3 mb-md-0 border-divider">
                <a href="{{ route('customers.index')}}" class="logo-link">
                    <img
                        class="anphu-logo"
                        src="{{ company()->company_logo ?? '' }}"
                        alt="{{ company()->company_brand }} Logo"
                    >
                </a>
            </div>

            <!-- Điện thoại & Email -->
            <div class="col-12 col-md-3 d-flex flex-column align-items-left justify-content-center mb-3 mb-md-0 border-divider">
                <div>
                    <a href="tel:{{ company()->company_phone_1 ?? '' }}">
                        <i class="fa fa-phone-alt mr-1"></i>
                        Zalo: {{ company()->company_phone_1 ?? '' }}
                    </a>
                </div>
                <div>
                    <a href="tel:{{ company()->company_phone_2 ?? '' }}">
                        <i class="fa fa-phone-alt mr-1"></i>
                        Hotline: {{ company()->company_phone_2 ?? '' }}
                    </a>
                </div>
                <div>
                    <a href="mailto:{{ company()->email ?? '' }}">
                        <i class="fa fa-envelope mr-1"></i>
                        {{ company()->email ?? '' }}
                    </a>
                </div>
                <div>
                    <i class="fa fa-clock mr-1"></i>
                    {{ company()->working_hours ?? '' }}
                </div>
            </div>

            <!-- Địa chỉ -->
            <div class="col-12 col-md-3 d-flex flex-column align-items-center justify-content-center mb-3 mb-md-0 border-divider">
                <div>
                    <i class="fa fa-home mr-1"></i>
                    <span style="font-weight: bold">
                        Địa chỉ VPGD 1:
                    </span>
                    <br>
                    <span style="color: #C9B037">
                        {{ company()->company_address_1 ?? '' }}   
                    </span>
                </div>
                <div>
                    <i class="fa fa-home mr-1"></i>
                    <span style="font-weight: bold">
                        Địa chỉ VPGD 2:
                    </span>
                    <br>
                    <span style="color: #C9B037">
                        {{ company()->company_address_2 ?? '' }}   
                    </span>
                </div>
            </div>

            <!-- Social Links -->
            <div class="col-12 col-md-2 d-flex flex-column align-items-center justify-content-center">
                <x-social-media 
                    size="small" 
                    style="minimal" 
                    class="d-flex justify-content-center"
                />
            </div>
        </div>
    </div>
</div>