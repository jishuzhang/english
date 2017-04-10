<?php
namespace frontend\widgets;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

class VerifyWidget extends InputWidget
{

    public $captchaAction = 'site/captcha';
    public $imageOptions = [];
    public $template = '{image} {input}';
    public $options = ['class' => 'form-control'];


    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        if (!isset($this->imageOptions['id'])) {
            $this->imageOptions['id'] = $this->options['id'] . '-image';
        }
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        $this->registerClientScript();

        if ($this->hasModel()) {
            $input = Html::activeTextInput($this->model, $this->attribute, $this->options);
        } else {
            $input = Html::textInput($this->name, $this->value, $this->options);
        }
        $route = $this->captchaAction;
        if (is_array($route)) {
            $route['v'] = uniqid();
        } else {
            $route = [$route, 'v' => uniqid()];
        }
        $image = Html::img($route, $this->imageOptions);
        echo strtr($this->template, [
            '{input}' => $input,
            '{image}' => $image,
        ]);
    }

    /**
     * Registers the needed JavaScript.
     */
    public function registerClientScript()
    {
        $options = $this->getClientOptions();
        $options = empty($options) ? '' : Json::htmlEncode($options);
        $id = $this->imageOptions['id'];
        $view = $this->getView();
        CaptchaAsset::register($view);
        $view->registerJs("jQuery('#$id').yiiCaptcha($options);");
    }

    /**
     * Returns the options for the captcha JS widget.
     * @return array the options
     */
    protected function getClientOptions()
    {
        $route = $this->captchaAction;

        if (is_array($route)) {
            $route[CaptchaAction::REFRESH_GET_VAR] = 1;
        } else {
            $route = [$route, CaptchaAction::REFRESH_GET_VAR => 1];
        }

        $options = [
            'refreshUrl' => Url::toRoute($route),
            'hashKey' => 'yiiCaptcha/' . trim($route[0], '/'),
        ];

        return $options;
    }

    /**
     * Checks if there is graphic extension available to generate CAPTCHA images.
     * This method will check the existence of ImageMagick and GD extensions.
     * @return string the name of the graphic extension, either "imagick" or "gd".
     * @throws InvalidConfigException if neither ImageMagick nor GD is installed.
     */
    public static function checkRequirements()
    {
        if (extension_loaded('imagick')) {
            $imagickFormats = (new \Imagick())->queryFormats('PNG');
            if (in_array('PNG', $imagickFormats, true)) {
                return 'imagick';
            }
        }
        if (extension_loaded('gd')) {
            $gdInfo = gd_info();
            if (!empty($gdInfo['FreeType Support'])) {
                return 'gd';
            }
        }
        throw new InvalidConfigException('Either GD PHP extension with FreeType support or ImageMagick PHP extension with PNG support is required.');
    }

}