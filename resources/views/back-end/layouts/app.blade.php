<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Nest Dashboard</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:title" content="" />
    <meta property="og:type" content="" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="back-end/imgs/theme/favicon.svg" />

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('back-end/css/main.css?v=6.1') }}" type="text/css" />
    <script src="{{ asset('back-end/js/vendors/color-modes.js') }}"></script>
</head>

<body>
    <div class="screen-overlay"></div>
    @include('back-end.partials.sidebar')

    <main class="main-wrap">
        @include('back-end.partials.header')
        @yield('content')
        @include('back-end.partials.footer')
    </main>

    <!-- Scripts Vendors -->
    <script src="{{ asset('back-end/js/vendors/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('back-end/js/vendors/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('back-end/js/vendors/select2.min.js') }}"></script>
    <script src="{{ asset('back-end/js/vendors/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('back-end/js/vendors/jquery.fullscreen.min.js') }}"></script>
    <script src="{{ asset('back-end/js/vendors/chart.js') }}"></script>

    <!-- Main Scripts -->
    <script src="{{ asset('back-end/js/main.js?v=6.1') }}"></script>
    <script src="{{ asset('back-end/js/custom-chart.js') }}"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // --- Fonction utilitaire pour vérifier existence avant addEventListener ---
            function safeAddEventListener(id, event, callback) {
                const el = document.getElementById(id);
                if (el) el.addEventListener(event, callback);
            }

            // --- Aperçu Logo ---
            safeAddEventListener('logoInput', 'change', function (event) {
                const file = event.target.files[0];
                const previewContainer = document.getElementById('logoPreviewContainer');
                const placeholder = document.getElementById('logoPlaceholder');
                const previewImage = document.getElementById('logoPreview');

                if (file) {
                    if (file.size > 2 * 1024 * 1024) { // 2MB
                        alert('Le fichier est trop volumineux. Taille maximum: 2MB');
                        this.value = '';
                        if (previewContainer) previewContainer.style.display = 'none';
                        return;
                    }
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        if (previewImage) previewImage.src = e.target.result;
                        if (previewContainer) previewContainer.style.display = 'block';
                        if (placeholder) placeholder.style.display = 'none';
                    }
                    reader.readAsDataURL(file);
                } else {
                    if (previewContainer) previewContainer.style.display = 'none';
                    if (placeholder) placeholder.style.display = 'block';
                    if (previewImage) previewImage.src = '';
                }
            });

            safeAddEventListener('logoReset', 'click', function () {
                const previewContainer = document.getElementById('logoPreviewContainer');
                const previewImage = document.getElementById('logoPreview');
                if (previewContainer) previewContainer.style.display = 'none';
                if (previewImage) previewImage.src = '';
            });

            // --- Aperçu Image ---
            safeAddEventListener('imageInput', 'change', function (event) {
                const file = event.target.files[0];
                const previewContainer = document.getElementById('imagePreviewContainer');
                const placeholder = document.getElementById('imagePlaceholder');
                const previewImage = document.getElementById('imagePreview');
                const supprimerImageCheckbox = document.getElementById('supprimer_image');

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        if (previewImage) previewImage.src = e.target.result;
                        if (previewContainer) previewContainer.style.display = 'block';
                        if (placeholder) placeholder.style.display = 'none';
                    }
                    reader.readAsDataURL(file);
                    if (supprimerImageCheckbox) supprimerImageCheckbox.checked = false;
                } else {
                    if (previewContainer) previewContainer.style.display = 'none';
                    if (placeholder) placeholder.style.display = 'block';
                    if (previewImage) previewImage.src = '';
                }
            });

            // Désactiver le champ fichier si suppression cochée
            const supprimerImageCheckbox = document.getElementById('supprimer_image');
            const imageInput = document.getElementById('imageInput');
            if (supprimerImageCheckbox && imageInput) {
                supprimerImageCheckbox.addEventListener('change', function () {
                    if (this.checked) {
                        imageInput.disabled = true;
                        const previewContainer = document.getElementById('imagePreviewContainer');
                        const placeholder = document.getElementById('imagePlaceholder');
                        if (previewContainer) previewContainer.style.display = 'none';
                        if (placeholder) placeholder.style.display = 'block';
                        imageInput.value = '';
                    } else {
                        imageInput.disabled = false;
                    }
                });
            }

            // --- Preview Images multiples ---
            const imagesInput = document.getElementById('imagesInput');
            const previewContainerMultiple = document.getElementById('preview-container');
            if (imagesInput && previewContainerMultiple) {
                imagesInput.addEventListener('change', function () {
                    previewContainerMultiple.innerHTML = '';
                    [...this.files].forEach(file => {
                        const reader = new FileReader();
                        reader.onload = e => {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.style.width = '100px';
                            img.style.height = '100px';
                            img.style.objectFit = 'cover';
                            img.classList.add('me-2', 'mb-2');
                            previewContainerMultiple.appendChild(img);
                        }
                        reader.readAsDataURL(file);
                    });
                });
            }

            // --- CKEditor ---
            const ckIds = ['description', 'long_description', 'additional_info'];
            ckIds.forEach(id => {
                const el = document.getElementById(id);
                if (el) {
                    ClassicEditor.create(el, {
                        toolbar: [
                            'heading', '|',
                            'bold', 'italic', 'underline', 'strikethrough', '|',
                            'bulletedList', 'numberedList', 'blockQuote', '|',
                            'link', 'insertTable', 'mediaEmbed', '|',
                            'undo', 'redo'
                        ],
                        height: 300
                    }).catch(error => console.error(error));
                }
            });

            // --- Promo et Variants ---
            const promoCheck = document.getElementById('promoCheck');
            const promoPriceContainer = document.getElementById('promoPriceContainer');
            if (promoCheck && promoPriceContainer) {
                const togglePromoPrice = () => {
                    promoPriceContainer.style.display = promoCheck.checked ? 'block' : 'none';
                    const input = promoPriceContainer.querySelector('input');
                    if (!promoCheck.checked && input) input.value = '';
                };
                promoCheck.addEventListener('change', togglePromoPrice);
                togglePromoPrice();
            }

            const variantCheck = document.getElementById('variantCheck');
            const variantsSection = document.getElementById('variants-section');
            if (variantCheck && variantsSection) {
                const toggleVariants = () => {
                    variantsSection.style.display = variantCheck.checked ? 'block' : 'none';
                };
                variantCheck.addEventListener('change', toggleVariants);
                toggleVariants();
            }

            // --- Gestion des variantes dynamiques ---
            const addVariantBtn = document.getElementById('add-variant');
            if (addVariantBtn) {
                let variantIndex = 1;
                addVariantBtn.addEventListener('click', () => {
                    const container = document.getElementById('variants-container');
                    if (!container) return;
                    const newRow = container.querySelector('.variant-row').cloneNode(true);
                    newRow.querySelectorAll('input, select').forEach(input => {
                        let name = input.getAttribute('name');
                        input.setAttribute('name', name.replace(/\d+/, variantIndex));
                        input.value = '';
                    });
                    container.appendChild(newRow);
                    variantIndex++;
                });
            }

            // Boutons suppression variante
            document.addEventListener('click', function (e) {
                if (e.target.classList.contains('btn-remove-variant')) {
                    const rows = document.querySelectorAll('.variant-row');
                    if (rows.length > 1) {
                        e.target.closest('.variant-row').remove();
                    }
                }
            });

            // --- Tooltips Bootstrap ---
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // --- Gestion erreurs images ---
            document.addEventListener('error', function (e) {
                if (e.target.tagName === 'IMG') {
                    e.target.style.display = 'none';
                    const parent = e.target.parentElement;
                    if (!parent.querySelector('.bi-image')) {
                        const icon = document.createElement('i');
                        icon.className = 'bi bi-image text-muted';
                        icon.style.fontSize = '1.5rem';
                        parent.appendChild(icon);
                    }
                }
            }, true);

        });
    </script>

</body>

</html>
