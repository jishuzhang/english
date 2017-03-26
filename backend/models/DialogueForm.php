<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\Translate;

/**
 * 视频
 */
class DialogueForm extends Model
{
    public $vid;
    public $chinese;
    public $english;
    public $tid;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['chinese','english', 'vid'], 'required','message'=>'该选项不能为空'],
            ['vid', 'integer'],
            ['vid', 'unique','targetClass' => '\common\models\Translate','message'=>'视屏ID已经其它台词绑定,请先删除原有绑定','on'=>'create'],

            [['chinese','english'], 'string','message'=>'非法输入'],

            ['tid', 'integer'],
            ['tid', 'required'],
        ];
    }

    public function scenarios()

    {
        $scenarios = parent::scenarios();

        $scenarios['create'] = ['chinese','english','vid'];
        $scenarios['edit'] = ['chinese','english','vid','tid'];

        return $scenarios;
    }

    /**
     * create a translate box
     * @return bool
     */
    public function translate()
    {
        $translate = new Translate();

        $translate->vid = $this->vid;
        $translate->en_content = $this->english;
        $translate->zn_content = $this->chinese;
        $translate->ctime = time();
        $translate->utime = time();

        return $translate->save() ? true : false ;
    }

    public function updateTranslate()
    {
        $translate = Translate::findOne(['tid'=>$this->tid]);

        $translate->vid = $this->vid;
        $translate->en_content = $this->english;
        $translate->zn_content = $this->chinese;
        $translate->utime = time();

        return $translate->save() ? true : false ;
    }

}
