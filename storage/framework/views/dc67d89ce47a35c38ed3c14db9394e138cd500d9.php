<?php if($is_first): ?>
<div class="ambassador--faq__content">
<?php endif; ?>
    <h3 class="faq--subtitle">
        <?php echo PageBuilder::block('ambassador_faq_objectives_question'); ?>

    </h3>
    <?php echo PageBuilder::block('ambassador_faq_objectives_answer'); ?>


<?php if($is_last): ?>
</div>
<?php endif; ?>