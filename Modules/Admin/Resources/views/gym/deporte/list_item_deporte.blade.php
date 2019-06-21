@foreach($deportes as $m)
          <div class="col-sm-6 col-md-4">
                                        <div class="thumbnail">
                                            <img src="{{$m->foto}}" alt="...">
                                            <div class="caption">
                                                <h1>Precio $ {{$m->precio}}</h1>
                                                <h3>{{$m->nombre}}</h3>


                                                <p><a href="{{ route('admin.Deporte.detail',['id'=>$m->id]) }}">{{str_limit($m->descripcion, $limit = 30, $end = '...')}}</a></p>
                                                <!--<button type="button" onclick="openNav()" class="btn btn-lg btn-block btn-outline-primary">Seleccionar</button>-->

                                                <button type="button" onclick="agregarDeportes({{$m->id}},'{{$m->nombre}}',{{$m->precio}})" class="btn btn-lg btn-block btn-outline-primary">Seleccionar</button>

                                            </div>
                                        </div>
                                    </div>          


@endforeach