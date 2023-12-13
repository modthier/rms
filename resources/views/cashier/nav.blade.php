<nav class="navbar header-top navbar-expand-lg mb-3  navbar-light bg-light">
      <span class="navbar-toggler-icon leftmenutrigger" style="margin-right: 20px;"></span>
      <h1 class="navbar-brand" style="margin-right: 1em;"> {{ $name->name }} </h1>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav animate side-nav navbar-dark bg-dark" style="z-index: 1000;">

          <li class="nav-item">
            <a class="nav-link text-white" target="_blanck" href="{{ route('cashier.sales') }}">
              <i class="fa fa-external-link-alt"></i>
              المبيعات
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link text-white" target="_blanck" href="{{ route('cashier.create') }}">
              <i class="fa fa-external-link-alt"></i>
              الكاشير
            </a>
          </li>
          <li class="nav-item">
            
            <a class="nav-link text-white" href="{{ route('logout') }}"  onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">
                <i class="fa fa-external-link-alt"></i>

              {{ __('Logout') }}
       
      

              </a>
          </li>
        </ul>
      </div>
    </nav>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
    </form>