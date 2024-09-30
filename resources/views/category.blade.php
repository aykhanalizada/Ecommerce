@extends('app')
@section('title','Category')

@section('content')

    <div class="d-flex justify-content-end mr-4 mb-4">
        <button type="button" class="btn btn-success pr-3 pl-3 " data-target="#create" data-toggle="modal">New</button>
    </div>
    <div>


        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead class="container-fluid">
            <tr>
                <th scope="row">No̱</th>
                <th scope="row" class="text-center">Category</th>
                <th scope="row" class="text-center">Status</th>
                <th scope="row" class="text-center ">Settings</th>

            </tr>
            </thead>
            <tbody>

            @foreach($categories as $category)

                <tr>

                    <td>{{ ($categories->currentPage()-1)*$categories->perPage() + $loop->iteration }}</td>

                    <td class="text-center align-content-center">{{$category->title}}</td>
                    <td class="text-center align-content-center">
                        <div class="btn-group btn-group-toggle " data-toggle="buttons">
                            <label class="btn btn-outline-success  pt-1 pb-1 pl-2 pr-2">
                                <input type="radio" name="options" id="option1"
                                       autocomplete="off" {{ $category->is_active=="1" ? "checked" : ""}}
                                       onclick="updateCategoryStatus(1,{{$category->id_category}},'{{route('update-category-status')}}')">
                                Active
                            </label>

                            <label class="btn btn-outline-danger pt-1 pb-1 pl-2 pr-2">
                                <input type="radio" name="options" id="option2"
                                       autocomplete="off"
                                       {{ $category->is_active=="0" ? "checked" : ""}}
                                       onclick="updateCategoryStatus(0,{{$category->id_category}},'{{route('update-category-status')}}')">
                                Passive
                            </label>
                        </div>
                    </td>

                    <td class="text-center">
                        <span role="button" data-toggle="modal" data-target="#edit"
                              onclick=editModal({{json_encode($category)}})>
                            <i class="fa-solid fa-pen-to-square m-2" style="font-size: 20px"></i>
                        </span>
                        <span role="button"
                              onclick="deleteModal({{ json_encode($category->id_category) }},
                             '{{route('category-destroy',['id'=>$category->id_category]) }}' )">

                            <i class="fa-solid fa-trash" style="font-size:20px"></i>
                        </span>

                    </td>

                </tr>

            @endforeach

            </tbody>
        </table>


        {{$categories->links()}}


        <x-modal modalId="create" action='{{route("category-store")}}' title="Create Category" buttonText="Create"
                 formId="createForm" error="errorCreate" errorMessage="errorMessageCreate">
            <div class="modal-body">

                <div class="row">
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Title" name="title">
                    </div>

                </div>
            </div>
        </x-modal>

        <x-modal modalId="edit" action='{{route("category-update")}}' title="Edit Category" buttonText="Update"
                 formId="updateForm" error="errorUpdate" errorMessage="errorMessageUpdate">
            <input type="hidden" name="id" >
            <div class="modal-body">

                <div class="row">
                    <div class="col">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" placeholder="Title" name="title">
                    </div>

                </div>
            </div>
        </x-modal>
    </div>

@endsection

@section('bottomScript')

    <script src="{{asset('js/category.js')}}"></script>

@endsection
