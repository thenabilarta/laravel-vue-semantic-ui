<?php $__env->startSection('content'); ?>

    <div class="block-header">
        <h2><?php echo app('translator')->getFromJson('settings::settings.module'); ?></h2>
    </div>

    <div class="row">

        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 no-vert-padding" >

            <?php echo $__env->make('settings::partial.menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        </div>

        <div  class="col-lg-9 col-md-9 col-sm-9 col-xs-12 no-vert-padding">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">

                        <div class="body">

                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <?php echo app('arrilot.widget')->run('Modules\Platform\Settings\Widgets\UserCountWidget',['count_active' => true,'color'=>'bg-light-green']); ?>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <?php echo app('arrilot.widget')->run('Modules\Platform\Settings\Widgets\UserCountWidget',['count_active' => false,'widget_title'=>'inactive','color'=>'bg-deep-orange']); ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>