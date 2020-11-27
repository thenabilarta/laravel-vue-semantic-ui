<a href="<?php echo e($url); ?>" title="<?php echo e($name); ?>" class="<?php echo e(isset($cssClass) ? $cssClass : ''); ?>">
    <?php if(isset($icon)): ?>
    <i class="material-icons"><?php echo e($icon); ?></i>
        <span><?php echo e($name); ?></span>
    <?php else: ?>
        <?php echo e($name); ?>

    <?php endif; ?>

</a>