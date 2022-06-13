<template>
  <q-page padding>
    <q-table
      title="Agendamentos"
      :rows="appointments"
      :columns="columns"
      row-key="name"
    >
    </q-table>
  </q-page>
</template>

<script>
import { defineComponent, ref, onMounted } from "vue";
import appointmentsService from "src/services/appointment";
import { useQuasar } from "quasar";

export default defineComponent({
  name: "AppointmentsPage",
  setup() {
    const appointments = ref([]);
    const { list } = appointmentsService();
    const columns = [
      { name: "id", field: "id", label: "ID", align: "left", sortable: true },
      {
        name: "specialty_id",
        field: "specialty_id",
        label: "specialty_id",
        align: "right",
        sortable: true,
      },
      {
        name: "professional_id",
        field: "professional_id",
        label: "professional_id",
        align: "right",
        sortable: true,
      },
      {
        name: "name",
        field: "name",
        label: "Nome",
        align: "left",
        sortable: true,
      },
      {
        name: "cpf",
        field: "cpf",
        label: "CPF",
        align: "left",
        sortable: true,
      },
      {
        name: "source_id",
        field: "source_id",
        label: "source_id",
        align: "left",
        sortable: true,
      },
      {
        name: "birthdate",
        field: "birthdate",
        label: "Aniversário",
        align: "left",
        sortable: true,
      },
      {
        name: "date_time",
        field: "date_time",
        label: "date_time",
        align: "left",
        sortable: true,
      },
    ];
    const $q = useQuasar();

    onMounted(() => {
      getAppointments();
    });
    const getAppointments = async () => {
      try {
        const { data } = await list();
        appointments.value = data.content;
      } catch (error) {
        console.log(error);
      }
    };

    return {
      appointments,
      columns,
    };
  },
});
</script>
