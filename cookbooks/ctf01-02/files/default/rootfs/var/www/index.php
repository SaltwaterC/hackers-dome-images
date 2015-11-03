<p>Hi people. Post a message while I'm AFK. Say what you need. I'll check periodically to see if there's something new.</p>
<form action="/" method="post">
User:
<br>
<input type="text" name="user" size="10">
<br>
Message:
<br>
<textarea name="message" cols="50" rows="10"></textarea>
<br>
<input type="submit" name="send" value="Send">
</form>
<hr>
<?php
$messages = json_decode(file_get_contents('messages.txt'), TRUE);

if ($messages === NULL)
{
	$messages = array();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
	$messages[] = array(
		'user' => $_POST['user'],
		'message' => $_POST['message']
	);
}

file_put_contents('messages.txt', json_encode($messages));
?>
<?php foreach ($messages as $message) : ?>
<p>User: <?php echo $message['user']; ?>
<br>
Message: <?php echo $message['message']; ?></p>
<hr>
<?php endforeach; ?>

