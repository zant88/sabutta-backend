<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'https://use.fontawesome.com/releases/v6.1.1/css/all.css',
        'https://unpkg.com/select2@4.0.3/dist/css/select2.min.css',
        'css/site.css',
        'css/style.css',
        'css/components.css',
    ];
    public $js = [
        'https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js',
        //'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js',
        "https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js",
        "https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.1/axios.min.js",
        'js/yii_overrides.js',
        'js/stisla.js',
        'js/chart.min.js',
        'js/scripts.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
        'app\assets\SweetAlertAsset',
    ];
}
