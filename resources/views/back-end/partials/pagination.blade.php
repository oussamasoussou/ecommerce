{{-- Pagination commune des listes du back-office.
     Utilisation : @include('back-end.partials.pagination', ['paginator' => $produits])
     - plusieurs pages : résumé + numéros de page
     - une seule page  : nombre d'éléments --}}
@if ($paginator->hasPages())
    <div class="mt-3">{{ $paginator->links() }}</div>
@elseif ($paginator->total() > 0)
    <p class="small text-muted mt-3 mb-0">
        {{ $paginator->total() }} élément{{ $paginator->total() > 1 ? 's' : '' }}
    </p>
@endif
