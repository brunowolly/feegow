<template>
  <q-page padding>
    <div class="q-pa-md">
      <div class="row q-col-gutter-none">
        <div class="flex flex-center">Consulta de</div>
        &nbsp;
        <div class="col-3">
          <q-select
            filled
            v-model="model"
            :options="options"
            option-label="nome"
            option-value="especialidade_id"
            label="Selecione a especialidade"
            @update:model-value="(val) => showChannel(val)"
          >
            <template v-slot:no-option>
              <q-item>
                <q-item-section class="text-grey"> No results </q-item-section>
              </q-item>
            </template>
          </q-select>
        </div>
      </div>
    </div>
    <div class="q-pa-md" v-if="!isHidden" id="hide">
      <q-table
        grid
        :card-container-class="cardContainerClass"
        title="Profissionais"
        :rows="professionals"
        :columns="columns"
        row-key="nome"
        :filter="filter"
        no-results-label="Não foi possível encontrar profissionais com o termo utilizado"
        hide-header
        v-model:pagination="pagination"
        :rows-per-page-options="rowsPerPageOptions"
      >
        <template v-slot:top-right>
          <q-input
            borderless
            dense
            debounce="300"
            v-model="filter"
            placeholder="Search"
          >
            <template v-slot:append>
              <q-icon name="search" />
            </template>
          </q-input>
        </template>

        <template v-slot:item="props">
          <div class="q-pa-xs col-xs-12 col-sm-6 col-md-4">
            <q-card width="200px;" height="200px">
              <q-card-section class="text-center">
                <q-avatar v-if="props.row.foto">
                  <q-img
                    :src="props.row.foto"
                    spinner-color="white"
                    style="height: 50px; max-width: 50px"
                  ></q-img>
                </q-avatar>
                &nbsp;
                <strong
                  >{{ props.row.tratamento }} &nbsp;{{ props.row.nome }}</strong
                >
                <br />
                <div class="flex flex-center" style="font-size: 12px">
                  <span>
                    {{ props.row.conselho }} &nbsp;
                    {{ props.row.documento_conselho }}</span
                  >
                </div>
                <br />
                <q-btn
                  rounded
                  label="Agendar"
                  color="secondary"
                  size="sm"
                  @click="
                    confirm = true;
                    getHowDidYoutMeetYou();
                    setProfessional(props.row);
                  "
                />
              </q-card-section>
            </q-card>
          </div>
        </template>
      </q-table>
    </div>
    <q-dialog v-model="confirm" class="row q-col-gutter-sm">
      <q-card padding>
        <q-card-section>
          <div class="text-h6">
            Preencha seus dados para agendar consulta com:<br />
            {{ professional.tratamento }} {{ professional.nome }}
          </div>
        </q-card-section>
        <q-card-section class="row items-center">
          <q-form @submit="onSubmit" class="row q-col-gutter-sm">
            <q-input
              v-model="form.name"
              outlined
              label="Nome Completo *"
              class="col-lg-6 col-4-xs"
            />
            <q-select
              filled
              class="col-lg-6 col-4-xs"
              v-model="form.source_id"
              :options="howDidYouMeetUs"
              option-label="nome_origem"
              option-value="origem_id"
              label="Como você nos conheceu?"
              emit-value
              map-options
            >
              <template v-slot:no-option>
                <q-item>
                  <q-item-section class="text-grey">
                    No results
                  </q-item-section>
                </q-item>
              </template>
            </q-select>
            <q-input
              outlined
              v-model="form.birthdate"
              label="Data de Nascimento"
              mask="##/##/####"
              class="col-lg-6 col-4-xs"
            >
              <template v-slot:append>
                <q-icon name="event" class="cursor-pointer">
                  <q-popup-proxy
                    transition-show="scale"
                    transition-hide="scale"
                  >
                  </q-popup-proxy>
                </q-icon>
              </template>
            </q-input>
            <q-input
              outlined
              v-model="form.cpf"
              label="CPF *"
              class="col-lg-6 col-4-xs"
            />
            <div hidden>
              <q-input
                label="Professional id"
                v-model="form.professional_id"
                class="col-lg-6 col-4-xs"
              />
              <q-input
                label="Especialidade id"
                v-model="form.specialty_id"
                class="col-lg-6 col-4-xs"
              />
            </div>
          </q-form>
        </q-card-section>
        <q-card-actions align="right">
          <q-btn
            label="Solicitar Horários"
            color="secondary"
            type="submit"
            @click="onSubmit()"
            v-close-popup
          />
          <q-btn label="Cancelar" color="secondary" v-close-popup />
        </q-card-actions>
      </q-card>
    </q-dialog>
  </q-page>
