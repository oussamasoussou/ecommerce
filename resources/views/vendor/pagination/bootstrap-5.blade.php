{{-- Pagination Bootstrap 5 en français (utilisée par la boutique et le back-office) --}}
@if ($paginator->hasPages())
    <nav class="d-flex justify-items-center justify-content-between" aria-label="Pagination">
        {{-- Mobile : Précédent / Suivant --}}
        <div class="d-flex justify-content-between flex-fill d-sm-none">
            <ul class="pagination">
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">&lsaquo; Précédent</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">&lsaquo; Précédent</a>
                    </li>
                @endif

                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Suivant &rsaquo;</a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">Suivant &rsaquo;</span>
                    </li>
                @endif
            </ul>
        </div>

        {{-- Écrans plus larges : résumé + numéros de page --}}
        <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between gap-3">
            <div>
                <p class="small text-muted mb-0">
                    Affichage de
                    <span class="fw-semibold">{{ $paginator->firstItem() }}</span>
                    à
                    <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
                    sur
                    <span class="fw-semibold">{{ $paginator->total() }}</span>
                    résultat{{ $paginator->total() > 1 ? 's' : '' }}
                </p>
            </div>

            <div>
                <ul class="pagination mb-0">
                    {{-- Page précédente --}}
                    @if ($paginator->onFirstPage())
                        <li class="page-item disabled" aria-disabled="true" aria-label="Page précédente">
                            <span class="page-link" aria-hidden="true">&lsaquo;</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Page précédente">&lsaquo;</a>
                        </li>
                    @endif

                    {{-- Numéros de page --}}
                    @foreach ($elements as $element)
                        {{-- Séparateur « … » --}}
                        @if (is_string($element))
                            <li class="page-item disabled" aria-disabled="true"><span class="page-link dot">{{ $element }}</span></li>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $url }}" aria-label="Page {{ $page }}">{{ $page }}</a></li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Page suivante --}}
                    @if ($paginator->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Page suivante">&rsaquo;</a>
                        </li>
                    @else
                        <li class="page-item disabled" aria-disabled="true" aria-label="Page suivante">
                            <span class="page-link" aria-hidden="true">&rsaquo;</span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
@endif
