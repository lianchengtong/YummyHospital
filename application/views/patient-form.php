<?php

/* @var $this \common\extend\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $model \common\models\WebsiteConfig */

$this->title    = "就诊人";
$this->showSave = "true";
?>

<div class="ui-form ui-border-t">
    <form action="#">
        <div class="ui-form-item ui-border-b">
            <label>真实姓名</label>
            <input type="text" placeholder="真实姓名">
        </div>

        <div class="ui-form-item ui-border-b">
            <label>性别</label>
            <div class="ui-select">
                <select>
                    <option>男</option>
                    <option>女</option>
                </select>
            </div>
        </div>


        <div class="ui-form-item ui-border-b">
            <label>手机号</label>
            <input type="numer" pattern="\d*" placeholder="联系手机号">
        </div>

        <div class="ui-form-item ui-border-b">
            <label>生日</label>
            <div class="ui-select-group">
                <div class="ui-select">
                    <select>
                        <option>2014</option>
                        <option selected>2015</option>
                        <option>2016</option>
                    </select>
                </div>
                <div class="ui-select">
                    <select>
                        <option>03</option>
                        <option selected>04</option>
                        <option>05</option>
                    </select>
                </div>
                <div class="ui-select">
                    <select>
                        <option>21</option>
                        <option selected>22</option>
                        <option>23</option>
                    </select>
                </div>
            </div>
        </div>


        <div class="ui-form-item ui-border-b">
            <label>身份证号</label>
            <input type="text" placeholder="15或18位身份证号">
        </div>
    </form>
</div>

