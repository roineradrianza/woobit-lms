<v-row>
    <v-col cols="12">
        <v-list-item class="px-0" two-line>
            <v-list-item-content>
                <v-list-item-title class="no-white-space">Experiența</v-list-item-title>
                <v-list-item-subtitle class="no-white-space">
                    enumeră aici tot ce găsești relevant în cariera ta personală și profesională
                    care te face un bun candidat în lucrul cu copiii și în a preda o materie
                    anume.
                    Experiența în
                    domeniul non profit, experiența internațională, hobby-uri, cărți și
                    materiale
                    publicate, etc.
                </v-list-item-subtitle>
            </v-list-item-content>
        </v-list-item>
    </v-col>


    <v-col cols="12">
        <v-row>
            <?= new Controller\Template('become-teacher/partials/experience/work') ?>
        </v-row>
    </v-col>

    <v-col cls="12">
        <v-divider></v-divider>
    </v-col>

    <v-col cols="12">
        <v-row>
            <?= new Controller\Template('become-teacher/partials/experience/volunteer') ?>
        </v-row>
    </v-col>

    <v-col cls="12">
        <v-divider></v-divider>
    </v-col>

    <v-col cols="12">
        <v-row>
            <?= new Controller\Template('become-teacher/partials/experience/projects') ?>
        </v-row>
    </v-col>

    <v-col cls="12">
        <v-divider></v-divider>
    </v-col>

    <v-col cols="12">
        <v-row>
            <?= new Controller\Template('become-teacher/partials/experience/books') ?>
        </v-row>
    </v-col>

</v-row>