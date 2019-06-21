<div class="row textbox">
    <div class="col-sm-6">
        <h1>{{ trans('admin::shopping.securityquestions.index.list_estatus') }}</h1>
    </div>
    @if ($can_add)
    <div class="col-sm-6 text-right">     
        <a href="{{ route('admin.securityquestions.add') }}" class="btn btn-warning addButton"><i class="fa fa-plus"></i> &nbsp;
            {{ trans('admin::shopping.securityquestions.index.add_new_securityquestions') }}</a>
    </div>
    @endif

</div>
@if(Session::has('info'))

    <p class="alert {{ Session::get('info')['alertclass'] }}" role="alert">
        {{ Session::get('info')['message'] }}
    </p>

@endif
<div class="table">


    <table class="table table-striped" id="tbl_securityquestions">
        <thead>
            <tr>
                <th>{{ trans('admin::shopping.securityquestions.index.key_question') }}</th>
                <th>{{ trans('admin::shopping.securityquestions.index.countries') }}</th>
                <th>{{ trans('admin::shopping.securityquestions.index.status') }}</th>
                @if ($can_edit || $can_delete)
                <th>{{ trans('admin::shopping.securityquestions.index.actions') }}</th>
                @endif
            </tr>
        </thead>
        <tbody>
        @foreach ($securityquestions as $sq)
            <tr id="lang_{!! $sq->id !!}">
                <td>{!! $sq->key_question !!}</td>

                <td>@foreach($sq->securityQuestionsCountry as $ocountry)<span class="label label-default" style="margin-right: .25em;">{!! $ocountry->country->name !!}</span>@endforeach</td>
                <td><span id="status{{$sq->id}}"  class="label  {{$sq->active ? 'label-success' : 'label-default'}} ">{!! $sq->active == 0 ?  trans('admin::language.lang_list_st_inactive')  : trans('admin::language.lang_list_st_active')  !!}</span></td>
                @if ($can_edit || $can_delete)
                    <td data-lid="{!! $sq->id !!}">
                    <span onclick="disableSecurityQuestions({{$sq->id}})" id='activeSecurityQuestions{{$sq->id}}' class="{{$sq->active ? 'hide' : ''}}">
                        <i class="glyphicon glyphicon-stop itemTooltip  " title="{{ trans('admin::shopping.securityquestions.index.enable') }}"></i>
                    </span>
                    <span onclick="disableSecurityQuestions({{$sq->id}})" id='inactiveSecurityQuestions{{$sq->id}}' class="{{$sq->active ? '' : 'hide'}}">
                        <i class="glyphicon glyphicon-play itemTooltip " title="{{ trans('admin::shopping.securityquestions.index.disable') }}"></i>
                     </span>
                     <a class="glyphicon glyphicon-pencil itemTooltip" href="{{ route('admin.securityquestions.edit', ['oe_id' => $sq->id]) }}" title="{{ trans('admin::language.lang_list_edit') }}"></a>

                        <span onclick="deleteSecurityQuestions({{$sq->id}})" id='deleteSecurityQuestions{{$sq->id}}'>
                        <i class="glyphicon glyphicon-trash itemTooltip " title="{{ trans('admin::shopping.securityquestions.index.delete') }}"></i>
                     </span>
                        <span onclick="getCountries({{$sq->id}})">
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
                <form action="{{ route('admin.securityquestions.updatecountries') }}" id="countriesSelection" method="post">

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">


                    <div class="modal-header">

                        <p>{{ trans('admin::shopping.banks.index.instructions') }}</p>
                    </div>
                    <div class="modal-body" id="bodyCountries">





                    </div>
                    <div class="modal-footer">

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

    $('#tbl_securityquestions').DataTable({
    "responsive": true,
            "ordering": false,
             "language": { 
                    "url": "{{ trans('admin::datatables.lang') }}"
               }
    });
    function disableSecurityQuestions(security_questions_id) {
        $.ajax({
            url: route('admin.securityquestions.active'),
            type: 'POST',
            data: {security_questions_id: security_questions_id},
            success: function (data) {
                var label = $("#status" + security_questions_id);
                var iconActive = $("#activeSecurityQuestions" + security_questions_id);
                var iconInactive = $("#inactiveSecurityQuestions" + security_questions_id);
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

    function deleteSecurityQuestions(security_questions_id) {
        $.ajax({
            url: route('admin.securityquestions.delete'),
            type: 'POST',
            data: {security_questions_id: security_questions_id},
            success: function (data) {

                if (data.status) {
                    location.reload();
                }
                else {

                }
            }
        });
    }


    function getCountries(security_questions_id){


        $.ajax({
            url: route('admin.securityquestions.countries'),
            type: 'POST',
            data: {security_questions_id: security_questions_id},
            success: function (data) {


                if (data.success) {
                    $("#bodyCountries").empty();
                    $.each(data.message, function(i, item) {
                        console.log(i,item.estatus);
                        var check = parseInt(item.estatus) == 1 ? 'checked' : '';
                        //var estatus = parseInt(item.estatus) == 0 ? 2 : 1;
                        $("#bodyCountries").append('<div class="checkbox"> <label><input name="countries_name['+i+']" type="checkbox" value="'+parseInt(item.estatus)+'" '+check+'>'+item.name+'</label></div>');

                    });

                    $("#bodyCountries").append('<input name="question_identifier" type="hidden" value="'+security_questions_id+'">');
                    $("#countriesModal").modal('show');
                }
                else {

                }
            }
        });


    }


</script>
@stop