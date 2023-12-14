<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\AdvanceController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ItemTypeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\DailyExpenseController;
use App\Http\Controllers\PurchaseOrdersController;
use App\Http\Controllers\UserManagementController;


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

Route::get('/', function () {
    return view('welcome',['metaTitle' => 'بوفية الشباب']);
});



Auth::routes(['register' => false]);

Route::group(['middleware' => 'auth'], function () {
Route::get('/home', [HomeController::class,'index'])->name('home');
Route::get('/order/realtime', [OrderController::class,'realtime'])->name('order.realtime');

Route::group(['middleware' => 'can:admin_only'], function(){


Route::get('/dashboard', [HomeController::class,'dashboard'])->name('admin.dashboard');
Route::resource('payment',PaymentController::class,['except' => ['show']]);

Route::post('getEmployee',[EmployeeController::class,'getEmployee'])->name('employee.getEmployee');

Route::get('employee/calculateSalary',[EmployeeController::class,'calculateSalary'])->name('employee.calculateSalary');


Route::resource('advance',AdvanceController::class,['except' => ['show']]);
Route::resource('attendance',AttendanceController::class,['except' => ['show','create']]);

Route::resource('dailyExpense',DailyExpenseController::class,['except' => ['show']]);
Route::resource('employee',EmployeeController::class,['except' => ['show']]);
Route::resource('ingredient',IngredientController::class,['except' => ['show']]);
Route::resource('item',ItemController::class,['except' => ['show']]);
Route::resource('itemType',ItemTypeController::class,['except' => ['show']]);


Route::get('order/dailyReport', [OrderController::class,'dailyReport'])
            ->name('order.dailyReport');

Route::get('order/weeklyReport', [OrderController::class,'weeklyReport'])
            ->name('order.weeklyReport');
Route::get('order/exportWeekReport', [OrderController::class,'exportWeekReport'])
            ->name('order.exportWeekReport');            
            
Route::get('order/monthlyReport', [OrderController::class,'monthlyReport'])
            ->name('order.monthlyReport');
Route::get('order/exporMonthReport', [OrderController::class,'exporMonthReport'])
            ->name('order.exporMonthReport');            
            
Route::get('order/productReport', [OrderController::class,'productReport'])
            ->name('order.productReport');


 Route::get('user/DailyTotal/{user}',[OrderController::class,'dailyTotal'])
           ->name('user.dailyTotal');
            
Route::resource('order',OrderController::class);



Route::resource('unit',UnitController::class,['except' => ['show','destroy','create']]);
Route::resource('setting',SettingController::class,['except' => 
       ['show','destroy','create']]);

Route::get('userManagement/create',[UserManagementController::class,'create'])->name('management.create');
Route::post('userManagement',[UserManagementController::class,'store'])->name('management.store');

Route::get('userManagement/resetPasswordForm/{user}',
      [UserManagementController::class,'resetPasswordForm'])->name('management.resetPasswordForm');

Route::post('userManagement/resetPassword/{user}',[UserManagementController::class,'resetPassword'])->name('management.resetPassword');


Route::get('userManagement/enableUser/{user}',[UserManagementController::class,'enableUser'])->name('management.enableUser');

Route::get('userManagement/disableUser/{user}',[UserManagementController::class,'disableUser'])->name('management.disableUser');

Route::get('userManagement',[UserManagementController::class,'index'])->name('management.index');

});



Route::group(['middleware' => 'can:stockeeper'], function(){

    Route::get('purchaseOrders',[PurchaseOrdersController::class,'index'])->name('purchaseOrders.index');
    Route::resource('dailyConsumption','DailyConsumptionController',
        ['except' => ['show']]);
    Route::resource('stock',StockController::class,['except' => ['show']]);

});

Route::group(['middleware' => 'can:cashier'], function(){

    Route::get('cashier/create',[CashierController::class,'create'])->name('cashier.create');

    Route::get('cashierDashboard',[CashierController::class,'cashierDashboard'])
              ->name('cashier.Dashboard');
    
    Route::post('cashier-store',[CashierController::class,'store'])->name('cashier.store');

    Route::get('cashier/sales',[CashierController::class,'sales'])->name('cashier.sales');

    Route::get('cashier/sales/{order}',[CashierController::class,'showSales'])->name('cashier.showSales');

    Route::match('delete','cashier/sales/{order}',[CashierController::class,'destroy'])->name('sales.destroy');


});



});