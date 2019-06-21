<!DOCTYPE html>
<html lang="en">
       <link rel="icon" href=" <?php echo asset(Session::get('portal.main.brand.favicon')); ?>" rel="image/x-icon" type="image/x-icon">

<head itemscope>
    <?php echo e(csrf_field()); ?>

    <meta charset="utf-8">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <!--<title><?php echo isset($title) ? $title : PageBuilder::block('meta_title', ['meta' => true]); ?></title>-->
    <meta name="description" content="<?php echo PageBuilder::block('meta_description', ['meta' => true]); ?>">
    <meta name="keywords" content="<?php echo PageBuilder::block('meta_keywords', ['meta' => true]); ?>">
    <meta itemprop="name" content="<?php echo PageBuilder::block('meta_title', ['meta' => true]); ?>">
    <meta itemprop="description" content="<?php echo PageBuilder::block('meta_description', ['meta' => true]); ?>">
<!--    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo config('cms.analytics.'.session()->get('portal.main.brand.id'));; ?>"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', '<?php echo config('cms.analytics.'.session()->get('portal.main.brand.id')); ?>');
</script>-->



    <?php if(isset($socialTags) && !empty($socialTags)): ?>
        <!-- Social tags -->
        <?php if(isset($socialTags['facebook'])): ?>
            <meta property="og:title"       content="<?php echo e($socialTags['facebook']['title']); ?>">
            <meta property="og:type"        content="<?php echo e($socialTags['facebook']['type']); ?>">
            <meta property="og:description" content="<?php echo e($socialTags['facebook']['description']); ?>">
            <meta property="og:url"         content="<?php echo e($socialTags['facebook']['url']); ?>">
            <meta property="og:site_name"   content="<?php echo e($socialTags['facebook']['site_name']); ?>">
            <meta property="og:image"       content="<?php echo e($socialTags['facebook']['image']); ?>">
            <meta property="og:image:secure_url" content="<?php echo e($socialTags['facebook']['image']); ?>">
            <meta property="og:image:type" content="image/png">
            <meta property="og:image:width" content="400">
            <meta property="og:image:height" content="400">
        <?php endif; ?>

        <?php if(isset($socialTags['twitter'])): ?>
            <meta name="twitter:card"        content="<?php echo e($socialTags['twitter']['card']); ?>">
            <meta name="twitter:title"       content="<?php echo e($socialTags['twitter']['title']); ?>">
            <meta name="twitter:site"        content="<?php echo e($socialTags['twitter']['site']); ?>">
            <meta name="twitter:creator"     content="<?php echo e($socialTags['twitter']['creator']); ?>">
            <meta name="twitter:url"         content="<?php echo e($socialTags['twitter']['url']); ?>">
            <meta name="twitter:domain"      content="<?php echo e($socialTags['twitter']['domain']); ?>">
            <meta name="twitter:description" content="<?php echo e($socialTags['twitter']['description']); ?>">
            <meta name="twitter:image"       content="<?php echo e($socialTags['twitter']['image']); ?>">
        <?php endif; ?>
    <?php else: ?>
        <?php
            $brandName = config('cms.brand_css.'.session()->get('portal.main.brand.id'));
            $brandName = ($brandName == 'master') ? 'omnilife' : $brandName;
            $metaTitle = PageBuilder::block('meta_title', ['meta' => true]) ?:
                trans('cms::header.metadata.' . $brandName . '.title');
            $metaDescription = PageBuilder::block('meta_description', ['meta' => true]) ?:
                trans('cms::header.metadata.' . $brandName . '.description');
        ?>
        <meta property="og:title" content="<?php echo $metaTitle; ?>">
        <meta property="og:description" content="<?php echo $metaDescription; ?>">
        <meta property="og:url" content="<?php echo e(url()->current()); ?>">
        <meta property="og:site_name" content="<?php echo $metaDescription; ?>">
        <meta property="og:image" content="<?php echo asset('themes/omnilife2018/images/logos/' . $brandName . '.png'); ?>">
        <meta property="og:image:secure_url" content="<?php echo asset('themes/omnilife2018/images/logos/' . $brandName . '.png'); ?>" />
        <meta property="og:image:type" content="image/png" />
        <meta property="og:image:width" content="600">
        <meta property="og:image:height" content="314">
        <meta name="twitter:title" content="<?php echo $metaTitle; ?>">
        <meta name="twitter:description" content="<?php echo $metaDescription; ?>">
        <meta name="twitter:url" content="<?php echo e(url()->current()); ?>">
        <meta name="twitter:image" content="<?php echo asset('themes/omnilife2018/images/logos/' . $brandName . '.png'); ?>">
        <meta name="twitter:site" content="https://twitter.com/omnilife">
        <meta name="twitter:creator" content="Omnilife">
    <?php endif; ?>


    <meta name="revisit-after" content="7 days">
         <link rel="icon" href=" <?php echo asset(Session::get('portal.main.brand.favicon')); ?>" rel="image/x-icon" type="image/x-icon">

    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Barlow+Semi+Condensed:400,500,600" rel="stylesheet">

    <!-- master CSS -->
    <link href="<?php echo asset('/themes/omnilife2018/css/master.css'); ?>" rel="stylesheet">
    <?php if(!empty(config('cms.brand_css.'.session()->get('portal.main.brand.id')))): ?>
        <?php if(config('cms.brand_css.'.session()->get('portal.main.brand.id')) != 'master'): ?>
            <link href="<?php echo PageBuilder::css(config('cms.brand_css.'.session()->get('portal.main.brand.id'))); ?>" rel="stylesheet">
        <?php endif; ?>
    <?php endif; ?>
    <?php if(session()->get('portal.main.app_locale') == 'ru' && session()->get('portal.main.countryCode') == 'RU'): ?>
        <link href="<?php echo asset('/themes/omnilife2018/css/russia.css'); ?>" rel="stylesheet">
    <?php endif; ?>
    <link href="<?php echo asset('/themes/omnilife2018/css/responsive.css'); ?>" rel="stylesheet">
    <link href="<?php echo asset('/cms/jquery/fancybox/jquery.fancybox.css'); ?>" media="all" type="text/css" rel="stylesheet">
    <link href="<?php echo asset('/cms/jquery-ui/jquery-ui.css'); ?>" media="all" type="text/css" rel="stylesheet">

    <link href="<?php echo asset('/themes/omnilife2018/css/survey.css'); ?>" rel="stylesheet">
</head>

<?php
    $brand = 'omnilife';
?>
<body class="<?php echo e(PageBuilder::block('body_theme')); ?>">
    <div id="blank-overlay" style="position: fixed; background: white; z-index: 9999; width: 100%; height: 100%;"></div>
    <div class="overlay"></div>
    <?php echo PageBuilder::section('header'); ?>

    <?php echo PageBuilder::section('search'); ?>

    <?php echo PageBuilder::section('login'); ?>

    <?php if(Request::url() !== url('/shopping/checkout')): ?>)
        <?php echo $__env->make('themes.omnilife2018.sections.cart', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php endif; ?>
    <div class="main-content">
