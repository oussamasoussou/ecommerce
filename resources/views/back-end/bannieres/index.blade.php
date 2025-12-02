@extends('back-end.layouts.app')

@section('content')
<section class="content-main">
    <div class="content-header d-flex justify-content-between align-items-center mb-4">
        <h2 class="content-title mb-0">Liste des bannières</h2>
        <a href="{{ route('bannieres.create') }}" class="btn btn-primary btn-sm rounded">
            <i class="bi bi-plus-circle"></i> Créer une nouvelle bannière
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width:15%;">Image</th>
                            <th style="width:20%;">Titre</th>
                            <th style="width:15%;">Position</th>
                            <th style="width:15%;">Lien</th>
                            <th style="width:10%;">Statut</th>
                            <th style="width:25%;" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bannieres as $banniere)
                        <tr style="border-bottom: 1px solid #d4d4d4;">
                            <!-- Image -->
                            <td>
                                @if($banniere->image)
                                    <img src="{{ asset('storage/' . $banniere->image) }}" 
                                         alt="Bannière"
                                         style="height: 60px; width: 100px; object-fit: cover; border-radius: 4px;">
                                @else
                                    <span class="text-muted">Aucune image</span>
                                @endif
                            </td>

                            <td>{{ $banniere->titre }}</td>
                            <td>
                                <span class="badge bg-secondary">{{ $banniere->position }}</span>
                            </td>
                            <td>
                                @if($banniere->lien)
                                    <a href="{{ $banniere->lien }}" target="_blank" class="text-truncate d-inline-block" style="max-width: 150px;">
                                        {{ Str::limit($banniere->lien, 30) }}
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('bannieres.toggle-status', $banniere->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm {{ $banniere->est_actif ? 'btn-success' : 'btn-secondary' }}">
                                        {{ $banniere->est_actif ? 'Activé' : 'Désactivé' }}
                                    </button>
                                </form>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('bannieres.edit', $banniere->id) }}" class="btn btn-sm btn-outline-primary me-1">
                                    <i class="bi bi-pencil-square"></i> Modifier
                                </a>
                                <form action="{{ route('bannieres.destroy', $banniere->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Voulez-vous vraiment supprimer cette bannière ?')">
                                        <i class="bi bi-trash3"></i> Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Aucune bannière trouvée.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Pagination --}}
    @if($bannieres->hasPages())
    <div class="pagination-area mt-30 mb-50">
        <nav>
            <ul class="pagination justify-content-center">
                {{-- Lien précédent --}}
                @if ($bannieres->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">&laquo;</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $bannieres->previousPageUrl() }}" rel="prev">&laquo;</a>
                    </li>
                @endif

                {{-- Numéros de pages --}}
                @foreach ($bannieres->getUrlRange(1, $bannieres->lastPage()) as $page => $url)
                    @if ($page == $bannieres->currentPage())
                        <li class="page-item active">
                            <span class="page-link">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach

                {{-- Lien suivant --}}
                @if ($bannieres->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $bannieres->nextPageUrl() }}" rel="next">&raquo;</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">&raquo;</span>
                    </li>
                @endif
            </ul>
        </nav>
        
        {{-- Informations de pagination --}}
        <div class="text-center text-muted mt-2">
            Affichage de {{ $bannieres->firstItem() ?? 0 }} à {{ $bannieres->lastItem() ?? 0 }} sur {{ $bannieres->total() }} bannières
        </div>
    </div>
    @endif

</section>
@endsection