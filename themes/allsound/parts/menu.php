<?php
$dir = get_template_directory_uri();
$menu_icon = $dir . '/dist/img/bars-regular.svg'; ?>

<nav id="menu-container" class="menu-ferme">

    <img src="<?= $menu_icon ?>">
    <ul>
        <li <?php if ($_SERVER['REQUEST_URI'] == '/') {
                echo 'class="lien-actif"';
            } ?>>
            <a href="/">Nos podcasts </a><span>. </span>
        </li>

        <li <?php if ($_SERVER['REQUEST_URI'] == '/category/nos-productions') {
                echo 'class="lien-actif"';
            } ?>>
            <a href="/category/nos-productions">Nos productions </a><span>. </span>
        </li>
        <li <?php if ($_SERVER['REQUEST_URI'] == '/about') {
                echo 'class="lien-actif"';
            } ?>>
            <a href="/about">About </a><span>. </span></h2>
        <li <?php if ($_SERVER['REQUEST_URI'] == '/contact') {
                echo 'class="lien-actif"';
            } ?>>
        <a href="/contact">Contact</a></li>
    </ul>

</nav>