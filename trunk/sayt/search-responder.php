<?php
  // Search-as-you-type sample Ajax responder
  //
  // Copyright 2006-7 Google Inc. All rights reserved.
  //
  // Author: mwichary@google.com (Marcin Wichary)

  // Adding a cache control so that browsers won't cache Ajax requests
  header("Cache-Control: no-cache"); 
  header("Content-Type: text/html; charset=UTF-8");

  /**
   * Get the sample data from the text file.
   * @return array Loaded data
   */ 
  function GetData() {
    $data = array();
    $file = file("test-data.txt");

    foreach($file as $record) {
      $record = explode("|", trim($record));

      if (count($record) == 4) { // Ignore invalid lines
        $data[] = $record;
      }
    }

    return $data;
  }

  /**
   * Get the results based on user's query.
   * @param string $query Query
   * @param array $data Sample data
   * @return array Result array
   */ 
  function GetResults($query, $data) {
    $results = array();
    $queryLength = strlen($query);
    foreach ($data as $record) {
      if (substr(strtolower($record[0]), 0, $queryLength) == $query) {
        $result = array();
        $result['name'] = $record[0];
        $result['type'] = $record[1];
        $result['content'] = $record[2];
        $result['moreDetailsUrl'] = $record[3];
        $result['style'] = 
          ($query == strtolower($record[0])) ? 'expanded' : 'normal';

        $results[] = $result;
      }
    }
    return $results;
  }

  // Get the data and the query
  $data = GetData();
  $query = strtolower(ltrim($_GET['query']));
 
  // Build response
  $response = array();
  $response['query'] = $query;
  $response['results'] = GetResults($query, $data);
  if (count($response['results']) == 1) {
    $response['autocompletedQuery'] = $response['results'][0]['name'];
  }

  // Output response
  echo "searchAsYouType.handleAjaxResponse(";
  echo json_encode($response);
  echo ");";
?>
