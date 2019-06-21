<h1>{!! trans('admin::themes.labels.theme_title') !!}- {{ $theme->theme }}</h1>

@if (!empty($themeErrors))

    <div class="table-responsive">
        <table id="themes-table" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>{!! trans('admin::themes.msg.theme_error') !!}.</th>
                </tr>
            </thead>
            <tbody>
            @foreach($themeErrors as $error)
                <tr>
                    <td>
                        {{ $error }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@elseif (isset($saved))

    <p class="text-success">{!! trans('admin::themes.msg.theme_updated') !!}</p>
    <p><a href="{{ route('admin.themes.update', ['themeId' => $theme->id]) }}">&raquo; {!! trans('admin::themes.msg.theme_saved') !!}</a></p>

@else

    <h4>{!! trans('admin::themes.labels.how_use') !!}</h4>
    <ul>
        <li>{!! trans('admin::themes.labels.blocks_updated') !!}</li>
        <li>{!! trans('admin::themes.labels.block_in_content') !!}</li>
        <li>{!! trans('admin::themes.labels.block_general') !!}</li>
        <li>{!! trans('admin::themes.labels.block_with_two_options') !!}</li>
    </ul>
    <div class="row">
        <div class="col-md-4 well-sm">
            <h4>{!! trans('admin::themes.labels.summary') !!}:</h4>
            <p><b>{!! trans('admin::themes.labels.themplates_used') !!}:</b> {{ implode(', ', $importBlocks->getTemplates()) }}</p>
            <p><b>{!! trans('admin::themes.labels.blocks_count') !!}:</b> {{ count($importBlocksList) }}</p>
        </div>
        <div class="col-md-8 well-sm">
            <h4>{!! trans('admin::themes.labels.key') !!}:</h4>
            <ul>
                <li class="well-sm bg-success">{!! trans('admin::themes.labels.new_blocks') !!}</li>
                <li class="well-sm bg-warning">{!! trans('admin::themes.labels.exist_blocks') !!}</li>
                <li class="well-sm bg-danger">{!! trans('admin::themes.labels.delete_blocks') !!}</li>
                <li class="well-sm bg-info">{!! trans('admin::themes.labels.blocks_unknown') !!}</li>
                <li class="well well-sm">{!! trans('admin::themes.labels.blocks_without _changes') !!}</li>
            </ul>
        </div>
    </div>

    {!! Form::open() !!}

    <div class="form-group">
        {!! Form::submit( trans('admin::themes.buttons.update_blocks'), ['class' => 'btn btn-primary']) !!}
    </div>

    <div class="table-responsive">
        <table id="themes-table" class="table table-striped table-bordered">

            <thead>
            <tr>
                <th>{!! Form::checkbox('update_all', 1, false, ['id' => 'update-all']) !!} 
                    <i class="glyphicon glyphicon-info-sign header_note" data-note="{!! trans('admin::themes.labels.template_info') !!}"></i> {!! trans('admin::themes.labels.update_templates') !!}</th>
                <th  class="with-th">{!! trans('admin::themes.labels.name') !!}</th>
                <th class="with-th">{!! trans('admin::themes.labels.label') !!}</th>
                <th class="with-th" >{!! trans('admin::themes.labels.block_category') !!}</th>
                <th class="with-th">{!! trans('admin::themes.labels.type') !!}</th>            
                <th><i class="glyphicon glyphicon-info-sign header_note" data-note="{!! trans('admin::themes.labels.template_show_in_site') !!}">
                    
                    </i>{!! trans('admin::themes.labels.show_in_site_wide') !!}</th>
                <th><i class="glyphicon glyphicon-info-sign header_note" data-note="{!! trans('admin::themes.labels.template_show_in_pages') !!}">
                    
                    </i>{!! trans('admin::themes.labels.show_in_pages') !!}</th>
                <th>{!! trans('admin::themes.labels.order') !!}</th>
            </tr>
            </thead>

            <tbody>
            @php
                ($rowClasses = ['new' => 'success', 'delete' => 'danger', 'update' => 'warning', 'info' => 'info', 'none' => ''])
            @endphp
            @foreach($importBlocksList as $blockName => $listInfo)
                @php
                $importBlock = $importBlocks->getAggregatedBlock($blockName);
                $currentBlock = $importBlocks->getBlock($blockName, 'db');
                $blockString=$importBlocks->getBlockName($blockName, $importBlock->blockData['category_id']);
                @endphp             
                <tr class="{{ $rowClasses[$listInfo['display_class']] }}">
                    <td>{!! ($listInfo['update_templates'] >= 0)?Form::checkbox('block['.$blockName.'][update_templates]', 1, $listInfo['update_templates'], ['class' => 'form-control run-template-updates']):'' !!}</td>
                    <td ><i class="glyphicon glyphicon-info-sign block_note" data-note="{{ $blockName }}_note"></i> 
                        <span style="word-wrap: break-word"> {!! $blockName !!}</span>    
                    </td>
                    <td>{!! Form::text('block['.$blockName.'][blockData][label]',($blockString!="")?$blockString:$importBlock->blockData['label'], ['class' => 'form-control','required' => 'required']) !!}</td>
                    <td>{!! ($listInfo['update_templates'] >= 0)?Form::select('block['.$blockName.'][blockData][category_id]', $categoryList, $importBlock->blockData['category_id'], ['class' => 'form-control']):'' !!}</td>
                    <td>{!! Form::select('block['.$blockName.'][blockData][type]', $typeList, $importBlock->blockData['type'], ['class' => 'form-control']) !!}</td>
                    <td>{!! ($listInfo['update_templates'] >= 0)?Form::checkbox('block['.$blockName.'][globalData][show_in_global]', 1, $importBlock->globalData['show_in_global'], ['class' => 'form-control based-on-template-updates']):'' !!}</td>
                    <td>{!! ($listInfo['update_templates'] >= 0)?Form::checkbox('block['.$blockName.'][globalData][show_in_pages]', 1, $importBlock->globalData['show_in_pages'], ['class' => 'form-control based-on-template-updates']):'' !!}</td>
                    <td >{!! Form::text('block['.$blockName.'][blockData][order]', $importBlock->blockData['order'], ['class' => 'form-control width-td']) !!}</td>
                </tr>
                <tr class="hidden" id="{{ $blockName }}_note">
                    <td colspan="7" style="padding-bottom: 20px">
                        <div class="col-sm-6">
                            <h4>{!! trans('admin::themes.labels.current_block_info') !!}</h4>
                            @if ($listInfo['display_class'] == 'new')
                              {!! trans('admin::themes.labels.block_not_current') !!} <br /><br />
                            @else
                                @if ($globalData = array_filter($currentBlock->globalData))
                                    {!! trans('admin::themes.labels.block_show_in') !!}{{ implode(' and ', array_intersect_key(['show_in_pages' => 'pages', 'show_in_global' => 'site-wide content'], $globalData)) }}.<br /><br />
                                @endif
                                @if ($currentBlock->templates || $currentBlock->inRepeaterBlocks)
                                    @if ($currentBlock->templates)
                                        <b>   {!! trans('admin::themes.labels.in_templates') !!} </b> {!! implode(', ', $currentBlock->templates) !!}<br />
                                    @endif
                                    @if ($currentBlock->inRepeaterBlocks)
                                        <b> {!! trans('admin::themes.labels.in_repiter_blocks') !!}:</b> {!! implode(', ', $currentBlock->inRepeaterBlocks) !!}<br />
                                    @endif
                                    <br />
                                @endif
                            @endif
                            @if ($currentBlock->repeaterChildBlocks)
                                <b>{!! trans('admin::themes.labels.child_block') !!}</b> {!! implode(', ', $currentBlock->repeaterChildBlocks) !!}<br /><br />
                            @endif
                            @if (count($currentBlock->blockData) > 1)
                                @foreach($currentBlock->blockData as $field => $value)
                                    <b>{!! trans('admin::themes.labels.'.$field) !!}</b>: <i>{{ $value }}</i><br />
                                @endforeach
                            @else
                               {!! trans('admin::themes.labels.block_error') !!}
                            @endif
                        </div>
                        <div class="col-sm-6">
                            <h4>{!! trans('admin::themes.labels.updates_found') !!}</h4>
                            @if ($importBlock->inCategoryTemplates || $importBlock->specifiedPageIds)
                                {!! trans('admin::themes.labels.blocks_not_found_in_template') !!}  <br />
                                @if ($importBlock->inCategoryTemplates)
                                    <b> {!! trans('admin::themes.labels.blocks_found_in_category') !!}:</b> {!! implode(', ', $importBlock->inCategoryTemplates) !!}<br />
                                @endif  
                                @if ($importBlock->specifiedPageIds)
                                    <b>{!! trans('admin::themes.labels.use_pages_id') !!}:</b> {!! implode(', ', $importBlock->specifiedPageIds) !!}<br />
                                @endif
                                <br />
                            @endif
                            
                       
                            
                            @if ($updatedGlobalValues = $importBlocks->updatedValues($importBlock, 'globalData'))
                                @foreach($updatedGlobalValues as $field => $changedValues)
                                
                                  
                                    <b>{{ ucwords(str_replace('_', ' ', $field)) }}</b>: <i>{{ $changedValues['old'] }}</i> => <i>{{ $changedValues['new'] }}</i><br />
                                @endforeach
                            @endif
                            @if ($addedToTemplates = $importBlocks->newElements($importBlock, 'templates'))
                                <b>{!! trans('admin::themes.labels.add_to_template') !!}:</b> {!! implode(', ', $addedToTemplates) !!}<br />
                            @endif
                            @if ($removedFromTemplates = $importBlocks->deletedElements($importBlock, 'templates'))
                                <b>{!! trans('admin::themes.labels.remove_from_template') !!}:</b> {!! implode(', ', $removedFromTemplates) !!}<br />
                            @endif
                            @if ($addedRepeaterChildren = $importBlocks->newElements($importBlock, 'repeaterChildBlocks'))
                                <b>{!! trans('admin::themes.labels.repeter_child_add') !!}:</b> {!! implode(', ', $addedRepeaterChildren) !!}<br />
                            @endif
                            @if ($removedRepeaterChildren = $importBlocks->deletedElements($importBlock, 'repeaterChildBlocks'))
                                <b>{!! trans('admin::themes.labels.repeter_child_removed') !!}:</b> {!! implode(', ', $removedRepeaterChildren) !!}<br />
                            @endif
                            @if ($addedToRepeaterTemplates = $importBlocks->newElements($importBlock, 'inRepeaterBlocks'))
                                <b>{!! trans('admin::themes.labels.add_to_repeter_block') !!}</b>: {!! implode(', ', $addedToRepeaterTemplates) !!}<br />
                            @endif
                            @if ($removedFromRepeaterTemplates = $importBlocks->deletedElements($importBlock, 'inRepeaterBlocks'))
                                <b>{!! trans('admin::themes.labels.remove_from_repeter_block') !!}</b>: {!! implode(', ', $removedFromRepeaterTemplates) !!}<br />
                            @endif
                            @if ($listInfo['display_class'] == 'delete')
                                @if ($listInfo['update_templates'] >= 0 || $removedFromTemplates || $removedFromRepeaterTemplates)
                                   {!! trans('admin::themes.labels.update_on_template') !!} {{ implode(' and ', array_keys(array_filter([
                                        'this block' => $currentBlock->templates,
                                        'the repeater blocks above' => $currentBlock->inRepeaterBlocks
                                    ]))) }} {!! trans('admin::themes.labels.remove_from_this_template') !!}<br />
                                @else
                                  {!! trans('admin::themes.labels.block_lost') !!}<br />
                                     {!! trans('admin::themes.labels.block_in_csv') !!}
                                @endif
                            @elseif ($addedToTemplates || $removedFromTemplates || $addedToRepeaterTemplates || $removedFromRepeaterTemplates || $updatedGlobalValues)
                                  {!! trans('admin::themes.labels.changes_will_save') !!} {{ implode(' and ', array_keys(array_filter([
                                    'this block' => $addedToTemplates || $removedFromTemplates  || $updatedGlobalValues,
                                    'the repeater blocks above' => $addedToRepeaterTemplates || $removedFromRepeaterTemplates
                                ]))) }}  {!! trans('admin::themes.labels.changes_are_saved') !!}<br />
                            @endif
                            @if ($addedToTemplates || $removedFromTemplates || $addedRepeaterChildren || $removedRepeaterChildren || $addedToRepeaterTemplates || $removedFromRepeaterTemplates || $updatedGlobalValues)
                                <br />
                            @endif
                            @if ($listInfo['display_class'] != 'delete' && $updatedValues = $importBlocks->updatedValues($importBlock, 'blockData'))
                               {!! trans('admin::themes.labels.data_changes_will_saved') !!}<br />                                                               
                               @foreach($updatedValues as $field => $changedValues)                                                                                          
                                    <b>{!! trans('admin::themes.labels.'.$field) !!}</b>: <i>{{ $changedValues['old'] }}</i> => <i>{{ $changedValues['new'] }}</i><br />
                                @endforeach
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>

        </table>
    </div>

    <div class="form-group">
        {!! Form::submit(trans('admin::themes.buttons.update_blocks'), ['class' => 'btn btn-primary']) !!}
    </div>

    {!! Form::close() !!}

@section('scripts')

    <script type="text/javascript">
        function disable_template_settings() {
            $(this).parent().parent().find('.based-on-template-updates').attr('disabled', !$(this).is(':checked'));
        }
        $(document).ready(function () {
            headerNote();
            $('.block_note').click(function () {
                $('#'+$(this).data('note')).toggleClass('hidden');
            });
            $('.run-template-updates').each(disable_template_settings).click(disable_template_settings);
            $('#update-all').click(function () {
                $('.run-template-updates').prop('checked', $(this).is(':checked')).each(disable_template_settings);
            });
        });
    </script>
@endsection

@endif
