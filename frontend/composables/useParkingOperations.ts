import { ref } from 'vue'

export const useParkingOperations = () => {
  const showEntryTicket = ref(false)
  const entryTicket = ref({ id: '', plate: '', vehicle: '', time: '' })
  const scanInPlate = ref('')
  const scanInType = ref('Mobil')
  const entryConfirmed = ref('')

  const recentEntries = ref([
    { plate: 'B 1234 XYZ', vehicle: 'Mobil', time: '07:42' },
    { plate: 'B 8890 QWE', vehicle: 'Motor', time: '07:38' },
    { plate: 'B 5567 TYU', vehicle: 'Mobil', time: '07:30' },
  ])

  const processEntry = () => {
    if (!scanInPlate.value) return

    const plate = scanInPlate.value.toUpperCase()
    const ticketId = 'TKT-' + Math.floor(1000 + Math.random() * 9000)

    entryConfirmed.value = plate
    recentEntries.value.unshift({
      plate,
      vehicle: scanInType.value,
      time: 'Baru saja',
    })

    entryTicket.value = {
      id: ticketId,
      plate,
      vehicle: scanInType.value,
      time: 'Baru saja',
    }
    showEntryTicket.value = true
    scanInPlate.value = ''
  }

  const showExitReceipt = ref(false)
  const exitReceipt = ref({ plate: '', duration: '', method: '', fare: 0 })
  const scanOutPlate = ref('')
  const payMethod = ref('Tunai')
  const exitConfirmed = ref('')

  const recentExits = ref([
    { plate: 'B 5678 ABC', vehicle: 'Mobil', duration: '2j 15m', fare: 'Rp 10.000', time: '07:40' },
    { plate: 'B 1122 ZXC', vehicle: 'Motor', duration: '45m', fare: 'Rp 3.000', time: '07:33' },
  ])

  const processExit = () => {
    if (!scanOutPlate.value) return

    const plate = scanOutPlate.value.toUpperCase()
    exitConfirmed.value = plate
    recentExits.value.unshift({
      plate,
      vehicle: 'Mobil',
      duration: '1j 12m',
      fare: 'Rp 8.000',
      time: 'Baru saja',
    })

    exitReceipt.value = {
      plate,
      duration: '1j 12m',
      method: payMethod.value,
      fare: 8000,
    }
    showExitReceipt.value = true
    scanOutPlate.value = ''
  }

  const printTicket = () => {
    window.print()
  }

  return {
    showEntryTicket,
    entryTicket,
    scanInPlate,
    scanInType,
    entryConfirmed,
    recentEntries,
    processEntry,
    showExitReceipt,
    exitReceipt,
    scanOutPlate,
    payMethod,
    exitConfirmed,
    recentExits,
    processExit,
    printTicket,
  }
}
