<section class="sidebar">
  <!-- Sidebar user panel -->
  <div class="user-panel">
    <div class="pull-left image">
      <img src="{{asset('AdminLTE-2.4.18/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
    </div>
    <div class="pull-left info">
      <p>Alexander Pierce</p>
      <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
    </div>
  </div>
  <!-- search form -->
  <form action="#" method="get" class="sidebar-form">
    <div class="input-group">
      <input type="text" name="q" class="form-control" placeholder="Search...">
      <span class="input-group-btn">
            <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
            </button>
          </span>
    </div>
  </form>
  <!-- /.search form -->
  <ul class="sidebar-menu" data-widget="tree">
    <li class="header">MAIN NAVIGATION</li>
    <li>
      <a href="{{url('home')}}">
        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
      </a>
    </li>
    <li>
      <a href="{{url('events')}}">
        <i class="fa fa-archive"></i> <span>My Event</span>
      </a>
    </li>
    <li>
      <a href="{{url('purchases')}}">
        <i class="fa fa-shopping-cart"></i> <span>My Purchase</span>
      </a>
    </li>
    <li>
      <a href="{{url('withdraw')}}">
        <i class="fa fa-dollar"></i> <span>Withdraw</span>
      </a>
    </li>
    <li>
      <a href="{{url('discover')}}">
        <i class="fa fa-search"></i> <span>Discover Event</span>
      </a>
    </li>
    <li>
      <a href="{{url('refund')}}">
        <i class="fa fa-refresh"></i> <span>Refund</span>
      </a>
    </li>
  </ul>
</section>