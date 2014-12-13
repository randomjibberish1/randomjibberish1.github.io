<?php
session_save_path('.');
session_start();
require 'trap_info.inc';
// check for saved values
if (array_key_exists('saved_trap', $_POST)) {
    $was_type_saved = false;
    foreach ($all_traps as $typename => $type) {
        foreach ($type as $tier_number => $tier) {
            foreach ($tier as $key => $trap_type) {
                if ($_POST['saved_trap'][$typename][$tier_number][$key] == 1){
                    $_SESSION['saved_trap'][$typename][$tier_number][$key] = true;
                    $was_type_saved = true;
                }
            }
        }
    }
    if ($was_type_saved == true){
        $_SESSION['trap_type_saved'] = true;
        header("Location: saved.php");
    }
}


    require 'header.inc';


//var_dump($_POST);
    ?>
    <center>
        <h1>Trap Salvage Calculator</h1>
    </center>
    <?php
    if (array_key_exists('calculate_button', $_POST)) {

// validate input
        $errors = validate_quantity($_POST['quantity']);
// if there are errors, reprint the table with stick values and die.
        if (!empty($errors)) {
            display_errors($errors);
            print_error_table($all_traps, $_POST);
            die;
        }

// calculating resources and totals
        $rss_total = array('traps' => 0, 'stone' => 0, 'wood' => 0, 'ore' => 0, 'food' => 0, 'silver' => 0);
        $rss_calc = array();

        $rss_calc = calculate_resources($all_traps, $rss_calc, $_POST);
        $rss_total = calculate_total($rss_calc, $rss_total, $_POST);


// if there are no traps to heal, state so and die
        if ($rss_total['traps'] == 0) {
            ?>
            <h3> <center>There are no traps to salvage!  You're good!</h3>
            <form action="<?php print $_SERVER['PHP_SELF'] ?>" method="POST">
                <tr><td colspan='7'><center><input type='submit' name='reload' value='Start Over'></td></tr>
                    </form>
                </center>
                <?php
                die;
            }

            // print table of values
            ?>
            <center>
                <form action='<?php print $_SERVER['PHP_SELF'] ?>' method='POST'>
                    <table width='600px'>      
                        <?php
                        if ($_SESSION['logged_in'] == true) {
                            print '<tr><td></td>';
                        } else {
                            print '<tr>';
                        }
                        ?>
                        <td><b>Name</td><td><b>Troops</b></td><td><b>Stone</td><td><b>Wood</td><td><b>Ore</td><td><b>Food</td><td><b>Silver</td>
                        <?php
                        // printing out the resource values
                        foreach ($all_traps as $typename => $type) {
                            foreach ($type as $tier_number => $tier) {
                                foreach ($tier as $key => $trap_type) {
                                    if ($_POST['quantity'][$typename][$tier_number][$key] != 0) {
                                        if ($_SESSION['logged_in'] == true) {
                                            ?>
                                            <tr><td><input type='checkbox' name='saved_trap[<?php print $typename ?>][<?php print $tier_number ?>][<?php print $key ?>]' value='1'></td>
                                                <?php
                                            } else {
                                                print '<tr>';
                                            }
                                            printf('<td>%s</td>'    // name of traps
                                                    . '<td>%s</td>'     // number of traps
                                                    . '<td>%s</td>'     // stone
                                                    . '<td>%s</td>'     // wood
                                                    . '<td>%s</td>'     // ore
                                                    . '<td>%s</td>'     // food
                                                    . '<td>%s</td></tr>'     // silver
                                                    , $trap_type['name'], number_format($_POST['quantity'][$typename][$tier_number][$key]), number_format($rss_calc[$typename][$tier_number][$key]['stone']), number_format($rss_calc[$typename][$tier_number][$key]['wood']), number_format($rss_calc[$typename][$tier_number][$key]['ore']), number_format($rss_calc[$typename][$tier_number][$key]['food']), number_format($rss_calc[$typename][$tier_number][$key]['silver']));
                                        }
                                    }
                                }
                            }
                            // print total row
                            if ($_SESSION['logged_in'] == true) {
                                print '<tr><td></td>';
                            } else {
                                print '<tr>';
                            }
                            print '<td><b>Totals</b></td>';
                            foreach ($rss_total as $key => $amount) {
                                printf("<td><b>%s</b></td>", number_format($rss_total[$key]));
                            }
                            // option to save trap type for the "Saved Options" page
                            print '<tr><td>&nbsp;</td></tr><tr>';
                            if ($_SESSION['logged_in'] == true) {
                                ?><td colspan='4' align='left'>
                                    <input type='submit' name='save_traps' value='Save Checked Traps'></form></td>
                                    <?php
                                }

                                // button to refresh the page
                                ?>
                        <form action="<?php print $_SERVER['PHP_SELF'] ?>" method="POST">
                            <td colspan='4' align='right'><input type='submit' name='reload' value='Start Over'></td></tr>
                        </form>
                    </table>
            </center>

        <?php
    }


// request input for trap healing values
    else {
        print_table($all_traps);
    }

