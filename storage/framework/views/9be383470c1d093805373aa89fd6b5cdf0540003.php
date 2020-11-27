<?php
use Modules\Platform\Core\Helper\SettingsHelper as SettingsHelper;
use Krucas\Settings\Facades\Settings as Settings;
?>



<?php $__env->startSection('body_class','login-page'); ?>

<?php $__env->startSection('content'); ?>

    <div class="login-box">


        <div class="logo">

            <?php if(\Krucas\Settings\Facades\Settings::get(\Modules\Platform\Core\Helper\SettingsHelper::S_DISPLAY_SHOW_LOGO_ON_LOGIN)): ?>
                <a href="javascript:void(0);"><?php echo \Modules\Platform\Core\Helper\SettingsHelper::displayLogo(); ?></a>
            <?php else: ?>
                <a href="javascript:void(0);"><?php echo e(Settings::get(\Modules\Platform\Core\Helper\SettingsHelper::S_DISPLAY_APPLICATION_NAME, config('app.name'))); ?></a>
            <?php endif; ?>
        </div>
        <div class="card">
            <div class="body">
                <form id="sign_up" method="POST" action="<?php echo e(route('login')); ?>">



                    <?php if(isset($errorMessage)): ?>
                        <span class="help-block">
                                <strong><?php echo e($errorMessage); ?></strong>
                        </span>
                    <?php endif; ?>

                    <?php echo e(csrf_field()); ?>


                    <div class="msg">
                        <?php echo app('translator')->getFromJson('auth.login_title'); ?>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">person</i>
                        </span>
                        <div class="form-line <?php echo e($errors->has('email') ? ' error' : ''); ?>">
                            <input id="name" type="text" placeholder="<?php echo app('translator')->getFromJson('auth.username'); ?>" value="<?php echo e($defaultLogin); ?>" class="form-control" name="email" autofocus>
                        </div>

                        <?php if($errors->has('email')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('email')); ?></strong>
                             </span>
                        <?php endif; ?>

                    </div>

                    <div class="input-group <?php echo e($errors->has('password') ? ' error' : ''); ?>">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input id="password" placeholder="<?php echo app('translator')->getFromJson('auth.password'); ?>" value="<?php echo e($defaultPass); ?>" type="password" class="form-control" name="password">
                        </div>
                        <?php if($errors->has('password')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('password')); ?></strong>
                             </span>
                        <?php endif; ?>
                    </div>

                    <div class="row">
                        <div class="col-xs-8 p-t-5">
                            <input type="checkbox" id="rememberme" name="remember" <?php echo e(old('remember') ? 'checked' : ''); ?> class="filled-in chk-col-pink">
                            <label for="rememberme"><?php echo app('translator')->getFromJson('auth.remember_me'); ?></label>
                        </div>
                        <div class="col-xs-4">
                            <button class="btn btn-block bg-pink waves-effect" type="submit"><?php echo app('translator')->getFromJson('auth.sign_in'); ?></button>
                        </div>
                    </div>
                    <div class="row m-t-15 m-b--20">
                        <?php if(config('bap.allow_registration')): ?>
                            <div class="col-xs-6">
                                <a href="<?php echo e(route('register')); ?>"><?php echo app('translator')->getFromJson('auth.regiser'); ?></a>
                            </div>
                            <div class="col-xs-6 align-right">
                                <a href="<?php echo e(route('password.request')); ?>"><?php echo app('translator')->getFromJson('auth.forget_password'); ?></a>
                            </div>
                        <?php else: ?>
                            <div class="col-xs-12 align-right">
                                <a href="<?php echo e(route('password.request')); ?>"><?php echo app('translator')->getFromJson('auth.forget_password'); ?></a>
                            </div>
                        <?php endif; ?>

                    </div>

                </form>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>