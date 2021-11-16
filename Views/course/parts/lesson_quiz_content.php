<v-row class="d-flex justify-center align-center quiz_container mt-6">
    <v-col class="lesson" cols="11" md="9">
        <h2 class="my-2 text-center"><?php echo $data['lesson']['lesson_name'] ?></h2>
        <v-col cols="12" :v-html="meta.description" v-if="meta.description != ''">
        </v-col>
        <template v-if="loading">
            <v-skeleton-loader class="full-height" width="100%" type="article" v-for="i in 5"></v-skeleton-loader>
        </template>
        <template v-else>
            <template v-if="!quiz_finished">
                <v-row class="d-flex justify-center">
                    <v-col class="d-flex justify-end" cols="6">
                        <p color="success">Puntuación Mínima: {{ meta.min_score }}</p>
                    </v-col>
                    <v-col class="d-flex justify-start" cols="6">
                        <p color="success">Puntuación Máxima: {{ meta.max_score }}</p>
                    </v-col>
                </v-row>
                <v-col class="d-flex justify-center mb-n4" cols="12">
                    <countdown tag="div" :time="quiz_countdown" :transform="transformSlotProps"
                        v-slot="{ days, hours, minutes, seconds }" @end="saveQuiz(false)" ref="countdown_component1"
                        :auto-start="counting">
                        <v-row class="d-flex justify-center" ref="countdown">
                            <v-col cols="12">
                                <h2 class="text-h6 text-md-h5 text-center">
                                    <template v-if="quiz_started">
                                        Tiempo restante:
                                    </template>
                                    <template v-else>
                                        Duración:
                                    </template>
                                </h2>
                            </v-col>
                            <v-col cols="4">
                                <p class="text-h4 text-md-h2 secondary--text text-center">{{ hours }} <br><span
                                        class="text-h6 text-md-h5 text-center mt-n6 d-md-inline">horas</span></p>
                            </v-col>
                            <v-col cols="4">
                                <p class="text-h4 text-md-h2 secondary--text text-center">{{ minutes }} <br><span
                                        class="text-h6 text-md-h5 text-center mt-n6 d-md-inline">minutos</span></p>
                            </v-col>
                            <v-col cols="4" class="pl-md-6">
                                <p class="text-h4 text-md-h2 secondary--text text-center"> {{ seconds }} <br><span
                                        class="text-h6 text-md-h5 text-center mt-n6 d-md-inline">segundos</span></p>
                            </v-col>
                        </v-row>
                    </countdown>
                </v-col>
                <v-col class="justify-center mb-n4 quiz-countdown d-none" cols="12" ref="countdown_row">
                    <countdown tag="div" :time="quiz_countdown" :transform="transformSlotProps"
                        v-slot="{ days, hours, minutes, seconds }" @end="saveQuiz(false)" ref="countdown_component2"
                        :auto-start="counting">
                        <v-row class="d-flex justify-center">
                            <v-col cols="12">
                                <h2 class="text-h6 text-md-h5 text-center">
                                    <template v-if="quiz_started">
                                        Tiempo restante:
                                    </template>
                                    <template v-else>
                                        Duración:
                                    </template>
                                </h2>
                            </v-col>
                            <v-col cols="4">
                                <p class="text-h4 text-md-h2 secondary--text text-center">{{ hours }} <br><span
                                        class="text-h6 text-md-h5 text-center mt-n6 d-md-inline">horas</span></p>
                            </v-col>
                            <v-col cols="4">
                                <p class="text-h4 text-md-h2 secondary--text text-center">{{ minutes }} <br><span
                                        class="text-h6 text-md-h5 text-center mt-n6 d-md-inline">minutos</span></p>
                            </v-col>
                            <v-col cols="4" class="pl-md-6">
                                <p class="text-h4 text-md-h2 secondary--text text-center"> {{ seconds }} <br><span
                                        class="text-h6 text-md-h5 text-center mt-n6 d-md-inline">segundos</span></p>
                            </v-col>
                        </v-row>
                    </countdown>
                </v-col>

                <v-col class="d-flex justify-center pl-4" cols="12">
                    <v-btn color="secondary" light v-if="!quiz_started" @click="quiz_started = true;">Iniciar Quiz
                    </v-btn>
                </v-col>
                <v-form ref="quiz_form">
                    <v-row ref="quiz_container" v-if="quiz_started">
                        <v-col cols="12" v-for="question in quiz" :key="question.question_id">
                            <v-card>
                                <v-row class="px-6">
                                    <v-col class="d-flex justify-center mb-n6" cols="12"
                                        v-if="question.question_type == '3'">
                                        <v-alert border="top" colored-border type="info" elevation="2">Recuerda ingresar
                                            la/s palabra/s sin espacios adicionales
                                        </v-alert>
                                    </v-col>
                                    <v-col cols="12">
                                        <h3>{{ question.question_name }}</h3>
                                    </v-col>
                                    <v-col class="p-0" cols="12">
                                        <template v-if="question.question_type == '1' || question.question_type == '2'">
                                            <v-radio-group class="pt-0" v-model="question.correct_answer"
                                                v-for="(answer, answer_index) in question.question_answers"
                                                :key="answer_index" :disabled="send_quiz_loading || quiz_finished">
                                                <v-radio class="v-normal-input" :label="answer.answer"
                                                    :value="answer.answer"></v-radio>
                                            </v-radio-group>
                                        </template>
                                        <template v-if="question.question_type == '3'">
                                            <div v-html="question.question_answers[0].answer">

                                            </div>
                                            {{ replaceMissingWords(question.question_answers[0], question) }}
                                            <v-row>
                                                <v-col cols="6" md="4"
                                                    v-for="(word, i) in question.question_answers[0].missing_words"
                                                    :key="i">
                                                    <label for="">
                                                        <v-badge :content="i + 1"></v-badge>
                                                    </label>
                                                    <v-text-field v-model="question.correct_answer[i]" outlined dense>
                                                    </v-text-field>
                                                </v-col>
                                            </v-row>
                                        </template>
                                    </v-col>
                                </v-row>
                            </v-card>
                        </v-col>
                    </v-row>
                    <v-col class="d-flex justify-center pl-4" cols="12">
                        <v-btn color="primary" v-if="quiz_started && !quiz_finished" :loading="send_quiz_loading"
                            :disabled="quiz_finished" @click="saveQuiz()" light>Finalizar quiz</v-btn>
                    </v-col>
                    <?php echo new Controller\Template('components/alert') ?>
                </v-form>
            </template>
            <template v-if="quiz_finished && attempt_results.hasOwnProperty('score')">
                <v-row class="d-flex justify-center">
                    <v-col class="d-flex justify-center" cols="12" v-if="parseInt(meta.can_repeat_quiz)">
                        <v-btn color="primary"
                            @click="quiz_started = false;quiz_finished = false;attempt_results = [];">
                            Intentar de nuevo
                        </v-btn>
                    </v-col>
                    <v-col class="d-flex justify-center" cols="6" md="3">
                        <v-chip class="px-8" color="success" v-if="parseInt(attempt_results.score) >= parseInt(meta.min_score)">Aprobado</v-chip>
                        <v-chip class="px-8" color="error" v-else>Fallado</v-chip>
                    </v-col>
                    <v-col class="d-flex justify-center" cols="6" md="3">
                        <p color="success">Puntuación Mínima: {{ meta.min_score }}</p>
                    </v-col>
                    <v-col class="d-flex justify-center" cols="6" md="3">
                        <p color="success">Puntuación Máxima: {{ meta.max_score }}</p>
                    </v-col>
                    <v-col class="d-flex justify-center" cols="6" md="3">
                        <p color="success">Puntuación Obtenida: {{ attempt_results.score }}</p>
                    </v-col>
                </v-row>
                <v-row ref="quiz_result_container">
                    <v-col cols="12" v-for="question in quiz_results" :key="question.question_id">
                        <v-card>
                            <v-row class="px-6">
                                <v-col cols="12">
                                    <h3>{{ question.question_name }}
                                        <template v-if="question.question_type == '1' || question.question_type == '2'">
                                            <v-icon color="success" v-if="parseInt(question.answer_correct)">mdi-check
                                            </v-icon>
                                            <v-icon color="error" v-else>mdi-close</v-icon>
                                        </template>
                                    </h3>
                                    <template v-if="question.question_type == '1' || question.question_type == '2'">
                                        <template v-if="!parseInt(question.answer_correct)">
                                            <h4 class="mt-2">Respuesta correcta: <b class="secondary--text">
                                                    {{ question.question_correct_answer }} </b></h4>
                                        </template>
                                    </template>
                                </v-col>
                                <v-col class="p-0" cols="12">
                                    <template v-if="question.question_type == '1' || question.question_type == '2'">
                                        <v-radio-group class="pt-0" v-model="question.correct_answer"
                                            v-for="(answer, answer_index) in question.question_answers"
                                            :key="answer_index" :disabled="send_quiz_loading || quiz_finished">
                                            <v-radio class="v-normal-input" :label="answer.answer"
                                                :value="answer.answer"></v-radio>
                                        </v-radio-group>
                                    </template>
                                    <template v-if="question.question_type == '3'">

                                        <div v-html="question.question_answers[0].answer">

                                        </div>
                                        {{ replaceMissingWordsReview(question.question_answers[0], question) }}
                                        {{ parseAnswers(question) }}
                                        <v-row>
                                            <v-col cols="6" md="2"
                                                v-for="(word, i) in question.question_answers[0].missing_words"
                                                :key="i">
                                                <v-badge class="pr-1 mr-4" :content="i + 1"></v-badge>
                                                {{ getWords(word, question, i) }}
                                                <v-icon color="success" v-if="checkWords(word, question, i)">
                                                    mdi-check
                                                </v-icon>
                                                <template v-else>
                                                    <v-icon color="error">
                                                        mdi-close
                                                    </v-icon>
                                                    <p class="font-weight-bold">Correcto: <span
                                                            class="font-weight-light"> {{ word }}</span></p>

                                                </template>

                                            </v-col>

                                        </v-row>
                                    </template>
                                </v-col>
                            </v-row>
                        </v-card>
                    </v-col>
                </v-row>
            </template>
        </template>
    </v-col>
</v-row>