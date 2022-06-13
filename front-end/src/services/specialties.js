import { useApi } from "src/composables/UseApi";

export default function specialtiesService() {
  const { list, post, update, remove, getById } = useApi("specialtiy");

  return {
    list,
    post,
    getById,
  };
}
