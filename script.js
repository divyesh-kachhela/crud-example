$(document).ready(function () {

    // Filter category (name and status)
    $("#filterCategory").click(function() {

        var filterData = getFilterData();

        $.ajax({
            url: 'categories.php',
            type: 'POST',
            data: {
                cateName: filterData.cateName,
                cateStatus: filterData.cateStatus
            },
            success: function(response) {
                $('.DOM').html($(response).find('.DOM').html());
            }
        });

    });

    //clear category filters
    $("#clear-filter").click(function () {

        $("#searchCategory").val("");
        $("#searchCategoryStatus").val("all");
        var key = 0;

        $.ajax({
            url: 'categories.php',
            type: 'POST',
            data: {
                resetOrder: key
            },
            success: function(response) {
                $('.DOM').html($(response).find('.DOM').html());
            }
        });

    });


    //category table pagination
    $(".DOM").on("click", "a:not(.action)", function (event) {
        event.preventDefault();
        var page_num = $(this).attr("id");

        var filterData = getFilterData();
    
        $.ajax({
            url: 'categories.php',
            type: 'POST',
            data: {
                pagesend: page_num,
                cateName: filterData.cateName,
                cateStatus: filterData.cateStatus
            },
            success: function (response) {
                $(".DOM").html($(response).find('.DOM').html());
            }
        });
    });


    //filter product (name, code, status and price)
    $("#filterProduct").click(function () {
        var FilterData = getProductFilterData();

        $.ajax({
            url: 'products.php',
            type: 'POST',
            dataType: 'html',
            data: {
                proName: FilterData.proName,
                proCode: FilterData.proCode,
                proStatus: FilterData.proStatus,
                proMinP : FilterData.proMinP,
                proMaxP : FilterData.proMaxP
            },
            success: function(response) {
                $("#product-order").html($(response).find("#product-order").html());
            }
        });

    });


    //clear product filters
    $("#clear-product-filter").click(function () {
        $("#searchProductName").val("");
        $("#searchProductCode").val("");
        $("#searchProductStatus").val("all");
        $("#minPrice").val("");
        $("#maxPrice").val("");
        var key = 1;

        $.ajax({
            url: 'products.php',
            type: 'POST',
            dataType: 'html',   
            data: {
                resetOrder: key
            },
            success: function(response) {
                $("#product-order").html($(response).find("#product-order").html());
            }
        });

    });

    //product table pagination
    $("#product-order").on("click", "a:not(.action)", function (event) {
        event.preventDefault();
        var page_num = $(this).attr("id");

        var FilterData = getProductFilterData();
    
        $.ajax({
            url: 'products.php',
            type: 'POST',
            data: {
                productPageSend: page_num,
                proName: FilterData.proName,
                proCode: FilterData.proCode,
                proStatus: FilterData.proStatus,
                proMinP : FilterData.proMinP,
                proMaxP : FilterData.proMaxP
            },
            success: function (response) {
                $("#product-order").html($(response).find('#product-order').html());
            }
        });
    });
});

 
// ordering data by category (name and status)
var sortOrderByName = 'DESC';
var orderByStatus = 'DESC';
var orderByOrdering = 'DESC';

function sort(Column) {
    var sortOrder;

    if (Column === 'Category_Name') {
        sortOrder = (sortOrderByName === 'DESC') ? 'ASC' : 'DESC';
        sortOrderByName = sortOrder;
    } else if (Column === 'Category_Status') {
        sortOrder = (orderByStatus === 'DESC') ? 'ASC' : 'DESC';
        orderByStatus = sortOrder;
    } else if (Column === 'Ordering') {
        sortOrder = (orderByOrdering === 'DESC') ? 'ASC' : 'DESC';
        orderByOrdering = sortOrder;
    }
    var filterData = getFilterData();

    $.ajax({
        url: 'categories.php',
        type: 'POST',
        data: {
            sendData: Column,
            sortOrder: sortOrder,
            cateName: filterData.cateName,
            cateStatus: filterData.cateStatus
        },
        success: function(response) {
            $(".DOM").html($(response).find('.DOM').html());
        }
    });
}


function getFilterData() {
    var inputCateName = $("#searchCategory").val().toLowerCase();
    var inputCateStatus = $("#searchCategoryStatus").val().toLowerCase();
    return { cateName: inputCateName, cateStatus: inputCateStatus };
}

function getProductFilterData() {
    var inputProName = $("#searchProductName").val().toLowerCase();
    var inputProCode = $("#searchProductCode").val().toLowerCase();
    var inputProStatus = $("#searchProductStatus").val().toLowerCase();
    var inputProMinP = $("#minPrice").val().toLowerCase();
    var inputProMaxP = $("#maxPrice").val().toLowerCase();
    return { proName: inputProName, proCode: inputProCode, proStatus: inputProStatus, proMinP: inputProMinP, proMaxP: inputProMaxP };
}


