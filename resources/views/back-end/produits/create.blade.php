@extends('back-end.layouts.app')

@section('content')
    <section class="content-main">
        <div class="content-header d-flex justify-content-between align-items-center mb-4">
            <h2 class="content-title">Ajouter un produit</h2>
            <a href="{{ route('produits.index') }}" class="btn btn-light border">
                <i class="material-icons md-arrow_back"></i> Retour à la liste
            </a>
        </div>

        <form action="{{ route('produits.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
            @csrf
            <div class="row g-4">

                <!-- Formulaire principal -->
                <div class="col-lg-7">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header text-white">
                            <h5 class="mb-0">Informations principales</h5>
                        </div>
                        <div class="card-body">
                            <!-- Sous-catégorie -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Sous-catégorie</label>
                                <select name="sous_categorie_id" class="form-select" required>
                                    <option value="">-- Choisir une sous-catégorie --</option>
                                    @foreach($sousCategories as $sc)
                                        <option value="{{ $sc->id }}">{{ $sc->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Marque</label>
                                <select name="marque_id" class="form-select" required>
                                    <option value="">-- Choisir une marque --</option>
                                    @foreach($marques as $marque)
                                        <option value="{{ $marque->id }}">{{ $marque->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Nom & Description -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nom du produit</label>
                                <input type="text" name="nom" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Description</label>
                                <textarea name="description" rows="3" class="form-control"></textarea>
                            </div>

                            <!-- Image principale & Images supplémentaires -->
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Image principale</label>
                                    <input type="file" name="image" class="form-control" accept="image/*">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Images supplémentaires</label>
                                    <input type="file" name="images_supplementaires[]" class="form-control" accept="image/*"
                                        multiple>
                                </div>
                            </div>

                            <!-- Poids -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Poids (kg)</label>
                                <input type="number" step="0.01" name="poids" class="form-control">
                            </div>

                            <!-- Quantité & Prix -->
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Quantité</label>
                                    <input type="number" name="quantite" class="form-control" required min="0">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Prix (€)</label>
                                    <input type="number" step="0.01" name="price" class="form-control" required>
                                </div>
                            </div>

                            <!-- Promotion -->
                            <div class="form-check mb-3">
                                <input type="checkbox" name="en_promotion" value="1" class="form-check-input"
                                    id="promoCheck">
                                <label class="form-check-label fw-bold" for="promoCheck">En promotion</label>
                            </div>
                            <div class="mb-3" id="promoPriceContainer" style="display: none;">
                                <label class="form-label fw-bold">Prix Promotionnel (€)</label>
                                <input type="number" step="0.01" name="prix_promotionnel" class="form-control">
                            </div>

                            <!-- Actif -->
                            <div class="form-check mb-3">
                                <input type="checkbox" name="est_actif" value="1" class="form-check-input" id="activeCheck"
                                    checked>
                                <label class="form-check-label fw-bold" for="activeCheck">Actif</label>
                            </div>

                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-success btn-lg">💾 Enregistrer le produit</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Variantes -->
                <div class="col-lg-5">
                    <div class="card shadow-sm mb-4 p-3">

                        <div class="form-check mb-3">
                            <input type="checkbox" name="avec_variant" value="1" class="form-check-input" id="variantCheck">
                            <label class="form-check-label fw-bold" for="variantCheck">Avec variantes</label>
                        </div>

                        <div id="variants-section" style="display: none;">
                            <hr>
                            <h5 class="mb-3 text-primary">Variantes</h5>
                            <div id="variants-container">
                                <div class="row mb-4 variant-row align-items-end border-bottom pb-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Couleurs</label>
                                        <select multiple name="variants[0][couleurs][]" class="form-select">
                                            @foreach($couleurs as $couleur)
                                                <option value="{{ $couleur->id }}">{{ $couleur->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Tailles</label>
                                        <select multiple name="variants[0][tailles][]" class="form-select">
                                            @foreach($tailles as $taille)
                                                <option value="{{ $taille->id }}">{{ $taille->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4 mt-3">
                                        <label class="form-label fw-bold">Quantité</label>
                                        <input type="number" name="variants[0][quantite_variant]" class="form-control"
                                            min="0">
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <label class="form-label fw-bold">Prix TTC (€)</label>
                                        <input type="number" step="0.01" name="variants[0][prix_ttc_variant]"
                                            class="form-control">
                                    </div>
                                    <div class="col-md-4 mt-3">
                                        <label class="form-label fw-bold">Prix promo (€)</label>
                                        <input type="number" step="0.01" name="variants[0][prix_promotionnel_variant]"
                                            class="form-control">
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <label class="form-label fw-bold">Image variante</label>
                                        <input type="file" name="variants[0][image_variant]" class="form-control"
                                            accept="image/*">
                                    </div>
                                    <div class="col-md-6 mt-3 text-end">
                                        <button type="button"
                                            class="btn btn-outline-danger btn-remove-variant">Supprimer</button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline-primary mb-3" id="add-variant">
                                <i class="material-icons md-add"></i> Ajouter une variante
                            </button>
                        </div>

                    </div>
                </div>

            </div>
        </form>
    </section>


@endsection