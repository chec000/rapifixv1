<?php AssetBuilder::setStatus('cms-versions', true); ?>

<?php if(!empty($pagination)): ?>

    <?php echo $pagination; ?>


<?php endif; ?>

<?php if(is_string($requests)): ?>

    <p><?php echo e($requests); ?></p>
    <p>&nbsp;</p>

<?php else: ?>

    <div class="table-responsive">
        <table class="table table-striped">

            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <?php if($show['page']): ?>
                    <th>Page</th>
                <?php endif; ?>
                <th>Note</th>
                <?php if($show['requested_by']): ?>
                    <th>Requested By</th>
                <?php endif; ?>
                <?php if($show['status']): ?>
                    <th>Status</th>
                <?php endif; ?>
                <th>Actions</th>
            </tr>
            </thead>

            <tbody>
            <?php $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo $request->page_version->version_id; ?></td>
                    <td><?php echo $request->page_version->getName(); ?></td>
                    <?php $page_name = \Modules\CMS\Helpers\Page\Path::getFullName($request->page_version->page_id); ?>
                    <?php if($show['page']): ?>
                        <td><?php echo $page_name; ?></td>
                    <?php endif; ?>
                    <td><?php echo $request->note; ?></td>
                    <?php if($show['requested_by']): ?>
                        <td><?php echo $request->user?$request->user->email:'Undefined'; ?></td>
                    <?php endif; ?>
                    <?php if($show['status']): ?>
                        <td><?php echo $request->status; ?></td>
                    <?php endif; ?>
                    <td>
                        <a href="<?php echo e(Modules\CMS\Helpers\Page\Path::getFullUrl($request->page_version->page_id).'?preview='.$request->page_version->preview_key); ?>"
                           target="_blank"><i class="glyphicon glyphicon-eye-open itemTooltip" title="Preview"></i></a>
                        <a href="<?php echo e(route('admin.pages.edit', ['pageId' => $request->page_version->page_id, 'version' => $request->page_version->version_id])); ?>"><i
                                    class="delete glyphicon glyphicon-pencil itemTooltip" title="Edit"></i></a>
                        <?php if($request->status == 'awaiting' && Auth::action('pages.version-publish', ['page_id' => $request->page_version->page_id])): ?>
                            <i class="request_publish_action glyphicon glyphicon-ok-circle itemTooltip"
                               data-page="<?php echo e($request->page_version->page_id); ?>"
                               data-version_id="<?php echo e($request->page_version->version_id); ?>" data-name="<?php echo e($page_name); ?>"
                               data-request="<?php echo e($request->id); ?>" data-action="approved" title="Approve & Publish"></i>
                            <i class="request_publish_action glyphicon glyphicon-remove-circle itemTooltip"
                               data-page="<?php echo e($request->page_version->page_id); ?>" data-name="<?php echo e($page_name); ?>"
                               data-request="<?php echo e($request->id); ?>" data-action="denied" title="Deny"></i>
                        <?php elseif($request->status == 'awaiting' && Auth::user()->id == $request->user_id): ?>
                            <i class="request_publish_action glyphicon glyphicon-remove-circle itemTooltip"
                               data-page="<?php echo e($request->page_version->page_id); ?>" data-name="<?php echo e($page_name); ?>"
                               data-request="<?php echo e($request->id); ?>" data-action="cancelled" title="Cancel"></i>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>

        </table>
    </div>

<?php endif; ?>