@extends('app')
@section('title','Product')

@section('content')

    <div class="d-flex justify-content-end mr-4 mb-4">
        <button type="button" class="btn btn-success pr-3 pl-3 " data-target="#create" data-toggle="modal">New</button>
    </div>


    <div class="search-container d-flex justify-content-between">

        <div class="d-flex justify-content-start mr-4 mb-4">
            <form id="productFilterForm" action="{{route('product-filter')}}">
                <label class="form-label">Category
                    <select name="category" class="form-select mt-2" aria-label="Default select example">
                        <option value="">Open this select menu</option>
                        @foreach($categories as $category)
                            <option value="{{$category->id_category}}">{{$category->title}}</option>
                        @endforeach
                    </select>
                </label>

                <label class="form-label">Brand
                    <select name="brand" class="form-select mt-2" aria-label="Default select example">
                        <option value="">Open this select menu</option>
                        @foreach($brands as $brand)
                            <option value="{{$brand->id_brand}}">{{$brand->title}}</option>
                        @endforeach
                    </select>
                </label>

                <label class="form-label">Status
                    <select name="status" class="form-select mt-2" aria-label="Default select example">
                        <option value="">Open this select menu</option>
                        <option value="1">Active</option>
                        <option value="0">Passive</option>
                    </select>
                </label>

                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-filter"></i></button>


            </form>


        </div>


        <div class="d-flex justify-content-end mr-4 mb-4 mt-4">
            <form id="searchProduct" action="{{ route('product-search') }}" method="GET" class="form-inline">

                <input type="text" name="query" class="form-control mr-sm-2 " placeholder="Search products">
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i></button>

            </form>
        </div>

    </div>

    <div class="pb-5">

        <table id="myTable" class="table table-striped table-bordered" style="width:100%">
            <thead class="container-fluid">
            <tr>
                <th scope="row">̱No
                </th>
                <th scope="row" class=" text-center">Product</th>
                <th scope="row" class="text-center">Brand</th>
                <th scope="row" class="text-center">Price</th>
                <th scope="row" class="text-center">Image</th>
                <th scope="row" class="text-center">Status</th>
                <th scope="row" class="text-center ">Settings</th>

            </tr>

            </thead>

            <tbody>

            @foreach($products as $product)

                <tr>
                    <td>{{ ($products->currentpage()-1) * $products->perPage() + $loop->iteration }}</td>
                    <td class=" align-content-center text-center">{{$product->title}}</td>


                    <td class=" align-content-center text-center">{{$product->brand->title}}</td>
                    <td class=" align-content-center text-center">{{$product->price}}</td>
                    <td class=" align-content-center text-center">
                        @if( isset($product->images))
                            @foreach($product->images as $image)
                                @if(  $image->pivot->is_main==1)
                                    <img src="{{  asset('storage/images/products/' . $image->file_name  ) }}"
                                         class="img-thumbnail rounded-circle" style="width:50px;height:50px;"
                                         alt="">
                                @endif
                            @endforeach
                        @else
                            <span>No image available</span>
                        @endif
                    </td>
                    <td class="text-center align-content-center">
                        <div class="btn-group btn-group-toggle " data-toggle="buttons">
                            <label class="btn btn-outline-success  pt-1 pb-1 pl-2 pr-2">
                                <input type="radio" name="options"
                                       autocomplete="off" {{ $product->is_active=="1" ? "checked" : ""}}
                                       onclick="updateProductStatus(1,{{$product->id_product}},'{{route('update-product-status')}}')">
                                Active
                            </label>

                            <label class="btn btn-outline-danger pt-1 pb-1 pl-2 pr-2">
                                <input type="radio" name="options"
                                       autocomplete="off"
                                       {{ $product->is_active=="0" ? "checked" : ""}}
                                       onclick="updateProductStatus(0,{{$product->id_product}},'{{route('update-product-status')}}')">
                                Passive
                            </label>
                        </div>
                    </td>

                    <td class="text-center">
                        <span role="button" data-toggle="modal" data-target="#edit"
                              onclick=updateModal({{json_encode($product)}})>
                            <i class="fa-solid fa-pen-to-square m-2" style="font-size: 20px"></i>
                        </span>
                        <span role="button"
                              onclick="deleteModal({{ json_encode($product->id_product) }},
                             '{{route('product-destroy',['id'=>$product->id_product]) }}' )">

                            <i class="fa-solid fa-trash" style="font-size:20px"></i>
                        </span>

                    </td>

                </tr>

            @endforeach

            </tbody>


        </table>
        @if($products and $products->isEmpty())
            <h4 class="text-center mt-5">There is no data for showing</h4>
        @endif

        {{ $products->links() }}


        <x-modal modalId="create" action='{{route("product-store")}}' title="Create Product" buttonText="Create"
                 formId="createForm" error="errorCreate" errorMessage="errorMessageCreate">

            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <label class="form-label">Title
                            <input type="text" class="form-control mb-3" placeholder="Title"
                                   name="title">
                        </label>
                    </div>

                    <div class="col">
                        <label class="form-label">Price
                            <input type="text" class="form-control mb-3" placeholder="Price"
                                   name="price">
                        </label>
                    </div>

                </div>


                <div class="row">
                    <div class="col">
                        <label class="form-label">Category
                            <select name="category" class="form-select" aria-label="Default select example">
                                <option value="">Open this select menu</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id_category}}">{{$category->title}}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>

                    <div class="col">
                        <label class="form-label">Brand
                            <select name="brand" class="form-select" aria-label="Default select example">
                                <option value="">Open this select menu</option>
                                @foreach($brands as $brand)
                                    <option value="{{$brand->id_brand}}">{{$brand->title}}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>

                </div>

                <div class="row mt-3">
                    <div class="col">
                        <label class="form-label">Description
                            <textarea class="form-control mb-3" placeholder="Description" name="description"></textarea>
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <label class="form-label">Images
                                <input class="form-control" type="file" id="formFile" name="files[]" multiple>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row" id="imageContainerCreate">
                    <div class="col">
                        <div class="mb-3">
                            <img id="createImage" class="figure-img img-fluid rounded d-none"
                                 style="width: 10rem; height:10rem;object-fit: cover " src="">
                        </div>
                    </div>
                </div>


                <div class="col">
                    <label class="form-label">Select Main Image
                        <select id="selectMainImageCreate" name="mainImageName" class="form-select"
                                aria-label="Default select example">

                        </select>
                    </label>
                </div>

                <div class="col">
                    <label class="form-label">Related Products
                        <select name="relatedProducts[]" class="form-select" aria-label="Default select example"
                                multiple>
                            @foreach($allProducts as $allProduct)
                                <option value="{{$allProduct->id_product}}">{{$allProduct->title}}</option>
                            @endforeach
                        </select>
                    </label>
                </div>

            </div>


        </x-modal>

        <x-modal modalId="edit" action='{{route("product-update")}}' title="Edit Product" buttonText="Update"
                 formId="updateForm" error="errorUpdate" errorMessage="errorMessageUpdate">
            <input type="hidden" name="id">
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <label class="form-label">Title
                            <input type="text" class="form-control mb-3" placeholder="Title" name="title">
                        </label>
                    </div>

                    <div class="col">
                        <label class="form-label">Price
                            <input type="text" class="form-control mb-3" placeholder="Price" name="price">
                        </label>
                    </div>

                </div>


                <div class="row">
                    <div class="col">
                        <label class="form-label">Category
                            <select name="category" class="form-select" aria-label="Default select example">
                                <option value="" selected>Open this select menu</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id_category}}">{{$category->title}}</option>
                                @endforeach
                            </select>
                        </label>

                    </div>

                    <div class="col">
                        <label class="form-label">Brand
                            <select name="brand" class="form-select" aria-label="Default select example">
                                <option value="" selected>Open this select menu</option>
                                @foreach($brands as $brand)
                                    <option value="{{$brand->id_brand}}">{{$brand->title}}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>

                </div>

                <div class="row mt-3">
                    <div class="col">
                        <label class="form-label">Description
                            <textarea class="form-control mb-3" placeholder="Description" name="description"></textarea>
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <label class="form-label">Images
                                <input class="form-control" type="file" id="formFile" name="files[]" multiple>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row" id="imageContainerUpdate">
                    <div class="col">
                        <div class="mb-3">
                            <img id="createImage" class="figure-img img-fluid rounded d-none"
                                 style="width: 10rem; height:10rem;object-fit: cover " src="">
                        </div>
                    </div>
                </div>


                <div class="col">
                    <label class="form-label">Select Main Image
                        <select id="selectMainImageUpdate" name="mainImageName" class="form-select"
                                aria-label="Default select example">

                        </select>
                    </label>
                </div>

                <div class="col">
                    <label class="form-label">Related Products
                        <select id="relatedProductsUpdate" name="relatedProducts[]" class="form-select"
                                aria-label="Default select example" multiple>
                            @foreach($allProducts as $allProduct)
                                <option value="{{$allProduct->id_product}}">{{$allProduct->title}}</option>
                            @endforeach
                        </select>
                    </label>
                </div>

            </div>


        </x-modal>
    </div>

@endsection

@section('bottomScript')

    <script src="{{asset('js/product.js')}}"></script>

@endsection
