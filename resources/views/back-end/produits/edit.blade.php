@extends('back-end.layouts.app')

@section('content')
    <section class="content-main">
        <div class="content-header d-flex justify-content-between align-items-center mb-4">
            <h2 class="content-title">Modifier le produit</h2>
            <a href="{{ route('produits.index') }}" class="btn btn-light border">
                <i class="material-icons md-arrow_back"></i> Retour à la liste
            </a>
        </div>

        <form action="{{ route('produits.update', $produit->id) }}" method="POST" enctype="multipart/form-data"
            id="productForm">
            @csrf
            @method('PUT')
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
                                        <option value="{{ $sc->id }}" {{ $produit->sous_categorie_id == $sc->id ? 'selected' : '' }}>{{ $sc->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Marque</label>
                                <select name="marque_id" class="form-select" required>
                                    <option value="">-- Choisir une marque --</option>
                                    @foreach($marques as $marque)
                                        <option value="{{ $marque->id }}" {{ $produit->sous_categorie_id == $marque->id ? 'selected' : '' }}>{{ $marque->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Nom & Description -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nom du produit</label>
                                <input type="text" name="nom" class="form-control" required value="{{ $produit->nom }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Description</label>
                                <textarea name="description" rows="3"
                                    class="form-control">{{ $produit->description }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Description longue</label>
                                <textarea
                                    name="long_description"
                                    rows="6"
                                    class="form-control"
                                    placeholder="Description détaillée du produit">
                                    {{ old('long_description', $produit->long_description) }}
                                </textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Informations additionnelles</label>
                                <textarea
                                    name="additional_info"
                                    rows="4"
                                    class="form-control"
                                    placeholder="Matière, dimensions, entretien, origine, etc.">
                                    {{ old('additional_info', $produit->additional_info) }}
                                </textarea>
                            </div>


                            <!-- Image principale & Poids -->
                            <div class="row g-3 mb-3">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Images supplémentaires</label>
                                    <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
                                    <div class="mt-2">
                                        @foreach($produit->images as $img)
                                            <div class="d-inline-block position-relative me-2 mb-2">
                                                <img src="{{ asset('storage/' . $img->image_path) }}" alt="image" width="80">
                                                <button type="button"
                                                    class="btn btn-sm btn-danger position-absolute top-0 end-0 btn-delete-image"
                                                    data-id="{{ $img->id }}">x</button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Poids (kg)</label>
                                    <input type="number" step="0.01" name="poids" class="form-control"
                                        value="{{ $produit->poids }}">
                                </div>
                            </div>

                            <!-- Quantité & Prix -->
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Quantité</label>
                                    <input type="number" name="quantite" class="form-control" required min="0"
                                        value="{{ $produit->quantite }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Prix (€)</label>
                                    <input type="number" step="0.01" name="price" class="form-control" required
                                        value="{{ $produit->prix_ttc }}">
                                </div>
                            </div>

                            <!-- Promotion & Prix promotionnel -->
                            <div class="form-check mb-3">
                                <input type="checkbox" name="est_en_promotion" value="1" class="form-check-input"
                                    id="promoCheck" {{ $produit->prix_promotionnel ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="promoCheck">En promotion</label>
                            </div>
                            <div class="mb-3" id="promoPriceContainer"
                                style="{{ $produit->prix_promotionnel ? '' : 'display:none;' }}">
                                <label class="form-label fw-bold">Prix Promotionnel (€)</label>
                                <input type="number" step="0.01" name="prix_promotionnel" class="form-control"
                                    value="{{ $produit->prix_promotionnel }}">
                            </div>

                            <!-- Actif -->
                            <div class="form-check mb-3">
                                <input type="checkbox" name="est_actif" value="1" class="form-check-input" id="activeCheck"
                                    {{ $produit->est_actif ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold" for="activeCheck">Actif</label>
                            </div>

                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-success btn-lg">💾 Mettre à jour le produit</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Variantes -->
                <div class="col-lg-5">
                    <div class="card shadow-sm mb-4 p-3">

                        <!-- Avec variantes -->
                        <div class="form-check mb-3">
                            <input type="checkbox" name="avec_variant" value="1" class="form-check-input" id="variantCheck"
                                {{ $produit->avec_variant ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="variantCheck">Avec variantes</label>
                        </div>

                        <!-- Variantes -->
                        <div id="variants-section" style="{{ $produit->avec_variant ? '' : 'display:none;' }}">
                            <hr>
                            <h5 class="mb-3 text-primary">Variantes</h5>
                            <div id="variants-container">
                                @foreach($produit->variants as $index => $variant)
                                    <div class="row mb-4 variant-row align-items-end border-bottom pb-3">
                                        <div class="col-md-12">
                                            <label class="form-label fw-bold">Couleurs</label>
                                            <select multiple name="variants[{{ $index }}][couleurs][]"
                                                class="form-select variant-color-select">
                                                @foreach($couleurs as $couleur)
                                                    <option value="{{ $couleur->id }}" {{ in_array($couleur->id, [$variant->couleur_id]) ? 'selected' : '' }}>{{ $couleur->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="selected-colors mt-2"></div>
                                        </div>

                                        <div class="col-md-12">
                                            <label class="form-label fw-bold">Tailles</label>
                                            <select multiple name="variants[{{ $index }}][tailles][]"
                                                class="form-select variant-size-select">
                                                @foreach($tailles as $taille)
                                                    <option value="{{ $taille->id }}" {{ in_array($taille->id, [$variant->taille_id]) ? 'selected' : '' }}>{{ $taille->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="selected-sizes mt-2"></div>
                                        </div>

                                        <div class="col-md-4 mt-3">
                                            <label class="form-label fw-bold">Quantité</label>
                                            <input type="number" name="variants[{{ $index }}][quantite_variant]"
                                                class="form-control" min="0" value="{{ $variant->quantite_variant }}">
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <label class="form-label fw-bold">Prix TTC (€)</label>
                                            <input type="number" step="0.01" name="variants[{{ $index }}][prix_ttc_variant]"
                                                class="form-control" value="{{ $variant->prix_ttc_variant }}">
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <label class="form-label fw-bold">Prix promo (€)</label>
                                            <input type="number" step="0.01"
                                                name="variants[{{ $index }}][prix_promotionnel_variant]" class="form-control"
                                                value="{{ $variant->prix_promotionnel_variant }}">
                                        </div>

                                        <div class="col-md-6 mt-3">
                                            <label class="form-label fw-bold">Image</label>
                                            <input type="file" name="variants[{{ $index }}][image_variant]" class="form-control"
                                                accept="image/*">
                                            @if($variant->image_variant)
                                                <img src="{{ asset('storage/' . $variant->image_variant) }}" class="img-fluid mt-2"
                                                    width="100">
                                            @endif
                                        </div>
                                        <div class="col-md-6 mt-3 text-end">
                                            <button type="button"
                                                class="btn btn-outline-danger btn-remove-variant">Supprimer</button>
                                        </div>
                                    </div>
                                @endforeach
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