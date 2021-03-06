<?php
/**
 * Created by PhpStorm.
 * User: MyBe
 * Date: 23.01.2017
 * Time: 20:46
 */

namespace app\models;


use yii\base\Model;
use dektrium\user\models\Profile as BaseProfile;

class Profile extends BaseProfile
{
    

    public function rules()
    {

        $rules = parent::rules();
        $rules[] = ['photo_url', 'string'];
        $rules[] = ['name', 'required'];
        $rules[] = ['name', 'string', 'min' => 3];
        $rules[] = ['name', 'filter', 'filter' => 'strip_tags'];

        return $rules;
    }

    public function getAvatarUrl($size = 200)
    {
        return $this->photo_url . '?sz=' . $size;
    }

}