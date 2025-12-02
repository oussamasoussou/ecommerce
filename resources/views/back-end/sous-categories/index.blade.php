@extends('back-end.layouts.app')

@section('content')
<section class="content-main">
    <div class="content-header d-flex justify-content-between align-items-center mb-4">
        <h2 class="content-title mb-0">Liste des sous-catégories</h2>
        <a href="{{ route('souscategories.create') }}" class="btn btn-primary btn-sm rounded">
            <i class="bi bi-plus-circle"></i> Créer une nouvelle sous-catégorie
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width:10%;">Logo</th>
                            <th style="width:10%;">Image</th>
                            <th style="width:20%;">Nom</th>
                            <th style="width:20%;">Description</th>
                            <th style="width:20%;">Catégorie parente</th>
                            <th style="width:20%;" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sousCategories as $sc)
                        <tr style="border-bottom: 1px solid #d4d4d4;">
                                  <td>
                                    @if($sc->logo)
                                        <img src="{{ asset('storage/' . $sc->logo) }}" 
                                             alt="Logo"
                                             style="height: 40px; width: 40px; object-fit: contain;">
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>

                                <!-- Image -->
                                <td>
                                    @if($sc->image)
                                        <img src="{{ asset('storage/' . $sc->image) }}" 
                                             alt="Image"
                                             style="height: 40px; width: 40px; object-fit: cover; border-radius: 4px;">
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>

                            <td>{{ $sc->name }}</td>
                            <td>{{ Str::limit($sc->description, 50, '...') }}</td>
                            <td>{{ $sc->category->name ?? 'Non définie' }}</td>
                            <td class="text-end">
                                <a href="{{ route('souscategories.edit', $sc->id) }}" class="btn btn-sm btn-outline-primary me-1">
                                    <i class="bi bi-pencil-square"></i> Modifier
                                </a>
                                <form action="{{ route('souscategories.destroy', $sc->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Voulez-vous vraiment supprimer cette sous-catégorie ?')">
                                        <i class="bi bi-trash3"></i> Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Aucune sous-catégorie trouvée.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Pagination --}}
    @if($sousCategories->hasPages())
    <div class="pagination-area mt-30 mb-50">
        <nav>
            <ul class="pagination justify-content-center">
                {{-- Lien précédent --}}
                @if ($sousCategories->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">&laquo;</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $sousCategories->previousPageUrl() }}" rel="prev">&laquo;</a>
                    </li>
                @endif

                {{-- Numéros de pages --}}
                @foreach ($sousCategories->getUrlRange(1, $sousCategories->lastPage()) as $page => $url)
                    @if ($page == $sousCategories->currentPage())
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
                @if ($sousCategories->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $sousCategories->nextPageUrl() }}" rel="next">&raquo;</a>
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
            Affichage de {{ $sousCategories->firstItem() ?? 0 }} à {{ $sousCategories->lastItem() ?? 0 }} sur {{ $sousCategories->total() }} sous-catégories
        </div>
    </div>
    @endif

</section>
@endsection