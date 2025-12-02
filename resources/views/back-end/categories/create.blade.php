@extends('back-end.layouts.app')

@section('title', 'Nouvelle Catégorie - Admin')

@section('content')
<section class="content-main">
    <div class="content-header d-flex justify-content-between align-items-center mb-4">
        <h2 class="content-title mb-0">Nouvelle Catégorie</h2>
        <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Retour à la liste
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-light py-3">
            <h5 class="card-title mb-0">Informations de la catégorie</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <!-- Informations de base -->
                    <div class="col-lg-8">
                        <div class="row">
                            <!-- Nom -->
                            <div class="col-md-12 mb-4">
                                <label class="form-label fw-semibold">Nom de la catégorie <span class="text-danger">*</span></label>
                                <input type="text" name="name" 
                                       value="{{ old('name') }}" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       placeholder="Ex: Électronique, Mode, Maison..." required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="col-md-12 mb-4">
                                <label class="form-label fw-semibold">Description</label>
                                <textarea name="description" rows="5" 
                                          class="form-control @error('description') is-invalid @enderror" 
                                          placeholder="Décrivez cette catégorie...">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Médias -->
                    <div class="col-lg-4">
                        <div class="sticky-top" style="top: 20px;">
                            <!-- Logo SVG -->
                            <div class="card mb-4">
                                <div class="card-header bg-light py-2">
                                    <h6 class="mb-0">Logo (SVG)</h6>
                                </div>
                                <div class="card-body">
                                    <div class="text-center mb-3">
                                        <div id="logoPreviewContainer" class="border-2 border-dashed border-gray-300 rounded-lg p-4" style="display: none;">
                                            <img id="logoPreview" src="#" alt="Aperçu du logo" class="img-fluid" style="max-height: 80px;">
                                            <p class="text-muted mt-2 mb-0">Aperçu du logo</p>
                                        </div>
                                        <div id="logoPlaceholder" class="border-2 border-dashed border-gray-300 rounded-lg p-4">
                                            <i class="bi bi-image text-muted" style="font-size: 2rem;"></i>
                                            <p class="text-muted mt-2 mb-0">Aucun logo sélectionné</p>
                                        </div>
                                    </div>
                                    
                                    <input type="file" name="logo" id="logoInput" 
                                           class="form-control @error('logo') is-invalid @enderror" 
                                           accept=".svg">
                                    <small class="form-text text-muted">
                                        Format SVG uniquement (max 2MB)
                                    </small>
                                    @error('logo')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Image -->
                            <div class="card">
                                <div class="card-header bg-light py-2">
                                    <h6 class="mb-0">Image de la catégorie</h6>
                                </div>
                                <div class="card-body">
                                    <div class="text-center mb-3">
                                        <div id="imagePreviewContainer" class="border-2 border-dashed border-gray-300 rounded-lg p-4" style="display: none;">
                                            <img id="imagePreview" src="#" alt="Aperçu de l'image" class="img-fluid rounded" style="max-height: 120px;">
                                            <p class="text-muted mt-2 mb-0">Aperçu de l'image</p>
                                        </div>
                                        <div id="imagePlaceholder" class="border-2 border-dashed border-gray-300 rounded-lg p-4">
                                            <i class="bi bi-card-image text-muted" style="font-size: 2rem;"></i>
                                            <p class="text-muted mt-2 mb-0">Aucune image sélectionnée</p>
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
                        </div>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle"></i> Annuler
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-plus-circle"></i> Créer la catégorie
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
