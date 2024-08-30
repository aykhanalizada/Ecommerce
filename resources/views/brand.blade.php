@extends('app')
@section('title','Brand')

@section('content')

    <div class="d-flex justify-content-end mr-4 mb-4">
        <button type="button" class="btn btn-success pr-3 pl-3 " data-target="#create" data-toggle="modal">New</button>
    </div>
    <div>


        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead class="container-fluid">
            <tr>
                <th scope="row">No̱</th>
                <th scope="row" class="text-center">Brand</th>
                <th scope="row" class="text-center">Logo</th>
                <th scope="row" class="text-center">Status</th>
                <th scope="row" class="text-center ">Settings</th>

            </tr>
            </thead>
            <tbody>

            @foreach($brands as $brand)

                <tr>

                    <td>{{ ($brands->currentPage()-1)*$brands->perPage() + $loop->iteration }}</td>
                    <td class=" align-content-center text-center">{{$brand->title}}</td>
                    <td class=" align-content-center text-center">

                        @if($brand->media)
                            <img src="{{  asset('storage/images/brands/' . $brand->media->file_name  ) }}"
                                 class="img-thumbnail rounded-circle" style="width:50px;height:50px;" alt="">
                        @else
                            <span>No image available</span>
                        @endif
                    </td>
                    <td class="text-center align-content-center">
                        <div class="btn-group btn-group-toggle " data-toggle="buttons">
                            <label class="btn btn-outline-success  pt-1 pb-1 pl-2 pr-2">
                                <input type="radio" name="options" id="option1"
                                       autocomplete="off" {{ $brand->is_active=="1" ? "checked" : ""}}
                                       onclick="updateBrandStatus(1,{{$brand->id_brand}},'{{route('update-brand-status')}}')">
                                Active
                            </label>

                            <label class="btn btn-outline-danger pt-1 pb-1 pl-2 pr-2">
                                <input type="radio" name="options" id="option2"
                                       autocomplete="off"
                                       {{ $brand->is_active=="0" ? "checked" : ""}}
                                       onclick="updateBrandStatus(0,{{$brand->id_brand}},'{{route('update-brand-status')}}')">
                                Passive
                            </label>
                        </div>
                    </td>

                    <td class="text-center">
                        <span role="button" data-toggle="modal" data-target="#edit"
                              onclick=editModal({{json_encode($brand)}})>
                            <i class="fa-solid fa-pen-to-square m-2" style="font-size: 20px"></i>
                        </span>
                        <span role="button"
                              onclick="deleteModal({{ json_encode($brand->id_brand) }},
                             '{{route('brand-destroy',['id'=>$brand->id_brand]) }}' )">

                            <i class="fa-solid fa-trash" style="font-size:20px"></i>
                        </span>

                    </td>

                </tr>

            @endforeach

            </tbody>
        </table>


        {{ $brands->links() }}


        <x-modal modalId="create" action='{{route("brand-store")}}' title="Create Brand" buttonText="Create"
                 formId="createForm" error="errorCreate" errorMessage="errorMessageCreate">

            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control mb-3" placeholder="Title" name="title">
                    </div>
                </div>


                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Logo</label>
                            <input class="form-control" type="file" id="formFile" name="file">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <img id="createLogo" class="figure-img img-fluid rounded d-none" style="width: 10rem; height:10rem;object-fit: cover " src="">
                        </div>
                    </div>
                </div>

            </div>

        </x-modal>

        <x-modal modalId="edit" action='{{route("brand-update")}}' title="Edit Brand" buttonText="Update"
                 formId="updateForm" error="errorUpdate" errorMessage="errorMessageUpdate">
            <input type="hidden" name="id">
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control mb-3" placeholder="Title" name="title">
                    </div>
                </div>


                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Logo</label>
                            <input class="form-control" type="file" id="formFile" name="file">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <img id="editLogo" class="figure-img img-fluid rounded" style="width: 10rem; height:10rem;object-fit: cover " src="">
                        </div>
                    </div>
                </div>
            </div>




        </x-modal>
    </div>

@endsection

@section('bottomScript')

    <script src="{{asset('js/brand.js')}}"></script>

@endsection
