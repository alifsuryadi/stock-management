@extends('layouts.admin')

@section('title', 'Tambah Transaksi - Stock Management')
@section('header', 'Tambah Transaksi')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Form Transaksi</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.transactions.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="type" class="form-label">Tipe Transaksi</label>
                                <select class="form-select @error('type') is-invalid @enderror" id="type"
                                    name="type" required>
                                    <option value="">Pilih Tipe</option>
                                    <option value="in" {{ old('type') == 'in' ? 'selected' : '' }}>Stock In (Masuk)
                                    </option>
                                    <option value="out" {{ old('type') == 'out' ? 'selected' : '' }}>Stock Out (Keluar)
                                    </option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="transaction_date" class="form-label">Tanggal Transaksi</label>
                                <input type="datetime-local"
                                    class="form-control @error('transaction_date') is-invalid @enderror"
                                    id="transaction_date" name="transaction_date"
                                    value="{{ old('transaction_date', now()->format('Y-m-d\TH:i')) }}" required>
                                @error('transaction_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="notes" class="form-label">Catatan</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="1">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr>
                        <h6>Produk</h6>

                        <div id="products-container">
                            <div class="product-row row mb-3">
                                <div class="col-md-8">
                                    <label class="form-label">Produk</label>
                                    <select class="form-select product-select" name="products[0][product_id]" required>
                                        <option value="">Pilih Produk</option>
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
                                    <input type="number" class="form-control quantity-input" name="products[0][quantity]"
                                        min="1" required>
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label">&nbsp;</label>
                                    <button type="button" class="btn btn-danger d-block remove-product"
                                        style="display: none;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-success mb-3" id="add-product">
                            <i class="fas fa-plus"></i> Tambah Produk
                        </button>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
                            <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary">Batal</a>
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

        document.getElementById('add-product').addEventListener('click', function() {
            const container = document.getElementById('products-container');
            const productOptions = @json(
                $products->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'category' => $product->category->name,
                        'stock' => $product->stock,
                    ];
                }));

            let optionsHtml = '<option value="">Pilih Produk</option>';
            productOptions.forEach(product => {
                optionsHtml += `<option value="${product.id}" data-stock="${product.stock}">
            ${product.name} (${product.category}) - Stok: ${product.stock}
        </option>`;
            });

            const newRow = document.createElement('div');
            newRow.className = 'product-row row mb-3';
            newRow.innerHTML = `
        <div class="col-md-8">
            <select class="form-select product-select" name="products[${productIndex}][product_id]" required>
                ${optionsHtml}
            </select>
        </div>
        <div class="col-md-3">
            <input type="number" class="form-control quantity-input" name="products[${productIndex}][quantity]" min="1" required>
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-danger remove-product">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    `;

            container.appendChild(newRow);
            productIndex++;

            updateRemoveButtons();
        });

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

        // Validate stock for out transactions
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('quantity-input') || e.target.classList.contains('product-select')) {
                const row = e.target.closest('.product-row');
                const typeSelect = document.getElementById('type');
                const productSelect = row.querySelector('.product-select');
                const quantityInput = row.querySelector('.quantity-input');

                if (typeSelect.value === 'out' && productSelect.value && quantityInput.value) {
                    const selectedOption = productSelect.querySelector(`option[value="${productSelect.value}"]`);
                    const stock = parseInt(selectedOption.dataset.stock);
                    const quantity = parseInt(quantityInput.value);

                    if (quantity > stock) {
                        alert(`Quantity tidak boleh melebihi stok yang tersedia (${stock})`);
                        quantityInput.value = stock;
                    }
                }
            }
        });
    </script>
@endsection
