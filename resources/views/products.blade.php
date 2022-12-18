@extends('layouts.app')
@section('content')

<div class="bg-white">     
  
    <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex items-baseline justify-between border-b border-gray-200 pt-6 pb-6">
            <h1 class="text-4xl font-bold tracking-tight text-gray-900">New Arrivals</h1>
        </div>
  
        <section aria-labelledby="products-heading" class="pt-6 pb-24">
  
            <div class="grid grid-cols-1 gap-x-8 gap-y-10 lg:grid-cols-4">
            <form class="hidden lg:block" method="get" action="{{ route('products.index') }}">
                {{ csrf_field() }}
              <div class="border-b border-gray-200 py-6">
                <h3 class="-my-3 flow-root">
                  <!-- Expand/collapse section button -->
                  <button type="button" class="flex w-full items-center justify-between bg-white py-3 text-sm text-gray-400 hover:text-gray-500" aria-controls="filter-section-0" aria-expanded="false">
                    <span class="font-medium text-gray-900">Title</span>
                  </button>
                </h3>
                <div class="pt-6" id="filter-section-0">
                  <div class="space-y-4">
                    <div class="flex items-center">
                        <input type="text" id="title" name="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search by title" value="{{ request('title') }}">
                    </div>
                  </div>
                </div>
              </div>
  
              <div class="border-b border-gray-200 py-6">
                <h3 class="-my-3 flow-root">
                  <button type="button" class="flex w-full items-center justify-between bg-white py-3 text-sm text-gray-400 hover:text-gray-500" aria-controls="filter-section-1" aria-expanded="false">
                    <span class="font-medium text-gray-900">Product Type</span>
                  </button>
                </h3>
                <div class="pt-6" id="filter-section-1">
                  <div class="space-y-4">
                    <div class="flex items-center">
                        <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="product_type_id">
                            <option value="">Select Product type </option>
                            @foreach ($productTypes as $productType)
                                <option value="{{ $productType->id }}" {{ request('product_type_id') == $productType->id ? 'selected' : '' }}>{{ $productType->name }}</option>
                            @endforeach
                        </select>
                    </div>
                  </div>
                </div>
              </div>
  
              <div class="border-b border-gray-200 py-6">
                <h3 class="-my-3 flow-root">
                  <button type="button" class="flex w-full items-center justify-between bg-white py-3 text-sm text-gray-400 hover:text-gray-500" aria-controls="filter-section-2" aria-expanded="false">
                    <span class="font-medium text-gray-900">Brand</span>
                  </button>
                </h3>
                <div class="pt-6" id="filter-section-2">
                  <div class="space-y-4">
                    <div class="flex items-center">
                        <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="product_brand_id"> 
                            <option value="">Select Brand </option>
                            @foreach ($productBrands as $productBrand)
                                <option value="{{ $productBrand->id }}" {{ request('product_brand_id') == $productBrand->id ? 'selected' : '' }}>{{ $productBrand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                  </div>
                </div>
                <br>
                <button type="submit" class="inline-flex items-center transition-colors font-medium select-none disabled:opacity-50 disabled:cursor-not-allowed focus:outline-none dark:focus:ring-offset-dark-eval-2 bg-cyan-500 text-black-500 hover:bg-gray-200 focus:bg-gray-400 border px-4 py-2 text-base rounded-md" aria-controls="filter-section-2" aria-expanded="false">
                    <span class="font-medium text-gray-900">Search</span>
                  </button>&nbsp;&nbsp;
                  <a href="{{ route('products.index') }}" class="inline-flex items-center transition-colors font-medium select-none disabled:opacity-50 disabled:cursor-not-allowed focus:outline-none dark:focus:ring-offset-dark-eval-2 bg-cyan-500 text-black-500 hover:bg-gray-200 focus:bg-gray-400 border px-4 py-2 text-base rounded-md">
                    <span class="font-medium text-gray-900">Reset</span>
                  </a>
              </div>
            </form>
  
            <!-- Product grid -->
            <div class="lg:col-span-3">
              <div class="h-96 rounded-lg border-4 border-dashed border-gray-200 lg:h-full">
                <div class="bg-white">
                    <div class="mx-auto max-w-2xl py-4 px-4 sm:py-6 sm:px-6 lg:max-w-7xl lg:px-8">
                  
                      <div class="mt-6 grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 xl:gap-x-8">
                        @foreach ($products as $product)
                            <div class="group relative">
                            <div class="min-h-80 aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-md bg-gray-200 group-hover:opacity-75 lg:aspect-none lg:h-80">
                              <img src="{{ $product->image_link }}" alt="Front of men&#039;s Basic Tee in black." class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                            </div>
                            <div class="mt-4 flex justify-between">
                              <div>
                                <h3 class="text-sm text-gray-700">
                                  <a href="{{ route('products.show', $product) }}">
                                    <span aria-hidden="true" class="absolute inset-0"></span>
                                     {{ $product->title }}
                                  </a>
                                </h3>
                                <p class="mt-1 text-sm text-gray-500">Sizes: </p>
                                <p class="mt-1 text-sm text-gray-500">
                                    @foreach ($product->variants as $variant)
                                        ({{ $variant->size }})
                                        @if(!$loop->last)  - @endif
                                        
                                    @endforeach
                                </p>
                              </div>
                              <p class="text-sm font-medium text-gray-900">{{ $product->price }}</p>
                            </div>
                          </div>    
                        @endforeach
                      </div><br>
                      {{ $products->appends([
                        'title' => request('title'),
                        'product_brand_id' => request('product_brand_id'),
                        'product_type_id' => request('product_type_id'),
                      ])->links() }}
                    </div>
                  </div>
              </div>
            </div>
          </div>
        </section>
      </main>
    
  </div>
  
  

@endsection