<?php
class information
{
   // Instance attributes
   private $name         = array('FIRST'=>"", 'LAST'=>null);
  private $street  = "";
   private $state   = "";
   private $zip = 0;
   private $city    = "";

   function name()
   {
     // string name()
     if( func_num_args() == 0 ) // number of string pass to function
     {
       if( empty($this->name['FIRST']) ) return $this->name['LAST'];
       else                              return $this->name['LAST'].', '.$this->name['FIRST'];
     }

     // void name($value)
     else if( func_num_args() == 1 )
     {
       $value = func_get_arg(0); //

       if( is_string($value) ) // check if it is a string
       {
         $value = explode(',', $value); // convert string to array

         if ( count($value) >= 2 ) $this->name['FIRST'] = htmlspecialchars(trim($value[1]));
         else                      $this->name['FIRST'] = '';

         $this->name['LAST']  = htmlspecialchars(trim($value[0]));
       }

       else if( is_array ($value) )
       {
         if ( count($value) >= 2 ) $this->name['LAST'] = htmlspecialchars(trim($value[1]));
         else                      $this->name['LAST'] = '';

         $this->name['FIRST']  = htmlspecialchars(trim($value[0]));
       }
     }

     // void name($first_name, $last_name)
     else if( func_num_args() == 2 )
     {
         $this->name['FIRST'] = htmlspecialchars(trim(func_get_arg(0)));
         $this->name['LAST']  = htmlspecialchars(trim(func_get_arg(1)));
     }

     return $this;
   }



function street()
   {
     // int assists()
     if( func_num_args() == 0 )
     {
       return $this->street;
     }

     // void assists($value)
     else if( func_num_args() == 1 )
     {
       $this->street = (string)func_get_arg(0);
     }

     return $this;
   }








   // rebounds() prototypes:
   //   int rebounds()               returns the number of rebounds taken.
   //
   //   void rebounds(int $value)    set object's $rebounds attribute
   function state()
   {
     // int rebounds()
     if( func_num_args() == 0 )
     {
       return $this->state;
     }

     // void rebounds($value)
     else if( func_num_args() == 1 )
     {
       $this->state = htmlspecialchars(trim(func_get_arg(0)));
     }

     return $this;
   }

   function city()
   {
     // int rebounds()
     if( func_num_args() == 0 )
     {
       return $this->city;
     }

     // void rebounds($value)
     else if( func_num_args() == 1 )
     {
       $this->city = htmlspecialchars(trim(func_get_arg(0)));
     }

     return $this;
   }



   function zip()
   {
     // int rebounds()
     if( func_num_args() == 0 )
     {
       return $this->zip;
     }

     // void rebounds($value)
     else if( func_num_args() == 1 )
     {
       $this->zip = (int)func_get_arg(0);
     }

     return $this;
   }


   function __construct($name="", $street="", $city=null, $state=null, $zip=0)
   {
     // if $name contains at least one tab character, assume all attributes are provided in
     // a tab separated list.  Otherwise assume $name is just the player's name.


     // delegate setting attributes so validation logic is applied
     $this->name($name);
     $this->street($street);
     $this->city($city);
     $this->state($state);
     $this->zip($zip);
   }








   function __toString()
   {
     return (var_export($this, true));
   }








   // Returns a tab separated value (TSV) string containing the contents of all instance attributes
   function toTSV()
   {
       return implode("\t", [$this->name(), $this->street(), $this->city(), $this->state(), $this->zip()]);
   }








   // Sets instance attributes to the contents of a string containing ordered, tab separated values
   function fromTSV(string $tsvString)
   {
     // assign each argument a value from the tab delineated string respecting relative positions
     list($name, $street, $city, $state, $zip) = explode("\t", $tsvString);
     $this->name($name);
     $this->street($street);
     $this->city($city);
     $this->state($state);
     $this->zip($zip);
   }
} // end class PlayerStatistic

?>
