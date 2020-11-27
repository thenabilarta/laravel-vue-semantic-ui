
    <li class="dd-item dd3-item" data-id="<?php echo e($menu->id); ?>">
        <div class="dd-handle dd3-handle"></div>

        <div class="dd3-content">
            <span class="menu-label" id="menu-label-<?php echo e($menu->id); ?>"><?php echo e($menu->label); ?></span>
            <a href="#" data-id="<?php echo e($menu->id); ?>" class="edit-menu float-right btn btn-xs btn-warning m-l-10 m-t-5"><?php echo app('translator')->getFromJson('menumanager::menu_manager.edit'); ?></a>
            <a href="#" data-id="<?php echo e($menu->id); ?>" class="delete-menu float-right btn btn-xs btn-danger m-t-5"><?php echo app('translator')->getFromJson('menumanager::menu_manager.delete'); ?></a>
        </div>
        <?php if($menu->children->count() > 0): ?>
            <ol class="dd-list">
            <?php $__currentLoopData = $menu->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo $__env->make('menumanager::partial.menuItem', array('menu' => $menu), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ol>
        <?php endif; ?>
    </li>

