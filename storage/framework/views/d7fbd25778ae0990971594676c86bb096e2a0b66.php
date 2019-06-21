<tr id="<?php echo $repeater_id; ?>_<?php echo $row_id; ?>">
    <td class="repeater-action" style="width: 40px; border: 0;">
        <?php echo Form::hidden('repeater['.$repeater_id.']['.$row_id.'][0]', 1); ?>

        <i class="glyphicon glyphicon-move"></i>
    </td>
    <td style="padding: 0px;">
        <?php
            $id = $repeater_id.'-'.$row_id;
        ?>
        <div id="accordion-<?php echo e($id); ?>" class="accordion" role="panel-group">
            <div class="panel panel-primary" style="border: 0;">
                <div class="panel-heading" role="tab">
                    <h4 class="panel-title">
                        <a href="#repeater-row-<?php echo e($id); ?>" data-parent="#accordion-<?php echo e($id); ?>" data-toggle="collapse"
                            class="accordion-toggle <?php if($index > 1): ?> collapsed <?php endif; ?>">
                            <?php echo e($index.'.- '.$label); ?>

                        </a>
                    </h4>
                </div>
                <div id="repeater-row-<?php echo e($id); ?>" class="panel-collapse collapse <?php if($index == 1 || $index == 'New'): ?> in <?php endif; ?>"
                    role="tabpanel" data-parent="#accordion-<?php echo e($id); ?>" style="padding: 12px; border: 1px solid #ddd;
                    border-bottom-left-radius: 5px; border-bottom-right-radius: 5px">
                    <?php echo $blocks; ?>

                </div>
            </div>
        </div>
    </td>
    <td class="repeater-action" style="width: 40px; border: 0;">
        <i class="glyphicon glyphicon-remove itemTooltip"
           onclick="repeater_delete(<?php echo $repeater_id; ?>, <?php echo $row_id; ?>)"></i>
    </td>
</tr>
