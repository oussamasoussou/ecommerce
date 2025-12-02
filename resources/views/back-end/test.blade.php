@extends('back-end.layouts.app')

@section('content')
<section class="content-main">
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Liste des tailles</h2>
        </div>
        <div>
            <a href="#" class="btn btn-primary btn-sm rounded">Créer une nouvelle taille</a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 20%;">Nom</th>
                        <th style="width: 50%;">Description</th>
                        <th>Date de création</th>
                        <th style="width: 20%;" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Small</td>
                        <td>Petite taille adaptée pour t-shirts et vêtements fins.</td>
                        <td>16.10.2025</td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-brand"><i class="material-icons md-edit"></i> Modifier</a>
                            <a href="#" class="btn btn-sm btn-light"><i class="material-icons md-delete_forever"></i> Supprimer</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Medium</td>
                        <td>Taille moyenne pour t-shirts, chemises et pantalons.</td>
                        <td>15.10.2025</td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-brand"><i class="material-icons md-edit"></i> Modifier</a>
                            <a href="#" class="btn btn-sm btn-light"><i class="material-icons md-delete_forever"></i> Supprimer</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Large</td>
                        <td>Taille large pour vêtements amples et confortables.</td>
                        <td>14.10.2025</td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-brand"><i class="material-icons md-edit"></i> Modifier</a>
                            <a href="#" class="btn btn-sm btn-light"><i class="material-icons md-delete_forever"></i> Supprimer</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
