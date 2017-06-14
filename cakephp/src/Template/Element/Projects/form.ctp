                <section class="boxed-group">
                    <h2><?= __('Content') ?></h2>
                    <div class="boxed-group-inner">
                        <?= $this->Form->control('title', ['label' => __('Title')]) . PHP_EOL ?>
                        <?= $this->Form->control('content', ['type' => 'textarea', 'label' => __('Content'), 'class' => 'js-content-field']) . PHP_EOL ?>
                    </div>
                </section>
                <section class="boxed-group">
                    <h2><?= __('Header Image') ?></h2>
                    <div class="boxed-group-inner">
                        <?= $this->Custom->upload('header_image', [
                            'indent' => 6,
                            't' => '    ',
                            'default' => $post->header_image_path
                        ]) . PHP_EOL ?>
                    </div>
                </section>
                <section class="boxed-group">
                    <h2><?= __('Sections') ?></h2>
<?php $len = count($post->sections); for ($i = 0; $i < $len; $i++) : ?>
                    <div class="boxed-group-inner">
                        <div class="row section-box">
                            <div class="col-lg-6">
                                <?= $this->Form->hidden("sections.{$i}.section_id") . PHP_EOL ?>
                                <?= $this->Form->hidden("sections.{$i}.item_order") . PHP_EOL ?>
                                <?= $this->Form->hidden("sections.{$i}.tag") . PHP_EOL ?>
                                <?= $this->Form->control("sections.{$i}.title", ['label' => __('Title')]) . PHP_EOL ?>
                                <?= $this->Form->control("sections.{$i}.description", ['type' => 'textarea', 'label' => __('Content')]) . PHP_EOL ?>
                            </div>
                            <div class="col-lg-6">
                                <?= $this->Custom->upload("sections.{$i}.image", [
                                    'indent' => 8,
                                    't' => '    ',
                                    'default' => $post->sections[$i]->image_path
                                ]) . PHP_EOL ?>
                            </div>
                        </div>
                    </div>
<?php endfor; ?>
                    <div class="boxed-group-inner">
                        <?= $this->Html->link(__('Add box'), '#', ['class' => 'js-add', 'data-holder' => '#holder', 'data-target' => '#new_box']) . PHP_EOL ?>
                    </div>
                </section>
