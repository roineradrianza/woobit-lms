
					<v-col class="mb-12 border-right"  cols="12" md="2">
						<h3 class="text-h4">Categorii</h3>
						<?php foreach ($data as $category): ?>
						<?php if (!empty($category['courses'])): ?>

						<v-list-item class="pl-0" href="<?= SITE_URL . "/categorie/{$category['category_id']}" ?>">
					      <v-list-item-content>
					        <v-list-item-title class="grey--text text--darkten-1 text-h5 no-white-space"><?= $category['name'] ?></v-list-item-title>
					      </v-list-item-content>
					    </v-list-item>

						<?php endif ?>
						<?php endforeach ?>
					</v-col>