<?php

/**
 * @package   yii2-krajee-base
 * @author    Kartik Visweswaran <kartikv2@gmail.com>
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2018
 * @version   2.0.2
 */

namespace kartik\base;

use ReflectionException;
use yii\base\InvalidConfigException;
use yii\base\Module as YiiModule;

/**
 * Base module class for Krajee extensions
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 2.0.2
 */
class Module extends YiiModule implements BootstrapInterface
{
    use TranslationTrait;
    use BootstrapTrait;

    /**
     * @inheritdoc
     * @throws InvalidConfigException
     * @throws ReflectionException
     */
    public function init()
    {
        $this->initBsVersion();
        parent::init();
        $this->initI18N();
    }
}
