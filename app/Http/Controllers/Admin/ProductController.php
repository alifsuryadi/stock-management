<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the products with advanced filtering and pagination
     */
    public function index(Request $request)
    {
        try {
            $query = Product::with('category');
            
            // Search functionality
            if ($request->filled('search')) {
                $search = trim($request->search);
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhereHas('category', function ($categoryQuery) use ($search) {
                          $categoryQuery->where('name', 'like', "%{$search}%");
                      });
                });
            }
            
            // Category filter
            if ($request->filled('category')) {
                $query->where('category_id', $request->category);
            }
            
            // Stock filter
            if ($request->filled('stock_filter')) {
                switch ($request->stock_filter) {
                    case 'low':
                        $query->where('stock', '<=', 5);
                        break;
                    case 'medium':
                        $query->whereBetween('stock', [6, 20]);
                        break;
                    case 'high':
                        $query->where('stock', '>', 20);
                        break;
                }
            }
            
            // Sorting functionality
            $sortBy = $request->get('sort', 'created_at');
            $sortDirection = $request->get('direction', 'desc');
            
            $allowedSorts = ['name', 'stock', 'created_at', 'updated_at'];
            if (in_array($sortBy, $allowedSorts)) {
                if ($sortBy === 'name') {
                    $query->orderBy('name', $sortDirection);
                } elseif ($sortBy === 'stock') {
                    $query->orderBy('stock', $sortDirection);
                } elseif ($sortBy === 'updated_at') {
                    $query->orderBy('updated_at', $sortDirection);
                } else {
                    $query->orderBy('created_at', $sortDirection);
                }
            }
            
            // Pagination with custom per page
            $perPage = (int) $request->get('per_page', 15);
            $allowedPerPage = [10, 15, 25, 50];
            if (!in_array($perPage, $allowedPerPage)) {
                $perPage = 15;
            }
            
            $products = $query->paginate($perPage)
                             ->appends($request->query());
            
            // Get categories for filter dropdown
            $categories = Category::orderBy('name')->get();
            
            return view('admin.products.index', compact('products', 'categories'));
            
        } catch (\Exception $e) {
            Log::error('Error in ProductController@index: ' . $e->getMessage());
            
            return back()->with('error', 'Terjadi kesalahan saat memuat data produk.');
        }
    }

    /**
     * Show the form for creating a new product
     */
    public function create()
    {
        try {
            $categories = Category::orderBy('name')->get();
            
            if ($categories->isEmpty()) {
                return redirect()->route('admin.categories.create')
                    ->with('warning', 'Silakan buat kategori terlebih dahulu sebelum menambah produk.');
            }
            
            return view('admin.products.create', compact('categories'));
            
        } catch (\Exception $e) {
            Log::error('Error in ProductController@create: ' . $e->getMessage());
            
            return redirect()->route('admin.products.index')
                ->with('error', 'Terjadi kesalahan saat memuat form tambah produk.');
        }
    }

    /**
     * Store a newly created product in storage
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:products,name',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0|max:999999',
        ], [
            'name.required' => 'Nama produk wajib diisi.',
            'name.unique' => 'Nama produk sudah ada, gunakan nama lain.',
            'name.max' => 'Nama produk maksimal 255 karakter.',
            'description.max' => 'Deskripsi maksimal 1000 karakter.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar yang diizinkan: JPEG, PNG, JPG, GIF, WEBP.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'stock.required' => 'Stok wajib diisi.',
            'stock.integer' => 'Stok harus berupa angka.',
            'stock.min' => 'Stok minimal 0.',
            'stock.max' => 'Stok maksimal 999999.',
        ]);

        try {
            DB::beginTransaction();
            
            $data = $request->only(['name', 'description', 'category_id', 'stock']);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time() . '_' . $image->getClientOriginalName();
                $data['image'] = $image->storeAs('products', $filename, 'public');
            }

            Product::create($data);
            
            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Produk berhasil ditambahkan!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Delete uploaded image if exists
            if (isset($data['image']) && Storage::disk('public')->exists($data['image'])) {
                Storage::disk('public')->delete($data['image']);
            }
            
            Log::error('Error in ProductController@store: ' . $e->getMessage());
            
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan produk.');
        }
    }

    /**
     * Display the specified product
     */
    public function show(Product $product)
    {
        try {
            $product->load('category');
            return view('admin.products.show', compact('product'));
            
        } catch (\Exception $e) {
            Log::error('Error in ProductController@show: ' . $e->getMessage());
            
            return redirect()->route('admin.products.index')
                ->with('error', 'Produk tidak ditemukan.');
        }
    }

    /**
     * Show the form for editing the specified product
     */
    public function edit(Product $product)
    {
        try {
            $categories = Category::orderBy('name')->get();
            return view('admin.products.edit', compact('product', 'categories'));
            
        } catch (\Exception $e) {
            Log::error('Error in ProductController@edit: ' . $e->getMessage());
            
            return redirect()->route('admin.products.index')
                ->with('error', 'Terjadi kesalahan saat memuat form edit produk.');
        }
    }

    /**
     * Update the specified product in storage
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:products,name,' . $product->id,
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0|max:999999',
        ], [
            'name.required' => 'Nama produk wajib diisi.',
            'name.unique' => 'Nama produk sudah ada, gunakan nama lain.',
            'name.max' => 'Nama produk maksimal 255 karakter.',
            'description.max' => 'Deskripsi maksimal 1000 karakter.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar yang diizinkan: JPEG, PNG, JPG, GIF, WEBP.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'stock.required' => 'Stok wajib diisi.',
            'stock.integer' => 'Stok harus berupa angka.',
            'stock.min' => 'Stok minimal 0.',
            'stock.max' => 'Stok maksimal 999999.',
        ]);

        try {
            DB::beginTransaction();
            
            $data = $request->only(['name', 'description', 'category_id', 'stock']);
            $oldImage = $product->image;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time() . '_' . $image->getClientOriginalName();
                $data['image'] = $image->storeAs('products', $filename, 'public');
            }

            $product->update($data);
            
            // Delete old image after successful update
            if ($request->hasFile('image') && $oldImage && Storage::disk('public')->exists($oldImage)) {
                Storage::disk('public')->delete($oldImage);
            }
            
            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Produk berhasil diperbarui!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Delete newly uploaded image if exists
            if (isset($data['image']) && Storage::disk('public')->exists($data['image'])) {
                Storage::disk('public')->delete($data['image']);
            }
            
            Log::error('Error in ProductController@update: ' . $e->getMessage());
            
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui produk.');
        }
    }

    /**
     * Remove the specified product from storage
     */
    public function destroy(Product $product)
    {
        try {
            DB::beginTransaction();
            
            $imagePath = $product->image;
            
            $product->delete();
            
            // Delete image after successful deletion
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            
            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Produk berhasil dihapus!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error in ProductController@destroy: ' . $e->getMessage());
            
            return redirect()->route('admin.products.index')
                ->with('error', 'Terjadi kesalahan saat menghapus produk.');
        }
    }

    /**
     * Bulk actions for products
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,update_stock',
            'products' => 'required|array',
            'products.*' => 'exists:products,id',
            'stock_value' => 'required_if:action,update_stock|integer|min:0',
        ]);

        try {
            DB::beginTransaction();
            
            $productIds = $request->products;
            $products = Product::whereIn('id', $productIds)->get();
            
            switch ($request->action) {
                case 'delete':
                    foreach ($products as $product) {
                        if ($product->image && Storage::disk('public')->exists($product->image)) {
                            Storage::disk('public')->delete($product->image);
                        }
                    }
                    Product::whereIn('id', $productIds)->delete();
                    $message = 'Produk terpilih berhasil dihapus!';
                    break;
                    
                case 'update_stock':
                    Product::whereIn('id', $productIds)->update(['stock' => $request->stock_value]);
                    $message = 'Stok produk terpilih berhasil diperbarui!';
                    break;
            }
            
            DB::commit();
            
            return redirect()->route('admin.products.index')
                ->with('success', $message);
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error in ProductController@bulkAction: ' . $e->getMessage());
            
            return redirect()->route('admin.products.index')
                ->with('error', 'Terjadi kesalahan saat melakukan aksi bulk.');
        }
    }

    /**
     * Get low stock products
     */
    public function lowStock()
    {
        try {
            $products = Product::with('category')
                ->where('stock', '<=', 5)
                ->orderBy('stock', 'asc')
                ->paginate(15);
                
            return view('admin.products.low-stock', compact('products'));
            
        } catch (\Exception $e) {
            Log::error('Error in ProductController@lowStock: ' . $e->getMessage());
            
            return redirect()->route('admin.products.index')
                ->with('error', 'Terjadi kesalahan saat memuat data stok rendah.');
        }
    }
}