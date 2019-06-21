  <div class="card">
                    <div class="card-header">{{ __('Asignar  Membresias') }}</div>
                    <div class="card-body">     

                        <form action="" class="formulario">
                            <div class="card-deck mb-3 text-center">                                                                
                            </div>
                              @foreach ($membresias as $m)           
                              <div class="card mb-4 box-shadow" style="width: 232px;display: inline-block">
                                                      <div class="card-header">
                                                        <h4 class="my-0 font-weight-normal">Free</h4>
                                                      </div>
                                                      <div class="card-body">
                                                               <img  src="https://www.w3schools.com/bootstrap4/img_avatar3.png" alt="John Doe" class="mr-3 mt-3 rounded-circle" style="width:60px;">
                                 
                                                        <h1 class="card-title pricing-card-title">${{$m->precio}} <small class="text-muted">/ mo</small></h1>
                                                        <ul class="list-unstyled mt-3 mb-4">
                                                          <li>Nombre : {{$m->nombre}}</li>
                                                          <li>2 GB of storage</li>
                                                          <li>Email support</li>
                                                          <li>Help center access</li>
                                                        </ul>
                                                        <button type="button" onclick="agregarMembresia({{$m->id}},'{{$m->nombre}}',{{$m->precio}})" class="btn btn-lg btn-block btn-outline-primary">Seleccionar</button>
                                                      </div>
                                                    </div>
                            

                            @endforeach         


                        </form>


                    </div>
                    <table class="table table-hover" id="tbl_membresias_agregadas">
                        <thead>Lista</thead>
                        <th>Membresia</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th>Eliminar</th>
                        <tbody>     
                        </tbody>
                    </table>
                </div>