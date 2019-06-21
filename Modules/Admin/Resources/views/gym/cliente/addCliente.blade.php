<div class="container">
    <div class="row">
        <div class="col-md-12">            
            <button onclick="   openNav()" class="btn"><span>
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                </span> Ver carrito </button>
        </div>
    </div>
    <div class="row">        
        <section>
            <div class="wizard">
                <div class="wizard-inner">
                    <div class="connecting-line"></div>
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#step1" data-toggle="tab" aria-controls="Inscripción" role="tab" title="Inscripción">
                                <span class="round-tab">
                                    <i class="glyphicon glyphicon-user"></i>
                                </span>
                            </a>
                        </li>
                        <li role="presentation" class="disabled">
                            <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Membresia">
                                <span class="round-tab">
                                    <i class="fa fa-shopping-cart"></i>                            
                                </span>
                            </a>
                        </li>
                        <li role="presentation" class="disabled">
                            <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Confirmación">
                                <span class="round-tab">
                                    <i class="glyphicon glyphicon-credit-card"></i>
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>         
                <div class="tab-content">
                    <div class="tab-pane active" role="tabpanel" id="step1">
                        <div role="tabpanel" class="tab-pane fade in sow active" id="cliente">               
                            <div class="panel panel-info">                 
                                <div class="panel-heading"> <h3 class="panel-title">{{ __('Register') }}</h3> </div>
                                <div class="panel-body">
                                    {!! Form::open(array('route' => 'admin.client.save_cliente','id'=>'save_client')) !!}

                                    <input type="hidden" name="tipo_inscripcion" value="1">
                                    <input type="hidden" name="lat" value="0">
                                    <input type="hidden" name="lon" value="0">
                                    <input type="hidden" name="concepto" id="concepto" value="Inscripcion y compra membresia" >
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>                          
                                            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{( $cliente!=null)?$cliente['name']:""}}" required autofocus>
                                            @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                            @endif                          
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="apellido_paterno" class="col-md-4 col-form-label text-md-right">{{ __('Apellidos') }}</label>                   
                                            <input id="apellido_paterno" type="text" class="form-control{{ $errors->has('apellido_paterno') ? ' is-invalid' : '' }}" name="apellido_paterno" value="{{( $cliente!=null)?$cliente['apellido_paterno']:""}}" required>                               
                                            @if ($errors->has('apellido_paterno'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('apellido_paterno') }}</strong>
                                            </span>
                                            @endif                            
                                        </div>
                                    </div>                                      
                                    <div class="row">

                        <div class="form-group col-md-6">
                                           <label for="clave_unica" class="col-form-label text-md-right">{{ __('Clave unica de identificación') }}</label>          
                                            <input id="clave_unica" type="text" class="form-control{{ $errors->has('clave_unica') ? ' is-invalid' : '' }}" name="clave_unica" value="{{( $cliente!=null)?$cliente['clave_unica']:""}}" required>
                                            @if ($errors->has('clave_unica'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('clave_unica') }}</strong>
                                            </span>
                                            @endif                          
                                        </div>  
                                   
                                        <div class="form-group col-md-6 ">
                                            <label for="telefono" class=" col-form-label text-md-right">{{ __('Teléfono') }}</label>                       
                                            <input id="telefono" type="tel" class="form-control{{ $errors->has('telefono') ? ' is-invalid' : '' }}" name="telefono" value="{{( $cliente!=null)?$cliente['telefono']:""}}" required >
                                            @if ($errors->has('telefono'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('telefono') }}</strong>
                                            </span>
                                            @endif                      
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="telefono_celular" class="col-md-4 col-form-label text-md-right">{{ __('Teléfono celular') }}</label>
                                            <input id="telefono_celular" type="tel" class="form-control{{ $errors->has('telefono_celular') ? ' is-invalid' : '' }}" name="telefono_celular" value="{{( $cliente!=null)?$cliente['telefono_celular']:""}}" required>
                                            @if ($errors->has('telefono_celular'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('telefono_celular') }}</strong>
                                            </span>
                                            @endif                        
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="fecha_nacimiento" class="col-md-4 col-form-label text-md-right">{{ __('Fecha nacimiento') }}</label>
                                            <input id="fecha_nacimiento" type="date" class="form-control{{ $errors->has('fecha_nacimiento') ? ' is-invalid' : '' }}" name="fecha_nacimiento" value="{{( $cliente!=null)?$cliente['fecha_nacimiento']:""}}" required>
                                            @if ($errors->has('fecha_nacimiento'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('fecha_nacimiento') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>               
                                    <div class="row">
                                                                                
                                        <div class="form-group col-md-6">
                                            <label for="estado_civil" class="col-md-4 col-form-label text-md-right">{{ __('Estado civil') }}</label>                                        
                                               <select value="{{( $cliente!=null)?$cliente['estado_civil']:""}}"  name="estado_civil" class="form-control{{ $errors->has('estado_civil') ? ' is-invalid' : '' }}">
                                          <option value="" selected>Selecciona una opción</option>
                                          <option value="Soltero">Soltero</option>
                                          <option value="Casado">Casado</option>
                                               </select>                                            
                                            @if ($errors->has('fecha_nacimiento'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('estado_civil') }}</strong>
                                            </span>
                                            @endif                           
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="pais" class="col-md-4 col-form-label text-md-right">{{ __('País') }}</label>
                                            <select name="pais"  class="form-control" id="pais" onchange="getEstadoPais(this);">
                                                @foreach ($paises as $p)
                                                <option  value="{{$p->id}}">{{$p->nombre}}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('pais'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('pais') }}</strong>
                                            </span>
                                            @endif
                                        </div>                            
                                    </div>                                    
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="estado" class="col-md-4 col-form-label text-md-right">{{ __('Estado') }}</label>
                                            <select name="estado"   class="form-control" id="estado">
                                                <option></option>
                                            </select>
                                            @if ($errors->has('estado'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('estado') }}</strong>
                                            </span>
                                            @endif                            
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="direccion" class="col-md-4 col-form-label text-md-right">{{ __('Dirección') }}</label>
                                            <input id="direccion" type="text" class="form-control{{ $errors->has('direccion') ? ' is-invalid' : '' }}" name="direccion" value="{{( $cliente!=null)?$cliente['direccion']:""}}" required>
                                            @if ($errors->has('direccion'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('direccion') }}</strong>
                                            </span>
                                            @endif                           
                                        </div>
                                    </div>    
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Correo electrónico') }}</label>

                                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{( $cliente!=null)?$cliente['email']:""}}" required >

                                            @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{ trans('admin::countries.add_flag') }}</label>
                                                <div class="input-group">
                                                    <input id="flag" class="img_src form-control" name="flag" value=''  type="text" value="{{( $cliente!=null)?$cliente['flag']:""}}">
                                                    <span class="input-group-btn">
                                                        <a href="{!! URL::to(config('admin.config.public').'/filemanager/dialog.php?type=1&field_id=flag') !!}" class="btn btn-default iframe-btn">{{ trans('admin::countries.add_btn_image') }}</a>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required value="{{( $cliente!=null)?$cliente['password']:""}}">

                                            @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                            @endif

                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>                            
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required value="{{( $cliente!=null)?$cliente['password']:""}}">
                                        </div>                            
                                    </div>   

                                    <!--<button type="submit" class="btn btn-primary next-step">Save and continue</button>-->
                                    <button type="button" class="btn btn-primary next-step">Save and continue</button>
                                    {!! Form::close() !!}

                                </div>
                            </div>
                        </div>

                        <!--                        <ul class="list-inline pull-right">
                                                    <li><button type="button" class="btn btn-primary next-step">Save and continue</button></li>
                                                </ul>-->
                    </div>
                    <div class="tab-pane" role="tabpanel" id="step2">
                        {!!$list_membresias!!}           


                        <ul class="list-inline pull-right">
                            <li><button type="button" class="btn btn-default prev-step">Previous</button></li>
                            <li><button type="button" class="btn btn-primary next-step">Save and continue</button></li>
                        </ul>
                    </div>
                    <div class="tab-pane" role="tabpanel" id="step3">
                        <h3>Step 3</h3>

                        <ul class="list-inline pull-right">
                            <li><button type="button" class="btn btn-default prev-step">Previous</button></li>
                            <li><button type="button" class="btn btn-default next-step">Skip</button></li>
                            <li><button type="button" class="btn btn-primary btn-info-full next-step">Save and continue</button></li>
                        </ul>
                    </div>
                    <div class="tab-pane" role="tabpanel" id="complete">
                        <h3>Resultado</h3>

                    </div>
                    <div class="clearfix"></div>
                </div>

            </div>
        </section>
    </div>
