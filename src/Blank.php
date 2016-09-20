<?php
class Blank
{
    private $;

    function __construct($description)
    {
      $this->description = $description;
    }

    function set()
    {
    
    }

    function get()
    {
      return ;
    }

    function save()
    {
      $GLOBALS['DB']->exec("INSERT INTO tasks (description) VALUES ('{$this->getDescription()}');");
    }

    static function getAll()
    {
      $returned_tasks = $GLOBALS['DB']->query("SELECT * FROM tasks;");
      $tasks = array();
      foreach($returned_tasks as $task) {
          $description = $task['description'];
          $new_task = new Task($description);
          array_push($tasks, $new_task);
      }
      return $tasks;
    }
}
?>