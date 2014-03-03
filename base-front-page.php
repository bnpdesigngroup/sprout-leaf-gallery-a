<?php global $sprout; ?>

<?php get_template_part('templates/head'); ?>

<body <?php body_class(); ?>>

  <!--[if lt IE 9]><div class="message alert square align-center" role="alert"><?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'sprout'); ?></div><![endif]-->
  
  <?php $notice = ot_get_option('notice', null); if ($notice): ?>
   
    <div class="message info square align-center fadeInDown"><?php echo $notice ?></div>
  
  <?php endif; ?>

  <?php
    do_action('get_header');
    get_template_part('templates/header');
  ?>

  <div role="document">

    <div id="inner_content" class="container">

    <?php echo do_shortcode(preg_replace('/\[?([^\]]+)\]?/', '[$1]', $sprout->options->get_option('home_gallery_shortcode', ''))); ?>

    </div><!-- /.container -->
  </div><!-- /[role="document"] -->

  <?php get_template_part('templates/footer'); ?>

</body>
</html>
