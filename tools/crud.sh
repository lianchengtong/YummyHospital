#!/bin/bash


# sh tools/crud User user\\Index

CLASS=$1
CONTROLLER=$2
VIEW=$3

php yii gii/crud --modelClass="common\models\\$CLASS" --searchModelClass="common\models\search\\$CLASS" --controllerClass="application\modules\manage\controllers\\${CONTROLLER}Controller" --viewPath="@application/modules/manage/views/${VIEW}" --template="custom"
