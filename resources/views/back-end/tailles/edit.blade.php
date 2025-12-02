@extends('back-end.layouts.app')

@section('content')
<section class="content-main">
    <div class="content-header d-flex justify-content-between align-items-center mb-4">
        <h2 class="content-title mb-0">Modifier la taille</h2>
        <a href="{{ route('tailles.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('tailles.update', $taille->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <!-- Nom -->
                    <div class="col-md-12 mb-4">
                        <label class="form-label fw-semibold">Nom <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $taille->name) }}" 
                               class="form-control @error('name') is-invalid @enderror" 
                               placeholder="Nom de la taille" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
@endsection
