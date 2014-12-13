<?php
// normal traps
$t1_antirange = array('name' => 'Archer Tower','stone' => 40, 'wood' => 40, 'ore' => 0, 'food' => 40, 'silver' => 0);
$t1_anticalvary = array('name' => 'Spikes','stone' => 40, 'wood' => 0, 'ore' => 30, 'food' => 40, 'silver' => 0);
$t1_antiinfantry = array('name' => 'Boiling Tar', 'stone' => 0, 'wood' => 40, 'ore' => 30, 'food' => 40, 'silver' => 0);
$t1_bricks = array('name' => 'War Bricks','stone' => 4, 'wood' => 0, 'ore' => 0, 'food' => 4, 'silver' => 0);
$tier1 = array($t1_antirange, $t1_anticalvary, $t1_antiinfantry, $t1_bricks);

$t2_antirange = array('name' => 'Turrets','stone' => 80, 'wood' => 80, 'ore' => 0, 'food' => 80, 'silver' => 0);
$t2_anticalvary = array('name' => 'Snares','stone' => 80, 'wood' => 0, 'ore' => 60, 'food' => 80, 'silver' => 0);
$t2_antiinfantry = array('name' => 'Steam Cannon', 'stone' => 0, 'wood' => 80, 'ore' => 60, 'food' => 80, 'silver' => 0);
$tier2 = array($t2_antirange, $t2_anticalvary, $t2_antiinfantry);


$t3_antirange = array('name' => 'Catapult','stone' => 120, 'wood' => 120, 'ore' => 0, 'food' => 120, 'silver' => 0);
$t3_anticalvary = array('name' => 'Caltrops','stone' => 120, 'wood' => 0, 'ore' => 90, 'food' => 120, 'silver' => 0);
$t3_antiinfantry = array('name' => 'Burning Rocks', 'stone' => 0, 'wood' => 120, 'ore' => 90, 'food' => 120, 'silver' => 0);
$tier3 = array($t3_antirange, $t3_anticalvary, $t3_antiinfantry);

$t4_antirange = array('name' => 'Trebuchet','stone' => 160, 'wood' => 160, 'ore' => 0, 'food' => 160, 'silver' => 60);
$t4_anticalvary = array('name' => 'Spiked Barricade','stone' => 160, 'wood' => 0, 'ore' => 120, 'food' => 160, 'silver' => 60);
$t4_antiinfantry = array('name' => 'Greek Fire', 'stone' => 0, 'wood' => 160, 'ore' => 120, 'food' => 160, 'silver' => 60);
$tier4 = array($t4_antirange, $t4_anticalvary, $t4_antiinfantry);

$traps = array('Tier 1' => $tier1, 'Tier 2' => $tier2, 'Tier 3' => $tier3, 'Tier 4' => $tier4);

// strategic traps
$s_t1_antirange = array('name' => 'Longbow Tower','stone' => 40, 'wood' => 40, 'ore' => 0, 'food' => 40, 'silver' => 0);
$s_t1_anticalvary = array('name' => 'Pitfall','stone' => 40, 'wood' => 0, 'ore' => 30, 'food' => 40, 'silver' => 0);
$s_t1_antiinfantry = array('name' => 'Rolling Wall', 'stone' => 0, 'wood' => 40, 'ore' => 30, 'food' => 40, 'silver' => 0);
$s_t1_bricks = array('name' => 'Iron Bricks','stone' => 4, 'wood' => 0, 'ore' => 0, 'food' => 4, 'silver' => 0);
$s_tier1 = array($s_t1_antirange, $s_t1_anticalvary, $s_t1_antiinfantry, $s_t1_bricks);

$s_t2_antirange = array('name' => 'Sentry Tower','stone' => 80, 'wood' => 80, 'ore' => 0, 'food' => 80, 'silver' => 0);
$s_t2_anticalvary = array('name' => 'Flaming Carts','stone' => 80, 'wood' => 0, 'ore' => 60, 'food' => 80, 'silver' => 0);
$s_t2_antiinfantry = array('name' => 'Armor Wall', 'stone' => 0, 'wood' => 80, 'ore' => 60, 'food' => 80, 'silver' => 0);
$s_tier2 = array($s_t2_antirange, $s_t2_anticalvary, $s_t2_antiinfantry);

$s_t3_antirange = array('name' => 'Poison Swamp','stone' => 120, 'wood' => 120, 'ore' => 0, 'food' => 120, 'silver' => 0);
$s_t3_anticalvary = array('name' => 'Defense Tower','stone' => 120, 'wood' => 0, 'ore' => 90, 'food' => 120, 'silver' => 0);
$s_t3_antiinfantry = array('name' => 'Pendulum', 'stone' => 0, 'wood' => 120, 'ore' => 90, 'food' => 120, 'silver' => 0);
$s_tier3 = array($s_t3_antirange, $s_t3_anticalvary, $s_t3_antiinfantry);

$s_t4_antirange = array('name' => 'Ballista Tower','stone' => 160, 'wood' => 160, 'ore' => 0, 'food' => 160, 'silver' => 60);
$s_t4_anticalvary = array('name' => 'War Barricade','stone' => 160, 'wood' => 0, 'ore' => 120, 'food' => 160, 'silver' => 60);
$s_t4_antiinfantry = array('name' => 'Smoke Bomb', 'stone' => 0, 'wood' => 160, 'ore' => 120, 'food' => 160, 'silver' => 60);
$s_tier4 = array($s_t4_antirange, $s_t4_anticalvary, $s_t4_antiinfantry);

$s_traps = array('Tier 1' => $s_tier1, 'Tier 2' => $s_tier2, 'Tier 3' => $s_tier3, 'Tier 4' => $s_tier4);

$all_traps = array('Normal Traps' => $traps, 'Strategic Traps' => $s_traps);
?>