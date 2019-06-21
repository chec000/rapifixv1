<h2>{{trans('admin::userTranslations.form_edit.title_form_edit')}}: {!! $user->email !!}</h2>

<table class="table table-bordered">
    <tbody>
        <tr>
            <td>{!! trans('admin::userTranslations.form_edit.date_created') !!}</td>
            <td>{!! DateTimeHelper::display($user->created_at, 'short') !!}</td>
        </tr>
        <tr>
            <td>{!! trans('admin::userTranslations.form_edit.account_status') !!}</td>
            <td>{!! !empty($user->active)? trans('admin::userTranslations.form_edit.active'): trans('admin::userTranslations.form_edit.disabled')!!}</td>
        </tr>
    </tbody>
</table>

@if (isset($success))

    @if ($success)
        <p class="text-success">
            {!!  trans('admin::userTranslations.form_edit.msg_account_updated', ['email' => Request::input('email')]) !!}<br/>
        </p>
        @if (!empty($email_message))
            <p class="text-{!! $email_status !!}">{!! $email_message !!}</p>
        @endif
    @else
        <p class="text-warning">
            {!! $error_save_bd !!}
        </p>
    @endif

    <p>
        <a href="{{ route('admin.users.index') }}" class="btn btn-default ">{{trans('admin::userTranslations.form_edit.back_user_list')}}</a>
    </p>

@else

    {!! Form::open() !!}
    <!-- user name field -->
    <div class="form-group {!! FormMessage::getErrorClass('name') !!}">
        {!! Form::label('name', trans('admin::userTranslations.form_edit.user_name'), ['class' => 'control-label']) !!}
        {!! Form::text('name',  $user->name , ['class' => 'form-control']) !!}
        <span class="help-block">{!! FormMessage::getErrorMessage('name') !!}</span>
    </div>

    <!-- user position field -->
    <div class="form-group {!! FormMessage::getErrorClass('position') !!}">
        {!! Form::label('position', trans('admin::userTranslations.form_edit.user_position'), ['class' => 'control-label']) !!}
        {!! Form::text('position', $user->position, ['class' => 'form-control']) !!}
        <span class="help-block">{!! FormMessage::getErrorMessage('position') !!}</span>
    </div>

    <!-- user email field -->
    <div class="form-group {!! FormMessage::getErrorClass('email') !!}">
        {!! Form::label('email', trans('admin::userTranslations.form_edit.user_email'), ['class' => 'control-label']) !!}
        {!! Form::text('email', $user->email, ['class' => 'form-control']) !!}
        <span class="help-block">{!! FormMessage::getErrorMessage('email') !!}</span>
    </div>

    <!-- user role field -->
    <div class="form-group {!! FormMessage::getErrorClass('role') !!}">
        {!! Form::label('role', trans('admin::userTranslations.form_edit.user_role'), ['class' => 'control-label']) !!}
        {!! Form::select('role', $roles, $user->role_id, ['class' => 'form-control']) !!}
        <span class="help-block">{!! FormMessage::getErrorMessage('role') !!}</span>
    </div>

    <!-- user language field -->
    <div class="form-group {!! FormMessage::getErrorClass('language') !!}">
        {!! Form::label('language', trans('admin::userTranslations.form_edit.language'), ['class' => 'control-label']) !!}
        {!! Form::select('language', $languages, $user->language_id, ['class' => 'form-control']) !!}
        <span class="help-block">{!! FormMessage::getErrorMessage('language') !!}</span>
    </div>

    <!-- user brands field -->
    <div class="form-group {!! FormMessage::getErrorClass('brands') !!}">
        {!! Form::label('brands', trans('admin::userTranslations.form_edit.brands'), ['class' => 'control-label']) !!}
        {!! Form::select('brands[]',$brands, array_pluck($userBrands, 'brand_id'), array('class' => 'form-control'
            , 'multiple'=>true, 'name' => 'brands[]', 'id' => 'multiselect_brand_id')) !!}

        <span class="help-block">{!! FormMessage::getErrorMessage('brands') !!}</span>
    </div>

    <!-- user countries field -->
    <div class="form-group {!! FormMessage::getErrorClass('countries') !!}">
        {!! Form::label('countries', trans('admin::userTranslations.form_edit.countries'), ['class' => 'control-label']) !!}
        {!! Form::select('countries[]', $countries, array_pluck($userCountries, 'country_id') , array('class' => 'form-control'
            , 'multiple'=>true, 'name' => 'countries[]', 'id' => 'multiselect_country_id')) !!}
        <span class="help-block">{!! FormMessage::getErrorMessage('countries') !!}</span>
    </div>

    <!-- send email -->
    <div class="form-group">
        {!! Form::label('send_email', trans('admin::userTranslations.form_edit.send_email'), ['class' => 'control-label']) !!}
        {!! Form::checkbox('send_email', 1, true, ['class' => 'form-control']) !!}
    </div>

    @if ($can_edit)
        <div class="form-group visible-lg-inline-block">
            <table>
                <tr>
                    <td>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-warning">{{trans('admin::userTranslations.form_add.back_user_list')}}</a> &nbsp;&nbsp;
                    </td>
                    <td>
                    @if ($can_change_pass)
                        <a href="{{ route('admin.users.edit', ['userId' => $user->id, 'action' => 'password']) }}" class="btn btn-info"><i class="fa fa-lock"></i> {!! trans('admin::userTranslations.form_edit.change_pass') !!}</a>&nbsp;&nbsp;
                    @endif
                    </td>
                    <td>
                    @if ($can_edit)
                        <!-- submit button -->
                        <button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> &nbsp; {{trans('admin::userTranslations.form_edit.btn_update')}}</button>
                    @endif
                    </td>
                </tr>
            </table>
        </div>
    @endif

    {!! Form::close() !!}

@section('scripts')

    <script type='text/javascript'>

        function changeUsersBrand (){
            var valBrands = $('#multiselect_brand_id').val();
            var valcountries = $('#multiselect_country_id').val();

            $.ajax({
                url: route('admin.users.selecFiltersBrandsUpdate'),
                dataType: 'json',
                type: 'POST',
                data: {brands: valBrands},
                success: function(r) {
                    //console.log(r);
                    $('#multiselect_country_id')
                        .find('option')
                        .remove()
                        .end();


                    $.each(r, function(key,value) {
                        $('#multiselect_country_id')
                            .append('<option value="'+key+'">'+value+'</option>');
                    });
                    $('#multiselect_country_id').val(valcountries);
                    $('#multiselect_country_id').select2();
                }
            });

            //alert('Brands:'+valBrands+'   Countries:'+valcountries);
        }

        $(document).ready(function () {
            $('#multiselect_brand_id').select2();
            $('#multiselect_country_id').select2();


            $('#multiselect_brand_id').change(function(){
                changeUsersBrand();
            });
        });
    </script>
@append

@endif
