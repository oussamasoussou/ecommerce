{{-- Affiche une information de config/shop.php, ou un repère « à compléter » si elle est vide.
     Utilisation : <x-shop-info key="phone" /> --}}
@props(['key'])
@php($value = config('shop.' . $key))
@if (filled($value)){{ $value }}@else<span class="todo">[à compléter]</span>@endif
