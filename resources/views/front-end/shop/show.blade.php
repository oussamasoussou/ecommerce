@extends('front-end.layouts.app')

@section('title', $produit->nom)
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($produit->description ?: $produit->long_description ?: $produit->nom), 155))
@section('og_image', $produit->image_url)

@section('content')
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container"></div>
        </div>

        <div class="container mb-30">
            <div class="row">
                <div class="col-xl-10 col-lg-12 m-auto">
                    <div class="product-detail accordion-detail">
                        <div class="row mb-50 mt-30">

                            {{-- ===== GALERIE IMAGES ===== --}}
                            <div class="col-md-6 col-sm-12 col-xs-12 mb-md-0 mb-sm-5">
                                <div class="detail-gallery">
                                    <span class="zoom-icon"><i class="fi-rs-search"></i></span>

                                    <div class="product-image-slider">
                                        @if ($produit->image)
                                            <figure class="border-radius-10 main-slide active">
                                                <img src="{{ $produit->image_url }}"
                                                     alt="{{ $produit->nom }}"
                                                     class="img-fluid product-detail-main-img"
                                                     data-index="0">
                                            </figure>
                                        @endif

                                        @foreach ($produit->images as $index => $image)
                                            <figure class="border-radius-10 main-slide {{ $loop->first && !$produit->image ? 'active' : '' }}">
                                                <img src="{{ asset('storage/' . $image->image_path) }}"
                                                     alt="{{ $produit->nom }}"
                                                     class="img-fluid product-detail-main-img"
                                                     data-index="{{ $produit->image ? $index + 1 : $index }}">
                                            </figure>
                                        @endforeach
                                    </div>

                                    <div class="slider-nav-thumbnails">
                                        @if ($produit->image)
                                            <div class="thumbnail-item active" data-index="0">
                                                <img src="{{ $produit->image_url }}"
                                                     alt="{{ $produit->nom }}"
                                                     class="img-fluid thumbnail-img">
                                            </div>
                                        @endif

                                        @foreach ($produit->images as $index => $image)
                                            <div class="thumbnail-item {{ !$produit->image && $loop->first ? 'active' : '' }}"
                                                 data-index="{{ $produit->image ? $index + 1 : $index }}">
                                                <img src="{{ asset('storage/' . $image->image_path) }}"
                                                     alt="{{ $produit->nom }}"
                                                     class="img-fluid thumbnail-img">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            {{-- ===== DÉTAILS PRODUIT ===== --}}
                            <div class="col-md-6 col-sm-12">
                                <div class="detail-info pr-30 pl-30">

                                    @if($produit->sale_off)
                                        <span class="stock-status out-stock">Sale Off</span>
                                    @endif

                                    <h1 class="title-detail">{{ $produit->nom }}</h1>

                                    <div class="product-detail-rating">
                                        <div class="product-rate-cover text-end">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: {{ $produit->rating * 20 }}%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted">({{ $produit->reviews_count }} avis)</span>
                                        </div>
                                    </div>

                                    <div class="clearfix product-price-cover">
                                        <div class="product-price primary-color float-left">
                                            <span class="current-price text-brand" id="prix-affiche">
                                                DT{{ number_format($produit->prix_ttc, 2) }}
                                            </span>
                                            @if($produit->prix_ancien)
                                                <span>
                                                    <span class="save-price font-md color3 ml-15">
                                                        {{ round((($produit->prix_ancien - $produit->prix_ttc) / $produit->prix_ancien) * 100) }}% Off
                                                    </span>
                                                    <span class="old-price font-md ml-15" id="ancien-prix-affiche">
                                                        DT{{ number_format($produit->prix_ancien, 2) }}
                                                    </span>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="short-desc mb-30">
                                        <p class="font-lg">{{ $produit->description }}</p>
                                    </div>

                                    {{-- ===== SÉLECTEUR DE VARIANTS ===== --}}
                                    @if($produit->avec_variant && $produit->variants->count() > 0)
                                        @php
                                            $couleurs         = $produit->variants->pluck('couleur')->filter()->unique('id');
                                            $toutesLesTailles = $produit->variants->pluck('taille')->filter()->unique('id');
                                            $variantsJson     = $produit->variants->map(fn($v) => [
                                                'id'         => $v->id,
                                                'couleur_id' => $v->couleur_id,
                                                'taille_id'  => $v->taille_id,
                                                'taille_nom' => $v->taille?->name,
                                                'prix'       => $v->prix_promotionnel ?? $v->prix_ttc_variant,
                                                'stock'      => $v->quantite_variant,
                                            ]);
                                        @endphp

                                        <div id="variant-picker" data-variants="{{ $variantsJson->toJson() }}">

                                            {{-- Couleurs --}}
                                            @if($couleurs->isNotEmpty())
                                            <div class="mb-3">
                                                <strong>Couleur :</strong>
                                                <span id="selected-couleur-label" class="ms-2 text-muted"></span>
                                                <div class="d-flex flex-wrap gap-2 mt-2">
                                                    @foreach($couleurs as $couleur)
                                                    <button type="button"
                                                        class="btn-couleur"
                                                        data-couleur-id="{{ $couleur->id }}"
                                                        title="{{ $couleur->name }}"
                                                        style="
                                                            width:36px; height:36px; border-radius:50%;
                                                            background-color:{{ $couleur->code_hex ?? '#ccc' }};
                                                            border: 3px solid transparent;
                                                            cursor:pointer;
                                                            transition: border-color .2s, transform .15s;
                                                            display:inline-block;
                                                        ">
                                                    </button>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @endif

                                            {{-- Tailles — masquées au départ, remplies par JS selon la couleur --}}
                                            @if($toutesLesTailles->isNotEmpty())
                                            <div class="mb-3" id="tailles-section" style="display:none;">
                                                <strong>Taille :</strong>
                                                <span id="selected-taille-label" class="ms-2 text-muted"></span>
                                                <div class="d-flex flex-wrap gap-2 mt-2" id="tailles-container">
                                                    {{-- Rempli dynamiquement par JS --}}
                                                </div>
                                            </div>
                                            @endif

                                            {{-- Info stock après sélection complète --}}
                                            <div id="variant-info" class="mb-2" style="display:none;">
                                                <span class="text-muted">Stock : </span>
                                                <strong id="variant-stock"></strong>
                                            </div>

                                            {{-- Messages d'erreur --}}
                                            <div id="variant-error" class="alert alert-warning py-2" style="display:none;"></div>

                                        </div>
                                    @endif
                                    {{-- ===== FIN SÉLECTEUR ===== --}}

                                    {{-- ===== FORMULAIRE PANIER ===== --}}
                                    <form action="{{ route('cart.add') }}" method="POST" id="add-to-cart-form">
                                        @csrf
                                        <input type="hidden" name="produit_id" value="{{ $produit->id }}">
                                        <input type="hidden" name="variant_id" id="hidden-variant-id">

                                        <div class="detail-extralink mb-50 d-flex align-items-center" style="gap: 20px;">
                                            <div class="detail-qty border radius">
                                                <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                                                <input type="number" name="qty" class="qty-val"
                                                       value="1" min="1"
                                                       max="{{ $produit->quantite }}"
                                                       id="product-qty">
                                                <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                            </div>

                                            @if($produit->avec_variant && $produit->variants->count() > 0)
                                                <button type="button" id="btn-add-to-cart"
                                                        class="button button-add-to-cart"
                                                        style="height: 50px;">
                                                    <i class="fi-rs-shopping-cart"></i> Ajouter au panier
                                                </button>
                                            @else
                                                <button type="submit"
                                                        class="button button-add-to-cart"
                                                        style="height: 50px;">
                                                    <i class="fi-rs-shopping-cart"></i> Ajouter au panier
                                                </button>
                                            @endif
                                        </div>
                                    </form>
                                    {{-- ===== FIN FORMULAIRE ===== --}}

                                    <div class="font-xs">
                                        <ul class="mr-50 float-start">
                                            <li class="mb-5">Référence: <a href="#">{{ $produit->reference }}</a></li>
                                            <li class="mb-5">Stock:
                                                <span class="in-stock text-brand ml-5">
                                                    {{ $produit->quantite }} articles en stock
                                                </span>
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </div>

                        {{-- ===== ONGLETS INFO ===== --}}
                        <div class="product-info">
                            <div class="tab-style3">
                                <ul class="nav nav-tabs text-uppercase">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="Description-tab"
                                           data-bs-toggle="tab" href="#Description">Description</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="Additional-info-tab"
                                           data-bs-toggle="tab" href="#Additional-info">Additional info</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="Reviews-tab"
                                           data-bs-toggle="tab" href="#Reviews">
                                           Avis ({{ $produit->reviews_count }})
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content shop_info_tab entry-main-content">
                                    <div class="tab-pane fade show active" id="Description">
                                        <p>{{ $produit->long_description ?? 'Pas de description disponible.' }}</p>
                                    </div>
                                    <div class="tab-pane fade" id="Additional-info">
                                        @if($produit->additional_info)
                                            <p>{{ $produit->additional_info }}</p>
                                        @else
                                            <p>Aucune information additionnelle disponible.</p>
                                        @endif
                                    </div>
                                    <div class="tab-pane fade" id="Reviews">
                                        {{-- Section avis --}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ===== PRODUITS SIMILAIRES ===== --}}
                        <div class="row mt-60">
                            <div class="col-12">
                                <h2 class="section-title style-1 mb-30">Produits similaires</h2>
                            </div>
                            <div class="col-12">
                                @if(isset($relatedProducts) && $relatedProducts->count() > 0)
                                    <div class="row related-products">
                                        @foreach ($relatedProducts as $relatedProduct)
                                            <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                                                <div class="product-cart-wrap mb-30">
                                                    <div class="product-img-action-wrap">
                                                        <div class="product-img product-img-zoom">
                                                            <a href="{{ route('shop.show', $relatedProduct->id) }}">
                                                                @if($relatedProduct->image)
                                                                    <img class="default-img"
                                                                         src="{{ $relatedProduct->image_url }}"
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
                                                        @if($relatedProduct->prix_promotionnel)
                                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                                <span class="hot">Promo</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="product-content-wrap">
                                                        <h2>
                                                            <a href="{{ route('shop.show', $relatedProduct->id) }}">
                                                                {{ \Illuminate\Support\Str::limit($relatedProduct->nom, 40) }}
                                                            </a>
                                                        </h2>
                                                        <div class="product-price">
                                                            <span>DT{{ number_format($relatedProduct->prix_promotionnel ?? $relatedProduct->prix_ttc, 2) }}</span>
                                                            @if($relatedProduct->prix_promotionnel)
                                                                <span class="old-price">DT{{ number_format($relatedProduct->prix_ttc, 2) }}</span>
                                                            @endif
                                                        </div>
                                                        <div class="product-action-1 mt-2">
                                                            @if($relatedProduct->avec_variant && $relatedProduct->variants->count() > 0)
                                                                <button type="button"
                                                                    class="action-btn add-to-cart-modal-btn"
                                                                    data-product-id="{{ $relatedProduct->id }}"
                                                                    data-product-name="{{ $relatedProduct->nom }}"
                                                                    data-product-image="{{ $relatedProduct->image_url }}"
                                                                    data-product-price="{{ number_format($relatedProduct->prix_promotionnel ?? $relatedProduct->prix_ttc, 2) }} DT">
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const picker = document.getElementById('variant-picker');
    if (!picker) return;
 
    const variants = JSON.parse(picker.dataset.variants);
    let couleurId  = null;
    let tailleId   = null;
 
    function afficherTaillesPourCouleur(cId) {
        const container = document.getElementById('tailles-container');
        const section   = document.getElementById('tailles-section');
        if (!container || !section) return;
 
        const variantsDeCetteCouleur = variants.filter(v => String(v.couleur_id) === String(cId));
 
        container.innerHTML = '';
        tailleId = null;
        const labelTaille = document.getElementById('selected-taille-label');
        if (labelTaille) labelTaille.textContent = '';
        resetVariantInfo();
 
        if (variantsDeCetteCouleur.length === 0) {
            section.style.display = 'none';
            return;
        }
 
        variantsDeCetteCouleur.forEach(v => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'btn btn-outline-secondary btn-taille';
            btn.dataset.tailleId = v.taille_id;
            btn.textContent = v.taille_nom ?? ('Taille ' + v.taille_id);
            btn.style.cssText = 'margin:3px; min-width:48px; padding:6px 14px; border-radius:6px;';
 
            if (v.stock <= 0) {
                btn.disabled = true;
                btn.style.opacity = '0.4';
                btn.style.textDecoration = 'line-through';
                btn.title = 'Rupture de stock';
            }
 
            btn.addEventListener('click', function () {
                container.querySelectorAll('.btn-taille').forEach(b => {
                    b.classList.remove('active', 'btn-secondary');
                    b.classList.add('btn-outline-secondary');
                });
                this.classList.remove('btn-outline-secondary');
                this.classList.add('active', 'btn-secondary');
 
                tailleId = this.dataset.tailleId;
                const label = document.getElementById('selected-taille-label');
                if (label) label.textContent = this.textContent.trim();
 
                updateVariantInfo();
            });
 
            container.appendChild(btn);
        });
 
        section.style.display = 'block';
    }
 
    function updateVariantInfo() {
        const v = variants.find(v =>
            String(v.couleur_id) === String(couleurId) &&
            String(v.taille_id)  === String(tailleId)
        );
 
        const info   = document.getElementById('variant-info');
        const err    = document.getElementById('variant-error');
        const hidden = document.getElementById('hidden-variant-id');
        const prix   = document.getElementById('prix-affiche');
 
        if (v) {
            if (prix) prix.textContent = 'DT' + parseFloat(v.prix).toFixed(2);
 
            document.getElementById('variant-stock').textContent =
                v.stock > 0 ? v.stock + ' en stock' : 'Rupture de stock';
 
            info.style.display = 'block';
            err.style.display  = 'none';
            hidden.value = v.id;
        } else {
            resetVariantInfo();
        }
    }
 
    function resetVariantInfo() {
        const info   = document.getElementById('variant-info');
        const err    = document.getElementById('variant-error');
        const hidden = document.getElementById('hidden-variant-id');
        if (info)   info.style.display   = 'none';
        if (err)    err.style.display    = 'none';
        if (hidden) hidden.value = '';
    }
 
    document.querySelectorAll('.btn-couleur').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.btn-couleur').forEach(b => {
                b.style.borderColor = 'transparent';
                b.style.transform   = 'scale(1)';
            });
            this.style.borderColor = '#333';
            this.style.transform   = 'scale(1.15)';
 
            couleurId = this.dataset.couleurId;
            const label = document.getElementById('selected-couleur-label');
            if (label) label.textContent = this.getAttribute('title');
 
            afficherTaillesPourCouleur(couleurId);
        });
    });
 
    const btnAdd = document.getElementById('btn-add-to-cart');
    if (btnAdd) {
        btnAdd.addEventListener('click', function () {
            const err    = document.getElementById('variant-error');
            const hidden = document.getElementById('hidden-variant-id');
 
            if (!couleurId) {
                err.textContent   = 'Veuillez sélectionner une couleur.';
                err.style.display = 'block';
                return;
            }
            if (!tailleId) {
                err.textContent   = 'Veuillez sélectionner une taille.';
                err.style.display = 'block';
                return;
            }
            if (!hidden.value) {
                err.textContent   = 'Combinaison introuvable, veuillez réessayer.';
                err.style.display = 'block';
                return;
            }
 
            err.style.display = 'none';
            document.getElementById('add-to-cart-form').dispatchEvent(new Event('submit', { cancelable: true, bubbles: true }));
        });
    }
});
</script>
@endpush
