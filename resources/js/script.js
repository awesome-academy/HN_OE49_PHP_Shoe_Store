$(document).ready(function(){ 
    $('#navbarDropdown').click(function() {
        $('#dd-menu').toggleClass('show');
    })

    $('#logout').click(function(event) {
        event.preventDefault();
        $('#logout-form').submit();
    })

    $(function () {
        $("#rateYo").rateYo({
            rating: 0,
            starWidth: "15px",
        }).on('rateyo.set', function (e, data) {
            $('#rating').val(data.rating)
        });
    });

    $(function () {
        $("#rateYoP").rateYo({
            rating: $('#prd-rate').val(),
            readOnly: true
        })
    })

    $(".close").click(function(){
        $("#flash").alert("close");
    });

    $('#update-order-status').click(function() {
        return confirm($('#update-order-status').attr("data-cf"));
    })
});

$(document).ready(function() {
    $("#img_profile").change(function() {
        let reader = new FileReader();
        reader.onload = (e) => {
            $("#img_preview").attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    });
    $('#form_profile').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: this.action,
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: (data) => {
                console.log(data);
            },
            error: function(data) {
                console.log(data);
            }
        });
    });
});
