<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="format-detection" content="telephone=yes">
        <link rel="icon" href="<?php echo e(asset(isset($brand['favicon']) ? $brand['favicon'] : '/favicon.ico')); ?>" type="image/x-icon">
       
        <title> <?php echo app('translator')->getFromJson('cms::country.title_'.config('cms.brand_css.'.session()->get('portal.main.brand.id'))); ?></title>
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Barlow+Semi+Condensed:400,500,600" rel="stylesheet">
        <link href="<?php echo e(asset('themes/omnilife2018/css/'.config('cms.brand_css.'.session()->get('portal.main.brand.id')).'.css')); ?>" rel="stylesheet">       
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
        <meta property="og:image:secure_url" content="<?php echo asset('themes/omnilife2018/images/logos/' . $brandName . '.png'); ?>">
        <meta property="og:image:type" content="image/png">
        <meta property="og:image:width" content="600">
        <meta property="og:image:height" content="314">
        <meta name="twitter:card" content="summary">
        <meta name="twitter:title" content="<?php echo $metaTitle; ?>">
        <meta name="twitter:description" content="<?php echo $metaDescription; ?>">
        <meta name="twitter:url" content="<?php echo e(url()->current()); ?>">
        <meta name="twitter:site" content="https://twitter.com/omnilife">
        <meta name="twitter:creator" content="Omnilife">
        <meta name="twitter:image" content="<?php echo asset('themes/omnilife2018/images/logos/' . $brandName . '.png'); ?>">   
    
     <!-- Custom fonts for this template -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
    <!-- Plugin CSS -->
    <!-- Custom fonts for this template -->
        <link href="<?php echo e(asset('cms/inicio/vendor/bootstrap/css/bootstrap.min.css')); ?>" rel="stylesheet" type="text/css">
          <link href="<?php echo e(asset('cms/inicio/vendor/fontawesome-free/css/all.min.css')); ?>" rel="stylesheet" type="text/css">
          <link href="<?php echo e(asset('cms/inicio/vendor/magnific-popup/magnific-popup.css')); ?>" rel="stylesheet" type="text/css">
           <link href="<?php echo e(asset('cms/inicio/css/creative.min.css')); ?>" rel="stylesheet" type="text/css">

    </head>
      <body id="page-top">

    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="#page-top">Start Bootstrap</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#services">Services</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#portfolio">Portfolio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#contact">Contact</a>
            </li>
                        <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#about">Acerca de</a>
            </li>
              <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="/">Home</a>
            </li>
                        <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="<?php echo e(route('admin.login')); ?>">Iniciar sesión</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <header class="masthead text-center text-white d-flex">
      <div class="container my-auto">
        <div class="row">
          <div class="col-lg-10 mx-auto">
            <h1 class="text-uppercase">
              <strong>Your Favorite Source of Free Bootstrap Themes</strong>
            </h1>
            <hr>
          </div>
          <div class="col-lg-8 mx-auto">
            <p class="text-faded mb-5">Start Bootstrap can help you build better websites using the Bootstrap CSS framework! Just download your template and start going, no strings attached!</p>
            <a class="btn btn-primary btn-xl js-scroll-trigger" href="#about">Find Out More</a>
          </div>
        </div>
      </div>
    </header>

    <section class="bg-primary" id="about">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto text-center">
            <h2 class="section-heading text-white">We've got what you need!</h2>
            <hr class="light my-4">
            <p class="text-faded mb-4">Start Bootstrap has everything you need to get your new website up and running in no time! All of the templates and themes on Start Bootstrap are open source, free to download, and easy to use. No strings attached!</p>
            <a class="btn btn-light btn-xl js-scroll-trigger" href="#services">Get Started!</a>
          </div>
        </div>
      </div>
    </section>

    <section id="services">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 text-center">
            <h2 class="section-heading">At Your Service</h2>
            <hr class="my-4">
          </div>
        </div>
      </div>
      <div class="container">
        <div class="row">
          <div class="col-lg-3 col-md-6 text-center">
            <div class="service-box mt-5 mx-auto">
              <i class="fas fa-4x fa-gem text-primary mb-3 sr-icon-1"></i>
              <h3 class="mb-3">Sturdy Templates</h3>
              <p class="text-muted mb-0">Our templates are updated regularly so they don't break.</p>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 text-center">
            <div class="service-box mt-5 mx-auto">
              <i class="fas fa-4x fa-paper-plane text-primary mb-3 sr-icon-2"></i>
              <h3 class="mb-3">Ready to Ship</h3>
              <p class="text-muted mb-0">You can use this theme as is, or you can make changes!</p>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 text-center">
            <div class="service-box mt-5 mx-auto">
              <i class="fas fa-4x fa-code text-primary mb-3 sr-icon-3"></i>
              <h3 class="mb-3">Up to Date</h3>
              <p class="text-muted mb-0">We update dependencies to keep things fresh.</p>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 text-center">
            <div class="service-box mt-5 mx-auto">
              <i class="fas fa-4x fa-heart text-primary mb-3 sr-icon-4"></i>
              <h3 class="mb-3">Made with Love</h3>
              <p class="text-muted mb-0">You have to make your websites with love these days!</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="p-0" id="portfolio">
      <div class="container-fluid p-0">
        <div class="row no-gutters popup-gallery">
          <div class="col-lg-4 col-sm-6">
            <a class="portfolio-box" href="img/portfolio/fullsize/1.jpg">
              <img class="img-fluid" src="img/portfolio/thumbnails/1.jpg" alt="">
              <div class="portfolio-box-caption">
                <div class="portfolio-box-caption-content">
                  <div class="project-category text-faded">
                    Category
                  </div>
                  <div class="project-name">
                    Project Name
                  </div>
                </div>
              </div>
            </a>
          </div>
          <div class="col-lg-4 col-sm-6">
            <a class="portfolio-box" href="img/portfolio/fullsize/2.jpg">
              <img class="img-fluid" src="img/portfolio/thumbnails/2.jpg" alt="">
              <div class="portfolio-box-caption">
                <div class="portfolio-box-caption-content">
                  <div class="project-category text-faded">
                    Category
                  </div>
                  <div class="project-name">
                    Project Name
                  </div>
                </div>
              </div>
            </a>
          </div>
          <div class="col-lg-4 col-sm-6">
            <a class="portfolio-box" href="img/portfolio/fullsize/3.jpg">
              <img class="img-fluid" src="img/portfolio/thumbnails/3.jpg" alt="">
              <div class="portfolio-box-caption">
                <div class="portfolio-box-caption-content">
                  <div class="project-category text-faded">
                    Category
                  </div>
                  <div class="project-name">
                    Project Name
                  </div>
                </div>
              </div>
            </a>
          </div>
          <div class="col-lg-4 col-sm-6">
            <a class="portfolio-box" href="img/portfolio/fullsize/4.jpg">
              <img class="img-fluid" src="img/portfolio/thumbnails/4.jpg" alt="">
              <div class="portfolio-box-caption">
                <div class="portfolio-box-caption-content">
                  <div class="project-category text-faded">
                    Category
                  </div>
                  <div class="project-name">
                    Project Name
                  </div>
                </div>
              </div>
            </a>
          </div>
          <div class="col-lg-4 col-sm-6">
            <a class="portfolio-box" href="img/portfolio/fullsize/5.jpg">
              <img class="img-fluid" src="img/portfolio/thumbnails/5.jpg" alt="">
              <div class="portfolio-box-caption">
                <div class="portfolio-box-caption-content">
                  <div class="project-category text-faded">
                    Category
                  </div>
                  <div class="project-name">
                    Project Name
                  </div>
                </div>
              </div>
            </a>
          </div>
          <div class="col-lg-4 col-sm-6">
            <a class="portfolio-box" href="img/portfolio/fullsize/6.jpg">
              <img class="img-fluid" src="img/portfolio/thumbnails/6.jpg" alt="">
              <div class="portfolio-box-caption">
                <div class="portfolio-box-caption-content">
                  <div class="project-category text-faded">
                    Category
                  </div>
                  <div class="project-name">
                    Project Name
                  </div>
                </div>
              </div>
            </a>
          </div>
        </div>
      </div>
    </section>

    <section class="bg-dark text-white">
      <div class="container text-center">
        <h2 class="mb-4">Free Download at Start Bootstrap!</h2>
        <a class="btn btn-light btn-xl sr-button" href="http://startbootstrap.com/template-overviews/creative/">Download Now!</a>
      </div>
    </section>

    <section id="contact">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto text-center">
            <h2 class="section-heading">Let's Get In Touch!</h2>
            <hr class="my-4">
            <p class="mb-5">Ready to start your next project with us? That's great! Give us a call or send us an email and we will get back to you as soon as possible!</p>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-4 ml-auto text-center">
            <i class="fas fa-phone fa-3x mb-3 sr-contact-1"></i>
            <p>123-456-6789</p>
          </div>
          <div class="col-lg-4 mr-auto text-center">
            <i class="fas fa-envelope fa-3x mb-3 sr-contact-2"></i>
            <p>
              <a href="mailto:your-email@your-domain.com">feedback@startbootstrap.com</a>
            </p>
          </div>
        </div>
      </div>
    </section>

       

        <!--<script src="<?php echo e(asset('themes/omnilife2018/js/main.js')); ?>"></script>-->

