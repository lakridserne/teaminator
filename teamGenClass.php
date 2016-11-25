<?php
/**
* Coding Pirates Teaminator
* Used to generate teams at Coding Pirates Game Jam 2015-2016
*/
class teamGen {
  private $db;

  function __construct($db) {
    $this->db = $db;
  }

  function genTeam($amount,$minage,$maxage,$designers,$visualtext,$ultra,$team_ID=false) {
    // generate team
    // first see if there enough people to generate a team of selected size in
    // the selected age group
    if($ultra != 1) {
      $sql = "SELECT * FROM participants WHERE age BETWEEN :minage AND :maxage AND teaminated=0 AND updated_since_csv=1";
    } else {
      $sql = "SELECT * FROM participants WHERE age BETWEEN :minage AND :maxage AND teaminated=0 AND updated_since_csv=1 AND ultra=1";
    }
    $ages = [
      [":minage",$minage],
      [":maxage",$maxage]
    ];
    $possibleCandidates = $this->db->query($sql,$ages);
    $numresults = count($possibleCandidates);
    if($numresults >= $amount) {
      // Yay! Enough! Go ahead and pull the list of candidates from the DB
      $sortedResult = $this->sortInterests($possibleCandidates,$designers,$visualtext,$amount,$numresults);
      // Put people in DB
      if($team_ID != false) {
        $next_team_ID = $team_ID;
      } else {
        $sql = "SELECT team_ID FROM team ORDER BY team_ID DESC LIMIT 1";
        $nextid = $this->db->query($sql);
        $next_team_ID = $nextid['0']["team_ID"] + 1;
      }
      $sql = "INSERT INTO team (team_ID,participants_ID) VALUES (:team_ID, :participants_ID)";
      $fetch_name = "SELECT name FROM participants WHERE ID=:id";
      $update_teaminate = "UPDATE participants SET teaminated=1 WHERE ID=:id";
      foreach($sortedResult as $team_member) {
        $values = [
          [":team_ID",$next_team_ID],
          [":participants_ID",$team_member]
        ];
        $this->db->query($sql,$values);
        $name_values = [
          [":id",$team_member]
        ];
        $this->db->query($update_teaminate,$name_values);
        $memberArray[] = $this->db->query($fetch_name,$name_values);
      }
      return $memberArray;
    } else {
      echo "Ikke nok deltagere der er mellem " . $minage . " og " . $maxage . " &aring;r.";
    }
  }

  // Sort based on interests
  private function sortInterests($resultset,$designers,$visualtext,$teamsize,$numresults) {
    // Find number of programmers we need and iterate over them
    $programmers = $teamsize - $designers;
    $selectedPeople = array();
    $match = 0;
    $selectedPeopleNum = 0;
    while($selectedPeopleNum < $programmers) {
      $randnum = rand(0,($numresults-1));
      $id = $resultset[$randnum]['ID'];
      if($resultset[$randnum][$visualtext] == 1) {
        // Programmer found, yay! Add ID to return array if it's not already selected
        foreach($selectedPeople as $person) {
          if($id == $person) {
            $match = 1;
          }
        }
        if($match == 0) {
          $selectedPeople[] = $id;
          $selectedPeopleNum++;
        }
      }
      $match = 0;
    }

    // now repeat the success for designers
    $match = 0;
    while($selectedPeopleNum < $teamsize) {
      $randnum = rand(0,($numresults-1));
      $id = $resultset[$randnum]['ID'];
      if($resultset[$randnum]['graphic'] == 1) {
        // Designer found! Add ID to array
        foreach($selectedPeople as $person) {
          if($id == $person) {
            $match = 1;
          }
        }
        if($match == 0) {
          $selectedPeople[] = $id;
          $selectedPeopleNum++;
        }
      }
      $match = 0;
    }
    return $selectedPeople;
  }
}
?>
