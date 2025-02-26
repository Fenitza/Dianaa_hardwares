<!-- Spacer Block -->
<div class="custom-spacer" style="height: 30px;"></div>

<!-- Catalog View -->
<div class="container-fluid catalog-view">

@php
    $productsByColor = $products->groupBy('Color');
    @endphp

    @foreach ($productsByColor as $color => $products)
        <strong>Color: {{ $color }}</strong>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Weight</th>
                    <th>Dimension</th>
                    <th>Material</th>
                    <th>SKU</th>
                    <th>Availability</th>
                    <th>Sale Price</th>
                    <!-- <th>Details</th> -->
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->Weight }} g</td> <!-- Assuming there is a 'size' field -->
                        <td>{{ $product->Dimension }}</td> <!-- Assuming there is a 'dimension' field -->
                        <td>{{ $product->Material }}</td>
                        <td>{{ $product->SKU }}</td>
                        <td>{{ $product->Quantity > 0 ? 'In Stock' : 'Out of Stock' }}</td>
                        <td>${{ number_format($product->SalePrice, 2) }}</td>
                        
                    </tr>
                    
                    <!-- <button class="btn btn-primary" onclick="showProductDetails({{ $product->id }})">View Details</button> -->
                @endforeach
            </tbody>
        </table>

    @endforeach
</div>

<!-- Spacer Block -->
<div class="custom-spacer" style="height: 50px;"></div>