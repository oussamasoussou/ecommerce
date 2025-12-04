@extends('back-end.layouts.app')

@section('content')
<section class="content-main">
    <div class="content-header d-flex justify-content-between align-items-center mb-4">
        <h2 class="content-title mb-0">Modifier le prix de livraison</h2>
        <a href="{{ route('deliveries.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('deliveries.update', $delivery->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Prix -->
                    <div class="col-md-12 mb-4">
                        <label class="form-label fw-semibold">Prix (€) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" 
                                   name="prix" 
                                   value="{{ old('prix', $delivery->prix) }}" 
                                   class="form-control @error('prix') is-invalid @enderror" 
                                   placeholder="Ex: 25.50" 
                                   step="0.01" 
                                   min="0" 
                                   max="9999999.99" 
                                   required>
                            <span class="input-group-text">€</span>
                            @error('prix')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="text-muted">Prix actuel: <strong>{{ number_format($delivery->prix, 2, ',', ' ') }} €</strong></small>
                    </div>

                    <!-- Informations supplémentaires -->
                    <div class="col-md-12 mb-4">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="card-title mb-3">Informations</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-1"><small class="text-muted">ID:</small></p>
                                        <p class="mb-0 fw-semibold">#{{ $delivery->id }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1"><small class="text-muted">Créé le:</small></p>
                                        <p class="mb-0 fw-semibold">{{ $delivery->created_at->format('d.m.Y H:i') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1"><small class="text-muted">Modifié le:</small></p>
                                        <p class="mb-0 fw-semibold">{{ $delivery->updated_at->format('d.m.Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>
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
    // Formatage automatique du prix
    document.querySelector('input[name="prix"]').addEventListener('input', function(e) {
        let value = e.target.value.replace(',', '.');
        if (value.includes('.')) {
            let parts = value.split('.');
            if (parts[1].length > 2) {
                parts[1] = parts[1].substring(0, 2);
                e.target.value = parts.join('.');
            }
        }
    });
</script>
@endpush
@endsection