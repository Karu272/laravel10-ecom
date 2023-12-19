<br>
<div class="col-md-3 d-none d-md-block">
    <br>
    <div class="col-md-12 text-center mb-3">
        <img class="img-fluid" src="{{ asset('front/img/logos/logo1.png') }}" alt="logo">
    </div>
    <div class="container-fluid">
        <h2 class="ml-5 ml-sm-0">Side Menu</h2>
        <!-- Add your side menu content here -->
        <div class="row mb-5 ml-5 ml-sm-0">
            <div class="col-md-3">
                <ul class="nav flex-column">
                    @foreach ($categories as $category)
                        <li class="nav-item">
                            <a class="nav-link mb-1" data-toggle="collapse"
                                href="#{{ strtolower(str_replace(' ', '', $category['category_name'])) }}"
                                aria-expanded="false">
                                &hearts;&nbsp;{{ $category['category_name'] }}
                            </a>
                            <div class="collapse"
                                id="{{ strtolower(str_replace(' ', '', $category['category_name'])) }}">
                                @if (isset($category['subcategories']) && count($category['subcategories']) > 0)
                                    <ul class="nav flex-column ml-3">
                                        @foreach ($category['subcategories'] as $subcategory)
                                            <li class="nav-item">
                                                <a class="nav-link mb-1" data-toggle="collapse"
                                                    href="#{{ strtolower(str_replace(' ', '', $subcategory['category_name'])) }}"
                                                    aria-expanded="false">
                                                    &nbsp;&rarr;{{ $subcategory['category_name'] }}
                                                </a>
                                                <div class="collapse"
                                                    id="{{ strtolower(str_replace(' ', '', $subcategory['category_name'])) }}">
                                                    @if (isset($subcategory['subcategories']) && count($subcategory['subcategories']) > 0)
                                                        <ul class="nav flex-column ml-3">
                                                            @foreach ($subcategory['subcategories'] as $subsubcategory)
                                                                <li class="nav-item">
                                                                    <a class="nav-link mb-1" href="#">
                                                                        &nbsp;&rarr;{{ $subsubcategory['category_name'] }}
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
