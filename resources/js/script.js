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
            fullStar: true,
        }).on('rateyo.set', function (e, data) {
            $('#rating').val(data.rating)
        });
    });

    $(function () {
        $("#rateYoP").rateYo({
            rating: $('#prd-rate').val(),
            starWidth: "21px",
            readOnly: true
        })
    })

    $(".close").click(function(){
        $("#flash").alert("close");
    });

    $('#update-order-status').click(function() {
        return confirm($('#update-order-status').attr("data-cf"));
    })

    $('#btn-edit-cmt').click(function () {
        $('#form-edit-cmt').toggleClass('visually-hidden');
    })

    $('#add').click(function () {
		if (Number($('#qty').val()) < $('#qty').attr('max')) {
            $('#qty').attr('value', Number($('#qty').val()) + 1);
		}
    });
    $('#sub').click(function () {
        if (Number($('#qty').val()) > 1) {
            $('#qty').attr('value', Number($('#qty').val()) - 1);
		}
    });

    $('#btn-cancel-order').click(function () {
        return confirm($('#btn-cancel-order').attr('data-cf'));
    })

    $('#btn-buy-again').click(function () {
        return confirm($('#btn-buy-again').attr('data-cf'));
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

$(document).ready(function() {
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: brand_labels,
            datasets: [{
                label: label,
                data: brand_quantity_week,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        },
    });
    
    $('#filter').change(function() {
        var selectedVal = $("#filter option:selected").val();
        if (selectedVal == 'day') {
            myChart.data.datasets[0].data = brand_quantity_day;
        } else if (selectedVal == 'week') {
            myChart.data.datasets[0].data = brand_quantity_week;
        } else {
            myChart.data.datasets[0].data = brand_quantity_month;
        }
        $('#btn-filter').click(function() {
            myChart.update();
        })
    })
});
