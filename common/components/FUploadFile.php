<?php
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
/**
 * Created by PhpStorm.
 * User: Бекарыс
 * Date: 06.01.2016
 * Time: 22:53
 */
class FUploadFile extends Component
{
    protected $file;
    protected $castom_filename = false;
    public $hash = '';
    const I_AVATAR = '/avatar';
    const I_UPLOAD = '/images';
    const I_POST = '/post';
    protected $base_alias = @frontend.'.upload';

    public function __construct($varname, $method = 'post', $upload_dir = false, $filename = false)
    {
        if ($upload_dir!==false) $this->upload_dir = $upload_dir;
        $this->castom_filename = $filename;
        $this->method = $method;
        if ($this->method == 'post') {
            $this->file=CUploadedFile::getInstanceByName($varname);

            if (!is_null($this->file))
            {
                $this->filename = $this->file->getName();
                $this->fileext = $this->file->getExtensionName();
                $this->filesize = $this->file->getSize();
                $this->hash = $this->getHashName();
                $this->fileuploaded = true;
            }
        }
        elseif ($this->method == 'xhr') {
            $this->filename = $_GET[$varname];
            $pathinfo = pathinfo($this->filename);
            $this->fileext = $pathinfo['extension'];
            $this->filesize = $this->getXhrSize();
            $this->hash = $this->getHashName();
            $this->fileuploaded = true;
        }
    }

    public function getUploadDir($hash, $dirdeep = 5) {
        $uploadDirectory = Yii::getPathOfAlias($this->base_alias.'.'.$this->upload_dir);

        for ($i=0; $i<$dirdeep; $i++) {
            $c = $hash[$i];
            $uploadDirectory .= '/'.$c;
        }

        if (!file_exists($uploadDirectory)) {
            mkdir($uploadDirectory, 0775, true);
        }

        return $uploadDirectory.'/'.substr($hash,$dirdeep);
    }

    public function getHashName() {
        if ($this->castom_filename === false) {
            return md5(uniqid());
        }
        else {
            $tmp = md5(uniqid());
            return substr($tmp, 0, $this->dirdeep).$this->castom_filename;
        }

    }

    public function save($deleteTempFile=true) {

        if (!$this->fileuploaded) throw new CException('file not uploaded');

        $savepath = $this->getUploadDir($this->hash, $this->dirdeep);

        while (file_exists($savepath . '.' . $this->fileext)) {
            $rand = rand(10, 99);
            $this->hash .= $rand;
            $savepath .= $rand;
        }

        $filename = $savepath . '.' . $this->fileext;

        // $imageFile to save in images table
        $imageFile = $this->hash . '.' . $this->fileext;
        if ($this->method == 'post') {
            $save = $this->file->saveAs($filename, $deleteTempFile);
            $this->saveFImages($imageFile);
            return $save;
        }
        elseif ($this->method == 'xhr') {
            $save = $this->saveXhr($filename);
            $this->saveFImages($imageFile);
            return $save;
        }

        return false;
    }

    public function __toString() {
        return $this->fileuploaded ? $this->hash.'.'.$this->file->extensionName : '';
    }

    /*
    * save filename in Images table
    */
    private function saveFImages($filename)
    {
        if (empty($this->f_image))
        {
            $this->f_image = new Images;
        }

        $this->f_image->name = $filename;

        return $this->f_image->save();
    }
}