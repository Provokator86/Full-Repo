/*
* File Name: murphy_business_income_statement.js
* Created On: Feb 02, 2016
* Created By: SWI Dev
* Purpose: Calculate all the income statement calculation like total revenue, total net sale, total cog etc  
* Dependency: Require jQuery-2.1.4.min.js or newer version
*/

// global namespace
//var MOMS = MOMS || {};

// sub namespace
//MOMS.event = {};

var MOMS = function (year) {
  var field = new Array(),year, fields;
  this.year = year;
  
  /*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Field Section ~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
  field['revenue'] = { 
      field_name : 'revenue_type_year',
      total_field_name : 'total_revenue_year', // A
      add_back_field_name : 'add_back_revenue_type_year',
      adjusted_field_name : 'add_back_adjusted_revenue_type_year',
      other_field_name : 'other_revenue_text',
      total_adjusted_field: 'total_adjusted_revenue_year' // A_
  };
  field['net_sale'] = { 
      field_name : 'net_sale_type_year',
      total_field_name : 'total_net_sale_year', // B
      add_back_field_name : 'add_back_net_sale_type_year',
      adjusted_field_name : 'add_back_adjusted_net_sale_type_year',
      other_field_name : 'other_net_sale_text',
      total_adjusted_field: 'total_adjusted_net_sale_year' // B_
  };
  field['cog'] = { 
      field_name : 'cog_type_year',
      total_field_name : 'total_cog_year', // C
      add_back_field_name : 'add_back_cog_type_year',
      adjusted_field_name : 'add_back_adjusted_cog_type_year',
      other_field_name : 'other_cog_text',
      total_adjusted_field: 'total_adjusted_cog_year' // C_
  };
  field['expense'] = { 
      field_name : 'expense_year',
      total_field_name : 'total_expense_year', // E
      add_back_field_name : 'add_back_expense_year',
      adjusted_field_name : 'add_back_adjusted_expense_year',
      other_field_name : 'other_expense_text',
      total_adjusted_field: 'total_adjusted_expense_year' // E_
  };
  field['fringe_benefit'] = {
      field_name : 'fringe_benefit_year',
      total_field_name : 'total_fringe_benefit_year', // J
      other_field_name : 'other_fringe_benefit_text'
  };
  field['other_expenses'] = {
      field_name : 'other_expenses_year',
      total_field_name : 'total_other_expenses_year', // M
      other_field_name : 'other_other_expense_text'
  };
  this.fields = field;
  this.total_gross_profit_year = 'total_gross_profit_year'; // D
  this.total_net_ope_inc_year = 'total_net_ope_inc_year'; // (F = A - E)
  this.total_net_inc_year = 'total_net_inc_year';  // (G = D - E)
  this.total_earning_before_tax_year = 'total_earning_before_tax_year'; // (H)
  this.total_owner_salary_year = 'total_owner_salary_year'; // I
  this.total_interest_expense_year = 'total_interest_expense_year'; // K
  this.total_depreciation_year = 'total_depreciation_year'; // L
  this.total_amortization_year = 'total_amortization_year'; // Q
  
  this.total_slr_discre_ern_year = 'total_slr_discre_ern_year'; // N
  this.total_manager_salary_year = 'total_manager_salary_year'; // O
  this.total_ebitda_year = 'total_ebitda_year'; // P
};

// Get year value from the text by matching regular expression
MOMS.prototype.get_year = function (text){
    var pattern1 = /(year1)/g, pattern2 = /(year2)/g, pattern3 = /(year3)/g, pattern4 = /(year4)/g, pattern5 = /(year5)/g;
    /*if(pattern1.test(text))
        return '1';
    else */
    if(pattern2.test(text))
        return '2';
    else if(pattern3.test(text))
        return '3';
    else if(pattern4.test(text))
        return '4';
    else if(pattern5.test(text))
        return '5';
    else 
        return '1';
}

