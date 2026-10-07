{{-- Gabarit commun des pages d'information. Les pages définissent @section('page-content'). --}}
@extends('front-end.layouts.app')

@section('title', $pageTitle)
@section('meta_description', $metaDescription)

@section('content')
    <style>
        .info-page {
            padding: 30px 0 80px;
        }

        .info-page .info-card {
            max-width: 860px;
            margin: 0 auto;
            background: #fff;
            border: 1px solid #ECECEC;
            border-radius: 16px;
            padding: 40px;
        }

        .info-page h1 {
            font-size: 32px;
            margin-bottom: 8px;
        }

        .info-page .updated {
            color: #7E7E7E;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .info-page h2 {
            font-size: 20px;
            margin: 30px 0 12px;
        }

        .info-page p,
        .info-page li {
            color: #4F5D68;
            line-height: 1.75;
        }

        .info-page ul {
            padding-left: 20px;
        }

        .info-page .todo {
            background: #FFF4DE;
            color: #9A6B00;
            padding: 1px 6px;
            border-radius: 4px;
            font-weight: 600;
        }

        .info-page .info-nav {
            display: flex;
            flex-wrap: wrap;
            gap: 8px 18px;
            justify-content: center;
            margin-top: 36px;
            padding-top: 24px;
            border-top: 1px dashed #ECECEC;
            font-size: 14px;
        }

        @media (max-width: 575.98px) {
            .info-page .info-card {
                padding: 24px 18px;
            }

            .info-page h1 {
                font-size: 26px;
            }
        }
    </style>

    <div class="info-page">
        <div class="container">
            <article class="info-card">
                <h1>{{ $pageTitle }}</h1>
                @yield('page-content')

                <nav class="info-nav" aria-label="Informations">
                    <a href="{{ route('pages.show', 'contact') }}">Contact</a>
                    <a href="{{ route('pages.show', 'livraison') }}">Livraison</a>
                    <a href="{{ route('pages.show', 'retours') }}">Retours</a>
                    <a href="{{ route('pages.show', 'cgv') }}">CGV</a>
                    <a href="{{ route('pages.show', 'mentions-legales') }}">Mentions légales</a>
                    <a href="{{ route('pages.show', 'confidentialite') }}">Confidentialité</a>
                </nav>
            </article>
        </div>
    </div>
@endsection
