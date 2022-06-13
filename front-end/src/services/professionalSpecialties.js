import { useApi } from "src/composables/UseApi";

export default function professionalspecialtiesService() {
  const { list, post, update, remove, getById } = useApi(
    "professional/specialtiy"
  );

  return {
    list,
    post,
    getById,
  };
}
