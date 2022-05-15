@extends('layouts.app')

@section('title')
    Performance Comercial
@endsection

@section('style')
    <link rel="stylesheet" type="text/css"
        href="{{asset('assets/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" type="text/css"
        href="{{asset('assets/node_modules/datatables.net-bs4/css/responsive.dataTables.min.css')}}">
    <link href="{{asset('assets/datepicker/datepicker3.css')}}" rel="stylesheet">
    <style>
        .subtotal{
            font-weight: bold;
        }
        .total{
           font-weight: bold; 
        }
    </style>
     
@endsection

@section('javascript')
    <script src="{{ asset('assets/node_modules/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('js/performance.js') }}"></script>

    <script src="{{asset('assets/datepicker/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('assets/datepicker/locales/bootstrap-datepicker.es.js')}}"></script>
     <script src="{{ asset('assets/node_modules/echarts/echarts-all.js') }}"></script>
     

  <script>
    @if (\Session::has('success'))  
        Swal.fire({
            position: 'top-end',
            type: 'success',
            title: "{{\Session::get('success')}}",
            showConfirmButton: false,
            timer: 4000,
            customClass: "sweetAlert"
        })
    @endif

     @if (\Session::has('warning'))  
        Swal.fire({
            position: 'top-end',
            type: 'warning',
            title: "{{\Session::get('warning')}}",
            showConfirmButton: false,
            timer: 4000,
            customClass: "sweetAlert"
        })
    @endif

    @if (!count($report) && $buttonValue == 'report')  
        Swal.fire({
            position: 'top-end',
            type: 'warning',
            title: "No existen datos asociados a la búsqueda",
            showConfirmButton: false,
            timer: 4000,
            customClass: "sweetAlert"
        })
    @endif

    $('#profits').DataTable({
        "scrollX": true,
          "language": {
            "url": "../Spanish.json"
          },
          "bSort" : false,
          "searching": false,
        "pageLength": 25,
        "rowCallback": function( row, data, index ) {
                var first = data[4].charAt(0);
                var row1 = $('td:eq(4)', row);

                if (first == '-'){
                    $('td:eq(4)', row).css('color', "#f33212");
                }else if (row1[0].className == 'subtotalColumn'){
                    $('td:eq(4)', row).css('color', "#1d83f0");
                }else{
                     $('td:eq(4)', row).css('color', "#050505");
                }
            },
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;

            var total = api.column( 4 ).data();

            if (total.length !=1 ){
                var first = total[3].charAt(0);

                if (first == '-'){
                    $('td:eq(4)', row).css('color', "#f33212");
                }else{
                    $('#total').css('color','#1d83f0');
                }  
            }
        },
    });

    $('#initial_date').datepicker({
        autoclose: true,
        format: "mm-yyyy",
        startView: "months",
        minViewMode: "months",
        language: 'es-ES',
        endDate: "0m"
    });

    $('#end_date').datepicker({
        autoclose: true,
        format: "mm-yyyy",
        startView: "months",
        minViewMode: "months",
        language: 'es-ES',
        endDate: "0m"
    });

    $('#consultores_select').multiSelect();

  </script>

@endsection

@section('content')
<div>
    <div class="row page-titles">
        <div class="col-lg-8 col-md-9 col-sm-7 col-xs-2 align-self-center">
            <h4 class="text-themecolor">Performance Comercial</h4>
        </div>
    </div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs customtab" role="tablist">
                    <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#consultor" role="tab"><span class="hidden-sm-up"><i class="ti-check-box"></i></span> <span class="hidden-xs-down">Por consultor</span></a> </li>
                    <li class="nav-item"> <a class="nav-link " data-toggle="tab" href="#cliente" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Por cliente</span></a> </li>
                </ul>
                <form id="form_comercial">
                    <div class="tab-content">
                        <div class="tab-pane active" id="consultor" role="tabpanel">
                            <div class="row show-grid ">
                                <div class="form-group col-xs-3 col-md-2 col-lg-2 sale1">
                                    <label class="initial_date">
                                        Desde:</label>
                                        <input placeholder="mm-yyyy" type="text" class="form-control initial2" readonly="" name="initial_date" id="initial_date" value="{{$from}}"/>
                                            <small class="form-control-feedback help-block initial"></small>
                                </div>

                                <div class="form-group col-xs-3 col-md-2 col-lg-2">
                                    <label class="end_date">
                                        Hasta:</label>
                                        <input placeholder="mm-yyyy" type="text" class="form-control" readonly="" name="end_date" id="end_date" value="{{$to}}"/>
                                            <small class="form-control-feedback help-block"></small>
                                </div>

                                <div class="form-group col-lg-5 col-md-6 col-xlg-6 m-b-30">
                                    <label class="consultores_select">
                                        Consultores</label>
                                    <select id='consultores_select' name="consultores_select" multiple='multiple'>
                                        @foreach ($consultores as $consultor)
                                             <option value='{{$consultor->co_usuario}}' @if (in_array($consultor->co_usuario , explode(',' , $selected))) selected @endif>{{$consultor->no_usuario}}</option>
                                        @endforeach
                                    </select> <small class="form-control-feedback help-block"></small>
                                </div>
                                <div class="form-actions col-xs-3 col-md-2 col-lg-2" style="float:right">
                                        <button type="submit" class="btn btn-info" id="report" value='report' style="margin-top: 33px;margin-left: 5px;width: 100px;"> <i class="ti-stats-up"></i> Reporte</button>
                                        <button type="submit" class="btn btn-info" id="graphic" value="graphic" style="margin-top: 33px;margin-left: 5px;width: 100px;"> <i class="ti-bar-chart"></i> Barra</button>
                                        <button type="submit" class="btn btn-info" id="pizza" value="pizza" style="margin-top: 33px;margin-left: 5px;width: 100px;"> <i class="ti-pie-chart"></i> Pastel</button>
                                </div>
                            </div>

                            <div class="table-responsive @if (!count($report)) d-none @endif">
                                <table id="profits" class="display nowrap table table-hover table-striped table-bordered " width="100%">
                                    <thead>
                                        <tr>
                                            <th><strong>Periodo</strong></th>
                                            <th><strong>Receita Líquida</strong></th>
                                            <th><strong>Custo Fixo</strong></th>
                                            <th><strong>Comissão</strong></th>
                                            <th><strong>Lucro</strong></th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                        @foreach ($subtotal as $sub)
                                            <tr>
                                                <td ><strong>{{$sub['no_usuario']}}</strong></td>
                                                <td ></td>
                                                <td ></td>
                                                <td ></td>
                                                <td ></td>
                                            </tr>   
                                            @foreach ($report as $rep)
                                                @if($rep->co_usuario == $sub['co_usuario']) 
                                                <tr>
                                                    <td>{{$rep->periodo_desc}}</td>
                                                    <td align="right">@convert($rep->ganancia)</td>
                                                    <td align="right">-R$ {{number_format($rep->brut_salario, 2, ',', '.')}}</td>
                                                    <td align="right">-R$ {{number_format($rep->comision, 2, ',', '.')}}</td>
                                                    <td align="right">@if ($rep->ganancia - ($rep->brut_salario + $rep->comision) > 0 ) R$ {{number_format($rep->ganancia - ($rep->brut_salario + $rep->comision), 2, ',', '.')}} @else -R$ {{(number_format(($rep->ganancia - ($rep->brut_salario + $rep->comision))*-1, 2, ',', '.'))}} @endif</td>
                                                </tr>
                                                @endif
                                            @endforeach
                                            <tr class="subtotal">
                                                <td>Subtotal</td>
                                                <td align="right">@convert($sub['ganancia'])</td>
                                                <td align="right">-R$ {{number_format($sub['brut_salario'], 2, ',', '.')}}</td>
                                                <td align="right">-R$ {{number_format($sub['comision'], 2, ',', '.')}}</td>
                                                <td align="right" class="subtotalColumn">@convert($sub['beneficio'])</td>
                                            </tr>
                                        @endforeach
                                        <tr class="total">
                                           <td>SALDO</td>
                                           <td align="right">@convert($totalProfit)</td>
                                           <td align="right">-R$ {{number_format($fixedCost, 2, ',', '.')}}</td>
                                           <td align="right">-R$ {{number_format($comision, 2, ',', '.')}}</td>
                                           <td align="right" id="total">@if ($totalProfit - ($fixedCost + $comision) > 0 ) R$ {{number_format($totalProfit - ($fixedCost + $comision), 2, ',', '.')}} @else -R$ {{number_format(($totalProfit - ($fixedCost + $comision))*-1, 2, ',', '.')}} @endif</td>
                                           
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="card-body graphic @if (!count($graphic)) d-none @endif">
                                <h4 class="card-title">Gráfico Barra</h4>
                                <div id="bar-chart" style="width:100%; height:400px;"></div>
                            </div>

                            <div class="card-body pizza @if (!count($pizza)) d-none @endif">
                                <h4 class="card-title">Gráfico Pastel</h4>
                                <div id="pie-chart" style="width:100%; height:400px;"></div>
                            </div>

                        </div>
                        <div class="tab-pane" id="cliente" role="tabpanel">
                            
                        </div>
                    </div>  
                    <input hidden="" id="action" value=""  />
                </form>
            </div>

            </div>
        </div>
    </div>
</div>
</div>

@endsection