@extends('back-end.layouts.app')

@section('content')
<section class="content-main">
    <div class="content-header d-flex justify-content-between align-items-center mb-4">
        <h2 class="content-title mb-0">Créer une nouvelle marque</h2>
        <a href="{{ route('marques.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('marques.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <!-- Nom -->
                    <div class="col-md-12 mb-4">
                        <label class="form-label fw-semibold">Nom de la marque <span class="text-danger">*</span></label>
                        <input type="text" name="name" 
                               value="{{ old('name') }}" 
                               class="form-control @error('name') is-invalid @enderror" 
                               placeholder="Ex: Nike, Adidas, Apple..." required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Logo -->
                    <div class="col-md-12 mb-4">
                        <label class="form-label fw-semibold">Logo de la marque</label>
                        <input type="file" name="logo" id="logoInput" 
                               class="form-control @error('logo') is-invalid @enderror" 
                               accept="image/*">
                        @error('logo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            Formats acceptés: JPEG, PNG, JPG, GIF, SVG. Taille max: 2MB
                        </div>

                        <!-- Preview -->
                        <div class="mt-3" id="logoPreviewContainer" style="display:none;">
                            <p class="text-muted mb-1">Aperçu du logo :</p>
                            <img id="logoPreview" src="#" 
                                 alt="Aperçu du logo" 
                                 style="max-height: 120px; max-width: 200px; border-radius: 8px; box-shadow: 0 0 5px rgba(0,0,0,0.1); object-fit: contain;">
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <button type="reset" class="btn btn-outline-secondary me-2">
                        <i class="bi bi-arrow-clockwise"></i> Réinitialiser
                    </button>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-check-circle"></i> Créer la marque
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>


@endsection