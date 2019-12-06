<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Lobster+Two&display=swap" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab&display=swap" rel="stylesheet"> 
  <title>bones-fejrer-familien</title>
    <?php wp_head();?>
  <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-153864952-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-153864952-1');
</script>

</head>
<body>
    <aside class="splash">
<img class="splash_logo" src="<?php the_field('splash_img'); ?>" alt="Bones logo">
    </aside>
    <header>
       <img class="logo" src="<?php the_field('logo_source'); ?>" alt="Bones logo">
         <label class="switch"   >
            <input type="checkbox">
            <span class="slider round" id="darklight"></span>
          </label>
        <script src="./JS/darkmode.js"></script>
    </header>