@extends('back-end.layouts.app')

@section('content')
<section class="content-main">
    <div class="content-header d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <div>
            <h2 class="content-title mb-1">Commandes</h2>
            <p class="text-muted mb-0">{{ $counts->sum() }} commande(s) au total</p>
        </div>

        {{-- Recherche --}}
        <form method="GET" action="{{ route('admin.orders.index') }}" class="d-flex gap-2">
            @if ($status)
                <input type="hidden" name="status" value="{{ $status }}">
            @endif
            <input type="search" name="q" value="{{ $search }}" class="form-control"
                   placeholder="N°, nom ou téléphone" style="min-width: 240px;">
            <button type="submit" class="btn btn-primary">Rechercher</button>
            @if ($search !== '')
                <a href="{{ route('admin.orders.index', array_filter(['status' => $status])) }}" class="btn btn-light">Effacer</a>
            @endif
        </form>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif

    {{-- Filtres par statut --}}
    <ul class="nav nav-pills mb-3 flex-wrap gap-1">
        <li class="nav-item">
            <a class="nav-link {{ !$status ? 'active' : '' }}"
               href="{{ route('admin.orders.index', array_filter(['q' => $search])) }}">
                Toutes <span class="badge bg-light text-dark ms-1">{{ $counts->sum() }}</span>
            </a>
        </li>
        @foreach (\App\Models\Order::STATUSES as $key => $label)
            <li class="nav-item">
                <a class="nav-link {{ $status === $key ? 'active' : '' }}"
                   href="{{ route('admin.orders.index', array_filter(['status' => $key, 'q' => $search])) }}">
                    {{ $label }} <span class="badge bg-light text-dark ms-1">{{ $counts[$key] ?? 0 }}</span>
                </a>
            </li>
        @endforeach
    </ul>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>N°</th>
                            <th>Date</th>
                            <th>Client</th>
                            <th>Téléphone</th>
                            <th class="text-center">Articles</th>
                            <th class="text-end">Total</th>
                            <th>Statut</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td><strong>#{{ $order->id }}</strong></td>
                                <td>
                                    {{ $order->created_at->format('d/m/Y') }}
                                    <div class="text-muted small">{{ $order->created_at->format('H:i') }}</div>
                                </td>
                                <td>
                                    {{ $order->nom_client }}
                                    <div class="text-muted small">{{ $order->user_id ? 'Client inscrit' : 'Invité' }}</div>
                                </td>
                                <td>
                                    <a href="tel:{{ preg_replace('/[^\d+]/', '', (string) $order->telephone) }}">{{ $order->telephone }}</a>
                                </td>
                                <td class="text-center">{{ $order->items_count }}</td>
                                <td class="text-end"><strong>{{ number_format($order->total, 2, ',', ' ') }} DT</strong></td>
                                <td><span class="badge {{ $order->statusBadge() }}">{{ $order->statusLabel() }}</span></td>
                                <td class="text-end">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                        Voir
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    Aucune commande{{ $status || $search !== '' ? ' pour ce filtre' : '' }}.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @include('back-end.partials.pagination', ['paginator' => $orders])
        </div>
    </div>
</section>
@endsection
