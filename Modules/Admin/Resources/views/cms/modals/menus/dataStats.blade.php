<div id="statsMenusModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>{!! trans('admin::menusCMS.records_history_menus') !!}</h3>
            </div>
            <div class="modal-body form-horizontal">
                <div class="table">
                    <table class="table table-striped" id="statsMenusTable">
                        <thead>
                        <tr>
                            <th>{!! trans('admin::pages.brand') !!}</th>
                            <th>{!! trans('admin::pages.country') !!}</th>
                            <th>{!! trans('admin::pages.language') !!}</th>
                            <th>{!! trans('admin::menusCMS.main_menu') !!}</th>
                            <th>{!! trans('admin::menusCMS.footer') !!}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($dataStatsMenus))
                            @foreach($dataStatsMenus as $statsMenu)
                                    <tr>
                                        <td>{!! $statsMenu->brand !!}</td>
                                        <td>{!! $statsMenu->country !!}</td>
                                        <td>{!! $statsMenu->language !!}</td>
                                        <td> {!! trans('admin::pages.pages') !!}: &nbsp;{!! $statsMenu->main_menu->total !!}</td>
                                        <td> {!! trans('admin::pages.pages') !!}: &nbsp;{!! $statsMenu->footer->total !!}</td>
                                    </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>

                </div>
            </div>
            <div class="modal-footer">
                <button class="btn cancel" data-dismiss="modal"><i class="fa fa-times"></i> &nbsp; {!! trans('admin::menusCMS.buttons.close') !!}</button>
            </div>
        </div>
    </div>
</div>