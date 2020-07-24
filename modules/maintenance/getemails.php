<?php
 
$mailbox = '{mail.webpage-company.com:143/notls}';
$username = 'crm@webpage-company.com';
$password = 'dukenu11';
 
$imapResource = imap_open($mailbox, $username, $password);

$mboxCheck = imap_check($imapResource);
$totalMessages = $mboxCheck->Nmsgs;
echo $totalMessages . '<br><br><br>';
if($imapResource === false){
    throw new Exception(imap_last_error());
}

$search = 'SINCE "' . date("j F Y", strtotime("-7 years")) . '"';
$emailData = imap_search($imapResource, $search);

if (! empty($emailData)) {
$i = 1;
foreach ($emailData as $emailIdent) {

	$overview = imap_fetch_overview($imapResource, $i, 0);
	$body = imap_fetchbody($imapResource, $i, '1.1');
	$header = imap_headerinfo($imapResource, $i);
	//print_r($header);
	if ($body == "") {
	$body = imap_fetchbody($imapResource, $i, "1");
	}

	$body = trim(substr(quoted_printable_decode($body), 0, 100));


	$date = date("d F, Y", strtotime($overview[0]->date));

	echo $overview[0]->from . '<br>';
	echo $overview[0]->subject . '<br>';
	echo $body . '<br>';
	echo $date . '<br>';
	echo 'From: ' . $overview[0]->from . '<br>';
	echo 'message_id: ' . $overview[0]->message_id . '<br>';
	echo 'msgno: ' . $overview[0]->msgno . '<br>';
	echo 'UID: ' . $overview[0]->uid . '<br>';
	echo $header->from[0]->mailbox . "@" . $header->from[0]->host . '<br>';
	echo '<br>';
	$i++;
	}

}
        
        imap_close($imapResource);


?>