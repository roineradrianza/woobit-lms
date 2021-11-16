				
				<v-row class="px-6 pb-16 d-flex align-center" style="min-height: 83vh">
					<?php echo new Controller\Template('course/parts/resource_content', $data) ?>
					<?php echo new Controller\Template('course/parts/footer', [ 'course' => $data['course'], 'curriculum' => $data['curriculum']]) ?>
				</v-row>