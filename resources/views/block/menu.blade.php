<nav class="navbar is-transparent is-fixed-top">
<div class="navbar-brand">
  <a class="navbar-item" href="{{ route('home') }}">
    <img src="/MyCoin-logo.png" alt="My Coin - Analyize your CryptoCurrency" width="112" height="28">
  </a>
  <div class="navbar-burger burger" data-target="nav-menu" v-on:click="showNav = !showNav" v-bind:class="{ 'is-active' : showNav }">
    <span></span>
    <span></span>
    <span></span>
  </div>
</div>

<div id="nav-menu" class="navbar-menu" v-bind:class="{ 'is-active' : showNav }">
  <div class="navbar-start">
    <a class="navbar-item" href="{{ route('home') }}">
      Home
    </a>
    <a class="navbar-item" href="{{ route('dashboard') }}">
      Dashboard
    </a>
    <a class="navbar-item" href="{{ route('trades') }}">
      Trades
    </a>
        <a class="navbar-item" href="{{ route('viewinstrumentmany', ["instrument" => "LTCEUR", "many" => "10"]) }}">
      View Instrument
    </a>
  </div>
  <div class="navbar-end">
    @if (Auth::guest())
        <a class="navbar-item " href="{{ route('login') }}">Login</a>
        <!--a class="navbar-item " href="{{ route('register') }}">Register</a-->
    @else
        <div class="navbar-item has-dropdown is-hoverable">
            <a class="navbar-link" href="#">{{ Auth::user()->name }}</a>

            <div class="navbar-dropdown">
                <a class="navbar-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                  <span class="icon" >
                    <i class="fa fa-lg fa-sign-out "></i>
                  </span>
                  Logout
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                      style="display: none;">
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
    @endif
</div>
</div>

</nav>