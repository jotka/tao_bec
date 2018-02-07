<?php
/**
 * This configuration file instantiates the service aiming at
 * retrieving/persisting information about the organization operating
 * the TAO Platform.
 */

return new oat\tao\model\OperatedByService(array(
    'operatedByName' => 'BEC',
    'operatedByEmail' => 'jkrochmalski@gmail.com'
));
