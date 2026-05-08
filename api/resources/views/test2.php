<?php
include('templates/head.php');
include('templates/sidebar.php');
include('templates/header.php');


if ($_SESSION['emp_user_type_id'] != 13) {
  $_SESSION['msg'] = "<div class='col-md-12 alert alert-danger text-center'>Sorry, you have no permission  to access this page!";
  $general_func->header_redirect($general_func->site_url . "pms2/index.php");
}

if (isset($_REQUEST['enter']) && (int)$_REQUEST['enter'] == 3) {
  $_SESSION['search_by'] = $_REQUEST['search_by'];
  $_SESSION['key'] = $_REQUEST['cd'];
} else {
  // echo 'ok';
  // $_SESSION['search_by'] = 4;
  // unset($_SESSION['search_by']);
  // unset($_SESSION['key']);
  $query = "where l.status=0 and l.approved_by=0";
  $query = "where 1";
}

if (isset($_GET['sort'])) {
  if ($_GET['sort'] == 'name_asc') {
    $sort = 'e.full_name ASC';
  } else if ($_GET['sort'] == 'name_desc') {
    $sort = 'e.full_name DESC';
  } else if ($_GET['sort'] == 'app_date_asc') {
    $sort = 'l.created_at ASC';
  } else if ($_GET['sort'] == 'app_date_desc') {
    $sort = 'l.created_at DESC';
  } else if ($_GET['sort'] == 'leave_date_asc') {
    $sort = 'l.leave_start ASC';
  } else if ($_GET['sort'] == 'leave_date_desc') {
    $sort = 'l.leave_start DESC';
  } else {
    $sort = 'l.id DESC';
  }
} else {
  // $_SESSION['search_by'] = 4;
  $sort = 'l.id DESC';
}




if (isset($_SESSION['search_by'])) {
  $query = "where 1 ";

  if (isset($_SESSION['search_by']) && (int)$_SESSION['search_by']  == 0) {
    if (trim($_SESSION['key']) != NULL) {
      $query .= " and l.status=0 and l.approved_by=0 and l.leave_start >='" . date('Y-m-d') . "' and e.full_name LIKE '" . trim($_SESSION['key']) . "%'";
    } else {
      $query .= " and l.status=0";
    }
  }

  if (isset($_SESSION['search_by']) && (int)$_SESSION['search_by']  == 1) {
    if (trim($_SESSION['key']) != NULL) {
      $query .= " and l.status=1 and l.leave_start >='" . date('Y-m-d') . "' and e.full_name LIKE '" . trim($_SESSION['key']) . "%'";
    } else {
      $query .= " and l.status=1 and l.leave_start >='" . date('Y-m-d') . "'";
    }
  }

  if (isset($_SESSION['search_by']) && (int)$_SESSION['search_by']  == 2) {
    if (trim($_SESSION['key']) != NULL) {
      $query .= " and l.status=2 and e.full_name LIKE '" . trim($_SESSION['key']) . "%'";
    } else {
      $query .= " and l.status=2";
    }
  }

  if (isset($_SESSION['search_by']) && (int)$_SESSION['search_by']  == 3) {
    if (trim($_SESSION['key']) != NULL) {
      $query .= "and l.status=1 and  l.leave_start <='" . date('Y-m-d') . "' and e.full_name LIKE '" . trim($_SESSION['key']) . "%'";
    } else {
      $query .= "and l.status=1 and l.leave_start <='" . date('Y-m-d') . "'";
    }
  }
  if (isset($_SESSION['search_by']) && (int)$_SESSION['search_by']  == 4) {
    if (trim($_SESSION['key']) != NULL) {
      $query = " where 1 and e.full_name LIKE '" . trim($_SESSION['key']) . "%'";
    } else {
      $query = "where 1";
    }
   
  }
}

