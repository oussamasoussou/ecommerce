<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <title>Nest - Multipurpose eCommerce HTML Template</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:title" content="" />
    <meta property="og:type" content="" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/imgs/theme/favicon.svg') }}" />
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('front-end/css/plugins/animate.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('front-end/css/main.css?v=6.1') }}" />

    <!-- Ajoutez dans la section <head> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Ajoutez avant la fermeture de </body> -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <style>

        
        /* Styles pour le modal d'ajout au panier */
        #addToCartModal .modal-content {
            border-radius: 15px;
            overflow: hidden;
            border: none;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        #addToCartModal .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 1.5rem;
        }

        #addToCartModal .btn-close-white {
            filter: brightness(0) invert(1);
            opacity: 0.8;
        }

        #addToCartModal .btn-close-white:hover {
            opacity: 1;
        }

        /* Image du produit */
        .product-modal-image {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 500px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* Options de couleur */
        .color-option {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 3px solid transparent;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .color-option:hover {
            transform: scale(1.1);
            border-color: #dee2e6;
        }

        .color-option.selected {
            border-color: #3bb77e;
            box-shadow: 0 0 0 2px rgba(59, 183, 126, 0.3);
        }

        .color-option.selected::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 14px;
            font-weight: bold;
            text-shadow: 0 0 3px rgba(0, 0, 0, 0.5);
        }

        /* Options de taille */
        .size-option {
            min-width: 60px;
            height: 40px;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            background: white;
            color: #495057;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 15px;
        }

        .size-option:hover:not(.selected) {
            border-color: #3bb77e;
            color: #3bb77e;
            transform: translateY(-2px);
        }

        .size-option.selected {
            background: #3bb77e;
            border-color: #3bb77e;
            color: white;
            box-shadow: 0 4px 12px rgba(59, 183, 126, 0.3);
        }

        .size-option.disabled {
            background: #f8f9fa;
            border-color: #dee2e6;
            color: #adb5bd;
            cursor: not-allowed;
            opacity: 0.6;
        }

        /* Sélecteur de quantité */
        .quantity-selector {
            background: white;
            border: 2px solid #e9ecef !important;
        }

        .quantity-selector:hover {
            border-color: #3bb77e !important;
        }

        .qty-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            font-size: 18px;
            transition: all 0.3s ease;
        }

        .qty-btn:hover {
            background: #f8f9fa;
            color: #3bb77e;
        }

        .qty-btn:active {
            transform: scale(0.95);
        }

        #modal_product_qty {
            font-size: 1.1rem;
            font-weight: bold;
            color: #212529;
        }

        #modal_product_qty:focus {
            outline: none;
            box-shadow: none;
        }

        /* Boutons */
        .btn-primary {
            background: linear-gradient(135deg, #3bb77e 0%, #2a9d68 100%);
            border: none;
            border-radius: 10px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(59, 183, 126, 0.3);
        }

        .btn-outline-primary {
            border: 2px solid #3bb77e;
            color: #3bb77e;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background: #3bb77e;
            color: white;
            transform: translateY(-2px);
        }

        /* Informations supplémentaires */
        .additional-info {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1rem;
        }

        .additional-info i {
            color: #3bb77e;
        }

        /* Badge promotion */
        #modal_promo_badge {
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        /* Animation d'apparition */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        #addToCartModal .modal-content {
            animation: fadeInUp 0.4s ease;
        }

        /* Responsive */
        @media (max-width: 768px) {
            #addToCartModal .modal-dialog {
                margin: 0.5rem;
            }

            .product-modal-image {
                min-height: 300px;
                padding: 1rem !important;
            }

            .product-modal-info {
                padding: 1rem !important;
            }

            .action-buttons .col-8,
            .action-buttons .col-4 {
                width: 100% !important;
                margin-bottom: 0.5rem;
            }
        }

        /* Animation du bouton ajouter au panier */
        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        #addToCartModalForm button[type="submit"]:hover {
            animation: pulse 0.5s ease;
        }

        /* Style pour le texte économies */
        #modal_savings .savings-amount {
            background: #ff6b6b;
            color: white;
            padding: 2px 8px;
            border-radius: 4px;
            font-weight: 600;
            margin-left: 5px;
        }

        /* Miniatures d'images */
        .image-thumbnails .thumbnail {
            width: 60px;
            height: 60px;
            border: 2px solid transparent;
            border-radius: 8px;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 0 5px;
        }

        .image-thumbnails .thumbnail:hover {
            border-color: #dee2e6;
        }

        .image-thumbnails .thumbnail.active {
            border-color: #3bb77e;
            box-shadow: 0 0 0 2px rgba(59, 183, 126, 0.2);
        }

        /* Scroll personnalisé pour le modal */
        .modal-body::-webkit-scrollbar {
            width: 8px;
        }

        .modal-body::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .modal-body::-webkit-scrollbar-thumb {
            background: #3bb77e;
            border-radius: 4px;
        }

        .modal-body::-webkit-scrollbar-thumb:hover {
            background: #2a9d68;
        }

        /* Dans app.blade.php, dans la section <style> */
        .cart-total-update {
            animation: priceUpdate 0.5s ease;
        }

        @keyframes priceUpdate {
            0% {
                transform: scale(1);
                color: inherit;
            }

            50% {
                transform: scale(1.2);
                color: #3bb77e;
            }

            100% {
                transform: scale(1);
                color: inherit;
            }
        }

        .quantity .btn {
            transition: all 0.2s;
        }

        .quantity .btn:active {
            transform: scale(0.95);
        }

        .qty-input {
            transition: border-color 0.3s;
        }

        .qty-input:focus {
            border-color: #3bb77e;
            box-shadow: 0 0 0 0.2rem rgba(59, 183, 126, 0.25);
        }


        /* Ajoutez dans le <style> de app.blade.php */
        .color-option {
            transition: all 0.3s ease;
        }

        .color-option:hover {
            transform: scale(1.1);
        }

        .color-option.selected {
            border: 3px solid #3bb77e !important;
            box-shadow: 0 0 5px rgba(59, 183, 126, 0.5);
        }

        .size-option.btn-primary {
            background-color: #3bb77e !important;
            border-color: #3bb77e !important;
            color: white !important;
        }

        .size-option.btn-outline-secondary {
            border-color: #ddd !important;
            color: #666 !important;
        }

        .size-option {
            min-width: 50px !important;
            padding: 8px 15px !important;
            margin: 3px !important;
            border-radius: 5px !important;
            font-weight: 500 !important;
        }

        #color_options,
        #size_options {
            min-height: 60px;
        }

        #variant_error,
        #color_error,
        #size_error {
            padding: 8px 12px;
            border-radius: 4px;
            margin-top: 5px;
        }

        #color_error,
        #size_error {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
        }

        #variant_error {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
        }

        /* Styles pour le panier */
        .cart-table {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
        }

        .cart-table thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .cart-table th {
            border: none;
            padding: 15px;
            font-weight: 600;
        }

        .cart-table td {
            vertical-align: middle;
            padding: 20px 15px;
            border-bottom: 1px solid #eee;
        }

        .cart-table tr:last-child td {
            border-bottom: none;
        }

        .quantity .btn {
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .quantity .form-control {
            border-left: 0;
            border-right: 0;
            border-radius: 0;
        }

        .btn-remove {
            transition: all 0.3s;
        }

        .btn-remove:hover {
            transform: scale(1.1);
        }

        /* Animation pour le panier */
        @keyframes cartBounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-5px);
            }
        }

        .cart-count {
            animation: cartBounce 0.5s ease;
        }

        /* Animation du panier */
        @keyframes cartBounce {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.2);
            }
        }

        .header-action-icon-2 .mini-cart-icon.animate {
            animation: cartBounce 0.5s ease;
        }

        /* Style pour le panier */
        .cart-qty {
            width: 60px;
            height: 40px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .remove-cart-item:hover {
            color: #ff0000 !important;
        }

        .cart-totals {
            background: #f8f9fa;
            border-radius: 10px;
        }

        .cart-table th {
            background: #f8f9fa;
            font-weight: 600;
        }

        /* Style pour les miniatures */
        .slider-nav-thumbnails {
            display: flex;
            gap: 10px;
            margin-top: 15px;
            overflow-x: auto;
        }

        .thumbnail-item {
            width: 80px;
            height: 80px;
            cursor: pointer;
            border: 2px solid transparent;
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        .thumbnail-item.active {
            border-color: #3bb77e;
            /* Couleur de votre thème */
        }

        .thumbnail-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Cacher toutes les images du slider principal sauf l'active */
        .main-slide {
            display: none;
        }

        .main-slide.active {
            display: block;
        }

        /* Ajoutez ceci dans votre fichier CSS */
        .product-image-slider img {
            max-height: 600px;
            /* Ajustez cette valeur selon vos besoins */
            width: auto;
            margin: 0 auto;
            object-fit: contain;
        }

        .product-image-slider figure {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 600px;
            /* Hauteur fixe pour le conteneur */
        }


        .product-title {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            width: 100%;
            margin: 0;
        }

        .product-title a {
            display: block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            text-decoration: none;
            color: inherit;
        }

        .green-logo {
            filter: brightness(0) saturate(100%) invert(47%) sepia(90%) saturate(400%) hue-rotate(90deg) brightness(95%) contrast(85%);
        }

        .quick-view-btn {
            cursor: pointer;
        }

        .product-image-slider img {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .thumb-gallery {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .thumb-gallery img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
            cursor: pointer;
            border: 2px solid transparent;
        }

        .thumb-gallery img.active {
            border-color: #3BB77E;
        }

        .detail-qty {
            display: inline-flex;
            align-items: center;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
        }

        .detail-qty a {
            padding: 0 10px;
            color: #666;
            text-decoration: none;
        }

        .detail-qty .qty-val {
            padding: 0 15px;
            font-weight: bold;
        }

        .old-price {
            text-decoration: line-through;
            color: #999;
            margin-left: 10px;
        }

        .button-add-to-cart {
            background: #3BB77E;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }

        .button-add-to-cart:hover {
            background: #2a9d68;
        }

        /* Styles pour les bannières */
        .banners .banner-img {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
        }

        .banners .banner-img img {
            width: 100%;
            height: auto;
            transition: transform 0.3s ease;
        }

        .banners .banner-img:hover img {
            transform: scale(1.05);
        }

        .banners .banner-text {
            position: absolute;
            top: 50%;
            left: 30px;
            transform: translateY(-50%);
            color: #fff;
        }

        .banners .banner-text h4 {
            font-size: 24px;
            font-weight: 700;
            line-height: 1.3;
            margin-bottom: 15px;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
        }

        .banners .btn-xs {
            background: #fff;
            color: #333;
            padding: 8px 15px;
            border-radius: 5px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .banners .btn-xs:hover {
            background: #2B38D1;
            color: #fff;
            transform: translateX(5px);
        }
    </style>

</head>

<body>
    @include('front-end.partials.header')
    <main class="main">
        @yield('content')
    </main>
    @include('front-end.partials.footer')

    @include('front-end.modals.add-to-cart')


    <!-- Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="text-center">
                    <img src=" {{ asset('front-end/imgs/theme/loading.gif') }}" alt="" />
                </div>
            </div>
        </div>
    </div>

    <script>
        // Sélection/désélection de tous les produits
        document.getElementById('exampleCheckbox11').addEventListener('change', function () {
            const checkboxes = document.querySelectorAll('input[type="checkbox"][name="checkbox"]:not(#exampleCheckbox11)');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    </script>

    <!-- Vendor JS-->
    <script>
        function togglePasswordVisibility(fieldId) {
            const passwordField = document.getElementById(fieldId);
            const iconElement = passwordField.nextElementSibling.querySelector('i');

            if (passwordField.type === "password") {
                passwordField.type = "text";
                iconElement.classList.remove('fi-rs-eye');
                iconElement.classList.add('fi-rs-eye-crossed'); // Supposons que vous ayez une icône "œil barré"
            } else {
                passwordField.type = "password";
                iconElement.classList.remove('fi-rs-eye-crossed');
                iconElement.classList.add('fi-rs-eye');
            }
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Gestion des boutons de vue rapide
            const quickViewButtons = document.querySelectorAll('.quick-view-btn');

            quickViewButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const productId = this.getAttribute('data-product-id');
                    const productName = this.getAttribute('data-product-name');
                    const productImage = this.getAttribute('data-product-image');
                    const productPrice = this.getAttribute('data-product-price');
                    const productOldPrice = this.getAttribute('data-product-old-price');
                    const productDescription = this.getAttribute('data-product-description');
                    const productCategory = this.getAttribute('data-product-category');
                    const productSubCategory = this.getAttribute('data-product-subcategory');
                    const productStock = this.getAttribute('data-product-stock');
                    const productLink = this.getAttribute('data-product-link');

                    // Mettre à jour le contenu de la modal
                    document.getElementById('quickViewTitle').textContent = productName;
                    document.getElementById('quickViewImage').src = productImage;
                    document.getElementById('quickViewPrice').textContent = productPrice + ' €';
                    document.getElementById('quickViewDescription').textContent = productDescription;
                    document.getElementById('quickViewCategory').textContent = productCategory;
                    document.getElementById('quickViewSubCategory').textContent = productSubCategory;
                    document.getElementById('quickViewStock').textContent = productStock;
                    document.getElementById('quickViewLink').href = productLink;

                    // Gérer l'ancien prix
                    const oldPriceElement = document.getElementById('quickViewOldPrice');
                    if (productOldPrice) {
                        oldPriceElement.textContent = productOldPrice + ' €';
                        oldPriceElement.style.display = 'inline-block';
                    } else {
                        oldPriceElement.style.display = 'none';
                    }

                    // Gestion de la quantité
                    const qtyVal = document.querySelector('.qty-val');
                    const qtyDown = document.querySelector('.qty-down');
                    const qtyUp = document.querySelector('.qty-up');

                    qtyDown.addEventListener('click', function (e) {
                        e.preventDefault();
                        let currentQty = parseInt(qtyVal.textContent);
                        if (currentQty > 1) {
                            qtyVal.textContent = currentQty - 1;
                        }
                    });

                    qtyUp.addEventListener('click', function (e) {
                        e.preventDefault();
                        let currentQty = parseInt(qtyVal.textContent);
                        qtyVal.textContent = currentQty + 1;
                    });

                    // Bouton ajouter au panier
                    const addToCartBtn = document.querySelector('.button-add-to-cart');
                    addToCartBtn.addEventListener('click', function () {
                        const quantity = parseInt(qtyVal.textContent);

                        // Ici vous pouvez ajouter la logique pour ajouter au panier
                        console.log('Ajouter au panier:', productId, quantity);

                        // Exemple avec AJAX
                        fetch('{{ route("cart.add") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                product_id: productId,
                                quantity: quantity
                            })
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Afficher un message de succès
                                    alert('Produit ajouté au panier !');
                                }
                            })
                            .catch(error => {
                                console.error('Erreur:', error);
                            });
                    });
                });
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            // Gestion du clic sur les miniatures
            $('.thumbnail-item').on('click', function () {
                var index = $(this).data('index');

                // Retirer la classe active de toutes les miniatures
                $('.thumbnail-item').removeClass('active');

                // Ajouter la classe active à la miniature cliquée
                $(this).addClass('active');

                // Cacher toutes les images du slider principal
                $('.main-slide').removeClass('active');

                // Afficher l'image correspondante
                $('.main-slide[data-index="' + index + '"]').addClass('active');
            });

            // Optionnel : Ajouter un effet hover sur les miniatures
            $('.thumbnail-item').hover(
                function () {
                    $(this).css('opacity', '0.8');
                },
                function () {
                    $(this).css('opacity', '1');
                }
            );
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Mise à jour de la quantité via AJAX
            document.querySelectorAll('.cart-qty').forEach(input => {
                input.addEventListener('change', function () {
                    const cartId = this.dataset.cartId;
                    const quantity = this.value;

                    fetch(`/cart/${cartId}/update`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ quantite: quantity })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Mettre à jour le total de l'article
                                document.querySelector(`.cart-total-${cartId}`).textContent =
                                    `${parseFloat(data.prix_total).toFixed(2).replace('.', ',')} €`;

                                // Mettre à jour le sous-total
                                document.getElementById('subtotal').textContent =
                                    `${parseFloat(data.cart_total).toFixed(2).replace('.', ',')} €`;
                                document.getElementById('grand-total').textContent =
                                    `${parseFloat(data.cart_total).toFixed(2).replace('.', ',')} €`;

                                // Mettre à jour le compteur du panier dans le header
                                document.querySelectorAll('.cart-count').forEach(el => {
                                    el.textContent = data.cart_count || 0;
                                });

                                showNotification('success', 'Quantité mise à jour');
                            } else {
                                showNotification('error', data.message || 'Erreur lors de la mise à jour');
                                this.value = this.defaultValue;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showNotification('error', 'Une erreur est survenue');
                        });
                });
            });

            // Supprimer un article
            document.querySelectorAll('.remove-cart-item').forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    const cartId = this.dataset.cartId;

                    if (confirm('Êtes-vous sûr de vouloir retirer cet article du panier ?')) {
                        fetch(`/cart/${cartId}/remove`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Supprimer la ligne du tableau
                                    document.querySelector(`.cart-item-${cartId}`).remove();

                                    // Mettre à jour les totaux
                                    if (document.querySelectorAll('.cart-item').length === 0) {
                                        location.reload(); // Recharger si panier vide
                                    } else {
                                        // Mettre à jour les totaux généraux
                                        fetch('/cart/total')
                                            .then(res => res.json())
                                            .then(totalData => {
                                                document.getElementById('subtotal').textContent =
                                                    `${parseFloat(totalData.total).toFixed(2).replace('.', ',')} €`;
                                                document.getElementById('grand-total').textContent =
                                                    `${parseFloat(totalData.total).toFixed(2).replace('.', ',')} €`;
                                            });
                                    }

                                    // Mettre à jour le compteur
                                    fetch('/cart/count')
                                        .then(res => res.json())
                                        .then(countData => {
                                            document.querySelectorAll('.cart-count').forEach(el => {
                                                el.textContent = countData.count || 0;
                                            });
                                        });

                                    showNotification('success', data.message);
                                }
                            });
                    }
                });
            });

            // Vider le panier
            document.getElementById('clear-cart')?.addEventListener('click', function () {
                if (confirm('Êtes-vous sûr de vouloir vider votre panier ?')) {
                    fetch('{{ route("cart.clear") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                location.reload();
                            }
                        });
                }
            });

            function showNotification(type, message) {
                // Vous pouvez utiliser Toastr, SweetAlert ou une simple alerte
                alert(message);
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            console.log('Script panier chargé');

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const baseUrl = window.location.origin;

            // Fonction pour afficher les notifications
            function showNotification(type, message) {
                // Utilisez Toastr si disponible, sinon une alerte simple
                if (typeof toastr !== 'undefined') {
                    toastr[type](message);
                } else {
                    alert(message);
                }
            }

            // Fonction pour mettre à jour les totaux dans l'interface
            function updateCartTotals(data) {
                // Mettre à jour le sous-total
                const subtotalElement = document.getElementById('cart-subtotal');
                if (subtotalElement && data.cart_total !== undefined) {
                    subtotalElement.textContent = parseFloat(data.cart_total).toFixed(2).replace('.', ',') + ' €';
                }

                // Mettre à jour le total général
                const grandTotalElement = document.getElementById('cart-grand-total');
                if (grandTotalElement && data.cart_total !== undefined) {
                    grandTotalElement.textContent = parseFloat(data.cart_total).toFixed(2).replace('.', ',') + ' €';
                }

                // Mettre à jour le compteur dans le header
                document.querySelectorAll('.cart-count').forEach(el => {
                    if (data.cart_count !== undefined) {
                        el.textContent = data.cart_count;
                    }
                });

                // Mettre à jour le compteur local dans la page panier
                const cartCountElement = document.querySelector('.text-muted.mr-20');
                if (cartCountElement && data.cart_count !== undefined) {
                    cartCountElement.innerHTML = `<i class="fi-rs-shopping-cart mr-5"></i>${data.cart_count} article(s)`;
                }
            }

            // Mettre à jour la quantité (AJAX)
            async function updateQuantity(cartId, quantity) {
                try {
                    console.log(`Mise à jour quantité: cartId=${cartId}, quantity=${quantity}`);

                    const response = await fetch(`${baseUrl}/cart/${cartId}/update`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ quantite: quantity })
                    });

                    const data = await response.json();
                    console.log('Réponse mise à jour:', data);

                    if (data.success) {
                        // Mettre à jour le total de l'article dans le tableau
                        const totalElement = document.querySelector(`.cart-total-${cartId}`);
                        if (totalElement && data.prix_total !== undefined) {
                            totalElement.textContent = parseFloat(data.prix_total).toFixed(2).replace('.', ',') + ' €';
                        }

                        // Mettre à jour les totaux généraux
                        updateCartTotals(data);

                        showNotification('success', 'Quantité mise à jour');
                        return true;
                    } else {
                        showNotification('error', data.message || 'Erreur lors de la mise à jour');
                        return false;
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showNotification('error', 'Une erreur est survenue lors de la mise à jour');
                    return false;
                }
            }

            // Gestion des boutons plus/moins (délégation d'événements)
            document.addEventListener('click', function (e) {
                // Bouton PLUS
                if (e.target.closest('.btn-plus') || (e.target.classList && e.target.classList.contains('btn-plus'))) {
                    e.preventDefault();
                    const btn = e.target.closest('.btn-plus') || e.target;
                    const cartId = btn.dataset.cartId;
                    const input = document.querySelector(`.qty-input[data-cart-id="${cartId}"]`);

                    if (input) {
                        const max = parseInt(input.max);
                        let newQty = parseInt(input.value) + 1;

                        if (newQty <= max) {
                            input.value = newQty;
                            updateQuantity(cartId, newQty);
                        } else {
                            showNotification('warning', 'Quantité maximale atteinte');
                        }
                    }
                }

                // Bouton MOINS
                if (e.target.closest('.btn-minus') || (e.target.classList && e.target.classList.contains('btn-minus'))) {
                    e.preventDefault();
                    const btn = e.target.closest('.btn-minus') || e.target;
                    const cartId = btn.dataset.cartId;
                    const input = document.querySelector(`.qty-input[data-cart-id="${cartId}"]`);

                    if (input) {
                        let newQty = parseInt(input.value) - 1;

                        if (newQty >= 1) {
                            input.value = newQty;
                            updateQuantity(cartId, newQty);
                        }
                    }
                }
            });

            // Changement direct dans l'input
            document.addEventListener('change', function (e) {
                if (e.target.classList && e.target.classList.contains('qty-input')) {
                    const input = e.target;
                    const cartId = input.dataset.cartId;
                    const quantity = parseInt(input.value);
                    const max = parseInt(input.max);

                    if (quantity >= 1 && quantity <= max) {
                        updateQuantity(cartId, quantity);
                    } else {
                        showNotification('warning', 'Quantité invalide');
                        // Revenir à la valeur précédente
                        input.value = input.defaultValue || 1;
                    }
                }
            });

            // Supprimer un article
            document.addEventListener('click', function (e) {
                if (e.target.closest('.btn-remove') || (e.target.classList && e.target.classList.contains('btn-remove'))) {
                    e.preventDefault();
                    const btn = e.target.closest('.btn-remove') || e.target;
                    const cartId = btn.dataset.cartId;

                    if (confirm('Êtes-vous sûr de vouloir retirer cet article du panier ?')) {
                        fetch(`${baseUrl}/cart/${cartId}/remove`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            }
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Supprimer la ligne du tableau
                                    const row = document.querySelector(`.cart-item-${cartId}`);
                                    if (row) {
                                        row.remove();
                                    }

                                    // Mettre à jour les totaux
                                    updateCartTotals(data);

                                    // Vérifier si le panier est vide
                                    if (data.cart_count === 0) {
                                        setTimeout(() => location.reload(), 1000);
                                    }

                                    showNotification('success', data.message || 'Article retiré du panier');
                                } else {
                                    showNotification('error', data.message || 'Erreur lors de la suppression');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                showNotification('error', 'Une erreur est survenue lors de la suppression');
                            });
                    }
                }
            });

            // Vider le panier
            const clearCartBtn = document.getElementById('clear-cart');
            if (clearCartBtn) {
                clearCartBtn.addEventListener('click', function (e) {
                    e.preventDefault();

                    if (confirm('Êtes-vous sûr de vouloir vider complètement votre panier ? Cette action est irréversible.')) {
                        fetch(`${baseUrl}/cart/clear`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            }
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Recharger la page pour vider complètement
                                    location.reload();
                                } else {
                                    showNotification('error', 'Erreur lors du vidage du panier');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                showNotification('error', 'Une erreur est survenue');
                            });
                    }
                });
            }

            console.log('Gestionnaire de panier initialisé');
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('add-to-cart-form');
            const variantSelect = document.getElementById('variant_id');
            const qtyInput = document.getElementById('product-qty');

            // Si le produit a des variantes, mettre à jour le stock max
            if (variantSelect) {
                variantSelect.addEventListener('change', function () {
                    const selectedOption = this.options[this.selectedIndex];
                    if (selectedOption.value) {
                        const stock = parseInt(selectedOption.dataset.stock);
                        qtyInput.max = stock;
                        if (qtyInput.value > stock) {
                            qtyInput.value = stock;
                        }
                    }
                });
            }

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                // Validation
                if (variantSelect && !variantSelect.value) {
                    alert('Veuillez sélectionner une option');
                    return;
                }

                // Soumission AJAX
                const formData = new FormData(this);

                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Mettre à jour le compteur du panier
                            document.querySelectorAll('.cart-count').forEach(el => {
                                el.textContent = data.cart_count;
                            });

                            // Notification
                            alert(data.message);

                            // Redirection optionnelle
                            // window.location.href = '{{ route("cart.index") }}';
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Une erreur est survenue');
                    });
            });
        });
    </script>
   <script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Script panier global chargé');
    
    // ------------------------------------------------------------
    // 1. GESTION DU PANIER DANS LE HEADER (mini-panier)
    // ------------------------------------------------------------
    
    // Fonction pour mettre à jour le compteur du panier
    function updateCartCount(count) {
        // Mettre à jour tous les compteurs de panier
        document.querySelectorAll('.cart-count').forEach(el => {
            el.textContent = count || 0;
        });
        
        // Mettre à jour le mini-panier dans le header
        updateMiniCart();
    }
    
    // Fonction pour mettre à jour le contenu du mini-panier
    function updateMiniCart() {
        // Optionnel: Recharger dynamiquement le contenu du mini-panier
        // fetch('/cart/mini-cart')
        //     .then(response => response.text())
        //     .then(html => {
        //         document.getElementById('mini-cart-items').innerHTML = html;
        //     });
    }
    
    // Fonction pour animer l'icône du panier
    function animateCartIcon() {
        const cartIcons = document.querySelectorAll('.mini-cart-icon');
        cartIcons.forEach(icon => {
            icon.classList.add('animate');
            setTimeout(() => {
                icon.classList.remove('animate');
            }, 500);
        });
    }
    
    // Gestion de la suppression dans le mini-panier
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-mini-cart')) {
            e.preventDefault();
            const removeBtn = e.target.closest('.remove-mini-cart');
            const cartId = removeBtn.dataset.cartId;
            
            if (confirm('Retirer cet article du panier ?')) {
                fetch(`/cart/${cartId}/remove`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Supprimer l'élément du DOM
                        const listItem = removeBtn.closest('li');
                        if (listItem) {
                            listItem.remove();
                        }
                        
                        // Mettre à jour le compteur
                        updateCartCount(data.cart_count);
                        
                        // Vérifier si le panier est vide
                        const miniCartItems = document.getElementById('mini-cart-items');
                        if (miniCartItems && miniCartItems.children.length === 0) {
                            miniCartItems.innerHTML = `
                                <li class="text-center py-3">
                                    <p class="text-muted">Votre panier est vide</p>
                                    <a href="{{ route('shop.index') }}" class="btn btn-sm btn-fill-out">
                                        Commencer les achats
                                    </a>
                                </li>
                            `;
                        }
                        
                        showSuccessMessage('Article retiré du panier');
                    } else {
                        showErrorMessage(data.message);
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    showErrorMessage('Erreur lors de la suppression');
                });
            }
        }
    });
    
    // ------------------------------------------------------------
    // 2. GESTION DES FORMULAIRES SIMPLES D'AJOUT AU PANIER
    // ------------------------------------------------------------
    
    document.addEventListener('submit', function(e) {
        if (e.target && e.target.classList.contains('add-to-cart-form')) {
            e.preventDefault();
            
            const form = e.target;
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            // Désactiver le bouton pendant la requête
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fi-rs-loading mr-5"></i>Ajout...';
            
            // Récupérer les données du formulaire
            const formData = new FormData(form);
            
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Mettre à jour le compteur du panier
                    updateCartCount(data.cart_count);
                    
                    // Animer l'icône du panier
                    animateCartIcon();
                    
                    // Afficher un message de succès
                    showSuccessMessage('Produit ajouté au panier !');
                } else {
                    // Afficher un message d'erreur
                    showErrorMessage(data.message || 'Erreur lors de l\'ajout au panier');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                showErrorMessage('Une erreur est survenue');
            })
            .finally(() => {
                // Réactiver le bouton
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
        }
    });
    
    // ------------------------------------------------------------
    // 3. GESTION DES FORMULAIRES SUR LA PAGE DE DÉTAIL
    // ------------------------------------------------------------
    
    const detailForm = document.getElementById('add-to-cart-form');
    if (detailForm) {
        detailForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const form = e.target;
            const variantSelect = document.getElementById('variant_id');
            const qtyInput = document.getElementById('product-qty');
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            // Validation
            if (variantSelect && !variantSelect.value) {
                showErrorMessage('Veuillez sélectionner une option');
                return;
            }
            
            if (parseInt(qtyInput.value) < 1) {
                showErrorMessage('Quantité invalide');
                return;
            }
            
            // Désactiver le bouton pendant la requête
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fi-rs-loading mr-5"></i>Ajout...';
            
            // Récupérer les données du formulaire
            const formData = new FormData(form);
            
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Mettre à jour le compteur du panier
                    updateCartCount(data.cart_count);
                    
                    // Animer l'icône du panier
                    animateCartIcon();
                    
                    // Afficher un message de succès
                    showSuccessMessage('Produit ajouté au panier !');
                    
                    // Optionnel: redirection vers le panier
                    // setTimeout(() => {
                    //     window.location.href = '{{ route("cart.index") }}';
                    // }, 1500);
                } else {
                    // Afficher un message d'erreur
                    showErrorMessage(data.message || 'Erreur lors de l\'ajout au panier');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                showErrorMessage('Une erreur est survenue');
            })
            .finally(() => {
                // Réactiver le bouton
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
        });
        
        // Gestion du changement de variant pour mettre à jour le stock max
        const variantSelect = document.getElementById('variant_id');
        const qtyInput = document.getElementById('product-qty');
        
        if (variantSelect && qtyInput) {
            variantSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                if (selectedOption.value) {
                    const stock = parseInt(selectedOption.dataset.stock);
                    qtyInput.max = stock;
                    
                    // Réinitialiser la quantité si elle dépasse le stock
                    if (parseInt(qtyInput.value) > stock) {
                        qtyInput.value = stock;
                    }
                }
            });
        }
    }
    
    // ------------------------------------------------------------
    // 4. FONCTIONS UTILITAIRES
    // ------------------------------------------------------------
    
    function showSuccessMessage(message) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'success',
                title: 'Succès',
                text: message,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            });
        } else if (typeof toastr !== 'undefined') {
            toastr.success(message);
        } else {
            alert(message);
        }
    }
    
    function showErrorMessage(message) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: message,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        } else if (typeof toastr !== 'undefined') {
            toastr.error(message);
        } else {
            alert(message);
        }
    }
    
    // ------------------------------------------------------------
    // 5. INITIALISATION DES MODALS D'AJOUT AU PANIER
    // ------------------------------------------------------------
    
    // Attendre que le DOM soit complètement chargé
    setTimeout(() => {
        if (document.querySelector('.add-to-cart-modal-btn')) {
            console.log('Initialisation des modals d\'ajout au panier...');
            initializeAddToCartModals();
        }
    }, 100);
});

