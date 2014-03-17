<?php

// No direct access.
defined('tinaFramework') or die;

/**
 * The people controller
 */
class PeopleController extends Controller
{
    // This is set to the view name by index.php
	public $view;
	
    /**
     * The display method is the default method in a controller
     */
	public function display()
	{
        // Get the people model
        $model = $this->getModel('people');
        
        // Get the people list from the model
        $people = $model->getPeople();
        
        // Assign $people to the view
        $this->assign('people', $people);
        
        // Display the view
        $this->displayView($this->view);
	}
}
