<?php
/**
 * Template Name: Homepage
 */
$context = Timber::get_context();
$context['post'] = Timber::get_post();
Timber::render(['homepage.twig'], $context);
