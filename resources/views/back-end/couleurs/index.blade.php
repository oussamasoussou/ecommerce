@extends('back-end.layouts.app')

@section('content')
<section class="content-main">
    <div class="content-header d-flex justify-content-between align-items-center mb-4">
        <h2 class="content-title mb-0">Liste des couleurs</h2>
        <a href="{{ route('couleurs.create') }}" class="btn btn-primary btn-sm rounded">
            <i class="bi bi-plus-circle"></i> Créer une nouvelle couleur
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width:20%;">Nom</th>
                            <th style="width:20%;">Code Hex</th>
                            <th style="width:20%;">Aperçu</th>
                            <th style="width:20%;">Date de création</th>
                            <th style="width:20%;" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($couleurs as $couleur)
                        <tr style="border-bottom: 1px solid #d4d4d4;">
                            <td>{{ $couleur->name }}</td>
                            <td>{{ $couleur->code_hex }}</td>
                            <td>
                                <span style="display:inline-block;width:25px;height:25px;background-color:{{ $couleur->code_hex }};border:1px solid #ccc;"></span>
                                @if($couleur->image)
                                    <img src="{{ asset('storage/' . $couleur->image) }}" alt="logo" style="width:25px;height:25px;">
                                @endif
                            </td>
                            <td>{{ $couleur->created_at->format('d.m.Y') }}</td>
                            <td class="text-end">
                                <a href="{{ route('couleurs.edit', $couleur->id) }}" class="btn btn-sm btn-outline-primary me-1">
                                    <i class="bi bi-pencil-square"></i> Modifier
                                </a>
                                <form action="{{ route('couleurs.destroy', $couleur->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Voulez-vous vraiment supprimer cette couleur ?')">
                                        <i class="bi bi-trash3"></i> Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Aucune couleur trouvée.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Pagination --}}
    @if($couleurs->hasPages())
    <div class="pagination-area mt-30 mb-50">
        <nav>
            <ul class="pagination justify-content-center">
                {{-- Lien précédent --}}
                @if ($couleurs->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">&laquo;</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $couleurs->previousPageUrl() }}" rel="prev">&laquo;</a>
                    </li>
                @endif

                {{-- Numéros de pages --}}
                @foreach ($couleurs->getUrlRange(1, $couleurs->lastPage()) as $page => $url)
                    @if ($page == $couleurs->currentPage())
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
                @if ($couleurs->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $couleurs->nextPageUrl() }}" rel="next">&raquo;</a>
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
            Affichage de {{ $couleurs->firstItem() ?? 0 }} à {{ $couleurs->lastItem() ?? 0 }} sur {{ $couleurs->total() }} couleurs
        </div>
    </div>
    @endif

</section>
@endsection