<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="format-detection" content="telephone=yes">

    <!-- Custom fonts for this template
   <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
   <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
   -->
    <!-- Plugin CSS -->
    <!-- Custom fonts for this template -->
    <link href="<?php echo e(asset('cms/inicio/css/bootstrap.min.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(asset('cms/inicio/css/font-awesome.min.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(asset('cms/inicio/css/icon-font.min.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(asset('cms/inicio/css/plugins.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(asset('cms/inicio/css/plugins.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(asset('cms/inicio/css/main.css')); ?>" rel="stylesheet" type="text/css">



    <script>
        const URL_PROJECT = "<?php echo e(url('/')); ?>";
    </script>

</head>

<body>
<div id="page">
    <div class="container">
        <div class="outer-row row">
            <div class="col-md-12">
                <!--===================================
                =            Header            		   =
                =====================================-->
                <?php echo PageBuilder::section('header',['categories'=>$categories,'cart'=>$cart]); ?>


