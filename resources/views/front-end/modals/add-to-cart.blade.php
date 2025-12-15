<!-- Modal d'ajout au panier avec variants -->
<div class="modal fade custom-modal" id="addToCartModal" tabindex="-1" aria-labelledby="addToCartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white border-0">
                <h5 class="modal-title fw-bold" id="addToCartModalLabel">
                    <i class="fi-rs-shopping-cart me-2"></i>Ajouter au panier
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-0">
                <form id="addToCartModalForm" action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="produit_id" id="modal_product_id">
                    
                    <div class="row g-0">
                        <!-- Colonne image -->
                        <div class="col-md-6">
                            <div class="product-modal-image p-4">
                                <div class="position-relative">
                                    <img src="" id="modal_product_image" alt="Produit" 
                                         class="img-fluid rounded-3 shadow-sm w-100"
                                         style="max-height: 400px; object-fit: contain;">
                                    
                                    <!-- Badge promotion -->
                                    <div class="position-absolute top-0 start-0 mt-3 ms-3" id="modal_promo_badge">
                                        <span class="badge bg-danger rounded-pill px-3 py-2 shadow">
                                            <i class="fi-rs-flash me-1"></i>Promo
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Navigation des images (si plusieurs) -->
                                <div class="image-thumbnails d-flex justify-content-center mt-3" id="modal_image_thumbnails" style="display: none;">
                                    <!-- Les miniatures seront générées ici -->
                                </div>
                            </div>
                        </div>
                        
                        <!-- Colonne informations -->
                        <div class="col-md-6">
                            <div class="product-modal-info p-4 h-100">
                                <!-- Nom du produit -->
                                <h3 class="product-title mb-3" id="modal_product_name"></h3>
                                
                                <!-- Prix -->
                                <div class="product-price-section mb-4">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="current-price fs-2 fw-bold text-brand" id="modal_product_price"></span>
                                        <span class="old-price text-muted text-decoration-line-through fs-5" id="modal_product_old_price"></span>
                                    </div>
                                    <div class="text-success small mt-1" id="modal_savings">
                                        <!-- Économies calculées -->
                                    </div>
                                </div>
                                
                                <!-- Section des variants -->
                                <div class="variants-section" id="variants_section" style="display: none;">
                                    <!-- Couleurs -->
                                    <div class="variant-group mb-4">
                                        <label class="form-label fw-semibold mb-2">
                                            <i class="fi-rs-palette me-1"></i>Couleur <span class="text-danger">*</span>
                                        </label>
                                        <div class="d-flex flex-wrap gap-2 mb-2" id="color_options">
                                            <!-- Options de couleur -->
                                        </div>
                                        <input type="hidden" name="variant_id" id="selected_variant_id">
                                        <div class="form-text text-danger small d-flex align-items-center" id="color_error" style="display: none;">
                                            <i class="fi-rs-exclamation-circle me-1"></i>Veuillez sélectionner une couleur
                                        </div>
                                    </div>
                                    
                                    <!-- Tailles -->
                                    <div class="variant-group mb-4">
                                        <label class="form-label fw-semibold mb-2">
                                            <i class="fi-rs-ruler me-1"></i>Taille <span class="text-danger">*</span>
                                        </label>
                                        <div class="size-selector d-flex flex-wrap gap-2" id="size_options">
                                            <!-- Options de taille -->
                                        </div>
                                        <div class="form-text text-danger small d-flex align-items-center" id="size_error" style="display: none;">
                                            <i class="fi-rs-exclamation-circle me-1"></i>Veuillez sélectionner une taille
                                        </div>
                                    </div>
                                    
                                    <!-- Informations du variant -->
                                    <div class="variant-info bg-light rounded-3 p-3 mb-4" id="variant_info_section" style="display: none;">
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <div class="d-flex align-items-center">
                                                    <i class="fi-rs-tag text-muted me-2"></i>
                                                    <span class="text-muted small">Prix:</span>
                                                    <span class="text-brand fw-bold ms-2" id="selected_variant_price"></span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex align-items-center">
                                                    <i class="fi-rs-box text-muted me-2"></i>
                                                    <span class="text-muted small">Stock:</span>
                                                    <span class="fw-bold ms-2 text-success" id="selected_variant_stock"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Section produits sans variant -->
                                <div class="no-variants-section" id="no_variants_section" style="display: none;">
                                    <div class="stock-info bg-light rounded-3 p-3 mb-4">
                                        <div class="d-flex align-items-center">
                                            <i class="fi-rs-box text-muted me-2 fs-5"></i>
                                            <div>
                                                <div class="text-muted small">Disponibilité</div>
                                                <div class="fw-bold text-success" id="product_stock"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Quantité -->
                                <div class="quantity-section mb-4">
                                    <label class="form-label fw-semibold mb-2">
                                        <i class="fi-rs-shopping-bag me-1"></i>Quantité
                                    </label>
                                    <div class="quantity-selector d-inline-flex align-items-center border rounded-3 p-2">
                                        <button type="button" class="btn qty-btn qty-minus border-0 bg-transparent" id="modal_qty_down">
                                            <i class="fi-rs-minus-circle"></i>
                                        </button>
                                        <input type="number" name="qty" value="1" min="1" 
                                               id="modal_product_qty"
                                               class="form-control border-0 text-center shadow-none mx-2" 
                                               style="width: 70px; font-weight: bold;">
                                        <button type="button" class="btn qty-btn qty-plus border-0 bg-transparent" id="modal_qty_up">
                                            <i class="fi-rs-plus-circle"></i>
                                        </button>
                                    </div>
                                    <div class="form-text text-muted mt-1">
                                        Quantité maximale: <span id="max_quantity" class="fw-bold">999</span>
                                    </div>
                                </div>
                                
                                <!-- Message d'erreur -->
                                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" id="variant_error" style="display: none;">
                                    <i class="fi-rs-exclamation-triangle me-2"></i>
                                    <div class="flex-grow-1" id="variant_error_message"></div>
                                    <button type="button" class="btn-close" onclick="$(this).parent().hide()"></button>
                                </div>
                                
                                <!-- Boutons d'action -->
                                <div class="action-buttons mt-4 pt-3 border-top">
                                    <div class="row g-2">
                                        <div class="col-8">
                                            <button type="submit" class="btn btn-primary btn-lg w-100 py-3 fw-bold">
                                                <i class="fi-rs-shopping-cart me-2"></i>Ajouter au panier
                                            </button>
                                        </div>
                                        <div class="col-4">
                                            <a href="#" id="view_details_link" class="btn btn-outline-primary btn-lg w-100 py-3">
                                                <i class="fi-rs-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                    
                                    <!-- Actions rapides -->
                                    <div class="quick-actions d-flex justify-content-center gap-3 mt-3">
                                        <button type="button" class="btn btn-sm btn-outline-secondary" id="add_to_wishlist">
                                            <i class="fi-rs-heart"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" id="share_product">
                                            <i class="fi-rs-share"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" id="compare_product">
                                            <i class="fi-rs-shuffle"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Informations supplémentaires -->
                                <div class="additional-info mt-4">
                                    <div class="row g-2 small">
                                        <div class="col-6">
                                            <div class="d-flex align-items-center text-muted">
                                                <i class="fi-rs-truck me-2"></i>
                                                <span>Livraison gratuite</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="d-flex align-items-center text-muted">
                                                <i class="fi-rs-shield-check me-2"></i>
                                                <span>Garantie 30 jours</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="d-flex align-items-center text-muted">
                                                <i class="fi-rs-rotate-left me-2"></i>
                                                <span>Retours gratuits</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="d-flex align-items-center text-muted">
                                                <i class="fi-rs-headset me-2"></i>
                                                <span>Support 24/7</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>