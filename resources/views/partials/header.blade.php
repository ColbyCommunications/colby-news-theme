  <nav class="navbar sticky-top navbar-expand-lg navbar-light" style="background-color: #fff; box-shadow: 0 2px 2px -2px rgba(0,0,0,.15);">
  <div class="container"> 
    <a class="navbar-brand" href="https://www.colby.edu">{!! Header::getBrand() !!}</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    @if (has_nav_menu('primary_navigation'))
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'container'=> false, 'menu_class' => 'navbar-nav ml-auto', 'walker' => new \App\wp_bootstrap4_navwalker(), 'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s<div id="search-container">
</div></ul></div>']) !!}
    @endif
    
  </div>
</nav>
