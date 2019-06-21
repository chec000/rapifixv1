<style>.required{color:red;font-weight:bold;}.message-label{margin-bottom: 2px;}.message-label span {height: 60px;}</style>
<div id="csv-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ trans('admin::shopping.products.updateproduct.label.load_csv') }}</h4>
            </div>

            <div class="modal-body">
                <form id="csv_form" method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label class="control-label">{{ trans('admin::cedis.add.select_country') }}</label><span class="required">*</span>
                        <select id="country" name="country" class="form-control input-sm" required="required">
                            <option></option>
                            @foreach($countries as $country)
                                <option {{ old('country') == $country->id ? 'selected' : '' }} value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <input type="file" id="file_csv" name="file_csv">
                        <p class="help-block">{{ trans('admin::distributorsPool.csv.file_ext') }}</p>
                    </div>

                    <div class="form-group">
                        <p class="help-block">{{ trans('admin::distributorsPool.csv.instructions') }}</p>
                        <ol>
                            <li>{{ trans('admin::shopping.products.updateproduct.label.inst_01') }}:
                                <a href="{{ asset('files/productos.csv') }}">{{ trans('admin::shopping.products.updateproduct.label.file_demo') }}</a>
                            </li>
                            <li>{{ trans('admin::shopping.products.updateproduct.label.inst_02') }}</li>
                            <li>{{ trans('admin::shopping.products.updateproduct.label.inst_03') }}</li>
                        </ol>
                    </div>
                </form>

                <div id="modal-messages"></div>
            </div>

            <div class="modal-footer">
                <button id="close-modal" type="button" class="btn btn-default" data-dismiss="modal">{{ trans('admin::distributorsPool.general.close') }}</button>
                <button id="upload-file" type="button" class="btn btn-primary">{{ trans('admin::distributorsPool.csv.upload') }}</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->