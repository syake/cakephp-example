<?php
    $chekbox_options = [
        'label' => __('Visible'),
        'templates' => [
            'nestingLabel' => '{{hidden}}<label class="custom-control custom-checkbox"{{attrs}}>{{input}}{{text}}</label>'
        ]
    ];
?>
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
                            'help' => __('Click the image to edit'),
                            'default' => $post->header_image_path
                        ]) . PHP_EOL ?>
                    </div>
                </section>
                <section class="boxed-group">
                    <h2><?= __('Points') ?></h2>
                    <div class="boxed-group-inner">
                        <div class="row js-sortable">
<?php $len = count($post->points); for ($i = 0; $i < $len; $i++) : ?>
                            <div class="col-lg-6 col-xl-4">
                                <div class="sortable-box">
                                    <?= $this->Form->hidden("points.{$i}.id") . PHP_EOL ?>
                                    <?= $this->Form->hidden("points.{$i}.item_order") . PHP_EOL ?>
                                    <?= $this->Form->hidden("points.{$i}.tag") . PHP_EOL ?>
                                    <?= $this->Form->control("points.{$i}.title", ['label' => __('Title'), 'class' => 'form-control-sm']) . PHP_EOL ?>
                                    <?= $this->Form->control("points.{$i}.description", ['type' => 'textarea', 'label' => __('Content'), 'class' => 'form-control-sm']) . PHP_EOL ?>
                                    <?= $this->Custom->upload("points.{$i}.image", [
                                        'indent' => 9,
                                        't' => '    ',
                                        'default' => $post->points[$i]->image_path
                                    ]) . PHP_EOL ?>
                                    <?= $this->Form->control("points.{$i}.visible", $chekbox_options) . PHP_EOL ?>
                                </div>
                            </div>
<?php endfor; ?>
                        </div>
                    </div>
                    <div class="boxed-group-inner">
                        <?= $this->Html->link(__('Add box'), '#', ['class' => 'js-add', 'data-holder' => '#holder', 'data-target' => '#new_box']) . PHP_EOL ?>
                    </div>
                </section>
                <section class="boxed-group">
                    <h2><?= __('Items') ?></h2>
                    <div class="boxed-group-inner">
                        <div class="row js-sortable">
<?php $len = count($post->items); for ($i = 0; $i < $len; $i++) : ?>
                            <div class="col-lg-6 col-xl-4">
                                <div class="sortable-box">
                                    <?= $this->Form->hidden("items.{$i}.id") . PHP_EOL ?>
                                    <?= $this->Form->hidden("items.{$i}.item_order") . PHP_EOL ?>
                                    <?= $this->Form->hidden("items.{$i}.tag") . PHP_EOL ?>
                                    <?= $this->Custom->upload("items.{$i}.image", [
                                        'indent' => 9,
                                        't' => '    ',
                                        'default' => $post->items[$i]->image_path
                                    ]) . PHP_EOL ?>
                                    <?= $this->Form->control("items.{$i}.visible", $chekbox_options) . PHP_EOL ?>
                                </div>
                            </div>
<?php endfor; ?>
                        </div>
                    </div>
                    <div class="boxed-group-inner">
                        <?= $this->Html->link(__('Add box'), '#', ['class' => 'js-add', 'data-holder' => '#holder', 'data-target' => '#new_box']) . PHP_EOL ?>
                    </div>
                </section>