					
					<v-row class="d-flex justify-center align-center">
						<v-col class="lesson d-flex justify-center p-0" cols="11" md="10">
							<h2 class="my-2 text-center"><?php echo $data['lesson']['lesson_name'] ?></h2>
						</v-col>
						<v-col class="p-0 mt-6 mt-md-12 d-flex justify-center" cols="12" md="3">
							<v-img src="<?php echo SITE_URL ?>/img/building.svg" max-width="70vw"></v-img>
						</v-col>
						<v-col cols="11" md="10" class="mt-6 mb-6 mb-md-12 mt-md-12">
						<?php if ($lesson['lesson_type'] == 2): ?>
							<h2 class="text-center">Este quiz se encuentra actualmente en desarrollo, se te notificará tan pronto esté disponible</h2>
						<?php else: ?>
							<h2 class="text-center">Esta lección se encuentra actualmente en desarrollo, vuelve más tarde</h2>
						<?php endif ?>
						</v-col>
					</v-row>