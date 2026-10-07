@extends('front-end.layouts.app')

@section('title', 'Mon profil')

@section('content')
    <div class="account-page">
        <div class="container">
            <h1>Mon compte</h1>

            <div class="row">
                <div class="col-lg-3">
                    @include('front-end.account._layout', ['active' => 'profile'])
                </div>

                <div class="col-lg-9">
                    @if (session('success'))
                        <div class="ac-alert success" role="status">{{ session('success') }}</div>
                    @endif

                    {{-- Informations personnelles --}}
                    <div class="ac-card">
                        <h3>Informations personnelles</h3>
                        <form method="POST" action="{{ route('account.updateProfile') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 ac-field">
                                    <label for="firstname">Prénom</label>
                                    <input type="text" id="firstname" name="firstname" required autocomplete="given-name"
                                           value="{{ old('firstname', $user->firstname) }}"
                                           class="@error('firstname') is-invalid @enderror">
                                    @error('firstname') <div class="ac-error">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 ac-field">
                                    <label for="lastname">Nom</label>
                                    <input type="text" id="lastname" name="lastname" required autocomplete="family-name"
                                           value="{{ old('lastname', $user->lastname) }}"
                                           class="@error('lastname') is-invalid @enderror">
                                    @error('lastname') <div class="ac-error">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 ac-field">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" required autocomplete="email"
                                           value="{{ old('email', $user->email) }}"
                                           class="@error('email') is-invalid @enderror">
                                    @error('email') <div class="ac-error">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 ac-field">
                                    <label for="phone">Téléphone</label>
                                    <input type="tel" id="phone" name="phone" required autocomplete="tel"
                                           value="{{ old('phone', $user->phone) }}"
                                           class="@error('phone') is-invalid @enderror">
                                    @error('phone') <div class="ac-error">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-8 ac-field">
                                    <label for="address">Adresse</label>
                                    <input type="text" id="address" name="address" required autocomplete="street-address"
                                           value="{{ old('address', $user->address) }}"
                                           class="@error('address') is-invalid @enderror">
                                    @error('address') <div class="ac-error">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4 ac-field">
                                    <label for="city">Ville</label>
                                    <input type="text" id="city" name="city" required autocomplete="address-level2"
                                           value="{{ old('city', $user->city) }}"
                                           class="@error('city') is-invalid @enderror">
                                    @error('city') <div class="ac-error">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </form>
                    </div>

                    {{-- Mot de passe --}}
                    <div class="ac-card">
                        <h3>Changer le mot de passe</h3>
                        <form method="POST" action="{{ route('account.changePassword') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 ac-field">
                                    <label for="current_password">Mot de passe actuel</label>
                                    <input type="password" id="current_password" name="current_password" required
                                           autocomplete="current-password"
                                           class="@error('current_password') is-invalid @enderror">
                                    @error('current_password') <div class="ac-error">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4 ac-field">
                                    <label for="password">Nouveau mot de passe</label>
                                    <input type="password" id="password" name="password" required minlength="8"
                                           autocomplete="new-password"
                                           class="@error('password') is-invalid @enderror">
                                    @error('password') <div class="ac-error">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4 ac-field">
                                    <label for="password_confirmation">Confirmation</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                           required minlength="8" autocomplete="new-password">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Changer le mot de passe</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
