<?php
error_reporting(1);
include_once "../head.htm";

$link_name = "Welcome";
if ($_SESSION['emp_user_type_id'] != 1) {
    $_SESSION['message'] = "Sorry, you have no permission  to access this page!";
    $general_func->header_redirect($general_func->site_url . "home.php");
}

$title_heading = "Monthly Leave Report";

$selected_month = isset($_GET['month']) ? trim($_GET['month']) : date("Y-m");
if (!preg_match('/^\d{4}-\d{2}$/', $selected_month)) {
    $selected_month = date("Y-m");
}
$month_start = $selected_month . "-01";
$month_end = date("Y-m-t", strtotime($month_start));
$month_label = date("F Y", strtotime($month_start));
$prev_month = date("Y-m", strtotime($month_start . " -1 month"));
$next_month = date("Y-m", strtotime($month_start . " +1 month"));
$current_report_url = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING']) && trim($_SERVER['QUERY_STRING']) != "") {
    $current_report_url .= "?" . $_SERVER['QUERY_STRING'];
}

function leave_date_label($leave, $general_func)
{
    $leave_start = trim($leave['leave_start']);
    $leave_end = trim($leave['leave_end']);
    $leave_type = strtolower(trim($leave['leave_type']));
    $whichhalf = trim($leave['whichhalf']);

    if ($leave_start == $leave_end) {
        $label = $general_func->display_date($leave_start, 10);
    } else {
        $label = $general_func->display_date($leave_start, 10) . " to " . $general_func->display_date($leave_end, 10);
    }

    // if ($leave_type == "halfday" && $whichhalf != "") {
    //     $label .= " (" . ucfirst($whichhalf) . " )";
    // }

    return $label;
}

function leave_type_label($leave)
{
    $leave_type = trim($leave['leave_type']);
    $whichhalf = trim($leave['whichhalf']);

    if ($leave_type == "") {
        return "-";
    }

    $label = ucwords(str_replace("_", " ", $leave_type));
    if (strtolower($leave_type) == "halfday" && $whichhalf != "") {
        $label .= " - " . normalized_half_label($whichhalf);
    }

    return $label;
}

function normalized_half_label($whichhalf)
{
    $clean_value = strtolower(trim($whichhalf));
    $clean_key = str_replace(array(" ", "-", "_"), "", $clean_value);

    if ($clean_key == "") {
        return "";
    }

    if (in_array($clean_key, array("first", "firsthalf", "1sthalf", "fh"))) {
        return "First Half";
    }

    if (in_array($clean_key, array("second", "secondhalf", "2ndhalf", "sh", "lasthalf"))) {
        return "Second Half";
    }

    return ucwords(str_replace(array("_", "-"), " ", $clean_value));
}

function half_day_type_label($whichhalf)
{
    $half_label = normalized_half_label($whichhalf);
    if ($half_label == "") {
        return "Half Day";
    }

    return "Half Day - " . $half_label;
}

function leave_day_name($leave_date)
{
    $leave_ts = strtotime(trim($leave_date));
    if ($leave_ts === false) {
        return "-";
    }

    return date("l", $leave_ts);
}

