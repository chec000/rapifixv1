<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info" style="width: 310px;">
                <div class="panel-heading">
                    <div class="panel-title">
                        <div class="row">
                            <div class="col-xs-6">
                                <h5><span class="glyphicon glyphicon-shopping-cart"></span> Shopping Cart</h5>
                            </div>
                            <div class="col-xs-6">
                                <button type="button" class="btn btn-primary btn-sm btn-block">
                                    <span class="glyphicon glyphicon-share-alt"></span> Continue shopping
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div id="items">
                        <div  id="list_membresias">					
                         
                            {!!$membresias!!}
                            </div>
                        </div>
                    </div>
                    <hr>

                </div>
                <div class="panel-footer">
                    <div class="row text-center">
                        <div class="col-xs-6">
                            <h4 class="text-right">Total $<strong id="total_membresia">{{Session::get('portal.main.gym.cliente.total_pagar')}}</strong></h4>
                        </div>
                        <div class="col-xs-6">
                            <button type="button" class="btn btn-success btn-block next-step" onclick="detalleVenta()">
                                Pagar
                            </button>                                                       
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
