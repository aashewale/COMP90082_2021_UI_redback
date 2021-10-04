<?php

ini_set('set_time_limit', 6000);
//#var_dump($_POST);
$temp = $_POST['post_content'];
//
//echo $temp;
$handle = popen('/Users/alishashewale/opt/anaconda3/bin/python python.py '.$temp, 'r');
$input = fread($handle, 2048);
echo $input;
// if ( is_numeric(strpos($input, 'Final text'))){
// echo substr($input, strpos($input, 'Final text'));
// }
// else{
//     echo "No text found";
// }

//var_dump($input);
pclose($handle);

//$input = 'Today is a very very special day!! You know why??? Because it is the Birthday of this amazing lady!!! Mum Theodosia Green you give me strength I never knew I had, you support me through every dumb idea(theres been a few), every challenge, every sadness. You celebrate every achievement and success with me. I could not have asked for a better mum for me, I love you more than words can say. I am so proud of you, your journey has had a lot of highs and lows but you are 1 of the strongest women I know and can do anything you set your mind too!! You are so loving and generous. I hope today brings you as much joy as watching fail videos bring you (she loves them). I am so proud and honoured to call you my mum. Happy Birthday. Final Text';

?>