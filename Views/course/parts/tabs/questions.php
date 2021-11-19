                
                <label class="body-1 pl-1">Deja tu pregunta</label>
                <vue-editor id="question_editor" class="mt-3 fl-text-input" v-model="comment" :editor-toolbar="toolbar" placeholder="Redacta tu pregunta acá"></vue-editor>
                <v-btn class="primary white--text my-4" @click="saveComment('question')" :disabled="canPost" :loading="send_comment_loading" block>Publicar</v-btn>
                 <template v-if="recent_questions.length > 0">
                	<v-col cols="12">
                		<h4 class="text-h5 mb-2">Preguntas recién publicadas por ti:</h4>
  				          <v-sheet class="mb-6" elevation="2" rounded class="mx-auto" v-for="item in recent_questions" v-if="item.comment_type == 'question'">
					          	<v-col class="px-4" cols="12">
					          		<v-avatar size="50">
			    								<v-img :src="item.avatar" v-if="null != item.avatar"></v-img>
					          			<v-icon color="primary" size="50px" v-else>mdi-account-circle</v-icon>			          		
					          		</v-avatar>
					          		<span class="primary--text">{{ getFullName(item) }}</span>
					          		<div class="mt-4" v-html="item.comment">
					          		</div>
					          		<v-row class="d-flex align-center">
					          			<v-col class="d-flex justify-start primary--text" cols="6">
					          				{{ fromNow(item.published_at) }}
					          			</v-col>
					          			<v-col class="d-flex justify-end" cols="6">
					          				<template v-if="item.editable">
							          			<v-btn color="primary" @click="item.edit_comment_box = true" text><v-icon>mdi-pencil</v-icon></v-btn>
							          			<v-btn color="red" @click="deleteComment(item)" text><v-icon>mdi-trash-can</v-icon></v-btn>
						          			</template>
					          			</v-col>
					          			<v-row class="px-8">
						          			<v-col cols="12" v-if="item.edit_comment_box == true">
				                			<vue-editor :id="'question_edit_editor' + item.lesson_comment_id" class="mt-3 fl-text-input" v-model="item.edited_comment" :editor-toolbar="toolbar" placeholder="Redacta tu pregunta acá"></vue-editor>
				                				<v-btn class="primary white--text my-4" @click="editComment(item)" :loading="item.edit_comment_loading">Actualizar</v-btn>
				              					<v-btn class="red white--text my-4" @click="item.edit_comment_box = false">Cerrar</v-btn>
						          			</v-col>
						          		</v-row>
					          		</v-row>
					          	</v-col>
					          </v-sheet>              		
                	</v-col>
                </template>
			          <v-sheet class="mb-6" elevation="2" rounded class="mx-auto" v-for="item in comments" v-if="item.comment_type == 'question'">
			          	<v-col class="px-4" cols="12">
			          		<v-avatar size="50">
	    								<v-img :src="item.avatar" v-if="null != item.avatar"></v-img>
			          			<v-icon color="primary" size="50px" v-else>mdi-account-circle</v-icon>
			          		</v-avatar>
			          		<span class="primary--text">{{ getFullName(item) }}</span>
			          		<div class="mt-4" v-html="item.comment">
			          		</div>

			          		<v-row class="d-flex align-center">
			          			<v-col class="d-flex justify-start primary--text" cols="6">
			          				{{ fromNow(item.published_at) }}
			          			</v-col>
			          			<v-col class="d-flex justify-end" cols="6">
				          			<v-btn color="secondary" @click="item.answer_box = true" text><v-icon>mdi-reply</v-icon></v-btn>
				          			<template v-if="item.editable">
					          			<v-btn color="primary" @click="item.edit_comment_box = true" text><v-icon>mdi-pencil</v-icon></v-btn>
					          			<v-btn color="red" @click="deleteComment(item)" text><v-icon>mdi-trash-can</v-icon></v-btn>
				          			</template>
			          			</v-col>
				          		<v-row class="px-8">
				          			<v-col cols="12" v-if="item.edit_comment_box == true">
		                			<vue-editor :id="'question_edit_editor' + item.lesson_comment_id" class="mt-3 fl-text-input" v-model="item.edited_comment" :editor-toolbar="toolbar" placeholder="Redacta tu pregunta acá"></vue-editor>
		                			<v-btn class="primary white--text my-4" @click="editComment(item)" :loading="item.edit_comment_loading">Actualizar</v-btn>
		              				<v-btn class="red white--text my-4" @click="item.edit_comment_box = false">Cerrar</v-btn>
				          			</v-col>

				          			<v-col cols="12" v-if="item.answer_box == true">
		                			<vue-editor :id="'answer_editor' + item.lesson_comment_id" class="mt-3 fl-text-input" v-model="item.answer" :editor-toolbar="toolbar" placeholder="Redacta tu respuesta acá"></vue-editor>
		                			<v-btn class="primary white--text my-4" @click="saveAnswer(item)" :loading="item.answer_loading">Publicar respuesta</v-btn>
	                				<v-btn class="red white--text my-4" @click="item.answer_box = false">Cerrar</v-btn>		                				
				          			</v-col>
												<v-col cols="12">
				          				<v-sheet class="mb-6" elevation="2" rounded class="mx-auto" v-for="answer in item.answers">
								          	<v-col class="px-4" cols="12">
								          		<v-avatar size="50">
								          			<v-img :src="answer.avatar" v-if="null != answer.avatar"></v-img>
								          			<v-icon color="primary" size="50px" v-else>mdi-account-circle</v-icon>
								          		</v-avatar>
								          		<span class="primary--text">{{ getFullName(answer) }}</span>
								          		<div class="mt-4" v-html="answer.comment">
								          		</div>
								          		<v-row class="d-flex align-center">
								          			<v-col class="d-flex justify-start primary--text" cols="6">
								          				{{ fromNow(answer.published_at) }}
								          			</v-col>
								          			<v-col class="d-flex justify-end" cols="6">
								          				<template v-if="answer.editable">
										          			<v-btn color="primary" @click="item.edit_answer_box = true" text><v-icon>mdi-pencil</v-icon></v-btn>
										          			<v-btn color="red" @click="deleteAnswer(answer)" text><v-icon>mdi-trash-can</v-icon></v-btn>
									          			</template>
								          			</v-col>
								          		</v-row>
								          		<v-col cols="12" v-if="item.edit_answer_box == true">
					                			<vue-editor :id="'answer_edit_editor' + item.lesson_comment_id" class="mt-3 fl-text-input" v-model="answer.edited_answer" :editor-toolbar="toolbar" placeholder="Redacta tu respuesta acá"></vue-editor>
					                			<v-btn class="primary white--text my-4" @click="editAnswer(item, answer)" :loading="item.answer_loading">Actualizar respuesta</v-btn>
				                				<v-btn class="red white--text my-4" @click="item.edit_answer_box = false">Cerrar</v-btn>
							          			</v-col>
								          	</v-col>
								          </v-sheet>
				          			</v-col>
				          		</v-row>
			          		</v-row>
			          	</v-col>
			          </v-sheet>
			          