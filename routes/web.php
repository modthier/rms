<?php


use App\Models\Setting;
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
use App\Http\Controllers\SummaryController;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ItemTypeController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\ExpenseTypeController;
use App\Http\Controllers\RequirementController;
use App\Http\Controllers\DailyExpenseController;
use App\Http\Controllers\PurchaseOrdersController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\RequirementTypeController;
use App\Http\Controllers\DailyConsumptionController;


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
    $name = Setting::getCached();
    return view('welcome', ['metaTitle' => $name?->name ?? config('app.name')])->with('name', $name);
});

Route::get('/health/live', [HealthController::class, 'live'])->name('health.live');
Route::get('/health/ready', [HealthController::class, 'ready'])->name('health.ready');



Auth::routes(['register' => false]);

Route::group(['middleware' => 'auth'], function () {
Route::get('/home', [HomeController::class,'index'])->name('home');
Route::get('/order/realtime', [OrderController::class,'realtime'])->name('order.realtime');
Route::get('order/dailyReport', [OrderController::class,'dailyReport'])
            ->name('order.dailyReport');

Route::get('order/hourlySearch', [OrderController::class,'hourlySearch'])
            ->name('order.hourlySearch');
Route::group(['middleware' => 'can:admin_only'], function(){


Route::get('/dashboard', [HomeController::class,'dashboard'])->name('admin.dashboard');
Route::resource('payment',PaymentController::class,['except' => ['show']]);

Route::post('getEmployee',[EmployeeController::class,'getEmployee'])->name('employee.getEmployee');

Route::get('employee/calculateSalary',[EmployeeController::class,'calculateSalary'])->name('employee.calculateSalary');


Route::resource('advance',AdvanceController::class,['except' => ['show']]);
Route::resource('attendance',AttendanceController::class,['except' => ['show','create']]);

//Route::resource('dailyExpense',DailyExpenseController::class,['except' => ['show']]);
Route::resource('employee',EmployeeController::class,['except' => ['show']]);
Route::resource('ingredient',IngredientController::class,['except' => ['show']]);
Route::get('item/search',[ItemController::class,'search'])->name('item.search');
Route::resource('item',ItemController::class,['except' => ['show']]);
Route::resource('itemType',ItemTypeController::class,['except' => ['show']]);





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

Route::get('order/canceledOrder/search', [OrderController::class,'canceledSearch'])
            ->name('order.canceledSearch');

Route::get('order/canceledOrder', [OrderController::class,'canceledOrder'])
            ->name('order.canceledOrder');
 Route::get('user/DailyTotal/{user}',[OrderController::class,'dailyTotal'])
           ->name('user.dailyTotal');
            
Route::resource('order',OrderController::class);

Route::get('dailyExpense/report',[DailyExpenseController::class,'showExpenseReport'])
         ->name('dailyExpense.showExpenseReport'); 
Route::get('dailyExpense/report/search', [DailyExpenseController::class,'search'])
            ->name('dailyExpense.search');
// summary           
Route::get('summary/search', [SummaryController::class,'search'])
            ->name('summary.search');
Route::get('summary', [SummaryController::class,'index'])
            ->name('summary.index');
//

Route::resource('unit',UnitController::class,['except' => ['show','destroy','create']]);
Route::resource('setting',SettingController::class,['except' => 
       ['show','destroy','create']]);

Route::get('userManagement/create',[UserManagementController::class,'create'])->name('management.create');
Route::post('userManagement',[UserManagementController::class,'store'])->name('management.store');

Route::get('userManagement/resetPasswordForm/{user}',
      [UserManagementController::class,'resetPasswordForm'])->name('management.resetPasswordForm');

Route::post('userManagement/resetPassword/{user}',[UserManagementController::class,'resetPassword'])->name('management.resetPassword');


Route::post('userManagement/enableUser/{user}',[UserManagementController::class,'enableUser'])->name('management.enableUser');

Route::post('userManagement/disableUser/{user}',[UserManagementController::class,'disableUser'])->name('management.disableUser');

Route::get('userManagement',[UserManagementController::class,'index'])->name('management.index');

});



Route::group(['middleware' => 'can:stockeeper'], function(){
    Route::get('purchaseOrders/search',[PurchaseOrdersController::class,'search'])->name('purchaseOrders.search');;
    Route::resource('purchaseOrders',PurchaseOrdersController::class);
    Route::resource('suppliers',SupplierController::class);
    Route::resource('dailyConsumption',DailyConsumptionController::class,
        ['except' => ['show']]);
    
    Route::resource('stock',StockController::class,['except' => ['show']]);
    Route::resource('expenseType',ExpenseTypeController::class,['except' => ['show']]);
    Route::get('expenseChange/{dailyExpense}',[DailyExpenseController::class,'change'])
         ->name('expense.change');
        
    Route::resource('dailyExpense',DailyExpenseController::class,['except' => ['show']]);
    
    Route::resource('requirementType',RequirementTypeController::class,['except' => ['show']]);
    Route::get('showReqReport',[RequirementController::class,'showReqReport'])
         ->name('requirement.showReqReport');
    Route::get('reqChange/{requirement}',[RequirementController::class,'change'])
         ->name('requirement.change');
    Route::resource('requirement',RequirementController::class,['except' => ['show']]);
    
});

Route::group(['middleware' => 'can:cashier'], function(){

    Route::get('cashier/create',[CashierController::class,'create'])->name('cashier.create');

    Route::get('cashierDashboard',[CashierController::class,'cashierDashboard'])
              ->name('cashier.Dashboard');

    Route::middleware('throttle:order-creation')->group(function () {
        Route::post('cashier-store',[CashierController::class,'store'])->name('cashier.store');
    });

    Route::get('cashier/sales',[CashierController::class,'sales'])->name('cashier.sales');

    Route::get('cashier/sales/{order}',[CashierController::class,'showSales'])->name('cashier.showSales');

    Route::delete('cashier/sales/{order}',[CashierController::class,'destroy'])->name('sales.destroy');
    Route::put('order/{order}',[CashierController::class,'cancelOrder'])
           ->name('order.cancelOrder');

});



});