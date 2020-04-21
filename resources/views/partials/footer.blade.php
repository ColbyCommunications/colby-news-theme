<!-- <footer class="content-info">
  <div class="container">
    @php dynamic_sidebar('sidebar-footer') @endphp
  </div>
</footer> -->

<footer style="background-color: #353535; min-height: 200px; margin-top:3rem; color: #fff;" class="d-flex">
  <div class="container d-flex align-items-center justify-content-between">
    <div><img src="{{ \App\asset_path('images/COLBY_logotype_white.png') }}" /></div>
    <div class="in-the-news-footer-menu">@if (has_nav_menu('footer_navigation'))

      {!! wp_nav_menu(['theme_location' => 'footer_navigation', 'container'=> false, 'menu_class' => 'navbar-nav ml-auto']) !!}
    @endif
  </div>
</footer>
