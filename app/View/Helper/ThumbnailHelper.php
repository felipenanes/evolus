<?php

App::uses('HtmlHelper', 'View/Helper');
class ThumbnailHelper extends HtmlHelper {

    private $defaults = array(
        'folder' => 'thumbnails',
        'width' => 235,
        'height' => 198,
        'quality' => 100,
        'resize' => 'auto',
        'cachePath' => '',
        'srcImage' => '',
        'srcHeight' => '',
        'srcWidth' => '',
        'openedImage' => '',
        'imageResized' => '',
        'folderRelative' => '',
        'basename' => '',
    );
    public $settings = array();

    public function __construct(View $View, $settings = array()) {
        parent::__construct($View, $settings);
        $this->defaults = array_merge($this->defaults, $settings);
    }

    public function render($image, $params, $options = array()) {
        $result = null;
        $this->setup($image, $params);
        if (file_exists($this->settings['folder'] . DS . $this->settings['cachePath'] . DS . $this->settings['basename'])) {
            //echo 'aqui';
            $result = $this->image($this->openCachedImage(), $options);
        } else if ($this->openSrcImage()) {
            $this->saveImgCache();
            $result = $this->image($this->settings['folderRelative'] . DS . $this->settings['cachePath'] . DS . $this->settings['basename'], $options);
        }
        $this->settings = array();
        return $result;
    }

    private function setup($image, $params) {
        $this->settings = array_merge($this->defaults, $params);

        $this->settings['basename'] = basename($image);
        if (strpos($image, '/') === 0) {
            $this->settings['srcImage'] = substr($image, 1);
        } else {
            $this->settings['srcImage'] = 'img' . DS . $image;
        }
        $this->settings['folderRelative'] = $this->settings['folder'];
        if (strpos($this->settings['folder'], '/') === 0) {
            $this->settings['folder'] = substr($this->settings['folder'], 1);
        } else {
            $this->settings['folder'] = 'img' . DS . $this->settings['folder'];
        }
        $this->settings['folder'] = WWW_ROOT . $this->settings['folder'];

        if ($this->settings['cachePath']) {
            $this->settings['cachePath'] .= DS;
        }
        $this->settings['cachePath'] .= $this->settings['width'] . 'x' . $this->settings['height'] . 'q' . $this->settings['quality'] . 'r' . $this->settings['resize'];
    }

    private function openCachedImage() {
        return $this->settings['folderRelative'] . '/' . $this->settings['cachePath'] . '/' . $this->settings['basename'];
    }

    private function openSrcImage() {
        $image_path = WWW_ROOT . $this->settings['srcImage'];
        if (is_file($image_path)) {
            list($width, $heigth) = getimagesize($image_path);

            $this->settings['srcWidth'] = $width;
            $this->settings['srcHeight'] = $heigth;

            $this->settings['openedImage'] = $this->openImage($image_path);
            return true;
        } else {
            return false;
        }
    }

    private function saveImgCache() {
        $filename = $this->settings['basename'];
        if(!file_exists($this->settings['folder'] . DS . $this->settings['cachePath'] . DS . $filename)){
            $this->resizeImage();
            $extension = strtolower(strrchr($this->settings['folder'] . $this->settings['srcImage'], '.'));

            if (!file_exists($this->settings['folder'] . DS . $this->settings['cachePath'])){
                mkdir($this->settings['folder'] . DS . $this->settings['cachePath'], 0755, true);
				chmod($this->settings['folder'] . DS . $this->settings['cachePath'], 0755);
            }

            switch ($extension) {
                case '.jpg':
                case '.jpeg':
                    if (imagetypes() & IMG_JPG) {
                        imagejpeg($this->settings['imageResized'], $this->settings['folder'] . DS . $this->settings['cachePath'] . DS . $filename, $this->settings['quality']);
						chmod($this->settings['folder'] . DS . $this->settings['cachePath'] . DS . $filename, 0644);
                    }
                    break;

                case '.gif':
                    if (imagetypes() & IMG_GIF) {
                        imagegif($this->settings['imageResized'], $this->settings['folder'] . DS . $this->settings['cachePath'] . DS . $filename);
						chmod($this->settings['folder'] . DS . $this->settings['cachePath'] . DS . $filename, 0644);
                    }
                    break;
                case '.png':
                    $scaleQuality = round(($this->settings['quality'] / 100) * 9);

                    $invertScaleQuality = 9 - $scaleQuality;

                    if (imagetypes() & IMG_PNG) {
                        imagepng($this->settings['imageResized'], $this->settings['folder'] . DS . $this->settings['cachePath'] . DS . $filename, $invertScaleQuality);
						chmod($this->settings['folder'] . DS . $this->settings['cachePath'] . DS . $filename, 0644);
                    }

                    break;
                default:
                    break;
            }
            imagedestroy($this->settings['imageResized']);
        }
    }

