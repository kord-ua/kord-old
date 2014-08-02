<?php defined('SYSPATH') OR die('No direct script access.') ?>

<form role="form" action="" method="post" accept-charset="<?php echo \KORD\Core::$charset ?>">
    <?php foreach ($form->getAreas() as $area): ?>
        <?php if ($area->getName()): ?>
            <fieldset>
                <legend><?php echo $area->getLabel() ?></legend>
        <?php endif ?>
        <?php foreach ($area->getElements() as $element): ?>
            <?php if ($element->getLabel()): ?>
                <label for="<?php echo $element->getName() ?>"><?php echo $element->getLabel() ?></label>
            <?php endif ?>
                <?php echo $element->render() ?>
                <?php if ($element->getErrors()): ?>
                <ul>
                    <?php foreach ($element->getErrors() as $error): ?>
                    <li><?php echo $error ?></li>
                    <?php endforeach ?>
                </ul>
                <?php endif ?>
        <?php endforeach ?>
            
        <?php if ($area->getName()): ?></fieldset><?php endif ?>
    <?php endforeach ?>
</form>
