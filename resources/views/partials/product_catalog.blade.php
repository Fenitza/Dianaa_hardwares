<!-- Spacer Block -->
<div class="custom-spacer" style="height: 30px;"></div>

<!-- Catalog View -->
<div class="container-fluid catalog-view">

@php
    $productsBySize = $products->groupBy('Size');
@endphp

@foreach ($productsBySize as $size => $products)
    <div class="mb-4">
        <h5 class="text-primary">Thread Size: {{ $size }}</h5>

        <!-- Responsive Table Wrapper -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table">
                    <tr>
                        <th>SKU</th>
                        <th>Thread Size</th>
                        <th>Length</th>
                        <th>Grade</th>
                        <th>Pitch</th>
                        <th>Weight (g)</th>
                        <th>Availability</th>
                        <th>Online Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        @php
                            $variant = $product->colorVariants->first();
                            $salePrice = $variant->sale_price ?? $product->SalePrice;
                            $discount = $product->discount ?? 0;
                            $onlinePrice = $salePrice - ($salePrice * $discount / 100);
                        @endphp
                        <tr>
                            <td>{{ $product->SKU }}</td>
                            <td>{{ $product->Size }}</td>
                            <td>{{ $product->Length }}</td>
                            <td>{{ $product->grade }}</td>
                            <td>{{ $product->pitch }}</td>
                            <td>{{ $product->weight }}</td>
                            <td>
                                <span class="{{ $product->Quantity > 0 ? 'text-success' : 'text-danger' }}">
                                    {{ $product->Quantity > 0 ? 'In Stock' : 'Out of Stock' }}
                                </span>
                            </td>
                            <td>₹{{ number_format($onlinePrice, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- End Responsive Table Wrapper -->

    </div>
@endforeach

</div>

<!-- Spacer Block -->
<div class="custom-spacer" style="height: 50px;"></div>
