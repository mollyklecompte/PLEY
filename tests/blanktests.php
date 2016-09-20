<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Blank.php";
    
    $server = 'mysql:host=localhost;dbname=to_do_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);
    class blankTests extends PHPUnit_Framework_TestCase
    {
        function test()
        {
            $test = new Test;
            $input = "";
            $output = $test->testFunction($input);
            $this->assertEquals("", $output);
        }

    }
?>  