<div class="form-group">
    <div class="row">
        {!! Form::label($name, $label, ['class' => 'control-label col-sm-2']) !!}
        <div class="col-sm-10">
            <div class="row">
                <div class="col-sm-3">{{ trans('admin::blocks.gallery.num_pictures') }}: <b>{!! count($content) !!}</b></div>
                <div class="col-sm-9"> <a href="{{ route('admin.gallery.edit', ['pageId' => $_block->getPageId(), 'blockId' => $_block->id]) }}" class="btn btn-default">{{ trans('admin::blocks.gallery.edit_button') }}</a></div>
            </div>
        </div>
    </div>
</div>
