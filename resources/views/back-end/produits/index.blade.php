@extends('back-end.layouts.app')

@section('content')
<section class="content-main">
    <div class="content-header d-flex justify-content-between align-items-center mb-4">
        <h2 class="content-title mb-0">Liste des produits</h2>
        <a href="{{ route('produits.create') }}" class="btn btn-primary btn-sm rounded">
            <i class="bi bi-plus-circle"></i> Ajouter produit
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nom</th>
                            <th>Sous-catégorie</th>
                            <th>Prix</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($produits as $produit)
                        <tr style="border-bottom: 1px solid #d4d4d4;">
                            <td>{{ $produit->nom }}</td>
                            <td>{{ $produit->sousCategorie->name ?? 'Non définie' }}</td>
                            <td>{{ number_format($produit->prix_ttc, 2) }} $</td>
                            <td class="text-end">
                                <a href="{{ route('produits.edit', $produit) }}" class="btn btn-sm btn-outline-primary me-1">
                                    <i class="bi bi-pencil-square"></i> Modifier
                                </a>
                                <form action="{{ route('produits.destroy', $produit) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Voulez-vous vraiment supprimer ce produit ?')">
                                        <i class="bi bi-trash3"></i> Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Aucun produit trouvé.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Pagination --}}
    @if($produits->hasPages())
    <div class="pagination-area mt-30 mb-50">
        <nav>
            <ul class="pagination justify-content-center">
                {{-- Lien précédent --}}
                @if ($produits->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">&laquo;</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $produits->previousPageUrl() }}" rel="prev">&laquo;</a>
                    </li>
                @endif

                {{-- Numéros de pages --}}
                @foreach ($produits->getUrlRange(1, $produits->lastPage()) as $page => $url)
                    @if ($page == $produits->currentPage())
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
                @if ($produits->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $produits->nextPageUrl() }}" rel="next">&raquo;</a>
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
            Affichage de {{ $produits->firstItem() ?? 0 }} à {{ $produits->lastItem() ?? 0 }} sur {{ $produits->total() }} produits
        </div>
    </div>
    @endif

</section>
@endsection