<style>
    .loader {
        border: 8px solid #C8C8C8; /* Light grey */
        border-top: 8px solid #3b2453; /* Blue */
        border-radius: 50%;
        width: 60px;
        height: 60px;
        animation: spin 1s linear infinite;
        position: absolute;
        left: 0;
        right: 0;
        z-index: 1500;
        margin: auto;
        top: 0;
        bottom: 0;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<div class="row textbox">
    <div class="col-sm-6">
        <h1>{{ trans('admin::distributorsPool.general.dist_pool') }}</h1>
        <a href="{{ asset('files/pool.csv') }}">{{ trans('admin::distributorsPool.csv.download_base_file') }}</a>
    </div>
        <div class="col-sm-6 text-right">
            @if (Auth::action('pool.uploadfile'))
                <a href="#" class="btn btn-success addButton" data-toggle="modal" data-target="#csv-modal"><i class="fa fa-upload"></i> &nbsp;
                    {{ trans('admin::distributorsPool.general.load_csv') }}
                </a>
            @endif
            @if (Auth::action('pool.add'))
                <a href="{{ route('admin.pool.add') }}" class="btn btn-warning addButton"><i class="fa fa-plus"></i> &nbsp;
                    {{ trans('admin::distributorsPool.general.add_dist') }}
                </a>
            @endif
        </div>
</div>

<div class="table">
    @if (session()->exists('success'))
        <div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ session()->get('success') }}
        </div>
    @endif

    <table class="table table-striped" id="tbl_pool">
        <thead>
            <tr>
                <th>{{ trans('admin::distributorsPool.general.dist_code') }}</th>
                <th>{{ trans('admin::distributorsPool.general.dist_name') }}</th>
                <th>{{ trans('admin::distributorsPool.general.dist_email') }}</th>
                <th>{{ trans('admin::distributorsPool.general.country') }}</th>
                <th>{{ trans('admin::distributorsPool.general.dist_used') }}</th>
                @if (Auth::action('pool.edit') || Auth::action('pool.delete'))
                    <th>{{ trans('admin::cedis.general.actions') }}</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($pool as $distributor)
                <tr>
                    <td>{{ $distributor->distributor_code }}</td>
                    <td>{{ $distributor->distributor_name }}</td>
                    <td>{{ $distributor->distributor_email }}</td>
                    <td>{{ $distributor->country->name }}</td>
                    <td><span class="label {{$distributor->used == 0 ? 'label-success' : 'label-default'}} ">{{ $distributor->used == 0 ?  trans('admin::distributorsPool.general.no')  : trans('admin::distributorsPool.general.yes')  }}</span></td>
                    @if (Auth::action('pool.edit') || Auth::action('pool.delete'))
                        <td>
                        @if (Auth::action('pool.edit'))
                            <a class="glyphicon glyphicon-pencil itemTooltip" href="{{ route('admin.pool.edit', [$distributor->distributor_code, $distributor->country_id]) }}" title="{{ trans('admin::distributorsPool.general.edit_dist') }}"></a>
                        @endif
                        @if (Auth::action('pool.delete'))
                            <form id="delete-pool-form-{{ $distributor->distributor_code }}" action="{{ route('admin.pool.delete', [$distributor->distributor_code, $distributor->country_id]) }}", method="POST" style="display: inline">
                                {{ csrf_field() }}
                                <a onclick="deleteElement(this)" data-code="{{ $distributor->distributor_code }}" id="delete-{{ $distributor->distributor_code }}" class="glyphicon glyphicon-remove itemTooltip" href="#" title="{{ trans('admin::distributorsPool.general.delete_dist') }}"></a>
                            </form>
                        @endif
                    </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
    <div id="loader" class="loader" style="display: none;"></div>
</div>

@section('scripts')
    <script>
        function getErrorsBlock(errors) {
            var errorList = '';
            $.each(errors, function (i, error) {
                errorList += '<li>'+error+'</li>';
            });

            return errorsBlock = '\
                <div class="alert alert-danger alert-dismissible">\
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>\
                        <ul>\
                        '+errorList+'\
                        </ul>\
                </div>';
        }

        function getResponseBlock(data) {
            var responseList = '';
            $.each(data, function (i, element) {
                var label = 'Success';
                if (element.class == 'danger') {
                    label = 'Error';
                }

                responseList += '<p class="message-label"><span class="label label-'+element.class+'">'+label+'</span>Line: '+element.line+', '+element.message+'</p>';
            });

            return responseList;
        }

        function deleteElement(element) {
            var code = $(element).data('code');

            $('#confirm-modal').modal({
                backdrop: 'static',
                keyboard: false
            }).one('click', '#delete', function(e) {
                $('#delete-pool-form-'+code).submit();
            });
        }
       $('#tbl_pool').DataTable({
                "responsive": true,
                "ordering": false,
                 "language": { 
                    "url": "{{ trans('admin::datatables.lang') }}"
               }
            });
        $(document).ready(function () {
     
            $('input[type=file]').change(function() {
                var ext = $('#file_csv').val().split('.').pop().toLowerCase();
                if ($.inArray(ext, ['csv']) == -1) {
                    var errors = [
                            '{{ trans('admin::distributorsPool.validation.file_type') }}'
                    ]

                    $('#modal-messages').html(getErrorsBlock(errors));
                    $('#upload-file').prop('disabled', true);
                    $('#file_csv').val('');
                } else {
                    $('#upload-file').prop('disabled', false);
                }
            });

            $('#csv-modal').modal({
                backdrop: 'static',
                keyboard: false,
                show: false
            });
            $('#csv-modal').on('hidden.bs.modal', function () {
                $('#upload-file').prop('disabled', false);
                $('#close-modal').prop('disabled', false);
                $('#modal-messages').html('');
                $('#country').val('');
                $('#file_csv').val('');
                location.reload();
            });

            $('#upload-file').click(function () {
                var data = new FormData($('#csv_form')[0]);

                $.ajax({
                    url: '{{ route('admin.pool.uploadfile') }}',
                    type: 'POST',
                    data: data,
                    cache: false,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    statusCode: { 419: function() {window.location.href = '{{ route('admin.home') }}'} },
                    beforeSend: function () {
                        $('#loader').show();
                        $('#upload-file').prop('disabled', true);
                        $('#close-modal').prop('disabled', true);
                    },
                    complete: function () {
                        $('#loader').hide();
                        $('#close-modal').prop('disabled', false);
                    }
                }).done(function (response, textStatus, jqXHR) {
                    if (response.status) {
                        if (response.data.length) {
                            $('#modal-messages').html(getResponseBlock(response.data));
                        }
                    } else {
                        if (response.errors && response.errors.length > 0) {
                            $('#modal-messages').html(getErrorsBlock(response.errors));
                            $('#upload-file').prop('disabled', false);
                        }
                    }
                }).fail(function (response, textStatus, errorThrown) {
                    console.log(response, textStatus, errorThrown);
                });
            });
        });
    </script>
@stop