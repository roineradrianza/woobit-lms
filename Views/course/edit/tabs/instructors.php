
						    	<v-row>
                    <v-col cols="12" md="4">
                    	<p class="text-center text-h5">Añadir profesor</p>
                      <label class="body-1 font-weight-thin pl-1">Ingrese el Înregistrare de Utilizator</label>
						          <v-text-field class="fl-text-input" v-model="instructors.username_search" clear-icon="mdi-close-circle" clearable type="text" :loading="instructors.loading" filled rounded dense>
						          	<template v-slot:append-outer>
							          	<div class="fl-append-outer">
							          		<v-btn primary text @click="searchUser">Buscar</v-btn>
							          	</div>
						          	</template>
						          </v-text-field>
						          <template v-if="instructors.searched">
							          <label class="body-1 font-weight-thin pl-1">Seleccione el Utilizator</label>
	                      <v-select class="mt-3 fl-text-input" v-model="instructors.user_selected" :items="instructors.users" item-text="item => item.first_name + ' ' + item.last_name"  :rules="validations.requiredRules" @change="filterSubcategories" :disabled="instructors.add_loading" return-object filled rounded dense>
	                      	<template #item="{item}">
	                      		{{ item.first_name }} {{ item.last_name }}  <span class="secondary--text"> ({{ item.username }})</span>
	                      	</template>	
			                    <template #selection="{ item }">
			                      {{ item.first_name }} {{ item.last_name }} <span class="secondary--text"> ({{ item.username }})</span>
			                    </template>
	                      </v-select>
						          </template >
	                    <v-btn class="primary" v-if="instructors.user_selected != ''" :loading="instructors.add_loading" @click="saveInstructor" block>Añadir Utilizator como profesor</v-btn>
									    <v-col cols="12">
										    <v-alert class="white--text" :type="instructors.alert_type" elevation="2" v-if="instructors.alert">
										      {{ instructors.alert_message }}
										    </v-alert>
									    </v-col>                 	
                    </v-col>
										<!--
						      	<v-col cols="12" md="4" v-for="instructor in instructors.items">
						      		<v-card class="my-12 teacher-card" max-width="15vw" max-width>
										    <v-img width="15vw" height="20vw" class="align-end" :src='instructor.avatar' >
										    	<v-card-title class="d-block font-weight-bold card-teacher-title white--text">
										    			<h4 class="text-h5">{{ instructor.first_name }} {{ instructor.last_name }}</h4>
										    			<h5 class="font-weight-light">Profesor</h5>
										    			<v-btn class="teacher-button-card py-2 px-6 rounded-pill white--text" @click="removeInstructor(instructor)"><v-icon class="red--text mr-2">Remover</v-btn>
										    	</v-card-title>
										    </v-img>
										  </v-card>
						      	</v-col>
						      	-->
                    <v-col class="d-flex" cols="12" md="4" v-for="instructor in instructors.items">
                    	<v-row class="d-flex justify-center">
                    		<v-card class="flex-grow-1 course-teacher-card gradient"  elevation="10">
	                    		<v-col class="d-flex justify-center" cols="12">
				                    <v-avatar color="white" width="100" height="100">
												      <img :src="instructor.avatar" v-if="null !== instructor.avatar">
												      <v-icon color="primary" size="100px" v-else>mdi-account-circle</v-icon>
												    </v-avatar>                   			
	                    		</v-col>
	                    		<v-col class="mb-n6" cols="12">
										    		<p class="text-h5 text-center white--text">{{ instructor.first_name }} {{ instructor.last_name }}</p>
	                    		</v-col>
	                    		<v-card-actions class="d-flex justify-center">
											      <v-btn color="red" text @click="removeInstructor(instructor)" center>Remover</v-btn>
											    </v-card-actions>
                    		</v-card>
                    	</v-row>
                    </v-col>
						    	</v-row>
						    	