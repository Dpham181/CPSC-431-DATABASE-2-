<!DOCTYPE html>
<html>
  <head>
    <title>CPSC 431 HW-3</title>
  </head>
  <body>
    <h1 style="text-align:center">Cal State Fullerton Basketball Statistics</h1>

    <?php
      require_once('Address.php');
      require_once('PlayerStatistic.php');
      require_once('config.php');
      // Connect to database

      /* Attempt to connect to MySQL database */
      $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

      // Check connection
      if($link === false){
          die("ERROR: Could not connect. " . mysqli_connect_error());
      }
      // if connection was successful
        // Build query to retrieve player's name, address, and averaged statistics from the joined Team Roster and Statistics tables
        // Prepare, execute, store results, and bind results to local variables
        $sql= "SELECT
          teamroster.ID,
          teamroster.Name_First,
          teamroster.Name_Last,
          teamroster.Street,
          teamroster.City,
          teamroster.State,
          teamroster.Country,
          teamroster.ZipCode,

          COUNT(statistics.Player) AS Gameplayed,
          AVG(statistics.PlayingTimeMin),
          AVG(statistics.PlayingTimeSec),
          AVG(statistics.Points),
          AVG(statistics.Assists),
          AVG(statistics.Rebounds)

          FROM teamroster LEFT JOIN statistics ON
          statistics.Player = teamroster.ID

          GROUP BY
          teamroster.Name_Last,
          teamroster.Name_First
          ORDER BY
          teamroster.Name_Last,
          teamroster.Name_First

          ";

      $stmt = $link->prepare($sql);
      $stmt -> execute();
      $stmt->store_result();
      $stmt->bind_result(
        $ID,
        $Name_First,
        $Name_Last,
        $Street,
        $City,
        $State,
        $Country,
        $ZipCode,
        $Gameplayed,
        $PlayingTimeMin,
        $PlayingTimeSec,
        $Points,
        $Assists,
        $Rebounds
      );



    ?>

    <table style="width: 100%; border:0px solid black; border-collapse:collapse;">
      <tr>
        <th style="width: 40%;">Name and Address</th>
        <th style="width: 60%;">Statistics</th>
      </tr>
      <tr>
        <td style="vertical-align:top; border:1px solid black;">
          <!-- FORM to enter Name and Address -->
          <form action="processAddressUpdate.php" method="post">
            <table style="margin: 0px auto; border: 0px; border-collapse:separate;">
              <tr>
                <td style="text-align: right; background: lightblue;">First Name</td>
                <td><input type="text" name="firstName" value="" size="35" maxlength="250"/></td>
              </tr>

              <tr>
                <td style="text-align: right; background: lightblue;">Last Name</td>
               <td><input type="text" name="lastName" value="" size="35" maxlength="250"/></td>
              </tr>

              <tr>
                <td style="text-align: right; background: lightblue;">Street</td>
               <td><input type="text" name="street" value="" size="35" maxlength="250"/></td>
              </tr>

              <tr>
                <td style="text-align: right; background: lightblue;">City</td>
                <td><input type="text" name="city" value="" size="35" maxlength="250"/></td>
              </tr>

              <tr>
                <td style="text-align: right; background: lightblue;">State</td>
                <td><input type="text" name="state" value="" size="35" maxlength="100"/></td>
              </tr>

              <tr>
                <td style="text-align: right; background: lightblue;">Country</td>
                <td><input type="text" name="country" value="" size="20" maxlength="250"/></td>
              </tr>

              <tr>
                <td style="text-align: right; background: lightblue;">Zip</td>
                <td><input type="text" name="zipCode" value="" size="10" maxlength="10"/></td>
              </tr>

              <tr>
               <td colspan="2" style="text-align: center;"><input type="submit" value="Add Name and Address" /></td>
              </tr>
            </table>
          </form>
        </td>

        <td style="vertical-align:top; border:1px solid black;">
          <!-- FORM to enter game statistics for a particular player -->
          <form action="processStatisticUpdate.php" method="post">
            <table style="margin: 0px auto; border: 0px; border-collapse:separate;">
              <tr>
                <td style="text-align: right; background: lightblue;">Name (Last, First)</td>
