<?php
// normal troops
$t1_infantry = array('name' => 'Swordsmen', 'stone' => 0, 'wood' => 20, 'ore' => 15, 'food' => 20, 'silver' => 0);
$t1_range = array('name' => 'Slingers','stone' => 20, 'wood' => 20, 'ore' => 0, 'food' => 20, 'silver' => 0);
$t1_calvary = array('name' => 'Outriders','stone' => 20, 'wood' => 0, 'ore' => 15, 'food' => 20, 'silver' => 0);
$t1_siege = array('name' => 'Battering Ram','stone' => 20, 'wood' => 20, 'ore' => 15, 'food' => 20, 'silver' => 0);
$tier1 = array($t1_infantry, $t1_range, $t1_calvary, $t1_siege);

$t2_infantry = array('name' => 'Hoplites', 'stone' => 0, 'wood' => 40, 'ore' => 30, 'food' => 40, 'silver' => 2);
$t2_range = array('name' => 'Skirmish Archers','stone' => 40, 'wood' => 40, 'ore' => 0, 'food' => 40, 'silver' => 2);
$t2_calvary = array('name' => 'Light Calvary','stone' => 40, 'wood' => 0, 'ore' => 30, 'food' => 40, 'silver' => 2);
$t2_siege = array('name' => 'Ballista','stone' => 40, 'wood' => 40, 'ore' => 30, 'food' => 40, 'silver' => 2);
$tier2 = array($t2_infantry, $t2_range, $t2_calvary, $t2_siege);

$t3_infantry = array('name' => 'Armored Pikeman', 'stone' => 0, 'wood' => 60, 'ore' => 45, 'food' => 60, 'silver' => 4);
$t3_range = array('name' => 'Guardians','stone' => 60, 'wood' => 60, 'ore' => 0, 'food' => 60, 'silver' => 4);
$t3_calvary = array('name' => 'Companion Calvary','stone' => 60, 'wood' => 0, 'ore' => 45, 'food' => 60, 'silver' => 4);
$t3_siege = array('name' => 'Siege Tower','stone' => 60, 'wood' => 60, 'ore' => 45, 'food' => 60, 'silver' => 4);
$tier3 = array($t3_infantry, $t3_range, $t3_calvary, $t3_siege);


$t4_infantry = array('name' => 'Immortals', 'stone' => 0, 'wood' => 80, 'ore' => 60, 'food' => 80, 'silver' => 6);
$t4_range = array('name' => 'Marksmen','stone' => 80, 'wood' => 80, 'ore' => 0, 'food' => 80, 'silver' => 6);
$t4_calvary = array('name' => 'War Elephant','stone' => 80, 'wood' => 0, 'ore' => 60, 'food' => 80, 'silver' => 6);
$t4_siege = array('name' => 'Onager','stone' => 80, 'wood' => 80, 'ore' => 60, 'food' => 60, 'silver' => 6);
$tier4 = array($t4_infantry, $t4_range, $t4_calvary, $t4_siege);

$troops = array('Tier 1' => $tier1, 'Tier 2' => $tier2, 'Tier 3' => $tier3, 'Tier 4' => $tier4);

// strategic troops
$s_t1_infantry = array('name' => 'Spearmen', 'stone' => 0, 'wood' => 20, 'ore' => 15, 'food' => 20, 'silver' => 0);
$s_t1_range = array('name' => 'Hunters','stone' => 20, 'wood' => 20, 'ore' => 0, 'food' => 20, 'silver' => 0);
$s_t1_calvary = array('name' => 'Chariots','stone' => 20, 'wood' => 0, 'ore' => 15, 'food' => 20, 'silver' => 0);
$s_tier1 = array($s_t1_infantry, $s_t1_range, $s_t1_calvary);

$s_t2_infantry = array('name' => 'Peltasts', 'stone' => 0, 'wood' => 40, 'ore' => 30, 'food' => 40, 'silver' => 2);
$s_t2_range = array('name' => 'Rangers','stone' => 40, 'wood' => 40, 'ore' => 0, 'food' => 40, 'silver' => 2);
$s_t2_calvary = array('name' => 'Scythed Chariots','stone' => 40, 'wood' => 0, 'ore' => 30, 'food' => 40, 'silver' => 2);
$s_tier2 = array($s_t2_infantry, $s_t2_range, $s_t2_calvary);

$s_t3_infantry = array('name' => 'Phalangite', 'stone' => 0, 'wood' => 60, 'ore' => 45, 'food' => 60, 'silver' => 4);
$s_t3_range = array('name' => 'Stalkers','stone' => 60, 'wood' => 60, 'ore' => 0, 'food' => 60, 'silver' => 4);
$s_t3_calvary = array('name' => 'Lancers','stone' => 60, 'wood' => 0, 'ore' => 45, 'food' => 60, 'silver' => 4);
$s_tier3 = array($s_t3_infantry, $s_t3_range, $s_t3_calvary);


$s_t4_infantry = array('name' => 'Legionnaires', 'stone' => 0, 'wood' => 80, 'ore' => 60, 'food' => 80, 'silver' => 6);
$s_t4_range = array('name' => 'Dianas','stone' => 80, 'wood' => 80, 'ore' => 0, 'food' => 80, 'silver' => 6);
$s_t4_calvary = array('name' => 'Cataphracts','stone' => 80, 'wood' => 0, 'ore' => 60, 'food' => 80, 'silver' => 6);
$s_tier4 = array($s_t4_infantry, $s_t4_range, $s_t4_calvary);

$s_troops = array('Tier 1' => $s_tier1, 'Tier 2' => $s_tier2, 'Tier 3' => $s_tier3, 'Tier 4' => $s_tier4);

$all_troops = array ('Normal Troops' => $troops, 'Strategic Troops' => $s_troops);

?>