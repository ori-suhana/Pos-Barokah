<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Data Produk</h2>
            <a href="{{ route('products.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm">
                + Tambah Produk
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Form Pencarian & Filter -->
            <form method="GET" action="{{ route('products.index') }}" class="flex flex-wrap gap-3 mb-4 items-center">
                <!-- Input Cari Nama/Kode -->
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari nama atau kode produk..."
                       class="flex-1 min-w-[200px] rounded-md border-gray-300 shadow-sm">
            
                <!-- Filter Kategori -->
                <select name="category_id" class="rounded-md border-gray-300 shadow-sm">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <!-- Filter Status Stok (Baru) -->
                <select name="stock_status" class="rounded-md border-gray-300 shadow-sm">
                    <option value="">Semua Status Stok</option>
                    <option value="menipis" @selected(request('stock_status') == 'menipis')>Stok Menipis</option>
                    <option value="habis" @selected(request('stock_status') == 'habis')>Stok Habis</option>
                </select>

                <!-- Pilihan Jumlah Data per Halaman (Baru) -->
                <select name="per_page" class="rounded-md border-gray-300 shadow-sm" onchange="this.form.submit()">
                    <option value="10" @selected(request('per_page') == 10)>10 / hal</option>
                    <option value="25" @selected(request('per_page') == 25)>25 / hal</option>
                    <option value="50" @selected(request('per_page') == 50)>50 / hal</option>
                </select>
            
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm">Cari</button>
                <a href="{{ route('products.index') }}" class="px-4 py-2 text-gray-500 text-sm flex items-center">Reset</a>
            </form>

            <x-card>
                @if (session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-md text-sm">
                        {{ session('success') }}
                    </div>
                @endif
 
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Kode</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Nama Produk</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Kategori</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500">Harga</th>
                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500">Stok</th>
                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($products as $product)
                            <tr class="@if ($product->stock == 0) bg-red-50 @elseif ($product->stock < 10) bg-yellow-50 @endif">
                                <td class="px-4 py-2 text-sm">{{ $product->code }}</td>
                                <td class="px-4 py-2 text-sm">{{ $product->name }}</td>
                                <td class="px-4 py-2 text-sm">{{ $product->category->name }}</td>
                                <td class="px-4 py-2 text-sm text-right">
                                    Rp{{ number_format($product->price, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-2 text-sm text-center font-semibold">
                                    {{ $product->stock }}
                                    @if ($product->stock == 0)
                                        <span class="text-red-600 text-xs block">Habis</span>
                                    @elseif ($product->stock < 10)
                                        <span class="text-yellow-600 text-xs block">Menipis</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-sm text-center space-x-2">
                                    <a href="{{ route('products.edit', $product) }}" class="text-indigo-600">Ubah</a>
                                    <form action="{{ route('products.destroy', $product) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus produk {{ $product->name }}?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                                    Belum ada data produk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
 
                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>