// ------------------------------------------------------------
// FONCTION PRINCIPALE POUR LES MODALS D'AJOUT AU PANIER
// ------------------------------------------------------------
function initializeAddToCartModals() {
    console.log('Recherche des modals sur la page...');
    
    // Liste de tous les modals possibles avec leurs sélecteurs
    const modalConfigs = [
        { 
            id: 'addToCartModalHome',
            modalSelector: '#addToCartModalHome',
            prefix: 'home_'
        },
        { 
            id: 'addToCartModal',
            modalSelector: '#addToCartModal',
            prefix: ''
        }
    ];
    
    // Trouver quel modal existe sur cette page
    let activeModal = null;
    let modalPrefix = '';
    
    for (const config of modalConfigs) {
        const modalElement = document.querySelector(config.modalSelector);
        if (modalElement) {
            activeModal = modalElement;
            modalPrefix = config.prefix;
            console.log(`Modal trouvé: ${config.id} avec préfixe: ${modalPrefix}`);
            break;
        }
    }
    
    if (!activeModal) {
        console.log('Aucun modal d\'ajout au panier trouvé sur cette page');
        return;
    }
    
    // Construire les sélecteurs complets
    const selectors = {
        modal: activeModal,
        form: `#addToCartModalForm${modalPrefix ? 'Home' : ''}`,
        productId: `#modal_product_id${modalPrefix}`,
        productName: `#modal_product_name${modalPrefix}`,
        productImage: `#modal_product_image${modalPrefix}`,
        productPrice: `#modal_product_price${modalPrefix}`,
        productOldPrice: `#modal_product_old_price${modalPrefix}`,
        viewDetailsLink: `#view_details_link${modalPrefix}`,
        selectedVariantId: `#selected_variant_id${modalPrefix}`,
        modalProductQty: `#modal_product_qty${modalPrefix}`,
        colorError: `#color_error${modalPrefix}`,
        sizeError: `#size_error${modalPrefix}`,
        variantError: `#variant_error${modalPrefix}`,
        colorOptions: `#color_options${modalPrefix}`,
        sizeOptions: `#size_options${modalPrefix}`,
        priceSection: `#variant_price_section${modalPrefix}`,
        stockSection: `#variant_stock_section${modalPrefix}`,
        selectedVariantPrice: `#selected_variant_price${modalPrefix}`,
        selectedVariantStock: `#selected_variant_stock${modalPrefix}`,
        variantsSection: `#variants_section${modalPrefix}`,
        noVariantsSection: `#no_variants_section${modalPrefix}`,
        productStock: `#product_stock${modalPrefix}`,
        qtyDown: `#modal_qty_down${modalPrefix}`,
        qtyUp: `#modal_qty_up${modalPrefix}`
    };
    
    // ------------------------------------------------------------
    // 1. GESTION DES BOUTONS D'OUVERTURE DE MODAL
    // ------------------------------------------------------------
    document.addEventListener('click', function(e) {
        const addToCartBtn = e.target.closest('.add-to-cart-modal-btn');
        if (addToCartBtn) {
            e.preventDefault();
            openAddToCartModal(addToCartBtn, selectors, activeModal);
        }
    });
    
    // ------------------------------------------------------------
    // 2. GESTION DES BOUTONS DE QUANTITÉ
    // ------------------------------------------------------------
    const qtyDownBtn = document.querySelector(selectors.qtyDown);
    const qtyUpBtn = document.querySelector(selectors.qtyUp);
    const qtyInput = document.querySelector(selectors.modalProductQty);
    
    if (qtyDownBtn && qtyInput) {
        qtyDownBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const currentValue = parseInt(qtyInput.value) || 1;
            if (currentValue > 1) {
                qtyInput.value = currentValue - 1;
            }
        });
    }
    
    if (qtyUpBtn && qtyInput) {
        qtyUpBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const currentValue = parseInt(qtyInput.value) || 1;
            const maxValue = parseInt(qtyInput.max) || 999;
            if (currentValue < maxValue) {
                qtyInput.value = currentValue + 1;
            }
        });
    }
    
    // ------------------------------------------------------------
    // 3. GESTION DE LA SOUMISSION DU FORMULAIRE
    // ------------------------------------------------------------
    const form = document.querySelector(selectors.form);
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            submitModalForm(this, selectors, activeModal);
        });
    }
}