// functions
// calculate resource totals
    function calculate_resources($all_traps, $rss_calc, $POST) {
        foreach ($all_traps as $typename => $type) {   // typename is Normal or Strategic
            foreach ($type as $tier_number => $tier) {  // tier_number is Tiers 1-4
                foreach ($tier as $key => $trap_type) {  // key is 0-3 representing Infantry through Siege
                    $rss_calc[$typename][$tier_number][$key]['stone'] = $trap_type['stone'] * $POST['quantity'][$typename][$tier_number][$key];
                    $rss_calc[$typename][$tier_number][$key]['wood'] = $trap_type['wood'] * $POST['quantity'][$typename][$tier_number][$key];
                    $rss_calc[$typename][$tier_number][$key]['ore'] = $trap_type['ore'] * $POST['quantity'][$typename][$tier_number][$key];
                    $rss_calc[$typename][$tier_number][$key]['food'] = $trap_type['food'] * $POST['quantity'][$typename][$tier_number][$key];
                    $rss_calc[$typename][$tier_number][$key]['silver'] = $trap_type['silver'] * $POST['quantity'][$typename][$tier_number][$key];
                }
            }
        }
        return $rss_calc;
    }

    function calculate_total($rss_calc, $rss_total, $POST) {
        foreach ($rss_calc as $typename => $type) {   // typename is Normal or Strategic
            foreach ($type as $tier_number => $tier) {  // tier_number is Tiers 1-4
                foreach ($tier as $key => $trap_type) {  // key is 0-3 representing Infantry through Siege
                    // calculate the total amount of all resources and traps
                    $rss_total['traps'] += $_POST['quantity'][$typename][$tier_number][$key];
                    $rss_total['stone'] += $rss_calc[$typename][$tier_number][$key]['stone'];
                    $rss_total['wood'] += $rss_calc[$typename][$tier_number][$key]['wood'];
                    $rss_total['ore'] += $rss_calc[$typename][$tier_number][$key]['ore'];
                    $rss_total['food'] += $rss_calc[$typename][$tier_number][$key]['food'];
                    $rss_total['silver'] += $rss_calc[$typename][$tier_number][$key]['silver'];
                }
            }
        }
        return $rss_total;
    }

    function validate_quantity($POST) {
        $errors = array();
        foreach ($POST as $typename => $type) {   // typename is Normal or Strategic
            foreach ($type as $tier_number => $tier) {  // tier_number is Tiers 1-4
                foreach ($tier as $key => $quantity) {
                    // key is 0-3 representing Infantry through Siege
                    if (!is_numeric($quantity) AND ! empty($quantity)) {
                        $errors['not_number'] = "Numbers only!";
                    }
                    if ($quantity < 0) {
                        $errors['not_non-negative'] = "No negatives!";
                    }
                    if ($quantity - round($quantity, 0) != 0) {
                        $errors['not_integer'] = "Whole numbers!";
                    }
                }
            }
        }
        return $errors;
    }

    // function to print errors
    function display_errors($errors) {
        if (isset($errors['not_number']))
            echo " <center><font color='red'>{$errors['not_number']}<br></font></center>";
        if (isset($errors['not_non-negative']))
            echo "<center><font color='red'>{$errors['not_non-negative']}<br></font></center>";
        if (isset($errors['not_integer']))
            echo "<center><font color='red'>{$errors['not_integer']}<br></font></center>";
    }

    function print_table($all_traps) {
        ?>
            <center>
                <table width="800px">
                    <form action="<?php print $_SERVER['PHP_SELF'] ?>" method="POST">
        <?php
        foreach ($all_traps as $typename => $type) {
            printf('<tr><td colspan=9><center><h3>%s</h3></center></td></tr>', $typename);
            print "<tr><td width = '8%'></td>
                                                <td colspan=2 align=center width = '16%'><b>Anti-Ranged</b></td>
                                                <td colspan=2 align=center width = '16%'><b>Anti-Calvary</b></td>
                                                <td colspan=2 align=center width = '16%'><b>Anti-Infantry</b></td>
                                                <td colspan=2 align=center width = '16%'><b>Bricks</b></td>";

            foreach ($type as $tier_number => $tier) {
                printf('</tr><tr><td><b>%s</b></td>', $tier_number);
                foreach ($tier as $key => $trap_type) {
                    printf("<td align=right><input type=text maxlength=7 size=5 name='quantity[%s][%s][] value=''></td><td>%s</td>", $typename, $tier_number, $trap_type['name']);
                }
                print '<tr><td>&nbsp</td></tr>';
            }
            print '<tr><td>&nbsp</td></tr>';
        }
        ?>
                        <tr>


                            <td colspan='9'><center><input type="submit" name="calculate_button" value="Calculate!"></td></tr>
                            </table> 
                        </center>
        <?php
    }

    function print_error_table($all_traps, $POST) {
        ?>
                        <center>
                            <table width="800px">
                                <form action="<?php print $_SERVER['PHP_SELF'] ?>" method="POST">
        <?php
        foreach ($all_traps as $typename => $type) {
            printf('<tr><td colspan=9><center><h3>%s</h3></center></td></tr>', $typename);
            print "<tr><td width = '8%'></td>
                                                <td colspan=2 align=center width = '16%'><b>Infantry</b></td>
                                                <td colspan=2 align=center width = '16%'><b>Ranged</b></td>
                                                <td colspan=2 align=center width = '16%'><b>Calvary</b></td>";
            if (count($type['Tier 1']) > 3) {
                print "<td colspan=2 align=center width = '8%'><b>Siege</b></td>";
            }
            foreach ($type as $tier_number => $tier) {
                printf('</tr><tr><td><b>%s</b></td>', $tier_number);
                foreach ($tier as $key => $trap_type) {
                    ?> 
                                                <td align=right><input type=text maxlength=7 size=5 name='quantity[<?php print $typename ?>][<?php print $tier_number ?>][]' value='<?php print $POST['quantity'][$typename][$tier_number][$key] ?>'></td><td><?php print $trap_type['name'] ?></td>
                                                <?php
                                            }
                                            print '<tr><td>&nbsp</td></tr>';
                                        }
                                        print '<tr><td>&nbsp</td></tr>';
                                    }
                                    ?>
                                    <tr>


                                        <td colspan='9'><center><input type="submit" name="calculate_button" value="Calculate!"></td></tr>
                                        </table> 
                                    </center>
        <?php
    }
    