<?php echo PageBuilder::section('head'); ?>


    <!-- Main slider home markup-->
    <?php echo PageBuilder::block('main_slider', [
        'view' => PageBuilder::block('main_slider_view'),
        'gradient_theme' => PageBuilder::block('main_slider_gradient_theme')
    ]); ?>

    <!-- end Main slider home markup-->

    <!-- Main content markup-->
    <div class="wrapper full-size-mobile business__main">

        <!-- Title markup-->
        <div class="business__main-title col3-4">
            <div class="business__main-inner">
                <h3 class="products-maintitle">
                    <?php echo e(PageBuilder::block('events_title')); ?>

                    <span><?php echo e(PageBuilder::block('events_title_highligth')); ?></span>
                </h3>
            </div>
        </div>
        <!-- end Title markup-->

        <!-- Container markup-->
        <div class="jobs--container">
            <div class="jobs--description">
                <?php echo PageBuilder::block('events_short_description'); ?>


                <!-- Description markup-->
                <div class="ezone__content ezone__details template-events">
                    <section class="ezone__section">
                        <header class="ezone__header">
                            <div class="ezone__headline bordered">
                                <h1 class="ezone__title small"><?php echo e(PageBuilder::block('events_date')); ?></h1>
                            </div>
                        </header>
                        <div class="ezone__body">
                            <div class="ezone__textcontent template-events">
                                <div class="text">
                                    <?php echo PageBuilder::block('events_description'); ?>

                                </div>
                                <aside class="ezone__banners mul">
                                    <figure class="ezone__banner">
                                        <div style="height: 320px;" id="map"></div>
                                    </figure>
                                    <figure class="ezone__banner large">
                                        <?php echo PageBuilder::block('events_image'); ?>

                                        <figcaption>
                                            <?php if(PageBuilder::block('events_button_message') != ''): ?>
                                                <a class="button" <?php echo PageBuilder::block('events_button_link'); ?>>
                                                    <?php echo PageBuilder::block('events_button_message'); ?>

                                                </a>
                                            <?php endif; ?>
                                        </figcaption>
                                    </figure>
                                </aside>
                            </div>
                        </div>
                    </section>
                </div>
                <!-- end Description markup-->

                <!-- Gallery markup-->
                <div class="ezone__grid-imgs">
                    <header class="ezone__header">
                        <div class="ezone__headline bordered">
                            <h1 class="ezone__title small"><?php echo e(PageBuilder::block('events_gallery_title')); ?></h1>
                        </div>
                    </header>
                    <div class="ezone__body">
                        <?php echo PageBuilder::block('galleries'); ?>

                    </div>
                </div>
                <!-- end Gallery markup-->

            </div>
        </div>
        <!-- end Container markup-->

    </div>
    <!-- end Main content markup-->

<?php echo PageBuilder::section('footer'); ?>


<script type="text/javascript">
    var MAP_COORDS = <?php echo PageBuilder::block('events_map'); ?>;
    var map;
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: MAP_COORDS.lat, lng: MAP_COORDS.long },
            zoom: 14
        });
        var marker = new google.maps.Marker({
            position: { lat: MAP_COORDS.lat, lng: MAP_COORDS.long },
            map: map,
        });
    };
    $('.fancybox').fancybox();
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBBmgIlPaMOTALtAFrpNzOSEpxEJHyoce4&callback=initMap" async defer></script>
