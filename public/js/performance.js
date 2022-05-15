var validator = '';

$( "#report" ).on( "click", function() {
    $( "#action" ).val('report');
    valid_performance();
});

$( "#graphic" ).on( "click", function() {
    $( "#action" ).val('graphic');
    valid_performance();
});

$( "#pizza" ).on( "click", function() {
    $( "#action" ).val('pizza');
    valid_performance();
});

function valid_performance(){
    required = 'El campo es obligatorio';
    validD = 'La fecha inicial es mayor que la fecha final';

    $.validator.addMethod("validdate", function( value, element ) {
       return this.optional( element ) || validInitialDate();
    });

   $.validator.addMethod("validConsultores", function(value, element) {
        return value.length > 0;
    });

validator = $("#form_comercial").validate({
    rules:
    {
    initial_date: {
     required:true,
     validdate: true,
    },
    end_date: {
     required:true,
    },
    consultores_select: {
     required: true,
     validConsultores: true,
    },
     },
     messages:
     {
    initial_date: {
     required:required,
     validdate: validD,
    },
    end_date: {
     required:required,
    },
    consultores_select: {
     required: required,
     validConsultores: required,
    },
    },
     errorPlacement : function(error, element) {
     $(element).closest('.form-group').find('.help-block').html(error.html());
     },
     highlight : function(element) {
     $(element).closest('.form-group').removeClass('has-success').addClass('has-danger');
     $(element).closest('.form-group').find('.form-control').addClass('form-control-danger');
     },
     unhighlight: function(element, errorClass, validClass) {
     $(element).closest('.form-group').removeClass('has-danger').addClass('has-success');
     $(element).closest('.form-group').find('.help-block').html('');
     },
     
    submitHandler: function(form) {
       
        var date_from = document.querySelector('#initial_date').value;
        var date_to = document.querySelector('#end_date').value;
        var consultores = $('select#consultores_select').val();
        var buttonValue = $( "#action" ).val();

        if (buttonValue == 'report'){
            //$('.table-responsive').removeClass('d-none');
            $('.graphic').addClass('d-none');
            $('.pizza').addClass('d-none');
            var url = location.href;
            var pos_id = location.href.indexOf('from=');
            if (pos_id != -1){
                var pos_ampersand = location.href.indexOf('&start');
                if (pos_ampersand != -1){
                    location.href = url.substr(0,pos_id + 3) + id_patient + url.substr(pos_ampersand,url.length);
                } else {
                    location.href = '/performanceComercialReport?selected='+ consultores +'&from='+date_from+'&to='+date_to+'&buttonValue='+buttonValue;
                }
            } else {
                 location.href = '/performanceComercialReport?selected='+ consultores +'&from='+date_from+'&to='+date_to+'&buttonValue='+buttonValue;
            }
        }else if(buttonValue == 'graphic'){
            axios.get('/performanceComercialGraphic?selected='+ consultores +'&from='+date_from+'&to='+date_to+'&buttonValue='+buttonValue)
                .then((response) => {
                var response1 = response.data;

                if (response1[0].length == 0){
                    $('.graphic').addClass('d-none');
                    $('.pizza').addClass('d-none');
                    $('.report').addClass('d-none');
                    Swal.fire({
                        position: 'top-end',
                        type: 'warning',
                        title: "No existen datos asociados a la búsqueda",
                        showConfirmButton: false,
                        timer: 4000,
                        customClass: "sweetAlert"
                    })

                }else if (response1[0].length != 0){
                    $('.graphic').removeClass('d-none');
                    $('.table-responsive').addClass('d-none');
                    $('.pizza').addClass('d-none');
                   var myChart = echarts.init(document.getElementById('bar-chart'));

                // specify chart configuration item and data
                    option = {
                        tooltip : {
                            trigger: 'item',
                            formatter: function (params) {
                              return `${params.seriesName}<br />
                                      ${params.name}: R$ ${params.data.toFixed(2).replace('.',',').replace(/\d(?=(\d{3})+\,)/g, '$&.')}`;
                            }
                        },
                        legend: {
                            data:response1[0],
                        },
                        toolbox: {
                            show : false,
                            feature : {
                                magicType : {show: true, type: ['line', 'bar']},
                                restore : {show: true},
                                saveAsImage : {show: true}
                            }
                        },
                        calculable : false,
                        xAxis : [
                            {
                                type : 'category',
                                data : response1[1]
                            }
                        ],
                        yAxis : [
                            {
                                type : 'value',
                                 axisLabel: {
                                    formatter: (function(value){
                                    let label;
                                    label = 'R$ '+value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                                    
                                    return label;
                                  })
                                 }
                            }
                        ],
                        series : response1[2],

                };
                // use configuration item and data specified to show chart
                myChart.setOption(option, true), $(function() {
                    function resize() {
                        setTimeout(function() {
                            myChart.resize()
                        }, 100)
                    }
                    $(window).on("resize", resize), $(".sidebartoggler").on("click", resize)
                });
                } 
            })
            .catch(function (error) {
                console.log(error);
            });
        }else if(buttonValue == 'pizza'){
            axios.get('/performanceComercialPizza?selected='+ consultores +'&from='+date_from+'&to='+date_to+'&buttonValue='+buttonValue)
                .then((response) => {
                    var response1 = response.data;

                    if (response1[0].length == 0){
                        $('.graphic').addClass('d-none');
                        $('.pizza').addClass('d-none');
                        $('.report').addClass('d-none');
                        Swal.fire({
                            position: 'top-end',
                            type: 'warning',
                            title: "No existen datos asociados a la búsqueda",
                            showConfirmButton: false,
                            timer: 4000,
                            customClass: "sweetAlert"
                        })

                    }else if (response1[0].length != 0){
                        $('.pizza').removeClass('d-none');
                        $('.graphic').addClass('d-none');
                        $('.table-responsive').addClass('d-none');    
                    
                        var pieChart = echarts.init(document.getElementById('pie-chart'));

                        // specify chart configuration item and data
                        option = {
                            tooltip : {
                                trigger: 'item',
                                formatter: function (params) {
                                  return `${params.seriesName}<br />
                                          ${params.name}: R$ ${params.value.toFixed(2).replace('.',',').replace(/\d(?=(\d{3})+\,)/g, '$&.')} (${params.percent}%)`;
                                }
                            },
                            legend: {
                                x : 'center',
                                y : 'bottom',
                                data: response1[0]
                            },
                            toolbox: {
                                show : true,
                            },
                            calculable : false,
                            series : [
                                {
                                    name:'Gráfico Pastel',
                                    type:'pie',
                                    radius : [20, 110],
                                    center : ['50%', 200],
                                    roseType : 'radius',
                                    width: '40%',       // for funnel
                                    max: 40,            // for funnel
                                    itemStyle : {
                                        normal : {
                                            label : {
                                                show : true
                                            },
                                            labelLine : {
                                                show : true
                                            }
                                        },
                                        emphasis : {
                                            label : {
                                                show : true
                                            },
                                            labelLine : {
                                                show : true
                                            }
                                        }
                                    },
                                    data:response1[1]
                                },
                            ]
                        };
                    
                    // use configuration item and data specified to show chart
                    pieChart.setOption(option, true), $(function() {
                        function resize() {
                            setTimeout(function() {
                                pieChart.resize()
                            }, 100)
                        }
                        $(window).on("resize", resize), $(".sidebartoggler").on("click", resize)
                    });
                }   
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
        
    }
 }); 
}

function validInitialDate() {
    if (!validDates(document.querySelector("#initial_date").value, document.querySelector("#end_date").value)) {
       return false; 
    }
    return true;
}

function validDates(value1,value2) {
    var from = value1;
    var to = value2;
    var separador = "-";

    var to = to.split(separador);
    var from = from.split(separador);
    var day = '1';

    to = new Date(
        to[1],
        to[0] - 1,
        day
    );

    from = new Date(
        from[1],
        from[0] - 1,
        day
    );
   
    if(from > to){
        return false;
    }
    return true;
}




