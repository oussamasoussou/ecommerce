@extends('back-end.layouts.app')

@section('content')
<section class="content-main">
    <div class="content-header d-flex justify-content-between align-items-center mb-4">
        <h2 class="content-title mb-0">Liste des marques</h2>
        <a href="{{ route('marques.create') }}" class="btn btn-primary btn-sm rounded">
            <i class="bi bi-plus-circle"></i> Créer une nouvelle marque
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width:10%;">ID</th>
                            <th style="width:25%;">Nom</th>
                            <th style="width:20%;">Logo</th>
                            <th style="width:20%;">Date de création</th>
                            <th style="width:25%;" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($marques as $marque)
                        <tr style="border-bottom: 1px solid #d4d4d4;">
                            <td>{{ $marque->id }}</td>
                            <td>
                                <strong>{{ $marque->name }}</strong>
                            </td>
                            <td>
                                @if($marque->logo)
                                    <img src="{{ Storage::disk('public')->url($marque->logo) }}" 
                                         alt="{{ $marque->name }}" 
                                         class="rounded"
                                         style="width:50px;height:50px;object-fit:cover;">
                                @else
                                    <span class="text-muted">Aucun logo</span>
                                @endif
                            </td>
                            <td>{{ $marque->created_at->format('d.m.Y') }}</td>
                            <td class="text-end">
                                <a href="{{ route('marques.edit', $marque->id) }}" 
                                   class="btn btn-sm btn-outline-primary me-1">
                                    <i class="bi bi-pencil-square"></i> Modifier
                                </a>
                                <form action="{{ route('marques.destroy', $marque->id) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Voulez-vous vraiment supprimer cette marque ?')">
                                        <i class="bi bi-trash3"></i> Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                <i class="bi bi-inbox me-2"></i>Aucune marque trouvée.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

 

</section>
@endsection