<div class="loader-image">
  <?php 
    $loader_image = gogreen_get_option('page_loader_image');
    if( $loader_image && isset($loader_image['url']) ){
      echo sprintf('<img src="%s" alt="%s" />', esc_url( $loader_image['url'] ), get_bloginfo( 'name' ) );
    }
  ?>
  <div class="loader-box">
      <div class="loader-circle"></div>
      <div class="loader-line-mask">
        <div class="loader-line"></div>
      </div>    
  </div>
</div>