// Get id value from the tex
MOMS.prototype.get_id = function(text){
    if(text)
    {
        var t = text.split('_');
        return t.pop() || '';
    }
    return '';
}

// Generate total value corresponding to name
MOMS.prototype.calculate_total = function (type, year, callback){
    var total = 0, field;
    callback = callback ? true : callback;
    year = year || 1;
    field = this.fields[type];
    $("input[name^='"+field['field_name']+year+"']").each(function(){
        total += (parseInt($(this).val()) || 0);
    });
    $('#'+field['total_field_name']+year).val(total);
    //$('#'+field['total_adjusted_field']+year).val(total);
    if(callback)
        $('#'+field['total_adjusted_field']+year).val(total);
}

// Generate total value corresponding to name
MOMS.prototype.calculate_adjusted_total = function (type, year, _this, target){
    var parent = _this.parent().parent().parent(), this_value = _this.val() || 0;
    if(_this.parent().parent().hasClass('width_80'))
        parent = parent.parent();
        
    var parent_id = parent.attr('id'), id = get_id(parent_id);
    var target_obj =  $('#'+target+id);
    field = this.fields[type];
    var add_back = parseInt(target_obj.find('input[name^="'+field['add_back_field_name']+year+'"]').val()) || 0;
    target_obj.find('input[name^="'+field['adjusted_field_name']+year+'"]').val(this_value - add_back);
    
    // Calculate total
    var total_adjusted_revenue = 0;
    $('input[name^="'+field['adjusted_field_name']+year+'"]').each(function(i){
        total_adjusted_revenue += (parseInt($(this).val()) || 0);
    });
    $('#'+field['total_adjusted_field']+year).val(total_adjusted_revenue);
    
    // Calculate gross profit
    this.calculate_total_gross_profit(year, _this);
    
    // Calculate net operating income and income
    this.calculate_total_net_operating_income_and_income(year)
}


/*
+---------------------------------------------------------------------------+
|                               Revenue Section                             | 
+---------------------------------------------------------------------------+
*/
// Calculate total revenue
MOMS.prototype.calculate_total_revenue = function(_this) {
    var year = 1, name = _this.attr('name');
    year = this.get_year(name);
    this.calculate_total('revenue', year);
    
    // Calculate add back and adjusted
    this.calculate_adjusted_total('revenue', year, _this, 'add_back_revenue_');
}

/*
+---------------------------------------------------------------------------+
|                               Net Sale                                    | 
+---------------------------------------------------------------------------+
*/   
// Calculate total net sale
MOMS.prototype.calculate_total_net_sale = function(_this) {
    var year = 1, name = _this.attr('name');
    year = this.get_year(name);
    this.calculate_total('net_sale', year);
    
    // Calculate add back and adjusted
    this.calculate_adjusted_total('net_sale', year, _this, 'add_back_net_sale_');
}

/*
+---------------------------------------------------------------------------+
|                               COG                                         | 
+---------------------------------------------------------------------------+
*/   
// Calculate total cog
MOMS.prototype.calculate_total_cog = function(_this) {
    var year = 1, name = _this.attr('name');
    year = this.get_year(name);
    this.calculate_total('cog', year);
    
    // Calculate add back and adjusted
    this.calculate_adjusted_total('cog', year, _this, 'add_back_cog_');
}

/*
+---------------------------------------------------------------------------+
|                               Expense                                     | 
+---------------------------------------------------------------------------+
*/   
// Calculate total expense
MOMS.prototype.calculate_total_expense = function(_this) {
    var year = 1, name = _this.attr('name');
    year = this.get_year(name);
    this.calculate_total('expense', year);
    
    // Calculate add back and adjusted
    this.calculate_adjusted_total('expense', year, _this, 'add_back_expense_');
}

