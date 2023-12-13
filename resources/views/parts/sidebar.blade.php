<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
      <div class="c-sidebar-brand d-lg-down-none">
          <a class="text-white" href="{{ route('admin.dashboard') }}">{{ env('ADMIN_PAGE') }}</a>
      </div>
      <ul class="c-sidebar-nav">
        @can('admin_only')
        <li class="c-sidebar-nav-item c-sidebar-nav-dropdown"><a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
            <svg class="c-sidebar-nav-icon">
              <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-cursor') }}"></use>
            </svg> الاصناف </a>
          <ul class="c-sidebar-nav-dropdown-items">
             <li class="c-sidebar-nav-item">
              <a class="c-sidebar-nav-link" target="_blanck" href="{{ route('cashier.create') }}"><span class="c-sidebar-nav-icon"></span> 
                  <i class="fa fa-external-link-alt" style="padding-left: 5px;"></i>
                 نقطة البيع
              </a>
            </li>
            
            <li class="c-sidebar-nav-item">
              <a class="c-sidebar-nav-link" target="_blanck" href="{{ route('order.realtime') }}"><span class="c-sidebar-nav-icon"></span> 
                  <i class="fa fa-external-link-alt" style="padding-left: 5px;"></i>
                 قائمة الطلبات
              </a>
            </li>
            <li class="c-sidebar-nav-item">
              <a class="c-sidebar-nav-link" href="{{ route('item.index') }}"><span class="c-sidebar-nav-icon"></span> 
                 قائمة الاصناف
              </a>
            </li>
            <li class="c-sidebar-nav-item">
              <a class="c-sidebar-nav-link" href="{{ route('itemType.index') }}"><span class="c-sidebar-nav-icon"></span> 
                أنواع الاصناف
              </a>
            </li>

            <li class="c-sidebar-nav-item">
              <a class="c-sidebar-nav-link" href="{{ route('ingredient.index') }}"><span class="c-sidebar-nav-icon"></span> 
                 المكونات الاساسية
              </a>
            </li>

          </ul>
        </li>
        @endcan

        <li class="c-sidebar-nav-item c-sidebar-nav-dropdown"><a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
            <svg class="c-sidebar-nav-icon">
              <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-cursor') }}"></use>
            </svg> ادارة المخزون </a>
          <ul class="c-sidebar-nav-dropdown-items">
            <li class="c-sidebar-nav-item">
              <a class="c-sidebar-nav-link" href="{{ route('purchaseOrders.index') }}"><span class="c-sidebar-nav-icon"></span> 
                 قائمة  المشتريات
              </a>
            </li>

            <li class="c-sidebar-nav-item">
              <a class="c-sidebar-nav-link" href="{{ route('stock.index') }}"><span class="c-sidebar-nav-icon"></span> 
                 قائمة  المخزون
              </a>
            </li>
            <li class="c-sidebar-nav-item">
              <a class="c-sidebar-nav-link" href="{{ route('dailyConsumption.index') }}"><span class="c-sidebar-nav-icon"></span> 
                الاستهلاك اليومي
              </a>
            </li>

             <li class="c-sidebar-nav-item">
              <a class="c-sidebar-nav-link" href="{{ route('dailyExpense.index') }}"><span class="c-sidebar-nav-icon"></span> 
                المنصرفات 
              </a>
            </li>
           

          </ul>
        </li>
         @can('admin_only')
        <li class="c-sidebar-nav-item c-sidebar-nav-dropdown"><a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
            <svg class="c-sidebar-nav-icon">
              <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-cursor') }}"></use>
            </svg>  شئون الموظفين  </a>
          <ul class="c-sidebar-nav-dropdown-items">
            <li class="c-sidebar-nav-item">
              <a class="c-sidebar-nav-link" href="{{ route('employee.index') }}"><span class="c-sidebar-nav-icon"></span> 
                 قائمة الموظفين
              </a>
            </li>
            <li class="c-sidebar-nav-item">
              <a class="c-sidebar-nav-link" href="{{ route('advance.index') }}"><span class="c-sidebar-nav-icon"></span> 
                السلفيات
              </a>
            </li>

            <li class="c-sidebar-nav-item">
              <a class="c-sidebar-nav-link" href="{{ route('attendance.index') }}"><span class="c-sidebar-nav-icon"></span> 
                قائمة الحضور
              </a>
            </li>

            <li class="c-sidebar-nav-item">
              <a class="c-sidebar-nav-link" href="{{ route('employee.calculateSalary') }}"><span class="c-sidebar-nav-icon"></span> 
                كشف الرواتب
              </a>
            </li>
          </ul>
        </li>


        <li class="c-sidebar-nav-item c-sidebar-nav-dropdown"><a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
            <svg class="c-sidebar-nav-icon">
              <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-cursor') }}"></use>
            </svg>   المستخدمين  </a>
          <ul class="c-sidebar-nav-dropdown-items">
            <li class="c-sidebar-nav-item">
              <a class="c-sidebar-nav-link" href="{{ route('management.index') }}"><span class="c-sidebar-nav-icon"></span> 
                   قائمة  المستخدمين
              </a>
            </li>
           
          </ul>
        </li>


         <li class="c-sidebar-nav-item c-sidebar-nav-dropdown"><a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
            <svg class="c-sidebar-nav-icon">
              <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-cursor') }}"></use>
            </svg>  التقارير  </a>
          <ul class="c-sidebar-nav-dropdown-items">
            <li class="c-sidebar-nav-item">
              <a class="c-sidebar-nav-link" href="{{ route('order.index') }}"><span class="c-sidebar-nav-icon"></span> 
                   تقرير المبيعات
              </a>
            </li>


            <li class="c-sidebar-nav-item">
              <a class="c-sidebar-nav-link" href="{{ route('order.dailyReport') }}"><span class="c-sidebar-nav-icon"></span> 
                    التقرير اليومي
              </a>
            </li>

            <li class="c-sidebar-nav-item">
              <a class="c-sidebar-nav-link" href="{{ route('order.weeklyReport') }}"><span class="c-sidebar-nav-icon"></span> 
                    التقرير  الاسبوعي
              </a>
            </li>

            
            <li class="c-sidebar-nav-item">
              <a class="c-sidebar-nav-link" href="{{ route('order.monthlyReport') }}"><span class="c-sidebar-nav-icon"></span> 
                    التقرير  الشهري
              </a>
            </li>            

            
           
          </ul>
        </li>


        <li class="c-sidebar-nav-item c-sidebar-nav-dropdown"><a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
            <svg class="c-sidebar-nav-icon">
              <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-cursor') }}"></use>
            </svg>  الضبط  </a>
          <ul class="c-sidebar-nav-dropdown-items">
            <li class="c-sidebar-nav-item">
              <a class="c-sidebar-nav-link" href="{{ route('unit.index') }}"><span class="c-sidebar-nav-icon"></span> 
                   وحدات القياس
              </a>
            </li>

            <li class="c-sidebar-nav-item">
              <a class="c-sidebar-nav-link" href="{{ route('setting.index') }}"><span class="c-sidebar-nav-icon"></span> 
                   ضبط النظام
              </a>
            </li>


            <li class="c-sidebar-nav-item">
              <a class="c-sidebar-nav-link" href="{{ route('payment.index') }}"><span class="c-sidebar-nav-icon"></span> 
                   طرق الدفع
              </a>
            </li>
           
          </ul>
        </li>
        @endcan
      </ul>
      <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
    </div>