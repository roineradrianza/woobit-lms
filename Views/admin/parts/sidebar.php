							 
			  <v-navigation-drawer class="sidebar" v-model="drawer" app>
			    <v-list dense>
			      <v-subheader class="subtitle-1 white--text">Dashboard</v-subheader>
			      <v-list-item-group v-model="selectedItem" color="primary">
			      	<?php foreach ($data['tabs'] as $i => $tab): ?>
				        <v-list-item key="<?= $i ?>" href="<?= SITE_URL . '/admin/'. $tab['url'] ?>" link>
				          <v-list-item-icon>
				            <v-icon class="white--text"><?= $tab['icon'] ?></v-icon>
				          </v-list-item-icon>
				          <v-list-item-content>
				            <v-list-item-title class="white--text"><?= $tab['name'] ?></v-list-item-title>
				          </v-list-item-content>
				        </v-list-item>
			      	<?php endforeach ?>
			      </v-list-item-group>
			    </v-list>
			  </v-navigation-drawer>