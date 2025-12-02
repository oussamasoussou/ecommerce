@extends('back-end.layouts.app')

@section('content')
<section class="content-main">
    <div class="content-header d-flex justify-content-between align-items-center mb-4">
        <h2 class="content-title mb-0">Liste des slides</h2>
        <a href="{{ route('sliders.create') }}" class="btn btn-primary btn-sm rounded">
            <i class="bi bi-plus-circle"></i> Créer un nouveau slide
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
                            <th style="width:20%;">Sous-titre</th>
                            <th style="width:10%;">Ordre</th>
                            <th style="width:10%;">Statut</th>
                            <th style="width:25%;" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sliders as $slider)
                        <tr style="border-bottom: 1px solid #d4d4d4;">
                            <!-- Image -->
                            <td>
                                @if($slider->image)
                                    <img src="{{ asset('storage/' . $slider->image) }}" 
                                         alt="Slide"
                                         style="height: 60px; width: 100px; object-fit: cover; border-radius: 4px;">
                                @else
                                    <span class="text-muted">Aucune image</span>
                                @endif
                            </td>

                            <td>{{ $slider->titre }}</td>
                            <td>{{ Str::limit($slider->sous_titre, 50) ?? '-' }}</td>
                            <td>
                                <span class="badge bg-primary">{{ $slider->ordre }}</span>
                            </td>
                            <td>
                                <form action="{{ route('sliders.toggle-status', $slider->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm {{ $slider->est_actif ? 'btn-success' : 'btn-secondary' }}">
                                        {{ $slider->est_actif ? 'Activé' : 'Désactivé' }}
                                    </button>
                                </form>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('sliders.edit', $slider->id) }}" class="btn btn-sm btn-outline-primary me-1">
                                    <i class="bi bi-pencil-square"></i> Modifier
                                </a>
                                <form action="{{ route('sliders.destroy', $slider->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Voulez-vous vraiment supprimer ce slide ?')">
                                        <i class="bi bi-trash3"></i> Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Aucun slide trouvé.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Pagination --}}
    @if($sliders->hasPages())
    <div class="pagination-area mt-30 mb-50">
        <nav>
            <ul class="pagination justify-content-center">
                {{-- Lien précédent --}}
                @if ($sliders->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">&laquo;</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $sliders->previousPageUrl() }}" rel="prev">&laquo;</a>
                    </li>
                @endif

                {{-- Numéros de pages --}}
                @foreach ($sliders->getUrlRange(1, $sliders->lastPage()) as $page => $url)
                    @if ($page == $sliders->currentPage())
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
                @if ($sliders->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $sliders->nextPageUrl() }}" rel="next">&raquo;</a>
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
            Affichage de {{ $sliders->firstItem() ?? 0 }} à {{ $sliders->lastItem() ?? 0 }} sur {{ $sliders->total() }} slides
        </div>
    </div>
    @endif

</section>
@endsection