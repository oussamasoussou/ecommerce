@extends('back-end.layouts.app')

@section('content')
<section class="content-main">
    <div class="content-header d-flex justify-content-between align-items-center mb-4">
        <h2 class="content-title mb-0">Ajouter un prix de livraison</h2>
        <a href="{{ route('deliveries.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('deliveries.store') }}" method="POST">
                @csrf

                <div class="row">
                    <!-- Prix -->
                    <div class="col-md-12 mb-4">
                        <label class="form-label fw-semibold" for="prix">Prix (DT) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number"
                                   id="prix"
                                   name="prix"
                                   value="{{ old('prix') }}"
                                   class="form-control @error('prix') is-invalid @enderror"
                                   placeholder="Ex: 7.00"
                                   step="0.01"
                                   min="0"
                                   max="9999999.99"
                                   required
                                   autofocus>
                            <span class="input-group-text">DT</span>
                            @error('prix')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-check-circle"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

@push('scripts')
<script>
    // Limite le prix à 2 décimales
    document.querySelector('input[name="prix"]').addEventListener('input', function (e) {
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
