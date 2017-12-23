<nav class="navbar is-transparent is-fixed-top">
<div class="navbar-brand">
  <a class="navbar-item" href="{{ route('home') }}">
    <img src="/MyCoin-logo.png" alt="My Coin - Analyize your CryptoCurrency" width="112" height="28">
  </a>
  <div class="navbar-burger burger" data-target="navbarExampleTransparentExample">
    <span></span>
    <span></span>
    <span></span>
  </div>
</div>

<div id="navbarExampleTransparentExample" class="navbar-menu">
  <div class="navbar-start">
    <a class="navbar-item" href="{{ route('home') }}">
      Home
    </a>
    <a class="navbar-item" href="{{ route('dashboard') }}">
      Dashboard
    </a>
    
    <!--
    <div class="navbar-item has-dropdown is-hoverable">
      <a class="navbar-link" href="#">
        Docs
      </a>
      
      <div class="navbar-dropdown is-boxed">
        <a class="navbar-item" href="{{ route('tickers') }}">
          Tickers (API)
        </a>
        <a class="navbar-item" href="https://bulma.io/documentation/modifiers/syntax/">
          Modifiers
        </a>
        <a class="navbar-item" href="https://bulma.io/documentation/columns/basics/">
          Columns
        </a>
        <a class="navbar-item" href="https://bulma.io/documentation/layout/container/">
          Layout
        </a>
        <a class="navbar-item" href="https://bulma.io/documentation/form/general/">
          Form
        </a>
        <hr class="navbar-divider">
        <a class="navbar-item" href="https://bulma.io/documentation/elements/box/">
          Elements
        </a>
        <a class="navbar-item is-active" href="https://bulma.io/documentation/components/breadcrumb/">
          Components
        </a>
      </div>
      
    </div>
    -->
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
<!--
  <div class="navbar-end">
    <div class="navbar-item">
      <div class="field is-grouped">
        <p class="control">
          <a class="bd-tw-button button" data-social-network="Twitter" data-social-action="tweet" data-social-target="http://localhost:4000" target="_blank" href="https://twitter.com/intent/tweet?text=Bulma: a modern CSS framework based on Flexbox&amp;hashtags=bulmaio&amp;url=http://localhost:4000&amp;via=jgthms">
            <span class="icon">
              <i class="fa fa-twitter"></i>
            </span>
            <span>
              Tweet
            </span>
          </a>
        </p>
        <p class="control">
          <a class="button is-primary" href="https://github.com/jgthms/bulma/archive/0.5.1.zip">
            <span class="icon">
              <i class="fa fa-download"></i>
            </span>
            <span>Download</span>
          </a>
        </p>
      </div>
    </div>
  </div>
  -->
</div>

</nav>