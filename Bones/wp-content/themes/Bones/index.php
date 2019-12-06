<?php get_header();?>
    <main class="indhold">
      <video muted controls class="intro_vid" src="<?php the_field("video_source");?>"></video>
      <section class="intro_text">
<h1><?php the_field("header_text");?> </h1>
<p><?php the_field("info_text");?> </p>
<button class="button_bones">
    <a href="https://www.bones.dk/" target="blank">
        <p><?php the_field("button_text");?></p>
    </a>
    </button>      
      </section>

    </main>

<?php get_footer();?>