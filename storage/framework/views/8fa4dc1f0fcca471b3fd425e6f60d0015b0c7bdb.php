<h4><?php echo e(trans('admin::pages.live_options.header')); ?></h4>

<?php echo CmsBlockInput::make('select', ['name' => 'page_info[live]',
    'label' => ($page->link) ? trans('admin::pages.live_options.link_visible') : trans('admin::pages.live_options.is_live'),
    'content' => $page->live, 'selectOptions' => $liveOptions, 'disabled' => $disabled]); ?>

<div class="live-date-options">
    <?php echo CmsBlockInput::make('datetime', ['name' => 'page_info[live_start]', 'label' => trans('admin::pages.live_options.from_date'),
        'content' => \Modules\CMS\Helpers\DateTimeHelper::mysqlToJQuery($page->live_start), 'disabled' => $disabled]); ?>

    <?php echo CmsBlockInput::make('datetime', ['name' => 'page_info[live_end]', 'label' => trans('admin::pages.live_options.until_date'),
        'content' => \Modules\CMS\Helpers\DateTimeHelper::mysqlToJQuery($page->live_end), 'disabled' => $disabled]); ?>

</div>
<?php echo CmsBlockInput::make('select', ['name' => 'page_info[sitemap]', 'label' => trans('admin::pages.live_options.sitemap'),
    'content' => $page->sitemap, 'selectOptions' => $sitemapOptions, 'disabled' => $disabled]); ?>

