<v-col cols="12">
	<v-row>
		<v-col class="d-flex justify-start align-center" cols="6">
			<?php if (!empty($data['curriculum']['prev_lesson'])): ?>
			<a href="<?php echo SITE_URL ?>/courses/<?php echo $data['course']['slug'] ?>/<?php echo $data['curriculum']['prev_lesson']['lesson_id'] ?>"><h4 class="text-h5 primary--text"><v-icon color="primary" x-large>mdi-arrow-left</v-icon> <?php echo $data['curriculum']['prev_lesson']['lesson_name'] ?></h4></a>		
			<?php endif ?>
		</v-col>
		<v-col class="d-flex justify-end align-center" cols="6">
			<?php if (!empty($data['curriculum']['next_lesson'])): ?>
			<a href="<?php echo SITE_URL ?>/courses/<?php echo $data['course']['slug'] ?>/<?php echo $data['curriculum']['next_lesson']['lesson_id'] ?>"><h4 class="text-h5 secondary--text"><?php echo $data['curriculum']['next_lesson']['lesson_name'] ?> <v-icon color="secondary" x-large>mdi-arrow-right</v-icon></h4></a>	
			<?php endif ?>
		</v-col>
	</v-row>
</v-col>