@extends('back-end.layouts.app')

@section('content')
<section class="content-main">
    <div class="content-header d-flex justify-content-between align-items-center mb-4">
        <h2 class="content-title mb-0">Modifier la couleur</h2>
        <a href="{{ route('couleurs.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('couleurs.update', $couleur->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Nom -->
                    <div class="col-md-12 mb-4">
                        <label class="form-label fw-semibold">Nom <span class="text-danger">*</span></label>
                        <input type="text" name="name" 
                               value="{{ old('name', $couleur->name) }}" 
                               class="form-control @error('name') is-invalid @enderror" 
                               placeholder="Nom de la couleur" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Code Hex -->
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-semibold">Code Hex <span class="text-danger">*</span></label>
                        <input type="color" name="code_hex" 
                               value="{{ old('code_hex', $couleur->code_hex) }}" 
                               class="form-control form-control-color @error('code_hex') is-invalid @enderror">
                        @error('code_hex')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Image -->
                    <div class="col-md-12 mb-4">
                        <label class="form-label fw-semibold">Image (optionnelle)</label>
                        <input type="file" name="image" id="imageInput" 
                               class="form-control @error('image') is-invalid @enderror" accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <!-- Aperçu actuel / nouveau -->
                        <div class="mt-3" id="imagePreviewContainer">
                            <p class="text-muted mb-1">Aperçu :</p>
                            <img id="imagePreview" 
                                 src="{{ $couleur->image ? asset('storage/' . $couleur->image) : '#' }}" 
                                 alt="Aperçu de l'image" 
                                 style="max-height: 120px; border-radius: 8px; box-shadow: 0 0 5px rgba(0,0,0,0.1);">
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-check-circle"></i> Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

@push('scripts')
<script>
    // Aperçu de la nouvelle image sélectionnée
    document.getElementById('imageInput').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const previewImage = document.getElementById('imagePreview');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
            }
            reader.readAsDataURL(file);
        } else {
            // Si aucune image sélectionnée, garder l'ancienne
            previewImage.src = '{{ $couleur->image ? asset("storage/" . $couleur->image) : "#" }}';
        }
    });
</script>
@endpush
@endsection
