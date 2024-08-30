@extends('app')
@section('title','User')

@section('content')

    <div class="d-flex justify-content-end mr-4 mb-4">
        <button type="button" class="btn btn-success pr-3 pl-3 " data-target="#create" data-toggle="modal">New</button>
    </div>
    <div>


        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead class="container-fluid">
            <tr>
                <th scope="row">No̱</th>
                <th scope="row" class="text-center">First Name</th>
                <th scope="row" class="text-center">Last Name</th>
                <th scope="row" class="text-center">Username</th>

                <th scope="row" class="text-center">Email</th>
                <th scope="row" class="text-center">Logo</th>
                <th scope="row" class="text-center">Status</th>
                <th scope="row" class="text-center ">Settings</th>

            </tr>
            </thead>
            <tbody>

            @foreach($users as $user)

                <tr>

                    <td>{{ ($users->currentPage()-1)*$users->perPage() + $loop->iteration }}</td>
                    <td class=" align-content-center text-center">{{$user->first_name}}</td>
                    <td class=" align-content-center text-center">{{$user->last_name}}</td>
                    <td class=" align-content-center text-center">{{$user->username}}</td>

                    <td class=" align-content-center text-center">{{$user->email}}</td>


                    <td class=" align-content-center text-center">

                        @if($user->media)
                            <img src="{{  asset('storage/images/users/' . $user->media->file_name  ) }}"
                                 class="img-thumbnail rounded-circle" style="width:50px;height:50px;" alt="">
                        @else
                            <span><img src="{{asset('images/default-user.webp')}}"
                                       class="img-thumbnail rounded-circle object-fit-cover"
                                       style="width:50px;height:50px;"></span>
                        @endif
                    </td>
                    <td class="text-center align-content-center">
                        <div class="btn-group btn-group-toggle " data-toggle="buttons">
                            <label class="btn btn-outline-success  pt-1 pb-1 pl-2 pr-2">
                                <input type="radio" name="options" id="option1"
                                       autocomplete="off" {{ $user->is_active=="1" ? "checked" : ""}}
                                       onclick="updateUserStatus(1,{{$user->id_user}},'{{route('update-user-status')}}')">
                                Active
                            </label>

                            <label class="btn btn-outline-danger pt-1 pb-1 pl-2 pr-2">
                                <input type="radio" name="options" id="option2"
                                       autocomplete="off"
                                       {{ $user->is_active=="0" ? "checked" : ""}}
                                       onclick="updateUserStatus(0,{{$user->id_user}},'{{route('update-user-status')}}')">
                                Passive
                            </label>
                        </div>
                    </td>

                    <td class="text-center">
                        <span role="button" data-toggle="modal" data-target="#edit"
                              onclick=editModal({{json_encode($user)}})>
                            <i class="fa-solid fa-pen-to-square m-2" style="font-size: 20px"></i>
                        </span>
                        <span role="button"
                              onclick="deleteModal({{ json_encode($user->id_user) }},
                             '{{route('user-destroy',['id'=>$user->id_user]) }}' )">

                            <i class="fa-solid fa-trash" style="font-size:20px"></i>
                        </span>

                    </td>

                </tr>

            @endforeach

            </tbody>
        </table>


        {{ $users->links() }}


        <x-modal modalId="create" action='{{route("user-store")}}' title="Create User" buttonText="Create"
                 formId="createForm" error="errorCreate" errorMessage="errorMessageCreate">

            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <label class="form-label">First Name
                            <input type="text" class="form-control mb-3" placeholder="First Name" name="firstName">
                        </label>
                    </div>

                    <div class="col">
                        <label class="form-label">Last Name
                            <input type="text" class="form-control mb-3" placeholder="Last Name" name="lastName">
                        </label>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label class="form-label">Username
                            <input type="text" class="form-control mb-3" placeholder="Username" name="username">
                        </label>
                    </div>

                    <div class="col">
                        <label class="form-label">Email
                            <input type="text" class="form-control mb-3" placeholder="Email" name="email">
                        </label>
                    </div>

                </div>

                <div class="row">

                    <div class="col">
                        <label class="form-label">Admin
                            <select name="is_admin" class="form-select mt-2" aria-label="Default select example">
                                <option value="" selected>Select Admin Status</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </label>
                    </div>

                    <div class="col">
                        <label class="form-label">Password
                            <input type="password" class="form-control mb-3" placeholder="Password" name="password">
                        </label>
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
                            <img id="createLogo" class="figure-img img-fluid rounded d-none"
                                 style="width: 10rem; height:10rem;object-fit: cover " src="">
                        </div>
                    </div>
                </div>

            </div>

        </x-modal>

        <x-modal modalId="edit" action='{{route("user-update")}}' title="Update User" buttonText="Update"
                 formId="updateForm" error="errorUpdate" errorMessage="errorMessageUpdate">

            <input type="hidden" name="id">

            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <label class="form-label">First Name
                            <input type="text" class="form-control mb-3" placeholder="First Name" name="firstName">
                        </label>
                    </div>

                    <div class="col">
                        <label class="form-label">Last Name
                            <input type="text" class="form-control mb-3" placeholder="Last Name" name="lastName">
                        </label>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label class="form-label">Username
                            <input type="text" class="form-control mb-3" placeholder="Username" name="username">
                        </label>
                    </div>

                    <div class="col">
                        <label class="form-label">Email
                            <input type="text" class="form-control mb-3" placeholder="Email" name="email">
                        </label>
                    </div>

                </div>

                <div class="row">

                    <div class="col">
                        <label class="form-label">Admin
                            <select name="is_admin" class="form-select mt-2" aria-label="Default select example">
                                <option value="" selected>Select Admin Status</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </label>
                    </div>


                    <div class="col">
                        <label class="form-label">Password
                            <input type="text" class="form-control mb-3" placeholder="Password" name="password">
                        </label>
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
                            <img id="createLogo" class="figure-img img-fluid rounded d-none"
                                 style="width: 10rem; height:10rem;object-fit: cover " src="">
                        </div>
                    </div>
                </div>

            </div>

        </x-modal>
    </div>

@endsection

@section('bottomScript')

    <script src="{{asset('js/user.js')}}"></script>

@endsection
