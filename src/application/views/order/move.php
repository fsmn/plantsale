<?php
//move an order to a different variety
?>
<form name="order-mover" id="order-mover" action="<?php print site_url('order/move/' . $order->id); ?>" method="POST">
	<p><label>Current Variety:</label>
		<?php print $order->variety; ?></p>
	<p><label for="variety_id">Variety ID: </label><input type="number" name="variety_id" id="variety_id" value="<?php print $order->variety_id; ?>" /><br />
		<label for="new_variety">New Variety: </label><span id="new_variety"><?php print $order->variety; ?></span>
	<p>
		<input type="submit" value="Move to New Variety" class="button edit" />
	</p>
</form>

<script type="text/javascript">
	$("#variety_id").blur(function() {
		my_variety = $(this).val();
		form_data = {
			variety_id: my_variety
		}
		$.ajax({
			dataType: "json",
			type: 'get',
			url: base_url + "variety/get/" + my_variety,
			data: form_data,
			success: function(data) {
				console.log(data["variety"]);
				variety_name = data['common_name'] + ", " + data['variety'];
				$("#new_variety").html(variety_name);
			},
			error: function(data) {
				console.log(data);
			}
		})
	});
</script>