<?php
function getPaymentInfo($DEPOSITDUEDATE, $DEPOSITPAYMENTDATE, $PERFORMANCEFEEDUEDATE, $PERFORMANCEFEEPAYMENTDATE) {
    global $totalfeeoverdue;
    global $totaldepositoverdue;
    global $totalfeepaid;
    global $totaldepositpaid;
    if (isset($DEPOSITPAYMENTDATE)) {
        $deposit = '<span class="badge badge-success">Deposit Paid</span>';
        $totaldepositpaid++;
    } else {
        if(!isset($DEPOSITDUEDATE)) {
            $deposit = '<span class="badge badge-dark">No Deposit Date</span>';
        } else {
            if (date("Y-m-d", strtotime($DEPOSITDUEDATE)) < date("Y-m-d")) {
                $days = Round((time() - strtotime(date("Y-m-d", strtotime($DEPOSITDUEDATE))))/(60 * 60 * 24));
                $deposit = '<span class="badge badge-danger">Days Overdue: ' . $days . '</span>';
                $totaldepositoverdue++;
            } else {
                $days = Round((strtotime(date("Y-m-d", strtotime($DEPOSITDUEDATE)))-time())/(60 * 60 * 24));
                if ($days <=7) {
                    $deposit = '<span class="badge badge-warning">Deposit due: ' . $days . ' days</span>';
                } else {
                    $deposit = '<span class="badge badge-primary">Deposit not paid</span>';
                }
            }
        }
    }
    if (isset($PERFORMANCEFEEPAYMENTDATE)) {
        $performancefee = '<span class="badge badge-success">Guarantee Paid</span>';
        $totalfeepaid++;
    } else {
        if(!isset($PERFORMANCEFEEDUEDATE)) {
            $performancefee = '<span class="badge badge-dark">No Guarantee Date</span>';
        } else {
            if (date("Y-m-d", strtotime($PERFORMANCEFEEDUEDATE)) < date("Y-m-d")) {
                $days = Round((time() - strtotime(date("Y-m-d", strtotime($PERFORMANCEFEEDUEDATE))))/(60 * 60 * 24));
                $performancefee = '<span class="badge badge-danger">Days Overdue: ' . $days . '</span>';
                $totalfeeoverdue++;
            } else {
                $days = Round((strtotime(date("Y-m-d", strtotime($PERFORMANCEFEEDUEDATE)))-time())/(60 * 60 * 24));
                if ($days <=7) {
                    $performancefee = '<span class="badge badge-warning">Guarantee due: ' . $days . ' days</span>';
                } else {
                    $performancefee = '<span class="badge badge-primary">Guarantee not paid</span>';
                }
            }
        }
    }
    return $deposit . ' / ' . $performancefee;
}
?>