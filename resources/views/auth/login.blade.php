<div>
    @include('layouts.header')
    <div class="container mt-6 mb-5">
        <div class="row justify-content-center">
            <div class="col-sm-8 col-lg-6 col-xl-5">
                <div class="card shadow zindex-100 mb-0">
                    <div class="card-body px-md-5 py-5">
                        <div class="mb-5">
                            <h6 class="h3">Connexion</h6>
                            <p class="text-muted mb-0">
                                Connectez-vous à votre compte pour continuer.
                            </p>
                        </div>
                        <span class="clearfix"></span>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group">
                                <label for="email" class="form-control-label">Adresse email</label>
                                <div class="input-group input-group-merge">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <label for="password" class="form-control-label">Mot de passe</label>
                                    </div>
                                    <div class="mb-2">
                                        @if (Route::has('password.request'))
                                            <a class="small text-muted text-underline--dashed border-primary" href="{{ route('password.request') }}">
                                                {{ __('Mot de passe oublié ?') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="input-group input-group-merge">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    {{-- <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                    </div> --}}
                                </div>
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="btn btn-warning btn-icon rounded-pill btn-block">
                                    <span class="btn-inner--text">Connexion</span>
                                    <span class="btn-inner--icon">
                                        <i class="fas fa-long-arrow-alt-right"></i>
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer px-md-5">
                        <small>Pas encore inscrit ?</small>
                        <a href="{{ route('register') }}" class="small font-weight-bold">Créer un compte</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('script')
    @endpush
</div>
