<template class="elevation-5">
  <v-card
    class="mx-auto text-center"
    color="primary"
    dark
  >
    <v-card-text>
      <v-sheet color="rgba(0, 0, 0, .12)">
        <v-sparkline
          :value="charts.sales"
          color="rgba(255, 255, 255, .7)"
          height="100"
          padding="24"
          stroke-linecap="round"
          smooth
        >
          <template v-slot:label="chart">
            {{ chart.value }}
          </template>
        </v-sparkline>
      </v-sheet>
    </v-card-text>
    <v-card-text>
      <div class="display-1 font-weight-thin">
        <?= $data['chart_title'] ?>
      </div>
    </v-card-text>
    <v-divider></v-divider>

  </v-card>
</template>