<?php
/**
 * The template for displaying front page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Austin_Ginder
 */

get_header();
?>
<div id="app">
<v-app v-cloak>
	<div class="blue darken-3">
		<v-layout>
		<v-flex sx12 mt-5 mb-5 style="text-align:center;" dark>
			<v-card color="blue darken-3" dark flat> 
			<img src="<?php bloginfo('stylesheet_directory'); ?>/img/austin-2017-400x400.jpg" width="200"><br />
			<h1>Hello! I'm <strong>Austin Ginder</strong></h1>
			<p>I'm a WordPress developer living in <a href="https://www.meetup.com/WordPress-Lancaster/" target="_new" style="text-decoration: none;"> <v-chip @click color="white" text-color="blue darken-3" class="ma-1"> <v-avatar left> <v-icon>mdi-map-marker</v-icon> </v-avatar>Lancaster, Pennsylvania</v-chip></a>. <br />
			Providing <a href="https://anchor.host" target="_new" style="text-decoration: none;"> <v-chip @click color="white" text-color="blue darken-3" class="ma-1"> <v-avatar left> <v-icon>mdi-anchor</v-icon> </v-avatar>hassle-free WordPress hosting</v-chip></a> for freelancers and web professionals.</p>
			</v-card>
		</v-flex>
		</v-layout>
	</div>
	<v-layout style="max-width:800px; margin: auto;">
		<v-flex sx12>
			<v-timeline dense align-top>
			<template v-for="post in posts">
			<v-timeline-item class="my-4" hide-dot v-if="post.format == 'year'">
				<span class="title">{{ post.title }}</span>
			</v-timeline-item>
			<v-timeline-item small v-else>
			<v-layout wrap>
			<v-flex xs11>
			<v-card class="elevation-2">
				<v-card-title class="headline" v-html="post.title"></v-card-title>
				<v-card-text v-html="post.content"></v-card-text>
			</v-card>
			</v-flex>
			<v-flex xs11 sm1 pa-2 text-xs-right>
				{{ post.created_at }}
			</v-flex>
			</v-layout>
			</v-timeline-item>
			</template>
			</v-timeline>
		</v-flex>
	</v-layout>
	<v-footer color="blue darken-3" padless>
    <v-layout
      justify-center
      row
      wrap
    >
      <v-flex
        py-3
        text-xs-center
        xs12
      >
        <a href="mailto:austinginder@gmail.com" style="text-decoration:none;"><v-icon color="white">mdi-email</v-icon></a>
        <a href="http://twitter.com/austinginder" target="_blank" style="text-decoration:none;"><v-icon color="white">mdi-twitter</v-icon></a>
      </v-flex>
    </v-layout>
  </v-footer>
</v-app>
</div>

<script>
new Vue({
	el: '#app',
	vuetify: new Vuetify(),
	data: {
		posts: <?php echo austinginder_posts(); ?>
	}
})
</script>

<?php get_footer(); ?>