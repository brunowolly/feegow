import { useApi } from "src/composables/UseApi";

export default function howDidYouMeetUsService() {
  const { listHow, post, getById } = useApi("how-did-you-meet-us");

  return {
    listHow,
  };
}