// ordering product table data
var sortOrderByProductName = 'DESC';
var orderByProductPrice = 'DESC';
var orderByProductSalePrice = 'DESC';
var orderByProductQuantity = 'DESC';
var orderByProductStatus = 'DESC';

function sortProduct(ProductColumn) {
    var sortOrder;
    if (ProductColumn === 'product_name') {
        sortOrder = (sortOrderByProductName === 'DESC') ? 'ASC' : 'DESC';
        sortOrderByProductName = sortOrder;
    } else if (ProductColumn === 'price') {
        sortOrder = (orderByProductPrice === 'DESC') ? 'ASC' : 'DESC';
        orderByProductPrice = sortOrder;
    } else if (ProductColumn === 'sale_price') {
        sortOrder = (orderByProductSalePrice === 'DESC') ? 'ASC' : 'DESC';
        orderByProductSalePrice = sortOrder;
    } else if (ProductColumn === 'quantity') {
        sortOrder = (orderByProductQuantity === 'DESC') ? 'ASC' : 'DESC';
        orderByProductQuantity = sortOrder;
    } else if (ProductColumn === 'status') {
        sortOrder = (orderByProductStatus === 'DESC') ? 'ASC' : 'DESC';
        orderByProductStatus = sortOrder;
    }
    var FilterData = getProductFilterData();

    $.ajax({
        url: 'products.php',
        type: 'POST',
        data: {
            ProductData: ProductColumn,
            ProductOrder: sortOrder,
            proName: FilterData.proName,
            proCode: FilterData.proCode,
            proStatus: FilterData.proStatus,
            proMinP : FilterData.proMinP,
            proMaxP : FilterData.proMaxP
        },
        success: function(response) {
            $("#product-order").html($(response).find('#product-order').html());
        }
    });
}


// delete row confirmation
function confirmDelete(event) {
    if (!confirm("Are you sure you want to delete this ?")) {
        event.preventDefault();
    }
}

// logout confirmation
function confirmLogout(event) {
    if (!confirm("Are you sure you want to log out ?")) {
        event.preventDefault();
    }
}


// update image preview
$(document).ready(function () {
    $('#fileInput').change(function (event) {
        var file = event.target.files[0];

        // Check if the file is an image
        if (file.type && file.type.indexOf('image') === -1) {
            alert('File is not an image.');
            location.reload();
            return;
        }

        var reader = new FileReader();
        reader.onload = function (e) {
            $('#imagePreview').empty(); // clear previous preview

            var img = $('<img>').attr('src', e.target.result);
            img.css({
                'max-width': '100%',
                'max-height': '100%'
            });
            $('#imagePreview').html(img);
        };
        reader.readAsDataURL(file);
    });
});


// add product images preview
$(document).ready(function() {
    $('#productImages').change(function() {
        const files = $(this)[0].files;
        $('#imageNames').empty();
        for (let i = 0; i < files.length; i++) {
            const fileName = files[i].name;
            const fileType = files[i].type;
            if (fileType.startsWith('image/')) {
                const fileReader = new FileReader();
                fileReader.onload = function(event) {
                    const imageSrc = event.target.result;
                    const imageContainer = $('<div class="image-container"></div>');
                    const image = $('<img class="preview-image" data-file="' + fileName + '" src="' + imageSrc + '" alt="' + fileName + '">');
                    const imageName = $('<div>' + fileName + '</div>');
                    imageContainer.append(image);
                    //imageContainer.append(imageName);
                    $('#imageNames').append(imageContainer);
                };
                fileReader.readAsDataURL(files[i]);
            } else {
                alert('Invalid file format. Only image files are allowed.');
                $(this).val(''); // clear file input field
                $('#imageNames').empty();
                return;
            }
        }
    });

    $(document).on('click', '.preview-image', function() {
        $('.preview-image').removeClass('selected');
        $(this).addClass('selected');
    });

    $('#upBtn').click(function(event) {
        const selectedImage = $('.preview-image.selected').attr('data-file');
        if (!selectedImage) {
            alert('Please select a main image.');
            event.preventDefault();
            return; // Stop further processing if no main image is selected
        }
        $("#storeName").val(selectedImage);
    });
});


$(document).ready(function() {
    $(document).on('click', '.imgbox', function() {
        $('.imgbox').removeClass('selected');
        $(this).addClass('selected');

        var dataIdValue = $(this).find("img").data("id");
        $("#dataIn").val(dataIdValue);
    });
});

