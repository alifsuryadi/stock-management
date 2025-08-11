@extends('layouts.admin')

@section('title', 'Tambah Transaksi - Stock Management')
@section('header', 'Tambah Transaksi')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="fas fa-plus-circle me-2"></i>
                        Form Transaksi Baru
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.transactions.store') }}" method="POST" id="transactionForm">
                        @csrf

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="type" class="form-label">
                                    <i class="fas fa-exchange-alt me-1"></i>
                                    Tipe Transaksi
                                </label>
                                <select class="form-select @error('type') is-invalid @enderror" id="type"
                                    name="type" required>
                                    <option value="">Pilih Tipe Transaksi</option>
                                    <option value="in" {{ old('type') == 'in' ? 'selected' : '' }}>
                                        <i class="fas fa-arrow-down"></i> Stock In (Barang Masuk)
                                    </option>
                                    <option value="out" {{ old('type') == 'out' ? 'selected' : '' }}>
                                        <i class="fas fa-arrow-up"></i> Stock Out (Barang Keluar)
                                    </option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="transaction_date" class="form-label">
                                    <i class="fas fa-calendar me-1"></i>
                                    Tanggal Transaksi
                                </label>
                                <input type="datetime-local"
                                    class="form-control @error('transaction_date') is-invalid @enderror"
                                    id="transaction_date" name="transaction_date"
                                    value="{{ old('transaction_date', now()->format('Y-m-d\TH:i')) }}" required>
                                @error('transaction_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="notes" class="form-label">
                                    <i class="fas fa-sticky-note me-1"></i>
                                    Catatan (Opsional)
                                </label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="1"
                                    placeholder="Masukkan catatan transaksi...">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0">
                                <i class="fas fa-boxes me-2"></i>
                                Daftar Produk
                            </h6>
                            <button type="button" class="btn btn-success btn-sm" id="addProduct">
                                <i class="fas fa-plus me-1"></i>
                                Tambah Produk
                            </button>
                        </div>

                        <div id="products-container">
                            <div class="product-row card mb-3">
                                <div class="card-body">
                                    <div class="row align-items-end">
                                        <div class="col-md-7">
                                            <label class="form-label">Pilih Produk</label>
                                            <select class="form-select product-select" name="products[0][product_id]"
                                                required>
                                                <option value="">-- Pilih Produk --</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}" data-stock="{{ $product->stock }}">
                                                        {{ $product->name }} ({{ $product->category->name }}) - Stok:
                                                        {{ $product->stock }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Quantity</label>
                                            <input type="number" class="form-control quantity-input"
                                                name="products[0][quantity]" min="1" placeholder="0" required>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-danger btn-sm remove-product w-100"
                                                style="display: none;">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <small class="text-muted stock-info"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan Transaksi
                            </button>
                            <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let productIndex = 1;

        // Product data for JavaScript
        const productData = {!! json_encode(
            $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'category' => $product->category->name,
                    'stock' => $product->stock,
                ];
            }),
        ) !!};

        document.getElementById('addProduct').addEventListener('click', function() {
            const container = document.getElementById('products-container');

            let optionsHtml = '<option value="">-- Pilih Produk --</option>';
            productData.forEach(product => {
                optionsHtml += `<option value="${product.id}" data-stock="${product.stock}">
            ${product.name} (${product.category}) - Stok: ${product.stock}
        </option>`;
            });

            const newRow = document.createElement('div');
            newRow.className = 'product-row card mb-3';
            newRow.innerHTML = `
        <div class="card-body">
            <div class="row align-items-end">
                <div class="col-md-7">
                    <label class="form-label">Pilih Produk</label>
                    <select class="form-select product-select" name="products[${productIndex}][product_id]" required>
                        ${optionsHtml}
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Quantity</label>
                    <input type="number" class="form-control quantity-input" 
                           name="products[${productIndex}][quantity]" min="1" placeholder="0" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-sm remove-product w-100">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <small class="text-muted stock-info"></small>
                </div>
            </div>
        </div>
    `;

            container.appendChild(newRow);
            productIndex++;

            updateRemoveButtons();
        });

        // Remove product row
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-product') || e.target.closest('.remove-product')) {
                const row = e.target.closest('.product-row');
                row.remove();
                updateRemoveButtons();
            }
        });

        function updateRemoveButtons() {
            const rows = document.querySelectorAll('.product-row');
            rows.forEach((row, index) => {
                const removeBtn = row.querySelector('.remove-product');
                if (rows.length > 1) {
                    removeBtn.style.display = 'block';
                } else {
                    removeBtn.style.display = 'none';
                }
            });
        }

        // Validate stock and show info
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('product-select')) {
                const row = e.target.closest('.product-row');
                const stockInfo = row.querySelector('.stock-info');
                const quantityInput = row.querySelector('.quantity-input');

                if (e.target.value) {
                    const selectedOption = e.target.querySelector(`option[value="${e.target.value}"]`);
                    const stock = parseInt(selectedOption.dataset.stock);
                    const productName = selectedOption.textContent.split(' (')[0];

                    stockInfo.innerHTML =
                        `<i class="fas fa-info-circle me-1"></i>Stok tersedia: <strong>${stock}</strong> unit untuk <strong>${productName}</strong>`;
                    quantityInput.max = stock;
                } else {
                    stockInfo.innerHTML = '';
                    quantityInput.max = '';
                }
            }

            if (e.target.classList.contains('quantity-input') || e.target.classList.contains('product-select')) {
                validateStockOnInput();
            }
        });

        function validateStockOnInput() {
            const typeSelect = document.getElementById('type');
            const rows = document.querySelectorAll('.product-row');

            if (typeSelect.value === 'out') {
                rows.forEach(row => {
                    const productSelect = row.querySelector('.product-select');
                    const quantityInput = row.querySelector('.quantity-input');
                    const stockInfo = row.querySelector('.stock-info');

                    if (productSelect.value && quantityInput.value) {
                        const selectedOption = productSelect.querySelector(
                        `option[value="${productSelect.value}"]`);
                        const stock = parseInt(selectedOption.dataset.stock);
                        const quantity = parseInt(quantityInput.value);

                        if (quantity > stock) {
                            quantityInput.classList.add('is-invalid');
                            stockInfo.innerHTML = `<i class="fas fa-exclamation-triangle text-danger me-1"></i>
                        <span class="text-danger">Quantity melebihi stok tersedia! Maksimal: ${stock}</span>`;
                            quantityInput.value = stock;
                        } else {
                            quantityInput.classList.remove('is-invalid');
                            const productName = selectedOption.textContent.split(' (')[0];
                            stockInfo.innerHTML = `<i class="fas fa-check-circle text-success me-1"></i>
                        <span class="text-success">Valid - Stok ${productName}: ${stock}</span>`;
                        }
                    }
                });
            }
        }

        // Form validation before submit
        document.getElementById('transactionForm').addEventListener('submit', function(e) {
            const typeSelect = document.getElementById('type');

            if (typeSelect.value === 'out') {
                const rows = document.querySelectorAll('.product-row');
                let hasError = false;

                rows.forEach(row => {
                    const productSelect = row.querySelector('.product-select');
                    const quantityInput = row.querySelector('.quantity-input');

                    if (productSelect.value && quantityInput.value) {
                        const selectedOption = productSelect.querySelector(
                            `option[value="${productSelect.value}"]`);
                        const stock = parseInt(selectedOption.dataset.stock);
                        const quantity = parseInt(quantityInput.value);

                        if (quantity > stock) {
                            hasError = true;
                        }
                    }
                });

                if (hasError) {
                    e.preventDefault();
                    alert('Terdapat quantity yang melebihi stok tersedia. Silakan periksa kembali.');
                }
            }
        });

        // Update stock info when transaction type changes
        document.getElementById('type').addEventListener('change', function() {
            validateStockOnInput();
        });
    </script>
@endsection
