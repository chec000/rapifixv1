<div class="modal fade" id="primary" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h1 style="color:white!important"><i class="glyphicon glyphicon-thumbs-up"></i> Actualizar membresia</h1>
            </div>
            <div class="modal-body">     
                <div class="row">
                    <div class="form-group">
                        <p style="font-size: 27px;">
                                 <span>Membresia: </span><strong id="nombre_membresia"></strong>
                        </p>
                        <p style="font-size: 27px;">
                                 <span>Precio: $</span><strong id="precio_membresia"></strong>
                        </p>
                        
                    </div>
                </div>
                
                <div class="row">
                    <div class="form-group">
                        <div class="searchable-container">
                            <div class="items col-xs-5 col-sm-5 col-md-3 col-lg-3">
                                <div class="info-block block-info clearfix">
                                    <div class="square-box pull-left">
                                        <span class="glyphicon glyphicon-tags glyphicon-lg"></span>
                                    </div>
                                    <div data-toggle="buttons" class="btn-group bizmoduleselect" >
                                        <label id="pago_efectivo" class="btn btn-default" style="border-radius:3px;" onclick="tipoPago('pago_efectivo', this)">
                                            <div class="bizcontent">
                                                <input type="checkbox" name="var_id[]" autocomplete="off" value="">
                                                <span class="glyphicon glyphicon-ok glyphicon-lg"></span>
                                                <h5>Efectivo</h5>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="items col-xs-5 col-sm-5 col-md-3 col-lg-3">
                                <div class="info-block block-info clearfix">
                                    <div class="square-box pull-left">
                                        <span class="glyphicon glyphicon-tags glyphicon-lg"></span>
                                    </div>
                                    <div data-toggle="buttons" class="btn-group bizmoduleselect"  >
                                        <label  id="tarjeta" class="btn btn-default" style="border-radius:3px;" onclick="tipoPago('tarjeta', this)">
                                            <div class="bizcontent">
                                                <input type="checkbox" name="var_id[]" autocomplete="off" value="">
                                                <span class="glyphicon glyphicon-ok glyphicon-lg"></span>
                                                <h5>Tarjeta</h5>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="items col-xs-5 col-sm-5 col-md-3 col-lg-3">
                                <div class="info-block block-info clearfix">
                                    <div class="square-box pull-left">
                                        <span class="glyphicon glyphicon-tags glyphicon-lg"></span>
                                    </div>
                                    <div data-toggle="buttons" class="btn-group bizmoduleselect" >
                                        <label id="otro" class="btn btn-default" style="border-radius:3px;" onclick="tipoPago('otro', this)">
                                            <div class="bizcontent">
                                                <input type="checkbox" name="var_id[]" autocomplete="off" value="">
                                                <span class="glyphicon glyphicon-ok glyphicon-lg"></span>
                                                <h5>Otro</h5>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
                
                <br>
                <div class="row" id="pago_con_efectivo" style="display: none">
                    <div class="col-md-12">
                            <div class="form-group form-inline">
                                  <label for="pago_cliente">Pago: </label>
                                  <input type="number" class="form-control" id="pago_cliente" min="1" placeholder="Ingrese el pago">
                                </div>
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <div class="row">
                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                                    <button onclick="actualizarMembresia()" type="button" class="btn btn-success pull-rigth" >Confirmar</button>                                    
                </div>
                
                
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<style>
    .modal-header-primary {
        color:#fff;
        padding:9px 15px;
        border-bottom:1px solid #eee;
        background-color: #428bca;
        -webkit-border-top-left-radius: 5px;
        -webkit-border-top-right-radius: 5px;
        -moz-border-radius-topleft: 5px;
        -moz-border-radius-topright: 5px;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;


    }
    .searchable-container{margin:20px 0 0 0}
    .searchable-container label.btn-default.active{background-color:#007ba7;color:#FFF}
    .searchable-container label.btn-default{width:90%;border:1px solid #efefef;margin:5px; box-shadow:5px 8px 8px 0 #ccc;}
    .searchable-container label .bizcontent{width:100%;}
    .searchable-container .btn-group{width:90%}
    .searchable-container .btn span.glyphicon{
        opacity: 0;
    }
    .searchable-container .btn.active span.glyphicon {
        opacity: 1;
    }


</style>