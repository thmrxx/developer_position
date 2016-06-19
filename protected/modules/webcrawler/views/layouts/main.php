<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo \Yii::app()->name; ?></title>

    <?php
    // CSS && JS
    $cs = \Yii::app()->clientScript;
    $as = CHtml::asset(Yii::getPathOfAlias('webroot.components'));
    $cs->registerScriptFile($as . '/jquery/dist/jquery.min.js', \CClientScript::POS_HEAD);
    $cs->registerScriptFile($as . '/bootstrap/dist/js/bootstrap.js', \CClientScript::POS_HEAD);
    $cs->registerCssFile($as . '/bootstrap/dist/css/bootstrap.min.css');
    ?>

</head>
<body>
<div class="container">
    <div class="row">
        <div class="menu col-xs-12" style="margin-top: 10px;">
            <?php
            $this->widget('zii.widgets.CMenu', array(
                'items' => array(
                    array('label' => 'Поиск', 'url' => array('//webcrawler/webcrawler/index')),
                    array('label' => 'Результаты', 'url' => array('//webcrawler/webcrawler/view')),
                ),
                'htmlOptions' => [
                    'class' => 'nav nav-tabs',
                ]
            ));
            ?>
        </div>
    </div>
    <?php echo $content; ?>
</div>
<!-- /.container -->

</body>
</html>