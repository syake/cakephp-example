            <section class="boxed-group">
                <h2><?= __('Content') ?></h2>
                <div class="boxed-group-inner">
                    <?= $this->Form->control('title', ['label' => __('Title')]) ?>
                    <?= $this->Form->control('content', ['type' => 'textarea', 'label' => __('Content'), 'class' => 'js-content-field']) ?>
                </div>
            </section>