// ------------------------------------------------------------
// FONCTIONS AUXILIAIRES POUR LES MODALS
// ------------------------------------------------------------

function openAddToCartModal(btn, selectors, modalElement) {
    // Récupérer les données du produit
    const productData = {
        id: btn.dataset.productId,
        name: btn.dataset.productName,
        image: btn.dataset.productImage,
        price: btn.dataset.productPrice,
        oldPrice: btn.dataset.productOldPrice
    };
    
    console.log('Ouverture du modal pour:', productData.name);
    
    // Mettre à jour les informations du produit
    updateProductInfo(productData, selectors);
    
    // Réinitialiser le modal
    resetModal(selectors);
    
    // Charger les variants du produit
    loadProductVariants(productData.id, selectors);
    
    // Afficher le modal
    if (typeof bootstrap !== 'undefined') {
        const modalInstance = new bootstrap.Modal(modalElement);
        modalInstance.show();
    } else {
        // Fallback si Bootstrap n'est pas chargé
        modalElement.style.display = 'block';
        modalElement.classList.add('show');
    }
}

function updateProductInfo(productData, selectors) {
    // Fonction utilitaire pour mettre à jour un élément
    function updateElement(selector, property, value) {
        const element = document.querySelector(selector);
        if (element) {
            if (property === 'textContent') {
                element.textContent = value;
            } else if (property === 'value') {
                element.value = value;
            } else if (property === 'src') {
                element.src = value;
            } else if (property === 'href') {
                element.href = value;
            }
        }
    }
    
    // Mettre à jour tous les éléments
    updateElement(selectors.productId, 'value', productData.id);
    updateElement(selectors.productName, 'textContent', productData.name);
    updateElement(selectors.productImage, 'src', productData.image);
    updateElement(selectors.productPrice, 'textContent', productData.price);
    updateElement(selectors.viewDetailsLink, 'href', `/shop/${productData.id}`);
    
    // Gestion de l'ancien prix
    const oldPriceElement = document.querySelector(selectors.productOldPrice);
    if (oldPriceElement) {
        if (productData.oldPrice && productData.oldPrice.trim() !== '') {
            oldPriceElement.textContent = productData.oldPrice;
            oldPriceElement.style.display = 'inline';
        } else {
            oldPriceElement.style.display = 'none';
        }
    }
}

