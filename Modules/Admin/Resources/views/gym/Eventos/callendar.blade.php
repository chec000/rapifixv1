<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>


<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading" style="color: white;">Calandario de eventos</div>
                	<select class="form-control">
                            <option><i class="fa fa-car" aria-hidden="true"></i> hola </option>
                    @for ($i = 0; $i < 10; $i++)
                    <option value="{{$i}}"> value-{{$i}}</option>
                     @endfor
                </select>
<div class="panel-body">
                    {!! $calendar->calendar() !!}
                </div>
            </div>
        </div>
    </div>
</div>

	<div id="calendar" class="modal fade in">
        <div class="modal-dialog">
            <div class="modal-content">
 
                <div class="modal-header" >
                    <a class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span></a>
                    <!--<h4 class="modal-title">Modal Heading</h4>-->
                    <div id="modalTitle"></div>
                </div>
                <div class="modal-body" id="modalBody">

                    
                </div>
                <div class="modal-footer">
                    <div class="btn-group">
                        <button class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                        <button class="btn btn-primary"><span class="glyphicon glyphicon-check"></span> Save</button>
                    </div>
                </div>
 
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dalog -->
    </div><!-- /.modal -->
    
@section('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>

{!! $calendar->script() !!}

@endsection