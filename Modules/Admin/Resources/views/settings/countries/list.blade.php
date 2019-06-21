<div class="row textbox">
    <div class="col-sm-6">
        <h1>{{ trans('admin::countries.list_title') }}</h1>
    </div>
    <div class="col-sm-6 text-right">
        @if ($can_add == true)
            <a href="{{ route('admin.countries.add') }}" class="btn btn-warning addButton"><i class="fa fa-plus"></i> &nbsp;
                {{ trans('admin::countries.list_add') }}</a>
        @endif
    </div>
</div>
<div class="table-responsive">
    @if (isset($success))
        <div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ $action == 'edit' ? trans('admin::countries.lang_edit_success', array('lang' => $lang)) : trans('admin::language.lang_add_success', array('lang' => $lang)) }}
        </div>
    @endif
    <table class="table table-striped" id="tb_country">
        <thead>
        <tr>
            <th>{{ trans('admin::countries.corbiz_key') }}</th>
            <th>{{ trans('admin::countries.list_name') }}</th>
            <th>{{ trans('admin::countries.list_lang') }}</th>
            <!--<th>{{ trans('admin::countries.maintenance') }}</th>-->
            <th>{{ trans('admin::countries.list_active') }}</th>
            @if ($can_edit || $can_delete)
                <th>{{ trans('admin::countries.list_actions') }}</th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach ($countries as $country)
            <tr id="country_{!! $country->id !!}">
                <td>{!! $country->corbiz_key !!}</td>
                <td>{!! $country->name !!}</td>
                <td>
                    @foreach($country->languages as $lang)
                        <span class="label label-default">   {!! $lang->language->language !!}</span>
                    @endforeach</td>
                <!--<td>-->
<!--                    <span style="margin-right: 4px;" class="label label-{{ ($country->shopping_active == 1) ? 'success' : 'danger' }}"><span class="glyphicon glyphicon-{{ ($country->shopping_active == 1) ? 'ok' : 'remove' }}"><span class="label label-{{ ($country->inscription_active == 1) ? 'success' : 'danger' }}" ></span> </span> <span>{{ trans('admin::countries.list_shopping') }}</span>  </span>
                    <span  style="margin-right: 4px;"  class="label label-{{ ($country->inscription_active == 1) ? 'success' : 'danger' }}"><span class="glyphicon glyphicon-{{ ($country->inscription_active == 1) ? 'ok' : 'remove' }}"><span class="label label-{{ ($country->inscription_active == 1) ? 'success' : 'danger' }}" ></span> </span><span style="margin-left: 4px;">{{ trans('admin::countries.list_inscription') }}</span> </span>
                    <span  style="margin-right: 4px;" class="label label-{{ ($country->customer_active == 1) ? 'success' : 'danger' }}"><span class="glyphicon glyphicon-{{ ($country->customer_active == 1) ? 'ok' : 'remove' }}"><span class="label label-{{ ($country->inscription_active == 1) ? 'success' : 'danger' }}" ></span></span><span style="margin-left: 4px;">{{  trans('admin::countries.add_admirable_customer')  }}</span> </span>-->
                <!--</td>-->
                <td>
                    <span class="label label-success cActive" style="display:{{ ($country->active == 1) ? '' : 'none' }}">{{ trans('admin::countries.list_st_active') }}</span>
                    <span class="label label-default cInactive" style="display:{{ ($country->active == 0) ? '' : 'none' }}">{{ trans('admin::countries.list_st_inactive') }}</span>
                </td>
                @if ($can_edit || $can_delete || $can_remove)
                    <td data-cid="{!! $country->id !!}">
                        @if ($can_edit)
                            <?php $enable = ($country->active == 0) ? null : ' hide'; ?>
                            <?php $disable = ($country->active == 0) ? ' hide' : null; ?>
                            <i onclick="inactivate({!! $country->id !!})" class="glyphicon glyphicon-stop itemTooltip{!! $enable !!}" title="{{ trans('admin::countries.list_enable') }}"></i>
                            <i onclick="activate({!! $country->id !!})" class="glyphicon glyphicon-play itemTooltip{!! $disable !!}" title="{{ trans('admin::countries.list_disable') }}"></i>
                            <a class="glyphicon glyphicon-pencil itemTooltip" href="{{ route('admin.countries.edit', ['countryId' => $country->id]) }}" title="{{ trans('admin::countries.list_edit') }}"></a>
                                @if ($can_remove)
                                    <form id="delete-country-form-{{ $country->id }}" action="{{ route('admin.countries.delete', $country->id) }}", method="POST" style="display: inline">
                                        {{ csrf_field() }}
                                        <a onclick="deleteElement(this)" data-code="{{ $country->id }}" data-element="{{ $country->name }}" id="delete-{{ $country->id }}" class="glyphicon glyphicon-trash itemTooltip" href="#" title="{{ trans('admin::countries.delete_country') }}"></a>
                                    </form>
                                @endif
                        @endif
                    </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

@section('scripts')
    <script type="text/javascript">

        $('#tb_country').DataTable({
            "responsive": true,
            "ordering": false,
              "language": { 
                    "url": "{{ trans('admin::datatables.lang') }}"
               }  
        });

        function deleteElement(element) {
            var code = $(element).data('code');
            var name = $(element).data('element');

            $('#confirm-modal .modal-body').text('{{trans('admin::shopping.products.index.confirm')}} ' + name + '?');

            $('#confirm-modal').modal({
                backdrop: 'static',
                keyboard: false
            }).one('click', '#delete', function(e) {
                $('#delete-country-form-'+code).submit();
            });
        }

        function disable_country(country_id) {
            $.ajax({
                url: route('admin.countries.active'),
                type: 'POST',
                data: {countryId: country_id},
                success: function (r) {
                    if (r.status === 0) {
                        $("#country_" + country_id + " .glyphicon-play").addClass('hide');
                        $("#country_" + country_id + " .glyphicon-stop").removeClass('hide');
                        $("#country_" + country_id + " .cActive").hide();
                        $("#country_" + country_id + " .cInactive").show();

                    }
                    else {
                        $("#country_" + country_id + " .glyphicon-stop").addClass('hide');
                        $("#country_" + country_id + " .glyphicon-play").removeClass('hide');
                        $("#country_" + country_id + " .cActive").show();
                        $("#country_" + country_id + " .cInactive").hide();

                    }
                }

            });
        }

        function activate(id) {
            disable_country(id,0);
        }

        function inactivate(id) {
            disable_country(id,1);
        }
    </script>
    @stop
    </div>
    </div>