    private function resizeImage() {
        $options = $this->getDimensions();

        $optimalWidth = $options['optimalWidth'];
        $optimalHeight = $options['optimalHeight'];

        if($optimalWidth > $this->settings['srcWidth'])
        {
            $optimalWidth = $this->settings['srcWidth'];
        }

        if($optimalHeight > $this->settings['srcHeight'])
        {
            $optimalHeight = $this->settings['srcHeight'];
        }

        // genera nova h/w se não for informado
        if($optimalWidth && !$optimalHeight)
        {
            $optimalHeight = $this->settings['srcHeight'] * ($optimalHeight / $this->settings['srcWidth']);
        }
        elseif($optimalHeight && !$optimalWidth)
        {
            $optimalWidth = $this->settings['srcWidth'] * ($optimalHeight / $this->settings['srcHeight']);
        }
        elseif(!$optimalWidth && !$optimalHeight)
        {
            $optimalWidth = $this->settings['srcWidth'];
            $optimalHeight = $this->settings['srcHeight'];
        }

        $this->settings['imageResized'] = imagecreatetruecolor($optimalWidth, $optimalHeight);

        $info = getimagesize(WWW_ROOT . $this->settings['srcImage']);

        if ( ($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG) ) {
            $trnprt_indx = imagecolortransparent($this->settings['openedImage']);

            // se for especificado uma cor para a transparencia
            if ($trnprt_indx >= 0) {

                //Pega a cor original da transparencia da imagem em valor RGB
                $trnprt_color    = imagecolorsforindex($this->settings['openedImage'], $trnprt_indx);

                // Aloca a mesma cor para a nova imagem
                $trnprt_indx    = imagecolorallocate($this->settings['imageResized'], $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);

                // Preenche o background da nova imagem que foi alocada acima
                imagefill($this->settings['imageResized'], 0, 0, $trnprt_indx);

                // Seta a cor de background da nova imagem para transparente
                imagecolortransparent($this->settings['imageResized'], $trnprt_indx);


            }
            //Sempre faz fundo transparente para imagens PNG que nao tiveram um background alocado
            elseif ($info[2] == IMAGETYPE_PNG) {

                // Desliga o blending da transparencia (temporariamente)
                imagealphablending($this->settings['imageResized'], false);

                // Cria uma nova cor trasnparente para a imagem
                $color = imagecolorallocatealpha($this->settings['imageResized'], 0, 0, 0, 127);

                // Preenche o background da nova imagem que foi alocada acima
                imagefill($this->settings['imageResized'], 0, 0, $color);

                // Restora o blending da transparencia
                imagesavealpha($this->settings['imageResized'], true);
            }
        }

        imagecopyresampled($this->settings['imageResized'], $this->settings['openedImage'], 0, 0, 0, 0, $optimalWidth, $optimalHeight, $this->settings['srcWidth'], $this->settings['srcHeight']);

        if ($this->settings['resize'] == 'crop') {
            $this->crop($optimalWidth, $optimalHeight);
        }
    }

