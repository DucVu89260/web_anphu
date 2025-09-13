<!-- Top bar -->
<div class="top-bar py-2 border-bottom bg-dark text-white">
  <div class="container">
    <div class="row align-items-center justify-content-center text-center">

      <!-- Logo -->
      <div class="col-12 d-flex justify-content-center">
        <a href="{{ route('admin.portfolios.index') }}" class="logo-link d-inline-block">
          <img class="anphu-logo" 
            src="{{ asset(company()->logo_main) }}" 
            alt="{{ company()->company_brand }} Logo"
            height="40"
          >
        </a>
      </div>

    </div>
  </div>
</div>