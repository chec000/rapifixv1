<h1> {{trans('admin::distributorsPool.add.new_dist')}}</h1>
<p class="text-right"><a href="{{ route('admin.pool.index') }}">{{trans('admin::brand.form_add.back_list')}}</a></p>

<form id="form-pool" method="POST" action="{{ route('admin.pool.save') }}">
    {{ csrf_field() }}
    <style>.required{color:red;font-weight:bold;}</style>

    <div id="messages">
        @if (session()->exists('success'))
            <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ session()->get('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session()->exists('error'))
            <div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <ul>
                    @foreach (session()->get('error') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- Country -->
    <fieldset class="fieldset_gray">
        <legend class="legend_gray">{{ trans('admin::cedis.general.country') }}</legend>

        <div class="row">
            <div class="col-xs-12">
                <label class="control-label">{{ trans('admin::cedis.add.select_country') }}</label><span class="required">*</span>
                <select name="country" class="form-control" required="required">
                    <option></option>
                    @foreach($countries as $country)
                        <option data-corbiz="{{ $country->corbiz_key }}" {{ old('country') == $country->id ? 'selected' : '' }} value="{{ $country->id }}">{{ $country->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </fieldset>

    <hr class="hr_bold_violet">

    <!-- General information -->
    <fieldset class="fieldset_gray">
        <legend class="legend_gray">{{ trans('admin::cedis.general.general_info') }}</legend>

        <div class="row">
            <!-- Code -->
            <div class="form-group col-xs-12 col-sm-2">
                <label class="control-label">{{ trans('admin::distributorsPool.general.dist_code') }}</label><span class="required">*</span>
                <input type="text" name="code" class="form-control" value="{{ old('code') }}" required="required">
            </div>

            <!-- Name -->
            <div class="form-group col-xs-12 col-sm-5">
                <label class="control-label">{{ trans('admin::distributorsPool.general.dist_name') }}</label><span class="required">*</span>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required="required" maxlength="200">
            </div>

            <!-- Email -->
            <div class="form-group col-xs-12 col-sm-5">
                <label class="control-label">{{ trans('admin::distributorsPool.general.dist_email') }}</label><span class="required">*</span>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required="required" maxlength="200">
            </div>
        </div>
    </fieldset>

    <hr>

    @if (Auth::action('pool.add'))
        <div class="row">
            <div class="col-xs-12">
                <button id="save-cedis" type="submit" class="btn btn-primary pull-right">Save</button>
            </div>
        </div>
    @endif
</form>

@section('scripts')
    <script>
        $(document).ready(function () {
            $('[name=code]').change(function () {
                var code = $(this).val();

                $.ajax({
                    url: '{{ route('admin.pool.validatesponsor') }}',
                    method: 'POST',
                    data: {code: code, country: $('[name=country] option:selected').data('corbiz')},
                    dataType: 'JSON',
                    statusCode: { 419: function() {window.location.href = '{{ route('admin.home') }}'} }
                }).done(function (response, textStatus, jqXHR) {
                    var message = '';
                    $('[name=code]').parent().removeClass('has-success');
                    $('[name=code]').parent().removeClass('has-error');
                    $('.help').remove();
                    $('#messages')

                    if (response.status) {
                        $('[name=name]').val(response.data.name_1);
                        $('[name=email]').val(response.data.email);
                        $('[name=code]').parent().addClass('has-success');
                    } else {
                        $('[name=code]').parent().addClass('has-error');
                        if (response.messages.length > 1) {
                            $.each(response.messages, function (i, msg) {
                                message += (msg.concat((i == response.messages.length -1) ? '' : '<br>')) ;
                            });
                        } else {
                            message = response.messages[0];
                        }

                        $('[name=code]').parent().parent().parent().append('' +
                            '<div class="form-group help col-xs-12 has-error">\n' +
                            '    <span class="help-block">'+message+'</span>\n' +
                            '</div>');
                    }
                }).fail(function (response, textStatus, errorThrown) {
                    console.log(response, textStatus, errorThrown);
                });
            });

            $('#form-pool').submit(function(event) {
                if ($('[name=code]').parent().hasClass('has-error')) {

                    $('#messages').append('' +
                        '<div class="alert alert-danger alert-dismissible">\n' +
                        '    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>\n' +
                        '        <ul>\n' +
                        '            <li>'+'{{ trans('admin::distributorsPool.validation.code_valid') }}'+'</li>' +
                        '        </ul>\n' +
                        '</div>');

                    event.preventDefault();
                } else {
                    return;
                }
            });
        });
    </script>
@endsection