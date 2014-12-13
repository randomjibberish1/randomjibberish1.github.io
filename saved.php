<?php
session_save_path('.');
session_start();
//session_destroy();
require 'header.inc';
require 'troop_info.inc';
require 'trap_info.inc';

/*var_dump($_SESSION);
print '<p>';
var_dump($_POST);
 * 
 */


error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<center>
    <h1>My Saved Options</h1>

    <?php
// if the user selected the "Remove" button, remove the checked units from the session
    if (array_key_exists('remove_type', $_POST)) {
        foreach ($all_troops as $typename => $type) {
            foreach ($type as $tier_number => $tier) {
                foreach ($tier as $key => $troop_type) {
                    if (@$_POST['remove_troop'][$typename][$tier_number][$key] == 'on') {
                        unset($_SESSION['saved_troop'][$typename][$tier_number][$key]);
                    }
                }
            }
        }
    }
    if (array_key_exists('remove_type', $_POST)) {
        foreach ($all_traps as $typename => $type) {
            foreach ($type as $tier_number => $tier) {
                foreach ($tier as $key => $troop_type) {
                    if (@$_POST['remove_trap'][$typename][$tier_number][$key] == 'on') {
                        unset($_SESSION['saved_trap'][$typename][$tier_number][$key]);
                    }
                }
            }
        }
    }

// if the user came from healing or salvage save redirect, then display that their selections were saved.
    if (@$_SESSION['troop_type_saved'] == true) {
        print '<center><font color=green>Troop selections saved!</font></center>';
        $_SESSION['troop_type_saved'] = false;
    }
    if (@$_SESSION['trap_type_saved'] == true) {
        print '<center><font color=green>Trap selections saved!</font></center>';
        $_SESSION['trap_type_saved'] = false;
    }


    if (array_key_exists('calculate_button', $_POST)) {
// if the user selected calculate, calculate the resources and total    
        $troop_post = 'troop';
        $trap_post = 'trap';
        $rss_troops = array();
        $rss_traps = array();
        $rss_total = array( 'unit' => 0, 'stone' => 0, 'wood' => 0, 'ore' => 0, 'food' => 0, 'silver' => 0);

        $rss_troops = calculate_resources($all_troops, $rss_troops, $_POST, $troop_post);
        $rss_traps = calculate_resources($all_traps, $rss_traps, $_POST, $trap_post);

        $rss_total = calculate_total($all_troops, $rss_troops, $rss_total, $_POST, $troop_post);
        $rss_total = calculate_total($all_traps, $rss_traps, $rss_total, $_POST, $trap_post);

        // if there are no troops to heal or traps to salvage, leave message and die.  Provide button to refresh page
        if ($rss_total['unit'] == 0) {
            ?>
            <h3> <center>There are no troops to heal or traps to salvage!  You're good!</h3>
            <form action="<?php print $_SERVER['PHP_SELF'] ?>" method="POST">
                <tr><td colspan='7'><center><input type='submit' name='reload' value='Start Over'></td></tr>
                    </form>
                </center>
                <?php
                die;
            }

            // display the quantities and totals
            print '<table width=600>';
            print '<td><b>Unit</td><td><b>Number</b></td><td><b>Stone</td><td><b>Wood</td><td><b>Ore</td><td><b>Food</td><td><b>Silver</td>';
            display_resources($all_troops, $_POST, $troop_post, $rss_troops);
            display_resources($all_traps, $_POST, $trap_post, $rss_traps);
            // display total
            print '<tr><td><b>Totals</b></td>';
                            foreach ($rss_total as $key => $amount) {
                                printf("<td><b>%s</b></td>", number_format($rss_total[$key]));
                            }
                            print '</tr>';
            
            ?>            <form action="<?php print $_SERVER['PHP_SELF'] ?>" method="POST">
                <tr><td colspan='7'><center><input type='submit' name='reload' value='Start Over'></td></tr>
                    </form>
                <?php
        }
        else{
            // display list of saved units
            
            
        ?>
        <form action='<?php print $_SERVER['PHP_SELF'] ?>' method='POST'>
            <table width='300px'>
        <?php
        // filter the array to remove empty values
        foreach ($all_troops as $typename => $type) {
            foreach ($type as $tier_number => $tier) {
                foreach ($tier as $key => $troop_type) {
                    if (empty($_SESSION['saved_troop'][$typename][$tier_number][$key])){
                        unset($_SESSION['saved_troop'][$typename][$tier_number][$key]);
                    }                   
                }
                if (empty($_SESSION['saved_troop'][$typename][$tier_number])){
                    unset($_SESSION['saved_troop'][$typename][$tier_number]);
                }               
            }
                if (empty($_SESSION['saved_troop'][$typename])){
                    unset($_SESSION['saved_troop'][$typename]);
                }               
        }
        foreach ($all_traps as $typename => $type) {
            foreach ($type as $tier_number => $tier) {
                foreach ($tier as $key => $troop_type) {
                    if (empty($_SESSION['saved_trap'][$typename][$tier_number][$key])){
                        unset($_SESSION['saved_trap'][$typename][$tier_number][$key]);
                    }                   
                }
                if (empty($_SESSION['saved_trap'][$typename][$tier_number])){
                    unset($_SESSION['saved_trap'][$typename][$tier_number]);
                }               
            }
                if (empty($_SESSION['saved_trap'][$typename])){
                    unset($_SESSION['saved_trap'][$typename]);
                }               
        }        
        
// print out a list of the saved troops/traps and provide checkbox to remove them
        foreach ($all_troops as $typename => $type) {
            if (!empty($_SESSION['saved_troop'][$typename])) {
                print '<tr><td colspan=2 align=center><b>' . $typename . '</b></td><td></td></tr>';
            }
            foreach ($type as $tier_number => $tier) {
                foreach ($tier as $key => $troop_type) {
                    if (@$_SESSION['saved_troop'][$typename][$tier_number][$key] == 1) {
                        ?>
                                <tr><td><input type='text' maxlength='7' size='5' name='troop[<?php print $typename ?>][<?php print $tier_number ?>][<?php print $key ?>]'></td>
                                    <td width='50%'><?php print $troop_type['name'] ?></td>
                                    <td align='center' width='20%'><input type='checkbox' name='remove_troop[<?php print $typename ?>][<?php print $tier_number ?>][<?php print $key ?>]'></td>
                                </tr>
                <?php
            }
        }
    }
    print '<tr><td></td></tr>';
}

foreach ($all_traps as $typename => $type) {
    if (!empty($_SESSION['saved_trap'][$typename])) {
        print '<tr><td colspan=2 align=center><b>' . $typename . '</b></td><td></td></tr>';
    }
    foreach ($type as $tier_number => $tier) {
        foreach ($tier as $key => $trap_type) {
            if (@$_SESSION['saved_trap'][$typename][$tier_number][$key] == 1) {
                ?>
                                <tr><td><input type='text' maxlength='7' size='5' name='trap[<?php print $typename ?>][<?php print $tier_number ?>][<?php print $key ?>]'></td>
                                    <td><?php print $trap_type['name'] ?></td>
                                    <td align='center'><input type='checkbox' name='remove_trap[<?php print $typename ?>][<?php print $tier_number ?>][<?php print $key ?>]'></td>
                                </tr>
                <?php
            }
        }
    }
    print '<tr><td></td></tr>';
}
// show submit buttons
if (!empty($_SESSION['saved_troop']) OR !empty($_SESSION['saved_trap'])){
?>
                <tr><td colspan='2' align='left'><input type='submit' name='calculate_button' value='Calculate!'></td>
                    <td align='center'><input type='submit' name='remove_type' value='Remove'></td>
                </tr>


<?php
}
else{
    print "You have no saved units!  Go and save some!";
}
        }
