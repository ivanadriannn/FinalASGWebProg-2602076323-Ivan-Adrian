<style>
    .logo {
        width: 100px;
        height: 100px;
    }
    .bg-success {
        background-color: #188754 !important;
    }
    .header {
        background-color: #188754;
        padding: 20px;
        color: white;
        text-align: center;
        border-radius: 5px;
    }
    .hero-section {
        padding: 50px 0;
        text-align: center;
    }
    .cta-button {
        margin-top: 30px;
    }
    .container {
        max-width: 1200px;
        margin: 0 auto;
    }
</style>

<div class="header">
    <div class="logo-container">
        <img src="assets/img/logo.png" alt="Logo" class="logo">
    </div>
    <div class="app-name">
        <span class="display-4">ConnectFriend</span>
    </div>
</div>

<div class="container hero-section">
    <div class="hero-content">
        <h1 class="display-3 text-success">@lang('lang.title_welcome')</h1>
    </div>

    <div class="hero-description">
        <p class="lead mt-4">@lang('lang.tag_welcome')</p>
    </div>

    <div class="cta-container">
        <a href="{{ route('register-page') }}" class="btn btn-success btn-lg cta-button">@lang('lang.btn_join_now')</a>
    </div>
</div>