function resetModal(selectors) {
    console.log('Réinitialisation du modal');
    
    // Fonction utilitaire pour manipuler les éléments
    function handleElement(selector, action, value = null) {
        const element = document.querySelector(selector);
        if (!element) return;
        
        switch(action) {
            case 'hide':
                element.style.display = 'none';
                break;
            case 'show':
                element.style.display = 'block';
                break;
            case 'clear':
                element.innerHTML = '';
                break;
            case 'setValue':
                element.value = value;
                break;
            case 'setMax':
                element.max = value;
                break;
        }
    }
    
    // Réinitialiser les champs
    handleElement(selectors.selectedVariantId, 'setValue', '');
    handleElement(selectors.modalProductQty, 'setValue', 1);
    handleElement(selectors.modalProductQty, 'setMax', 999);
    
    // Masquer les messages d'erreur
    handleElement(selectors.colorError, 'hide');
    handleElement(selectors.sizeError, 'hide');
    handleElement(selectors.variantError, 'hide');
    
    // Masquer les sections d'info variant
    handleElement(selectors.priceSection, 'hide');
    handleElement(selectors.stockSection, 'hide');
    
    // Vider les options
    handleElement(selectors.colorOptions, 'clear');
    handleElement(selectors.sizeOptions, 'clear');
    
    // Masquer les sections de variant
    handleElement(selectors.variantsSection, 'hide');
    handleElement(selectors.noVariantsSection, 'hide');
}

