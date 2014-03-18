<?php

// No direct access.
defined('tinaFramework') or die;

/**
 * Edit a person controller
 */
class EditPersonController extends Controller
{
    /**
     * The display method is the default method in a controller
     */
	public function display()
	{
        $request = new Request();
        $session = new Session();
        $model = $this->getModel('people');
        
        $id = $request->getVar('id');
        
        // If the person id is set then we are editing an existing person
        if ($id != '') {
            $person = $model->getPerson($id);
            // Let's make sure the person actually exists
            if (($person->id == '')) {
                $this->redirect('index.php');
                exit;
            }
        // Otherwise it's a new person
        } else {
            $person = new Person;
            // If an error is detect, get the person from the saved session data
            if ($request->getVar('error') == '1') $person = $session->getSessionData();
        }
        
        // Assign $person to the view
        $this->assign('person', $person);
        
        // Display the view
        $this->displayView();
	}
    
    /**
     * Save a person
     */
    public function save()
	{
        $request = new Request();
        $session = new Session();
        $data = $request->getVars('post');
        $id = $request->getVar('id');
        
        // Let's make sure the required fields are not blank
        if (($data['firstname'] == '') || ($data['lastname'] == '') || ($data['email'] == '')) {
            $session->saveSessionData($data);
            $this->redirect('index.php?view=editperson&error=1' . (($id != '') ? '&id=' . $id : ''), 'The fields "First name", "Last name" and "Email address" are required !', 'warning');
            exit;
        }
        
        $model = $this->getModel('people');
        
        // We want to avoid duplicate email addresses
        $unique = $model->checkUniqueEmailAddress($data);
        
        if (!$unique) {
            $data['email'] = '';
            $session->saveSessionData($data);
            $this->redirect('index.php?view=editperson&error=1' . (($id != '') ? '&id=' . $id : ''), 'The email address is already in use !', 'warning');
            exit;
        }
        
        // All is good so far. Let's save the person
        $result = $model->savePerson($data);
        
        if ($result) {
            $this->redirect('index.php?view=people', 'The contact was saved successfully!');
        } else {
            $this->redirect('index.php?view=people', 'An error occured while saving the contact!', 'warning');
        }
	}
    
    /**
     * Delete a person
     */
    public function delete()
	{
        $request = new Request();
        $id = $request->getVar('id');
        
        $model = $this->getModel('people');
        $person = $model->getPerson($id);
        $result = $model->deletePerson($person->id);
        
        if ($result) {
            $this->redirect('index.php?view=people', 'The contact was deleted successfully!');
        } else {
            $this->redirect('index.php?view=people', 'An error occured while deleting the contact!', 'warning');
        }
	}
}

