<?php
class Restaurant
{
    private $restaurant_name;
    private $id;
    private $cuisine_id;


    function __construct($restaurant_name, $id = null, $cuisine_id)
    {
      $this->restaurant_name = $restaurant_name;
      $this->id = $id;
      $this->cuisine_id = $cuisine_id;
    }

    function setRestaurantName($new_restaurant_name)
    {
        $this->restaurant_name = $new_restaurant_name;
    }

    function getRestaurantName()
    {
      return $this->restaurant_name;
    }

    function getId()
    {
      return $this->id;
    }

    function getCuisineId()
    {
      return $this->cuisine_id;
    }

    function save()
    {
      $GLOBALS['DB']->exec("INSERT INTO restaurants (restaurant_name, cuisine_id) VALUES ('{$this->getRestaurantName()}', {$this->getCuisineId()});");
      $this->id = $GLOBALS['DB']->lastInsertId();
    }

    static function getAll()
    {
      $returned_restaurants = $GLOBALS['DB']->query("SELECT * FROM restaurants;");
      $list_of_restaurants = array();
      foreach($returned_restaurants as $restaurant) {
          $id = $restaurant['id'];
          $cuisine_id = $restaurant['cuisine_id'];
          $restaurant_name = $restaurant['restaurant_name'];
          $new_restaurant = new Restaurant($restaurant_name, $id, $cuisine_id);
          array_push($list_of_restaurants, $new_restaurant);
      }
      return $list_of_restaurants;
    }

    static function deleteAll()
    {
        $GLOBALS['DB']->exec("DELETE FROM restaurants");
    }

    static function find($search_id)
    {
        $searched_restaurant = null;
        $list_of_restaurants = Restaurant::getAll();
        foreach($list_of_restaurants as $restaurant) {
            $restaurant_id = $restaurant->getId();
            if ($restaurant_id == $search_id) {
                $searched_restaurant = $restaurant;
            }
        }
        return $searched_restaurant;
    }

    function findMatch($search)
    {
        $restaurants = Restaurant::getAll();
        $match = "";
        foreach($restaurants as $restaurant){
            if($restaurant->restaurant_name == $search) {
                break;
            }
        }
        return $restaurant;
    }
}
?>
