<?php include 'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-success">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default  " href="./index.php?page=branch/new_branch"><i class="fa fa-plus"></i> Add New</a>
			</div>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-striped table-bordered" id="list">
				<!-- <colgroup>
					<col width="5%">
					<col width="15%">
					<col width="25%">
					<col width="25%">
					<col width="15%">
				</colgroup> -->
				<thead>
					<tr>
						<th class="text-center">Serial</th>
						<th>Branch ID</th>
						<th>Address</th>
						<th>City - Zip code</th>
						<th>Country</th>
						<th>Contact #</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$qry = $conn->query("SELECT * FROM branches order by address asc,city asc ");
					while ($row = $qry->fetch_assoc()) :
					?>
						<tr>
							<td class="text-center"><?php echo $i++ ?></td>
							<td class=""><?php echo $row['branch_code'] ?></td>
							<td><?php echo ucwords($row['address']) ?></td>
							<td><?php echo ucwords($row['city'] . ', ' . $row['zip_code']) ?></td>
							<td><?php echo ucwords($row['country']) ?></td>
							<td><?php echo $row['contact'] ?></td>
							<td class="text-center">
								<div class="btn-group">
									<a href="index.php?page=branch/edit_branch&id=<?php echo $row['id'] ?>" class="btn btn-success  ">
										<i class="fas fa-edit"></i>
									</a>
									<button type="button" class="btn btn-danger delete_branch" data-id="<?php echo $row['id'] ?>">
										<i class="fas fa-trash"></i>
									</button>
								</div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<style>
	table td {
		vertical-align: middle !important;
	}
</style>
<script>
	$(document).ready(function() {
		$('#list').dataTable({
			"pageLength": 50
		});
		$('.view_branch').click(function() {
			uni_modal("branch's Details", "view_branch.php?id=" + $(this).attr('data-id'), "large")
		});
		$('.delete_branch').click(function() {
			_conf("Are you sure to delete this branch?", "delete_branch", [$(this).attr('data-id')])
		})
	})

	function delete_branch($id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_branch',
			method: 'POST',
			data: {
				id: $id
			},
			success: function(resp) {
				if (resp == 1) {
					alert_toast("Data successfully deleted", 'success')
					setTimeout(function() {
						location.reload()
					}, 1500)

				}
			}
		})
	}
</script>