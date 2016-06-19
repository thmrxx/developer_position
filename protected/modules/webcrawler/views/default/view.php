<h1>Результаты поиска</h1>

<?php if (isset($results) && $results): ?>

    <div class="row">
        <div class="col-sm-12 col-md-6" id="view-item"></div>
        <div class="col-sm-12 col-md-6">
            <table class="table table-condensed">
                <th>#</th>
                <th>URL запрос</th>
                <th>Тип</th>
                <th>Найдено</th>
                <?php foreach ($results as $res) {
                    echo CHtml::openTag('tr');
                    echo CHtml::tag('td', [], $res->id);
                    echo CHtml::tag('td', [], CHtml::link($res->url, '#', ['class' => 'show-results-link', 'data-id' => $res->id]));
                    echo CHtml::tag('td', [], $res->type);
                    echo CHtml::tag('td', [], $res->count);
                    echo CHtml::closeTag('tr');
                } ?>
            </table>
        </div>

    </div>

    <script>
        $(function () {
            $('.show-results-link').click(function () {
                var id = $(this).attr('data-id');
                $.ajax({
                    url: '<?php echo $this->createUrl('viewItem'); ?>',
                    data: {id: id},
                    type: 'post',
                    success: function (html) {
                        $('#view-item').html(html);
                    }
                });

                return false;
            });
        });
    </script>

<?php else: ?>
    <h3>Нет результатов поиска. <?php echo CHtml::link('Найдите что-нибудь', $this->createUrl('index')); ?></h3>
<?php endif; ?>
