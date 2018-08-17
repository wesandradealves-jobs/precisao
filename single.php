<?php include('_inc/head.php'); ?> 
  <?php include('_inc/header.php'); ?> 
      <main>
        <section class="banner -internal" style="background-image: url(profile/uploads/<?php echo ($sessao_image) ? $sessao_image : ''; ?>)">
          <div class="container">
            <h2>
              <?php 
                echo "<span>".$sessao_titulo."</span>".": ".$single_post_titulo;
              ?>
            </h2>
            <?php include('_inc/components/breadcrumb.php'); ?>
          </div>
        </section>
        <section class="internal-content">
          <div class="container">
            <div class="internal-content-fill">
              <?php echo htmlspecialchars_decode($single_post_text); ?>
            </div>
            <?php include('_inc/sidebar.php'); ?>
          </div>
        </section>
      </main>
<?php include('_inc/footer.php'); ?>