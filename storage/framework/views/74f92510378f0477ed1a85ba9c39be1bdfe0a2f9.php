<section class="search">
    <div class="wrapper">
        <div class="form-group">
            <input id="global-search" class="form-control form-control--search" type="input" name="search" placeholder="<?php echo app('translator')->getFromJson('cms::search.input_placeholder'); ?>">
            <button class="icon-btn icon-cross close" type="button"></button>
        </div>
        <div id="global-search-container" class="search-results" style="display: none">
            <div id="global-search-loading" style="display: none">
                <div class="loader__inner text-center">
                    <svg class="loader__circular" viewBox="25 25 50 50">
                        <circle class="loader__base" cx="50" cy="50" r="10"></circle>
                        <circle class="loader__path" cx="50" cy="50" r="10"></circle>
                    </svg>
                </div>
            </div>
            <div id="global-search-results" style="display: none">
            </div>
            <div id="global-search-empty" style="display: none">
                <div class="search-result product">
                    <h3 class="product__name"><?php echo app('translator')->getFromJson('cms::search.empty_title'); ?></h3>
                    <div class="product__content">
                        <p class="product__description"><?php echo app('translator')->getFromJson('cms::search.empty_description'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
