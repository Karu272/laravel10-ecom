<div class="mb-2 mt-1">
    <span style="background-color: white;">&nbsp;FOUND {{ count($categoryProducts) }} RESULTS&nbsp;</span>
    <nav class="mt-4" aria-label="breadcrumb">
        <ol style="background-color: white;" class="breadcrumb">
            <select class="form-select" name="sort" id="sort">
                <option value="product_latest" {{ $sort == 'product_latest' ? 'selected' : '' }}>Sort By: Latest Items</option>
                <option value="best_selling" {{ $sort == 'best_selling' ? 'selected' : '' }}>Sort By: Best Selling</option>
                <option value="best_rating" {{ $sort == 'best_rating' ? 'selected' : '' }}>Sort By: Best Rating</option>
                <option value="lowest_price" {{ $sort == 'lowest_price' ? 'selected' : '' }}>Sort By: Lowest Price</option>
                <option value="highest_price" {{ $sort == 'highest_price' ? 'selected' : '' }}>Sort By: Highest Price</option>
                <option value="featured_items" {{ $sort == 'featured_items' ? 'selected' : '' }}>Sort By: Featured Items</option>
                <option value="discounted_items" {{ $sort == 'discounted_items' ? 'selected' : '' }}>Sort By: Discounted Items</option>
            </select>
            <li class="breadcrumb-item ml-auto"><a href="{{ url('/') }}">Home</a>&nbsp;&rarr;<?php echo $getCategoriesDetails['breadcrumbs']; ?>
            </li>
        </ol>
    </nav>
</div>

