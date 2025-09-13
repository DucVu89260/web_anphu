<!-- Top bar -->
<div class="top-bar py-2">
    <div class="container">
        <div class="row align-items-center">
            <!-- Logo -->
            <div class="col-12 mb-md-0 text-center">
                <a href="{{ route('customers.index')}}" class="logo-link d-inline-block">
                    <img
                        class="anphu-logo"
                        src="{{ asset(company()->logo_main) }}"
                        alt="{{ company()->company_brand }} Logo"
                    >
                </a>
            </div>
        </div>
    </div>
</div>