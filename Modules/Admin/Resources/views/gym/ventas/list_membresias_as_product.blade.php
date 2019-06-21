                 <div class="panel panel-info">
                            <div class="panel-heading">{{ __('Asignar  Membresias') }}</div>
                            <div class="panel-body">                                   
                                <div class="row">
                                    @foreach ($membresias as $m)        
                                    <div class="col-sm-6 col-md-4">
                                        <div class="thumbnail">
                                            <a href="{{route('admin.Membresia.detail-membresia',['id'=>$m->id])}}">
                                                                                        <img src="{{$m->imagen}}" alt="{{$m->nombre}}">
    
                                                </a>
                                            
                                            <div class="caption">
                                                <h1>Precio $ {{$m->precio}}</h1>
                                                <h3>{{$m->nombre}}</h3>
                                                <p><a href="{{route('admin.Membresia.detail-membresia',['id'=>$m->id])}}">{{str_limit($m->descripcion, $limit = 30, $end = '...')}}</a></p>
                                                <!--<button type="button" onclick="openNav()" class="btn btn-lg btn-block btn-outline-primary">Seleccionar</button>-->
                                                <button type="button" onclick="agregarMembresia({{$m->id}},'{{$m->nombre}}',{{$m->precio}})" class="btn btn-lg btn-block btn-outline-primary">Seleccionar</button>
                                            </div>
                                        </div>
                                    </div>                     
                                    @endforeach         
                                </div>                           
                            </div>
                        </div>   