<?php


$API_URL = 'https://sawaddee.herokuapp.com/bot.php';
$ACCESS_TOKEN = 'l0QRJWB1D4gHdDPND+0Y9blpz/7abiFp0l1KdsAUd4GF4b70A9+crXGEZslp4HE9zQCG1rICub/PqYf2xBjjc1JqwZuQedOsZCyuXRnIVw5SNQht4dS1Wgt20TzoUfXqYikqdXnIBc7dIVhVD1ykHQdB04t89/1O/w1cDnyilFU='; 
$channelSecret = '36d83e50f82e2637f118af1b912ab3c4';


$POST_HEADER = array('Content-Type: application/json', 'Authorization: Bearer ' . $ACCESS_TOKEN);

$request = file_get_contents('php://input');   // Get request content
$request_array = json_decode($request, true);   // Decode JSON to Array



if ( sizeof($request_array['events']) > 0 ) {

    foreach ($request_array['events'] as $event) {

        $reply_message = '';
        $reply_token = $event['replyToken'];

        $text = $event['message']['text'];
        $data = [
            'replyToken' => $reply_token,
            // 'messages' => [['type' => 'text', 'text' => json_encode($request_array) ]]  Debug Detail message
            'messages' => [['type' => 'text', 'text' => $text ]]
        ];
        $post_body = json_encode($data, JSON_UNESCAPED_UNICODE);

        $send_result = send_reply_message($API_URL.'/reply', $POST_HEADER, $post_body);

        echo "Result: ".$send_result."\r\n";
    }
}

echo "OK";




function send_reply_message($url, $post_header, $post_body)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $post_header);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_body);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}

?>
