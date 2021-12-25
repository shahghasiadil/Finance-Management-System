<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/dashboard');
// Allocations Routes
Route::get('/get_selected_expensecode', 'AllocationController@get_selected_expensecodes');
Route::get('/get_selected_catcodes', 'AllocationController@get_selected_catcodes');
Route::get('/get_selected_allocation', 'AllocationController@get_selected_allocation');
Route::get('/get_allocated_budgetcode', 'AllocationController@allocated_budgetcode');
Route::get('/expensecodes', 'AllocationController@expensecode');
Route::get('/get_proj_alloc', 'AllocationController@get_proj_alloc');
Route::get('/get_projects', 'AllocationController@get_projects');
Route::get('/budgetcatcodes', 'AllocationController@budgetcatcodes');
Route::get('/budgetcodes', 'AllocationController@get_budgetcodes');
Route::get('/search_allocation', 'AllocationController@search_allocation');
Route::get('/get_allocation', 'AllocationController@get_allocations');
Route::resource('allocation', 'AllocationController');

// Expense Codes Routes
Route::get('/get_budgetcatcodes', 'ExpenseController@budgetcatcodes');
Route::get('/search_expensecode', 'ExpenseController@search_expensecode');
Route::get('/get_expensecode', 'ExpenseController@get_expensecode');
Route::resource('expensecode', 'ExpenseController');

// Budget Category Routes
Route::get('/get_budgetcodes', 'BudgetCatController@get_budgetcodes');
Route::get('/search_budgetcatcode', 'BudgetCatController@search_budgetcatcode');
Route::get('/get_budgetcatcode', 'BudgetCatController@get_budgetcatcode');
Route::resource('budgetcatcode', 'BudgetCatController');

// Budget Code Routes
Route::get('/search_budgetcode', 'BudgetController@search_budgetcode');
Route::get('/get_budgetcode', 'BudgetController@get_budgetcode');
Route::resource('budgetcode', 'BudgetController');

// Project Routes
Route::get('/search_project', 'ProjectController@search_project');
Route::get('/get_project', 'ProjectController@get_project');
Route::resource('project', 'ProjectController');


Auth::routes();


// Users Routes




// Route::view('/Projects', 'admin.Projects');

Route::get('/{path}', 'HomeController@index')->where('path', '[A-Za-z]+');

// Journals Routes
Route::resource('journal', 'JournalController');
Route::get('/get_journal', 'JournalController@get_journal');
Route::get('/get_expense_codes', 'JournalController@get_expense_codes');
Route::get('/get_budget_cat_codes', 'JournalController@get_budget_cat_codes');
Route::get('/get_vouchers', 'JournalController@get_vouchers');
Route::get('/get_budget_codes', 'JournalController@get_budget_codes');
Route::get('/search_journal', 'JournalController@search_journal');
// Vouchers Routes
Route::resource('voucher', 'VoucherController');
Route::get('/get_voucher', 'VoucherController@get_voucher');
Route::get('/search_voucher', 'VoucherController@search_voucher');
