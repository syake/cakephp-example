            <section class="boxed-group">
                <h2><?= __('Content') ?></h2>
                <div class="boxed-group-inner">
                    <?= $this->Form->control('title', ['label' => __('Title')]) ?>
                    <?= $this->Form->control('content', ['type' => 'textarea', 'label' => __('Content'), 'class' => 'js-content-field']) ?>
                </div>
            </section>
            <section class="boxed-group">
                <h2><?= __('Header Image') ?></h2>
                <div class="boxed-group-inner">
                    <?php
                      if (!empty($post->header_image)) {
                          $header_attr = ' data-default="' . $image_path . $post->header_image . '"';
                      } else {
                          $header_attr = '';
                      }
                    ?>
                    <div class="upload js-upload" id="header_image"<?= $header_attr ?>>
                        <div class="upload-empty">
                            <div class="upload-empty-container">
                                <div class="upload-empty-inner">
                                    <?= $this->Form->hidden('header_image_temp', ['class' => 'temp', 'value' => 0]) ?>
                                    <?= $this->Form->file('header_image[]') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?= $this->Form->error('header_image') ?>
                    <p class="upload-doc"><?= __('Click the image to edit') ?></p>
                    <?= $this->Html->link(__('Remove Header Image'), '#', ['class' => 'js-upload-delete', 'data-target' => '#header_image']) ?>
                </div>
            </section>
