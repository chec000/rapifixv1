<h1>{{ trans('admin::shopping.productsrestriction.label.title') }}</h1>
@if(session('msg'))
    <div class="alert alert-success" role="alert">{{ session('msg') }}</div>
@elseif(session('errors') != null)
    <div class="alert alert-danger" role="alert">{{ session('errors')->first('msg') }}</div>
@endif
<div class="form-group">
        <fieldset class="fieldset_gray">
            <legend class="legend_gray">
                {{ trans('admin::shopping.productsrestriction.label.fieldset_tit') }} {{ $countryUser[$id] }}
            </legend>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('id_country', trans('admin::shopping.productsrestriction.label.countries'), ['class' => 'control-label']) !!}
                        {!! Form::select('id_country', $countryUser, $id, ['required','class' => 'form-control', 'id' => 'country_id']) !!}
                    </div>
                </div>
                {!! Form::open( ['route' => ['admin.productRestrictions.update','id' => $id], 'method' => 'PUT']) !!}
                <div class="col-md-6">
                    <div class="form-group @if (!$response['status']) has-error @endif">
                        <label for="code_state" class="control-label">
                            {{trans('admin::shopping.productsrestriction.label.state')}}
                            <span onclick="deleteSearch()" class="btn btn-warning" style="padding: 1px 5px; font-size: 10px; font-weight: normal" >
                            {{trans('admin::shopping.productsrestriction.label.delete') }} <i class="fa fa-times" aria-hidden="true"></i>
                        </span>
                        </label>
                        {!! Form::select('code_state', $response['data'], session('code') != null ? session('code'): "" , ['required','class' => 'form-control', 'id'=>'code_state']) !!}
                        <span class="help-block" style="color: red">{{ $errors->first('code_state') }}</span>
                        @if (!$response['status'])
                            <span class="help-block">
                                @foreach ($response['messages'] as $i => $msg)
                                    {!! $i == (sizeof($response['messages'])-1) ? '<i>'.$msg.'</i>' : $msg.'<br>' !!}
                                @endforeach
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-10">
                    {!! Form::label('product_id', trans('admin::shopping.productsrestriction.label.product'), ['class' => 'control-label']) !!}
                    {!! Form::select('product_id', $prodCountry, null,array('class' => 'form-control', 'id' => 'select_product_id')) !!}
                    <span class="help-block" style="color: red">{{ $errors->first('country') }}</span>
                </div>
                <div class="col-md-2 text-center">
                    <button class='btn btn-primary addButton' type="submit">
                        {{trans('admin::shopping.productsrestriction.label.button-save')}}
                    </button>
                </div>
                {!! Form::close() !!}
            </div>
        </fieldset>
</div><br />
<div class="form-group">
    <div class="table">
        <table class="table table-striped" id="tb_products">
            <thead>
                <tr>
                    <th>{{trans('admin::shopping.productsrestriction.label.table.product')}}</th>
                    <th>{{trans('admin::shopping.productsrestriction.label.table.state')}}</th>
                    <th class="text-center">{{trans('admin::shopping.productsrestriction.label.table.delete')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productRestrictions as $pR)
                    @foreach($pR->productsRestriction as $p)
                    <tr>
                        <td>  {{ $pR->product->sku }} - {{ $pR->name }}  </td>
                        <td>  {{ $p->state }}  </td>
                        <td class="text-center">
                            @if (Auth::action('productRestrictions.destroy'))
                                {!! Form::open( ['route' => ['admin.productRestrictions.destroy','id' => $p->id], 'id' => 'delete_form'.$pR->id, 'method' => 'DELETE']) !!}
                                <i class="fa fa-trash" aria-hidden="true" onclick="document.getElementById('delete_form{{$pR->id}}').submit();"></i>
                                {!! Form::hidden('idCountry', $id) !!}
                                {!! Form::hidden('code', session('code') != null ?  session('code') : "",['id'=>'id_state_delete']) !!}
                                {!! Form::close() !!}
                            @endif
                        </td>
                    </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@section('scripts')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script type="text/javascript">
        var table = $('#tb_products').DataTable({ "responsive": true, });
        $( document ).ready(function() {
            $('#code_state').select2();
            $('#select_product_id').select2();
            $('#country_id').change(function(){
                countryChange($(this).val())
            });
            $('#code_state').change(function () {
                var optSel = $(this).val();
                table.search(optSel).draw();
            });
            var codeState = "{{ session('code') != null ?  session('code') : "" }}";
            if(codeState != ""){
                table.search(codeState).draw();
            }
        });
        function countryChange(id){
            var url = window.location.origin;
            var splitUrl = window.location.pathname.split('/');
            splitUrl.shift();
            splitUrl.length == 3 ? splitUrl[splitUrl.length-1] = id : splitUrl.push(id);
            for (i = 0; i < splitUrl.length; i++){ url = url + "/" + splitUrl[i]; }
            $( location ).attr("href", url);
        }
        function deleteSearch() {
            table.search("").draw();
        }
    </script>
@endsection