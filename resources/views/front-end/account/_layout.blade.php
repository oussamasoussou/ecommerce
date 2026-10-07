{{-- Gabarit commun de l'espace client : styles + menu latéral. Utilisation : @include('front-end.account._layout', ['active' => 'profile']) --}}
<style>
    .account-page {
        --ac-primary: #5D7052;
        --ac-primary-dark: #4A5A41;
        --ac-primary-soft: #EEF1E8;
        --ac-ink: #253D4E;
        --ac-muted: #7E7E7E;
        --ac-line: #ECECEC;
        --ac-error: #B23B2E;
        padding: 30px 0 80px;
    }

    .account-page h1 {
        font-size: 30px;
        margin-bottom: 24px;
    }

    .ac-card {
        background: #fff;
        border: 1px solid var(--ac-line);
        border-radius: 16px;
        padding: 26px;
        margin-bottom: 24px;
    }

    .ac-card h3 {
        font-size: 19px;
        margin-bottom: 18px;
    }

    .ac-nav {
        list-style: none;
        padding: 10px;
        margin: 0 0 24px;
        background: #fff;
        border: 1px solid var(--ac-line);
        border-radius: 16px;
    }

    .ac-nav a,
    .ac-nav button {
        display: flex;
        align-items: center;
        gap: 10px;
        width: 100%;
        padding: 12px 14px;
        border: 0;
        border-radius: 10px;
        background: transparent;
        color: var(--ac-ink);
        font-weight: 600;
        text-align: left;
    }

    .ac-nav a:hover,
    .ac-nav button:hover {
        background: var(--ac-primary-soft);
        color: var(--ac-primary);
    }

    .ac-nav a.active {
        background: var(--ac-primary);
        color: #fff;
    }

    .ac-field {
        margin-bottom: 16px;
    }

    .ac-field label {
        display: block;
        font-weight: 600;
        font-size: 14px;
        color: var(--ac-ink);
        margin-bottom: 6px;
    }

    .account-page .ac-field input {
        width: 100%;
        height: 48px;
        padding: 0 14px;
        border: 1.5px solid var(--ac-line);
        border-radius: 10px;
        font-size: 15px;
    }

    .account-page .ac-field input:focus {
        outline: none;
        border-color: var(--ac-primary);
        box-shadow: 0 0 0 4px rgba(93, 112, 82, .12);
    }

    .account-page .ac-field input.is-invalid {
        border-color: var(--ac-error);
    }

    .ac-error {
        margin-top: 5px;
        font-size: 13px;
        color: var(--ac-error);
    }

    .ac-alert {
        padding: 12px 16px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .ac-alert.success {
        background: var(--ac-primary-soft);
        color: var(--ac-primary-dark);
        border: 1px solid rgba(93, 112, 82, .3);
    }

    .ac-alert.error {
        background: #FBEAE8;
        color: var(--ac-error);
        border: 1px solid rgba(178, 59, 46, .3);
    }

    .ac-status {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 700;
        background: #FFF4DE;
        color: #9A6B00;
    }

    .ac-status.delivered,
    .ac-status.paid {
        background: var(--ac-primary-soft);
        color: var(--ac-primary-dark);
    }

    .ac-status.cancelled {
        background: #FBEAE8;
        color: var(--ac-error);
    }

    .ac-table {
        width: 100%;
    }

    .ac-table th {
        font-size: 13px;
        text-transform: uppercase;
        color: var(--ac-muted);
        padding: 10px 12px;
        border-bottom: 1.5px solid var(--ac-line);
    }

    .ac-table td {
        padding: 14px 12px;
        border-bottom: 1px dashed var(--ac-line);
        vertical-align: middle;
        color: var(--ac-ink);
    }

    .ac-empty {
        text-align: center;
        padding: 40px 10px;
        color: var(--ac-muted);
    }
</style>

<ul class="ac-nav">
    <li>
        <a href="{{ route('account.profile') }}" class="{{ ($active ?? '') === 'profile' ? 'active' : '' }}">
            <i class="fi-rs-user"></i> Mon profil
        </a>
    </li>
    <li>
        <a href="{{ route('account.orders') }}" class="{{ ($active ?? '') === 'orders' ? 'active' : '' }}">
            <i class="fi-rs-shopping-bag"></i> Mes commandes
        </a>
    </li>
    <li>
        <a href="{{ route('wishlist.index') }}">
            <i class="fi-rs-heart"></i> Mes favoris
        </a>
    </li>
    <li>
        <form method="POST" action="{{ route('frontend.logout') }}">
            @csrf
            <button type="submit"><i class="fi-rs-sign-out"></i> Déconnexion</button>
        </form>
    </li>
</ul>
