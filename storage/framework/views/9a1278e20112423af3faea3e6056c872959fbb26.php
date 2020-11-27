<?php $__env->startSection('content'); ?>

    <div class="block-header">
        <h2><?php echo app('translator')->getFromJson('settings::settings.module'); ?></h2>
    </div>

    <div class="row">

        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 no-vert-padding">

            <?php echo $__env->make('settings::partial.menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        </div>

        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 no-vert-padding">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>

                            <a href="<?php echo e(route('settings.menu_manager.create_element')); ?>" class="btn bg-pink float-right m-l-5"><?php echo app('translator')->getFromJson('menumanager::menu_manager.add'); ?></a>


                            <?php echo app('translator')->getFromJson('menumanager::menu_manager.module'); ?>
                            <small><?php echo app('translator')->getFromJson('menumanager::menu_manager.module_description'); ?></small>
                        </h2>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-lg-12 col-sm-12 col-xs-12">
                                <b><i class="fa fa-info-circle" aria-hidden="true"></i> <?php echo app('translator')->getFromJson('menumanager::menu_manager.help'); ?></b> <br />
                                <?php echo app('translator')->getFromJson('menumanager::menu_manager.additional_description'); ?> <br /><br />

                                <a target="_blank" href="/bap/pages/ui/icons.html"> <?php echo app('translator')->getFromJson('menumanager::menu_manager.icon_ref'); ?></a>
                            </div>
                        </div>

                        <div class="row clearfix">
                            <div class="col-lg-6 col-md-6 col-sm-12">

                                <h2 class="card-inside-title"><?php echo app('translator')->getFromJson('menumanager::menu_manager.main_menu'); ?></h2>



                                <div class="dd nestable-with-handle">
                                    <ol class="dd-list">
                                        <?php $__currentLoopData = $mainMenu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($menu->parent_id == null ): ?>
                                                <?php echo $__env->make('menumanager::partial.menuItem',['menu'=>$menu], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ol>
                                </div>

                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <?php echo form($menuForm); ?>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
    <link href="<?php echo e(asset('bap/plugins/nestable/jquery-nestable.css')); ?>" rel="stylesheet" type="text/css">
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('bap/plugins/nestable/jquery.nestable.js')); ?>"></script>
    <script src="<?php echo Module::asset('menumanager:js/BAP_MenuManager.js'); ?>"></script>

    <?php echo JsValidator::formRequest(\Modules\Platform\MenuManager\Http\Requests\SaveMenuElementRequest::class, '#save_menu_element_form'); ?>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>