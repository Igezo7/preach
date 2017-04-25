<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    private $src = './Public/material/model.jpg';
    private $image;
    private $info;

    public function index(){
    $this->display('index');
}

    public function getModel(){
        $info = getimagesize($this->src);
        $type = image_type_to_extension($info[2],false);
        $this->info =$info;
        $this->info['type'] = $type;
        $fun = "imagecreatefrom".$type;
        $this->image = $fun($this->src);
    }


    public function fontMark($fontsize,$x,$y,$color,$text){
    $col = imagecolorallocatealpha($this->image,$color[0],$color[1],$color[2],$color[3]);
    $black = imagecolorallocate($this->image, 0x00, 0x00, 0x00);
    imagefttext($this->image,25,0,435,891,$black,'./Public/font/test.ttf',$text);
        $this->show($text);
    }

    public function show($text){
        $time = time();
    header('content-type:' . $this -> info['mime'].';charset=utf-8');
    $fun='image' . $this->info['type'];
    $fun($this->image,'./Public/cache/'.$text.$time.'.jpg');
        $this->assign('time',$time);
        $this->assign('text',$text);
        $this->display('content');
    }

    public function test(){
        $this->getModel();
        $name = $_POST['cardname'];
        $lenth = strlen($name);
        if ($lenth=='6'){
            $name = substr_replace($name, '  ', 3, 0);
        }
        $this->fontMark(50,1200,130,array(255,255,255,60),$name);
    }

    public function __destruct(){
    imagedestroy($this->image);
    }

    public function dsp()
    {
        $img = file_get_contents('./Public/material/model.jpg', true);
        header("Content-Type: image/jpeg;text/html;charset=utf-8");
        echo $img;
    }

}