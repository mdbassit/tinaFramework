<?php

// No direct access.
defined('tinaFramework') or die;

$itemCount = count($people);

?>

<h1 class="title">Addressbook</h1>
<div class="toolbar clearfix">
    <a class="button" href="index.php?view=editperson">New contact</a>
    <div class="itemcount"><?php echo $itemCount . (($itemCount == 1) ? ' person' : ' people'); ?></div>
</div>
<table class="people">
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th class="action">Action</th>
    </tr>
<?php foreach ($people as $person) { ?>
    <tr class="record">
        <td><a href="index.php?view=editperson&id=<?php echo $person->id; ?>"><?php echo $person->firstname . ' ' . $person->lastname; ?></a></td>
        <td><?php echo $person->email; ?></td>
        <td><?php echo $person->phone; ?></td>
        <td class="action">
            <a href="index.php?view=editperson&id=<?php echo $person->id; ?>">Edit</a> - 
            <a href="index.php?view=editperson&action=delete&id=<?php echo $person->id; ?>" onclick="if(!confirm('Are you sure you want to delete this contact?')) return false">Delete</a>
        </td>
    </tr>
<?php } ?>
</table>

