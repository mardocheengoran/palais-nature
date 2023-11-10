<div class="steps steps-light pt-2 pb-3 mb-5 mt--100">
    <a class="step-item active" href="{{ route('checkout.cart') }}">
        <div class="step-progress">
            <span class="step-count">1</span>
        </div>
        <div class="step-label">
            <i class="czi-cart"></i>Panier
        </div>
    </a>

    <a class="step-item {{ request()->routeIs('checkout.mode') or request()->routeIs('checkout.address') ? 'active current' : '' }}" href="#">
        <div class="step-progress">
            <span class="step-count">2</span>
        </div>
        <div class="step-label">
            <i class="icofont-google-map"></i>Livraison
        </div>
    </a>

    <span class="step-item" href="#">
        <div class="step-progress">
            <span class="step-count">3</span>
        </div>
        <div class="step-label">
            <i class="czi-card"></i>Paiement
        </div>
    </span>
    <span class="step-item" href="#">
        <div class="step-progress">
            <span class="step-count">4</span>
        </div>
        <div class="step-label">
            <i class="czi-check-circle"></i>Résumé
        </div>
    </span>
</div>
