				<v-row class="course_news gradient pt-12 pb-12 pl-16 pr-10">
					<v-col class="pl-10" cols="12">
						<h1 class="white--text text-h2">Lista de cursos</h1>
					</v-col>
				</v-row>	
				<v-row class="pl-6 pt-6">
					<?= new Controller\Template('courses/parts/sidebar', $data['categories']) ?>
					<v-col cols="12" md="10">
						<?= new Controller\Template('courses/parts/recommended_courses', $data['courses']) ?>
						<?php /*echo new Controller\Template('courses/parts/endorsed_courses')*/ ?>
						<?php /*echo new Controller\Template('courses/parts/other_courses')*/ ?>
					</v-col>
				</v-row>			