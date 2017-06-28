<?php
    $this->assign('title', '403 Forbidden');
?>
<div class="content error-content">
    <?= $this->Flash->render() ?>
    <h1>403<small><?= __('Forbidden') ?></small></h1>
    <p><?= __('Access to this resource on the server is denied!') ?></p>
</div>
