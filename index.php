<?php

$question = '';
$msg = '';

$messages = fopen("messages.txt", "r");
$messages2 = array();
$cnt = 0;
while (!feof($messages)){
		$messages2[$cnt] = fgets($messages);
		$cnt++;
}



$people = json_decode(file_get_contents("people.json"), true);
if(isset($_POST["person"]) && $_POST['question'] != ''){
	$en_name = $_POST["person"];
	$question=$_POST["question"];
    $msg = $messages2[intval(hash('md5', $question.$en_name))%16]; 
} else{
	$en_name = array_rand($people);
}
$fa_name = $people[$en_name];




if(!str_starts_with($question, "آیا") || (!str_ends_with($question, "?") && !str_ends_with($question, "؟"))){
	$msg = "سوال درستی پرسیده نشده";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="styles/default.css">
    <title>مشاوره بزرگان</title>
</head>
<body>
<p id="copyright">تهیه شده برای درس کارگاه کامپیوتر،دانشکده کامییوتر، دانشگاه صنعتی شریف</p>
<div id="wrapper">
    <div id="title">
        <span id="label">
		<?php
			 if ($question != '') 
			 {
				 echo "پرسش:";
			 }
		?>	
		</span>
        <span id="question"><?php echo $question ?></span>
    </div>
    <div id="container">
        <div id="message">
            <p><?php 
				if ($question != '')
					echo $msg; 
				else
					echo "سوال خود را بپرس!";
			?></p>
        </div>
        <div id="person">
            <div id="person">
                <img src="images/people/<?php echo "$en_name.jpg" ?>"/>
                <p id="person-name"><?php echo $fa_name ?></p>
            </div>
        </div>
    </div>
    <div id="new-q">
        <form method="post">
            سوال
            <input type="text" name="question" value="<?php echo $question ?>" maxlength="150" placeholder="..."/>
            را از
            <select name="person">
                <?php
				
                foreach ($people as $eng => $fa) {
						if ($eng == $en_name){							
                            echo "<option value=\"$eng\" selected>$fa</option>";
						}
                        else {
                            echo "<option value=\"$eng\" >$fa</option>";
						}
                }
				
                ?>
            </select>
            <input type="submit" value="بپرس"/>
        </form>
    </div>
</div>
</body>
</html>
