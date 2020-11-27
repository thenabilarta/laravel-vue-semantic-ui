<?php $__env->startSection('content'); ?>

    <div class="block-header">
        <h2><?php echo app('translator')->getFromJson('dashboard::dashboard.module'); ?></h2>
    </div>

    <div class="row dashboard-row">

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="card">
                <div id="app">
                    <index></index>
                </div>
            </div>
        </div>

    </div>
    
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css-up'); ?>

<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>

    <script src="<?php echo Module::asset('media:js/media.js'); ?>"></script>

<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>

    <script src="<?php echo Module::asset('dashboard:js/BAP_Dashboard.js'); ?>"></script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>