function loadProductVariants(productId, selectors) {
    console.log(`Chargement des variants pour ${productId}`);
    
    fetch(`/api/products/${productId}/variants`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Erreur HTTP: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Données reçues:', data);
            
            if (data.success) {
                if (data.variants && data.variants.length > 0) {
                    // Produit avec variants
                    document.querySelector(selectors.variantsSection).style.display = 'block';
                    generateVariantOptions(data.variants, selectors);
                } else {
                    // Produit sans variant
                    document.querySelector(selectors.noVariantsSection).style.display = 'block';
                    
                    const stockElement = document.querySelector(selectors.productStock);
                    const qtyInput = document.querySelector(selectors.modalProductQty);
                    
                    if (stockElement) {
                        stockElement.textContent = `${data.stock} articles`;
                    }
                    
                    if (qtyInput && data.stock) {
                        qtyInput.max = data.stock;
                    }
                }
            } else {
                showModalError(selectors.variantError, data.message || 'Erreur lors du chargement des options');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showModalError(selectors.variantError, 'Impossible de charger les options. Veuillez réessayer.');
        });
}

function generateVariantOptions(variants, selectors) {
    const colorOptionsDiv = document.querySelector(selectors.colorOptions);
    const sizeOptionsDiv = document.querySelector(selectors.sizeOptions);
    
    if (!colorOptionsDiv || !sizeOptionsDiv) {
        console.error('Conteneurs d\'options non trouvés');
        return;
    }
    
    // Vider les conteneurs
    colorOptionsDiv.innerHTML = '';
    sizeOptionsDiv.innerHTML = '';
    
    // Organiser les variants par couleur
    const colorsMap = new Map();
    
    variants.forEach(variant => {
        if (variant.couleur) {
            const colorId = variant.couleur.id;
            if (!colorsMap.has(colorId)) {
                colorsMap.set(colorId, {
                    color: variant.couleur,
                    sizes: []
                });
            }
            
            if (variant.taille && variant.quantite_variant > 0) {
                colorsMap.get(colorId).sizes.push({
                    taille: variant.taille,
                    variant: variant
                });
            }
        }
    });
    
    // Créer les boutons de couleur
    colorsMap.forEach((colorData, colorId) => {
        const colorBtn = document.createElement('button');
        colorBtn.type = 'button';
        colorBtn.className = 'color-option';
        colorBtn.style.cssText = `
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: ${colorData.color.code_hex || '#ccc'};
            border: 2px solid #ddd;
            margin: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        `;
        colorBtn.title = colorData.color.name;
        colorBtn.dataset.colorId = colorId;
        
        colorBtn.addEventListener('click', function() {
            // Désélectionner toutes les couleurs
            document.querySelectorAll(`${selectors.colorOptions} .color-option`).forEach(opt => {
                opt.classList.remove('selected');
                opt.style.borderColor = '#ddd';
            });
            
            // Sélectionner cette couleur
            this.classList.add('selected');
            this.style.borderColor = '#3bb77e';
            
            // Afficher les tailles pour cette couleur
            displaySizesForColor(colorData.sizes, selectors);
            
            // Masquer l'erreur de couleur
            document.querySelector(selectors.colorError).style.display = 'none';
        });
        
        colorOptionsDiv.appendChild(colorBtn);
    });
    
    // Sélectionner la première couleur par défaut si disponible
    if (colorsMap.size > 0) {
        setTimeout(() => {
            const firstColorBtn = colorOptionsDiv.querySelector('.color-option');
            if (firstColorBtn) {
                firstColorBtn.click();
            }
        }, 100);
    }
}