// functions
// calculate resource totals
function calculate_resources($all_troops, $rss_calc, $POST, $postkey) {
    foreach ($all_troops as $typename => $type) {   // typename is Normal or Strategic
        foreach ($type as $tier_number => $tier) {  // tier_number is Tiers 1-4
            foreach ($tier as $key => $troop_type) {  // key is 0-3 representing Infantry through Siege
                $rss_calc[$typename][$tier_number][$key]['stone'] = $troop_type['stone'] * @$POST[$postkey][$typename][$tier_number][$key];
                $rss_calc[$typename][$tier_number][$key]['wood'] = $troop_type['wood'] * @$POST[$postkey][$typename][$tier_number][$key];
                $rss_calc[$typename][$tier_number][$key]['ore'] = $troop_type['ore'] * @$POST[$postkey][$typename][$tier_number][$key];
                $rss_calc[$typename][$tier_number][$key]['food'] = $troop_type['food'] * @$POST[$postkey][$typename][$tier_number][$key];
                $rss_calc[$typename][$tier_number][$key]['silver'] = $troop_type['silver'] * @$POST[$postkey][$typename][$tier_number][$key];
            }
        }
    }
    return $rss_calc;
}

function calculate_total($all_troops, $rss_calc, $rss_total, $POST, $postkey) {
    foreach ($all_troops as $typename => $type) {   // typename is Normal or Strategic
        foreach ($type as $tier_number => $tier) {  // tier_number is Tiers 1-4
            foreach ($tier as $key => $troop_type) {  // key is 0-3 representing Infantry through Siege
                if (!empty($POST[$postkey][$typename][$tier_number][$key])) {
                    // calculate the total amount of all resources and troops
                    $rss_total['unit'] += $POST[$postkey][$typename][$tier_number][$key];
                    $rss_total['stone'] += $rss_calc[$typename][$tier_number][$key]['stone'];
                    $rss_total['wood'] += $rss_calc[$typename][$tier_number][$key]['wood'];
                    $rss_total['ore'] += $rss_calc[$typename][$tier_number][$key]['ore'];
                    $rss_total['food'] += $rss_calc[$typename][$tier_number][$key]['food'];
                    $rss_total['silver'] += $rss_calc[$typename][$tier_number][$key]['silver'];
                }
            }
        }
    }
    return $rss_total;
}

function display_resources($all_troops, $POST, $postkey, $rss_calc) {
    foreach ($all_troops as $typename => $type) {
        foreach ($type as $tier_number => $tier) {
            foreach ($tier as $key => $troop_type) {
                if (@$POST[$postkey][$typename][$tier_number][$key] != 0) {
                    printf('<tr><td>%s</td>'    // name of troops
                            . '<td>%s</td>'     // number of troops
                            . '<td>%s</td>'     // stone
                            . '<td>%s</td>'     // wood
                            . '<td>%s</td>'     // ore
                            . '<td>%s</td>'     // food
                            . '<td>%s</td></tr>'     // silver
                            , $troop_type['name'], number_format($POST[$postkey][$typename][$tier_number][$key]), number_format($rss_calc[$typename][$tier_number][$key]['stone']), number_format($rss_calc[$typename][$tier_number][$key]['wood']), number_format($rss_calc[$typename][$tier_number][$key]['ore']), number_format($rss_calc[$typename][$tier_number][$key]['food']), number_format($rss_calc[$typename][$tier_number][$key]['silver']));
                }
            }
        }
    }
}
