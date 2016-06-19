<?php
Yii::app()->clientScript->registerScriptFile('components/jquery-form/jquery.form.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile('components/jquery-form-validator/form-validator/jquery.form-validator.min.js', CClientScript::POS_END);
?>

<h1>Поиск по сайту</h1>

<form id="search-form" action="">
    <div class="form-group">
        <label class="control-label" for="form-url">URL</label>
        <input type="url"
               id="form-url"
               name="form-url"
               class="form-control"
               data-validation="url"
               placeholder="http://example.com/page.html">
    </div>
    <div class="form-group" id="div-type">
        <label class="control-label" for="form-type">Тип поиска</label>
        <select class="form-control" name="form-type" id="form-type" data-validation="required">
            <option value="" selected="selected" disabled="disabled">выберите тип</option>
            <option value="links">все ссылки</option>
            <option value="images">все изображения</option>
            <option value="text">свой текст</option>
        </select>
    </div>
    <div class="form-group" id="div-text">
        <label class="control-label" for="form-text">Поисковый запрос</label>
        <input type="text"
               id="form-text"
               name="form-text"
               class="form-control"
               data-validation="letternumeric"
               data-validation-allowing=",-_ "
               data-validation-error-msg='Значение должно содержать только числа, буквы, пробелы, "-", "," и "_"'
               placeholder="macbook pro">
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">Найти</button>
        <h3 id="form-result"></h3>

        <h3 class="text-danger" id="form-result-error"></h3>
    </div>


</form>

<script>
    $(function () {
        // validate form
        $.validate({
            form: '#search-form',
            modules: 'security',
            lang: 'ru'
        });

        $('#div-type').hide();
        $('#div-text').hide();
        $('input#form-url')
            .on('keydown', function (event) {
                $(this).validate();
            })
            .on('validation', function (evt, valid) {
                if (valid) {
                    $('#div-type').slideDown();
                } else {
                    $('#div-type').slideUp();
                }
            });
        $('select#form-type')
            .on('change', function (event) {
                if ($(this).val() == 'text') {
                    $('#div-text').slideDown();
                } else {
                    $('#div-text').slideUp();
                }
            });

        $('form#search-form').on('submit', function (e) {
            e.preventDefault(); // prevent native submit
            $(this).ajaxSubmit({
                //target: '#form-result',
                url: '<?php echo $this->createUrl('search'); ?>',
                type: 'post',
                dataType: 'json',
                beforeSubmit: function () {
                    $('#form-result').show().text('Поиск...');
                    $('#form-result-error').hide();
                },
                success: function (data) {
                    if (data.error) {
                        $('#form-result').hide();
                        $('#form-result-error').show().text(data.message);
                    } else {
                        $('#form-result-error').hide();
                        $('#form-result').show().html(data.message);
                    }
                    console.log(data);
                }
            })
        });
    });
</script>