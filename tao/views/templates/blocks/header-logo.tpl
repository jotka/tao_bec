<?php 
use oat\tao\helpers\Layout;
/* alpha|beta|sandbox message */
$releaseMsgData = Layout::getReleaseMsgData();
if($releaseMsgData['link']):?>
    <a href="http://54.37.234.90" title="BEC TAO" class="lft">
    <?php else:?>
        <div class="lft">
        <?php endif;?>
        <img src="<?=$releaseMsgData['logo']?>" alt="TAO Logo" id="tao-main-logo"/>
        <?php if($releaseMsgData['link']):?>
    </a>
<?php else:?>
    </div>
<?php endif;?>