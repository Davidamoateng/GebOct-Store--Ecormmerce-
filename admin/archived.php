<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/GebOct Store/core/init.php';
include 'includes/head.php';
include 'includes/navigation.php';
?>

<h2 class="text-center">Archived</h2>
<hr>
<table class="table table-bordered table-striped table-condenesed">
  <thead class="bg-primary text-light"><th>Action</th><th>Product</th><th>Price</th><th>Category</th><th>Sold</th></thead>
  <tbody>
    <tr>
      <td>
        <a href="archived.php?restore=1" class="btn btn-sm btn-light font-weight-bold"><span class="fa fa-redo-alt"></span> restore</a>
      </td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
  </tbody>
</table>

<?php include 'includes/footer.php'; ?>