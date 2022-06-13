import { useQuasar } from 'quasar'

export default function myNotifications (text) {
  const $q = useQuasar()

  const showNotify = async (text, typeNotification) => {
    $q.notify({
      type: typeNotification,
      message: text,
      position: 'bottom-right',
      timeout: 100
    })
  }

  return {
    showNotify

  }
}
