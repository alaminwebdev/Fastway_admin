<?php
include 'db_connect.php';
$qry = $conn->query("SELECT * FROM parcels where id = " . $_GET['id'])->fetch_array();
foreach ($qry as $k => $v) {
	$$k = $v;
}
if ($to_branch_id > 0 || $from_branch_id > 0) {
	$to_branch_id = $to_branch_id  > 0 ? $to_branch_id  : '-1';
	$from_branch_id = $from_branch_id  > 0 ? $from_branch_id  : '-1';
	$branch = array();
	$branches = $conn->query("SELECT *,concat(address,', ',city,', ',contact,', ',zip_code,', ',country) as addresss FROM branches where id in ($to_branch_id,$from_branch_id)");
	while ($row = $branches->fetch_assoc()) :
		$branch[$row['id']] = $row['addresss'];
	endwhile;
}
?>
<div class="container-fluid">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-md-12">
				<div class="callout callout-success">
					<dl>
						<dt>Tracking Number:</dt>
						<dd>
							<h4><b><?php echo $reference_number ?></b></h4>
						</dd>
					</dl>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="callout callout-success">
					<b class="border-bottom border-success">Sender Information</b>
					<dl>
						<dt>Name:</dt>
						<dd><?php echo ucwords($sender_name) ?></dd>
						<dt>Address:</dt>
						<dd><?php echo ucwords($sender_address) ?></dd>
						<dt>Contact:</dt>
						<dd><?php echo ucwords($sender_contact) ?></dd>
					</dl>
				</div>
				<div class="callout callout-success">
					<b class="border-bottom border-success">Recipient Information</b>
					<dl>
						<dt>Name:</dt>
						<dd><?php echo ucwords($recipient_name) ?></dd>
						<dt>Address:</dt>
						<dd><?php echo ucwords($recipient_address) ?></dd>
						<dt>Contact:</dt>
						<dd><?php echo ucwords($recipient_contact) ?></dd>
					</dl>
				</div>
			</div>
			<div class="col-md-6">
				<div class="callout callout-success">
					<b class="border-bottom border-success">Parcel Details</b>
					<div class="row">
						<div class="col-sm-6">
							<dl>
								<dt>Wight:</dt>
								<dd><?php echo $weight ?></dd>
								<dt>Height:</dt>
								<dd><?php echo $height ?></dd>
								<dt>Price:</dt>
								<dd><?php echo number_format($price, 2) ?></dd>
							</dl>
						</div>
						<div class="col-sm-6">
							<dl>
								<dt>Width:</dt>
								<dd><?php echo $width ?></dd>
								<dt>length:</dt>
								<dd><?php echo $length ?></dd>
								<dt>Type:</dt>
								<dd><?php echo $type == 1 ? "<span class='badge badge-success'>Deliver to Recipient</span>" : "<span class='badge badge-info'>Pickup</span>" ?></dd>
							</dl>
						</div>
					</div>
					<dl>
						<dt>Branch Accepted the Parcel:</dt>
						<dd><?php echo ucwords($branch[$from_branch_id]) ?></dd>
						<?php if ($type == 2) : ?>
							<dt>Nearest Branch to Recipient for Pickup:</dt>
							<dd><?php echo ucwords($branch[$to_branch_id]) ?></dd>
						<?php endif; ?>
						<div class="row">
							<div class="col-sm-6">
								<dt>Parcel Type:</dt>
								<dd>
									<?php
									switch ($parcel_type) {
										case 'normal':
											echo "<span class='badge badge-pill badge-dark'>Normal</span>";
											break;
										case 'confidential':
											echo "<span class='badge badge-pill badge-danger'>Confidential</span>";
											break;

										default:
											echo "<span class='badge badge-pill badge-dark'>Normal</span>";
											break;
									}
									?>
								</dd>
							</div>
							<div class="col-sm-6">
								<dt>Delivery Type:</dt>
								<dd>
									<?php
									switch ($delivery_type) {
										case '1':
											echo "<span class='badge badge-pill badge-dark'>Regular</span>";
											break;
										case '2':
											echo "<span class='badge badge-pill badge-danger'>Express</span>";
											break;

										default:
											echo "<span class='badge badge-pill badge-dark'>Regular</span>";
											break;
									}

									?>
								</dd>
							</div>
						</div>


						<dt>Status:</dt>
						<dd>
							<?php
							switch ($status) {
								case '1':
									echo "<span class='badge badge-pill badge-info'> Collected</span>";
									break;
								case '2':
									echo "<span class='badge badge-pill badge-danger'> Shipped</span>";
									break;
								case '3':
									echo "<span class='badge badge-pill badge-secondary'> In-Transit</span>";
									break;
								case '4':
									echo "<span class='badge badge-pill badge-dark'> Arrived At Destination</span>";
									break;
								case '5':
									echo "<span class='badge badge-pill badge-primary'> Out for Delivery</span>";
									break;
								case '6':
									echo "<span class='badge badge-pill badge-light'> Ready to Pickup</span>";
									break;
								case '7':
									echo "<span class='badge badge-pill badge-success'>Delivered</span>";
									break;
								case '8':
									echo "<span class='badge badge-pill badge-success'> Picked-up</span>";
									break;
								case '9':
									echo "<span class='badge badge-pill badge-danger'> Unsuccessfull Delivery Attempt</span>";
									break;

								case '10':
									echo "<span class='badge badge-pill badge-danger'>Pending</span>";
									break;

								default:
									echo "<span class='badge badge-pill badge-info'> Item Accepted by Courier</span>";

									break;
							}

							?>
							<span class="btn badge badge-success" id='update_status'><i class="fa fa-edit"></i> Update Status</span>
						</dd>

					</dl>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal-footer display p-0 m-0">
	<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
</div>
<style>
	#uni_modal .modal-footer {
		display: none
	}

	#uni_modal .modal-footer.display {
		display: flex
	}
</style>
<noscript>
	<style>
		table.table {
			width: 100%;
			border-collapse: collapse;
		}

		table.table tr,
		table.table th,
		table.table td {
			border: 1px solid;
		}

		.text-cnter {
			text-align: center;
		}
	</style>

</noscript>
<script>
	$('#update_status').click(function() {
		uni_modal("Update Status of: <?php echo $reference_number ?>", "manage_parcel_status.php?id=<?php echo $id ?>&cs=<?php echo $status ?>", "")
	})
</script>