</div>




<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!--<script src="{{ PageBuilder::js('add') }}"></script>-->

{!! Form::open(array('route' => 'admin.Estados.estados','id'=>'form_estado')) !!}
<input type="hidden" id="id_pais" name="id_pais">

{!! Form::close() !!}

{!!$venta_aside!!}

<script type="text/javascript">
                    var tipo_pago = "";
                    function tipoPago(tipo, element) {
                        tipo_pago = tipo;
                        var tarjetas = $('.searchable-container').find('label');
                        if (element.id === "pago_efectivo") {
                            $("#pago_con_efectivo").css('display', 'block');
                        } else {
                            $("#pago_con_efectivo").css('display', 'none');
                        }
                        $.each(tarjetas, function (index, value) {
                            if (value.id !== element.id) {
                                value.classList.remove('active');
                            }
                        });
                    }

                    function agregarMembresia(id, nombre) {
                        saveMembresia(id, 1).done(function (data) {
                            openNav();
                            if (data.code == 100) {
                                var m = $("#list_membresias");
                                m.append(data.data);
                            }
                        });
                    }

                    function  realizarPago(tipo) {
                        var concepto=$("#concepto").val();
                        var tipo_transaccion=1;
                        $('.loader').addClass("show");
                        if (tipo_pago === "efectivo") {
                            var pago_cliente = $("#pago_cliente").val();
                        } else {
                            pago_cliente = 0;
                        }

                        if (tipo_pago === "efectivo") {
                            if (pago_cliente > 0) {
                                finalizarCheckout(tipo_pago, pago_cliente,tipo_transaccion,concepto);
                            }
                        } else {
                            finalizarCheckout(tipo_pago, pago_cliente,tipo_transaccion,concepto);
                        }
                    }

                    function finalizarCheckout(tipo_pago, pago_cliente,transaccion,concepto) {
                        $.ajax({
                            url: route('admin.Cliente.finalizar_compra'),
                            data: {tipo_pago: tipo_pago, pago_cliente: pago_cliente,tipo_venta:transaccion,concepto:concepto},
                            type: 'POST',
                            dataType: 'json',
                            success: function (data) {
                                $('.loader').removeClass("show");
                                $('#primary').modal('hide');
                                var $active = $('.wizard .nav-tabs li.active');
                                $active.next().removeClass('disabled');
                                nextTab($active);
                                var mensajes = $("#cmsDefaultNotification");
                                if (data.code == 200) {
                                    mensajes.css('display', 'block');
                                    mensajes.addClass('panel panel-success');
                                      $("#success").modal('show');
                                    $("#cantidad_pagar").text(data.total);
                                    $("#cantidad_restante").text(data.diferencia);                                  
                                    $("#mensaje_final").append("<span class='label label-success'>" + data.data + "</span>");
                                    mensajes.append("  <h1>" + data.data + "</h1>");

                                } else {
                                    mensajes.append("  <span class='label label-success'>" + data.data + "</span>");
                                }
                            },
                            error: function (data) {
                                $('.loader').removeClass("show");
                                $('#primary').modal('hide');

                                scrollTop();
                            }
                        });
                    }



   
                    function showModalPago() {
                        var total_cliente = $("#total_membresia").text();
                        $("#total_pagar_cliente").text(total_cliente);
                        $("#primary").modal('show');
                    }

                    function addCantidad(id, cantidad, precio) {
                        var subtotal = $("#subtotal_membresia-" + id);
                        var old_value = $("#cantidad_m-" + id);
                        if (cantidad === null) {
                            var ca = old_value.val();
                            old_value.val(parseInt(ca) + 1);
                        }

                        subtotal.text(old_value.val() * precio);
                    }

                    function eliminarMembresia(id) {
                        $("#membresia-" + id).remove();
                    }


                    $(document).ready(function () {
                        //Initialize tooltips
                        $('.nav-tabs > li a[title]').tooltip();
                        //Wizard
                        $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

                            var $target = $(e.target);
                            if ($target.parent().hasClass('disabled')) {
                                return false;
                            }
                        });
                        $(".next-step").click(function (e) {

                            saveCliente().done(function (data) {
                                if (data.status == true) {
                                    var $active = $('.wizard .nav-tabs li.active');
                                    $active.next().removeClass('disabled');
                                    nextTab($active);
                                } else {

                                    if (data.code == 300) {
                                        var $active = $('.wizard .nav-tabs li.active');
                                        $active.next().removeClass('disabled');
                                        nextTab($active);
                                    }else if(data.code===600){
                                        $("#dialog").dialog();
                                        var mensajes = $("#cmsDefaultNotification");
                                            mensajes.css('display', 'block');
                                            mensajes.addClass('panel panel-danger');
                                            $('html, body').animate({scrollTop: 0}, 'slow');
                                            mensajes.append("  <span class='label label-danger'>" + data.data + "</span>");
                                        
                                    } else {
                                        $("#dialog").dialog();
                                        var mensajes = $("#cmsDefaultNotification");
                                        $.each(data.data, function (index, value) {
                                            mensajes.css('display', 'block');
                                            mensajes.addClass('panel panel-danger');
                                            $('html, body').animate({scrollTop: 0}, 'slow');
                                            mensajes.append("  <span class='label label-danger'>" + value + "</span>");
                                        });
                                    }
                                }
                            });
                        });
                        $(".prev-step").click(function (e) {

                            var $active = $('.wizard .nav-tabs li.active');
                            prevTab($active);
                        });
                    });
                    function saveCliente() {
                        form = $("#save_client");
                        var request = $.ajax({
                            url: form.attr('action'),
                            data: form.serialize(),
                            type: form.attr('method'),
                            dataType: 'json',
                        });
                        return request;
                    }

                    function saveMembresia(id, cantidad) {
                        var request = $.ajax({
                            url: route('admin.Cliente.add_membresia'),
                            data: {id_membresia: id, cantidad: cantidad},
                            type: 'POST',
                            dataType: 'json',
                        });
                        return request;
                    }


                    function nextTab(elem) {
                        $(elem).next().find('a[data-toggle="tab"]').click();
                    }
                    function prevTab(elem) {
                        $(elem).prev().find('a[data-toggle="tab"]').click();
                    }
                    function addMembresia(id_membresia,nombre, tipo) {
                        $.ajax({
                            url: route('admin.Cliente.add_less_membresia'),
                            type: 'POST',
                            data: {id_membresia: id_membresia, tipo: tipo},
                            success: function (data) {
                                $("#total_membresia").text(data.total_pagar);
                                $("#cantidad-membresia-" + id_membresia).text(data.cantidad);
                                $("#subtotal-membresia-" + id_membresia).text(data.subtotal);
                            }

                        });
                    }

                    var exist_data = false;

                    function detalleVenta() {
                        closeNav();
                        if (exist_data == false) {
                            $.ajax({
                                url: route('admin.Cliente.detalle_venta_checkout'),
                                type: 'GET',
                                success: function (data) {
                                    $("#step3").html(data);
                                    exist_data = true;
                                }
                            });
                        }
                    }

                    function scrollTop() {
                        $('html, body').animate({scrollTop: 0}, 800);
                    }
                    function reload(){
                    location.reload();
                    }
</script>
