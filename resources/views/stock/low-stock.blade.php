<x-mail::message>
# Peringatan Stok Menipis

Halo Admin,

Stok produk berikut telah mencapai batas minimum dan perlu segera diisi ulang.

| | |
|---|---|
| **Produk** | {{ $product->name }} |
| **SKU** | {{ $product->sku }} |
| **Stok Saat Ini** | {{ $product->stock }} |
| **Minimum Stok** | {{ $product->min_stock }} |

Harap segera lakukan pengisian stok untuk menghindari kehabisan barang.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
