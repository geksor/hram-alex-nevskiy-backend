<?php

namespace api\models;

use common\models\Gallery;
use common\models\School;
use Yii;
use zxbodya\yii2\galleryManager\GalleryBehavior;

/**
 * Class SchoolApi
 * @package api\models
 */
class SchoolApi extends School
{

    public function fields()
    {
        $prefix = Yii::$app->request->hostInfo;

        return [
            'title',
            'text',
            'timetable',
            'phone',
            'image' => function () use ($prefix) {
                return  $prefix . $this->getThumbImage();
            },
            'gallery' => function () use ($prefix) {
                $galleryArr = [];
                $galleryModel = Gallery::findOne(['id' => $this->gallery_id]);
                if (isset($galleryModel)) {
                    $galleryImages = $galleryModel->getBehavior('galleryBehavior')->getImages();
                }
                if ($galleryImages){
                    foreach ($galleryImages as $galleryImage){
                        /* @var $galleryImage GalleryBehavior */
                        $galleryArr[] = [
                            'name' => $galleryImage->name,
                            'description' => $galleryImage->description,
                            'preview' => $prefix . $galleryImage->getUrl('preview'),
                            'small' => $prefix . $galleryImage->getUrl('small'),
                            'medium' => $prefix . $galleryImage->getUrl('medium'),
                            'original' => $prefix . $galleryImage->getUrl('original'),
                        ];
                    }
                }
                return $galleryArr;
            },
        ];
    }
}