    private function crop($optimalWidth, $optimalHeight) {

        $cropStartX = ( $optimalWidth / 2) - ( $this->settings['width'] / 2 );
        $cropStartY = ( $optimalHeight / 2) - ( $this->settings['height'] / 2 );

        $crop = $this->settings['imageResized'];
        $this->settings['imageResized'] = @imagecreatetruecolor($this->settings['width'], $this->settings['height']);
        @imagecopyresampled($this->settings['imageResized'], $crop, 0, 0, $cropStartX, $cropStartY, $this->settings['width'], $this->settings['height'], $this->settings['width'], $this->settings['height']);
    }

    private function openImage($file) {
        $extension = strtolower(strrchr($file, '.'));

        switch ($extension) {
            case '.jpg':
            case '.jpeg':
                $img = imagecreatefromjpeg($file);
                break;
            case '.gif':
                $img = imagecreatefromgif($file);
                $transparent_index = imagecolortransparent($img);
                break;
            case '.png':
                $img = imagecreatefrompng($file);
                break;
            default:
                $img = false;
                break;
        }
        return $img;
    }

    private function getDimensions() {

        switch ($this->settings['resize']) {
            case 'exact':
                $optimalWidth = $this->settings['width'];
                $optimalHeight = $this->settings['height'];
                break;
            case 'portrait':
                $optimalWidth = $this->getSizeByFixedHeight($this->settings['height']);
                $optimalHeight = $this->settings['height'];
                break;
            case 'landscape':
                $optimalWidth = $this->settings['width'];
                $optimalHeight = $this->getSizeByFixedWidth($this->settings['width']);
                break;
            case 'auto':
                $optionArray = $this->getSizeByAuto($this->settings['width'], $this->settings['height']);
                $optimalWidth = $optionArray['optimalWidth'];
                $optimalHeight = $optionArray['optimalHeight'];
                break;
            case 'crop':
                $optionArray = $this->getOptimalCrop($this->settings['width'], $this->settings['height']);
                $optimalWidth = $optionArray['optimalWidth'];
                $optimalHeight = $optionArray['optimalHeight'];
                break;
        }
        return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
    }

    private function getSizeByFixedHeight($newHeight) {
        $ratio = $this->settings['srcWidth'] / $this->settings['srcHeight'];
        $newWidth = $newHeight * $ratio;
        return $newWidth;
    }

    private function getSizeByFixedWidth($newWidth) {
        $ratio = $this->settings['srcHeight'] / $this->settings['srcWidth'];
        $newHeight = $newWidth * $ratio;
        return $newHeight;
    }

    private function getSizeByAuto($newWidth, $newHeight) {
        if ($this->settings['srcHeight'] < $this->settings['srcWidth']) {
            $optimalWidth = $newWidth;
            $optimalHeight = $this->getSizeByFixedWidth($newWidth);
        } elseif ($this->settings['srcHeight'] > $this->settings['srcWidth']) {
            $optimalWidth = $this->getSizeByFixedHeight($newHeight);
            $optimalHeight = $newHeight;
        } else {
            if ($newHeight < $newWidth) {
                $optimalWidth = $newWidth;
                $optimalHeight = $this->getSizeByFixedWidth($newWidth);
            } else if ($newHeight > $newWidth) {
                $optimalWidth = $this->getSizeByFixedHeight($newHeight);
                $optimalHeight = $newHeight;
            } else {
                $optimalWidth = $newWidth;
                $optimalHeight = $newHeight;
            }
        }

        return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
    }

    private function getOptimalCrop($newWidth, $newHeight) {

        $heightRatio = $this->settings['srcHeight'] / $newHeight;
        $widthRatio = $this->settings['srcWidth'] / $newWidth;

        if ($heightRatio < $widthRatio) {
            $optimalRatio = $heightRatio;
        } else {
            $optimalRatio = $widthRatio;
        }

        $optimalHeight = $this->settings['srcHeight'] / $optimalRatio;
        $optimalWidth = $this->settings['srcWidth'] / $optimalRatio;

        return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
    }

}