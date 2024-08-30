$(document).ready(function () {
    toastr.options = {
        "progressBar": true, "positionClass": "toast-top-center", "timeOut": "2000",
    }

    $("#updateForm #formFile").on('change', (function (e) {
        var files = e.target.files
        var container = $('#imageContainerUpdate')
        var select = $('#selectMainImageUpdate')

        container.empty();
        select.empty();

        select.append($('<option>').val('').text('Select main image'))


        Array.from(files).forEach((file, index) => {

            var imgURL = URL.createObjectURL(file);

            var imgElement = $('<img>').attr('src', imgURL)
                .addClass('figure-img img-fluid rounded')
                .css({'width': '8rem', 'height': '8rem', 'object-fit': 'cover', 'margin': '0.5rem'});

            container.append(imgElement);
            select.append($('<option>').val(file.name).text('Image ' + (index + 1)))
        })


    }));


    $("#createForm #formFile").on('change', (function (e) {
        var files = e.target.files
        var container = $('#imageContainerCreate')
        var select = $('#selectMainImageCreate')

        container.empty();
        select.empty();

        select.append($('<option>').val('').text('Select main image'))


        Array.from(files).forEach((file, index) => {

            var imgURL = URL.createObjectURL(file);

            var imgElement = $('<img>').attr('src', imgURL)
                .addClass('figure-img img-fluid rounded')
                .css({'width': '8rem', 'height': '8rem', 'object-fit': 'cover', 'margin': '0.5rem'});

            container.append(imgElement);
            select.append($('<option>').val(file.name).text('Image ' + (index + 1)))
        })


    }));

})


function updateModal(data) {

    $('#updateForm input[name="id"]').val(data.id_product)
    $('#updateForm input[name="title"]').val(data.title)
    $('#updateForm input[name="price"]').val(data.price)
    $('#updateForm select[name="category"]').val(data.categories[0].id_category)
    $('#updateForm select[name="brand"]').val(data.brand.id_brand)
    $('#updateForm textarea[name="description"]').val(data.description)

    var container = $('#imageContainerUpdate')
    var selectMainImage = $('#selectMainImageUpdate');
    var selectRelatedProducts = $('#relatedProductsUpdate');
    var hideSelectedProduct = $('#relatedProductsUpdate option[value="' + data.id_product + '"]').hide()


    container.empty()
    selectMainImage.empty();

    selectRelatedProducts.val([]).trigger('change');


    if (data.images && data.images.length > 0) {
        data.images.forEach((image, index) => {

            var imgURL = 'storage/images/products/' + image.file_name
            var imgElement = $('<img>').attr('src', imgURL)
                .addClass('figure-img img-fluid rounded')
                .css({'width': '8rem', 'height': '8rem', 'object-fit': 'cover', 'margin': '0.5rem'});
            container.append(imgElement)
            selectMainImage.append($('<option>').val(image.file_name).text('Image ' + `${index + 1}`))

            if (data.images.length > 0 && image.pivot.is_main) {

                selectMainImage.val(image.file_name);
            }

        })


    } else {
        container.append('<p>No images available</p>');

    }


    data.related_products.forEach(product => {
        selectRelatedProducts.find(`option[value="${product.id_product}"]`).prop('selected', true);
    });
    selectRelatedProducts.trigger('change');

}


$("#updateForm").on("submit", function (e) {
    e.preventDefault();

    var formData = new FormData(this);
    var files = $('#updateForm #formFile')[0].files;
    for (var i = 0; i < files.length; i++) {
        formData.append('productImages[]', files[i]);

    }

    console.log(...formData)

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

    var files = $('#createForm #formFile')[0].files;
    for (var i = 0; i < files.length; i++) {
        formData.append('productImages[]', files[i]);

    }

    console.log(...formData)
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


function deleteModal(product, routeUrl) {
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
                url: routeUrl, type: "POST", data: product, success: function (response) {
                    console.log(response)
                }, error: function (xhr, status, error) {
                    console.log(xhr.responseJSON.message)
                }
            })
            Swal.fire({
                title: "Deleted!", text: "Your file has been deleted.", icon: "success"
            }).then(() => {
                location.reload()
            })
        }
    });


}

function updateProductStatus(status, productId, routeUrl) {

    $.ajax({
        url: routeUrl,
        type: "POST",
        data: {
            is_active: status, id_product: productId
        },
        success: function (response) {
            console.log(response)
            toastr["success"]("Status successfully updated")

        }, error: function (xhr, status, error) {
            console.log(xhr.responseJSON.message)
        }

    })
}


$('#productFilterForm').on('submit', function (e) {
    var inputs = $("#productFilterForm select")
    console.log(inputs)
    $(inputs).each(function (index, input) {

        if (!input.value) {
            $(input).removeAttr('name')
        }
    })
})




