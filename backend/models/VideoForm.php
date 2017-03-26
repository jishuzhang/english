<?php
namespace backend\models;

use Yii;
use yii\base\ExitException;
use yii\base\Model;
use common\models\Movies;
use yii\web\UploadedFile;

/**
 * 视频
 */
class VideoForm extends Model
{
    public $id;
    public $title;
    public $src;
    public $description;
    public $poster;
    public $_posterUrl;
    public $uploadRootPath = 'upload';


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['title', 'description','src'], 'required','message'=>'该选项不能为空'],
            ['id', 'integer'],

            ['title', 'string', 'min' => 4,'max'=>'24','tooLong'=>'标题过长','tooShort'=>'标题过短'],
            ['description', 'string', 'min' => 1,'max'=>'255','tooLong'=>'描述过长','tooShort'=>'描述过短'],

            ['src','url','message' => '无效的视频地址'],

            ['poster', 'file'],
            ['poster', 'file', 'skipOnEmpty' => false],

            // mimeType  安全机制
            ['poster', 'file', 'extensions' => 'jpg, png','checkExtensionByMimeType'=>false,'maxSize'=>1024000],
            //['poster', 'file', 'extensions' => 'jpg, png', 'mimeTypes' => 'image/jpeg, image/png',],

        ];
    }

    public function scenarios()

    {
        $scenarios = parent::scenarios();

        $scenarios['create'] = ['title','description','src','poster'];
        $scenarios['edit'] = ['title','description','src','id','poster'];

        return $scenarios;
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
        $video->mtime = time();

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
        $video->poster = $this->_posterUrl;
        $video->ctime = time();
        $video->mtime = time();

        return $video->save() ? true : false;
    }

    /**
     * 将接收到的 文件按照 年/月/日 的目录格式 放置在前台根目录下
     * @author su
     */
    public function encryptFileSave()
    {
        if(!$this->poster instanceof UploadedFile){
            Yii::trace('没有获取到文件对象', 'upload');
            $this->addError('poster','上传加密失败');
            return false;
        }

        $timePath = date('Y').DIRECTORY_SEPARATOR.date('m').DIRECTORY_SEPARATOR.date('d');
        $filePathEncrypted = FRONTEND_PATH.DIRECTORY_SEPARATOR.$timePath;
        $fileNameEncrypted = md5($this->poster->baseName.time()) . '.' . $this->poster->extension;

        if (!file_exists($filePathEncrypted)) {

            try{

                mkdir($filePathEncrypted,0755,true);
                // chmod($filePathEncrypted,0755);

            }catch(ExitException $e){

                Yii::trace( $e->getMessage(), 'uploads');
                return false;
            }

        }

        $newFileIsExists = true;

        while($newFileIsExists){

            if(file_exists($filePathEncrypted.DIRECTORY_SEPARATOR.$fileNameEncrypted)){
                $fileNameEncrypted = md5($this->poster->baseName.time()) . '.' . $this->poster->extension;
            }else{
                $newFileIsExists = false;
            }
        }

        // 录入数据库的路径
        $this->_posterUrl = $this->uploadRootPath.DIRECTORY_SEPARATOR.$timePath.DIRECTORY_SEPARATOR.$fileNameEncrypted;

        // 用来copy 的绝对路径
        $this->poster->saveAs($filePathEncrypted.DIRECTORY_SEPARATOR.$fileNameEncrypted);

        return true;

    }

}
