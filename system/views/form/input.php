<?php defined('SYSPATH') OR die('No direct script access.') ?>

<?php if ($element->isMultilingual()): ?>
    <?php foreach ($element->getLanguages() as $language):  ?>
        <?php echo $language ?> <input type="<?php echo $element->getType() ?>" name="<?php echo $element->getName() ?>[<?php echo $language ?>]" value="<?php echo \KORD\Helper\Arr::get($element->getValue(),$language) ?>"/><br/>
    <?php endforeach ?>
<?php else: ?>
    <input type="<?php echo $element->getType() ?>" name="<?php echo $element->getName() ?>" value="<?php echo $element->getValue() ?>"/><br/>
<?php endif ?>