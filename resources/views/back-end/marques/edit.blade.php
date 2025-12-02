@extends('back-end.layouts.app')

@section('content')
<section class="content-main">
    <div class="content-header d-flex justify-content-between align-items-center mb-4">
        <h2 class="content-title mb-0">Modifier la marque</h2>
        <a href="{{ route('marques.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('marques.update', $marque->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <!-- Nom -->
                    <div class="col-md-12 mb-4">
                        <label class="form-label fw-semibold">Nom de la marque <span class="text-danger">*</span></label>
                        <input type="text" name="name" 
                               value="{{ old('name', $marque->name) }}" 
                               class="form-control @error('name') is-invalid @enderror" 
                               placeholder="Ex: Nike, Adidas, Apple..." required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Logo -->
                    <div class="col-md-12 mb-4">
                        <label class="form-label fw-semibold">Logo de la marque</label>
                        
                        <!-- Logo actuel -->
                        @if($marque->logo)
                        <div class="mb-3 p-3 border rounded bg-light">
                            <p class="text-muted mb-2">Logo actuel :</p>
                            <img src="{{ Storage::disk('public')->url($marque->logo) }}" 
                                 alt="{{ $marque->name }}" 
                                 style="max-height: 100px; max-width: 150px; object-fit: contain;"
                                 class="rounded border">
                            <div class="mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remove_logo" id="removeLogo">
                                    <label class="form-check-label text-danger" for="removeLogo">
                                        Supprimer le logo actuel
                                    </label>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="mb-3">
                            <span class="text-muted">Aucun logo actuellement</span>
                        </div>
                        @endif

                        <input type="file" name="logo" id="logoInput" 
                               class="form-control @error('logo') is-invalid @enderror" 
                               accept="image/*">
                        @error('logo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            Laissez vide pour conserver le logo actuel. Formats: JPEG, PNG, JPG, GIF, SVG. Taille max: 2MB
                        </div>

                        <!-- Preview nouveau logo -->
                        <div class="mt-3" id="logoPreviewContainer" style="display:none;">
                            <p class="text-muted mb-1">Aperçu du nouveau logo :</p>
                            <img id="logoPreview" src="#" 
                                 alt="Aperçu du nouveau logo" 
                                 style="max-height: 120px; max-width: 200px; border-radius: 8px; box-shadow: 0 0 5px rgba(0,0,0,0.1); object-fit: contain;">
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <a href="{{ route('marques.index') }}" class="btn btn-outline-secondary me-2">
                        Annuler
                    </a>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-check-circle"></i> Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>


@endsection