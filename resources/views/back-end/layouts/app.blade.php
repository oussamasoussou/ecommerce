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
    <link rel="stylesheet" href="{{ asset('back-end/css/main.css?v=6.1') }}" rel="stylesheet" type="text/css" />
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


    <script src="{{ asset('back-end/js/vendors/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('back-end/js/vendors/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('back-end/js/vendors/select2.min.js') }}"></script>
    <script src="{{ asset('back-end/js/vendors/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('back-end/js/vendors/jquery.fullscreen.min.js') }}"></script>
    <script src="{{ asset('back-end/js/vendors/chart.js') }}"></script>

    <!-- Main Script -->
    <script src="{{ asset('back-end/js/main.js?v=6.1') }}" type="text/javascript"></script>
    <script src="{{ asset('back-end/js/custom-chart.js') }}" type="text/javascript"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

    <script>
        // Aperçu du logo SVG
        document.getElementById('logoInput').addEventListener('change', function (event) {
            const file = event.target.files[0];
            const previewContainer = document.getElementById('logoPreviewContainer');
            const placeholder = document.getElementById('logoPlaceholder');
            const previewImage = document.getElementById('logoPreview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImage.src = e.target.result;
                    previewContainer.style.display = 'block';
                    placeholder.style.display = 'none';
                }
                reader.readAsDataURL(file);
            } else {
                previewContainer.style.display = 'none';
                placeholder.style.display = 'block';
                previewImage.src = '';
            }
        });

        // Aperçu de l'image
        document.getElementById('imageInput').addEventListener('change', function (event) {
            const file = event.target.files[0];
            const previewContainer = document.getElementById('imagePreviewContainer');
            const placeholder = document.getElementById('imagePlaceholder');
            const previewImage = document.getElementById('imagePreview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImage.src = e.target.result;
                    previewContainer.style.display = 'block';
                    placeholder.style.display = 'none';
                }
                reader.readAsDataURL(file);
            } else {
                previewContainer.style.display = 'none';
                placeholder.style.display = 'block';
                previewImage.src = '';
            }
        });

        // Validation des fichiers
        document.querySelector('form').addEventListener('submit', function (e) {
            const logoInput = document.getElementById('logoInput');
            const imageInput = document.getElementById('imageInput');

            // Validation du logo SVG
            if (logoInput.files.length > 0) {
                const logoFile = logoInput.files[0];
                if (logoFile.type !== 'image/svg+xml') {
                    e.preventDefault();
                    alert('Le logo doit être un fichier SVG.');
                    return;
                }
                if (logoFile.size > 2 * 1024 * 1024) { // 2MB
                    e.preventDefault();
                    alert('Le logo ne doit pas dépasser 2MB.');
                    return;
                }
            }

            // Validation de l'image
            if (imageInput.files.length > 0) {
                const imageFile = imageInput.files[0];
                const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

                if (!validTypes.includes(imageFile.type)) {
                    e.preventDefault();
                    alert('L\'image doit être au format JPG, PNG, GIF ou WEBP.');
                    return;
                }
                if (imageFile.size > 5 * 1024 * 1024) { // 5MB
                    e.preventDefault();
                    alert('L\'image ne doit pas dépasser 5MB.');
                    return;
                }
            }
        });
    </script>

    <script>
        // Initialisation des tooltips Bootstrap
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        });

        // Gestion des erreurs d'image
        document.addEventListener('error', function (e) {
            if (e.target.tagName === 'IMG') {
                e.target.style.display = 'none';
                // Afficher une icône de remplacement
                const parent = e.target.parentElement;
                if (!parent.querySelector('.bi-image')) {
                    const icon = document.createElement('i');
                    icon.className = 'bi bi-image text-muted';
                    icon.style.fontSize = '1.5rem';
                    parent.appendChild(icon);
                }
            }
        }, true);
    </script>

    <script>
        // Aperçu du logo sélectionné
        document.getElementById('logoInput').addEventListener('change', function (event) {
            const file = event.target.files[0];
            const previewContainer = document.getElementById('logoPreviewContainer');
            const previewImage = document.getElementById('logoPreview');

            if (file) {
                // Vérification de la taille du fichier (2MB max)
                if (file.size > 2 * 1024 * 1024) {
                    alert('Le fichier est trop volumineux. Taille maximum: 2MB');
                    this.value = '';
                    previewContainer.style.display = 'none';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImage.src = e.target.result;
                    previewContainer.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                previewContainer.style.display = 'none';
                previewImage.src = '';
            }
        });

        // Réinitialisation du formulaire
        document.querySelector('button[type="reset"]').addEventListener('click', function () {
            document.getElementById('logoPreviewContainer').style.display = 'none';
            document.getElementById('logoPreview').src = '';
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            ClassicEditor
                .create(document.querySelector('#description'), {
                    toolbar: [
                        'heading', '|',
                        'bold', 'italic', 'underline', 'strikethrough', '|',
                        'bulletedList', 'numberedList', 'blockQuote', '|',
                        'link', 'insertTable', 'mediaEmbed', '|',
                        'undo', 'redo'
                    ],
                    height: 300
                })
                .catch(error => {
                    console.error(error);
                });
        });
    </script>

    <script>

        document.getElementById('promoCheck').addEventListener('change', function () {
            document.getElementById('promoPriceContainer').style.display = this.checked ? 'block' : 'none';
        });
        document.getElementById('variantCheck').addEventListener('change', function () {
            document.getElementById('variants-section').style.display = this.checked ? 'block' : 'none';
        });

        document.addEventListener('DOMContentLoaded', function () {

            function updateSelected(container, select, type) {
                container.innerHTML = '';
                Array.from(select.selectedOptions).forEach(option => {
                    const span = document.createElement('span');
                    span.classList.add('badge', 'bg-primary', 'me-1', 'mb-1');
                    span.textContent = option.text;

                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.classList.add('btn-close', 'btn-close-white', 'ms-1', 'btn-sm');
                    removeBtn.onclick = () => {
                        option.selected = false;
                        updateSelected(container, select, type);
                    };

                    span.appendChild(removeBtn);
                    container.appendChild(span);
                });
            }

            document.querySelectorAll('.variant-color-select').forEach(select => {
                const container = select.nextElementSibling;
                select.addEventListener('change', () => updateSelected(container, select, 'color'));
                updateSelected(container, select, 'color');
            });

            document.querySelectorAll('.variant-size-select').forEach(select => {
                const container = select.nextElementSibling;
                select.addEventListener('change', () => updateSelected(container, select, 'size'));
                updateSelected(container, select, 'size');
            });

        });


        document.addEventListener('DOMContentLoaded', function () {
            const promoCheck = document.getElementById('promoCheck');
            const promoPriceContainer = document.getElementById('promoPriceContainer');
            const variantCheck = document.getElementById('variantCheck');
            const variantsSection = document.getElementById('variants-section');

            promoPriceContainer.style.display = promoCheck.checked ? 'block' : 'none';
            variantsSection.style.display = variantCheck.checked ? 'block' : 'none';

            promoCheck.addEventListener('change', () => {
                promoPriceContainer.style.display = promoCheck.checked ? 'block' : 'none';
            });

            variantCheck.addEventListener('change', () => {
                variantsSection.style.display = variantCheck.checked ? 'block' : 'none';
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            const variantCheck = document.getElementById('variantCheck');
            const variantsSection = document.getElementById('variants-section');

            // Afficher / cacher au chargement si checkbox précochée (utile si validation échoue)
            variantsSection.style.display = variantCheck.checked ? 'block' : 'none';

            variantCheck.addEventListener('change', function () {
                variantsSection.style.display = this.checked ? 'block' : 'none';
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            const promoCheck = document.getElementById('promoCheck');
            const promoPriceContainer = document.getElementById('promoPriceContainer');

            // Fonction pour afficher/masquer le champ prix promotionnel
            function togglePromoPrice() {
                if (promoCheck.checked) {
                    promoPriceContainer.style.display = 'block';
                } else {
                    promoPriceContainer.style.display = 'none';
                    // Optionnel : vider le champ quand on décoche
                    promoPriceContainer.querySelector('input').value = '';
                }
            }

            // Événement sur le changement de la checkbox
            promoCheck.addEventListener('change', togglePromoPrice);

            // Appliquer l'état initial au chargement
            togglePromoPrice();
        });

        let variantIndex = 1;

        document.getElementById('add-variant').addEventListener('click', () => {
            let container = document.getElementById('variants-container');
            let newRow = container.querySelector('.variant-row').cloneNode(true);

            newRow.querySelectorAll('input, select').forEach(input => {
                let name = input.getAttribute('name');
                input.setAttribute('name', name.replace(/\d+/, variantIndex));
                input.value = '';
            });

            container.appendChild(newRow);
            variantIndex++;
        });

        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('btn-remove-variant')) {
                let rows = document.querySelectorAll('.variant-row');
                if (rows.length > 1) {
                    e.target.closest('.variant-row').remove();
                }
            }
        });

        // Preview Images
        const imagesInput = document.getElementById('imagesInput');
        const previewContainer = document.getElementById('preview-container');

        imagesInput.addEventListener('change', function () {
            previewContainer.innerHTML = '';
            [...this.files].forEach(file => {
                const reader = new FileReader();
                reader.onload = e => {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = '100px';
                    img.style.height = '100px';
                    img.style.objectFit = 'cover';
                    img.classList.add('me-2', 'mb-2');
                    previewContainer.appendChild(img);
                }
                reader.readAsDataURL(file);
            });
        });

    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const imageInput = document.getElementById('imageInput');
            const imagePreview = document.getElementById('imagePreview');
            const imagePreviewContainer = document.getElementById('imagePreviewContainer');
            const imagePlaceholder = document.getElementById('imagePlaceholder');

            imageInput.addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        imagePreview.src = e.target.result;
                        imagePreviewContainer.style.display = 'block';
                        imagePlaceholder.style.display = 'none';
                    }
                    reader.readAsDataURL(file);
                } else {
                    imagePreviewContainer.style.display = 'none';
                    imagePlaceholder.style.display = 'block';
                }
            });

            // Afficher l'aperçu si retour après erreur de validation
            @if(old('image_preview'))
                imagePreview.src = '{{ old('image_preview') }}';
                imagePreviewContainer.style.display = 'block';
                imagePlaceholder.style.display = 'none';
            @endif
});
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const imageInput = document.getElementById('imageInput');
            const imagePreview = document.getElementById('imagePreview');
            const imagePreviewContainer = document.getElementById('imagePreviewContainer');
            const imagePlaceholder = document.getElementById('imagePlaceholder');
            const supprimerImageCheckbox = document.getElementById('supprimer_image');

            // Aperçu de la nouvelle image
            imageInput.addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        imagePreview.src = e.target.result;
                        imagePreviewContainer.style.display = 'block';
                        imagePlaceholder.style.display = 'none';
                    }
                    reader.readAsDataURL(file);
                } else {
                    imagePreviewContainer.style.display = 'none';
                    imagePlaceholder.style.display = 'block';
                }
            });

            // Désactiver la case à cocher suppression si une nouvelle image est sélectionnée
            imageInput.addEventListener('change', function () {
                if (this.files.length > 0 && supprimerImageCheckbox) {
                    supprimerImageCheckbox.checked = false;
                }
            });

            // Désactiver le champ fichier si la suppression est cochée
            if (supprimerImageCheckbox) {
                supprimerImageCheckbox.addEventListener('change', function () {
                    if (this.checked) {
                        imageInput.disabled = true;
                        imagePreviewContainer.style.display = 'none';
                        imagePlaceholder.style.display = 'block';
                        imageInput.value = '';
                    } else {
                        imageInput.disabled = false;
                    }
                });
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const imageInput = document.getElementById('imageInput');
            const imagePreview = document.getElementById('imagePreview');
            const imagePreviewContainer = document.getElementById('imagePreviewContainer');
            const imagePlaceholder = document.getElementById('imagePlaceholder');

            imageInput.addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        imagePreview.src = e.target.result;
                        imagePreviewContainer.style.display = 'block';
                        imagePlaceholder.style.display = 'none';
                    }
                    reader.readAsDataURL(file);
                } else {
                    imagePreviewContainer.style.display = 'none';
                    imagePlaceholder.style.display = 'block';
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const imageInput = document.getElementById('imageInput');
            const imagePreview = document.getElementById('imagePreview');
            const imagePreviewContainer = document.getElementById('imagePreviewContainer');
            const imagePlaceholder = document.getElementById('imagePlaceholder');
            const supprimerImageCheckbox = document.getElementById('supprimer_image');

            // Aperçu de la nouvelle image
            imageInput.addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        imagePreview.src = e.target.result;
                        imagePreviewContainer.style.display = 'block';
                        imagePlaceholder.style.display = 'none';
                    }
                    reader.readAsDataURL(file);
                } else {
                    imagePreviewContainer.style.display = 'none';
                    imagePlaceholder.style.display = 'block';
                }
            });

            // Désactiver la case à cocher suppression si une nouvelle image est sélectionnée
            if (supprimerImageCheckbox) {
                imageInput.addEventListener('change', function () {
                    if (this.files.length > 0) {
                        supprimerImageCheckbox.checked = false;
                    }
                });

                // Désactiver le champ fichier si la suppression est cochée
                supprimerImageCheckbox.addEventListener('change', function () {
                    if (this.checked) {
                        imageInput.disabled = true;
                        imagePreviewContainer.style.display = 'none';
                        imagePlaceholder.style.display = 'block';
                        imageInput.value = '';
                    } else {
                        imageInput.disabled = false;
                    }
                });
            }
        });
    </script>

    
</body>

</html>