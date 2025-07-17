@extends('frontend.layouts.master')

@section('content')
    <!--=============================
            BREADCRUMB START
        ==============================-->
    <section class="fp__breadcrumb" style="background: url({{ asset(config('settings.breadcrumb')) }});">
        <div class="fp__breadcrumb_overlay">
            <div class="container">
                <div class="fp__breadcrumb_text">
                    <h1>Products</h1>
                    <ul>
                        <li><a href="{{ url('/') }}">home</a></li>
                        <li><a href="javascript:;">products</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
            BREADCRUMB END
        ==============================-->


    <!--=============================
            SEARCH MENU START
        ==============================-->
    {{-- <section class="fp__search_menu mt_120 xs_mt_90 mb_100 xs_mb_70"> --}}
    <section class="fp__search_menu my-5">
        <div class="container">

            {{-- search area which was removed here --}}
            {{-- <form class="fp__search_menu_form" method="GET" action="{{ route('product.index') }}">
                <div class="row">
                    <div class="col-xl-6 col-md-5">
                        <input type="text" placeholder="Search..." name="search" value="{{ @request()->search }}">
                    </div>
                    <div class="col-xl-4 col-md-4">
                        <select class="nice-select" name="category">
                            <option value="">All</option>
                            @foreach ($categories as $category)
                                <option @selected(@request()->category == $category->slug) value="{{ $category->slug }}">{{ $category->name }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="col-xl-2 col-md-3">
                        <button type="submit" class="common_btn">search</button>
                    </div>
                </div>
            </form> --}}

            <button class="btn btn-dark d-lg-none mb-1" id="sidebarToggleBtn">
                Filter Properties
            </button>
            <div class="row">

                <div class="col-lg-3 sidebar__search py-1" id="sidebar__search">
                    <div class="sidebar__content pt-3">
                        <div class="close__button" id="closeSidebarBtn">
                            <button role="button">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <h4>Filter Properties</h4>
                        <div class="search__inputs my-3">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Search On EricksonPlaza"
                                    aria-label="Search On EricksonPlaza" aria-describedby="button-addon2">
                                <button class="btn btn-outline-secondary" type="button" id="button-addon2">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="categories__box">
                            <h5 class="border-1 border-bottom pb-2 mb-2">Categories</h5>
                            <div class="category_list">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="checkChecked">
                                    <label class="form-check-label" for="checkChecked">
                                        Electronics and Gadgets
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="checkChecked">
                                    <label class="form-check-label" for="checkChecked">
                                        Fashion and Apparel
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="checkChecked">
                                    <label class="form-check-label" for="checkChecked">
                                        Books and Stationery
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="checkChecked"
                                        checked>
                                    <label class="form-check-label" for="checkChecked">
                                        Home and Kitchen
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="checkChecked">
                                    <label class="form-check-label" for="checkChecked">
                                        Sports and Fitness
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="checkChecked">
                                    <label class="form-check-label" for="checkChecked">
                                        Health and Beauty
                                    </label>
                                </div>
                            </div>
                        </div>
                        <h5 class="mt-3">Price Filter</h5>
                        <div class="search__inputs my-3">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Min Price" aria-label="Min Price"
                                    aria-describedby="button-addon2">
                                <input type="text" class="form-control left__line" placeholder="Min Price"
                                    aria-label="Min Price" aria-describedby="button-addon2">
                                <button class="btn btn-outline-secondary" type="button" id="button-addon2">GO</button>
                            </div>
                        </div>
                        <div class="categories__box">
                            <h5 class="border-1 border-bottom pb-2 mb-2">Other Categories</h5>
                            <div class="category_list">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="checkChecked1">
                                    <label class="form-check-label" for="checkChecked">
                                        Electronics and Gadgets
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="checkChecked2">
                                    <label class="form-check-label" for="checkChecked">
                                        Fashion and Apparel
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="checkChecked3">
                                    <label class="form-check-label" for="checkChecked">
                                        Books and Stationery
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9 col-md-12 col-12">
                    <div class="row">
                        @foreach ($products as $product)
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6  wow fadeInUp" data-wow-duration="1s">
                                <div class="fp__menu_item">
                                    <div class="fp__menu_item_img">
                                        <img src="{{ asset($product->thumb_image) }}" alt="{{ $product->name }}"
                                            class="img-fluid w-100">
                                        <a class="category" href="#">{{ @$product->category->name }}</a>
                                    </div>
                                    <div class="fp__menu_item_text">
                                        @if ($product->reviews_avg_rating)
                                            <p class="rating">
                                                @for ($i = 1; $i <= $product->reviews_avg_rating; $i++)
                                                    <i class="fas fa-star"></i>
                                                @endfor

                                                <span>{{ $product->reviews_count }}</span>
                                            </p>
                                        @endif
                                        <a class="title"
                                            href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                                        <h5 class="price">
                                            @if ($product->offer_price > 0)
                                                {{ currencyPosition($product->offer_price) }}
                                                <del>{{ currencyPosition($product->price) }}</del>
                                            @else
                                                {{ currencyPosition($product->price) }}
                                            @endif
                                        </h5>
                                        <ul class="d-flex flex-wrap justify-content-center">
                                            <li><a href="javascript:;"
                                                    onclick="loadProductModal('{{ $product->id }}')"><i
                                                        class="fas fa-shopping-basket"></i></a></li>
                                            <li><a href="#"><i class="fal fa-heart"></i></a></li>
                                            <li><a href="{{ route('product.show', $product->slug) }}"><i
                                                        class="far fa-eye"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        @if (count($products) === 0)
                            <h4 class="text-center mt-5">No Product Found!</h4>
                        @endif
                    </div>
                </div>

            </div>
            @if ($products->hasPages())
                <div class="fp__pagination mt_60">
                    <div class="row">
                        <div class="col-12">
                            {{ $products->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