function leave_days_value($leave)
{
    $leave_start = trim($leave['leave_start']);
    $leave_end = trim($leave['leave_end']);
    $leave_type_raw = strtolower(trim($leave['leave_type']));

    if ($leave_start == "" || $leave_end == "") {
        return 0;
    }

    $start_ts = strtotime($leave_start);
    $end_ts = strtotime($leave_end);
    if ($start_ts === false || $end_ts === false) {
        return 0;
    }

    if ($end_ts < $start_ts) {
        $tmp = $start_ts;
        $start_ts = $end_ts;
        $end_ts = $tmp;
    }

    $total_days = (int)floor(($end_ts - $start_ts) / 86400) + 1;
    if ($total_days < 1) {
        $total_days = 1;
    }

    $leave_type_key = str_replace(array(" ", "-", "_"), "", $leave_type_raw);

    if ($leave_type_key == "halfday" || $leave_type_key == "earlygo") {
        return 0.5;
    }

    // Explicit business rule for this custom leave type.
    // Example: FullDay-Plus-SecondHalfStartDate-FirstHalfEndDate (9 Mar to 10 Mar) => 2 days.
    if ($leave_type_key == "fulldayplussecondhalfstartdatefirsthalfenddate") {
        return (float)$total_days;
    }

    // Covers variants like:
    // FullDay-Plus-HalfStartDay, FullDay-Plus-HalfEndDay, FullDay-Plus-HalfStart-HalfEnd.
    $has_half_start = (strpos($leave_type_key, "halfstartday") !== false || strpos($leave_type_key, "halfstart") !== false);
    $has_half_end = (strpos($leave_type_key, "halfendday") !== false || strpos($leave_type_key, "halfend") !== false);

    if ($has_half_start && $has_half_end) {
        return max(0.5, $total_days - 1);
    }
    if ($has_half_start || $has_half_end) {
        return max(0.5, $total_days - 0.5);
    }

    if (strpos($leave_type_key, "half") !== false && strpos($leave_type_key, "fullday") === false) {
        return 0.5;
    }

    return (float)$total_days;
}

function format_leave_days($days)
{
    return rtrim(rtrim(number_format((float)$days, 2, '.', ''), '0'), '.');
}

function leave_day_segments($leave, $general_func, $month_start = "", $month_end = "")
{
    $segments = array();

    $leave_start = trim($leave['leave_start']);
    $leave_end = trim($leave['leave_end']);
    $leave_type_raw = strtolower(trim($leave['leave_type']));
    $whichhalf = trim($leave['whichhalf']);

    if ($leave_start == "" || $leave_end == "") {
        return $segments;
    }

    $start_ts = strtotime($leave_start);
    $end_ts = strtotime($leave_end);
    if ($start_ts === false || $end_ts === false) {
        return $segments;
    }

    if ($end_ts < $start_ts) {
        $tmp = $start_ts;
        $start_ts = $end_ts;
        $end_ts = $tmp;
    }

    $original_start_ts = $start_ts;
    $original_end_ts = $end_ts;

    if ($month_start != "") {
        $month_start_ts = strtotime(trim($month_start));
        if ($month_start_ts !== false && $start_ts < $month_start_ts) {
            $start_ts = $month_start_ts;
        }
    }

    if ($month_end != "") {
        $month_end_ts = strtotime(trim($month_end));
        if ($month_end_ts !== false && $end_ts > $month_end_ts) {
            $end_ts = $month_end_ts;
        }
    }

    if ($end_ts < $start_ts) {
        return $segments;
    }

    $leave_type_key = str_replace(array(" ", "-", "_"), "", $leave_type_raw);
    $total_days = (int)floor(($end_ts - $start_ts) / 86400) + 1;
    if ($total_days < 1) {
        $total_days = 1;
    }

    // Exact business rule provided by user: treat each day as full day.
    if ($leave_type_key == "fulldayplussecondhalfstartdatefirsthalfenddate") {
        for ($i = 0; $i < $total_days; $i++) {
            $current_date = date("Y-m-d", $start_ts + ($i * 86400));
            $segments[] = array(
                "type_label" => "Full Day",
                "date_label" => $general_func->display_date($current_date, 10),
                "day_label" => leave_day_name($current_date),
                "days" => 1
            );
        }
        return $segments;
    }

    if ($leave_type_key == "halfday" || $leave_type_key == "earlygo") {
        $type_label = half_day_type_label($whichhalf);

        $half_day_date = date("Y-m-d", $original_start_ts);
        $half_day_ts = strtotime($half_day_date);
        if ($half_day_ts < $start_ts || $half_day_ts > $end_ts) {
            return $segments;
        }

        $segments[] = array(
            "type_label" => $type_label,
            "date_label" => $general_func->display_date($half_day_date, 10),
            "day_label" => leave_day_name($half_day_date),
            "days" => 0.5
        );
        return $segments;
    }

    $has_half_start = (
        strpos($leave_type_key, "halfstartday") !== false ||
        strpos($leave_type_key, "halfstart") !== false ||
        strpos($leave_type_key, "secondhalfstartdate") !== false ||
        strpos($leave_type_key, "firsthalfstartdate") !== false
    );

    $has_half_end = (
        strpos($leave_type_key, "halfendday") !== false ||
        strpos($leave_type_key, "halfend") !== false ||
        strpos($leave_type_key, "firsthalfenddate") !== false ||
        strpos($leave_type_key, "secondhalfenddate") !== false
    );

    $apply_half_start = $has_half_start && ($start_ts == $original_start_ts);
    $apply_half_end = $has_half_end && ($end_ts == $original_end_ts);

    for ($i = 0; $i < $total_days; $i++) {
        $current_date = date("Y-m-d", $start_ts + ($i * 86400));
        $type_label = "Full Day";
        $days = 1;

        if ($i == 0 && $apply_half_start) {
            $type_label = half_day_type_label($whichhalf);
            $days = 0.5;
        }

        if ($i == ($total_days - 1) && $apply_half_end) {
            if ($total_days == 1 && $apply_half_start) {
                $type_label = "Full Day";
                $days = 1;
            } else {
                $type_label = half_day_type_label($whichhalf);
                $days = 0.5;
            }
        }

        $segments[] = array(
            "type_label" => $type_label,
            "date_label" => $general_func->display_date($current_date, 10),
            "day_label" => leave_day_name($current_date),
            "days" => $days
        );
    }

    return $segments;
}

