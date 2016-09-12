<?php
    require_once "src/Blank.php";
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