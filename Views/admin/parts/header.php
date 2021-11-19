								

			  <v-app-bar app>
			    <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
			    <v-col cols="12" class="d-flex justify-end">
				    <v-menu right bottom>
			        <template v-slot:activator="{ on, attrs }">
			          <v-btn icon v-bind="attrs" v-on="on">
			            <v-icon>mdi-dots-vertical</v-icon>
			          </v-btn>
			        </template>
			        <v-list>
			          <v-list-item class="d-flex justify-center">
							    <v-avatar>
							      <img src="<?= $_SESSION['avatar'] ?>" alt="<?= $_SESSION['first_name'] ?>">
							    </v-avatar>
			          </v-list-item>
			          <v-list-item class="mb-n4">
						      <v-list-item-content>
						        <v-list-item-title class="text-center primary--text"><?= $_SESSION['first_name'] . ' ' . $_SESSION['last_name']?></v-list-item-title>
						      </v-list-item-content>
			          </v-list-item>
			         	<v-list-item class="mb-n2" href="<?= SITE_URL ?>">
						      <v-list-item-content>
						        <v-list-item-title class="text-center">Inicio</v-list-item-title>
						      </v-list-item-content>
				    		</v-list-item>
			          <v-list-item class="mb-n2" href="<?= SITE_URL ?>/profile/">
						      <v-list-item-content>
						        <v-list-item-title class="text-center">Perfil</v-list-item-title>
						      </v-list-item-content>
			          </v-list-item>
			          <v-list-item>
			            <v-btn color="red" href="<?php SITE_URL ?>/api/members/logout" text onclick="gapi.auth2.getAuthInstance().signOut()">Cerrar sesión</v-btn>
			          </v-list-item>
			        </v-list>
			      </v-menu>		     	
			    </v-col>
			  </v-app-bar>
			  <?= new Controller\Template('admin/parts/sidebar', Controller\Template::admin_menu_tabs()) ?>