</template>

<script>
import { defineComponent, ref, onMounted, computed, watch } from "vue";
import specialtiesService from "src/services/specialties";
import howDidYouMeetUsService from "src/services/howDidYouMeetUs";
import professionalSpecialtiesService from "src/services/professionalSpecialties";

import appointmentService from "src/services/appointment";

import { useQuasar } from "quasar";
import myNotifications from "src/composables/notifications";
export default defineComponent({
  name: "IndexPage",

  setup() {
    const { showNotify } = myNotifications();
    let especialidade_id = ref({});
    const form = ref({
      name: "",
      source_id: "",
      birthdate: "",
      cpf: "",
      specialty_id: "",
      professional_id: "",
    });

    let isHidden = ref(true);
    const $q = useQuasar();
    const columns = [
      {
        name: "profissional_id",
        label: "profissional_id",
        field: "profissional_id",
      },
      { name: "nome", label: "Nome", field: "nome" },
      { name: "tratamento", label: "Tratamento", field: "tratamento" },
      {
        name: "documento_conselho",
        label: "Documento",
        field: "documento_conselho",
      },
      {
        name: "foto",
        label: "Foto",
        field: "foto",
      },
      {
        name: "especialidade_id",
        label: "especialidade_id",
        field: "especialidade_id",
      },
    ];

    let professionals = ref([]);
    let options = ref([]);
    let model = ref([]);
    let howDidYouMeetUs = ref([{ "": "" }]);
    let professinalsSpecialized = ref([]);
    let professional = ref([]);

    const { list } = specialtiesService();
    const { listHow } = howDidYouMeetUsService();
    const { getById } = professionalSpecialtiesService();
    const { post } = appointmentService();

    onMounted(() => {
      getSpecialties();
    });
    function getItemsPerPage() {
      if ($q.screen.lt.sm) {
        return 3;
      }
      if ($q.screen.lt.md) {
        return 6;
      }
      return 9;
    }
    const filter = ref("");
    const pagination = ref({
      page: 1,
      rowsPerPage: getItemsPerPage(),
    });
    watch(
      () => $q.screen.name,
      () => {
        pagination.value.rowsPerPage = getItemsPerPage();
      }
    );
    const setProfessional = (professionalRow) => {
      professional.value = professionalRow;
      form.value.professional_id = professionalRow.profissional_id;
      form.value.specialty_id = especialidade_id;
    };
    const getSpecialties = async () => {
      try {
        const { data } = await list();
        options.value = data.content;
      } catch (error) {
        console.log(error);
      }
    };
    const getProfessionalSpecialized = async (id) => {
      try {
        const { data } = await getById(id);
        professinalsSpecialized.value = data.content;
        professionals.value = data.content;
        isHidden.value = false;
        especialidade_id = id;
      } catch (error) {
        console.log(error);
      }
    };
    const showChannel = (speciality) => {
      try {
        getProfessionalSpecialized(speciality.especialidade_id);
      } catch (error) {
        console.log(error);
      }
    };

    const getHowDidYoutMeetYou = async () => {
      try {
        const { data } = await listHow();
        howDidYouMeetUs.value = data.content;
      } catch (error) {
        console.log(error);
      }
    };
    const showNotif = async () => {
      $q.notify({
        type: "positive",
        message: "Agendamento enviado",
        position: "bottom-right",
        timeout: 500,
      });
    };

    const onSubmit = async () => {
      try {
        await post(form.value);
        showNotif();
      } catch (error) {
        showNotify("Action error: " + error.message, "warning");
      }
      form.value = [];
    };

    return {
      model,
      options,
      especialidade_id,
      showChannel,
      professinalsSpecialized,
      columns,
      professionals,
      filter,
      pagination,
      isHidden,
      cardContainerClass: computed(() => {
        return $q.screen.gt.xs
          ? "grid-masonry grid-masonry--" + ($q.screen.gt.sm ? "3" : "2")
          : null;
      }),

      rowsPerPageOptions: computed(() => {
        return $q.screen.gt.xs ? ($q.screen.gt.sm ? [3, 6, 9] : [3, 6]) : [3];
      }),
      confirm: ref(false),
      onSubmit,
      date: "",
      howDidYouMeetUs,
      getHowDidYoutMeetYou,
      setProfessional,
      professional,
      form,
    };
  },
});
</script>
