<?php

// No direct access.
defined('tinaFramework') or die;

/**
 * The person class is useful when creating a new person
 */
class Person
{
    public $id;
    public $firstname;
    public $lastname;
    public $email;
    public $phone;
}


/**
 * This is our people model
 */
class PeopleModel extends Model
{
    
    /**
     * Get all the people from the database
     */
	public function getPeople()
	{
        // Let's first get our database object
        $db = Database::getDB();
        
        // The query method will return a resultset when executing a SELECT statement
        $result = $db->query('SELECT * FROM `people` ORDER BY firstname');
        
        // We want to get a list of people
        $people = $db->getObjectList($result);
        
        return $people;
	}
    
    /**
     * Get one person from the database
     */
    public function getPerson($id)
	{
        // Initialize the database object
        $db = Database::getDB();
        
        // This query is going to be prepared, the parameters are going to be bound 
        // seperately to protect against SQL injection attacks. 
        // See http://www.php.net/manual/en/mysqli-stmt.prepare.php for more info
        $result = $db->query('SELECT * FROM `people` WHERE id=?', array($id));
        
        // We want a single person object
        $person = $db->getObject($result);
        
        return $person;
	}
    
    /**
     * Make sure the email address is not already in use
     */
    public function checkUniqueEmailAddress($data)
    {
        $id = $data['id'];
        $email = $data['email'];
        
        $people = $this->getPeople();
        
        foreach ($people as $person) {
            if ($id != '') {
                if (($person->email == $email) && ($person->id != $id)) return false;
            } else {
                if ($person->email == $email) return false;
            }
        }
        
        return true;
    }
    
    /**
     * Save a person in the database
     */
    public function savePerson($data)
	{
        // Get the person's id
        $id = $data['id'];
        
        // Convert the $data array to scalar variables
        foreach ($data as $key => $value)
        {
            $$key = $value;
        }
        
        // Initialize the database object
        $db = Database::getDB();
        
        // We are using the same method to save new and existing people.
        // We will just check the person's id, if it's not blank then it's an existing person
        if ($id != '') {
            $result = $db->query('UPDATE `people` SET firstname=?, lastname=?, email=?, phone=? WHERE id=?', 
                                  array($firstname, $lastname, $email, $phone, $id));
        
        // Otherwise it's a new person
        } else {
            $result = $db->query('INSERT INTO `people`(firstname, lastname, email, phone) VALUES(?, ?, ?, ?)', 
                                 array($firstname, $lastname, $email, $phone));
        }
        
        // $result will be set to FALSE if the query fails
        return $result;
	}
    
    /**
     * Delete a person from the database
     */
    public function deletePerson($id)
	{
        $db = Database::getDB();
        $result = $db->query('DELETE FROM `people` WHERE id=?', array($id));
        
        return $result;
	}
    
}
