@extends('back-end.layouts.app')

@section('title', 'Modifier la Catégorie - Admin')

@section('content')
<section class="content-main">
    <div class="content-header d-flex justify-content-between align-items-center mb-4">
        <h2 class="content-title mb-0">Modifier la catégorie</h2>
        <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Retour à la liste
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-light py-3">
            <h5 class="card-title mb-0">Modifier les informations de la catégorie</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <!-- Informations de base -->
                    <div class="col-lg-8">
                        <div class="row">
                            <!-- Nom -->
                            <div class="col-md-12 mb-4">
                                <label class="form-label fw-semibold">Nom de la catégorie <span class="text-danger">*</span></label>
                                <input type="text" name="name" 
                                       value="{{ old('name', $category->name) }}" 
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
                                          placeholder="Décrivez cette catégorie...">{{ old('description', $category->description) }}</textarea>
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
                                    <!-- Logo actuel -->
                                    @if($category->logo)
                                        <div class="text-center mb-3">
                                            <img src="{{ asset('storage/' . $category->logo) }}" 
                                                 alt="Logo actuel" 
                                                 class="img-fluid border rounded p-2 bg-white" 
                                                 style="max-height: 80px;">
                                            <p class="text-muted mt-2 mb-0">Logo actuel</p>
                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="checkbox" name="remove_logo" id="removeLogo">
                                                <label class="form-check-label text-danger" for="removeLogo">
                                                    Supprimer le logo
                                                </label>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Nouveau logo -->
                                    <div class="text-center mb-3">
                                        <div id="logoPreviewContainer" class="border-2 border-dashed border-gray-300 rounded-lg p-4" style="display: none;">
                                            <img id="logoPreview" src="#" alt="Aperçu du nouveau logo" class="img-fluid" style="max-height: 80px;">
                                            <p class="text-muted mt-2 mb-0">Nouveau logo</p>
                                        </div>
                                        <div id="logoPlaceholder" class="border-2 border-dashed border-gray-300 rounded-lg p-4" 
                                             style="{{ $category->logo ? 'display: none;' : '' }}">
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
                                    <!-- Image actuelle -->
                                    @if($category->image)
                                        <div class="text-center mb-3">
                                            <img src="{{ asset('storage/' . $category->image) }}" 
                                                 alt="Image actuelle" 
                                                 class="img-fluid border rounded p-2 bg-white" 
                                                 style="max-height: 120px;">
                                            <p class="text-muted mt-2 mb-0">Image actuelle</p>
                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="checkbox" name="remove_image" id="removeImage">
                                                <label class="form-check-label text-danger" for="removeImage">
                                                    Supprimer l'image
                                                </label>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Nouvelle image -->
                                    <div class="text-center mb-3">
                                        <div id="imagePreviewContainer" class="border-2 border-dashed border-gray-300 rounded-lg p-4" style="display: none;">
                                            <img id="imagePreview" src="#" alt="Aperçu de la nouvelle image" class="img-fluid rounded" style="max-height: 120px;">
                                            <p class="text-muted mt-2 mb-0">Nouvelle image</p>
                                        </div>
                                        <div id="imagePlaceholder" class="border-2 border-dashed border-gray-300 rounded-lg p-4" 
                                             style="{{ $category->image ? 'display: none;' : '' }}">
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
                            <div>
                                <button type="submit" class="btn btn-success px-4">
                                    <i class="bi bi-check-circle"></i> Mettre à jour
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection