<?php


// Authenticate with Ably using your API key
$apikey = 'vplq7g.EFWToA:qSCPiQrvMC_fPw5IF3U0S1gwjlkTK4BvrNch68CHmew';
$ably   = new \Ably\AblyRest($apikey);

// Publish a message with the name 'first' and the contents of your input field

  $channel = $ably->channels->get('get-started');
  $channel->publish('first', 'test');



