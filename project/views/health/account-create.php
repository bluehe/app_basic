<?php
/* @var $this yii\web\View */

$this->title = '添加账号';
$this->params['breadcrumbs'][] = ['label' => '数据中心', 'url' => ['health/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="account-create">

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
