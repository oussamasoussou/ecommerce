<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Connexion - Tableau de bord</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/imgs/theme/favicon.svg') }}" />
    <link rel="stylesheet" href="{{ asset('back-end/css/main.css?v=6.1') }}">
</head>

<body>
    <main>
        <section class="content-main mt-80 mb-80">
            <div class="card mx-auto card-login">
                <div class="card-body">
                    <h4 class="card-title mb-4 text-center">Connexion</h4>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.post') }}">
                        @csrf
                        <div class="mb-3">
                            <input class="form-control" placeholder="Email" type="email" name="email" required />
                        </div>
                        <div class="mb-3">
                            <input class="form-control" placeholder="Mot de passe" type="password" name="password"
                                required />
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary w-100">Connexion</button>
                        </div>
                    </form>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                </div>
            </div>
        </section>
    </main>

    <script src="{{ asset('back-end/js/vendors/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('back-end/js/vendors/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('back-end/js/main.js?v=6.1') }}" type="text/javascript"></script>
</body>

</html>