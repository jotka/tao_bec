<?php
use oat\tao\helpers\Layout;
use oat\tao\helpers\Template;
?>
<footer class="dark-bar">
    <div class="lft">
        © 2018
    </div>
    <div class="rgt">
        <?php $operatedByData = Layout::getOperatedByData();
        if (! empty($operatedByData['name'])): ?>
            <?= __('Operated By ') ?>
            <?php if (! empty($operatedByData['email'])): ?>
                <a href="<?= $operatedByData['email'] ?>"><?= $operatedByData['name'] ?></a>
            <?php else: ?>
                <?= $operatedByData['name'] ?>
            <?php endif; ?>
        <?php endif; ?>
    </div>

</footer>
<?php Template::inc('blocks/careers-js.tpl', 'tao'); ?>
