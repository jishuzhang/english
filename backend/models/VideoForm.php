<?php
namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * 视频
 */
class VideoForm extends Model
{
    public $id;
    public $title;
    public $src;
    public $description;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['title', 'description','src'], 'required','{attributes}不能为空'],
            ['id', 'integer'],

            ['title', 'string', 'min' => 4,'max'=>'24','tooLong'=>'标题过长','tooShort'=>'标题过短'],
            ['description', 'string', 'min' => 1,'max'=>'255','tooLong'=>'描述过长','tooShort'=>'描述过短'],

            ['src','url','message' => '无效的视频地址']

        ];
    }

    /**
     * edit video information
     * @return bool
     */
    public function updateVideo()
    {
        $video = Movies::findOne(['id' => $this->id]);

        $video->title = $this->title;
        $video->src = $this->src;
        $video->description = $this->description;
        $video->ctime = time();

        return $video->save() ? true : false;

    }

    /**
     * create new video
     */
    public function createVideo()
    {
        $video = new Movies();

        $video->title = $this->title;
        $video->src = $this->src;
        $video->description = $this->description;
        $video->ctime = time();

        return $video->save() ? true : false;
    }
}
