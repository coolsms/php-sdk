<?php
	include "header.php";
	$result = $_SESSION['result'];
	$submit = filter_input(INPUT_POST, 'submit');

	if(isset($submit) && $submit == 'Search')
	{
		$type = filter_input(INPUT_POST, 'type');
		$rcpt_number = filter_input(INPUT_POST, 'rcpt_number');
		$page = filter_input(INPUT_POST, 'page');
		$count = filter_input(INPUT_POST, 'count');
		$msg_id = filter_input(INPUT_POST, 'msg_id');
		$group_id = filter_input(INPUT_POST, 'group_id');

		if(isset($count)&&$count!="") $options->count = $count;
		/*
		if(!is_null($rcpt_number)) $options->s_rcpt = $rcpt_number;
		if(!is_null($page)) $options->page = $page;
		if(!is_null($msg_id)) $options->mid = $msg_id;
		if(!is_null($group_id)) $options->gid = $group_id;
		 */
		$sentResult = $rest->sent($options); 

	}
	else
		$sentResult = $rest->sent();
?>
<div id="body">
	<h4><a onclick="showOption()" title="고급 검색">Advance Search</a></h4>
</div>

<div id="search_option" style="display:none;">
	<form method="post" >
	<table class="table" style="width:50%;">
	<tr>
		<th> Recipient Number </th>
		<td> <input type=text value="<?php echo $rcpt_number; ?>" name="rcpt_number" /> </td>
		<th> Page </th>
		<td> <input type=text value="<?php echo $page; ?>" name="page" /> </td>
		<th> Count </th>
		<td> <input type=text value="<?php echo $count; ?>" name="count" placeholder="Default = 20" /></td>
		<th> Msg ID </th>
		<td> <input type=text value="<?php echo $msg_id; ?>" name="msg_id" /></td>
		<th> Group ID </th>
		<td> <input type=text value="<?php echo $group_id; ?>" name="group_id" /></td>
		
	</tr>
	<tr>
		<th> Search Date</th><td></td><td></td><td></td>
	</tr>
	<tr>
		<td style="text-align:right;"> Start Date </td>
		<td> <input type=text id=dp_start name=dp_start placeholder="YYYY-MM-DD HH:MI:SS" /></td>
		<td style="text-align:right;"> End Date</td>
		<td> <input type=text id=dp_end name=dp_end  placeholder="YYYY-MM-DD HH:MI:SS"/></td>
	</tr>
	<tr>
		<td colspan="4"><input type=submit name="submit" value="Search" class="btn btn-primary" style="float:right;"/></td>
	</tr>
	</table>
	</form>

</div>


<table class="table">
<tr>
	<th></th>
	<th>Type</th>
	<th>Accepted Time</th>
	<th>Rcpt Number</th>
	<th>Group ID</th>
	<th>Msg ID</th>
	<th>Status</th>
	<th><a href="http://doc.coolsms.co.kr/?page_id=55" title="코드에대해서 정확하게 알고싶으면 이용하세요">Result Code</a></th>
	<th>Result Msg</th>
	<th>Sent Time</th>
	<th>Msg Text</th>
</tr>

<?php
	if(isset($sentResult))
	{
		foreach($sentResult as $row=>$val)
		{
			if(is_array($val))
				foreach($val as $data=>$data_row)
					echo "<tr>
							<td>$data</td>
							<td>$data_row->type</td>
							<td>$data_row->accepted_time</td>
							<td>$data_row->recipient_number</td>
							<td>$data_row->group_id</td>
							<td>$data_row->message_id</td>
							<td>$data_row->status</td>
							<td>$data_row->result_code</td>
							<td>$data_row->result_message</td>
							<td>$data_row->sent_time</td>
							<td>$data_row->text</td>
						  </tr>";
		}
	}
	else
		echo "<h3>No results found</h3>";


	





?>

</table>

<script>
	
	function showOption()
	{
		option_div = document.getElementById("search_option").style.display;
		if(option_div == 'none')
			document.getElementById("search_option").style.display = "block";
		else
			document.getElementById("search_option").style.display = "none";
	}

</script>

