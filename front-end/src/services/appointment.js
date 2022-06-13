import { useApi } from "src/composables/UseApi";

export default function appointmentService() {
  const { list, post } = useApi("/clinica/appointment");

  return {
    list,
    post,
  };
}
