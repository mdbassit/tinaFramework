<?php

// No direct access.
defined('tinaFramework') or die;

$itemCount = count($people);

?>

<h1 class="title"><?php echo Lang::_('Addressbook'); ?></h1>
<div class="toolbar clearfix">
    <a class="button" href="index.php?view=editperson"><?php echo Lang::_('New contact'); ?></a>
    <div class="itemcount"><?php echo $itemCount . (($itemCount == 1) ? Lang::_(' person') : Lang::_(' people')); ?></div>
</div>
<table class="people">
    <tr>
        <th><?php echo Lang::_('Name'); ?></th>
        <th><?php echo Lang::_('Email'); ?></th>
        <th><?php echo Lang::_('Phone'); ?></th>
        <th class="action"><?php echo Lang::_('Action'); ?></th>
    </tr>
<?php foreach ($people as $person) { ?>
    <tr class="record">
        <td><a href="index.php?view=editperson&id=<?php echo $person->id; ?>"><?php echo $person->firstname . ' ' . $person->lastname; ?></a></td>
        <td><?php echo $person->email; ?></td>
        <td><?php echo $person->phone; ?></td>
        <td class="action">
            <a href="index.php?view=editperson&id=<?php echo $person->id; ?>"><?php echo Lang::_('Edit'); ?></a> - 
            <a href="index.php?view=editperson&action=delete&id=<?php echo $person->id; ?>" onclick="if(!confirm('<?php echo Lang::_('Are you sure you want to delete this contact?'); ?>')) return false"><?php echo Lang::_('Delete'); ?></a>
        </td>
    </tr>
<?php } ?>
</table>

