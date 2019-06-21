@foreach ($tabs as $index => $content)

        <div class="tab-pane" id="tab{!! $index !!}">

        <br/><br/>

        {!! $content !!}

        @if ($index >= 0 && ((!empty($page) && !$page->link) || $can_publish))

            @if ($new_page)
                <div class="form-group">
                    <div class="col-sm-10 col-sm-offset-2">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-floppy-o"></i> &nbsp;  {!! trans('admin::pages.add_page') !!}</button>
                    </div>
                </div>
            @elseif (!$publishing)
                <div class="form-group">
                    <div class="col-sm-10 col-sm-offset-2">
                        <button class="btn btn-primary" name="publish" value="publish" type="submit"><i class="fa fa-floppy-o"></i> {!! trans('admin::siteWideContent.buttons.update_page') !!}</button>
                    </div>
                </div>
            @elseif ($publishing)
                <div class="form-group">
                    <div class="col-sm-10 col-sm-offset-2">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-floppy-o"></i> &nbsp;{!! trans('admin::siteWideContent.buttons.save_version') !!}</button>
                        &nbsp;
                        @if ($can_publish)
                            <button class="btn btn-primary" name="publish" type="submit" value="publish"><i class="fa fa-floppy-o"></i>
                                &nbsp; {{ $page->is_live() ? trans('admin::siteWideContent.buttons.save_version_publish') :trans('admin::siteWideContent.buttons.save_version_ready_go') }}</button>
                        @else
                            <button class="btn btn-primary request_publish"><i class="fa fa-paper-plane"></i> &nbsp;
                                {!! trans('admin::siteWideContent.buttons.save_request_publish') !!}</button>
                        @endif
                    </div>
                </div>
            @endif

        @endif

    </div>

@endforeach