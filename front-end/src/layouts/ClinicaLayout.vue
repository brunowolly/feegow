<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated>
      <q-toolbar>
        <q-toolbar-title>
          <center>Clínica</center>
        </q-toolbar-title>
      </q-toolbar>
    </q-header>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>
import { defineComponent } from "vue";

// import EssentialLink from 'components/EssentialLink.vue'

export default defineComponent({
  name: "ClinicaLayout",

  components: {},

  setup() {
    return {};
  },
});
</script>
