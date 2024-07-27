<!-- Modal -->
<div class="modal fade" id="{{ $modalId }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <h5 class="modal-title" id="exampleModalCenterTitle">{{$title}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="{{$formId}}" action="{{$action}}" method="POST" enctype="multipart/form-data">

                @csrf

                {{$slot}}


                <div id="{{$error}}" class="d-none alert alert-danger d-flex align-items-center ml-3 mr-3"
                     style="font-size:14px;" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                        <use xlink:href="#exclamation-triangle-fill"/>
                    </svg>
                    <div>
                        <span class="fw-bold">Ensure that these requirements are met:</span>
                        <ul id="{{$errorMessage}}" class="mt-2 mb-0">

                        </ul>
                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">{{$buttonText}}</button>
                </div>

            </form>
        </div>
    </div>
</div>