<!--            <td><input type="text" name="name" value="" size="50" maxlength="500"/></td>  -->
                <td><select name="name_ID" required>
                  <option value="" selected disabled hidden>Choose player's name here</option>
                  <?php

                    // for each row of data returned,
                    //   construct an Address object providing first and last name
                    //   emit an option for the pull down list such that
                    //     the displayed name is retrieved from the Address object
                    //     the value submitted is the unique ID for that player
                    // for example:
                    //     <option value="101">Duck, Daisy</option>

                    while($stmt->fetch()){
                     $selectplayer= new information([$Name_First,$Name_Last]);
                      echo "<option value=\"$ID\">".$selectplayer->name()."</option>";
                    }

                    $stmt->data_seek(0);
                  ?>

                </select></td>
              </tr>

              <tr>
                <td style="text-align: right; background: lightblue;">Playing Time (min:sec)</td>
               <td><input type="text" name="time" value="" size="5" maxlength="5"/></td>
              </tr>

              <tr>
                <td style="text-align: right; background: lightblue;">Points Scored</td>
               <td><input type="text" name="points" value="" size="3" maxlength="3"/></td>
              </tr>

              <tr>
                <td style="text-align: right; background: lightblue;">Assists</td>
                <td><input type="text" name="assists" value="" size="2" maxlength="2"/></td>
              </tr>

              <tr>
                <td style="text-align: right; background: lightblue;">Rebounds</td>
                <td><input type="text" name="rebounds" value="" size="2" maxlength="2"/></td>
              </tr>

              <tr>
               <td colspan="2" style="text-align: center;"><input type="submit" value="Add Statistic" /></td>
              </tr>
            </table>
          </form>
        </td>
      </tr>
    </table>


    <h2 style="text-align:center">Player Statistics</h2>

    <?php
    echo "<p>Number of Player found: ".$stmt->num_rows."</p>";
    ?>

    <table style="border:1px solid black; border-collapse:collapse;">
      <tr>
        <th colspan="1" style="vertical-align:top; border:1px solid black; background: lightgreen;"></th>
        <th colspan="2" style="vertical-align:top; border:1px solid black; background: lightgreen;">Player</th>
        <th colspan="1" style="vertical-align:top; border:1px solid black; background: lightgreen;"></th>
        <th colspan="4" style="vertical-align:top; border:1px solid black; background: lightgreen;">Statistic Averages</th>
      </tr>
      <tr>
        <th style="vertical-align:top; border:1px solid black; background: lightgreen;"></th>
        <th style="vertical-align:top; border:1px solid black; background: lightgreen;">Name</th>
        <th style="vertical-align:top; border:1px solid black; background: lightgreen;">Address</th>

        <th style="vertical-align:top; border:1px solid black; background: lightgreen;">Games Played</th>
        <th style="vertical-align:top; border:1px solid black; background: lightgreen;">Time on Court</th>
        <th style="vertical-align:top; border:1px solid black; background: lightgreen;">Points Scored</th>
        <th style="vertical-align:top; border:1px solid black; background: lightgreen;">Number of Assists</th>
        <th style="vertical-align:top; border:1px solid black; background: lightgreen;">Number of Rebounds</th>
      </tr>
      <?php
      $row_number=0;

        // now we fetch the array table with contain all the information about player and static that get from the query.
        while($stmt->fetch()){
          // contruct player (name and information )

          $player = new information([$Name_First,$Name_Last], $Street,
            $City,
            $State,
            $Country,
            $ZipCode);
            // contruct static with name, time , point, assit ,rebounds
          $static = new PlayerStatistic([$Name_First,$Name_Last],[$PlayingTimeMin,$PlayingTimeSec],
                $Points,
                $Assists,
                $Rebounds);
                // contruct table for player rows and columns
          echo "<tr>\n";
          echo "<td style='vertical-align:top; border:1px solid black;'>". ++$row_number ."</td>\n" ;

          echo "<td  style='vertical-align:top; border:1px solid black;'>". $player->Name() ."</td>\n";
          // if zipcode return 0 for echo so leaving as empty string
          if($player->ZipCode() == 0){
            echo "<td  style='vertical-align:top; border:1px solid black;'>". $player->street() .
                        " , ". $player->city().
                        " , " . $player->state().
                        " , " . $player->country().
                        "</td>\n";

          }
          else
          echo "<td  style='vertical-align:top; border:1px solid black;'>". $player->street() .
                      " , ". $player->city().
                      " , " . $player->state().
                      " , " . $player->ZipCode().
                      " , " . $player->country().

          "</td>\n";
          echo "<td style='vertical-align:top; border:1px solid black;'>". $Gameplayed."</td>\n";
          // a play has
          if($Gameplayed<1){
            echo "<td  style='border:1px solid black; border-collapse:collapse; background: gray;'></td>";
            echo "<td  style='border:1px solid black; border-collapse:collapse; background: gray;'></td>";
            echo "<td  style='border:1px solid black; border-collapse:collapse; background: gray;'></td>";
            echo "<td  style='border:1px solid black; border-collapse:collapse; background: gray;'></td>";

          }
              else {
                echo "<td style='vertical-align:top; border:1px solid black;'> ". $static->playingTime() ."</td>\n";
                echo "<td style='vertical-align:top; border:1px solid black;'>". $static->pointsScored() ."</td>\n";
                echo "<td style='vertical-align:top; border:1px solid black;'>". $static->Assists() ."</td>\n";
                echo "<td style='vertical-align:top; border:1px solid black;'>". $static->rebounds() ."</td>\n";
                  }

          echo "</tr>";

}

        $stmt->free_result();
        $link->close();

      ?>

    </table>

  </body>
</html>
