@extends('front-end.layouts.app')

@section('content')
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">

            </div>
        </div>

        <div class="container mb-30">
            <div class="row">
                <div class="col-xl-10 col-lg-12 m-auto">
                    <div class="product-detail accordion-detail">
                        <div class="row mb-50 mt-30">
                            <!-- Images gallery -->
                            <div class="col-md-6 col-sm-12 col-xs-12 mb-md-0 mb-sm-5">
                                <div class="detail-gallery">
                                    <span class="zoom-icon"><i class="fi-rs-search"></i></span>



                                    <!-- MAIN SLIDES -->
                                    <div class="product-image-slider">
                                        {{-- Image principale du produit --}}
                                        @if ($produit->image)
                                            <figure class="border-radius-10 main-slide active">
                                                <img src="{{ asset('storage/' . $produit->image) }}" alt="{{ $produit->nom }}"
                                                    class="img-fluid product-detail-main-img" data-index="0">
                                            </figure>
                                        @endif

                                        {{-- Images secondaires (table produit_images) --}}
                                        @foreach ($produit->images as $index => $image)
                                            <figure
                                                class="border-radius-10 main-slide {{ $loop->first && !$produit->image ? 'active' : '' }}">
                                                <img src="{{ asset('storage/' . $image->image_path) }}"
                                                    alt="{{ $produit->nom }}" class="img-fluid product-detail-main-img"
                                                    data-index="{{ $produit->image ? $index + 1 : $index }}">
                                            </figure>
                                        @endforeach
                                    </div>

                                    <!-- THUMBNAILS -->
                                    <div class="slider-nav-thumbnails">
                                        {{-- Miniature pour l'image principale --}}
                                        @if ($produit->image)
                                            <div class="thumbnail-item active" data-index="0">
                                                <img src="{{ asset('storage/' . $produit->image) }}" alt="{{ $produit->nom }}"
                                                    class="img-fluid thumbnail-img">
                                            </div>
                                        @endif

                                        {{-- Miniatures pour les images secondaires --}}
                                        @foreach ($produit->images as $index => $image)
                                            <div class="thumbnail-item {{ !$produit->image && $loop->first ? 'active' : '' }}"
                                                data-index="{{ $produit->image ? $index + 1 : $index }}">
                                                <img src="{{ asset('storage/' . $image->image_path) }}"
                                                    alt="{{ $produit->nom }}" class="img-fluid thumbnail-img">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>


                            <!-- Product details -->
                            <div class="col-md-6 col-sm-12">
                                <div class="detail-info pr-30 pl-30">
                                    @if($produit->sale_off)
                                        <span class="stock-status out-stock">Sale Off</span>
                                    @endif
                                    <h2 class="title-detail">{{ $produit->nom }}</h2>
                                    <div class="product-detail-rating">
                                        <div class="product-rate-cover text-end">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: {{ $produit->rating * 20 }}%">
                                                </div>
                                            </div>
                                            <span class="font-small ml-5 text-muted">({{ $produit->reviews_count }}
                                                avis )</span>
                                        </div>
                                    </div>

                                    <div class="clearfix product-price-cover">
                                        <div class="product-price primary-color float-left">
                                            <span
                                                class="current-price text-brand">€{{ number_format($produit->prix_ttc, 2) }}</span>
                                            @if($produit->prix_ancien)
                                                <span><span
                                                        class="save-price font-md color3 ml-15">{{ round((($produit->prix_ancien - $produit->prix_ttc) / $produit->prix_ancien) * 100) }}%
                                                        Off</span>
                                                    <span
                                                        class="old-price font-md ml-15">€{{ number_format($produit->prix_ancien, 2) }}</span></span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="short-desc mb-30">
                                        <p class="font-lg">{{ $produit->description }}</p>
                                    </div>

                                    @if($produit->avec_variant)

                                        {{-- Couleurs disponibles --}}
                                        @php
                                            $couleurs = $produit->variants->pluck('couleur')->filter();
                                        @endphp
                                        @if($couleurs->isNotEmpty())
                                            <div class="mb-3">
                                                <strong>Couleurs disponibles:</strong>
                                                <div class="mt-2">
                                                    @foreach($couleurs as $couleur)
                                                        <span class="badge" style="
                                                                                                background-color: {{ $couleur->code_hex ?? '#000' }};
                                                                                                color: #fff;
                                                                                                font-size: 14px;
                                                                                                padding: 10px 15px;
                                                                                                border-radius: 8px;
                                                                                                display: inline-block;
                                                                                                margin-right: 5px;
                                                                                                min-width: 80px;
                                                                                                text-align: center;
                                                                                            ">
                                                            {{ $couleur->name }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                        {{-- Tailles disponibles --}}
                                        @php
                                            $tailles = $produit->variants->pluck('taille.name')->unique()->filter();
                                        @endphp
                                        @if($tailles->isNotEmpty())
                                            <div class="mb-3">
                                                <strong>Tailles disponibles:</strong>
                                                <div class="mt-2">
                                                    @foreach($tailles as $taille)
                                                        <span class="badge" style="
                                                                                                background-color: #17a2b8;
                                                                                                color: #fff;
                                                                                                font-size: 14px;
                                                                                                padding: 10px 15px;
                                                                                                border-radius: 8px;
                                                                                                display: inline-block;
                                                                                                margin-right: 5px;
                                                                                                min-width: 60px;
                                                                                                text-align: center;
                                                                                            ">
                                                            {{ $taille }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                    @endif


                                    <form action="{{ route('cart.add') }}" method="POST" id="add-to-cart-form">
                                        @csrf
                                        <input type="hidden" name="produit_id" value="{{ $produit->id }}">

                                        <!-- Pour les produits AVEC variants -->
                                        @if($produit->avec_variant && $produit->variants->count() > 0)
                                            <button type="button" class="add add-to-cart-modal-btn"
                                                data-product-id="{{ $produit->id }}" data-product-name="{{ $produit->nom }}"
                                                data-product-image="{{ asset('storage/' . $produit->image) }}"
                                                data-product-price="{{ number_format($produit->prix_promotionnel ?? $produit->prix_ttc, 2, ',', ' ') }} €"
                                                data-product-old-price="{{ $produit->prix_promotionnel ? number_format($produit->prix_ttc, 2, ',', ' ') : '' }}"
                                                style="background: none; border: none; color: inherit; cursor: pointer;">
                                                <i class="fi-rs-shopping-cart mr-5"></i>Ajouter
                                            </button>
                                        @else
                                            <!-- Pour les produits SANS variant -->
                                            <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form">
                                                @csrf
                                                <input type="hidden" name="produit_id" value="{{ $produit->id }}">
                                                <input type="hidden" name="qty" value="1">
                                                <button type="submit" class="add"
                                                    style="background: none; border: none; color: inherit; cursor: pointer;">
                                                    <i class="fi-rs-shopping-cart mr-5"></i>Ajouter
                                                </button>
                                            </form>
                                        @endif

                                        <div class="detail-extralink mb-50 align-items-center justify-content-between"
                                            style="gap: 20px;">
                                            <div class="detail-qty border radius">
                                                <input type="number" name="qty" class="qty-val" value="1" min="1"
                                                    max="{{ $produit->quantite }}" id="product-qty">
                                            </div>
                                            <button type="submit" class="button button-add-to-cart ml-auto"
                                                style="height: 50px;">
                                                <i class="fi-rs-shopping-cart"></i> Ajouter au panier
                                            </button>
                                        </div>
                                    </form>

                                    <div class="font-xs">
                                        <ul class="mr-50 float-start">
                                            <li class="mb-5">Référence: <a href="#">{{ $produit->reference  }}</a></li>
                                            <li class="mb-5">Stock: <span
                                                    class="in-stock text-brand ml-5">{{ $produit->quantite }} articles en
                                                    stock </span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tabs for Description, Info, Vendor, avis -->
                        <div class="product-info">
                            <div class="tab-style3">
                                <ul class="nav nav-tabs text-uppercase">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="Description-tab" data-bs-toggle="tab"
                                            href="#Description">Description</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="Additional-info-tab" data-bs-toggle="tab"
                                            href="#Additional-info">Additional info</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="Vendor-info-tab" data-bs-toggle="tab"
                                            href="#Vendor-info">Vendor</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="Reviews-tab" data-bs-toggle="tab" href="#Reviews">avis
                                            ({{ $produit->reviews_count }})</a>
                                    </li>
                                </ul>
                                <div class="tab-content shop_info_tab entry-main-content">
                                    <div class="tab-pane fade show active" id="Description">
                                        <p>{{ $produit->long_description }}</p>
                                    </div>
                                    <div class="tab-pane fade" id="Additional-info">
                                        <table class="font-md">
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="Vendor-info">
                                        <p>{{ $produit->vendor->description ?? '' }}</p>
                                    </div>
                                    <div class="tab-pane fade" id="Reviews">

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Related Products -->
<div class="row mt-60">
    <div class="col-12">
        <h2 class="section-title style-1 mb-30">Produits similaires</h2>
    </div>
    <div class="col-12">
        @if(isset($relatedProducts) && $relatedProducts->count() > 0)
            <div class="row related-products">
                @foreach($relatedProducts as $relatedProduct)
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                        <div class="product-cart-wrap mb-30">
                            <div class="product-img-action-wrap">
                                <div class="product-img product-img-zoom">
                                    <!-- CORRECTION : Utilisez l'ID au lieu du slug -->
                                    <a href="{{ route('produit.show', $relatedProduct->id) }}">
                                        @if($relatedProduct->image)
                                            <img class="default-img"
                                                src="{{ asset('storage/' . $relatedProduct->image) }}"
                                                alt="{{ $relatedProduct->nom }}"
                                                style="height: 200px; object-fit: cover;">
                                        @else
                                            <img class="default-img"
                                                src="{{ asset('images/default-product.jpg') }}"
                                                alt="{{ $relatedProduct->nom }}"
                                                style="height: 200px; object-fit: cover;">
                                        @endif
                                    </a>
                                </div>
                                <!-- CORRECTION : Utilisez prix_promotionnel si vous avez ce champ -->
                                @if($relatedProduct->prix_promotionnel)
                                    <div class="product-badges product-badges-position product-badges-mrg">
                                        <span class="hot">Promo</span>
                                    </div>
                                @endif
                            </div>
                            <div class="product-content-wrap">
                                <h2>
                                    <!-- CORRECTION : Utilisez l'ID au lieu du slug -->
                                    <a href="{{ route('produit.show', $relatedProduct->id) }}">
                                        {{ \Illuminate\Support\Str::limit($relatedProduct->nom, 40) }}
                                    </a>
                                </h2>
                                <div class="product-price">
                                    <!-- CORRECTION : Utilisez le prix promotionnel s'il existe -->
                                    <span>€{{ number_format($relatedProduct->prix_promotionnel ?? $relatedProduct->prix_ttc, 2) }}</span>
                                    <!-- CORRECTION : Affichez le prix normal s'il y a un prix promotionnel -->
                                    @if($relatedProduct->prix_promotionnel)
                                        <span class="old-price">€{{ number_format($relatedProduct->prix_ttc, 2) }}</span>
                                    @endif
                                </div>
                                <div class="product-action-1">
                                    <!-- CORRECTION : Ajoutez la logique pour produits avec/sans variants -->
                                    @if($relatedProduct->avec_variant && $relatedProduct->variants->count() > 0)
                                        <button type="button" class="action-btn add-to-cart-modal-btn"
                                            data-product-id="{{ $relatedProduct->id }}"
                                            data-product-name="{{ $relatedProduct->nom }}"
                                            data-product-image="{{ $relatedProduct->image ? asset('storage/' . $relatedProduct->image) : asset('images/default-product.jpg') }}"
                                            data-product-price="{{ number_format($relatedProduct->prix_promotionnel ?? $relatedProduct->prix_ttc, 2) }} €">
                                            <i class="fi-rs-shopping-cart"></i>
                                        </button>
                                    @else
                                        <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form">
                                            @csrf
                                            <input type="hidden" name="produit_id" value="{{ $relatedProduct->id }}">
                                            <input type="hidden" name="qty" value="1">
                                            <button type="submit" aria-label="Ajouter au panier" class="action-btn">
                                                <i class="fi-rs-shopping-cart"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center">Aucun produit similaire trouvé.</p>
        @endif
    </div>
</div>

                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection