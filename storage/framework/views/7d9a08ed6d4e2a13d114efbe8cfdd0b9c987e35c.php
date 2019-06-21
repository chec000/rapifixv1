<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3>Reportes</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading clearfix">Reporte de clientes
                    <div class="pull-right">
                        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapse01"
                                aria-expanded="false" aria-controls="collapse01"><i class="fa fa-bars"></i></button>
                    </div>
                </div>
                <div class="panel-body collapse" id="collapse01">
                           <?php echo Form::open(array('route' => 'admin.shopping-report.reporte.clientes')); ?>

                         
                         <select class="form-control" id="select_dates_clients" name="estado"  required="required">
                             <option value="" selected="selected">Selecciona una opción</option>
                             <option value="0">Todos</option>
                             <option value="1">Al dia</option>
                              <option value="2">Con atrasos</option>
                         </select>
                         <br>
                         <div class="row" id="date_clientes">
                             <div class="col-md-6">
                                  <div class="form-group">
                            <label for="exampleInputEmail1">Fecha inicial</label>
                              <input type="date" name="date_start_client" class="form-control"  required="required">
                          </div>
                                  
                             </div>
                             <div class="col-md-6">
                                 <div class="form-group">
                                      <label for="exampleInputEmail1">Fecha final</label>
                                      <input type="date" name="date_end_client" class="form-control" required="required"> 
                                 </div>
                             </div>
                         </div> 
                         <br>
                         <div class="text-center">
                             
                             <button class="btn btn-success" type="submit"  name="btnGenerar" >
                                 Generar
                             </button>
                         </div>
                      
                        <?php echo Form::close(); ?>

                </div>
            </div>
            <div class="panel panel-info">
                <div class="panel-heading clearfix">Reporte de ventas
                    <div class="pull-right">
                        <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#collapse02"
                                aria-expanded="false" aria-controls="collapse02"><i class="fa fa-bars"></i></button>
                    </div>
                </div>
                <div class="panel-body collapse" id="collapse02">
                         <?php echo Form::open(array('route' => 'admin.shopping-report.reporte-general')); ?>

                         
                         <select class="form-control" id="select_dates_ventas" name="ventas">
                             <option value="" selected="selected">Selecciona una opción</option>                             
                             <option value="0">Mensual</option>
                             <option value="1">Filtrado</option>
                              <option value="2">Anual</option>
                              <option value="3">Venta efectivo</option>
                              <option value="4">Venta tarjeta</option>

                         </select>
                         <br>
                         <div class="row" id="dates_reports" style="display: none">
                             <div class="col-md-6">
                                  <div class="form-group">
                            <label for="exampleInputEmail1">Fecha inicial</label>
                              <input type="date" name="date_start" class="form-control">
                          </div>
                                  
                             </div>
                             <div class="col-md-6">
                                 <div class="form-group">
                                      <label for="exampleInputEmail1">Fecha final</label>
                                      <input type="date" name="date_end" class="form-control"> 
                                 </div>
                             </div>
                         </div> 
                         <br>
                         <div class="text-center">
                             
                             <button class="btn btn-success" type="submit"  name="btnGenerar" >
                                 Generar
                             </button>
                         </div>
                      
                        <?php echo Form::close(); ?>

                  
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading clearfix">categoria en proceso
                    <div class="pull-right">
                        <button class="btn btn-default" type="button" data-toggle="collapse" data-target="#collapse06"
                                aria-expanded="false" aria-controls="collapse06"><i class="fa fa-bars"></i></button>
                    </div>
                </div>
                <div class="panel-body collapse" id="collapse06">
                    <button class="btn btn-default btn-block">Mensual</button>
                    <button class="btn btn-default btn-block">Filtrado</button>  
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-success">
                <div class="panel-heading clearfix">Reporte de entrenadores
                    <div class="pull-right">
                        <button class="btn btn-success" type="button" data-toggle="collapse" data-target="#collapse03"
                                aria-expanded="false" aria-controls="collapse03"><i class="fa fa-bars"></i></button>
                    </div>
                </div>
                <div class="panel-body collapse" id="collapse03">
                   <button class="btn btn-default btn-block">Mensual</button>
                    <button class="btn btn-default btn-block">Filtrado</button>
                    
                </div>
            </div>
            <div class="panel panel-warning">
                <div class="panel-heading clearfix">Reporte de gastos
                    <div class="pull-right">
                        <button class="btn btn-warning" type="button" data-toggle="collapse" data-target="#collapse04"
                                aria-expanded="false" aria-controls="collapse04"><i class="fa fa-bars"></i></button>
                    </div>
                </div>
                <div class="panel-body collapse" id="collapse04">
                    <button class="btn btn-default btn-block">Mensual</button>
                    <button class="btn btn-default btn-block">Filtrado</button>  </div>
            </div>
            <div class="panel panel-danger">
                <div class="panel-heading clearfix">Reporte de inscripciones
                    <div class="pull-right">
                        <button class="btn btn-danger" type="button" data-toggle="collapse" data-target="#collapse05"
                                aria-expanded="false" aria-controls="collapse05"><i class="fa fa-bars"></i></button>
                    </div>
                </div>
                <div class="panel-body collapse" id="collapse05">
                    <button class="btn btn-default btn-block">Mensual</button>
                    <button class="btn btn-default btn-block">Filtrado</button>
                </div>
            </div>
        </div>
    </div>
</div>



<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!--<script src="<?php echo e(PageBuilder::js('add')); ?>"></script>-->

<script type="text/javascript">
    
$("#select_dates_ventas").change(function() {
    var value=$(this).val();
    if(value==="1"||value==="3"||value==="4"){
                  $("#dates_reports").show();
    }else{
                  $("#dates_reports").hide();
    }
});
    
    function reporte(tipo_reporte) {         
    $.ajax({
            url: route('admin.reporte-general'),
            type: 'POST',
            data: {tipo_reporte: tipo_reporte},
            success: function (data) {
        
            },
      error: function(data) { 
        console.log(data);          
    }

    });
    }

</script>