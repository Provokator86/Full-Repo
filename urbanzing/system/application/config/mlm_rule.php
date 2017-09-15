<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * $mlm_rule    is an array which hold the state/type/rules of a mlm product. Element of each array are follow...
 * key of array $mlm_rule holds the name of the rule. It will goes to the product table. Each product holds 
 *      the name of the key means all the element/attribute will inharit the tree of that perticuliar product.
 * name             = name of the rule
 * description      = description of the rule
 * payment_type     = when the payment will generate. (LNA=>Last node all,
 *                                                  RLNA=>1st node will be 2:1 or 1:2 and then last node all,
 *                                                  R11M=>1st node will be 2:1 or 1:2 and then last node all,
 *                                                  RAN=>2:1 or 1:2 for all node)
 * payment_upto     = upto which level the payment will be generate. (-1 means payment will be generate upto nth level)
 * payment_amount   = the amount will generate after payout. if it is array means the value of that array will
 *                      be the payout amount for each level respectly.
 * payment_unit     = the unit of the payment (e.g. Rs., 1gm of gold, tour)
 * payment_rule     = the amount generation formula in every level (e.g. l*a=level*amount)
 * payment_interval = payment generation interval time. Unite is days
 * bonous           = if the user get bonous after arrive a perticuliar level. (yes/no/level). level means which
 *                      will give the bonous after get the particuliar level intervel. Yes means the bonous will
 *                      generate after arrive the perticuliar level.
 * bonous_amount    = amount given as bonous. if it is array, key of the array will be the level number
 * bonous_unit      = like payment unit
 */
$mlm_rule   = array(
            'rule_one'=>array(
                'name'=>'Rule One',
                'description'=>'This is test description',
                'payment_type'=>'LNA',
                'payment_upto'=>12,
                'payment_amount'=>100,
                'payment_unit'=>'Rs.',
                'payment_rule'=>'(member/2)*amount',
                'bonous'=>10,
                'bonous_amount'=>5000,
                'bonous_unit'=>'Rs.'
                ),
            'rule_two'=>array(
                'name'=>'Rule Two',
                'description'=>'This is test description',
                'payment_type'=>'R11M',
                'payment_upto'=>-1,
                'payment_amount'=>500,
                'payment_unit'=>'Rs.',
                'payment_rule'=>'(amount*1)',
                'bonous'=>10,
                'bonous_amount'=>5000,
                'bonous_unit'=>'Rs.'
                )
        );

?>
