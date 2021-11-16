                
                <label class="body-1 pl-1">Deja tu aporte</label>
                <vue-editor id="contributions_editor" class="mt-3 fl-text-input" v-model="comment" :editor-toolbar="toolbar" placeholder="Redacta tu aporte acá"></vue-editor>
                <v-btn class="primary white--text my-4" @click="saveComment('contribution')" :disabled="canPost" :loading="send_comment_loading" block>Publicar</v-btn>
                <template v-if="recent_contributions.length > 0">
                	<v-col cols="12">

                		<h4 class="text-h5 mb-2">Aportes recién publicados por ti:</h4>
  				          <v-sheet class="mb-6" elevation="2" rounded class="mx-auto" v-for="item in recent_contributions" v-if="item.comment_type == 'contribution'">
					          	<v-col class="px-4" cols="12">
					          		<v-avatar size="50">
			    								<v-img :src="item.avatar" v-if="null != item.avatar"></v-img>
					          			<v-icon color="primary" size="50px" v-else>mdi-account-circle</v-icon>			          		
					          		</v-avatar>
					          		<span class="primary--text">{{ getFullName(item) }} <b class="secondary--text">({{ item.username }})</b></span>
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
			          <v-sheet class="mb-6" elevation="2" rounded class="mx-auto" v-for="item in comments" v-if="item.comment_type == 'contribution'">
			          	<v-col class="px-4" cols="12">
			          		<v-avatar size="50">
	    								<v-img :src="item.avatar" v-if="null != item.avatar"></v-img>
			          			<v-icon color="primary" size="50px" v-else>mdi-account-circle</v-icon>			          		
			          		</v-avatar>
			          		<span class="primary--text">{{ getFullName(item) }} <b class="secondary--text">({{ item.username }})</b></span>
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
			          