function displaySizesForColor(sizes, selectors) {
    const sizeOptionsDiv = document.querySelector(selectors.sizeOptions);
    if (!sizeOptionsDiv) return;
    
    sizeOptionsDiv.innerHTML = '';
    
    if (sizes.length === 0) {
        sizeOptionsDiv.innerHTML = '<p class="text-muted small">Aucune taille disponible</p>';
        return;
    }
    
    sizes.forEach(sizeData => {
        const sizeBtn = document.createElement('button');
        sizeBtn.type = 'button';
        sizeBtn.className = 'size-option btn btn-outline-secondary';
        sizeBtn.textContent = sizeData.taille.name;
        sizeBtn.dataset.variantId = sizeData.variant.id;
        sizeBtn.dataset.stock = sizeData.variant.quantite_variant;
        sizeBtn.dataset.price = sizeData.variant.prix_promotionnel_variant || sizeData.variant.prix_ttc_variant;
        
        sizeBtn.addEventListener('click', function() {
            // Désélectionner toutes les tailles
            document.querySelectorAll(`${selectors.sizeOptions} .size-option`).forEach(opt => {
                opt.classList.remove('btn-primary');
                opt.classList.add('btn-outline-secondary');
            });
            
            // Sélectionner cette taille
            this.classList.remove('btn-outline-secondary');
            this.classList.add('btn-primary');
            
            // Mettre à jour le variant sélectionné
            document.querySelector(selectors.selectedVariantId).value = this.dataset.variantId;
            
            // Mettre à jour le stock et la quantité max
            const stock = parseInt(this.dataset.stock);
            const qtyInput = document.querySelector(selectors.modalProductQty);
            if (qtyInput) {
                qtyInput.max = stock;
            }
            
            // Mettre à jour le prix affiché
            const price = parseFloat(this.dataset.price);
            document.querySelector(selectors.productPrice).textContent = price.toFixed(2).replace('.', ',') + ' €';
            
            // Afficher les infos du variant
            document.querySelector(selectors.priceSection).style.display = 'block';
            document.querySelector(selectors.stockSection).style.display = 'block';
            document.querySelector(selectors.selectedVariantPrice).textContent = price.toFixed(2).replace('.', ',') + ' €';
            document.querySelector(selectors.selectedVariantStock).textContent = stock + ' disponible(s)';
            
            // Masquer l'erreur de taille
            document.querySelector(selectors.sizeError).style.display = 'none';
            
            // Réinitialiser la quantité à 1
            if (qtyInput) {
                qtyInput.value = 1;
            }
        });
        
        sizeOptionsDiv.appendChild(sizeBtn);
    });
}

