@extends('back-end.layouts.app')

@section('content')
    <section class="content-main">
        <div class="content-header d-flex justify-content-between align-items-center mb-4">
            <h2 class="content-title mb-0">Liste des catégories</h2>
            <a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm rounded">
                <i class="bi bi-plus-circle"></i> Créer une nouvelle catégorie
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
                                <th style="width:15%;">Nom</th>
                                <th style="width:45%;">Description</th>
                                <th style="width:20%;" class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                                <tr style="border-bottom: 1px solid #d4d4d4;">
                                    <td>
                                        @if($category->logo)
                                            <img src="{{ asset('storage/' . $category->logo) }}" alt="Logo"
                                                style="height: 40px; width: 40px; object-fit: contain;">
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>

                                    <!-- Image -->
                                    <td>
                                        @if($category->image)
                                            <img src="{{ asset('storage/' . $category->image) }}" alt="Image"
                                                style="height: 40px; width: 40px; object-fit: cover; border-radius: 4px;">
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="fw-semibold">{{ $category->name }}</span>
                                    </td>
                                    <td>{{ Str::limit($category->description, 50, '...') }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('categories.edit', $category->id) }}"
                                            class="btn btn-sm btn-outline-primary me-1">
                                            <i class="bi bi-pencil-square"></i> Modifier
                                        </a>
                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Voulez-vous vraiment supprimer cette catégorie ?')">
                                                <i class="bi bi-trash3"></i> Supprimer
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Aucune catégorie trouvée.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Pagination améliorée --}}
        @if($categories->hasPages())
            <div class="pagination-area mt-30 mb-50">
                <nav>
                    <ul class="pagination justify-content-center">
                        {{-- Previous Page Link --}}
                        @if ($categories->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">&laquo;</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $categories->previousPageUrl() }}" rel="prev">&laquo;</a>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($categories->getUrlRange(1, $categories->lastPage()) as $page => $url)
                            @if ($page == $categories->currentPage())
                                <li class="page-item active">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($categories->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $categories->nextPageUrl() }}" rel="next">&raquo;</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">&raquo;</span>
                            </li>
                        @endif
                    </ul>
                </nav>

                {{-- Info sur la pagination --}}
                <div class="text-center text-muted mt-2">
                    Affichage de {{ $categories->firstItem() }} à {{ $categories->lastItem() }} sur {{ $categories->total() }}
                    catégories
                </div>
            </div>
        @endif

    </section>
@endsection