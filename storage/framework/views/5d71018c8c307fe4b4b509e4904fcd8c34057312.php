<?php echo PageBuilder::section('head'); ?>


<div class="jumbotron" style="background: url(<?php echo e(PageBuilder::block('internal_banner', ['view' => 'raw'])); ?>) no-repeat center"></div>

<?php
$postDates = explode('-', Request::input('id'));
$range = !empty($postDates[1]) ? 'month' : 'year';
$postDates = array_filter($postDates) + [date('Y'), '01'];
try {
    $fromDate = \Carbon\Carbon::createFromFormat('Y-m', implode('-', $postDates))->startOfMonth();
    $toDate = clone $fromDate;
    $toDate->modify('+1 '.$range);
    $pages = PageBuilder::categoryFilter('post_date', [$fromDate, $toDate], ['view' => PageBuilder::block('category_view'), 'match' => 'in', 'renderIfEmpty' => false]);
    $archive = ($range == 'year') ? 'Year ' . $fromDate->format('Y') : $fromDate->format('F Y');
} catch (\Exception $e) {
    $pages = [];
    $archive = 'None';
}
?>

<section id="sec1">
    <div class="container">

        <div class="row">

            <div class="col-sm-9">

                <h1><?php echo PageBuilder::block('title'); ?>: <?php echo e($archive ?: 'None'); ?></h1>
                <p class="lead"><?php echo PageBuilder::block('lead_text'); ?></p>
                <?php echo PageBuilder::block('content'); ?>


                <?php if($pages): ?>
                    <?php echo $pages; ?>

                <?php else: ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <p>&nbsp;</p>
                            <p>No posts found.</p>
                        </div>
                    </div>
                <?php endif; ?>

            </div>

            <div class="col-sm-3">
                <?php echo PageBuilder::section('blog-bar'); ?>

            </div>

        </div>

    </div>
    <!-- /.container -->
</section>

<?php echo PageBuilder::section('footer'); ?>