<!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAEp9fyBXuhBis4OfH7o1HAVZjux8xEx3U&callback=initMap"
    async defer></script>-->
        <script src="<?php echo e(PageBuilder::js('jquery.min')); ?>"></script>
        <script src="<?php echo e(PageBuilder::js('bootstrap.min')); ?>"></script>
        <script src="<?php echo e(PageBuilder::js('localizacion')); ?>"></script>
        
                <script src="<?php echo e(asset('cms/inicio/vendor/jquery/jquery.min.js')); ?>"></script>
                <script src="<?php echo e(asset('cms/inicio/vendor/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
                <script src="<?php echo e(asset('cms/inicio/vendor/jquery-easing/jquery.easing.min.js')); ?>"></script>
                <script src="<?php echo e(asset('cms/inicio/vendor/scrollreveal/scrollreveal.min.js')); ?>"></script>
                <script src="<?php echo e(asset('cms/inicio/vendor/magnific-popup/jquery.magnific-popup.min.js')); ?>"></script>
                <script src="<?php echo e(asset('cms/inicio/js/creative.min.js')); ?>"></script>
                <script src="<?php echo e(asset('cms/inicio/js/grayscale.min.js')); ?>"></script>
        <script type="text/javascript" >
            var APP_URL = <?php echo json_encode(url('/')); ?>;

        </script>

    </body>
</html>
