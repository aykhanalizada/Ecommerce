$(document).ready(function () {
    toastr.options = {
        "progressBar": true,
        "positionClass": "toast-top-center",
        "timeOut": "2000",
    }
})

function editModal(data) {

    $("#updateForm").find($('input[name="title"]')).val(data.title)
    $("#updateForm").find($('input[name="id"]')).val(data.id_category)
}


$("#updateForm").on("submit", function (e) {
    e.preventDefault();

    var formData = $(this).serialize();
    $.ajax({
        url: $('#updateForm').attr('action'),
        type: "POST",
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

    var formData = $(this).serialize();

    $.ajax({
        url: $('#createForm').attr('action'),
        type: "POST",
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


function deleteModal(category, routeUrl) {
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
                data: category,
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

function updateCategoryStatus(status, categoryId, routeUrl) {
    $.ajax({
        url: routeUrl,
        type: "POST",
        data: {
            is_active: status,
            id_category: categoryId
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

