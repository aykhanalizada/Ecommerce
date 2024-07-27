$(document).ready(function () {
    toastr.options = {
        "progressBar": true,
        "positionClass": "toast-top-center",
        "timeOut": "2000",
    }

    $("#updateForm #formFile").on('change', (function (e) {
        imgURL = URL.createObjectURL(e.target.files[0]);
        $("#updateForm #editLogo").attr("src", imgURL);
    }));

    $("#createForm #formFile").on('change', (function (e) {
        imgURL = URL.createObjectURL(e.target.files[0]);
        $("#createForm #createLogo").attr("src", imgURL).removeClass('d-none');
    }));


})

function editModal(data) {
    console.log(data)

    $("#updateForm input[name='id']").val(data.id_user)
    $("#updateForm input[name='firstName']").val(data.first_name)
    $("#updateForm input[name='lastName']").val(data.last_name)
    $("#updateForm input[name='username']").val(data.username)
    $("#updateForm input[name='email']").val(data.email)
    $("#updateForm select[name='is_admin']").val(data.is_admin)

    // $("#updateForm #editLogo").attr('src','images/users/' + data.media.file_name)

}


$("#updateForm").on("submit", function (e) {
    e.preventDefault();

    var formData = new FormData(this);
    $.ajax({
        url: $('#updateForm').attr('action'),
        type: "POST",
        processData: false,
        contentType: false,
        data: formData,
        success: function (xhr) {
            console.log(xhr)

            toastr["success"]("Status successfully updated")
            setTimeout(function () {
                location.reload();
            }, 2000)

        },
        error: function (xhr, status, error) {
            $("#errorMessageUpdate").empty()
            $("#errorUpdate").removeClass('d-none')
            console.log(xhr.responseJSON.message)
            $('#errorMessageUpdate').append('<li>' + xhr.responseJSON.message + '</li>')
        }

    })
})

$("#createForm").on("submit", function (e) {
    e.preventDefault();

    var formData = new FormData(this);

    $.ajax({
        url: $('#createForm').attr('action'),
        type: "POST",
        processData: false,
        contentType: false,
        data: formData,
        success: function () {
            console.log('success')

            toastr["success"]("Status successfully created")
            setTimeout(function () {
                location.reload();
            }, 2000)

        },
        error: function (xhr, status, error) {
            $("#errorMessageCreate").empty()
            $("#errorCreate").removeClass('d-none')
            console.log(xhr.responseJSON.message)
            $('#errorMessageCreate').append('<li>' + xhr.responseJSON.message + '</li>')

        }

    })
})


function deleteModal(user, routeUrl) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url: routeUrl,
                type: "POST",
                data: user,
                success: function (response) {
                    console.log(response)
                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseJSON.message)
                }
            })
            Swal.fire({
                title: "Deleted!",
                text: "Your file has been deleted.",
                icon: "success"
            }).then(() => {
                location.reload()
            })
        }
    });


}

function updateUserStatus(status, userId, routeUrl) {
    $.ajax({
        url: routeUrl,
        type: "POST",
        data: {
            is_active: status,
            id_user: userId
        },
        success: function (response) {
            console.log(response)

            toastr["success"]("Status successfully updated")


        },
        error: function (xhr, status, error) {
            console.log(xhr.responseJSON.message)
        }

    })
}

