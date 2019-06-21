<div id="listpages" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{!! trans('admin::pages.modal_history_title') !!}</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body form-horizontal">
                <div class="table">
                    <table class="table table-striped dataTable no-footer" id="list_table_pages" role="grid" aria-describedby="statsBlocksTable_info">
                        <thead>
                            <tr role="row">
                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 0px;">{!! trans('admin::pages.brand') !!}</th>
                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 0px;">{!! trans('admin::pages.country') !!}</th>
                                  <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 0px;">{!! trans('admin::pages.language') !!}</th>
                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 0px;">{!! trans('admin::pages.name') !!}</th>
                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 0px;">{!! trans('admin::pages.url') !!}</th>
                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 0px;">{!! trans('admin::pages.status') !!}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($pages))
                            @foreach ($pages as $p)
                            <tr role="row" class="odd">
                                <td>{!!$p->marcas!!}</td>
                                <td>{!!$p->countries!!}</td>
                                <td>{!!$p-> language!!}</td>
                                <td>{!!$p->nombre!!}</td>
                                <td>{!!$p->url!!}</td>
                                <td>

                                    @switch($p->status)
                                    @case(1)
                                    <span class="label type_link">{!! trans('admin::pages.link_document') !!}</span>
                                    @break
                                    @case(2)
                                    <span class="label type_group">{!! trans('admin::pages.group_page') !!}</span>
                                    @break
                                    @case(3)
                                    <span class="label type_hidden">{!! trans('admin::pages.not_live') !!}</span>
                                    @break
                                    @case(4)
                                    <span class="label type_normal_dark">{!! trans('admin::pages.normal_page') !!}</span>
                                    @break
                                    @endswitch
                                </td>
                            </tr>
                            @endforeach
                            @endif


                        </tbody>
                    </table>


                </div>
            </div>
            <div class="modal-footer">
                <button class="btn cancel" data-dismiss="modal"><i class="fa fa-times"></i> &nbsp; {!! trans('admin::pages.close') !!}</button>
            </div>
        </div>
    </div>
</div>
