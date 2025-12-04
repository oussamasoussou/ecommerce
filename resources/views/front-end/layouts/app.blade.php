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
    <style>
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
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const baseUrl = window.location.origin;

            // Fonction pour afficher les notifications
            function showNotification(type, message) {
                if (typeof toastr !== 'undefined') {
                    toastr[type](message);
                } else {
                    alert(message);
                }
            }

            // Mettre à jour la quantité
            async function updateQuantity(cartId, quantity, inputElement) {
                try {
                    const response = await fetch(`${baseUrl}/cart/${cartId}/update`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ quantite: quantity })
                    });

                    const data = await response.json();

                    if (data.success) {
                        // Mettre à jour l'input
                        if (inputElement) {
                            inputElement.value = quantity;
                        }

                        // Mettre à jour le total de l'article
                        const totalElement = document.querySelector(`.cart-total-${cartId}`);
                        if (totalElement) {
                            totalElement.textContent =
                                `${parseFloat(data.prix_total).toFixed(2).replace('.', ',')} €`;
                        }

                        // Mettre à jour les totaux généraux
                        const subtotalElement = document.getElementById('cart-subtotal');
                        const grandTotalElement = document.getElementById('cart-grand-total');

                        if (subtotalElement) {
                            subtotalElement.textContent =
                                `${parseFloat(data.cart_total).toFixed(2).replace('.', ',')} €`;
                        }

                        if (grandTotalElement) {
                            grandTotalElement.textContent =
                                `${parseFloat(data.cart_total).toFixed(2).replace('.', ',')} €`;
                        }

                        // Mettre à jour le compteur dans le header
                        document.querySelectorAll('.cart-count').forEach(el => {
                            el.textContent = data.cart_count || 0;
                        });

                        showNotification('success', 'Quantité mise à jour');
                    } else {
                        showNotification('error', data.message);
                        // Revenir à l'ancienne valeur
                        if (inputElement) {
                            inputElement.value = inputElement.defaultValue;
                        }
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showNotification('error', 'Une erreur est survenue');
                }
            }

            // Boutons plus/moins
            document.querySelectorAll('.btn-plus').forEach(btn => {
                btn.addEventListener('click', function () {
                    const cartId = this.dataset.cartId;
                    const input = document.querySelector(`.qty-input[data-cart-id="${cartId}"]`);
                    const max = parseInt(input.max);
                    let newQty = parseInt(input.value) + 1;

                    if (newQty <= max) {
                        input.value = newQty;
                        updateQuantity(cartId, newQty, input);
                    } else {
                        showNotification('warning', 'Quantité maximale atteinte');
                    }
                });
            });

            document.querySelectorAll('.btn-minus').forEach(btn => {
                btn.addEventListener('click', function () {
                    const cartId = this.dataset.cartId;
                    const input = document.querySelector(`.qty-input[data-cart-id="${cartId}"]`);
                    let newQty = parseInt(input.value) - 1;

                    if (newQty >= 1) {
                        input.value = newQty;
                        updateQuantity(cartId, newQty, input);
                    }
                });
            });

            // Changement direct dans l'input
            document.querySelectorAll('.qty-input').forEach(input => {
                input.addEventListener('change', function () {
                    const cartId = this.dataset.cartId;
                    const quantity = parseInt(this.value);

                    if (quantity >= 1 && quantity <= parseInt(this.max)) {
                        updateQuantity(cartId, quantity, this);
                    } else {
                        this.value = this.defaultValue;
                        showNotification('warning', 'Quantité invalide');
                    }
                });
            });

            // Supprimer un article
            document.querySelectorAll('.btn-remove').forEach(btn => {
                btn.addEventListener('click', function () {
                    const cartId = this.dataset.cartId;

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
                                    // Supprimer la ligne
                                    const row = document.querySelector(`.cart-item-${cartId}`);
                                    if (row) {
                                        row.remove();
                                    }

                                    // Mettre à jour les totaux
                                    const subtotalElement = document.getElementById('cart-subtotal');
                                    const grandTotalElement = document.getElementById('cart-grand-total');

                                    if (subtotalElement) {
                                        subtotalElement.textContent =
                                            `${parseFloat(data.cart_total).toFixed(2).replace('.', ',')} €`;
                                    }

                                    if (grandTotalElement) {
                                        grandTotalElement.textContent =
                                            `${parseFloat(data.cart_total).toFixed(2).replace('.', ',')} €`;
                                    }

                                    // Mettre à jour le compteur
                                    document.querySelectorAll('.cart-count').forEach(el => {
                                        el.textContent = data.cart_count || 0;
                                    });

                                    // Vérifier si le panier est vide
                                    if (data.cart_count === 0) {
                                        setTimeout(() => location.reload(), 1000);
                                    }

                                    showNotification('success', data.message);
                                } else {
                                    showNotification('error', data.message || 'Erreur lors de la suppression');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                showNotification('error', 'Une erreur est survenue');
                            });
                    }
                });
            });

            // Vider le panier
            const clearCartBtn = document.getElementById('clear-cart');
            if (clearCartBtn) {
                clearCartBtn.addEventListener('click', function () {
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