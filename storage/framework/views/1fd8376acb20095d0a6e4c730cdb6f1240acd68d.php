<?php if($theme->theme !== $directory->directory && ! empty($directory->directory)): ?>
<ul>
  <li>
      <a class="tree-folder-link" href="#" data-path="<?php echo e($directory->path); ?>"><?php echo e($directory->directory); ?></a>
<?php endif; ?>
      <?php if( ! empty($directory->folders)): ?>
        <ul>
          <?php $__currentLoopData = $directory->folders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $folder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo \View::make('admin::cms.partials.themes.filetree', ['directory' => $folder, 'theme' => $theme]); ?>

          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      <?php endif; ?>
      <?php if( ! empty($directory->files)): ?>
        <ul>
          <?php $__currentLoopData = $directory->files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><a href="#" class="load-template-file-link" data-path="<?php echo e($directory->path); ?>/<?php echo e($file); ?>"><?php echo e($file); ?></a></li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      <?php endif; ?>
<?php if($theme->theme !== $directory->directory  && ! empty($directory->directory)): ?>
    </li>
</ul>
<?php endif; ?>
