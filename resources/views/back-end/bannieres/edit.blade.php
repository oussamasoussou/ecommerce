@extends('back-end.layouts.app')

@section('title', 'Modifier la Bannière - Admin')

@section('content')
<section class="content-main">
    <div class="content-header d-flex justify-content-between align-items-center mb-4">
        <h2 class="content-title mb-0">Modifier la Bannière</h2>
        <a href="{{ route('bannieres.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Retour à la liste
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-light py-3">
            <h5 class="card-title mb-0">Informations de la bannière</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('bannieres.update', $banniere->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <!-- Informations de base -->
                    <div class="col-lg-8">
                        <div class="row">
                            <!-- Titre -->
                            <div class="col-md-12 mb-4">
                                <label class="form-label fw-semibold">Titre de la bannière <span class="text-danger">*</span></label>
                                <input type="text" name="titre" 
                                       value="{{ old('titre', $banniere->titre) }}" 
                                       class="form-control @error('titre') is-invalid @enderror" 
                                       placeholder="Ex: Promotion d'été, Nouvelle Collection, Soldes Hiver..." required>
                                @error('titre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Position -->
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-semibold">Position <span class="text-danger">*</span></label>
                                <select name="position" class="form-select @error('position') is-invalid @enderror" required>
                                    <option value="">-- Sélectionner une position --</option>
                                    @foreach($positions as $key => $value)
                                        <option value="{{ $key }}" {{ old('position', $banniere->position) == $key ? 'selected' : '' }}>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('position')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Texte du bouton -->
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-semibold">Texte du bouton</label>
                                <input type="text" name="texte_bouton" 
                                       value="{{ old('texte_bouton', $banniere->texte_bouton) }}" 
                                       class="form-control @error('texte_bouton') is-invalid @enderror" 
                                       placeholder="Ex: Découvrir, Acheter maintenant, Voir plus...">
                                @error('texte_bouton')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Lien -->
                            <div class="col-md-12 mb-4">
                                <label class="form-label fw-semibold">Lien de redirection</label>
                                <input type="url" name="lien" 
                                       value="{{ old('lien', $banniere->lien) }}" 
                                       class="form-control @error('lien') is-invalid @enderror" 
                                       placeholder="Ex: https://votresite.com/promotion">
                                @error('lien')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Statut -->
                            <div class="col-md-12 mb-4">
                                <div class="form-check form-switch">
                                    <input type="checkbox" name="est_actif" 
                                           class="form-check-input @error('est_actif') is-invalid @enderror" 
                                           id="est_actif" 
                                           value="1" 
                                           {{ old('est_actif', $banniere->est_actif) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="est_actif">
                                        Bannière active
                                    </label>
                                </div>
                                @error('est_actif')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    Si activé, la bannière sera visible sur le site
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Médias -->
                    <div class="col-lg-4">
                        <div class="sticky-top" style="top: 20px;">
                            <!-- Image actuelle -->
                            <div class="card mb-4">
                                <div class="card-header bg-light py-2">
                                    <h6 class="mb-0">Image actuelle</h6>
                                </div>
                                <div class="card-body text-center">
                                    @if($banniere->image)
                                        <img src="{{ asset('storage/' . $banniere->image) }}" 
                                             alt="Image actuelle" 
                                             class="img-fluid rounded mb-3" 
                                             style="max-height: 200px;">
                                        <p class="text-success small mb-2">
                                            <i class="bi bi-check-circle"></i> Image actuellement définie
                                        </p>
                                        <div class="form-check">
                                            <input type="checkbox" name="supprimer_image" 
                                                   class="form-check-input" 
                                                   id="supprimer_image" 
                                                   value="1">
                                            <label class="form-check-label text-danger small" for="supprimer_image">
                                                Supprimer cette image
                                            </label>
                                        </div>
                                    @else
                                        <div class="text-center text-muted py-4">
                                            <i class="bi bi-card-image" style="font-size: 2rem;"></i>
                                            <p class="mt-2 mb-0">Aucune image définie</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Nouvelle image -->
                            <div class="card">
                                <div class="card-header bg-light py-2">
                                    <h6 class="mb-0">Nouvelle image</h6>
                                </div>
                                <div class="card-body">
                                    <div class="text-center mb-3">
                                        <div id="imagePreviewContainer" class="border-2 border-dashed border-gray-300 rounded-lg p-4" style="display: none;">
                                            <img id="imagePreview" src="#" alt="Aperçu de la nouvelle image" class="img-fluid rounded" style="max-height: 200px;">
                                            <p class="text-muted mt-2 mb-0">Aperçu de la nouvelle image</p>
                                        </div>
                                        <div id="imagePlaceholder" class="border-2 border-dashed border-gray-300 rounded-lg p-4">
                                            <i class="bi bi-card-image text-muted" style="font-size: 2rem;"></i>
                                            <p class="text-muted mt-2 mb-0">Aucune nouvelle image sélectionnée</p>
                                        </div>
                                    </div>
                                    
                                    <input type="file" name="image" id="imageInput" 
                                           class="form-control @error('image') is-invalid @enderror" 
                                           accept="image/*">
                                    <small class="form-text text-muted">
                                        Formats: JPG, PNG, GIF, WEBP (max 5MB)
                                    </small>
                                    @error('image')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Informations sur les dimensions -->
                            <div class="card mt-4">
                                <div class="card-header bg-light py-2">
                                    <h6 class="mb-0">Recommandations</h6>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled small text-muted mb-0">
                                        <li><i class="bi bi-info-circle me-1"></i> Accueil: 1200x400px</li>
                                        <li><i class="bi bi-info-circle me-1"></i> Header: 1920x200px</li>
                                        <li><i class="bi bi-info-circle me-1"></i> Sidebar: 300x250px</li>
                                        <li><i class="bi bi-info-circle me-1"></i> Footer: 1200x150px</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('bannieres.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle"></i> Annuler
                            </a>
                            <div>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bi bi-check-circle"></i> Mettre à jour
                                </button>
                                <button type="button" class="btn btn-outline-danger ms-2" 
                                        onclick="if(confirm('Voulez-vous vraiment supprimer cette bannière ?')) { document.getElementById('delete-form').submit(); }">
                                    <i class="bi bi-trash3"></i> Supprimer
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Formulaire de suppression -->
            <form id="delete-form" action="{{ route('bannieres.destroy', $banniere->id) }}" method="POST" class="d-none">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
</section>
@endsection
