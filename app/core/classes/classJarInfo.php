<?php
/////////////////////////////////////
// Класс для получения инфы из jar //
/////////////////////////////////////
require 'pclzip.lib.php';

class JarInfo{
    private $mimetype;
    private $manifest = array();
    private $info = array();
    private $file;
    
    // Констуктор...
    public function __construct($file){
    // $file - путь до файла.
    is_file($file) or die ("Файл: $file не существует.");
    
    $archive = new PclZip($file);
    $this->file = $file;
    $this->manifest = $archive->extract(PCLZIP_OPT_BY_NAME, 'META-INF/MANIFEST.MF', PCLZIP_OPT_EXTRACT_AS_STRING);
    $this->parse();
    }
    
    // Разбираем манифест
    private function parse(){
        $man = explode("\n", trim($this->manifest[0]['content']));
        foreach($man as $mani){
        $ar = explode(': ', $mani);
        $this->info[$ar[0]] = $ar[1];
        } 
    }
    
    // Версия
    public function getVersion(){
        if($this->info['MIDlet-Version'])
        return $this->info['MIDlet-Version'];
        else
        return false;
    }
    
    // Имя
    public function getName(){
        if($this->info['MIDlet-Name'])
        return $this->info['MIDlet-Name'];
        else
        return false;
    }
    
    // Производитель
    public function getVendor(){
        if($this->info['MIDlet-Vendor'])
        return $this->info['MIDlet-Vendor'];
        else
        return false;
    }
    
    // Профиль
    public function getProfile(){
        if($this->info['MicroEdition-Profile'])
        return $this->info['MicroEdition-Profile'];
        else
        return false;
    }
    
    // URL
    public function getUrl(){
        if($this->info['MIDlet-Info-URL'])
        return $this->info['MIDlet-Info-URL'];
        else
        return false;
    }

    // Получить иконку
    public function getIcon($save_as){
        $icon = trim(substr($this->info['MIDlet-1'], $pos = strpos($this->info['MIDlet-1'], ',')+1, strrpos($this->info['MIDlet-1'], ',')-$pos));
        $icon = preg_replace('#^/#', null, $icon);
        $archive = new PclZip($this->file);
        $list = $archive->extract(PCLZIP_OPT_BY_NAME, $icon, PCLZIP_OPT_EXTRACT_AS_STRING);
        if(pathinfo($icon, PATHINFO_EXTENSION) == 'png' && $list[0]['content'] !== '' && @$image = imagecreatefromstring($list[0]['content'])){
        $width = imagesx($image);
        $height = imagesy($image);
        $x_ratio = 16/$width;
        $y_ratio = 16/$height;
        if(($width<=16)&&($height<=16)){
		$tn_width = $width;
		$tn_height = $height;
	       }elseif (($x_ratio*$height)<16){
	    $tn_height = ceil($x_ratio*$height);
		$tn_width = 16;
	     }else{
		$tn_width = ceil($y_ratio*$width);
		$tn_height = 16;
	       }
        $image_two = ImageCreate($tn_width, $tn_height);
        imagecopyresampled($image_two, $image, 0, 0, 0, 0, $tn_width, $tn_height, $width, $height);
        imagepng($image_two, $save_as);
     	imagedestroy($image);
        return true;
        }else{
        return false;
        }}
        
    // Получить JAD    
    public function getJad($url){
        $siz = filesize($this->file);
        $jad = str_ireplace('.jar','.jad',$this->file);
        $f = fopen($jad,'w+');
        fputs($f, $this->manifest[0]['content']."\n".'MIDlet-Jar-Size: '.$siz."\n".'MIDlet-Jar-URL: '.$url);
        fclose($f);
    }
    
    // Установка мини описания
    public function setDesсription($value){
        $this->info['MIDlet-Desсription'] = $value;
    }
    
    // Установка инфы при удалении
    public function setDeleteConfirm($value){
        $this->info['MIDlet-Delete-Confirm'] = $value;
    }
    
    // Установка имени
    public function setName($value){
        $this->info['MIDlet-Name'] = $value;
    }
    
    // Установка URL
    public function setUrl($value){
        $this->info['MIDlet-Info-URL'] = $value;
    }
    
    // Сохранение манифеста и упаковка в приложение
    public function saveManifest(){
        //TODO:Попытаться разобраться почему ява получается хреновой после перепаковки
        $man_string = '';
        foreach($this->info as $key=>$val){
$man_string = $man_string.$key.': '.$val.'
';
        }
        $man_string = iconv("UTF-8", "windows-1251", $man_string);
        
        //$zip = new ZipArchive;
        //$zip->open($this->file) or die('Неудалось открыть приложение!');
        //$zip->addFile('java/META-INF/MANIFEST.MF', 'META-INF/MANIFEST.MF');
        //$zip->close();
        
        //$archive = new PclZip($this->file);
        //$archive->extract(PCLZIP_OPT_PATH, 'java') or die ('Неудалось распаковать приложение!');
        
        //$manfile = fopen('java/META-INF/MANIFEST.MF', "w") or die ('Неудалось открыть манифест!');
        //fwrite($manfile, $man_string);
        //fclose($manfile);
        
        //$archive->create('java', PCLZIP_OPT_REMOVE_PATH, 'java');
        //unlink('cache/META-INF/MANIFEST.MF');
        
    }
    
    
    }

?>