function submitModalForm(form, selectors, modalElement) {
    // Validation
    const variantIdInput = document.querySelector(selectors.selectedVariantId);
    const qtyInput = document.querySelector(selectors.modalProductQty);
    const variantsSection = document.querySelector(selectors.variantsSection);
    
    // Vérifier si le produit a des variants
    const hasVariants = variantsSection && variantsSection.style.display !== 'none';
    
    if (hasVariants && (!variantIdInput || !variantIdInput.value)) {
        // Afficher l'erreur dans le bon champ
        if (variantIdInput && !variantIdInput.value) {
            const colorError = document.querySelector(selectors.colorError);
            const sizeError = document.querySelector(selectors.sizeError);
            
            // Vérifier ce qui n'est pas sélectionné
            const colorSelected = document.querySelector(`${selectors.colorOptions} .color-option.selected`);
            const sizeSelected = document.querySelector(`${selectors.sizeOptions} .size-option.btn-primary`);
            
            if (!colorSelected && colorError) {
                colorError.style.display = 'block';
            }
            
            if (!sizeSelected && sizeError) {
                sizeError.style.display = 'block';
            }
            
            if (colorSelected && sizeSelected) {
                // Si les deux sont sélectionnés mais variantId n'est pas défini
                showModalError(selectors.variantError, 'Veuillez sélectionner une option valide');
            }
        }
        return;
    }
    
    // Désactiver le bouton de soumission
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fi-rs-loading mr-5"></i>Ajout...';
    
    // Soumettre le formulaire
    const formData = new FormData(form);
    
    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Mettre à jour le compteur du panier dans tout le site
            document.querySelectorAll('.cart-count').forEach(el => {
                el.textContent = data.cart_count;
            });
            
            // Animer l'icône du panier
            const cartIcons = document.querySelectorAll('.mini-cart-icon');
            cartIcons.forEach(icon => {
                icon.classList.add('animate');
                setTimeout(() => icon.classList.remove('animate'), 500);
            });
            
            // Fermer le modal
            if (typeof bootstrap !== 'undefined') {
                const modal = bootstrap.Modal.getInstance(modalElement);
                if (modal) modal.hide();
            } else {
                modalElement.style.display = 'none';
                modalElement.classList.remove('show');
            }
            
            // Afficher un message de succès
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'Succès',
                    text: 'Produit ajouté au panier !',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            } else {
                alert('Produit ajouté au panier !');
            }
        } else {
            showModalError(selectors.variantError, data.message || 'Erreur lors de l\'ajout au panier');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        showModalError(selectors.variantError, 'Une erreur est survenue');
    })
    .finally(() => {
        // Réactiver le bouton
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
}

function showModalError(selector, message) {
    const element = document.querySelector(selector);
    if (element) {
        element.textContent = message;
        element.style.display = 'block';
    }
}
</script>
    <script src=" {{ asset('front-end/js/vendor/modernizr-3.6.0.min.js') }}"></script>
    <script src=" {{ asset('front-end/js/vendor/jquery-3.7.1.min.js') }}"></script>
    <script src=" {{ asset('front-end/js/vendor/jquery-migrate-3.3.0.min.js') }}"></script>
    <script src=" {{ asset('front-end/js/vendor/bootstrap.bundle.min.js') }}"></script>
    <script src=" {{ asset('front-end/js/plugins/slick.js') }}"></script>
    <script src=" {{ asset('front-end/js/plugins/jquery.syotimer.min.js') }}"></script>
    <script src=" {{ asset('front-end/js/plugins/waypoints.js') }}"></script>
    <script src=" {{ asset('front-end/js/plugins/wow.js') }}"></script>
    <script src=" {{ asset('front-end/js/plugins/perfect-scrollbar.js') }}"></script>
    <script src=" {{ asset('front-end/js/plugins/magnific-popup.js') }}"></script>
    <script src=" {{ asset('front-end/js/plugins/select2.min.js') }}"></script>
    <script src=" {{ asset('front-end/js/plugins/counterup.js') }}"></script>
    <script src=" {{ asset('front-end/js/plugins/jquery.countdown.min.js') }}"></script>
    <script src=" {{ asset('front-end/js/plugins/images-loaded.js') }}"></script>
    <script src=" {{ asset('front-end/js/plugins/isotope.js') }}"></script>
    <script src=" {{ asset('front-end/js/plugins/scrollup.js') }}"></script>
    <script src=" {{ asset('front-end/js/plugins/jquery.vticker-min.js') }}"></script>
    <script src=" {{ asset('front-end/js/plugins/jquery.theia.sticky.js') }}"></script>
    <script src=" {{ asset('front-end/js/plugins/jquery.elevatezoom.js') }}"></script>
    <!-- Template  JS -->
    <script src=" {{ asset('front-end/js/main.js?v=6.1') }}"></script>
    <script src=" {{ asset('front-end/js/shop.js?v=6.1') }}"></script>
</body>

</html>