    
    <v-row>

      <v-col cols="12" md="6">
        <label class="body-1 font-weight-thin pl-1">Activo</label>
        <v-select class="mt-3 fl-text-input pt-select" v-model="lessons.item.meta.lesson_active" :items="[{text: 'Sí', value: '1'}, {text: 'No', value: '0'}]" item-text="text" item-value="value" filled rounded dense></v-select>
      </v-col>

      <v-col cols="12" md="6" v-if="lessons.item.meta.hasOwnProperty('lesson_active') && lessons.item.meta.lesson_active == '1'">
        <label class="body-1 font-weight-thin pl-1">Enviar correo de publicación</label>
        <v-select class="mt-3 fl-text-input pt-select" v-model="lessons.item.meta.send_publish_email" :items="[{text: 'Sí', value: '1'}, {text: 'No', value: '0'}]" item-text="text" item-value="value" filled rounded dense></v-select>
      </v-col>

      <v-col cols="12" md="6">
        <label class="body-1 font-weight-thin pl-1">Duración del Quiz</label>
        <v-text-field type="number" class="mt-3 fl-text-input" v-model="lessons.item.meta.quiz_duration" placeholder="Ingrese la duración en min" hint="Ej: 60 minutos" suffix="minutos" filled rounded dense></v-text-field>
      </v-col>

      <v-col cols="12" md="6">
        <label class="body-1 font-weight-thin pl-1">Puede repetirse</label>
        <v-select class="mt-3 fl-text-input pt-select" v-model="lessons.item.meta.can_repeat_quiz" :items="[{text: 'Sí', value: '1'}, {text: 'No', value: '0'}]" item-text="text" item-value="value" filled rounded dense></v-select>
      </v-col>

      <v-col cols="12" md="6">
        <label class="body-1 font-weight-thin pl-1">Puntuaje máximo</label>
        <v-text-field type="number" class="mt-3 fl-text-input" v-model="lessons.item.meta.max_score" placeholder="Ingrese el puntuaje máximo alcanzado" hint="Ej: 100" suffix="Puntos" filled rounded dense></v-text-field>
      </v-col>

      <v-col cols="12" md="6">
        <label class="body-1 font-weight-thin pl-1">Puntuación aprobatoria</label>
        <v-text-field type="number" class="mt-3 fl-text-input" v-model="lessons.item.meta.min_score" placeholder="Ingrese la puntuación aprobatoria" hint="Ej: 50" suffix="Puntos" filled rounded dense></v-text-field>
      </v-col>

      <v-col cols="12">
        <label class="body-1 font-weight-thin pl-1">Descriere</label>
        <vue-editor id="lesson_editor" class="mt-3 fl-text-input" v-model="lessons.item.meta.description" placeholder="Descriere del curso" />
      </v-col>

      <v-col cols="12">
        <h2 class="text-h4 text-center">Preguntas</h2>
        <br>
        <v-row>
          <v-col cols="12">
            <v-expansion-panels>
              <v-expansion-panel v-for="(quiz, quiz_index) in lessons.item.quizzes" :key="quiz.question_id">
                <v-expansion-panel-header @keyup.space.prevent>
                  <v-row class="d-flex justify-end align-center" no-gutters>
                    <v-col class="d-flex justify-start p-0" cols="9">
                      <v-row>
                        <v-col cols="7" md="3">
                          <v-select class="v-normal-input" v-model="quiz.question_type" label="Tipo de pregunta" :items="lessons.quiz_options" item-text="text" item-value="value" @change="quiz.old_question_name += ' ';checkQuizType(quiz)" @click.native.stop dense></v-select>
                        </v-col>

                        <v-col cols="2" md="1">
                          <v-text-field type="number" class="v-normal-input" v-model="quiz.score" label="Puntuación" @change="quiz.old_question_name += ' '" @click.native.stop dense></v-text-field>
                        </v-col>
                      </v-row>
                    </v-col>
                    <v-col class="d-flex justify-end p-0" cols="3">
                      <v-btn-toggle group>
                        <v-btn class="primary--text" v-if="!checkQuizNames(quiz)" :loading="curriculum.update_quiz_loading" @click="updateQuestion(quiz)" text>Guardar</v-btn>
                        <v-btn text @click="removeQuiz(quiz, quiz_index)">
                          <v-icon color="red" >mdi-delete</v-icon>
                        </v-btn>
                      </v-btn-toggle>
                    </v-col>
                    <v-col cols="12">
                      <v-text-field v-model="quiz.question_name" class="mt-3 fl-text-input" placeholder="Pregunta" @click.native.stop="" :disabled="curriculum.add_quiz_loading" filled rounded dense></v-text-field>
                    </v-col>
                  </v-row>
                </v-expansion-panel-header>
                <v-expansion-panel-content>
                  <template v-if="quiz.question_type == '1' || quiz.question_type == '2'">
                    <v-col class="d-flex justify-center" cols="12" v-if="quiz.question_type == '1'">
                      <v-btn class="secondary white--text" @click="addQuestionAnswer(quiz)">Agregar respuesta</v-btn>
                    </v-col>
                    <v-col cols="12">
                      <v-row class="d-flex justify-center align-center" v-for="(answer, answer_index) in quiz.question_answers">
                        <v-col class="p-0" cols="4">
                          <v-text-field class="v-normal-input" v-model="answer.answer" label="Respuesta" :disabled="quiz.question_type == '2'" @change="quiz.old_question_name += ' '" dense></v-text-field>
                        </v-col>
                        <v-col class="p-0 d-flex justify-end" cols="1" v-if="quiz.question_type != '2'">
                          <v-btn color="error" @click="removeQuestionAnswer(quiz, answer_index)" text><v-icon>mdi-trash-can</v-icon></v-btn>
                        </v-col>
                        <v-col class="p-0 d-flex justify-start" cols="2">
                          <v-radio-group v-model="quiz.correct_answer">
                            <v-radio label="Correcta" :value="answer.answer" @click="quiz.old_question_name += ' '"></v-radio>
                          </v-radio-group>
                        </v-col>
                      </v-row>
                    </v-col>
                  </template>
                  <template v-if="quiz.question_type == '3'">
                    <v-col class="p-0" cols="12">
                      <v-textarea class="v-normal-input" v-model="quiz.question_answers[0].answer" :disabled="quiz.question_type == '2'" @change="quiz.old_question_name += ' ';matchWords(quiz.question_answers[0])" @keydown="matchWords(quiz.question_answers[0])" @input="matchWords(quiz.question_answers[0])" outlined></v-textarea>
                      <p class="body-1"><v-icon color="primary">mdi-information</v-icon> Para separar cada palabra a rellenar, debe encerrar cada una entre <b>[]</b>.</p>
                      <p class="body-1"><span class="font-weight-bold">Ejemplo</span>: El vídeo proporciona una <span class="font-weight-bold">[manera]</span> eficaz para ayudarle a demostrar el punto. Cuando haga clic en Vídeo en línea, puede pegar el <span class="font-weight-bold">[código]</span> para insertar del vídeo que desea agregar. También puede escribir una <span class="font-weight-bold">[palabra]</span> clave para buscar en línea el vídeo que mejor se adapte a su documento.</p>
                    </v-col>
                  </template>

                </v-expansion-panel-content>
              </v-expansion-panel>
            </v-expansion-panels>
          </v-col>
          <v-col cols="12">
            <v-divider></v-divider>
          </v-col>
          <v-col cols="12">
            <v-col class="d-flex justify-center" cols="12">
              <v-btn class="secondary white--text" @click="addQuestion()" :loading="curriculum.add_quiz_loading">Agregar pregunta</v-btn>
            </v-col>
          </v-col>
        </v-row>
      </v-col>

     <?= new Controller\Template('components/alert') ?>

    </v-row>
    