$leaves_applications = $db->fetch_all_array("select l.id,l.employee_id,l.approved_by,l.leave_type,l.leave_start,l.leave_end,l.whichhalf,l.doc_proof,l.reason,l.status,l.created_at,e.full_name,e.manager_id  from leaves_log_tbl l left join employees e on l.employee_id=e.id $query order by $sort");

?>


<!--Site Content Start-->
<div class="site-content">
  <div class="container">
    <?php
    // echo "<pre>";
    //  print_r($leaves_applications);
    ?>

    <?php
    if (isset($_SESSION['msg']) && trim($_SESSION['msg']) != NULL) {
    ?><div class="row ">
        <?= $_SESSION['msg'];
        $_SESSION['msg'] = ""; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
  </div>
<?php
    }
?>
<form enctype="multipart/form-data" method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
  <input type="hidden" name="enter" value="3" />
  <div class="row">
    <div class="col-2 d-flex align-items-center justify-content-center">
      <label class="mt-2">Search By: </label>
    </div>
    <div class="col-3">
      <select name="search_by" onchange="option_list(this.value)" class="form-control">
        <option value="4" <?= $_SESSION['search_by'] == 4 ? 'selected="selected"' : ''; ?>>Leave Applications</option>
        <option value="0" <?= $_SESSION['search_by'] == 0 ? 'selected="selected"' : ''; ?>>Pending Applications</option>
        <option value="1" <?= $_SESSION['search_by'] == 1 ? 'selected="selected"' : ''; ?>>Leave Approved</option>
        <option value="2" <?= $_SESSION['search_by'] == 2 ? 'selected="selected"' : ''; ?>>Leave Rejected</option>
        <option value="3" <?= $_SESSION['search_by'] == 3 ? 'selected="selected"' : ''; ?>>Old Approved Leave</option>
      </select>
    </div>
    <div class="col-5">
      <input type="text" name="cd" value="<?= isset($_SESSION['key']) ? $_SESSION['key'] : '' ?>" autocomplete="OFF" id="text_search" class="form-control" placeholder="Search here...">
    </div>
    <div class="col-2">
      <button type="submit" class="btn btn-success ml-4 submit1"><i class="fa fa-search"></i></button>
    </div>
  </div>
</form>

<div class="mt-3">
  <div class="right mb-2 text-right">
    <a href="add-leave.php"><button type="button" class="btn btn-info btn-sm">Add Leave</button></a>
  </div>
  <table class="table">
    <thead class="">
      <th>Name <a href="?sort=name_asc"><i class="fa fa-arrow-up"></i></a><a href="?sort=name_desc"><i class="fa fa-arrow-down"></i></a></th>
      <th>Type</th>
      <th>Status</th>
      <th>Application Date <a href="?sort=app_date_asc"><i class="fa fa-arrow-up"></i></a><a href="?sort=app_date_desc"><i class="fa fa-arrow-down"></i></a></th>
      <th>Leave Date <a href="?sort=leave_date_asc"><i class="fa fa-arrow-up"></i></a><a href="?sort=leave_date_desc"><i class="fa fa-arrow-down"></i></a></th>
      <th>Action</th>
    </thead>
    <tbody>
      <?php
      foreach ($leaves_applications as $leave) {
      ?>
        <tr>
          <td><?= $leave['full_name'] ?></td>
          <td><span class="badge badge-success" style="font-size: 85%;"><?= ucfirst($leave['leave_type']) ?></td>
          <td><?= $general_func->leave_status($leave['status']); ?></td>
          <td><?= $general_func->display_date($leave['created_at'], 1) ?></td>
          <td><?= $general_func->display_date($leave['leave_start'], 1) ?></td>
          <td><a href="javascript:void(0);" data-id="<?= $leave['id'] ?>" id="<?= $leave['id'] ?>" class="btn btn-info mx-1 viewleavedetails" title="view"><i class="fa fa-eye"></i></a><a href="javascript:void(0);" data-id="<?= $leave['id'] ?>" class="btn btn-danger mx-1 deleteleavedetails" title="Delete"><i class="fa fa-trash"></i></a></td>
        </tr>
      <?php
      } ?>
    </tbody>
    <?php echo (!count($leaves_applications)) ? "<tr><td>There are no record found.!</td></tr>" : ''; ?>
  </table>
