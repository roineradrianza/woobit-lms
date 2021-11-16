					
					<v-col class="lesson" cols="12">
						<v-row>
							<v-col cols="12">
								<v-row class="d-flex justify-center">
									<v-col cols="12" md="8" v-html="meta.description">	
									</v-col>
								</v-row>
							</v-col>
							<v-row class="d-flex justify-center" v-if="resources.length > 0">
								<v-col cols="12" md="8">
									<h3 class="text-h4">Recursos</h3>
								</v-col>
								<v-col cols="12" md="8">
									<v-divider></v-divider>
								</v-col>
								<v-col cols="12" md="8" >
									<v-row>
										<template v-for="resource in resources">
											<v-col cols="12" md="6">
											  <v-card class="mx-auto outlined">
											    <v-list-item three-line>
											      <v-list-item-content>
											        <v-list-item-title class="headline mb-1 no-white-space">
											          {{ resource.name }}
											        </v-list-item-title>
											      </v-list-item-content>

											      <v-list-item-avatar size="80" color="primary">
											      	<v-icon color="white" x-large>mdi-file-{{ getExtIcon(resource.url) }}</v-icon>
											      	<br>
											      </v-list-item-avatar>
											    </v-list-item>

											    <v-card-actions>
											    	<v-row>
									            <template v-if="resource.percent_loading_active">
									              <v-col class="p-0 mb-n6" cols="12">
									                <p class="text-center" v-if="resource.percent_loading < 100">Descargando recurso</p>
									                <p class="text-center" v-else>Descarga completada, espere un momento...</p>
									              </v-col>
									              <v-col class="p-0" cols="12">
									                <v-progress-linear :active="resource.percent_loading_active" :value="resource.percent_loading" height="15" dark>
									                	<template v-slot:default="{ value }">
															        <strong>{{ Math.ceil(value) }}%</strong>
															      </template>
									                </v-progress-linear>
									              </v-col>
									            </template>
									            <v-col class="d-flex justify-center" cols="12">
													      <v-btn color="primary" @click="saveFile(resource.url, resource)" outlined rounded text>
													        Descargar
													      </v-btn>
									            </v-col>
											    	</v-row>
											    </v-card-actions>
											  </v-card>
											</v-col>
										</template>
									</v-row>
								</v-col>
							</v-row>
						</v-row>
					</v-col>