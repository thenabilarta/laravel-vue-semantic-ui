<?php

use Modules\Platform\Core\Helper\SettingsHelper as SettingsHelper;
use Krucas\Settings\Facades\Settings as Settings;

?>


        <!DOCTYPE html>

<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title> <?php echo e(\Krucas\Settings\Facades\Settings::get(\Modules\Platform\Core\Helper\SettingsHelper::S_DISPLAY_APPLICATION_NAME, config('app.name'))); ?></title>
    <!-- Favicon-->

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <link rel="icon" href="<?php echo e(asset('bap/images/favicon.png')); ?>" type="image/png">

    <link href="<?php echo e(asset('bap/plugins/font-awesome/css/font-awesome.min.css')); ?>" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    <link
  rel="stylesheet"
  href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css"
/>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet"
          type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <?php echo $__env->yieldPushContent('css-up'); ?>



    <script type="text/javascript" src="<?php echo e(asset('bap/plugins/jquery/jquery.min.js')); ?>"></script>

    <?php if(config('broadcasting.connections.pusher.key') != ''): ?>
        <script src="https://js.pusher.com/3.1/pusher.min.js"></script>
        <script>

            window.PUSHER = new Pusher('<?php echo e(config('broadcasting.connections.pusher.key')); ?>', {
                cluster: '<?php echo e(config('broadcasting.connections.pusher.options.cluster')); ?>',
                encrypted: true
            });

        </script>
    <?php endif; ?>

        <!-- Css -->
        <?php echo Packer::css([
            '/bap/plugins/bootstrap/css/bootstrap.css',
            '/bap/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css',
            '/bap/plugins/node-waves/waves.css',
            '/bap/plugins/animate-css/animate.css',
            '/bap/plugins/bootstrap-select/css/bootstrap-select.css',
            '/bap/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css',
            '/bap/plugins/jquery-datatable/extensions/responsive/css/responsive.dataTables.css',
            '/bap/scss/style.css',
            '/bap/plugins/offlinejs/offline-theme-chrome.css',
            '/bap/plugins/offlinejs/offline-language-english.css',
            '/bap/plugins/select2-4.0.3/dist/css/select2.min.css',
            '/bap/plugins/select2-4.0.3/dist/css/select2-bootstrap.css',
            '/bap/plugins/select2-4.0.3/dist/css/pmd-select2.css',
            '/bap/plugins/bootstrap-daterangepicker/daterangepicker.css',
            '/bap/plugins/bootstrap-datetimepicker/dist/css/bootstrap-datetimepicker.min.css',
            '/bap/plugins/jquery-datatable/yadcf/jquery.dataTables.yadcf.css',
            '/bap/plugins/bootstrap-fileinput/css/fileinput.min.css',
            '/bap/plugins/jquery-comments/css/jquery-comments.css',
            ],
            '/storage/cache/css/main.css'
        ); ?>


    <?php echo $__env->yieldPushContent('css'); ?>


    <?php echo $__env->make('partial.header_js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <script type="text/javascript">

        window.APPLICATION_USER_DATE_FORMAT = '<?php echo e(\Modules\Platform\Core\Helper\UserHelper::userJsDateFormat()); ?>';
        window.APPLICATION_USER_TIME_FORMAT = '<?php echo e(\Modules\Platform\Core\Helper\UserHelper::userJsTimeFormat()); ?>';
        window.APPLICATION_USER_LANGUAGE = '<?php echo e(app()->getLocale()); ?>';
        window.UID = '<?php echo e(Auth::user()->id); ?>';
        window.PUSHER_ACIVE = '<?php echo e(config('broadcasting.connections.pusher.key') != '' ? 1 : 0); ?>';
        <?php if(\Modules\Platform\Core\Helper\UserHelper::userJsTimeFormat()  == 'HH:mm'): ?>
            window.APPLICATION_USER_TIME_FORMAT_24 = true;
        <?php else: ?>
            window.APPLICATION_USER_TIME_FORMAT_24 = false;
        <?php endif; ?>
    </script>


    <?php if(config('bap.google_ga')): ?>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo e(config('app.google_ga')); ?>"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', '<?php echo e(config('bap.google_ga')); ?>');
        </script>
    <?php endif; ?>

</head>

<body class="<?php echo e(Auth::user()->theme()); ?> <?php echo $__env->yieldContent('body_class'); ?>">

<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="preloader">
            <div class="spinner-layer pl-red">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
        <p><?php echo app('translator')->getFromJson('core::core.please_wait'); ?></p>
    </div>
</div>
<!-- #END# Page Loader -->
<!-- Overlay For Sidebars -->
<div class="overlay"></div>
<!-- #END# Overlay For Sidebars -->

<?php echo $__env->make('partial.search-bar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('partial.top-bar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<section>


    <?php echo $__env->make('partial.left-sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php echo $__env->make('partial.right-sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</section>

<section class="content">
    <div class="container-fluid">



        <?php echo $__env->make('flash::message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <?php echo $__env->yieldContent('content'); ?>

    </div>
</section>


<?php echo $__env->make('partial.bottom_js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


<?php echo $__env->yieldPushContent('scripts'); ?>

<div class="modal fade" id="genericModal" tabindex="-1" role="dialog" aria-hidden="true" style="z-index: 10080!important;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="largeModalLabel"></h4>
            </div>

            <div class="modal-body ">

            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal"><?php echo app('translator')->getFromJson('core::core.CLOSE'); ?></button>
            </div>
        </div>
    </div>
</div>

<?php echo $__env->make('announcement::announcement-message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

</body>
</html>
