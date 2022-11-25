<?php

// print_listing_li:
// This function prints an HTML <li> element containing an auction listing
function print_bids_li($item_id, $title, $my_bid, $desc, $price, $num_bids, $end_time,$image)
{
    // Truncate long descriptions
    if (strlen($desc) > 250) {
        $desc_shortened = substr($desc, 0, 250) . '...';
    } else {
        $desc_shortened = $desc;
    }

    // Fix language of bid vs. bids
    if ($num_bids == 1) {
        $bid = ' bid';
    } else {
        $bid = ' bids';
    }

    // Calculate time to auction end
    $now = new DateTime();
    if ($now > $end_time) {
        $time_remaining = 'This auction has ended';
    } else {
        // Get interval:
        $time_to_end = date_diff($now, $end_time);
        $time_remaining = display_time_remaining($time_to_end) . ' remaining';
    }

    // Print HTML
    echo('<li class="list-group-item d-flex justify-content-between">
<img src='.$image.' />
<div class="col-sm" ><h5><a href="listing.php?item_id=' . $item_id . '">' . $title . '</a></h5>' .$desc_shortened.'</div>
<div class="text-center text-nowrap"><span style="font-size: 1.5em">£' . number_format($price, 2) . '</span><br/>' . $num_bids . $bid . '<br/>' . $time_remaining . '</div>
</li>');
}

function print_bids_li_red($item_id, $title, $my_bid, $desc, $price, $num_bids, $end_time,$image)
{
    // Truncate long descriptions
    if (strlen($desc) > 250) {
        $desc_shortened = substr($desc, 0, 250) . '...';
    } else {
        $desc_shortened = $desc;
    }

    // Fix language of bid vs. bids
    if ($num_bids == 1) {
        $bid = ' bid';
    } else {
        $bid = ' bids';
    }

    // Calculate time to auction end
    $now = new DateTime();
    if ($now > $end_time) {
        $time_remaining = 'This auction has ended';
    } else {
        // Get interval:
        $time_to_end = date_diff($now, $end_time);
        $time_remaining = display_time_remaining($time_to_end) . ' remaining';
    }

    // Print HTML
    echo('<li class="list-group-item d-flex justify-content-between">
<img src='.$image.' />
<div class="col-sm" ><h5><a href="listing.php?item_id=' . $item_id . '">' . $title . '</a></h5>' .$desc_shortened.'</div>
<div class="text-center text-nowrap"><span style="font-size: 1.5em">£' . number_format($price, 2) . '</span><br/>' . $num_bids . $bid . '<br/>' . $time_remaining . '</div>
</li>');
}
?>

<style>
    img {
        border: 1px solid #ddd; /* Gray border */
        border-radius: 4px;  /* Rounded border */
        padding: 5px; /* Some padding */
        width: 5rem; /* Set a small width */
    }
</style






