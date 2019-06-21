<div class="row textbox">
    <div class="col-sm-6">
        <h1>{{ trans('admin::shopping.banks.index.list_estatus') }}</h1>
    </div>
    @if ($can_add)
    <div class="col-sm-6 text-right">     
        <a href="{{ route('admin.banks.add') }}" class="btn btn-warning addButton"><i class="fa fa-plus"></i> &nbsp;
            {{ trans('admin::shopping.banks.index.add_new_banks') }}</a>
    </div>
    @endif

</div>
@if(Session::has('info'))

    <p class="alert {{ Session::get('info')['alertclass'] }}" role="alert">
        {{ Session::get('info')['message'] }}
    </p>

@endif
<div class="table">


    <table class="table table-striped" id="tbl_banks">
        <thead>
            <tr>
                <th>{{ trans('admin::shopping.banks.index.bank_key') }}</th>
                <th>{{ trans('admin::shopping.banks.index.countries') }}</th>
                <th>{{ trans('admin::shopping.banks.index.status') }}</th>
                @if ($can_edit || $can_delete)
                <th>{{ trans('admin::shopping.banks.index.actions') }}</th>
                @endif
            </tr>
        </thead>
        <tbody>
        @foreach ($banks as $bk)
            <tr id="lang_{!! $bk->id !!}">
                <td>{!! $bk->bank_key !!}</td>

                <td>@foreach($bk->banksCountry as $ocountry)<span class="label label-default" style="margin-right: .25em;">{!! $ocountry->country->name !!}</span>@endforeach</td>
                <td><span id="status{{$bk->id}}"  class="label  {{$bk->active ? 'label-success' : 'label-default'}} ">{!! $bk->active == 0 ?  trans('admin::language.lang_list_st_inactive')  : trans('admin::language.lang_list_st_active')  !!}</span></td>
                @if ($can_edit || $can_delete)
                    <td data-lid="{!! $bk->id !!}">
                    <span onclick="disableBanks({{$bk->id}})" id='activeBanks{{$bk->id}}' class="{{$bk->active ? 'hide' : ''}}">
                        <i class="glyphicon glyphicon-stop itemTooltip  " title="{{ trans('admin::shopping.banks.index.enable') }}"></i>
                    </span>
                    <span onclick="disableBanks({{$bk->id}})" id='inactiveBanks{{$bk->id}}' class="{{$bk->active ? '' : 'hide'}}">
                        <i class="glyphicon glyphicon-play itemTooltip " title="{{ trans('admin::shopping.banks.index.disable') }}"></i>
                     </span>
                     <a class="glyphicon glyphicon-pencil itemTooltip" href="{{ route('admin.banks.edit', ['oe_id' => $bk->id]) }}" title="{{ trans('admin::language.lang_list_edit') }}"></a>

                        <span onclick="deleteBanks({{$bk->id}})" id='deleteBanks{{$bk->id}}'>
                        <i class="glyphicon glyphicon-trash itemTooltip " title="{{ trans('admin::shopping.banks.index.delete') }}"></i>
                     </span>

                     <span onclick="getCountries({{$bk->id}})">
                        <i class="glyphicon glyphicon-globe itemTooltip " title="{{ trans('admin::shopping.banks.index.countries') }}"></i>
                     </span>
                    </td>
                @endif

            </tr>
        @endforeach

        </tbody>
    </table>


    <div class="modal" tabindex="-1" role="dialog" id="countriesModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('admin.banks.updatecountries') }}" id="countriesSelection" method="post">

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">


                    <div class="modal-header">

                        <p>{{ trans('admin::shopping.banks.index.instructions') }}</p>
                    </div>
                    <div class="modal-body" id="bodyCountries">





                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="idbank" value=""/>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" >{{trans('admin::shopping.banks.index.close')}}</button>
                        <button type="submit" class="btn btn-primary" id="saveCountries">{{trans('admin::shopping.banks.index.save')}}</button>

                    </div>
                </form>
            </div>
        </div>
    </div>



</div>
@section('scripts')
<script type="text/javascript">

    $('#tbl_banks').DataTable({
    "responsive": true,
            "ordering": false,
             "language": { 
                    "url": "{{ trans('admin::datatables.lang') }}"
               }  
    });

    // process the form




    function disableBanks(bank_id) {
        $.ajax({
            url: route('admin.banks.active'),
            type: 'POST',
            data: {bank_id: bank_id},
            success: function (data) {
                let label = $("#status" + bank_id);
                let iconActive = $("#activeBanks" + bank_id);
                let iconInactive = $("#inactiveBanks" + bank_id);
                if (data.status === 0) {
                    iconActive.removeClass('hide');
                    iconInactive.addClass('hide');
                    label.removeClass('label-success').addClass('label-default');
                    label.text(data.message);
                }
                else {
                    iconActive.addClass('hide');
                    iconInactive.removeClass('hide');
                    label.removeClass('label-default').addClass('label-success');
                    label.text(data.message);
                }
            }
        });
    }

    function deleteBanks(bank_id) {
        $.ajax({
            url: route('admin.banks.delete'),
            type: 'POST',
            data: {bank_id: bank_id},
            success: function (data) {

                if (data.status) {
                    location.reload();
                }
                else {

                }
            }
        });
    }


    function getCountries(bank_id){


        $.ajax({
            url: route('admin.banks.countries'),
            type: 'POST',
            data: {bank_id: bank_id},
            success: function (data) {


                if (data.success) {
                    $("#bodyCountries").empty();
                    $.each(data.message, function(i, item) {
                        console.log(i,item.estatus);
                        var check = parseInt(item.estatus) == 1 ? 'checked' : '';
                        //var estatus = parseInt(item.estatus) == 0 ? 2 : 1;
                        $("#bodyCountries").append('<div class="checkbox"> <label><input name="countries_name['+i+']" type="checkbox" value="'+parseInt(item.estatus)+'" '+check+'>'+item.name+'</label></div>');

                    });

                    $("#bodyCountries").append('<input name="bank_identifier" type="hidden" value="'+bank_id+'">');
                    $("#countriesModal").modal('show');
                }
                else {

                }
            }
        });


    }

</script>
@stop