function emergency_doc_status($leave)
{
    $doc_proof = trim((string)$leave['doc_proof']);
    $doc_proof_req = isset($leave['doc_proof_req']) ? (int)$leave['doc_proof_req'] : 0;
    $doc_proof_status = isset($leave['doc_proof_status']) ? (int)$leave['doc_proof_status'] : 0;


    
    if ($doc_proof_status == 1 && $doc_proof == "1") {
        return array("label" => "Submitted", "class" => "doc-submitted");
    }
   

    if ($doc_proof_req !== 1) {
        return array("label" => "Not Required", "class" => "doc-neutral");
    }

    if ($doc_proof == "") {
        return array("label" => "Not Submitted", "class" => "doc-missing");
    }

    

    

    return array("label" => "Submitted - Pending", "class" => "doc-pending");
}

$approved_leaves = $db->fetch_all_array("
    SELECT 
        l.id,
        l.employee_id,
        l.leave_type,
        l.leave_start,
        l.leave_end,
        l.whichhalf,
        l.status,
        l.doc_proof,
        l.doc_proof_req,
        l.doc_proof_status,
        l.emergency_leave,
        e.full_name
    FROM leaves_log_tbl l
    LEFT JOIN employees e ON l.employee_id = e.id
    WHERE l.status = 1
    AND l.emergency_leave = 0
    AND l.leave_start <= '" . $month_end . "'
    AND l.leave_end >= '" . $month_start . "'
    ORDER BY e.full_name ASC, l.leave_start ASC, l.id ASC
");

$emergency_leaves = $db->fetch_all_array("
    SELECT 
        l.id,
        l.employee_id,
        l.leave_type,
        l.leave_start,
        l.leave_end,
        l.whichhalf,
        l.status,
        l.doc_proof,
        l.doc_proof_req,
        l.doc_proof_status,
        l.emergency_leave,
        e.full_name
    FROM leaves_log_tbl l
    LEFT JOIN employees e ON l.employee_id = e.id
    WHERE l.status = 1
    AND l.emergency_leave = 1
    AND l.leave_start <= '" . $month_end . "'
    AND l.leave_end >= '" . $month_start . "'
    ORDER BY e.full_name ASC, l.leave_start ASC, l.id ASC
");

$approved_count = count($approved_leaves);
$emergency_count = count($emergency_leaves);
$emergency_submitted_count = 0;
$emergency_not_submitted_count = 0;

foreach ($emergency_leaves as $emergency_leave) {
    $doc_status = emergency_doc_status($emergency_leave);
    if ($doc_status['label'] == "Submitted" || $doc_status['label'] == "Submitted - Pending" || $doc_status['label'] == "Submitted - Rejected") {
        $emergency_submitted_count++;
    }
    if ($doc_status['label'] == "Not Submitted") {
        $emergency_not_submitted_count++;
    }
}
?>

<style type="text/css">
    .leave-filter-bar {
        width: 96%;
           margin: 0px 2% 20px 2%;
        background: #f4f8fd;
        border: 1px solid #d8e5f3;
        padding: 14px 18px;
        box-sizing: border-box;
    }

    .leave-filter-bar td {
        font: 13px/18px Arial, Helvetica, sans-serif;
        color: #24527a;
    }

    .leave-summary-box {
        width: 96%;
         margin: 0px 2% 20px 2%;
    }

    .leave-summary-card {
        width: 23%;
        border: 1px solid #d7e5f2;
        background: #f8fbff;
        padding: 12px 14px;
        box-sizing: border-box;
        min-height: 84px;
    }

    .leave-summary-title {
        font: bold 12px/16px Arial, Helvetica, sans-serif;
        color: #577da5;
        text-transform: uppercase;
        letter-spacing: .5px;
    }

    .summary-jump-link {
        display: block;
        text-decoration: none;
    }

    .summary-jump-link:hover .leave-summary-title,
    .summary-jump-link:hover .leave-summary-value {
        color: #003c79;
    }

    .leave-summary-value {
        font: bold 28px/34px Arial, Helvetica, sans-serif;
        color: #0055a8;
        padding-top: 8px;
    }

    .leave-section-title {
        width: 96%;
        margin: 0px 2% 0 2%;
        font: bold 16px/22px Arial, Helvetica, sans-serif;
        color: #003c79;
    }

    .month-nav-link {
        display: inline-block;
        padding: 7px 12px;
        border: 1px solid #c9d9ea;
        background: #ffffff;
        color: #0055a8;
        text-decoration: none;
        font: bold 12px/16px Arial, Helvetica, sans-serif;
    }

    .month-nav-link:hover {
        background: #edf5fc;
        text-decoration: none;
    }

    .month-chip {
        display: inline-block;
        padding: 7px 12px;
        background: #0055a8;
        color: #ffffff;
        font: bold 12px/16px Arial, Helvetica, sans-serif;
    }

    .doc-badge {
        display: inline-block;
        padding: 4px 9px;
        border-radius: 12px;
        font: bold 11px/14px Arial, Helvetica, sans-serif;
        white-space: nowrap;
    }

    .doc-submitted {
        background: #dff3e4;
        color: #287d3c;
    }

    .doc-pending {
        background: #fff3d8;
        color: #9a6a00;
    }

    .doc-missing {
        background: #fde3e3;
        color: #b23434;
    }

    .doc-rejected {
        background: #f8dede;
        color: #8f1f1f;
    }

    .doc-neutral {
        background: #e7edf5;
        color: #506a85;
    }

    .soft-note {
        width: 96%;
          margin: 0px 2% 20px 2%;
        padding: 11px 14px;
        background: #fffbe8;
        border: 1px solid #f0e2a6;
        color: #7f6513;
        font: 12px/18px Arial, Helvetica, sans-serif;
        box-sizing: border-box;
    }

    .report-actions {
        text-align: right;
    }

    .report-actions input[type="month"] {
        height: 31px;
        border: 1px solid #c9d9ea;
        padding: 3px 7px;
        color: #24527a;
    }

    .report-actions input[type="submit"] {
        height: 31px;
        border: 1px solid #004687;
        background: #0055a8;
        color: #ffffff;
        padding: 0 14px;
        cursor: pointer;
        font: bold 12px/16px Arial, Helvetica, sans-serif;
    }
</style>

<div class="bodyContent">
    <h1 class="mainHead"><?php echo $title_heading; ?></h1>

    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="left" valign="top">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="left" valign="top"><img src="images/spacer.gif" alt="" width="14" height="14" /></td>
                    </tr>
                    <?php if (isset($_SESSION['msg']) && trim($_SESSION['msg']) != NULL) { ?>
                        <tr>
                            <td class="message_error" align="center"><?php echo $_SESSION['msg']; $_SESSION['msg'] = ""; ?></td>
                        </tr>
                        <tr>
                            <td class="body_content-form" height="10"></td>
                        </tr>
                    <?php } ?>
                </table>
            </td>
        </tr>

        <tr>
            <td align="left" valign="top">
                <table class="leave-filter-bar" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="left" valign="middle" width="25%" style="padding: 12px 14px;">
                            <strong>Attendance Month:</strong> <?php echo $month_label; ?>
                        </td>
                        <td align="center" valign="middle" width="45%" style="padding: 12px 14px;">
                            <a class="month-nav-link" href="<?php echo $_SERVER['PHP_SELF']; ?>?month=<?php echo $prev_month; ?>">Previous Month</a>
                            <span class="month-chip"><?php echo $month_label; ?></span>
                            <a class="month-nav-link" href="<?php echo $_SERVER['PHP_SELF']; ?>?month=<?php echo $next_month; ?>">Next Month</a>
                        </td>
                        <td align="right" valign="middle" width="30%" class="report-actions" style="padding: 12px 14px;">
                            <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>" style="margin:0;">
                                <input type="month" name="month" value="<?php echo $selected_month; ?>" />
                                <input type="submit" value="View Report" />
                            </form>
                        </td>
                    </tr>
                </table>

                <table class="leave-summary-box" border="0" cellspacing="12" cellpadding="0">
                    <tr>
                        <td class="leave-summary-card" align="left" valign="top">
                            <a href="<?php echo htmlspecialchars($current_report_url); ?>#approvelist" class="summary-jump-link">
                                <div class="leave-summary-title">Approved Leave</div>
                                <div class="leave-summary-value"><?php echo $approved_count; ?></div>
                            </a>
                        </td>
                        <td class="leave-summary-card" align="left" valign="top">
                            <a href="<?php echo htmlspecialchars($current_report_url); ?>#emergencylist" class="summary-jump-link">
                                <div class="leave-summary-title">Emergency Leave</div>
                                <div class="leave-summary-value"><?php echo $emergency_count; ?></div>
                            </a>
                        </td>
                        <td class="leave-summary-card" align="left" valign="top">
                            <div class="leave-summary-title">Document Submitted</div>
                            <div class="leave-summary-value"><?php echo $emergency_submitted_count; ?></div>
                        </td>
                        <td class="leave-summary-card" align="left" valign="top">
                            <div class="leave-summary-title">Document Not Submitted</div>
                            <div class="leave-summary-value"><?php echo $emergency_not_submitted_count; ?></div>
                        </td>
                    </tr>
                </table>

                <!-- <div class="soft-note">
                    This report shows approved leave applications that fall within <strong><?php echo $month_label; ?></strong>. Emergency leave is shown separately with document submission status for faster attendance preparation.
                </div> -->

                <section id="approvelist" class="leave-section-title">Approved Leave List</section>
                <table width="96%" align="center" border="0" cellpadding="0" cellspacing="0" class="workHrLogTbl" style="">
                    <thead>
                        <tr>
                            <td class="text_numbering" colspan="6" align="right" valign="bottom" style="background:#fff; border:none">
                                <?php echo $approved_count; ?> Records found
                            </td>
                        </tr>
                        <tr>
                            <th width="6%" align="center" valign="middle">SL</th>
                            <th width="22%" align="left" valign="middle">Employee Name</th>
                            <th width="18%" align="left" valign="middle">Leave Type</th>
                            <th width="24%" align="left" valign="middle">Leave Date</th>
                            <th width="14%" align="left" valign="middle">Day</th>
                            <th width="16%" align="center" valign="middle">No. of Days</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($approved_count == 0) { ?>
                            <tr>
                                <td colspan="6" align="center" bgcolor="#f5f7fa" valign="middle" height="50" class="message_error">Sorry, no approved leave found for this month!</td>
                            </tr>
                        <?php } else {
                            $sl = 1;
                            foreach ($approved_leaves as $leave) { ?>
                                <?php
                                $segments = leave_day_segments($leave, $general_func, $month_start, $month_end);
                                if (count($segments) == 0) {
                                    $segments[] = array(
                                        "type_label" => leave_type_label($leave),
                                        "date_label" => leave_date_label($leave, $general_func),
                                        "day_label" => leave_day_name($leave['leave_start']),
                                        "days" => leave_days_value($leave)
                                    );
                                }

                                foreach ($segments as $segment) {
                                ?>
                                    <tr bgcolor="<?php echo $sl % 2 == 0 ? $general_func->color2 : $general_func->color1; ?>">
                                        <td align="center" valign="middle" class="table_content-blue"><?php echo $sl; ?></td>
                                        <td align="left" valign="middle" class="table_content-blue"><?php echo $leave['full_name'] != "" ? $leave['full_name'] : "Employee not exist"  ?></td>
                                        <td align="left" valign="middle" class="table_content-blue"><?php echo $segment['type_label']; ?></td>
                                        <td align="left" valign="middle" class="table_content-blue"><?php echo $segment['date_label']; ?></td>
                                        <td align="left" valign="middle" class="table_content-blue"><?php echo $segment['day_label']; ?></td>
                                        <td align="center" valign="middle" class="table_content-blue"><?php echo format_leave_days($segment['days']); ?></td>
                                    </tr>
                                <?php
                                    $sl++;
                                }
                            }
                        } ?>
                    </tbody>
                </table>

                <div id="" class="leave-section-title">Emergency Leave List</div>
                <table id="emergencylist" width="96%" align="center" border="0" cellpadding="0" cellspacing="0" class="workHrLogTbl" style="">
                    <thead>
                        <tr>
                            <td class="text_numbering" colspan="7" align="right" valign="bottom" style="background:#fff; border:none">
                                <?php echo $emergency_count; ?> Records found
                            </td>
                        </tr>
                        <tr>
                            <th width="6%" align="center" valign="middle">SL</th>
                            <th width="20%" align="left" valign="middle">Employee Name</th>
                            <th width="15%" align="left" valign="middle">Leave Type</th>
                            <th width="20%" align="left" valign="middle">Leave Date</th>
                            <th width="12%" align="left" valign="middle">Day</th>
                            <th width="17%" align="left" valign="middle">Document Status</th>
                            <th width="10%" align="center" valign="middle">No. of Days</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($emergency_count == 0) { ?>
                            <tr>
                                <td colspan="7" align="center" bgcolor="#f5f7fa" valign="middle" height="50" class="message_error">Sorry, no emergency leave found for this month!</td>
                            </tr>
                        <?php } else {
                            $sl = 1;
                            foreach ($emergency_leaves as $leave) {
                                $doc_status = emergency_doc_status($leave);
                                ?>
                                <?php
                                $segments = leave_day_segments($leave, $general_func, $month_start, $month_end);
                                if (count($segments) == 0) {
                                    $segments[] = array(
                                        "type_label" => leave_type_label($leave),
                                        "date_label" => leave_date_label($leave, $general_func),
                                        "day_label" => leave_day_name($leave['leave_start']),
                                        "days" => leave_days_value($leave)
                                    );
                                }

                                foreach ($segments as $segment) {
                                ?>
                                    <tr bgcolor="<?php echo $sl % 2 == 0 ? $general_func->color2 : $general_func->color1; ?>">
                                        <td align="center" valign="middle" class="table_content-blue"><?php echo $sl; ?></td>
                                        <td align="left" valign="middle" class="table_content-blue"><?php echo $leave['full_name'] != "" ? $leave['full_name'] : "Employee #" . $leave['employee_id']; ?></td>
                                        <td align="left" valign="middle" class="table_content-blue"><?php echo $segment['type_label']; ?></td>
                                        <td align="left" valign="middle" class="table_content-blue"><?php echo $segment['date_label']; ?></td>
                                        <td align="left" valign="middle" class="table_content-blue"><?php echo $segment['day_label']; ?></td>
                                        <td align="left" valign="middle" class="table_content-blue"><span class="doc-badge <?php echo $doc_status['class']; ?>"><?php echo $doc_status['label']; ?></span></td>
                                        <td align="center" valign="middle" class="table_content-blue"><?php echo format_leave_days($segment['days']); ?></td>
                                    </tr>
                                <?php
                                    $sl++;
                                }
                            }
                        } ?>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
</div>

<?php include "../foot.htm"; ?>