</div>
</div>
<!--Site Content End-->
<footer class="footer">
  <div class="container">
    <p class="m-0">Copyright &copy; 2021 Webgrity - All rights reserved. </p>
  </div>
</footer>
<!--Footer End-->
</div>
</div>
<!--Main End-->
</div>
</div>


<div class="modal fade" id="leavedetails-modal" tabindex="-1" role="dialog" aria-labelledby="leavedetails-modal-label" aria-hidden="true">

  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="leavedetails-modal-label">leave Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form name="" enctype="multipart/form-data" action="process/handy.php" method="POST" onsubmit="return handyformValidation();">
        <input type="hidden" name="return_url" value="leaves.php">
        <input type="hidden" name="id" id="leave-id">
        <div class="modal-body">
          <div class="form-group">
            <div class="card" style="width: 100%;">
              <div class="card-body">
                <h5 class="card-title" id="employeeNameid">Employee Name</h5>
                <p class="card-text" id="reasonid">
                  Reason
                </p>
              </div>
              <ul class="list-group list-group-flush" id="timesandtype">
              </ul>
              <div class="list-group p-2">
                <label for="comment">Comments</label>
                <textarea name="comment" id="comment" cols="30" rows="3"></textarea>
              </div>
              <div class="card-body" id="leave-status-id">
                <a href="javascript:void(0);" class="btn btn-danger" id="rejectedbtn" style="float: left;" onclick="rejectedleave();">Reject</a>
                <a href="javascript:void(0);" class="btn btn-success" id="approvebtn" style="float: right;" onclick="approvedleave();">Approve</a>
              </div>
            </div>
          </div>
      </form>
    </div>
  </div>
</div>
</div>
<!-- Leaves Delete Modal -->


