<?php
/**********
Versión: 001
Fecha: 07-06-2018
Desarrollador: Viviana Rodas
Descripción: Se llaman los archivos de bootbox y main js para sobreescribir el confirm de yii.
---------------------------------------
*/
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
        'css/site.css',
    ];
    // register the library first after our
    // script
    public $js = ['js/bootbox.min.js', 'js/main.js'];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
