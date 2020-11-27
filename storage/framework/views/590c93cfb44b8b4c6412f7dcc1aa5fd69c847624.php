<div class="info-box">
    <div class="icon <?php echo e($config['color']); ?>">
        <i class="material-icons ">face</i>
    </div>
    <div class="content">
        <div class="text"><?php echo app('translator')->getFromJson('settings::widgets.users_count.'.$config['widget_title']); ?></div>
        <div class="number count-to" data-from="0" data-to="<?php echo e($userCount); ?>" data-speed="1000" data-fresh-interval="20"><?php echo e($userCount); ?></div>
    </div>
</div>