<div class="modal fade" id="leavedelete-modal" tabindex="-1" role="dialog" aria-labelledby="leavedelete-modal-label" aria-hidden="true">

  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="leavedelete-modal-label">Are you sure, you want to delete the leave?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <div class="card" style="width: 100%;">
            <div class="card-body" id="leave-status-id">
              <button type="button" class="btn btn-info" data-dismiss="modal" aria-label="Close">
                Cancel
              </button>
              <a href="javascript:void(0);" class="btn btn-danger" id="deletebtn" style="float: right;" onclick="deleteleave();">Delete</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
  /*****leave reject function*********/
  function rejectedleave() {
    var id = $('#rejectedbtn').attr('data-id');
    var comment = document.getElementById('comment').value;
    $.ajax({
      type: "POST",
      url: "process/get_leave.php",
      cache: false,
      data: {
        id: id,
        action: 'rejected',
        comment: comment
      },
      dataType: "json",
      success: function(data) {

        var arrayValue = JSON.parse(JSON.stringify(data));

        if (arrayValue['status'] == 'success') {
          location.reload(true);
        } else {
          location.reload(true);
        }
      }
    });
  }

  /*****leave accepted function*********/

  function approvedleave() {
    // alert();
    var id = $('#approvebtn').attr('data-id');
    var comment = document.getElementById('comment').value;
    // alert(comment);
    $.ajax({
      type: "POST",
      url: "process/get_leave.php",
      cache: false,
      data: {
        id: id,
        action: 'approved',
        comment: comment
      },
      dataType: "json",
      success: function(data) {
        var arrayValue = JSON.parse(JSON.stringify(data));

        if (arrayValue['status'] == 'success') {
          location.reload(true);
        } else {
          location.reload(true);
        }
      }
    });
  }

  /*****leave view details function*********/
  $(document).on('click', '.viewleavedetails', function() {
    var id = $(this).attr('data-id');
    $.ajax({
      type: "POST",
      url: "process/get_leave.php",
      cache: false,
      data: {
        id: id,
        action: 'leavedetails'
      },
      dataType: "json",
      success: function(data) {
        var arrayValue = JSON.parse(JSON.stringify(data));

        if (arrayValue['status'] == 'success') {
          $('#arrayValue').val(arrayValue['data']['id']);
          $('#employeeNameid').empty().html(arrayValue['data']['full_name']);
          $('#reasonid').empty().html(arrayValue['data']['reason']);

          var addhtml = '<li class="list-group-item"><strong>Leave Type : </strong><h6 class="badge badge-info" style="font-size: 95%;"> ' + arrayValue['data']['leave_type'].toUpperCase() + '</h6></li>';

          addhtml += '<li class="list-group-item"><strong>Application Date : </strong>' + arrayValue['data']['created_at'] + '</li>';

          if (arrayValue['data']['leave_type'] == 'fullday') {
            addhtml += '<li class="list-group-item"><strong>Leave Date : </strong>' + arrayValue['data']['leave_start'] + ' to ' + arrayValue['data']['leave_end'] + '</li>';
          }
          if (arrayValue['data']['leave_type'] == 'halfday') {
            addhtml += '<li class="list-group-item"><strong>Leave Half : </strong>' + arrayValue['data']['whichhalf'] + '</li>';

            addhtml += '<li class="list-group-item"><strong>Leave Date : </strong>' + arrayValue['data']['leave_start'] + '</li>';
          }
          if (arrayValue['data']['leave_type'] == 'early' && arrayValue['data']['doc_proof'] != '') {
            addhtml += '<li class="list-group-item"><strong>Docs : </strong>' + arrayValue['data']['doc_proof'] + '</li>';
            addhtml += '<li class="list-group-item"><strong>Leave Date : </strong>' + arrayValue['data']['leave_start'] + '</li>';
          }

          if (parseInt(arrayValue['data']['status']) == 0) {
            $('#leave-status-id').empty().html('<a href="javascript:void(0);" class="btn btn-danger" id="rejectedbtn" data-id="' + arrayValue['data']['id'] + '" style="float: left;" onclick="rejectedleave();">Decline</a><a href="javascript:void(0);" class="btn btn-success" data-id="' + arrayValue['data']['id'] + '" style="float: right;" id="approvebtn" onclick="approvedleave();">Approve</a>');
            $('#comment').prop('disabled', false);
          } else {
            $('#leave-status-id').empty().html('<h4> <strong>Current Status : </strong>' + arrayValue['data']['statusName'] + '</h4>');
            $('#comment').prop('disabled', true);
            $('#comment').val(arrayValue['data']['comment']);

          }

          $('#timesandtype').html(addhtml);
          $('#arrayValue').val(arrayValue['data']['id']);

          $('#leavedetails-modal').modal('show');
        }
      }
    });
  });


  /*****leave  delete Modal *********/
  $(document).on('click', '.deleteleavedetails', function() {
    var id = $(this).attr('data-id');

    $('#deletebtn').attr('data-id', id);
    $('#leavedelete-modal').modal('show');
  });

  /*****leave  delete function *********/
  function deleteleave() {
    var id = $('#deletebtn').attr('data-id');
    $.ajax({
      type: "POST",
      url: "process/get_leave.php",
      cache: false,
      data: {
        id: id,
        action: 'deleted',
      },
      dataType: "json",
      success: function(data) {

        var arrayValue = JSON.parse(JSON.stringify(data));

        if (arrayValue['status'] == 'success') {
          location.reload(true);
        } else {
          location.reload(true);
        }
      }
    });
  }
</script>
<?php 
if(isset($_GET['id'])){
  $leaves_id = $_GET['id'];
?>
<script>
  document.getElementById(<?php echo $leaves_id; ?>).click();
</script>

<?php
}
?>
</body>

</html>