async function ajaxCall(url, data = {}, method = 'POST', loader = false) {
    try {
        return await $.ajax({
            type: method,
            url: url,
            data: data,
            beforeSend: function(){
                if(loader){
                    $("#overlay").fadeIn(300);
                }
            },
            complete: function(){
                if(loader){
                    setTimeout(function(){
                        $("#overlay").fadeOut(300);
                    },500);
                }
            },
        });
    } catch (error) {
        console.error('An error occurred:', error);
    }
}


async function toastMsg({
                            message = '',
                            timer = 3000,
                            icon = 'success',
                            toast = true,
                            position = 'bottom-end',
                            confirm = false
                        }) {
    const Toast = Swal.mixin({
        toast,
        position,
        showConfirmButton: confirm,
        timer,
        timerProgressBar: false,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });

    try {
        await Toast.fire({
            icon,
            title: message
        });
    } catch (error) {
        console.error('An error occurred while displaying toast:', error);
    }
}

function validateRequest(formId, rules = {}, messages = {}) {
    const form = $('#' + formId);
    form.validate({
        rules,
        messages,
        errorElement: 'span',
        errorClass: 'invalid-feedback',
        errorPlacement: (error, element) => {
            error.insertAfter(element);
        },
        highlight: (element) => {
            $(element).addClass('is-invalid');
        },
        unhighlight: (element) => {
            $(element).removeClass('is-invalid');
            $(element).addClass('is-valid');
        },
    });
}


function ajaxSetup() {
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    });
}

function openQuickView(productId) {
    ajaxSetup();
    let $this = $('#quick-view-data');
    let modal = $('#quickView');
    let modalBody = $('.modal-body');
    modalBody.html('');
    let route = $this.data('route');
    ajaxCall(route, {'product_id': productId}, 'POST', true).then(function (response) {
        if (response.status === true) {
            modalBody.html(response.html);
            $('.product-thumb-carousel').owlCarousel({
                loop: true,
                items: 1,
                dots: false,
                smartSpeed: 500,
                nav: true,
                navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
                thumbs: true,
                thumbImage: true,
                thumbContainerClass: 'owl-thumbs',
                thumbItemClass: 'owl-thumb-item'
            });
            modal.modal('show');
        }
    });
}

function removeFromCart(cartItemId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        width: '410',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, Delete It!'
    }).then((result) => {
        if (result.isConfirmed) {
            ajaxSetup();
            let cart = $('#deleteCart');
            let route = cart.data('route');
            ajaxCall(route, {'cart_item_id': cartItemId}, 'POST', true).then(function (response) {
                if(response.status === true){
                    let totalItems = $('.count');
                    let cart = $('#cartItems');
                    toastMsg({message: response.message, timer: 2000});
                    totalItems.html(response.total_items);
                    cart.html(response.cart_html);
                } else {
                    toastMsg({message: response.message, timer: 3000, icon: 'info'});
                }
            });
        }
    })
}
