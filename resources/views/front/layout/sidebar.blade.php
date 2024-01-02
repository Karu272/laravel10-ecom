@if (!request()->is('/') && !request()->is(url('/')))
    <br>
    <div class="col-md-3 d-none d-md-block">
        <br>
        <div class="col-md-12 text-center mb-3">
            <img class="img-fluid" style="width: 45%;" src="{{ asset('front/img/logos/logo1.png') }}" alt="logo">
        </div>
        <div class="container-fluid">
            <div style="border: 1px solid #ccc; box-shadow: 5px 0 5px -5px rgba(0, 0, 0, 0.2);">
                <h2 style="text-align: center;" class="ml-sm-0">Categories</h2>
                <!-- Add your side menu content here -->
                <div class="row mb-5 ml-sm-0">
                    <div class="col-md-12">
                        <ul class="nav flex-column">
                            @foreach ($categories as $category)
                                <li class="nav-item">
                                    <a class="nav-link mb-1 boldtxt" data-toggle="collapse"
                                        href="#{{ strtolower(str_replace(' ', '', $category['category_name'])) }}"
                                        aria-expanded="false">
                                        <h5>&hearts;&nbsp;{{ $category['category_name'] }}</h5>
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
                                                            <h6>&nbsp;&rarr;{{ $subcategory['category_name'] }}</h6>
                                                        </a>
                                                        <div class="collapse"
                                                            id="{{ strtolower(str_replace(' ', '', $subcategory['category_name'])) }}">
                                                            @if (isset($subcategory['subcategories']) && count($subcategory['subcategories']) > 0)
                                                                <ul class="nav flex-column ml-3">
                                                                    @foreach ($subcategory['subcategories'] as $subsubcategory)
                                                                        <li class="nav-item">
                                                                            <a class="nav-link mb-1"
                                                                                href="{{ $subsubcategory['url'] }}">
                                                                                <h6>&nbsp;&rarr;{{ $subsubcategory['category_name'] }}
                                                                                </h6>
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
            <br>
            <div style="border: 1px solid #ccc; box-shadow: 5px 0 5px -5px rgba(0, 0, 0, 0.2);">
                <h2 style="text-align: center;" class="ml-sm-0">Color</h2>
                <div class="row mb-5 ml-sm-0">
                    <div class="col-md-12">
                        <ul class="nav flex-column">
                            @foreach ($colors as $key => $color)
                                <li class="d-flex align-items-center">
                                    <input type="checkbox" id="color{{ $key }}" name="color"
                                        value="{{ $color }}" class="filterAjax">
                                    <label
                                        style="background-color: {{ $color }}; width: 20px; height: 20px; border: 1px solid #000;"
                                        for="color{{ $key }}" title="{{ $color }}"
                                        class="ml-2"></label>&nbsp;&nbsp;{{ $color }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

@if (request()->is('/'))
    <br>
    <div class="col-md-3 d-none d-md-block">
        <br>
        <div class="col-md-12 text-center mb-3">
            <img class="img-fluid" style="width: 45%;" src="{{ asset('front/img/logos/logo1.png') }}" alt="logo">
        </div>
        <div class="container-fluid">
            <!-- Add your content here -->
            <img class="img-fluid" style="width: 100%;" src="{{ asset('front/img/logos/69.jpg') }}" alt="largerlogo">
        </div>
    </div>
@endif
