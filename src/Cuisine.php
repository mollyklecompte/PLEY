<?php
class Cuisine
{
    private $cuisine_type;
    private $id;

    function __construct($cuisine_type, $id = null)
    {
      $this->cuisine_type = $cuisine_type;
      $this->id = $id;
    }

    function setCuisineType($new_cuisine_type)
    {
        $this->cuisine_type = (string) $new_cuisine_type;
    }

    function getCuisineType()
    {
      return $this->cuisine_type;
    }

    function getId()
    {
      return $this->id;
    }

    function save()
    {
      $GLOBALS['DB']->exec("INSERT INTO cuisines (cuisine_type) VALUES ('{$this->getCuisineType()}');");
      $this->id = $GLOBALS['DB']->lastInsertId();
    }

    static function getAll()
    {
      $returned_cuisines = $GLOBALS['DB']->query("SELECT * FROM cuisines;");
      $list_of_cuisines = array();

      foreach($returned_cuisines as $cuisine) {
          $id = $cuisine['id'];
          $cuisine_type = $cuisine['cuisine_type'];
          $new_cuisine = new Cuisine($cuisine_type, $id);
          array_push($list_of_cuisines, $new_cuisine);
      }
      return $list_of_cuisines;
    }

    static function deleteAll()
    {
        $GLOBALS['DB']->exec("DELETE FROM cuisines");
    }

    static function find($search_id)
    {
        $searched_cuisine = null;
        $list_of_cuisines = Cuisine::getAll();
        foreach($list_of_cuisines as $cuisine) {
            $cuisine_id = $cuisine->getId();
            if ($cuisine_id == $search_id) {
                $searched_cuisine = $cuisine;
            }
        }
        return $searched_cuisine;
    }

    function getRestaurants()
    {
        $restaurants = array();
        $returned_restaurants = $GLOBALS['DB']->query("SELECT * FROM restaurants WHERE cuisine_id = {$this->getId()};");
        foreach($returned_restaurants as $restaurant) {
            $restaurant_name = $restaurant['restaurant_name'];
            $id = $restaurant['id'];
            $cuisine_id = $restaurant['cuisine_id'];
            $new_restaurant = new Restaurant($restaurant_name, $id, $cuisine_id);
            array_push($restaurants, $new_restaurant);
        }
        return $restaurants;
    }
}
?>
