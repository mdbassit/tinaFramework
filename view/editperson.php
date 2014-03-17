<?php

// No direct access.
defined('tinaFramework') or die;

?>

<h1 class="title"><?php echo (($person->id != '') ? 'Edit contact' : 'Add a contact'); ?></h1>

<form name="mainform" id="mainform" action="index.php" method="post">
    <fieldset>
        <div class="field required">
            <label for="firstname">First name</label><input type="text" id="firstname" name="firstname" value="<?php echo $person->firstname; ?>">
        </div>
        <div class="field required">
            <label for="lastname">Last name</label><input type="text" id="lastname" name="lastname" value="<?php echo $person->lastname; ?>">
        </div>
        <div class="field required">
            <label for="email">Email address</label><input type="text" id="email" name="email" value="<?php echo $person->email; ?>">
        </div>
        <div class="field">
            <label for="phone">Phone</label><input type="text" id="phone" name="phone" value="<?php echo $person->phone; ?>">
        </div>
        <div class="buttons">
            <a class="button" href="javascript:void(0)" onclick="document.getElementById('mainform').submit()">Save contact</a>
            <a class="button cancel" href="javascript:void(0)" onclick="window.location = 'index.php?view=people'">Cancel</a>
        </div>
    </fieldset>
    <input type="hidden" name="view" value="editperson">
    <input type="hidden" name="action" value="save">
    <input type="hidden" name="id" value="<?php echo $person->id; ?>">
</form>
