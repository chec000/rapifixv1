<?php echo PageBuilder::section('head'); ?>


<div class="jumbotron" style="background: url(<?php echo e(PageBuilder::block('internal_banner', ['view' => 'raw'])); ?>) no-repeat center"></div>

<section id="sec1">
    <div class="container">

        <?php echo PageBuilder::breadcrumb(); ?>


        <div class="row">
            <div class="col-sm-12">
                <h1>Error: 500</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <?php if(env('APP_DEBUG')): ?>
                    <p class="errorpage_1"><?php echo $error; ?></p>
                    <p><?php echo e('Line ' . $e->getLine() . ' in ' . $e->getFile()); ?></p>

                    <?php if($e->getLine()): ?>
                    <pre class="text-danger"><?php echo e(file($e->getFile())[$e->getLine()-1]); ?></pre>
                    <?php endif; ?>
                    <p>&nbsp;</p>

                    <p>Full Trace:</p>
                    <p><?php echo nl2br($e->getTraceAsString()); ?></p>
                <?php else: ?>
                    <?php echo e('oops, something went wrong ...'); ?>

                <?php endif; ?>
            </div>
        </div>

    </div>
</section>

<?php echo PageBuilder::section('footer'); ?>