/*
+---------------------------------------------------------------------------+
|                           Gross Profit                                    | 
+---------------------------------------------------------------------------+
*/   
// Calculate total gross profit
MOMS.prototype.calculate_total_gross_profit = function(year, _this) {
    var name = _this.attr('name'), total = 0;
    year = year || 1;
    var field_rev = this.fields['revenue'], field_net_sale = this.fields['net_sale'], field_cog = this.fields['cog'];
    total = ($("input[name^='"+field_rev['total_adjusted_field']+year+"']").val() || 0) - ($("input[name^='"+field_cog['total_adjusted_field']+year+"']").val() || 0);
    // Set value
    $('#total_gross_profit_year'+year).val(total);
}

/*
+---------------------------------------------------------------------------+
|                       Net operating income                                | 
+---------------------------------------------------------------------------+
*/   
// Calculate total Net operating income
MOMS.prototype.calculate_total_net_operating_income_and_income = function(year) {
    var total_income = 0,total_gross_profit = 0, total_expense = 0; // A, D, E
    total_income = parseInt($('#total_adjusted_revenue_year'+year).val()) || 0;
    total_gross_profit = parseInt($('#total_gross_profit_year'+year).val()) || 0;
    total_expense = parseInt($('#total_adjusted_expense_year'+year).val()) || 0;
    
    // Assign those value to the total income
    $('#total_net_ope_inc_year'+year).val(total_income-total_expense); // F = A - E
    $('#total_earning_before_tax_year'+year).val(total_gross_profit-total_expense); // H = F
    $('#total_net_inc_year'+year).val(total_gross_profit-total_expense); // G = D - E   
}

/*
+---------------------------------------------------------------------------+
|                       Frienge Benefit                                     | 
+---------------------------------------------------------------------------+
*/ 
MOMS.prototype.calculate_total_fringe_benefit = function (_this){
    var year = 1, name = _this.attr('name');
    year = this.get_year(name);
    this.calculate_total('fringe_benefit', year, false);
}

/*
+---------------------------------------------------------------------------+
|                  Extraordinary / Other Expenses                           | 
+---------------------------------------------------------------------------+
*/ 
MOMS.prototype.calculate_total_other_expenses = function (_this){
    var year = 1, name = _this.attr('name');
    year = this.get_year(name);
    this.calculate_total('other_expenses', year, false);
}

/*
+---------------------------------------------------------------------------+
|                  Calculate Interest Expense                               | 
+---------------------------------------------------------------------------+
*/ 
MOMS.prototype.calculate_total_interest = function (_this){
    var year = 1, name = _this.attr('name');
    year = this.get_year(name);
    this.calculate_total('other_expenses', year, false);
}

/*~~~~~~~~~~~Total~~~~~~~~~~~*/
// Calculate total revenue                                  // Done
// Calculate total net sale                                 // Done
// Calculate total cog                                      // Done
// Calculate total expenses                                 // Done

/*~~~~~~~~~Add Back~~~~~~~~~~*/
// Calculate add back and it's total of revenue             // Done
// Calculate add back and it's total of net sale            // Done
// Calculate add back and it's total of cog                 // Done
// Calculate add back and it's total of expense             // Done

/*~~~~~~~~~Calculated~~~~~~~~*/
// Calculate total gross profit                             // Done
// Calculate total Net Operating Income                     // Done
// Calculate total Net Income                               // Done
// Calculate total Earnings Before Tax                      // Done

// Calculate total Owner's Salary                           //

// Calculate total Owner's Fringe Benefits                  // Done

// Calculate total Interest Expense                         //

// Calculate total Depreciation                             //

// Calculate total Amortization                             //

// Calculate total Extraordinary / Other Expenses           // Done

// Calculate total Sellers Discretionary Earnings           //    
 
// Calculate total Normalized Owner/Manager Salary          //

// Calculate total EBITDA                                   //

/*var incst = new MOMS();
incst.calculate_total('revenue', 1);
incst.calculate_total('cog', 1);
incst.calculate_total('net_sale', 1);*/