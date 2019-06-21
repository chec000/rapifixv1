<h1>{{trans('admin::userTranslations.form_add.title_form_add')}}</h1>

<br/>

@if (isset($success))

    @if ($success)
        <p class="text-success">
            {!!  trans('admin::userTranslations.form_add.msg_account_created', ['email' => Request::input('email')]) !!}<br/>
            {{trans('admin::userTranslations.form_add.account_password')}} {!! $password !!}<br/>
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
        <a href="{{ route('admin.users.add') }}">{{trans('admin::userTranslations.form_add.add_another_user')}}</a><br />
        <a href="{{ route('admin.users.index') }}">{{trans('admin::userTranslations.form_add.back_user_list')}}</a>
    </p>

@else

    {!! Form::open() !!}
        <!-- user name field -->
        <div class="form-group {!! FormMessage::getErrorClass('name') !!}">
            {!! Form::label('name', trans('admin::userTranslations.form_add.user_name'), ['class' => 'control-label']) !!}
            {!! Form::text('name', Request::input('name'), ['class' => 'form-control']) !!}
            <span class="help-block">{!! FormMessage::getErrorMessage('name') !!}</span>
        </div>

        <!-- user position field -->
        <div class="form-group {!! FormMessage::getErrorClass('position') !!}">
            {!! Form::label('position', trans('admin::userTranslations.form_add.user_position'), ['class' => 'control-label']) !!}
            {!! Form::text('position', Request::input('position'), ['class' => 'form-control']) !!}
            <span class="help-block">{!! FormMessage::getErrorMessage('position') !!}</span>
        </div>

        <!-- user email field -->
        <div class="form-group {!! FormMessage::getErrorClass('email') !!}">
            {!! Form::label('email', trans('admin::userTranslations.form_add.user_email'), ['class' => 'control-label']) !!}
            {!! Form::text('email', Request::input('email'), ['class' => 'form-control']) !!}
            <span class="help-block">{!! FormMessage::getErrorMessage('email') !!}</span>
        </div>

        <!-- user role field -->
        <div class="form-group {!! FormMessage::getErrorClass('role') !!}">
            {!! Form::label('role', trans('admin::userTranslations.form_add.user_role'), ['class' => 'control-label']) !!}
            {!! Form::select('role', $roles, Request::input('role'), ['class' => 'form-control']) !!}
            <span class="help-block">{!! FormMessage::getErrorMessage('role') !!}</span>
        </div>

        <!-- user language field -->
        <div class="form-group {!! FormMessage::getErrorClass('language') !!}">
            {!! Form::label('language', trans('admin::userTranslations.form_add.language'), ['class' => 'control-label']) !!}
            {!! Form::select('language', $languages, Request::input('language'), ['class' => 'form-control']) !!}
            <span class="help-block">{!! FormMessage::getErrorMessage('language') !!}</span>
        </div>

        <!-- user brands field -->
        <div class="form-group {!! FormMessage::getErrorClass('brands') !!}">
            {!! Form::label('brands', trans('admin::userTranslations.form_add.brands'), ['class' => 'control-label']) !!}
            {!! Form::select('brands[]',$brands, Request::input('brands'),array('class' => 'form-control'
                , 'multiple'=>true, 'name' => 'brands[]', 'id' => 'multiselect_brand_id')) !!}
            <span class="help-block">{!! FormMessage::getErrorMessage('brands') !!}</span>
        </div>

        <!-- user countries field -->

        <div class="form-group {!! FormMessage::getErrorClass('countries') !!}">
            {!! Form::label('countries', trans('admin::userTranslations.form_add.countries'), ['class' => 'control-label']) !!}
            {!! Form::select('countries[]', $countries, Request::input('countries'),array('class' => 'form-control'
                , 'multiple'=>true, 'name' => 'countries[]', 'id' => 'multiselect_country_id')) !!}
            <span class="help-block">{!! FormMessage::getErrorMessage('countries') !!}</span>
        </div>

        <!-- password field -->
        <div class="form-group {!! FormMessage::getErrorClass('password') !!}">
            {!! Form::label('password', trans('admin::userTranslations.form_add.int_password'), ['class' => 'control-label']) !!}
            {!! Form::password('password', ['class' => 'form-control']) !!}
            <span class="help-block">{!! FormMessage::getErrorMessage('password') !!}</span>
        </div>

        <!-- confirm password field -->
        <div class="form-group {!! FormMessage::getErrorClass('password_confirmation') !!}">
            {!! Form::label('password_confirmation', trans('admin::userTranslations.form_add.confirm_int_password'), ['class' => 'control-label']) !!}
            {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
            <span class="help-block">{!! FormMessage::getErrorMessage('password_confirmation') !!}</span>
        </div>

        <!-- send email -->
        <div class="form-group">
            {!! Form::label('send_email', trans('admin::userTranslations.form_add.send_email'), ['class' => 'control-label']) !!}
            {!! Form::checkbox('send_email', 1, true, ['class' => 'form-control']) !!}
        </div>

        <!-- submit button -->
    @if ($can_add == true)
        <button type="submit" class="btn btn-primary addButton"><i class="fa fa-plus"></i> &nbsp; {{trans('admin::userTranslations.form_add.add_user')}}</button>
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